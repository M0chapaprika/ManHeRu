<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Si ya está autenticado, redirigir a inicio
        if (session()->has('usuario')) {
            return redirect()->route('inicio');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Buscar usuario por Gmail
        $usuario = Usuario::where('Gmail', $request->email)->first();

        if ($usuario && $request->password === $usuario->Contrasena) {
            // Login exitoso
            session(['usuario' => $usuario]);
            return redirect()->route('inicio');
        }

        // Login fallido
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

    public function logout()
    {
        // Limpiar toda la sesión
        session()->flush();
        // O específicamente: session()->forget('usuario');
        
        return redirect()->route('inicio');
    }
}