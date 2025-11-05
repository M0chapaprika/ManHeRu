<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManHeRu - Mobiliario para Empresas</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <img src="{{ asset('images/Logo.jpg') }}" alt="Logo ManHeRu">
            <span class="nombre">ManHeRu</span>
        </div>

        <nav class="menu">
            <a href="#">Acerca de</a>
            <a href="#">Productos</a>
            <a href="#">Cotizaciones</a>
            <a href="#">Contacto</a>
            <a href="{{ route('login') }}">Iniciar Sesion</a>
        </nav>

        <div class="icono-info">
            <button class="btn-info">
                <i>ℹ️</i>
                <span class="arrow">▼</span>
            </button>
        </div>
    </header>

    <main class="contenido">
        <section class="texto-principal">
            <h1>Mobiliario Para <br>Empresas</h1>
            <p>
                Creamos espacios de trabajo funcionales y modernos,<br>
                adaptados a las necesidades de tu empresa.
            </p>
            <button class="btn-catalogo">Ver catálogo</button>
        </section>
    </main>
</body>
</html>
