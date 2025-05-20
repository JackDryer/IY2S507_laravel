<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function home()
    {
        $user_requests = User::where("status", "requested")->count();
        $asset_requests = AssetRequest::where("status", "requested")->count();
        return view("admin.home", [
            "user_requests" => $user_requests,
            "asset_requests" => $asset_requests
        ]);
    }
    public function showUserRequests()
    {
        $user_requests = User::where("status", "requested")->sortable()->paginate(10);
        return view("admin.user_requests", ["user_requests" => $user_requests]);
    }
    public function approveUserRequest(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);
        $user = User::find($validated["id"]);
        $user->status = "active";
        $user->save();
        return redirect(route("admin.user_requests"))->with("success", "User Approved");
    }
    public function showAssetRequests()
    {
        $asset_requests = AssetRequest::with(["user", "asset"])->where("status", "requested")->sortable()->paginate(10);
        return view("admin.asset_requests", ["asset_requests" => $asset_requests]);
    }
    public function approveAssetRequest(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);
        $asset_request = AssetRequest::find($validated["id"]);
        $asset_request->status = "approved";
        $asset_request->save();
        return redirect(route("admin.asset_requests"))->with("success", "Asset Approved");
    }
    public function showManageUsers()
    {
        $users = User::sortable()->paginate(10);
        return view("admin.manage.users", ["users" => $users]);
    }
    public function addAsset(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:assets',
            'serial_number' => 'required|string|max:255',
            'colour_id' => 'required|exists:colours,id',
            'device_id' => 'required|exists:devices,id'
        ]);

        Asset::create($validated);
        return redirect()->route('admin.manage_assets')->with('success', 'Asset created successfully');
    }

    public function showManageAssets()
    {
        $assets = Asset::with(["device", "colour"])->sortable()->paginate(10);
        return view("admin.manage.assets", ["assets" => $assets]);
    }
    public function deleteAsset(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:assets,id'
        ]);

        $asset = Asset::find($validated['id']);
        $asset->delete();

        return redirect()->route('admin.manage_assets')->with('success', 'Asset deleted successfully');
    }

    public function manageUser(Request $request)
    {
        $userId = $request->input('id');
        $action = $request->input('action');
        $user = User::findOrFail($userId);

        switch ($action) {
            case 'update':
                // Update user details
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . $userId,
                    'role' => 'required|string|in:admin,user', // Example roles
                ]);
                $user->name = $validated['name'];
                $user->email = $validated['email'];
                $user->role = $validated['role'];
                $user->save();
                return redirect()->back()->with('success', 'User updated successfully');

            case 'approve':
                $user->status = 'active';
                $user->save();
                return redirect()->back()->with('success', 'User approved');

            case 'toggle_status':
                // Toggle user status (is_disabled)
                $user->is_disabled = !$user->is_disabled;
                $user->save();
                $status = $user->is_disabled ? 'disabled' : 'enabled';
                return redirect()->back()->with('success', "User $status");

            case 'strip_assets':
                // Strip all assets from user
                DB::table('assets')
                    ->where('user_id', $userId)
                    ->update(['user_id' => null]);
                return redirect()->back()->with('success', 'All assets removed from user');

            default:
                return redirect()->back()->with('error', 'Invalid action');
        }
    }
}
