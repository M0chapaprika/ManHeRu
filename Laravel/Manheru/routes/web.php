<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;

// Página de inicio - se adapta si hay usuario logueado o no
Route::get('/', function () {
    if (session()->has('usuario')) {
        $usuario = session('usuario');
        return view('Inicio', compact('usuario'));
    }
    return view('Inicio');
})->name('inicio');

// Mostrar formulario de login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');

// Procesar login (POST)
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Cerrar sesión
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// CRUD de Usuarios (solo para administradores)
Route::resource('usuarios', UsuarioController::class)->except(['show']);

// Página Acerca de
Route::get('/acerca', function () {
    return view('acerca');
})->name('acerca');

Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');