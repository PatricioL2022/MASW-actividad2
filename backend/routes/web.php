<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\API\PersonController;
use Illuminate\Support\Facades\Route;

Route::get('/sa', function () {
   // dd('hola');
   // return view('welcome');
   return strtotime("2024/07/15");
});

/**Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::get('/{user}/detalle','detail')->name('user_detail');
});*/





Route::prefix('v1/persons')->group(function () {
    Route::get('/',[ PersonController::class, 'get']);
    Route::post('/',[ PersonController::class, 'create']);
    Route::delete('/{id}',[ PersonController::class, 'delete']);
    Route::get('/{id}',[ PersonController::class, 'getById']);
    Route::put('/{id}',[ PersonController::class, 'update']);
});
