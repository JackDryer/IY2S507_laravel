<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetRequest;
use App\Models\Brand;
use App\Models\ProductType;
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
    
    public function showAvailableAssets(Request $request){
        // Get filter parameters
        $deviceType = $request->input('device_type');
        $brand = $request->input('brand');
        $minRam = $request->input('min_ram');
        $minStorage = $request->input('min_storage');
        
        // Base query for available assets
        $query = Asset::whereDoesntHave('requests', function ($query) {
                $query->where('status', 'approved');
            });
            
        // Apply filters if they exist
        if ($deviceType) {
            $query->whereHas('device.productType', function($q) use ($deviceType) {
                $q->where('id', $deviceType);
            });
        }
        
        if ($brand) {
            $query->whereHas('device.brand', function($q) use ($brand) {
                $q->where('id', $brand);
            });
        }
        
        if ($minRam) {
            $ramBytes = $minRam * 1_000_000_000; // Convert GB to bytes
            $query->whereHas('device', function($q) use ($ramBytes) {
                $q->where('ram_bytes', '>=', $ramBytes);
            });
        }
        
        if ($minStorage) {
            $storageBytes = $minStorage * 1_000_000_000; // Convert GB to bytes
            $query->whereHas('device', function($q) use ($storageBytes) {
                $q->where('storage_bytes', '>=', $storageBytes);
            });
        }
        
        // Get data for filter dropdowns
        $productTypes = ProductType::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        
        // Get paginated and sorted results
        $assets = $query->sortable("name")->paginate(10)->appends($request->except('page'));
        
        return view('user.available_assets', [
            "assets" => $assets,
            "productTypes" => $productTypes,
            "brands" => $brands,
            "filters" => $request->all()
        ]);
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
