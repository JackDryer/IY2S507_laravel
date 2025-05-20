<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showRegister (){
        $departments = Department::All();
        return view ("auth.register",["departments"=>$departments]);
    }

    public function showLogin (){
        return view ("auth.login");
    }

    public function register (Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'employee_num' => 'required|digits_between:4,10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'department_id'=> 'required|exists:departments,id'
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
            function (User $user) {return $user->status === "active";}
        )){
            $request->session()->regenerate();
            if (Auth::user()->is_admin){
                return redirect()->route("admin.home");
            }
            return redirect()->route("home");
        }
        throw ValidationException::withMessages([
            'credentials'=>'Sorry, incorrect credentials or the user has not been approved'
        ]);
    }
    
    public function showProfile()
    {
        $departments = Department::All();
        $user = Auth::user();
        return view('auth.profile', [
            'user' => $user,
            'departments' => $departments
        ]);
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'employee_num' => 'required|digits_between:4,10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'password' => [
                'nullable',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);
        
        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
        

        $user->fill($validated);
        $user->save();
        
        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }
    
    public function logout (Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
