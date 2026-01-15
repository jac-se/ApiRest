<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\PonenteController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/eventos', [EventoController::class, 'index']);
Route::get('/eventos/{id}', [EventoController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Rutas protegidas (auth:api)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->group(function () {

    // Eventos
    Route::post('/eventos', [EventoController::class, 'store']);
    Route::put('/eventos/{id}', [EventoController::class, 'update']);
    Route::delete('/eventos/{id}', [EventoController::class, 'destroy']);

    // Ponentes
    Route::post('/ponentes', [PonenteController::class, 'store']);
    Route::put('/ponentes/{id}', [PonenteController::class, 'update']);
    Route::delete('/ponentes/{id}', [PonenteController::class, 'destroy']);

    // Asistentes
    Route::get('/asistentes', [AsistenteController::class, 'index']);
    Route::post('/asistentes', [AsistenteController::class, 'store']);
    Route::get('/asistentes/{id}', [AsistenteController::class, 'show']);
    Route::put('/asistentes/{id}', [AsistenteController::class, 'update']);
    Route::delete('/asistentes/{id}', [AsistenteController::class, 'destroy']);

    // Usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});