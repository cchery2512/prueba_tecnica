<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EventoCalendarioController;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::post('registrar', [AuthController::class, 'registrar']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::apiResource('usuario', UserController::class);
    Route::apiResource('tipo_evento', TipoEventoController::class);
    Route::apiResource('evento_calendario', EventoCalendarioController::class);
});
