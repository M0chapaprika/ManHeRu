<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Helpers\AlertHelper;

class UsuarioController extends Controller
{
    public function index()
    {
        // Verificar que el usuario sea administrador
        if (!session()->has('usuario') || session('usuario')->ID_Rol != 1) {
            AlertHelper::error('No tienes permisos para acceder a esta sección');
            return redirect()->route('inicio');
        }

        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        if (!session()->has('usuario') || session('usuario')->ID_Rol != 1) {
            AlertHelper::error('No tienes permisos para acceder a esta sección');
            return redirect()->route('inicio');
        }

        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        if (!session()->has('usuario') || session('usuario')->ID_Rol != 1) {
            AlertHelper::error('No tienes permisos para realizar esta acción');
            return redirect()->route('inicio');
        }

        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Gmail' => 'required|email|unique:Usuarios,Gmail',
            'Contrasena' => 'required|string|min:6',
            'Telefono' => 'required|string|max:20',
            'ID_Rol' => 'required|integer|between:1,3'
        ]);

        Usuario::create([
            'Nombre' => $request->Nombre,
            'Gmail' => $request->Gmail,
            'Contrasena' => $request->Contrasena, // En texto plano según tu configuración
            'Telefono' => $request->Telefono,
            'ID_Rol' => $request->ID_Rol,
            'Estatus' => 1,
            'ID_Direccion' => null
        ]);

        AlertHelper::success('Usuario creado exitosamente');
        return redirect()->route('usuarios.index');
    }

    public function edit($id)
    {
        if (!session()->has('usuario') || session('usuario')->ID_Rol != 1) {
            AlertHelper::error('No tienes permisos para acceder a esta sección');
            return redirect()->route('inicio');
        }

        $usuario = Usuario::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        if (!session()->has('usuario') || session('usuario')->ID_Rol != 1) {
            AlertHelper::error('No tienes permisos para realizar esta acción');
            return redirect()->route('inicio');
        }

        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Gmail' => 'required|email|unique:Usuarios,Gmail,' . $usuario->ID_Usuario . ',ID_Usuario',
            'Telefono' => 'required|string|max:20',
            'ID_Rol' => 'required|integer|between:1,3'
        ]);

        $usuario->update([
            'Nombre' => $request->Nombre,
            'Gmail' => $request->Gmail,
            'Telefono' => $request->Telefono,
            'ID_Rol' => $request->ID_Rol
        ]);

        AlertHelper::success('Usuario actualizado exitosamente');
        return redirect()->route('usuarios.index');
    }

    public function destroy($id)
    {
        if (!session()->has('usuario') || session('usuario')->ID_Rol != 1) {
            AlertHelper::error('No tienes permisos para realizar esta acción');
            return redirect()->route('inicio');
        }

        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        AlertHelper::success('Usuario eliminado exitosamente');
        return redirect()->route('usuarios.index');
    }
}