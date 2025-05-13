<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Models\Asset;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::get('/register',[AuthController::class,'showRegister'])->name("register.show");
Route::get('/login',[AuthController::class,'showLogin'])->name("login.show");
Route::post('/register',[AuthController::class,'register'])->name("register");
Route::post('/login',[AuthController::class,'login'])->name("login");
Route::post('/logout',[AuthController::class,'logout'])->name("logout");

Route::get('/assets', [AssetController::class,"index"])->middleware(['auth']);
Route::get('/assets/create', [AssetController::class,"create"])->middleware(['auth','admin']);
Route::get('/assets/{id}', [AssetController::class,"show"])->middleware(['auth','admin']);