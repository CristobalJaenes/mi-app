<?php

use App\Http\Controllers\CitasController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\Auth\adminController;
use App\Http\Controllers\pdfController;

Route::get('/', function () {
    return redirect()->route('inicio');
});

Route::get('/ayuda',function(){
    return view('ayuda');
})->name('ayuda');

Route::middleware(['auth', 'checkUserRole'])->group(function () {
    Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');
    Route::get('/horario/ajax/{fecha}', [CitasController::class, 'getHorarioAjax'])->name('horario.ajax');
    Route::get('/client/{id}', [clienteController::class, 'panelCliente'])->name('panelCliente');

    Route::get('/formCita/{id}', [CitasController::class, 'formCita'])->name('formCita');
    Route::get('/creaCita/{id}', [CitasController::class, 'creaCita'])->name('creaCita');

    Route::get('/formCitaEdit/{id}', [CitasController::class, 'formCitaEdit'])->name('formCitaEdit');
    Route::get('/editaCita/{id}', [CitasController::class, 'editaCita'])->name('editaCita');

    Route::delete('/borraCita/{id}', [CitasController::class, 'borraCita'])->name('borraCita');

    Route::get('/formCreaCliente', [clienteController::class, 'formCreaCliente'])->name('formCreaCliente');
    Route::get('/creaCliente', [clienteController::class, 'creaCliente'])->name('creaCliente');

    Route::get('/formEditaCliente/{id}', [clienteController::class, 'formEditaCliente'])->name('formEditaCliente');
    Route::get('/editaCliente/{id}', [clienteController::class, 'editaCliente'])->name('editaCliente');

    Route::get('/listaDent', [CitasController::class, 'listaDent'])->name('listaDent');
    Route::get('/citasIdDent/{id}', [CitasController::class, 'CitasIdDent'])->name('CitasIdDent');
    Route::get('/formCitasDia', [citasController::class, 'formCitasDia'])->name('formCitasDia');
    Route::get('/buscaCitasDia/{dia}', [citasController::class, 'buscaCitasDia'])->name('buscaCitasDia');

    Route::get('/formBuscaCliente', [clienteController::class, 'formBuscaCliente'])->name('formBuscaCliente');
    Route::get('/buscaCliente/{texto}', [clienteController::class, 'buscaCliente'])->name('buscaCliente');

    Route::get('/formEditaOdonto/{id}', [clienteController::class, 'formEditaOdonto'])->name('formEditaOdonto');
    Route::get('/editaOdonto/{id}', [clienteController::class, 'editaOdonto'])->name('editaOdonto');

    // -----------------------
    Route::get('/gestUsuPass/{id}', [adminController::class, 'gestUsuPass'])->name('gestUsuPass');
    Route::post('/gestUsuPassCheck/{id}', [adminController::class, 'PassCheck'])->name('gestUsuPassCheck');
    // Route::get('/gestUsu', [adminController::class, 'gestUsu'])->name('gestUsu');
    Route::get('/gestUsu/{id}', [adminController::class, 'gestUsu'])->name('gestUsu');
    Route::get('/modPerm/{id}', [adminController::class, 'modPerm'])->name('modPerm');

    Route::delete('/borraCliente/{id}', [clienteController::class, 'borraCliente'])->name('borraCliente');

    Route::delete('/borraUsu/{id}', [adminController::class, 'borraUsu'])->name('borraUsu');
    Route::delete('/borraUsu2/{id}', [adminController::class, 'borraUsu2'])->name('borraUsu2');

    Route::post('/upgClient/{id}', [adminController::class, 'upgClient'])->name('upgClient');
    Route::post('/upgClientPass/{id}', [adminController::class, 'upgClientPass'])->name('upgClientPass');
    Route::post('/upgClientPassCheck/{id}', [adminController::class, 'upgPassCheck'])->name('upgClientPassCheck');

    Route::get('/ajustes', [ProfileController::class, 'ajustes'])->name('ajustes');

    Route::get('/citasPacientePdf/{id}', [pdfController::class, 'citasPacientePdf'])->name('citasPacientePdf');
    Route::get('/citasDiaPdf/{dia}', [pdfController::class, 'citasDiaPdf'])->name('citasDiaPdf');
    Route::get('/citasDentPdf/{id}', [pdfController::class, 'citasDentPdf'])->name('citasDentPdf');
});

Route::middleware('auth')->group(function () {
    Route::post('/cambiaEmail', [ProfileController::class, 'update'])->name('cambiaEmail');
    Route::post('/changePass', [ProfileController::class, 'changePass'])->name('changePass');
});

require __DIR__ . '/auth.php';
