<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Crop;
use App\Models\Plot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CropController extends Controller
{
    public function create(){
        $perm = Auth::user()->getRoleForSelectedFarm();
        

        if ($perm !== 'admin' && Auth::user()->isOwner !== 1) {
            return view('dashboard');
        }

        $farmId = session('selected_farm_id');
        $plots = Plot::where('farm_id',$farmId)->get();
        $crops = Crop::where('farm_id', $farmId)->get();

        return view('crops.crops',compact('plots','crops'));
    }

    public function store(Request $request){
        $farmId = session('selected_farm_id');

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('crops', 'name')->where(function ($query) use ($farmId) {
                    return $query->where('farm_id', $farmId);
                }),
            ],
            'plantingDate' => ['required', 'date'],
            'harvestDate' => ['nullable', 'date', 'after_or_equal:plantingDate'],
        ], [
            'name.required' => 'O nome da safra é obrigatório.',
            'name.unique' => 'Já existe uma safra com esse nome nesta fazenda.',
            'plantingDate.required' => 'A data de plantio é obrigatória.',
            'plantingDate.date' => 'A data de plantio deve ser uma data válida.',
            'harvestDate.date' => 'A data de colheita deve ser uma data válida.',
            'harvestDate.after_or_equal' => 'A data de colheita deve ser igual ou posterior à data de plantio.',
        ]);

        $farmId = session('selected_farm_id');

        $crop = Crop::create(   
            ['name' => $request->name,
            'planting_date' => $request->plantingDate,
            'harvest_date' => $request->harvestDate,
            'farm_id' => $farmId,
        ]);
        
        return redirect()->route('crop.index')->with('success', 'Safra cadastrada com sucesso!'); 
    }

    public function update(Request $request, Crop $crop){
        $farmId = session('selected_farm_id');

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('crops', 'name')
                    ->ignore($crop->id)
                    ->where(function ($query) use ($farmId) {
                        return $query->where('farm_id', $farmId);
                    }),
            ],
            'planting' => ['required', 'date'],
            'harvest' => ['nullable', 'date', 'after_or_equal:planting'],
        ], [
            'name.required' => 'O nome da safra é obrigatório.',
            'name.unique' => 'Já existe uma safra com esse nome nesta fazenda.',
            'planting.required' => 'A data de plantio é obrigatória.',
            'planting.date' => 'A data de plantio deve ser uma data válida.',
            'harvest.date' => 'A data de colheita deve ser uma data válida.',
            'harvest.after_or_equal' => 'A data de colheita deve ser igual ou posterior à data de plantio.',
        ]);

        $crop->update([
            'name' => $request->input('name'),
            'planting_date' => $request->input('planting'),
            'harvest_date' => $request->input('harvest'),
        ]);
        
        return redirect()->route('crop.index')->with('success', 'Safra atualizado com sucesso!'); 
    }

    public function delete(Crop $crop){
        $crop->delete();
        return redirect()->route('crop.index')->with('success', 'Safra deletada com sucesso!');
    }

    public function getReport($cropId){
        // Recupera todas as atividades da safra
        $activities = Activity::with('plot')
            ->where('crop_id', $cropId)
            ->get();

        $totalDiesel = 0;

        foreach ($activities as $activity) {
            $area = $activity->plot->area;
            $dieselValue = $activity->diesel_value;

            // Soma o consumo de todos os maquinários dessa atividade na tabela pivô
            $totalConsumption = DB::table('machinery_use_activity')
                ->where('activity_id', $activity->id)
                ->get()
                ->sum(function ($use) {
                    return (float) str_replace(',', '.', $use->diesel_consumption ?? 0);
                });

            $totalDiesel += ($totalConsumption * $area) * $dieselValue;
            
            $gastosPorTipo = DB::table('activities')
            ->where('crop_id', $cropId)
            ->select('type', DB::raw("SUM(supply_estimated_value) as total"))
            ->groupBy('type')
            ->pluck('total', 'type');
        }

        $gastosFormatados = [];

        foreach ($gastosPorTipo as $tipo => $valor) {
            $gastosFormatados[$tipo] = number_format($valor, 2, ',', '.');
        }

        return response()->json([
            'total_diesel_cost' => number_format($totalDiesel, 2, ',', '.'),
            'crop_id' => $cropId,
            'spend_per_type' => $gastosFormatados
        ]);
    }
}
