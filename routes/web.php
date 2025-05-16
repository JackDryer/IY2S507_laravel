<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\Asset;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::middleware(['guest'])->controller(AuthController::class)->group(function(){
    Route::get('/register','showRegister')->name("register.show");
    Route::get('/login','showLogin')->name("login.show");
    Route::post('/register','register')->name("register");
    Route::post('/login','login')->name("login");
});
Route::post('/logout',[AuthController::class,'logout'])->name("logout")->middleware('auth');

Route::middleware(['auth'])->controller(AssetController::class)->group(function(){
    Route::get('/assets/create', "create");
    Route::get('/assets/{id}', "show");
});
Route::middleware(['auth'])->controller(UserController::class)->group(function(){
    Route::get('/home', "home")->name("user.home"); 
    Route::get('/available_assets', "showAvailableAssets")->name("user.available_assets"); 
    Route::post('/available_assets', "requestAsset")->name("user.request_asset");
});

Route::middleware(['auth','admin'])->controller(AdminController::class)->group(function(){
    Route::get('/admin', "home")->name("admin.home");
    Route::get('/admin/user_requests', "showUserRequests")->name("admin.user_requests");
    Route::post('/admin/approve_user', "approveUserRequest")->name("admin.approve_user_request");
});