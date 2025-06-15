<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use App\Http\Controllers\ClienteDentistaController;
Route::get('todos', [ClienteDentistaController::class, 'getTodo']);
// Route::get('/', [ClienteDentistaController::class, 'getTodo']);

Route::get('clientes', [ClienteDentistaController::class, 'getClientes']);
Route::get('dentistas', [ClienteDentistaController::class, 'getDentistas']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
