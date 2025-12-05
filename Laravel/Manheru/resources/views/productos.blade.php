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
            <a href="{{ route('contacto') }}">Contacto</a>
            
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

        @if($productos->count() > 0)
            <div class="productos-grid" id="productos-grid">
                @foreach($productos as $producto)
                    <div class="producto-card" data-nombre="{{ strtolower($producto->Nombre) }}">
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
                        
                        <!-- Añadir precio del producto (necesitarás agregar este campo a la base de datos) -->
                        <div class="producto-precio">
                            ${{ number_format($producto->Precio ?? 0, 2) }} MXN
                        </div>
                        
                        <p class="producto-descripcion">
                            {{-- Descripción del producto --}}
                            {{ $producto->Descripcion ?? 'Producto de calidad para tu espacio de trabajo.' }}
                        </p>
                        
                        <div class="producto-codigo">
                            Código: {{ $producto->ID_Producto }}
                        </div>
                        
                        <div class="producto-acciones">
                            <button class="btn-informacion" onclick="verDetalleProducto({{ $producto->ID_Producto }})">
                                <i class="fas fa-info-circle"></i> Información
                            </button>
                            
                            @if($producto->Estatus)
                                <button class="btn-agregar-carrito" 
                                        data-producto-id="{{ $producto->ID_Producto }}"
                                        data-producto-nombre="{{ $producto->Nombre }}"
                                        data-producto-precio="{{ $producto->Precio ?? 0 }}">
                                    <i class="fas fa-cart-plus"></i> Agregar al carrito
                                </button>
                                
                                <button class="btn-favorito" data-producto-id="{{ $producto->ID_Producto }}">
                                    <i class="far fa-heart"></i> Favorito
                                </button>
                            @else
                                <button class="btn-agotado" disabled>
                                    <i class="fas fa-times-circle"></i> Agotado
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-productos">
                <i class="fas fa-box-open fa-3x"></i>
                <p>No hay productos disponibles en este momento.</p>
            </div>
        @endif

        <div class="explorar-opciones">
            <button class="btn-explorar" onclick="window.location.href='#productos-grid'">
                <i class="fas fa-arrow-down"></i> Explorar más opciones
            </button>
        </div>
    </main>

    <!-- Modal de confirmación -->
    <div class="modal" id="modal-confirmacion">
        <div class="modal-contenido">
            <span class="modal-cerrar">&times;</span>
            <h3 id="modal-titulo"></h3>
            <p id="modal-mensaje"></p>
            <div class="modal-acciones">
                <button class="btn-modal-cancelar">Cancelar</button>
                <button class="btn-modal-confirmar">Confirmar</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown del perfil
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

            // Buscador de productos
            const buscadorInput = document.getElementById('buscador-productos');
            const productosGrid = document.getElementById('productos-grid');
            
            buscadorInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const productos = productosGrid.querySelectorAll('.producto-card');
                
                productos.forEach(producto => {
                    const nombre = producto.getAttribute('data-nombre');
                    if (nombre.includes(searchTerm)) {
                        producto.style.display = 'block';
                    } else {
                        producto.style.display = 'none';
                    }
                });
            });

            // Agregar al carrito
            const botonesAgregar = document.querySelectorAll('.btn-agregar-carrito');
            botonesAgregar.forEach(boton => {
                boton.addEventListener('click', function() {
                    const productoId = this.getAttribute('data-producto-id');
                    const productoNombre = this.getAttribute('data-producto-nombre');
                    const productoPrecio = this.getAttribute('data-producto-precio');
                    
                    agregarAlCarrito(productoId, productoNombre, productoPrecio);
                });
            });

            // Agregar a favoritos
            const botonesFavorito = document.querySelectorAll('.btn-favorito');
            botonesFavorito.forEach(boton => {
                boton.addEventListener('click', function() {
                    const productoId = this.getAttribute('data-producto-id');
                    const icono = this.querySelector('i');
                    
                    if (icono.classList.contains('far')) {
                        icono.classList.remove('far');
                        icono.classList.add('fas');
                        this.style.color = '#8b0000';
                        agregarAFavoritos(productoId);
                    } else {
                        icono.classList.remove('fas');
                        icono.classList.add('far');
                        this.style.color = '';
                        eliminarDeFavoritos(productoId);
                    }
                });
            });

            // Modal
            const modal = document.getElementById('modal-confirmacion');
            const btnCerrar = document.querySelector('.modal-cerrar');
            const btnCancelar = document.querySelector('.btn-modal-cancelar');
            
            if (btnCerrar) {
                btnCerrar.onclick = function() {
                    modal.style.display = 'none';
                }
            }
            
            if (btnCancelar) {
                btnCancelar.onclick = function() {
                    modal.style.display = 'none';
                }
            }
            
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        });

        function agregarAlCarrito(productoId, productoNombre, productoPrecio) {
            fetch('{{ route("carrito.agregar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    producto_id: productoId,
                    cantidad: 1,
                    nombre: productoNombre,
                    precio: productoPrecio
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar contador del carrito
                    document.getElementById('carrito-contador').textContent = data.carrito_count;
                    
                    // Mostrar mensaje de éxito
                    mostrarModal('¡Producto agregado!', 'El producto se ha añadido al carrito correctamente.');
                    
                    // Opcional: Mostrar notificación
                    mostrarNotificacion('Producto agregado al carrito', 'success');
                } else {
                    mostrarModal('Error', 'No se pudo agregar el producto al carrito.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarModal('Error', 'Ocurrió un error al procesar la solicitud.');
            });
        }

        function agregarAFavoritos(productoId) {
            fetch('{{ route("favoritos.agregar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    producto_id: productoId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarNotificacion('Producto agregado a favoritos', 'success');
                }
            });
        }

        function eliminarDeFavoritos(productoId) {
            fetch('{{ route("favoritos.eliminar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    producto_id: productoId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarNotificacion('Producto eliminado de favoritos', 'info');
                }
            });
        }

        function mostrarModal(titulo, mensaje) {
            document.getElementById('modal-titulo').textContent = titulo;
            document.getElementById('modal-mensaje').textContent = mensaje;
            document.getElementById('modal-confirmacion').style.display = 'block';
        }

        function mostrarNotificacion(mensaje, tipo) {
            // Crear elemento de notificación
            const notificacion = document.createElement('div');
            notificacion.className = `notificacion notificacion-${tipo}`;
            notificacion.innerHTML = `
                <span>${mensaje}</span>
                <button onclick="this.parentElement.remove()">&times;</button>
            `;
            
            document.body.appendChild(notificacion);
            
            // Remover después de 3 segundos
            setTimeout(() => {
                if (notificacion.parentElement) {
                    notificacion.remove();
                }
            }, 3000);
        }

        function verDetalleProducto(productoId) {
            // Aquí puedes implementar la vista de detalle del producto
            alert('Detalle del producto #' + productoId);
            // window.location.href = `/productos/${productoId}`;
        }
    </script>
</body>
</html>