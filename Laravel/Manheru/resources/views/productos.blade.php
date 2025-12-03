<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManHeRu - Productos</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
</head>
<body>
    <!-- INCLUIR COMPONENTE DE ALERTAS -->
    @include('components.alert')

    <header class="navbar">
        <div class="logo">
            <img src="{{ asset('images/Logo.jpg') }}" alt="Logo ManHeRu">
            <span class="nombre">ManHeRu</span>
        </div>

        <nav class="menu">
            <a href="{{ route('inicio') }}">Inicio</a>
            <a href="{{ route('acerca') }}">Acerca de</a>
            <a href="{{ route('productos.index') }}">Productos</a>
            <a href="#">Cotizaciones</a>
            <a href="#">Contacto</a>
            
            @if(session()->has('usuario'))
                @if(session('usuario')->ID_Rol == 1)
                    <a href="{{ route('usuarios.index') }}">Gestión de Usuarios</a>
                @endif
                <a href="{{ route('logout') }}">Cerrar Sesión</a>
            @else
                <a href="{{ route('login.form') }}">Iniciar Sesión</a>
            @endif
        </nav>
    </header>

    <main class="productos-container">
        <h1 class="titulo-principal">VARIEDAD DE MOBILIARIO PARA TODOS LOS ESPACIOS</h1>
        <p class="subtitulo">Productos más buscados en el mercado</p>

        @if($productos->count() > 0)
            <div class="productos-grid">
                @foreach($productos as $producto)
                    <div class="producto-card">
                        <div class="producto-imagen-placeholder">
                            <span>Sin imagen</span>
                        </div>
                        
                        <div class="producto-categoria">
                            {{ $producto->tipo ? $producto->tipo->Nombre : 'Sin categoría' }}
                        </div>
                        
                        <div class="disponibilidad {{ $producto->Estatus ? 'disponible' : 'no-disponible' }}">
                            {{ $producto->Estatus ? 'Disponible' : 'Agotado' }}
                        </div>
                        
                        <h3 class="producto-nombre">{{ $producto->Nombre }}</h3>
                        
                        <p class="producto-descripcion">
                            {{-- Ya que la tabla Tipos no tiene descripción, mostramos una genérica --}}
                            Producto de calidad para tu espacio de trabajo.
                        </p>
                        
                        <!-- Mostrar el ID del producto si necesitas -->
                        <div style="color: #666; font-size: 0.9rem; margin-bottom: 10px;">
                            Código: {{ $producto->ID_Producto }}
                        </div>
                        
                        <button class="btn-informacion">Información</button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-productos">
                <p>No hay productos disponibles en este momento.</p>
            </div>
        @endif

        <div class="explorar-opciones">
            <button class="btn-explorar">Explorar opciones</button>
        </div>
    </main>
</body>
</html>