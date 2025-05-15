<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegister (){
        return view ("auth.register");
    }

    public function showLogin (){
        return view ("auth.login");
    }

    public function register (Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|',
            'password' => 'required|string|min:8|confirmed'
        ]);
        User::create($validated);
        return redirect()->route("home")->with('success',"User Created, please wait for approval form admin");
    }

    public function login (Request $request){
            $validated = $request->validate([
            'email'=> 'required|email|',
            'password' => 'required|string'
        ]);
        
        if (Auth::attemptWhen(
            $validated,
            function (User $user) {return $user->is_approved;}
        )){
            $request->session()->regenerate();
            return redirect()->route("home");
        }
        throw ValidationException::withMessages([
            'credentials'=>'Sorry, incorrect credentials or the user has not been approved'
        ]);
    }
    public function logout (Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
