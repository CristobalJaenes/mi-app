<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CitasController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class InicioController extends Controller
{
    public function index()
    {
        $citasSemana = CitasController::getCitasSemana();
        $semana = now()->format('Y-m-d H:i:s');

        return view('inicio', compact('semana', 'citasSemana'));
    }

}
