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
}
