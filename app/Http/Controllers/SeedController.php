<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\Seed;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeedController extends Controller
{
    public function create(){
        $perm = Auth::user()->getRoleForSelectedFarm();

        if ($perm !== 'admin' && Auth::user()->isOwner !== 1) {
            return view('dashboard');
        }

        $farms = Farm::where('user_id', Auth::id())->get();
        $farmId = session('selected_farm_id');

        $seeds = Seed::where('farm_id', $farmId)->get();

        return view('supply.seeds',compact('seeds','farms'));
    }

    public function store(Request $request){
        $farmId = session('selected_farm_id');
        $value = $this->formataValor($request->value);
        $initialStock = $this->formataValor($request->stock_quantity);

        $seed = Seed::create(   
            ['name' => $request->name,
            'type' => 'semente',
            'initial_stock_quantity' => $initialStock,
            'measure_unity' => $request->unity,
            'value' => $value,
            'pms' => $request->pms,
            'germination' => $request->germination,
            'vigor' => $request->vigor,
            'farm_id' => $farmId
        ]);
        
        return redirect()->route('seed.create')->with('success', 'Semente cadastrada com sucesso!'); 
    }

    public function update(Request $request, Seed $seed){
        $value = $this->formataValor($request->value);

        $seed->update([
            'name' => $request->input('edit-seed-name'),
            'type' => 'semente',
            'initial_stock_quantity' => $request->input('edit-seed-stockQuantity'),
            'measure_unity' => $request->input('edit-seed-unity'),
            'value' => $value,
            'pms' => $request->input('edit-seed-pms'),
            'germination' =>  $request->input('edit-seed-germination'),
            'vigor' => $request->input('edit-seed-vigor'),
        ]);
        
        return redirect()->route('seed.create')->with('success', 'Semente atualizada com sucesso!'); 
    }

    public function delete(Seed $seed){
        $seed->delete();
        return redirect()->route('seed.create')->with('success', 'Safra deletada com sucesso!');
    }

    private function formataValor($value){
        $raw = $value;

        $cleaned = preg_replace('/[^\d,]/u', '', $raw);

        // Troca vírgula por ponto
        $normalized = str_replace(',', '.', $cleaned);

        return (float) $normalized;
    }
}
