<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario - ManHeRu</title>
    <link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
</head>
<body>
    @include('components.alert')

    <div class="crud-container">
        <div class="crud-header">
            <h1>Crear Nuevo Usuario</h1>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
        </div>

        <div class="form-container">
            <form action="{{ route('usuarios.store') }}" method="POST" class="crud-form">
                @csrf
                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" required>
                </div>

                <div class="form-group">
                    <label for="Gmail">Email</label>
                    <input type="email" name="Gmail" id="Gmail" required>
                </div>

                <div class="form-group">
                    <label for="Contrasena">Contraseña</label>
                    <input type="password" name="Contrasena" id="Contrasena" required>
                </div>

                <div class="form-group">
                    <label for="Telefono">Teléfono</label>
                    <input type="text" name="Telefono" id="Telefono" required>
                </div>

                <div class="form-group">
                    <label for="ID_Rol">Rol</label>
                    <select name="ID_Rol" id="ID_Rol" required>
                        <option value="1">Administrador</option>
                        <option value="2">Usuario</option>
                        <option value="3">Invitado</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>