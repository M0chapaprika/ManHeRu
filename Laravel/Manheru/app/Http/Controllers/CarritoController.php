<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;

class CarritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.session');
    }

    public function index()
    {
        $carrito = session('carrito', [
            'items' => [],
            'subtotal' => 0,
            'envio' => 0,
            'impuestos' => 0,
            'total' => 0
        ]);
        
        $usuario = session('usuario');
        return view('carrito', compact('carrito', 'usuario'));
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
            'nombre' => 'required|string',
            'precio' => 'required|numeric|min:0'
        ]);

        $productoId = $request->producto_id;
        $cantidad = $request->cantidad;
        $nombre = $request->nombre;
        $precio = $request->precio;

        $carrito = session('carrito', [
            'items' => [],
            'subtotal' => 0,
            'envio' => 0,
            'impuestos' => 0,
            'total' => 0
        ]);

        // Verificar si el producto ya está en el carrito
        if (isset($carrito['items'][$productoId])) {
            $carrito['items'][$productoId]['cantidad'] += $cantidad;
        } else {
            $carrito['items'][$productoId] = [
                'id' => $productoId,
                'nombre' => $nombre,
                'precio' => $precio,
                'cantidad' => $cantidad
            ];
        }

        // Calcular totales
        $carrito = $this->calcularTotales($carrito);
        
        // Guardar en sesión
        session(['carrito' => $carrito]);
        session(['carrito_count' => count($carrito['items'])]);

        return response()->json([
            'success' => true,
            'carrito_count' => session('carrito_count'),
            'message' => 'Producto agregado al carrito'
        ]);
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer|min:1'
        ]);

        $productoId = $request->producto_id;
        $cantidad = $request->cantidad;

        $carrito = session('carrito', [
            'items' => [],
            'subtotal' => 0,
            'envio' => 0,
            'impuestos' => 0,
            'total' => 0
        ]);

        if (isset($carrito['items'][$productoId])) {
            $carrito['items'][$productoId]['cantidad'] = $cantidad;
            
            // Calcular totales
            $carrito = $this->calcularTotales($carrito);
            
            // Guardar en sesión
            session(['carrito' => $carrito]);
            
            // Calcular subtotal del producto
            $subtotalProducto = $carrito['items'][$productoId]['precio'] * $cantidad;

            return response()->json([
                'success' => true,
                'subtotal_producto' => $subtotalProducto,
                'subtotal' => $carrito['subtotal'],
                'impuestos' => $carrito['impuestos'],
                'total' => $carrito['total'],
                'carrito_count' => count($carrito['items'])
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Producto no encontrado en el carrito'
        ]);
    }

    public function eliminar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|integer'
        ]);

        $productoId = $request->producto_id;
        $carrito = session('carrito', [
            'items' => [],
            'subtotal' => 0,
            'envio' => 0,
            'impuestos' => 0,
            'total' => 0
        ]);

        if (isset($carrito['items'][$productoId])) {
            unset($carrito['items'][$productoId]);
            
            // Calcular totales
            $carrito = $this->calcularTotales($carrito);
            
            // Guardar en sesión
            session(['carrito' => $carrito]);
            session(['carrito_count' => count($carrito['items'])]);

            return response()->json([
                'success' => true,
                'subtotal' => $carrito['subtotal'],
                'impuestos' => $carrito['impuestos'],
                'total' => $carrito['total'],
                'carrito_count' => session('carrito_count')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Producto no encontrado en el carrito'
        ]);
    }

    public function guardarUbicacion(Request $request)
    {
        $request->validate([
            'ubicacion' => 'required|string|min:5'
        ]);

        $ubicacion = $request->ubicacion;
        session(['ubicacion_entrega' => $ubicacion]);

        // Verificar si es Querétaro
        $esQueretaro = stripos($ubicacion, 'querétaro') !== false || 
                      stripos($ubicacion, 'qro') !== false ||
                      stripos($ubicacion, 'queretaro') !== false;

        return response()->json([
            'success' => true,
            'es_queretaro' => $esQueretaro,
            'message' => 'Ubicación guardada correctamente'
        ]);
    }

    public function procesarPago(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required|in:transferencia,mercadopago',
            'opcion_entrega' => 'required|in:bodega,domicilio'
        ]);

        $carrito = session('carrito', []);
        $usuario = session('usuario');

        if (empty($carrito['items'])) {
            return response()->json([
                'success' => false,
                'message' => 'El carrito está vacío'
            ]);
        }

        // Generar número de pedido
        $numeroPedido = 'PED-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // Calcular costo de envío
        $costoEnvio = $request->opcion_entrega === 'domicilio' ? 150 : 0;

        // Crear pedido
        $pedido = [
            'numero_pedido' => $numeroPedido,
            'usuario_id' => $usuario->ID_Usuario,
            'usuario_nombre' => $usuario->Nombre,
            'usuario_email' => $usuario->Gmail,
            'fecha' => date('Y-m-d H:i:s'),
            'items' => $carrito['items'],
            'subtotal' => $carrito['subtotal'],
            'envio' => $costoEnvio,
            'impuestos' => $carrito['impuestos'],
            'total' => $carrito['subtotal'] + $costoEnvio + $carrito['impuestos'],
            'metodo_pago' => $request->metodo_pago,
            'opcion_entrega' => $request->opcion_entrega,
            'ubicacion_entrega' => session('ubicacion_entrega', ''),
            'estado' => 'pendiente',
            'comprobante_generado' => false
        ];

        // Guardar pedido en sesión (en una aplicación real, se guardaría en BD)
        $pedidos = session('pedidos', []);
        $pedidos[$numeroPedido] = $pedido;
        session(['pedidos' => $pedidos]);

        // Vaciar carrito
        session()->forget('carrito');
        session()->forget('carrito_count');

        // Generar respuesta según método de pago
        if ($request->metodo_pago === 'transferencia') {
            $mensaje = "Pedido #{$numeroPedido} creado. Por favor, realiza la transferencia.";
            $tipo = 'transferencia';
        } else {
            $mensaje = "Pedido #{$numeroPedido} creado. Redirigiendo a Mercado Pago...";
            $tipo = 'mercadopago';
        }

        return response()->json([
            'success' => true,
            'pedido_numero' => $numeroPedido,
            'mensaje' => $mensaje,
            'tipo_pago' => $tipo
        ]);
    }

    public function descargarComprobante($id)
    {
        $pedidos = session('pedidos', []);
        
        if (!isset($pedidos[$id])) {
            return redirect()->route('perfil.pedidos')
                ->with('error', 'Pedido no encontrado');
        }

        $pedido = $pedidos[$id];
        
        // Aquí implementarías la generación del PDF
        // Por ahora, redireccionamos a una vista de comprobante
        return view('comprobante', compact('pedido'));
    }

    private function calcularTotales($carrito)
    {
        $subtotal = 0;
        
        foreach ($carrito['items'] as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }
        
        $impuestos = $subtotal * 0.16; // 16% de IVA
        
        $carrito['subtotal'] = $subtotal;
        $carrito['impuestos'] = $impuestos;
        $carrito['total'] = $subtotal + $impuestos;
        
        return $carrito;
    }
}