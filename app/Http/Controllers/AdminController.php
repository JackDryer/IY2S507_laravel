<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home (){
        $user_requests = User::where("is_approved",false)->count();
        return view ("admin.home",["user_requests" =>$user_requests]);
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
        return redirect(route("admin.user_requests"))->with("success","user approved");
    }
}
