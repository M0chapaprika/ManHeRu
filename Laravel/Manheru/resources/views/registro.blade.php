<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - ManHeRu</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
    <script>
        // Función para verificar fortaleza de contraseña
        function checkPasswordStrength(password) {
            let strength = 0;
            
            // Longitud mínima
            if (password.length >= 6) strength++;
            
            // Contiene letras mayúsculas y minúsculas
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            
            // Contiene números
            if (/[0-9]/.test(password)) strength++;
            
            // Contiene caracteres especiales
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            return strength;
        }

        // Función para validar contraseña en tiempo real
        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const strengthElement = document.getElementById('password-strength');
            const strength = checkPasswordStrength(password);
            
            let strengthText = '';
            let strengthClass = '';
            
            if (strength === 0) {
                strengthText = 'Muy débil';
                strengthClass = 'strength-weak';
            } else if (strength <= 2) {
                strengthText = 'Débil';
                strengthClass = 'strength-weak';
            } else if (strength === 3) {
                strengthText = 'Media';
                strengthClass = 'strength-medium';
            } else {
                strengthText = 'Fuerte';
                strengthClass = 'strength-strong';
            }
            
            if (password.length > 0) {
                strengthElement.innerHTML = `<span class="${strengthClass}">Fortaleza: ${strengthText}</span>`;
            } else {
                strengthElement.innerHTML = '';
            }
            
            // Validar coincidencia de contraseñas
            const confirmField = document.getElementById('password_confirmation');
            if (confirmPassword.length > 0 && password !== confirmPassword) {
                confirmField.style.borderColor = '#dc3545';
            } else if (confirmPassword.length > 0 && password === confirmPassword) {
                confirmField.style.borderColor = '#28a745';
            } else {
                confirmField.style.borderColor = '#ddd';
            }
        }

        // Función para validar formulario antes de enviar
        function validateForm() {
            const nombre = document.getElementById('nombre').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            let isValid = true;
            let errorMessage = '';
            
            // Validar nombre
            if (nombre.length < 2) {
                isValid = false;
                errorMessage += 'El nombre debe tener al menos 2 caracteres.\n';
                document.getElementById('nombre').style.borderColor = '#dc3545';
            } else {
                document.getElementById('nombre').style.borderColor = '#ddd';
            }
            
            // Validar email
            if (!emailRegex.test(email)) {
                isValid = false;
                errorMessage += 'Por favor, ingrese un email válido.\n';
                document.getElementById('email').style.borderColor = '#dc3545';
            } else {
                document.getElementById('email').style.borderColor = '#ddd';
            }
            
            // Validar contraseña
            if (password.length < 6) {
                isValid = false;
                errorMessage += 'La contraseña debe tener al menos 6 caracteres.\n';
                document.getElementById('password').style.borderColor = '#dc3545';
            } else {
                document.getElementById('password').style.borderColor = '#ddd';
            }
            
            // Validar coincidencia de contraseñas
            if (password !== confirmPassword) {
                isValid = false;
                errorMessage += 'Las contraseñas no coinciden.\n';
                document.getElementById('password_confirmation').style.borderColor = '#dc3545';
            }
            
            if (!isValid) {
                alert('Por favor, corrija los siguientes errores:\n\n' + errorMessage);
                return false;
            }
            
            return true;
        }

        // Inicializar validación
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('password').addEventListener('input', validatePassword);
            document.getElementById('password_confirmation').addEventListener('input', validatePassword);
        });
    </script>
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <img src="{{ asset('images/Logo.jpg') }}" alt="Logo ManHeRu">
            <span class="nombre">ManHeRu</span>
        </div>
    </header>

    <main class="registro-container">
        <div class="registro-card">
            <h2>Crear Cuenta</h2>
            <p class="subtitle">Regístrate para acceder a todos los beneficios</p>

            <!-- Mostrar mensajes de error -->
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Mostrar mensaje de éxito -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" onsubmit="return validateForm()">
                @csrf
                
                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" 
                           placeholder="Ingresa tu nombre completo" 
                           value="{{ old('nombre') }}" 
                           required>
                    @error('nombre')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" 
                           placeholder="ejemplo@correo.com" 
                           value="{{ old('email') }}" 
                           required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" 
                           placeholder="Mínimo 6 caracteres" 
                           required>
                    <div id="password-strength" class="password-strength"></div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Repite tu contraseña" 
                           required>
                </div>

                <button type="submit" class="btn-register">Crear Cuenta</button>
            </form>

            <div class="extra-options">
                <a href="{{ route('login.form') }}">¿Ya tienes una cuenta? Inicia sesión</a>
                <a href="{{ route('inicio') }}">Volver al inicio</a>
            </div>
        </div>
    </main>
</body>
</html>