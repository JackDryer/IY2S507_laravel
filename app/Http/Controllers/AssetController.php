<?php

namespace App\Http\Controllers;

use App\Models\Asset;


class AssetController extends Controller
{
    public function index(){
        $assets= Asset::sortable()->paginate(10);
        return view('user.home',["assets" =>$assets]);
    }
    public function create(){
        return view("assets.create");
    }
    public function show($id){
        $asset = Asset::findOrFail($id);
        return view('assets.show',["asset" =>$asset]);
    }
}
