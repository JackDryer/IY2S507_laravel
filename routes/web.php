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
Route::middleware(['auth'])->controller(UserController::class)->group(function(){
    Route::get('/home', "home")->name("user.home"); 
    Route::get('/available_assets', "showAvailableAssets")->name("user.available_assets"); 
    Route::post('/available_assets', "requestAsset")->name("user.request_asset");
});

// Admin routes focused on user and request management
Route::middleware(['auth','admin'])->controller(AdminController::class)->group(function(){
    Route::get('/admin', "home")->name("admin.home");
    Route::get('/admin/user_requests', "showUserRequests")->name("admin.user_requests");
    Route::post('/admin/user_requests', "approveUserRequest")->name("admin.approve_user_request");
    Route::get('/admin/asset_requests', "showAssetRequests")->name("admin.asset_requests");
    Route::post('/admin/asset_requests', "approveAssetRequest")->name("admin.approve_asset_request");
    Route::get('/admin/manage_users', "showManageUsers")->name("admin.manage_users");
});

// New hardware management routes with single POST endpoint
Route::middleware(['auth','admin'])->controller(HardwareController::class)->prefix('admin/hardware')->name('hardware.')->group(function(){
    Route::get('/', "index")->name("index");
    Route::post('/', "handleAction")->name("action"); // Single endpoint for all actions
});