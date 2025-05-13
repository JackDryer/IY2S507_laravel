<?php

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

Route::get('/assets', function() {
    $assets= Asset::orderBy("name","asc")->paginate(10);
    return view('assets.index',["assets" =>$assets]);
})->middleware(['auth']);
Route::get('/assets/create', function() {
    return view("assets.create");
})->middleware(['auth','admin']);
Route::get('/assets/{id}', function($id) {
    $assets= [
        ["name"=>"asset1","make"=>"lenovo","id"=>"1"],
        ["name"=>"thinkpad","make"=>"lenovo","id"=>"2"]
    ];
    return view('assets.show',["id" =>$assets[$id]]);
});