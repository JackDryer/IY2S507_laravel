<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function home(){
        $user_id = Auth::user()->id;
        $approved_assets = Asset::whereHas('requests', function ($query) {
            $query->where('user_id', Auth::id())
            ->where('status', 'approved');
        })
            ->sortable()
            ->paginate(4, ['*'], 'assignedAssets');
        $pending_assets = Asset::whereHas('requests', function ($query) {
            $query->where('user_id', Auth::id())
            ->where('status', 'requested');
        })
            ->sortable()
            ->paginate(4, ['*'], 'pendingAssets');
        //sortable('name')->paginate(4,['*'], 'cbShows');
        return view('user.home',["approved_assets" =>$approved_assets,"pending_assets"=>$pending_assets]);
    }
    public function showAvailableAssets(){
        $assets = Asset::whereDoesntHave('requests', function ($query) {
                $query->where('status', 'approved');
            })
            ->sortable("name")
            ->paginate(10);
        return view('user.available_assets',["assets" =>$assets]);
    }
    public function requestAsset(Request $request){
        if (AssetRequest::where("user_id",Auth::id())
        ->whereNot("status","denied")
        ->count() >= Auth::user()->device_limit){
            return redirect()->route("user.available_assets")->with('success',"You have reached your device limit");
        }
        $id = $request->validate([
            'id'=>'required|integer'
        ])["id"];
        AssetRequest::create([
            "user_id" =>Auth::id(),
            "asset_id" =>$id
        ]);
        return redirect()->route("user.available_assets")->with('success',"Asset Requested");
    }
}
