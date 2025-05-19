<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HardwareController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()){
        return redirect(route("user.home"));
    }
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
Route::middleware(['auth'])->controller(UserController::class)->name('user.')->group(function(){
    Route::get('/home', "home")->name("home"); 
    Route::get('/available_assets', "showAvailableAssets")->name("available_assets"); 
    Route::post('/available_assets', "requestAsset")->name("request_asset");
});

// Admin routes focused on user and request management
Route::middleware(['auth','admin'])->controller(AdminController::class)->prefix('admin/')->name('admin.')->group(function(){
    Route::get('/', "home")->name("home");
    Route::get('/user_requests', "showUserRequests")->name("user_requests");
    Route::post('/user_requests', "approveUserRequest")->name("approve_user_request");
    Route::get('/asset_requests', "showAssetRequests")->name("asset_requests");
    Route::post('/asset_requests', "approveAssetRequest")->name("approve_asset_request");
    Route::get('/manage_users', "showManageUsers")->name("manage_users");
});

// New hardware management routes with single POST endpoint
Route::middleware(['auth','admin'])->controller(HardwareController::class)->prefix('admin/hardware')->name('hardware.')->group(function(){
    Route::get('/', "index")->name("index");
    Route::post('/', "handleAction")->name("action"); // Single endpoint for all actions
});