<?php
// app/Http\Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

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
     * Procesar el login - ADAPTADO PARA TU ESTRUCTURA
     */
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $credentials = $request->validate([
            'email' => ['required', 'email', 'string'], // Campo 'email' en el formulario
            'password' => ['required', 'string', 'min:6'],
        ]);

        // Buscar usuario por Gmail (que es nuestro email)
        $user = User::where('Gmail', $credentials['email'])->first();

        // Verificar si el usuario existe y la contraseña es correcta
        if ($user && Hash::check($credentials['password'], $user->Contrasena)) {
            // Verificar si el usuario está activo
            if ($user->Estatus != 1) {
                return back()->withErrors([
                    'email' => 'Tu cuenta está desactivada. Contacta al administrador.',
                ])->onlyInput('email');
            }

            // Iniciar sesión manualmente
            Auth::login($user, $request->boolean('remember'));

            // Regenerar sesión para prevenir fijación de sesión
            $request->session()->regenerate();
            
            // Redirigir al dashboard
            return redirect()->intended('/');
        }

        // Si la autenticación falla
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegister()
    {
        return view('registro');
    }

    /**
     * Procesar el registro - ADAPTADO PARA TU ESTRUCTURA
     */
    public function register(Request $request)
    {
        // Validar datos del registro
        $validated = $request->validate([
            'Nombre' => ['required', 'string', 'max:100'],
            'Gmail' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,Gmail'],
            'Contrasena' => ['required', 'string', 'min:6', 'confirmed'],
            'Telefono' => ['required', 'string', 'max:20'],
            'ID_Rol' => ['nullable', 'integer'],
        ]);

        // Crear el usuario con la estructura correcta
        $user = User::create([
            'Nombre' => $validated['Nombre'],
            'Gmail' => $validated['Gmail'],
            'Contrasena' => Hash::make($validated['Contrasena']),
            'Telefono' => $validated['Telefono'],
            'Estatus' => 1, // Activo por defecto
            'ID_Rol' => $validated['ID_Rol'] ?? 2, // Rol por defecto (2 = usuario normal)
        ]);

        // Autenticar al usuario después del registro
        Auth::login($user);

        // Redirigir al dashboard
        return redirect('/')->with('success', '¡Cuenta creada exitosamente!');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    /**
     * Mostrar dashboard (protegido)
     */
    public function dashboard()
    {
        return view('dashboard');
    }
}