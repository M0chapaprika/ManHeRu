<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - ManHeRu</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carrito.css') }}">
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
                        <a href="{{ route('favoritos') }}">
                            <i class="fas fa-heart"></i> Mis Favoritos
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

    <main class="carrito-container">
        <div class="carrito-header">
            <h1><i class="fas fa-shopping-cart"></i> Carrito de Compras</h1>
            <a href="{{ route('productos.index') }}" class="btn-regresar">
                <i class="fas fa-arrow-left"></i> Seguir comprando
            </a>
        </div>

        @if(!empty($carrito) && count($carrito['items']) > 0)
            <div class="carrito-contenido">
                <!-- Lista de productos -->
                <div class="carrito-items">
                    <table class="carrito-tabla">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carrito['items'] as $id => $item)
                                <tr data-producto-id="{{ $id }}">
                                    <td>
                                        <div class="producto-info">
                                            <div class="producto-imagen">
                                                <i class="fas fa-couch"></i>
                                            </div>
                                            <div class="producto-detalle">
                                                <h4>{{ $item['nombre'] }}</h4>
                                                <p>Código: {{ $id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item['precio'], 2) }} MXN</td>
                                    <td>
                                        <div class="cantidad-control">
                                            <button class="btn-cantidad btn-disminuir" 
                                                    data-producto-id="{{ $id }}">-</button>
                                            <input type="number" 
                                                   class="cantidad-input" 
                                                   value="{{ $item['cantidad'] }}" 
                                                   min="1" 
                                                   data-producto-id="{{ $id }}">
                                            <button class="btn-cantidad btn-aumentar" 
                                                    data-producto-id="{{ $id }}">+</button>
                                        </div>
                                    </td>
                                    <td class="subtotal" data-producto-id="{{ $id }}">
                                        ${{ number_format($item['precio'] * $item['cantidad'], 2) }} MXN
                                    </td>
                                    <td>
                                        <button class="btn-eliminar" data-producto-id="{{ $id }}">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Resumen del pedido -->
                <div class="carrito-resumen">
                    <h2>Resumen del Pedido</h2>
                    
                    <div class="resumen-detalle">
                        <div class="resumen-fila">
                            <span>Subtotal:</span>
                            <span id="subtotal-total">${{ number_format($carrito['subtotal'], 2) }} MXN</span>
                        </div>
                        <div class="resumen-fila">
                            <span>Envío:</span>
                            <span id="envio-costo">${{ number_format($carrito['envio'], 2) }} MXN</span>
                        </div>
                        <div class="resumen-fila">
                            <span>Impuestos (16%):</span>
                            <span id="impuestos-total">${{ number_format($carrito['impuestos'], 2) }} MXN</span>
                        </div>
                        <div class="resumen-fila total">
                            <span>Total:</span>
                            <span id="total-pedido">${{ number_format($carrito['total'], 2) }} MXN</span>
                        </div>
                    </div>

                    <!-- Ubicación de entrega -->
                    <div class="ubicacion-entrega">
                        <h3><i class="fas fa-map-marker-alt"></i> Ubicación de entrega</h3>
                        <div class="form-ubicacion">
                            <input type="text" 
                                   id="input-ubicacion" 
                                   placeholder="Ingresa tu dirección completa"
                                   value="{{ session('ubicacion_entrega', '') }}">
                            <button type="button" id="btn-guardar-ubicacion" class="btn-guardar-ubicacion">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                        </div>
                        <div class="mensaje-ubicacion" id="mensaje-ubicacion"></div>
                    </div>

                    <!-- Opciones de entrega (solo si es Querétaro) -->
                    <div class="opciones-entrega" id="opciones-entrega" style="display: none;">
                        <h3><i class="fas fa-truck"></i> Opciones de entrega</h3>
                        <div class="opciones-radio">
                            <label>
                                <input type="radio" name="opcion-entrega" value="bodega" checked>
                                <i class="fas fa-warehouse"></i> Recoger en bodega
                                <span style="color: #666; font-size: 0.9rem;"> (Gratis)</span>
                            </label>
                            <label>
                                <input type="radio" name="opcion-entrega" value="domicilio">
                                <i class="fas fa-home"></i> Entrega a domicilio
                                <span style="color: #666; font-size: 0.9rem;"> (+$150.00 MXN)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Métodos de pago -->
                    <div class="metodos-pago">
                        <h3><i class="fas fa-credit-card"></i> Método de pago</h3>
                        <div class="opciones-pago">
                            <div class="pago-opcion" data-metodo="transferencia">
                                <label>
                                    <input type="radio" name="metodo-pago" value="transferencia" checked>
                                    <div class="pago-icono">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <div>
                                        <strong>Transferencia bancaria</strong>
                                        <p style="font-size: 0.9rem; color: #666;">BBVA, Santander, Banorte</p>
                                    </div>
                                </label>
                            </div>
                            <div class="pago-opcion" data-metodo="mercadopago">
                                <label>
                                    <input type="radio" name="metodo-pago" value="mercadopago">
                                    <div class="pago-icono">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <div>
                                        <strong>Mercado Pago</strong>
                                        <p style="font-size: 0.9rem; color: #666;">Tarjeta de crédito/débito</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="carrito-acciones">
                        <button class="btn-regresar" onclick="window.history.back()">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </button>
                        <button class="btn-pagar" id="btn-proceder-pago">
                            <i class="fas fa-credit-card"></i> Proceder al pago
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="carrito-vacio">
                <i class="fas fa-shopping-cart"></i>
                <h2>Tu carrito está vacío</h2>
                <p>¡Agrega algunos productos para comenzar!</p>
                <a href="{{ route('productos.index') }}" class="btn-ver-productos">
                    <i class="fas fa-store"></i> Ver productos
                </a>
            </div>
        @endif
    </main>

    <!-- Modal de confirmación de pago -->
    <div class="modal" id="modal-pago">
        <div class="modal-contenido">
            <span class="modal-cerrar">&times;</span>
            <h3 id="modal-pago-titulo"></h3>
            <div id="modal-pago-contenido"></div>
            <div class="modal-acciones">
                <button class="btn-modal-cancelar">Cancelar</button>
                <button class="btn-modal-confirmar" id="btn-confirmar-pago">Confirmar</button>
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

            // Control de cantidad
            document.querySelectorAll('.btn-aumentar').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productoId = this.getAttribute('data-producto-id');
                    cambiarCantidad(productoId, 1);
                });
            });

            document.querySelectorAll('.btn-disminuir').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productoId = this.getAttribute('data-producto-id');
                    cambiarCantidad(productoId, -1);
                });
            });

            document.querySelectorAll('.cantidad-input').forEach(input => {
                input.addEventListener('change', function() {
                    const productoId = this.getAttribute('data-producto-id');
                    const nuevaCantidad = parseInt(this.value);
                    
                    if (nuevaCantidad >= 1) {
                        actualizarCantidad(productoId, nuevaCantidad);
                    } else {
                        this.value = 1;
                    }
                });
            });

            // Eliminar producto
            document.querySelectorAll('.btn-eliminar').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productoId = this.getAttribute('data-producto-id');
                    eliminarDelCarrito(productoId);
                });
            });

            // Guardar ubicación
            const btnGuardarUbicacion = document.getElementById('btn-guardar-ubicacion');
            if (btnGuardarUbicacion) {
                btnGuardarUbicacion.addEventListener('click', function() {
                    const ubicacion = document.getElementById('input-ubicacion').value.trim();
                    
                    if (!ubicacion) {
                        mostrarMensajeUbicacion('Por favor, ingresa una dirección válida.', 'error');
                        return;
                    }

                    guardarUbicacion(ubicacion);
                });
            }

            // Opciones de entrega
            const opcionesEntrega = document.querySelectorAll('input[name="opcion-entrega"]');
            opcionesEntrega.forEach(opcion => {
                opcion.addEventListener('change', function() {
                    if (this.value === 'domicilio') {
                        // Agregar costo de envío
                        calcularTotales(150);
                    } else {
                        // Sin costo de envío
                        calcularTotales(0);
                    }
                });
            });

            // Métodos de pago
            const opcionesPago = document.querySelectorAll('.pago-opcion');
            opcionesPago.forEach(opcion => {
                opcion.addEventListener('click', function() {
                    // Remover clase seleccionado de todas las opciones
                    opcionesPago.forEach(o => o.classList.remove('seleccionado'));
                    
                    // Agregar clase a la opción seleccionada
                    this.classList.add('seleccionado');
                    
                    // Marcar el radio button correspondiente
                    const radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;
                });
            });

            // Proceder al pago
            const btnProcederPago = document.getElementById('btn-proceder-pago');
            if (btnProcederPago) {
                btnProcederPago.addEventListener('click', function() {
                    procederAlPago();
                });
            }

            // Modal
            const modal = document.getElementById('modal-pago');
            const btnCerrar = modal.querySelector('.modal-cerrar');
            const btnCancelar = modal.querySelector('.btn-modal-cancelar');
            
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

        function cambiarCantidad(productoId, cambio) {
            const input = document.querySelector(`.cantidad-input[data-producto-id="${productoId}"]`);
            const nuevaCantidad = parseInt(input.value) + cambio;
            
            if (nuevaCantidad >= 1) {
                input.value = nuevaCantidad;
                actualizarCantidad(productoId, nuevaCantidad);
            }
        }

        function actualizarCantidad(productoId, cantidad) {
            fetch('{{ route("carrito.actualizar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    producto_id: productoId,
                    cantidad: cantidad
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar subtotal del producto
                    const subtotalElement = document.querySelector(`.subtotal[data-producto-id="${productoId}"]`);
                    subtotalElement.textContent = `$${data.subtotal_producto.toFixed(2)} MXN`;
                    
                    // Actualizar totales
                    actualizarTotales(data);
                    
                    // Actualizar contador del carrito
                    document.getElementById('carrito-contador').textContent = data.carrito_count;
                    
                    mostrarNotificacion('Cantidad actualizada', 'success');
                }
            });
        }

        function eliminarDelCarrito(productoId) {
            if (!confirm('¿Estás seguro de eliminar este producto del carrito?')) {
                return;
            }

            fetch('{{ route("carrito.eliminar") }}', {
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
                    // Eliminar fila de la tabla
                    const fila = document.querySelector(`tr[data-producto-id="${productoId}"]`);
                    fila.remove();
                    
                    // Actualizar totales
                    actualizarTotales(data);
                    
                    // Actualizar contador del carrito
                    document.getElementById('carrito-contador').textContent = data.carrito_count;
                    
                    mostrarNotificacion('Producto eliminado del carrito', 'success');
                    
                    // Si el carrito está vacío, recargar la página
                    if (data.carrito_count === 0) {
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                }
            });
        }

        function guardarUbicacion(ubicacion) {
            fetch('{{ route("carrito.guardar-ubicacion") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    ubicacion: ubicacion
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensajeUbicacion('Ubicación guardada correctamente', 'success');
                    
                    // Mostrar opciones de entrega si es Querétaro
                    if (data.es_queretaro) {
                        document.getElementById('opciones-entrega').style.display = 'block';
                    } else {
                        document.getElementById('opciones-entrega').style.display = 'none';
                    }
                } else {
                    mostrarMensajeUbicacion('Error al guardar la ubicación', 'error');
                }
            });
        }

        function actualizarTotales(data) {
            document.getElementById('subtotal-total').textContent = `$${data.subtotal.toFixed(2)} MXN`;
            document.getElementById('impuestos-total').textContent = `$${data.impuestos.toFixed(2)} MXN`;
            document.getElementById('total-pedido').textContent = `$${data.total.toFixed(2)} MXN`;
        }

        function calcularTotales(costoEnvio) {
            const subtotal = parseFloat(document.getElementById('subtotal-total').textContent.replace('$', '').replace(' MXN', ''));
            const envio = costoEnvio;
            const impuestos = (subtotal * 0.16);
            const total = subtotal + envio + impuestos;
            
            document.getElementById('envio-costo').textContent = `$${envio.toFixed(2)} MXN`;
            document.getElementById('impuestos-total').textContent = `$${impuestos.toFixed(2)} MXN`;
            document.getElementById('total-pedido').textContent = `$${total.toFixed(2)} MXN`;
        }

        function procederAlPago() {
            const metodoPago = document.querySelector('input[name="metodo-pago"]:checked').value;
            const modal = document.getElementById('modal-pago');
            
            if (metodoPago === 'transferencia') {
                document.getElementById('modal-pago-titulo').textContent = 'Pago por Transferencia';
                document.getElementById('modal-pago-contenido').innerHTML = `
                    <p>Por favor, realiza la transferencia a la siguiente cuenta:</p>
                    <div style="background-color: #f9f9f9; padding: 15px; border-radius: 4px; margin: 15px 0;">
                        <p><strong>Banco:</strong> BBVA</p>
                        <p><strong>Cuenta:</strong> 0123 4567 8901 2345</p>
                        <p><strong>CLABE:</strong> 012 180 01234567890 1</p>
                        <p><strong>Beneficiario:</strong> ManHeRu Mobiliario S.A. de C.V.</p>
                        <p><strong>Total a pagar:</strong> $${document.getElementById('total-pedido').textContent}</p>
                    </div>
                    <p>Una vez realizada la transferencia, envía el comprobante a: pagos@manheru.com</p>
                `;
            } else if (metodoPago === 'mercadopago') {
                document.getElementById('modal-pago-titulo').textContent = 'Pago con Mercado Pago';
                document.getElementById('modal-pago-contenido').innerHTML = `
                    <p>Serás redirigido a Mercado Pago para completar tu pago de forma segura.</p>
                    <div style="background-color: #f9f9f9; padding: 15px; border-radius: 4px; margin: 15px 0;">
                        <p><strong>Total a pagar:</strong> $${document.getElementById('total-pedido').textContent}</p>
                    </div>
                    <p>Al confirmar, se generará un link de pago único.</p>
                `;
            }
            
            modal.style.display = 'block';
        }

        function mostrarMensajeUbicacion(mensaje, tipo) {
            const mensajeElement = document.getElementById('mensaje-ubicacion');
            mensajeElement.textContent = mensaje;
            mensajeElement.style.color = tipo === 'success' ? 'green' : 'red';
        }

        function mostrarNotificacion(mensaje, tipo) {
            const notificacion = document.createElement('div');
            notificacion.className = `notificacion notificacion-${tipo}`;
            notificacion.innerHTML = `
                <span>${mensaje}</span>
                <button onclick="this.parentElement.remove()">&times;</button>
            `;
            
            document.body.appendChild(notificacion);
            
            setTimeout(() => {
                if (notificacion.parentElement) {
                    notificacion.remove();
                }
            }, 3000);
        }
    </script>
</body>
</html>