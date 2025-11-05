<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - ManHeRu</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <img src="{{ asset('images/Logo.jpg') }}" alt="Logo ManHeRu">
            <span class="nombre">ManHeRu</span>
        </div>
    </header>

    <main class="login-container">
        <div class="login-card">
            <h2>Iniciar Sesión</h2>
            <p class="subtitle">Accede a tu cuenta para continuar</p>

            <form action="{{ route('login') }}" method="POST">
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-login">Entrar</button>
            </form>

            <div class="extra-options">
                <a href="#">¿Olvidaste tu contraseña?</a>
                <a href="#">Crear cuenta nueva</a>
            </div>
        </div>
    </main>
</body>
</html>
