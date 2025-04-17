<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::prefix('todos')->group(function () {
    Route::get('/', [TodoController::class, 'index']);
    Route::post('/', [TodoController::class, 'store']);
    Route::get('/{id}', [TodoController::class, 'show']);
    Route::patch('/{id}/complete', [TodoController::class, 'complete']);
    Route::delete('/{id}', [TodoController::class, 'destroy']);
});

