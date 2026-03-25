<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function showLogin()
    {
        // Si ya está logueado, lo mandamos a los productos directamente
        if (Auth::check()) {
            return redirect()->route('productos.index');
        }
        return view('auth.login');
    }

    /**
     * Procesa el intento de login.
     */
    public function login(Request $request)
    {
        // Validamos que los datos tengan el formato correcto
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentamos iniciar sesión con las credenciales proporcionadas
        if (Auth::attempt($credentials)) {
            // Regeneramos la sesión por seguridad
            $request->session()->regenerate();
            // Redirigimos a la página que intentaba visitar o a productos
            return redirect()->intended('productos');
        }

        // Si las credenciales fallan, regresamos al formulario con un mensaje
        return back()->with('error', 'Las credenciales no coinciden con nuestros registros.');
    }

    /**
     * Cierra la sesión del usuario de forma segura.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidamos la sesión actual y regeneramos el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigimos al inicio (login)
        return redirect('/');
    }
}