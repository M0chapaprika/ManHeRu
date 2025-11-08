<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Helpers\AlertHelper;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Si ya está autenticado, redirigir a inicio
        if (session()->has('usuario')) {
            AlertHelper::info('Ya tienes una sesión activa');
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
            AlertHelper::success('Sesión iniciada');
            return redirect()->route('inicio');
        }

        // Login fallido
        AlertHelper::error('Credenciales incorrectas');
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

    public function logout()
    {
        session()->forget('usuario');
        AlertHelper::success('Sesión cerrada con éxito');
        return redirect()->route('inicio');
    }
}