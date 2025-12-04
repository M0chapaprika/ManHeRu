<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\FavoritoController;

// Página de inicio
Route::get('/', function () {
    if (session()->has('usuario')) {
        $usuario = session('usuario');
        return view('Inicio', compact('usuario'));
    }
    return view('Inicio');
})->name('inicio');

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/registro', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/registro', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de perfil (protegidas)
Route::middleware(['auth.session'])->group(function () {
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::get('/perfil/pedidos', [PerfilController::class, 'pedidos'])->name('perfil.pedidos');
    Route::get('/perfil/pedido/{id}', [PerfilController::class, 'verPedido'])->name('perfil.pedido');
    
    // Carrito de compras
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/carrito/actualizar', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::post('/carrito/eliminar', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/guardar-ubicacion', [CarritoController::class, 'guardarUbicacion'])->name('carrito.guardar-ubicacion');
    Route::post('/carrito/procesar-pago', [CarritoController::class, 'procesarPago'])->name('carrito.procesar-pago');
    Route::get('/carrito/comprobante/{id}', [CarritoController::class, 'descargarComprobante'])->name('carrito.comprobante');
    
    // Favoritos
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos');
    Route::post('/favoritos/agregar', [FavoritoController::class, 'agregar'])->name('favoritos.agregar');
    Route::post('/favoritos/eliminar', [FavoritoController::class, 'eliminar'])->name('favoritos.eliminar');
});

// CRUD de Usuarios (solo para administradores)
Route::resource('usuarios', UsuarioController::class)->except(['show']);

// Otras rutas
Route::get('/acerca', function () {
    return view('acerca');
})->name('acerca');

Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/cotizaciones', function () {
    return view('cotizaciones');
})->name('cotizaciones');