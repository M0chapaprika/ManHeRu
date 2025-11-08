<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - ManHeRu</title>
    <link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
</head>
<body>
    @include('components.alert')

    <div class="crud-container">
        <div class="crud-header">
            <h1>Editar Usuario</h1>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
        </div>

        <div class="form-container">
            <form action="{{ route('usuarios.update', $usuario->ID_Usuario) }}" method="POST" class="crud-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" value="{{ $usuario->Nombre }}" required>
                </div>

                <div class="form-group">
                    <label for="Gmail">Email</label>
                    <input type="email" name="Gmail" id="Gmail" value="{{ $usuario->Gmail }}" required>
                </div>

                <div class="form-group">
                    <label for="Telefono">Teléfono</label>
                    <input type="text" name="Telefono" id="Telefono" value="{{ $usuario->Telefono }}" required>
                </div>

                <div class="form-group">
                    <label for="ID_Rol">Rol</label>
                    <select name="ID_Rol" id="ID_Rol" required>
                        <option value="1" {{ $usuario->ID_Rol == 1 ? 'selected' : '' }}>Administrador</option>
                        <option value="2" {{ $usuario->ID_Rol == 2 ? 'selected' : '' }}>Usuario</option>
                        <option value="3" {{ $usuario->ID_Rol == 3 ? 'selected' : '' }}>Invitado</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>