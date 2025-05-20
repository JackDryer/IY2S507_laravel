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
        $departments = \App\Models\Department::all(); // Add this line
        return view("admin.manage.users", [
            "users" => $users,
            "departments" => $departments // Pass departments to the view
        ]);
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
        // Handle JSON request format (for fetch API calls)
        if ($request->isJson()) {
            $data = $request->json()->all();
            $userId = $data['id'];
            $action = $data['action'];
        } else {
            $userId = $request->input('id');
            $action = $request->input('action');
        }
        
        $user = User::findOrFail($userId);

        switch ($action) {
            case 'update':
                // Check if this is a JSON request
                if ($request->isJson()) {
                    try {
                        $validated = $request->validate([
                            'first_name' => 'required|string|max:255',
                            'last_name' => 'required|string|max:255',
                            'email' => 'required|email|max:255|unique:users,email,' . $userId,
                            'employee_num' => 'required|string|max:255|unique:users,employee_num,' . $userId,
                            'department_id' => 'required|exists:departments,id',
                            'device_limit' => 'required|integer|min:0',
                            'status' => 'required|in:requested,active,denied',
                            'is_admin' => 'required|boolean'
                        ]);
                        
                        $user->first_name = $validated['first_name'];
                        $user->last_name = $validated['last_name'];
                        $user->email = $validated['email'];
                        $user->employee_num = $validated['employee_num'];
                        $user->department_id = $validated['department_id'];
                        $user->device_limit = $validated['device_limit'];
                        $user->status = $validated['status'];
                        $user->is_admin = $validated['is_admin'];
                        $user->save();
                        
                        // Set a flash message that can be read after redirecting
                        session()->flash('success', 'User updated successfully');
                        
                        return response()->json([
                            'success' => true, 
                            'message' => 'User updated successfully'
                        ]);
                    } catch (\Exception $e) {
                        return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
                    }
                } else {
                    // Handle traditional form submission (if needed)
                    // ...existing code...
                }
                break;

            case 'approve':
                $user->status = 'active';
                $user->save();
                return redirect()->back()->with('success', 'User approved');;

            case 'strip_assets':
                // Begin transaction to ensure data consistency
                DB::beginTransaction();
                try {
                    // Cancel any pending asset requests from this user
                    DB::table('asset_requests')
                        ->where('user_id', $userId)
                        ->where('status', 'requested')
                        ->update(['status' => 'denied']);
                    
                    DB::commit();
                    return redirect()->back()->with('success', 'All assets and pending requests removed from user');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Error removing user assets: ' . $e->getMessage());
                }

            default:
                return redirect()->back()->with('error', 'Invalid action');
        }
    }
}
