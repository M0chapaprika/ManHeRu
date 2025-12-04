<!DOCTYPE html>
<!-- resources/views/productos/create.blade.php -->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto - ManHeRu</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
    <style>
        .form-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .form-title {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .form-check-input {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .form-check-label {
            cursor: pointer;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: transform 0.2s;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
        }
        
        .btn-back {
            display: inline-block;
            background: #95a5a6;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 20px;
            transition: background 0.3s;
        }
        
        .btn-back:hover {
            background: #7f8c8d;
        }
        
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 8px;
            display: none;
        }
        
        .image-preview-container {
            text-align: center;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 0.875rem;
            margin-top: 5px;
            display: block;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
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
            <a href="{{ route('productos.index') }}">Productos</a>
            <a href="{{ route('productos.create') }}" class="active">Agregar Producto</a>
            
            @auth
                @if(Auth::user()->ID_Rol == 1)
                    <a href="{{ route('admin.dashboard') }}">Panel Admin</a>
                @endif
                <a href="{{ route('logout') }}">Cerrar Sesión</a>
            @else
                <a href="{{ route('login') }}">Iniciar Sesión</a>
            @endauth
        </nav>
    </header>

    <main>
        <div class="form-container">
            <h1 class="form-title">Agregar Nuevo Producto</h1>
            
            @if($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre del Producto *</label>
                    <input type="text" id="nombre" name="nombre" 
                           class="form-control" 
                           value="{{ old('nombre') }}"
                           placeholder="Ej: Escritorio Ejecutivo de Madera"
                           required>
                    @error('nombre')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción *</label>
                    <textarea id="descripcion" name="descripcion" 
                              class="form-control" 
                              placeholder="Describe detalladamente el producto..."
                              required>{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="categoria" class="form-label">Categoría *</label>
                    <select id="categoria" name="categoria" class="form-control" required>
                        <option value="">Selecciona una categoría</option>
                        <option value="Escritorios" {{ old('categoria') == 'Escritorios' ? 'selected' : '' }}>Escritorios</option>
                        <option value="Sillas" {{ old('categoria') == 'Sillas' ? 'selected' : '' }}>Sillas</option>
                        <option value="Mesas" {{ old('categoria') == 'Mesas' ? 'selected' : '' }}>Mesas</option>
                        <option value="Estanterías" {{ old('categoria') == 'Estanterías' ? 'selected' : '' }}>Estanterías</option>
                        <option value="Archiveros" {{ old('categoria') == 'Archiveros' ? 'selected' : '' }}>Archiveros</option>
                        <option value="Sofás" {{ old('categoria') == 'Sofás' ? 'selected' : '' }}>Sofás</option>
                        <option value="Muebles de Sala" {{ old('categoria') == 'Muebles de Sala' ? 'selected' : '' }}>Muebles de Sala</option>
                        <option value="Muebles de Recepción" {{ old('categoria') == 'Muebles de Recepción' ? 'selected' : '' }}>Muebles de Recepción</option>
                        <option value="Otros" {{ old('categoria') == 'Otros' ? 'selected' : '' }}>Otros</option>
                    </select>
                    @error('categoria')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="precio" class="form-label">Precio ($) *</label>
                    <input type="number" id="precio" name="precio" 
                           class="form-control" 
                           value="{{ old('precio') }}"
                           placeholder="Ej: 999.99"
                           step="0.01"
                           min="0"
                           required>
                    @error('precio')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="imagen" class="form-label">Imagen del Producto</label>
                    <input type="file" id="imagen" name="imagen" 
                           class="form-control"
                           accept="image/*"
                           onchange="previewImage(event)">
                    <small>Formatos permitidos: JPEG, PNG, JPG, GIF. Máximo 2MB.</small>
                    
                    <div class="image-preview-container">
                        <img id="imagePreview" class="preview-image" src="#" alt="Vista previa">
                    </div>
                    
                    @error('imagen')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-check">
                    <input type="checkbox" id="disponible" name="disponible" 
                           class="form-check-input" 
                           value="1" 
                           {{ old('disponible', true) ? 'checked' : '' }}>
                    <label for="disponible" class="form-check-label">
                        Producto disponible para venta
                    </label>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Guardar Producto
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('productos.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Volver a Productos
                </a>
            </div>
        </div>
    </main>

    <script>
        // Vista previa de imagen
        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }
        
        // Validación de precio
        document.getElementById('precio').addEventListener('input', function(e) {
            if (this.value < 0) {
                this.value = 0;
            }
        });
        
        // Contador de caracteres para descripción
        document.getElementById('descripcion').addEventListener('input', function(e) {
            const maxLength = 1000;
            const currentLength = this.value.length;
            const counter = document.getElementById('charCounter') || 
                           (function() {
                               const counter = document.createElement('div');
                               counter.id = 'charCounter';
                               counter.style.fontSize = '0.875rem';
                               counter.style.color = '#666';
                               counter.style.marginTop = '5px';
                               this.parentNode.appendChild(counter);
                               return counter;
                           }).call(this);
            
            counter.textContent = `${currentLength} / ${maxLength} caracteres`;
            
            if (currentLength > maxLength) {
                counter.style.color = '#e74c3c';
                this.style.borderColor = '#e74c3c';
            } else {
                counter.style.color = '#666';
                this.style.borderColor = currentLength > 0 ? '#27ae60' : '#ddd';
            }
        });
        
        // Validación del formulario antes de enviar
        document.querySelector('form').addEventListener('submit', function(e) {
            const precio = document.getElementById('precio').value;
            const descripcion = document.getElementById('descripcion').value;
            
            if (precio < 0) {
                e.preventDefault();
                alert('El precio no puede ser negativo');
                return false;
            }
            
            if (descripcion.length < 10) {
                e.preventDefault();
                alert('La descripción debe tener al menos 10 caracteres');
                return false;
            }
            
            return true;
        });
    </script>
</body>
</html>