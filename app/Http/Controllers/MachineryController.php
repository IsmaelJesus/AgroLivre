<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\Machinery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MachineryController extends Controller
{
    public function index(){
        $perm = Auth::user()->getRoleForSelectedFarm();

        if ($perm !== 'admin' && Auth::user()->isOwner !== 1) {
            return view('dashboard');
        }

        $farms = Farm::where('user_id', Auth::id())->get();
        $farmId = session('selected_farm_id');

        // $machinery = Machinery::whereHas('farm', function ($query) {
        //     $query->where('user_id', Auth::id());
        // })->with('farm')->get();
        $machinery = Machinery::where('farm_id', $farmId)->get();

        return view('machinery.machinery', compact('machinery','farms'));
    }

    public function store(Request $request){
        $farmId = session('selected_farm_id');
        $value = str_replace(['R$', '.', ','], ['', '', '.'], $request->acquisitionValue);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('machinery', 'name')->where(function ($query) use ($farmId) {
                    return $query->where('farm_id', $farmId);
                }),
            ], 
            [
            'name.required' => 'O nome da safra é obrigatório.',
            'name.unique' => 'Já existe uma safra com esse nome nesta fazenda.',
            ]
        ]);

        $machinery = Machinery::create([
            'name' => $request->name,
            'type' => $request->type,
            'brand' => $request->brand,
            'model' => $request->model,
            'acquisition_date' => $value,
            'useful_life' => $request->usefulLife,
            'acquisition_value' => $request->acquisitionValue,
            'hours_use' => $request->hoursUse,
            'status' => $request->status,
            'farm_id' => $farmId,
        ]);

        return redirect()->route('machinery.index')->with('success', 'Maquinario cadastrada com sucesso!');
    }

    public function delete(Machinery $machinery){
        $machinery->delete();
        return redirect()->route('machinery.index')->with('success', 'Maquinario deletado com sucesso!');
    }

    public function update(Request $request, Machinery $machinery){
        $farmId = session('selected_farm_id');
        $value = str_replace(['R$', '.', ','], ['', '', '.'], $request->input('edit-machinery-acquisitionValue'));

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('machinery', 'name')
                    ->ignore($machinery->id)
                    ->where(function ($query) use ($farmId) {
                        return $query->where('farm_id', $farmId);
                    }),
            ],
        ], [
            'name.required' => 'O nome da safra é obrigatório.',
            'name.unique' => 'Já existe uma safra com esse nome nesta fazenda.',
        ]);

        $machinery->update([
            'name' => $request->input('edit-machinery-name'),
            'type' => $request->input('edit-machinery-type'),
            'brand' => $request->input('edit-machinery-brand'),
            'model' => $request->input('edit-machinery-model'),
            'acquisition_value' => $value,
            'acquisition_usefulLife' =>$request->input('edit-machinery-usefulLife'),
            'acquisition_date' =>$request->input('edit-machinery-acquisitionDate'),
            'hours_use' => $request->input('edit-machinery-hoursUse'),
            'status' => $request->input('edit-machinery-status'),
        ]);
        
        return redirect()->route('machinery.index')->with('success', 'Maquinario atualizado com sucesso!'); 
    }
}
