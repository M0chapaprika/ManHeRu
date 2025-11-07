<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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