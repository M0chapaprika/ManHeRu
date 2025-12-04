<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - ManHeRu</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
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
                        <a href="{{ route('logout') }}">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </div>
                </div>
            @endif
        </nav>
    </header>

    <main class="perfil-container">
        <div class="perfil-header">
            <h1><i class="fas fa-user-circle"></i> Mi Perfil</h1>
            <a href="{{ route('inicio') }}" class="btn-volver">
                <i class="fas fa-arrow-left"></i> Volver al inicio
            </a>
        </div>

        <div class="perfil-info">
            <div class="info-card">
                <h2><i class="fas fa-info-circle"></i> Información Personal</h2>
                <div class="info-item">
                    <strong>Nombre:</strong> {{ $usuario->Nombre }}
                </div>
                <div class="info-item">
                    <strong>Email:</strong> {{ $usuario->Gmail }}
                </div>
                <div class="info-item">
                    <strong>Teléfono:</strong> {{ $usuario->Telefono }}
                </div>
                <div class="info-item">
                    <strong>Rol:</strong> 
                    @if($usuario->ID_Rol == 1)
                        <span class="badge-admin">Administrador</span>
                    @elseif($usuario->ID_Rol == 2)
                        <span class="badge-user">Usuario</span>
                    @else
                        <span class="badge-guest">Invitado</span>
                    @endif
                </div>
                <div class="info-item">
                    <strong>Estado:</strong> 
                    @if($usuario->Estatus == 1)
                        <span style="color: green;"><i class="fas fa-check-circle"></i> Activo</span>
                    @else
                        <span style="color: red;"><i class="fas fa-times-circle"></i> Inactivo</span>
                    @endif
                </div>
            </div>

            <div class="pedidos-card">
                <h2><i class="fas fa-history"></i> Resumen de Pedidos</h2>
                <div class="stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $totalPedidos }}</span>
                        <span class="stat-label">Pedidos Totales</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $pedidosPendientes }}</span>
                        <span class="stat-label">Pendientes</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $pedidosCompletados }}</span>
                        <span class="stat-label">Completados</span>
                    </div>
                </div>
                <a href="{{ route('perfil.pedidos') }}" class="btn-ver-pedidos">
                    <i class="fas fa-list"></i> Ver todos mis pedidos
                </a>
            </div>
        </div>

        <div class="pedidos-card">
            <h2><i class="fas fa-shopping-bag"></i> Mis Pedidos Recientes</h2>
            
            @if($pedidos->count() > 0)
                <table class="pedidos-table">
                    <thead>
                        <tr>
                            <th># Pedido</th>
                            <th>Fecha</th>
                            <th>Productos</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                        <tr>
                            <td>#{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $pedido->productos_count }} productos</td>
                            <td>${{ number_format($pedido->total, 2) }}</td>
                            <td>
                                <span class="estado-pedido estado-{{ $pedido->estado }}">
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn-accion btn-ver" onclick="verDetalle({{ $pedido->id }})">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                                @if($pedido->estado == 'completado')
                                <button class="btn-accion btn-descargar">
                                    <i class="fas fa-download"></i> Factura
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-pedidos">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>No tienes pedidos realizados</h3>
                    <p>¡Comienza a comprar en nuestro catálogo!</p>
                    <a href="{{ route('productos.index') }}" class="btn-catalogo">
                        <i class="fas fa-store"></i> Ver catálogo
                    </a>
                </div>
            @endif
        </div>
    </main>

    <script>
        // Script para el dropdown del perfil
        document.addEventListener('DOMContentLoaded', function() {
            const profileBtn = document.querySelector('.profile-btn');
            if (profileBtn) {
                profileBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const dropdown = this.nextElementSibling;
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                });
                
                document.addEventListener('click', function() {
                    const dropdowns = document.querySelectorAll('.dropdown-content');
                    dropdowns.forEach(dropdown => {
                        dropdown.style.display = 'none';
                    });
                });
            }
        });

        function verDetalle(pedidoId) {
            // Aquí puedes implementar la lógica para ver el detalle del pedido
            alert('Mostrando detalles del pedido #' + pedidoId);
            // En una implementación real, esto podría abrir un modal o redirigir a otra página
        }
    </script>
</body>
</html>