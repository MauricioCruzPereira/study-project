<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function(){
    Route::resource('',UserController::class)->parameters([
        ''=>'id'
    ])->except([
        "edit",
        "create"
    ]);
});
