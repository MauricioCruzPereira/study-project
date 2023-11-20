<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function(){
    Route::resource('',UserController::class)->parameters([
        ''=>'id'
    ])->except([
        "edit",
        "create"
    ])->middleware(['auth:sanctum']);

    // Adicione a rota create sem o middleware
    Route::post('/', 'store');
    Route::get('/', 'index');
});
