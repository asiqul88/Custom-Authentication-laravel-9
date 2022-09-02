<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(){

        return view('admin_views.auth.login');

    }

    public function login(Request $request){

        $request ->validate([
            
            'email' => 'required|email',
            'password' => 'required|min:6',

        ]);

        $data = $request->only('email','password');

        if (Auth::attempt($data)) {
            return redirect('dashboard');
        }

        return redirect()->route('admin.login')->with('error', 'Your data is not correct!!');
        
    }

    public function register_view(){

        return view('admin_views.auth.register');

        
    }

    public function register(Request $request){

        $request ->validate([

            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'

        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)

        ]);


        if (Auth::attempt($request->only('email','password'))) {
            return redirect('dashboard');
        }

        return redirect()->route('admin.login')->with('error', 'You are not registered yet!!');
        
    }

    public function dashboard(){

        if (Auth::check()) {
            return view('admin_views.dashboard');
        }

        return redirect()->route('admin.login')->with('error', 'You can not log in!!');
       
    }

    public function logout(){

        Session::flush();
        Auth::logout();

        return redirect()->route('admin.login')->with('error', 'You are successfully loged out!!');

        
    }
}
