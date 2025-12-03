<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Tipo;

class ProductoController extends Controller
{
    public function index()
    {
        try {
            // Intentar obtener productos de la BD
            $productos = Producto::with('tipo')->get();
            
            // Si no hay productos, usar datos de ejemplo
            if ($productos->isEmpty()) {
                $productos = $this->getProductosEjemplo();
            }
            
        } catch (\Exception $e) {
            // Si hay error de conexión, usar datos de ejemplo
            \Log::error('Error al obtener productos: ' . $e->getMessage());
            $productos = $this->getProductosEjemplo();
        }
        
        return view('productos', compact('productos'));
    }
    
    /**
     * Datos de ejemplo cuando no hay conexión a BD
     */
    private function getProductosEjemplo()
    {
        // Datos de ejemplo estáticos
        return collect([
            (object)[
                'ID_Producto' => 1,
                'Nombre' => 'Escritorio mediano de madera de roble duro',
                'Estatus' => true,
                'ID_Tipo' => 1,
                'tipo' => (object)[
                    'ID_Tipo' => 1,
                    'Nombre' => 'Escritorio de oficina',  // Cambiado de 'Nombre_Tipo' a 'Nombre'
                    'Estatus' => true
                ]
            ],
            (object)[
                'ID_Producto' => 2,
                'Nombre' => 'Silla ortopédica cómoda con asiento acolchonado',
                'Estatus' => true,
                'ID_Tipo' => 2,
                'tipo' => (object)[
                    'ID_Tipo' => 2,
                    'Nombre' => 'Silla de oficina',  // Cambiado de 'Nombre_Tipo' a 'Nombre'
                    'Estatus' => true
                ]
            ],
            (object)[
                'ID_Producto' => 3,
                'Nombre' => 'Mesa de conferencias ejecutiva',
                'Estatus' => false,
                'ID_Tipo' => 3,
                'tipo' => (object)[
                    'ID_Tipo' => 3,
                    'Nombre' => 'Muebles de sala',  // Cambiado de 'Nombre_Tipo' a 'Nombre'
                    'Estatus' => true
                ]
            ]
        ]);
    }
}