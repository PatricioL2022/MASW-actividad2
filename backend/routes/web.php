<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\API\PersonController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/persons')->group(function () {
    Route::get('/',[ PersonController::class, 'get']);
    Route::post('/',[ PersonController::class, 'create']);
    Route::delete('/{id}',[ PersonController::class, 'delete']);
    Route::get('/{id}',[ PersonController::class, 'getById']);
    Route::put('/{id}',[ PersonController::class, 'update']);
});
