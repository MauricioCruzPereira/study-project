<?php

use Illuminate\Support\Facades\Route;

Route::controller(ProductController::class)->group(function(){
  Route::resource('',ProductController::class)->parameters([
      ''=>'id'
  ])->except([
      "edit",
      "create"
  ])->middleware(['auth:sanctum']);
});
