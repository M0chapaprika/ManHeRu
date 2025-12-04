<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManHeRu - Mobiliario para empresas</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
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
            <a href="{{ route('acerca') }}">Acerca de</a>
            <a href="{{ route('productos.index') }}">Productos</a>
            <a href="{{ route('cotizaciones') }}">Cotizaciones</a>
            <a href="#">Contacto</a>
            
            @if(session()->has('usuario'))
                <!-- Mostrar opciones de administrador solo si tiene rol 1 -->
                @if(session('usuario')->ID_Rol == 1)
                    <a href="{{ route('usuarios.index') }}">Gestión de Usuarios</a>
                @endif
                
                <!-- Botón para perfil del usuario -->
                <div class="user-profile-dropdown">
                    <button class="profile-btn">
                        <i class="fas fa-user-circle"></i> Mi Perfil
                    </button>
                    <div class="dropdown-content">
                        <a href="{{ route('perfil') }}">
                            <i class="fas fa-user"></i> Ver Perfil
                        </a>
                        <a href="{{ route('perfil.pedidos') }}">
                            <i class="fas fa-shopping-bag"></i> Mis Pedidos
                        </a>
                        <a href="{{ route('logout') }}">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </div>
                </div>
            @else
                <!-- Mostrar cuando no hay sesión -->
                <a href="{{ route('login.form') }}">Iniciar Sesión</a>
            @endif
        </nav>
    </header>

    <main class="contenido">
        <section class="texto-principal">
            <h1>Mobiliario Para <br>Empresas</h1>
            <p>
                Creamos espacios de trabajo funcionales y modernos,<br>
                adaptados a las necesidades de tu empresa.
            </p>
            <button class="btn-catalogo">Ver catálogo</button>
            
            <!-- Mostrar información adicional si el usuario está logueado -->
            @if(session()->has('usuario'))
                <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px; border-left: 4px solid #8b0000;">
                    <h3 style="color: #8b0000; margin-bottom: 10px;">Sesión activa</h3>
                    <p style="margin: 5px 0;"><strong>Usuario:</strong> {{ session('usuario')->Nombre }}</p>
                    <p style="margin: 5px 0;"><strong>Email:</strong> {{ session('usuario')->Gmail }}</p>
                    <p style="margin: 5px 0;">
                        <strong>Rol:</strong> 
                        @if(session('usuario')->ID_Rol == 1)
                            Administrador
                        @elseif(session('usuario')->ID_Rol == 2)
                            Usuario
                        @else
                            Invitado
                        @endif
                    </p>
                    <a href="{{ route('perfil') }}" class="btn-perfil" style="display: inline-block; margin-top: 10px; padding: 8px 16px; background-color: #8b0000; color: white; text-decoration: none; border-radius: 4px;">
                        <i class="fas fa-user"></i> Ir a mi perfil
                    </a>
                </div>
            @endif
        </section>
    </main>

    <script>
        // JavaScript para el dropdown del perfil
        document.addEventListener('DOMContentLoaded', function() {
            const profileBtn = document.querySelector('.profile-btn');
            if (profileBtn) {
                profileBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const dropdown = this.nextElementSibling;
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                });
                
                // Cerrar dropdown al hacer clic fuera
                document.addEventListener('click', function() {
                    const dropdowns = document.querySelectorAll('.dropdown-content');
                    dropdowns.forEach(dropdown => {
                        dropdown.style.display = 'none';
                    });
                });
            }
        });
    </script>
</body>
</html>