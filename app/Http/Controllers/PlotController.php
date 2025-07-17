<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\Plot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PlotController extends Controller
{
    public function index(){
        $perm = Auth::user()->getRoleForSelectedFarm();

        if ($perm !== 'admin' && Auth::user()->isOwner !== 1) {
            return view('dashboard');
        }

        $farmId = session('selected_farm_id');
        $farms = Farm::where('user_id', Auth::id())->get();

        $plots = Plot::where('farm_id',$farmId)->get();

        return view('plots.plot', compact('plots','farms'));
    }

    public function create(){
        return view(('plots.create'));
    }

    public function store(Request $request){
        $farmId = session('selected_farm_id');

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:plots,name'],
            'area' => ['required', 'numeric', 'min:1'],
        ], [
            'name.required' => 'O nome da área é obrigatório.',
            'name.unique' => 'Já existe uma área com esse nome.',
            'area.required' => 'A área é obrigatória.',
            'area.numeric' => 'A área deve ser um número.',
            'area.min' => 'A área deve ser maior ou igual a 1.',
        ]);

        Plot::create([
            'name' => $request->name,
            'area' => $request->area,
            'farm_id' => $farmId
        ]);

        return redirect()->route('plot.index')->with('success', 'Área cadastrada com sucesso!');
    }

    public function edit(Request $request){
        $id = $request->input('id');
    
        $plots = Plot::where('id',$id)->get();

        dd($plots);
    }

    public function update(Request $request, Plot $plot){
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('plots', 'name')->ignore($plot->id),
            ],
            'area' => ['required', 'numeric', 'min:1'],
        ], [
            'name.required' => 'O nome da área é obrigatório.',
            'name.unique' => 'Já existe uma área com esse nome.',
            'area.required' => 'A área é obrigatória.',
            'area.numeric' => 'A área deve ser um número.',
            'area.min' => 'A área deve ser maior ou igual a 1.',
        ]);


        $plot->update($request->only(['name', 'area']));
        
        return redirect()->route('plot.index')->with('success', 'Área atualizada com sucesso!'); 
    }

    public function delete(Plot $plot){
        $plot->delete();
        return redirect()->route('plot.index')->with('success', 'Área deletada com sucesso!');
    }
}
