<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManHeRu - Productos</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- INCLUIR COMPONENTE DE ALERTAS -->
    @include('components.alert')

    <header class="navbar">
        <div class="logo">
            <a href="{{ route('inicio') }}">
                <img src="{{ asset('images/Logo.jpg') }}" alt="Logo ManHeRu">
            </a>
            <span class="nombre">ManHeRu</span>
        </div>

        <nav class="menu">
            <a href="{{ route('inicio') }}">Inicio</a>
            <a href="{{ route('acerca') }}">Acerca de</a>
            <a href="{{ route('productos.index') }}">Productos</a>
            <a href="{{ route('cotizaciones') }}">Cotizaciones</a>
            <a href="#">Contacto</a>
            
            @if(session()->has('usuario'))
                @if(session('usuario')->ID_Rol == 1)
                    <a href="{{ route('usuarios.index') }}">Gestión de Usuarios</a>
                @endif
                
                <!-- Carrito de compras -->
                <a href="{{ route('carrito') }}" class="carrito-link" id="carrito-header">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="carrito-contador" id="carrito-contador">
                        {{ session('carrito_count', 0) }}
                    </span>
                </a>
                
                <!-- Dropdown del perfil -->
                <div class="user-profile-dropdown">
                    <button class="profile-btn">
                        <i class="fas fa-user-circle"></i> {{ session('usuario')->Nombre }}
                    </button>
                    <div class="dropdown-content">
                        <a href="{{ route('perfil') }}">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                        <a href="{{ route('perfil.pedidos') }}">
                            <i class="fas fa-shopping-bag"></i> Mis Pedidos
                        </a>
                        <a href="{{ route('carrito') }}">
                            <i class="fas fa-shopping-cart"></i> Mi Carrito
                        </a>
                        <a href="{{ route('logout') }}">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </div>
                </div>
            @else
                <a href="{{ route('login.form') }}">Iniciar Sesión</a>
            @endif
        </nav>
    </header>

    <main class="productos-container">
        <div class="productos-header">
            <h1 class="titulo-principal">VARIEDAD DE MOBILIARIO PARA TODOS LOS ESPACIOS</h1>
            <p class="subtitulo">Productos más buscados en el mercado</p>
            
            <!-- Barra de búsqueda -->
            <div class="buscador-container">
                <div class="buscador">
                    <input type="text" id="buscador-productos" placeholder="Buscar productos por nombre...">
                    <button type="button" id="btn-buscar">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif
@endauth