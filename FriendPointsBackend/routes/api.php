<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function(){
    Route::post("/register", "register");
    Route::post("/login", "login");
});
Route::controller(AuthController::class)->middleware("jwt")->group(function(){
    Route::get("/user", "getUser");
    Route::post("/logout", "logout");
});
