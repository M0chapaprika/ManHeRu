<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pedido; // Asume que tienes un modelo Pedido

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!session()->has('usuario')) {
                return redirect()->route('login.form')
                    ->with('error', 'Debes iniciar sesión para acceder a tu perfil');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $usuario = session('usuario');
        
        // Obtener pedidos del usuario (esto es un ejemplo, ajusta según tu modelo)
        $pedidos = $this->obtenerPedidosUsuario($usuario->ID_Usuario);
        
        // Estadísticas
        $totalPedidos = $pedidos->count();
        $pedidosPendientes = $pedidos->where('estado', 'pendiente')->count();
        $pedidosCompletados = $pedidos->where('estado', 'completado')->count();
        
        return view('perfil', compact('usuario', 'pedidos', 'totalPedidos', 'pedidosPendientes', 'pedidosCompletados'));
    }

    public function pedidos()
    {
        $usuario = session('usuario');
        $pedidos = $this->obtenerPedidosUsuario($usuario->ID_Usuario);
        
        return view('perfil.pedidos', compact('usuario', 'pedidos'));
    }

    public function verPedido($id)
    {
        $usuario = session('usuario');
        // Aquí obtendrías el pedido específico
        // $pedido = Pedido::where('ID_Usuario', $usuario->ID_Usuario)->findOrFail($id);
        
        // return view('perfil.detalle-pedido', compact('usuario', 'pedido'));
        
        // Por ahora, redirigimos a la lista de pedidos
        return redirect()->route('perfil.pedidos')
            ->with('info', 'Funcionalidad en desarrollo');
    }

    private function obtenerPedidosUsuario($userId)
    {
        // Esta es una función de ejemplo. Debes reemplazarla con tu lógica real
        // que obtenga los pedidos del usuario desde la base de datos
        
        // Ejemplo de datos de prueba
        return collect([
            (object)[
                'id' => 1,
                'fecha' => '2024-01-15',
                'productos_count' => 3,
                'total' => 1250.00,
                'estado' => 'completado'
            ],
            (object)[
                'id' => 2,
                'fecha' => '2024-02-10',
                'productos_count' => 2,
                'total' => 850.50,
                'estado' => 'procesando'
            ],
            (object)[
                'id' => 3,
                'fecha' => '2024-02-20',
                'productos_count' => 1,
                'total' => 450.00,
                'estado' => 'pendiente'
            ],
        ]);
    }
}