<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FavoritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.session');
    }

    public function index()
    {
        $favoritos = session('favoritos', []);
        $usuario = session('usuario');
        
        return view('favoritos', compact('favoritos', 'usuario'));
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|integer'
        ]);

        $productoId = $request->producto_id;
        $favoritos = session('favoritos', []);

        if (!in_array($productoId, $favoritos)) {
            $favoritos[] = $productoId;
            session(['favoritos' => $favoritos]);
        }

        return response()->json([
            'success' => true,
            'favoritos_count' => count($favoritos),
            'message' => 'Producto agregado a favoritos'
        ]);
    }

    public function eliminar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|integer'
        ]);

        $productoId = $request->producto_id;
        $favoritos = session('favoritos', []);

        if (($key = array_search($productoId, $favoritos)) !== false) {
            unset($favoritos[$key]);
            $favoritos = array_values($favoritos); // Reindexar array
            session(['favoritos' => $favoritos]);
        }

        return response()->json([
            'success' => true,
            'favoritos_count' => count($favoritos),
            'message' => 'Producto eliminado de favoritos'
        ]);
    }
}