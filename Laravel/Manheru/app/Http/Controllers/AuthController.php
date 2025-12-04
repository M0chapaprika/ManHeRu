<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buscar usuario por email
        $usuario = Usuario::where('Gmail', $request->email)->first();

        if ($usuario && password_verify($request->password, $usuario->Contrasena)) {
            // Guardar usuario en sesión
            session(['usuario' => $usuario]);
            
            return redirect()->route('inicio')
                ->with('success', '¡Bienvenido ' . $usuario->Nombre . '!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son válidas.',
        ]);
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegister()
    {
        return view('registro'); // Asegúrate de que retorna 'registro'
    }

    /**
     * Procesar registro de nuevo usuario
     */
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:Usuarios,Gmail',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        try {
            // Crear nuevo usuario
            $usuario = new Usuario();
            $usuario->Nombre = $request->nombre;
            $usuario->Gmail = $request->email;
            $usuario->Contrasena = password_hash($request->password, PASSWORD_DEFAULT);
            $usuario->ID_Rol = 2; // Rol de usuario normal por defecto
            $usuario->save();

            // Iniciar sesión automáticamente
            session(['usuario' => $usuario]);

            return redirect()->route('inicio')
                ->with('success', '¡Cuenta creada exitosamente! Bienvenido ' . $usuario->Nombre);

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al crear la cuenta. Por favor, intente nuevamente.',
            ]);
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        session()->forget('usuario');
        return redirect()->route('inicio')
            ->with('success', 'Sesión cerrada correctamente.');
    }
}