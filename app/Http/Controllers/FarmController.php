<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FarmController extends Controller
{
    public function index(){
        $perm = Auth::user()->getRoleForSelectedFarm();

        if ($perm !== 'admin' && Auth::user()->isOwner !== 1) {
            return view('dashboard');
        }

        $farms = Farm::where('owner_id',Auth::id())->get();
        $farmId = session('selected_farm_id');

        return view('farm.farm', compact('farms'));
    }

    public function create(){
        return view(('plots.create'));
    }

    public function store(Request $request){
        $request['owner_id'] = Auth::id(); 

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('farms')->where(function ($query) {
                    return $query->where('owner_id', Auth::user()->id);
                }),
            ],
            'location' => ['required','max:50'],
        ], [
            'name.unique' => 'Você já possui uma fazenda com esse nome.',
            'name.max' => 'O nome da fazenda não deve ter mais de 50 caracters.',
            'location.required' => 'Você deve preencher a localização da fazenda',
            'location.max' => 'A localização não deve ter mais de 50 caracters'
        ]);

        $farm = Farm::create($request->all());

        // 2. Insere o relacionamento do owner na tabela farm_user
        $farm->users()->attach(Auth::id(), [
            'role' => 'admin' // ou 'admin', se não usar enum
        ]);
        
         return redirect()->route('farm.index')->with('success', 'Fazenda cadastrado com sucesso!'); 
    }

    public function update(Request $request, Farm $farm){
        $userId = Auth::user()->id;

         $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('farms', 'name')->ignore($farm->id)
            ->where(function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            })],
            'location' => ['required','max:50'],
        ], [
            'name.unique' => 'Você já possui uma fazenda com esse nome.',
            'name.max' => 'O nome da fazenda não deve ter mais de 50 caracters.',
            'location.required' => 'Você deve preencher a localização da fazenda',
            'location.max' => 'A localização não deve ter mais de 50 caracters'
        ]);

        $farm->update($request->only(['name', 'location']));
        
        return redirect()->route('farm.index')->with('success', 'Fazenda atualizada com sucesso!'); 
    }

    public function delete(Farm $farm){
        $farm->delete();
        return redirect()->route('farm.index')->with('success', 'Fazenda deletada com sucesso!');
    }

    public function farmTrade(Request $request){
        $request->validate([
            'farm_id' => 'required|exists:farms,id',
        ]);

        $user = Auth::user();
        $farmId = $request->farm_id;

        if (!$user->ownedFarms()->where('id', $farmId)->exists() && $user->farm_id != $farmId) {
            abort(403, 'Acesso negado à fazenda.');
        }

        session(['active_farm_id' => $farmId]);

        return back();
    }
}
