<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function(){
    Route::post('login', 'login');
    Route::post('logout','logout')->middleware(['auth:sanctum']);
    Route::get('me','me')->middleware(['auth:sanctum']);
});
