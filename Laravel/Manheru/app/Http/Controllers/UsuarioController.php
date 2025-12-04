<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;  // Cambiado de Usuario a User
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Verificar si el usuario actual es administrador
    private function esAdministrador()
    {
        return session()->has('usuario') && session('usuario')->ID_Rol == 1;
    }

    public function index()
    {
        // Verificar que el usuario sea administrador
        if (!$this->esAdministrador()) {
            return redirect()->route('inicio')
                ->with('error', 'No tienes permisos para acceder a esta sección');
        }

        $usuarios = User::all();  // Cambiado a User
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        if (!$this->esAdministrador()) {
            return redirect()->route('inicio')
                ->with('error', 'No tienes permisos para acceder a esta sección');
        }

        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        if (!$this->esAdministrador()) {
            return redirect()->route('inicio')
                ->with('error', 'No tienes permisos para realizar esta acción');
        }

        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Gmail' => 'required|email|unique:usuarios,Gmail',
            'Contrasena' => 'required|string|min:6',
            'Telefono' => 'required|string|max:20',
            'ID_Rol' => 'required|integer|between:1,3',
            'Estatus' => 'nullable|boolean'
        ]);

        User::create([  // Cambiado a User
            'Nombre' => $request->Nombre,
            'Gmail' => $request->Gmail,
            'Contrasena' => Hash::make($request->Contrasena),
            'Telefono' => $request->Telefono,
            'ID_Rol' => $request->ID_Rol,
            'Estatus' => $request->Estatus ?? 1,
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    public function edit($id)
    {
        if (!$this->esAdministrador()) {
            return redirect()->route('inicio')
                ->with('error', 'No tienes permisos para acceder a esta sección');
        }

        $usuario = User::findOrFail($id);  // Cambiado a User
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->esAdministrador()) {
            return redirect()->route('inicio')
                ->with('error', 'No tienes permisos para realizar esta acción');
        }

        $usuario = User::findOrFail($id);  // Cambiado a User

        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Gmail' => 'required|email|unique:usuarios,Gmail,' . $usuario->ID_Usuario . ',ID_Usuario',
            'Telefono' => 'required|string|max:20',
            'ID_Rol' => 'required|integer|between:1,3',
            'Estatus' => 'nullable|boolean'
        ]);

        $usuario->update([
            'Nombre' => $request->Nombre,
            'Gmail' => $request->Gmail,
            'Telefono' => $request->Telefono,
            'ID_Rol' => $request->ID_Rol,
            'Estatus' => $request->Estatus ?? $usuario->Estatus
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        if (!$this->esAdministrador()) {
            return redirect()->route('inicio')
                ->with('error', 'No tienes permisos para realizar esta acción');
        }

        $usuario = User::findOrFail($id);  // Cambiado a User
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}