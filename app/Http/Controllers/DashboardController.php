<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $farms = Auth::user()->farms; // ou o método que você usa
        dd($farms);
        // Se quiser selecionar automaticamente a primeira fazenda:
        if ($farms->isNotEmpty() && !session()->has('selected_farm_id')) {
            session(['selected_farm_id' => $farms->first()->id]);
        }

        return view('dashboard', compact('farms'));
    }
}
