<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
   
    public function index() {
        return view('login');
    }

    
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
           
            return redirect()->intended('dashboard');
        }

       
        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    
    public function dashboard() {
        return view('dashboard');
    }

    
    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
