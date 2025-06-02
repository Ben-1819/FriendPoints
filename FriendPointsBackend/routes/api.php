<?php

use App\Http\Controllers\FriendController;
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

Route::controller(FriendController::class)->middleware("jwt")->group(function(){
    Route::get("/index", "index");
    Route::get("/group1/index", "group1Friends");
    Route::get("/group2/index", "group2Friends");
    Route::get("/{id}/index", "otherIndex");
    Route::get("/{id}/group1/index", "otherGroup1Friends");
    Route::get("/{id}/group2/index", "otherGroup2Friends");
    Route::get("/showOptions", "showOptions");
    Route::post("/store", "store");
});

Route::controller(FriendController::class)->middleware(["jwt", "friendOwner"])->group(function(){
    Route::put("/{id}/update", "update");
    Route::put("/{id}/addPoints", "addPoints");
    Route::put("/{id}/removePoints", "removePoints");
    Route::put("/{id}/delete", "destroy");
});
