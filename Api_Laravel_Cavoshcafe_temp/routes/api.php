<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::prefix('cliente')->group(function () {
    Route::post('/login', [ClienteController::class, 'login']);
    Route::post('/', [ClienteController::class, 'modificar']);
    Route::post('/codigo', [ClienteController::class, 'generarCodigo']);
});