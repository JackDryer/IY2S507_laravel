<?php

namespace App\Http\Controllers;

use App\Models\AssetRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home (){
        $user_requests = User::where("is_approved",false)->count();
        $asset_requests = AssetRequest::where("status","requested")->count();
        return view ("admin.home",[
            "user_requests" =>$user_requests, 
            "asset_requests" =>$asset_requests
        ]);
    }
    public function showUserRequests (){
        $user_requests = User::where("is_approved",false)->sortable()->paginate(10);
        return view ("admin.user_requests",["user_requests" =>$user_requests]);
    }
    public function approveUserRequest (Request $request){
        $validated = $request->validate([
            'id'=>'required|integer'
        ]);
        $user = User::find($validated["id"]);
        $user->is_approved =true;
        $user->save();
        return redirect(route("admin.user_requests"))->with("success","User Approved");
    }
    public function showAssetRequests (){
        $asset_requests = AssetRequest::with(["user","asset"])->where("status","requested")->sortable()->paginate(10);
        return view ("admin.asset_requests",["asset_requests" =>$asset_requests]);
    }
    public function approveAssetRequest (Request $request){
        $validated = $request->validate([
            'id'=>'required|integer'
        ]);
        $asset_request = AssetRequest::find($validated["id"]);
        $asset_request->status ="approved";
        $asset_request->save();
        return redirect(route("admin.asset_requests"))->with("success","Asset Approved");
    }
}
