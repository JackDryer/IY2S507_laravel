<?php

use App\Models\Asset;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/assets', function() {
    $assets= Asset::orderBy("name","asc")->paginate(10);
    return view('assets.index',["assets" =>$assets]);
}) ;
Route::get('/assets/create', function() {
    return view("assets.create");
});
Route::get('/assets/{id}', function($id) {
    $assets= [
        ["name"=>"asset1","make"=>"lenovo","id"=>"1"],
        ["name"=>"thinkpad","make"=>"lenovo","id"=>"2"]
    ];
    return view('assets.show',["id" =>$assets[$id]]);
});