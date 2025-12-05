<?php
// app/Http\Controllers/ProductoController.php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Mostrar todos los productos
     */
    public function index()
    {
        // Obtener todos los productos de la base de datos
        $productos = Producto::orderBy('created_at', 'desc')->get();
        
        return view('productos');
    }

    /**
     * Mostrar formulario para crear un nuevo producto
     */
    public function create()
    {
        // Verificar que el usuario sea administrador (el middleware también lo hace)
        return view('productos.create');
    }

    /**
     * Almacenar un nuevo producto en la base de datos
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'precio' => 'required|numeric|min:0',
            'disponible' => 'boolean'
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'categoria.required' => 'La categoría es obligatoria.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif.',
            'imagen.max' => 'La imagen no debe pesar más de 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Procesar la imagen si se subió
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagenPath = $imagen->storeAs('productos', $nombreImagen, 'public');
        }

        // Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'imagen' => $imagenPath,
            'precio' => $request->precio,
            'disponible' => $request->has('disponible') ? true : false
        ]);

        // Registrar actividad (opcional)
        \Log::info('Producto creado', [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'usuario' => auth()->user()->Nombre
        ]);

        return redirect()->route('productos.index')
            ->with('success', '¡Producto agregado exitosamente!');
    }

    /**
     * Mostrar un producto específico
     */
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    /**
     * Mostrar formulario para editar un producto
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualizar un producto en la base de datos
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'precio' => 'required|numeric|min:0',
            'disponible' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Procesar nueva imagen si se subió
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagenPath = $imagen->storeAs('productos.index', $nombreImagen, 'public');
            $producto->imagen = $imagenPath;
        }

        // Actualizar los demás campos
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->categoria = $request->categoria;
        $producto->precio = $request->precio;
        $producto->disponible = $request->has('disponible') ? true : false;
        $producto->save();

        return redirect()->route('productos.index')
            ->with('success', '¡Producto actualizado exitosamente!');
    }

    /**
     * Eliminar un producto
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        
        // Eliminar imagen si existe
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }
        
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', '¡Producto eliminado exitosamente!');
    }

    /**
     * Cambiar estado de disponibilidad
     */
    public function toggleDisponible($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->disponible = !$producto->disponible;
        $producto->save();

        $estado = $producto->disponible ? 'disponible' : 'no disponible';
        return redirect()->back()
            ->with('success', "Producto marcado como $estado");
    }
}