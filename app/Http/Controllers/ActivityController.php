<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Crop;
use App\Models\Machinery;
use App\Models\Plot;
use App\Models\Seed;
use App\Models\Supply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ActivityController extends Controller
{
    public function create(){
        $perm = Auth::user()->getRoleForSelectedFarm();

        if ($perm !== 'admin' && $perm !== 'tecnico' && $perm !== 'operador' && Auth::user()->isOwner !== 1) {
            return view('dashboard');
        }

        $farmId = session('selected_farm_id');

        $plots = Plot::where('farm_id',$farmId)->get();
        $machineries = Machinery::where('farm_id',$farmId)->where('status','true')->get();
        $owner = Auth::user();
        
        // Pega as plantações relacionadas apenas a esses plots (ou diretamente via whereHas)
        $crops = Crop::where('farm_id',$farmId)->get();
        $supplies = Supply::where('farm_id',$farmId)->get();
        $seeds = Seed::where('farm_id',$farmId)->get();
        $activityMachinery = Activity::with('machinery')->get();

        //Pego todas as fazendas do owner atual
        $ownedFarmIds = $owner->ownedFarms()->pluck('id');
        
        //Pego todos os usuários vinculados a essas fazendas (via tabela farm_user), evitando o próprio owner
        $users = User::
                whereHas('farms', function ($query) use ($farmId) {
                    $query->where('farm_id', $farmId);
                })
                ->with(['farms' => function ($query) use ($farmId) {
                    $query->where('farm_id', $farmId);
                }])
                ->get();

        if(!Auth::user()->isOwner){
            $activities = Activity::with('machinery','seed')
            ->where('farm_id', $farmId)
            ->where('user_id',Auth::user()->id)
            ->get();
        }else{
            $activities = Activity::with('machinery','seed')
            ->where('farm_id', $farmId)
            ->get();
        }

        return view('activity.activity',compact('activities','plots','machineries','users','crops','supplies','activityMachinery','seeds'));
    }

    public function store(Request $request){
        $farmId = session('selected_farm_id');
        
        $request->validate([
        'name' => ['required', 'string', 'max:255',
        Rule::unique('activities', 'name')
        ->where(function ($query) use ($farmId) {
            return $query->where('farm_id', $farmId);
        })],
        'type' => ['required', 'string'],
        'crop_id' => ['required', 'exists:crops,id'],
        'plot_id' => ['required', 'exists:plots,id'],
        'supply_id' => ['nullable', 'exists:supplies,id'],
        'seed_id' => ['nullable', 'exists:seeds,id'],
        'user_id' => ['required', 'exists:users,id'],
        'startDate' => ['required', 'date'],
        'finishDate' => ['nullable', 'date', 'after_or_equal:startDate'],
        'dieselValue' => ['required', 'min:0'],
        'supplyEstimatedValue' => ['required', 'min:0'],
        'machinery_id_1' => ['nullable', 'exists:machinery,id'],
        'machinery_dieselConsumption_1' => ['required', 'min:0'],
        'machinery_id_2' => ['nullable', 'exists:machinery,id'],
    ], [
        'name.required' => 'O nome da atividade é obrigatório.',
        'name.unique' => 'O nome da atividade já existe.',
        'type.required' => 'O tipo da atividade é obrigatório.',
        'crop_id.required' => 'A cultura é obrigatória.',
        'plot_id.required' => 'O talhão é obrigatório.',
        'user_id.required' => 'O responsável pela atividade é obrigatório.',
        'startDate.required' => 'A data de início é obrigatória.',
        'startDate.date' => 'Data de início inválida.',
        'finishDate.date' => 'Data de término inválida.',
        'finishDate.after_or_equal' => 'A data de término deve ser igual ou posterior à de início.',
        'dieselValue.regex' => 'Valor do diesel inválido.',
        'supplyEstimatedValue.regex' => 'Valor estimado do insumo inválido.',
    ]);

        $dieselValue = $this->formataValor($request->dieselValue);
        $estimatedValue = $this->formataValor($request->supplyEstimatedValue);

        $activities = Activity::create([
            'name' => $request->name,
            'type' => $request->type,
            'crop_id' => $request->crop_id,
            'plot_id' => $request->plot_id,
            'supply_id' => $request->supply_id,
            'seed_id' => $request->seed_id,
            'farm_id' => $farmId,
            'user_id'=> $request->user_id,
            'start_date' => $request->startDate,
            'finish_date' => $request->finishDate,
            'diesel_value' => $dieselValue,
            'observations' => $request->observation,
            'supply_estimated_value' => $estimatedValue,
        ]);

        // 2. Verifica se maquinário 1 foi enviado
        if ($request->filled('machinery_id_1')) {
            $machineryDieselConsumption = $this->formataValor($request->machinery_dieselConsumption_1);

            $activities->machinery()->attach($request->machinery_id_1, [
                'diesel_consumption'    => $machineryDieselConsumption,
            ]);
        }

        // 3. Verifica se maquinário 2 foi enviado
        if ($request->filled('machinery_id_2')) {
            $machineryDieselConsumption = $this->formataValor($request->machinery_dieselConsumption_2) ? $this->formataValor($request->machinery_dieselConsumption_2) : null;

            $activities->machinery()->attach($request->machinery_id_2, [
                'diesel_consumption' => $machineryDieselConsumption,
            ]);
        }

        return redirect()->back()->with('success', 'Atividade cadastrada com sucesso!');
    }

    public function update(Activity $activity, Request $request){

        $farmId = session('selected_farm_id');

        $request->validate([
            'update_name' => ['required', 'string', 'max:255'
            ,Rule::unique('activities', 'name')->ignore($activity->id)
            ->where(function ($query) use ($farmId) {
                return $query->where('farm_id', $farmId);
            })],
            'update_type' => ['required', 'string'],
            'update_crop_id' => ['required', 'exists:crops,id'],
            'update_plot_id' => ['required', 'exists:plots,id'],
            'update_user_id' => ['required', 'exists:users,id'],
            'update_startDate' => ['required', 'date'],
            'update_finishDate' => ['nullable', 'date', 'after_or_equal:update_startDate'],
            'update_machinery_dieselValue' => ['required', 'min:0'],
            'update_supplyEstimatedValue' => ['required', 'min:0'],
            'update_machinery_id_1' => ['nullable', 'exists:machinery,id'],
            'update_machinery_dieselConsumption_1' => ['required', 'min:0'],
            'update_machinery_id_2' => ['nullable', 'exists:machinery,id'],
            'update_machinery_dieselConsumption_2' => ['nullable', 'regex:/^[\d.,]+$/'],
        ], [
            'update_name.required' => 'O nome da atividade é obrigatório.',
            'update_name.unique' => 'O nome da atividade já existe.',
            'update_type.required' => 'O tipo da atividade é obrigatório.',
            'update_crop_id.required' => 'A cultura é obrigatória.',
            'update_plot_id.required' => 'O talhão é obrigatório.',
            'update_user_id.required' => 'O responsável pela atividade é obrigatório.',
            'update_startDate.required' => 'A data de início é obrigatória.',
            'update_finishDate.after_or_equal' => 'A data de término deve ser igual ou posterior à de início.',
            'update_machinery_dieselValue.regex' => 'Valor do diesel inválido.',
            'update_supplyEstimatedValue.regex' => 'Valor estimado do insumo inválido.',
        ]);

        $dieselConsumption = $this->formataValor($request->update_machinery_dieselValue);
        $estimatedValue = $this->formataValor($request->update_supplyEstimatedValue);

        $activity->update([
            'name' => $request->input('update_name'),
            'type' => $request->input('update_type'),
            'crop_id' => $request->input('update_crop_id'),
            'plot_id' => $request->input('update_plot_id'),
            'farm_id' => $farmId,
            'machinery_id' => $request->input('update_machinery_id'),
            'user_id' => $request->input('update_user_id'),
            'diesel_value' => $dieselConsumption,
            'start_date' => $request->input('update_startDate'),
            'finish_date' => $request->input('update_finishDate'),
            'observations' => $request->input('update_observation'),
            'supply_estimated_value' => $estimatedValue,
        ]);

        if ($request->filled('update_pivot_id_1') && $request->filled('update_pivot_id_2')) {
            // Busca o ID da pivot
            $pivotId1 = $request->input('update_pivot_id_1');
            $pivotId2 = $request->input('update_pivot_id_2');
            $machineryDieselConsumption1 = $this->formataValor($request->update_machinery_dieselConsumption_1);
            $machineryDieselConsumption2 = $this->formataValor($request->update_machinery_dieselConsumption_2);

            // Encontra o registro diretamente e atualiza
            DB::table('machinery_use_activity')
                ->where('id', $pivotId1)
                ->update([
                    'machinery_id' => $request->input('update_machinery_id_1'),
                    'diesel_consumption' => $machineryDieselConsumption1,
                    'updated_at' => now(),
                ]);

            DB::table('machinery_use_activity')
            ->where('id', $pivotId2)
            ->update([
                'machinery_id' => $request->input('update_machinery_id_2'),
                'diesel_consumption' => $machineryDieselConsumption2,
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('activity.create')->with('success', 'Atividade atualizada com sucesso!');
    }

    public function delete(Activity $activity){
        $activity->delete();
        return redirect()->back()->with('success', 'Atividade deletada com sucesso!');
    }

    public function findByName(Request $request){
        $farmId = session('selected_farm_id');

        $activities = Activity::with(['plot','crop','machinery','seed','supply','user'])
        ->where('farm_id',$farmId)
        ->when($request->findName, fn($q, $name) => $q->where('name', 'like', "%{$name}%"))
        ->get();

        return response()->json($activities);
    }

    public function getInsumosPorTipo($type){
        $farmId = session('selected_farm_id');
        try{
            if($type === 'adubador' || $type === 'pulverizador'){
                $supplies = Supply::where('farm_id',$farmId)->get();
                return response()->json($supplies);
            }else{
                $seeds = Seed::where('farm_id',$farmId)->get();
                return response()->json($seeds);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao buscar insumos',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function json($id){
        $farmId = session('selected_farm_id');

        try {
            $activity = Activity::with('machinery')->where('farm_id',$farmId)->findOrFail($id);
            return response()->json($activity);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao buscar atividade',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function formataValor($value){
        $raw = $value;

        $cleaned = preg_replace('/[^\d,]/u', '', $raw);

        // dd($cleaned);

        // Troca vírgula por ponto
        $normalized = str_replace(',', '.', $cleaned);

        return (float) $normalized;
    }
}
