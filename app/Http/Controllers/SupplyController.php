<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplyController extends Controller
{
    public function index(){
        $perm = Auth::user()->getRoleForSelectedFarm();

        if ($perm !== 'admin' && Auth::user()->isOwner !== 1) {
            return view('dashboard');
        }

        $farms = Farm::where('user_id', Auth::id())->get();
        $farmId = session('selected_farm_id');

        $supplies = Supply::where('farm_id', $farmId)->get();

        return view('supply.supply',compact('supplies','farms'));
    }

    public function create(){
        $supplies = Supply::where('user_id',Auth::id())->get();

        return view('crops.crops',compact('supplies'));
    }

    public function store(Request $request){
        $farmId = session('selected_farm_id');

        $value = $this->formataValor($request->value);
        $initialStock = $this->formataValor($request->stock_quantity);

        $supply = Supply::create([
            'name' => $request->name,
            'type' => $request->type,
            'initial_stock_quantity' => $initialStock,
            'measure_unity' => $request->unity,
            'value' => $value,
            'farm_id' => $farmId
        ]);

        return redirect()->route('supply.index')->with('success', 'Insumo cadastrado com sucesso!');
    }

    public function update(Request $request, Supply $supply){
        $value = $this->formataValor($request->input('edit-supply_value'));
        $stockQuantity = $this->formataValor($request->input('edit-supply-stockQuantity'));

        $supply->update([
            'name' => $request->input('edit-supply-name'),
            'type' => $request->input('edit-supply-type'),
            'initial_stock_quantity' => $stockQuantity,
            'measure_unity' => $request->input('edit-supply-unity'),
            'value' => $value,
        ]);
        
        return redirect()->route('supply.index')->with('success', 'Insumo atualizado com sucesso!'); 
    }

    public function delete(Supply $supply){
        $supply->delete();
        return redirect()->route('supply.index')->with('success', 'Insumo deletado com sucesso!');
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
