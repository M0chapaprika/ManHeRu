<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - ManHeRu</title>
    <link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
</head>
<body>
    @include('components.alert')

    <div class="crud-container">
        <div class="crud-header">
            <h1>Gestión de Usuarios</h1>
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">Nuevo Usuario</a>
            <a href="{{ route('inicio') }}" class="btn btn-secondary">Volver al Inicio</a>
        </div>

        <div class="table-container">
            <table class="crud-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->ID_Usuario }}</td>
                        <td>{{ $usuario->Nombre }}</td>
                        <td>{{ $usuario->Gmail }}</td>
                        <td>{{ $usuario->Telefono }}</td>
                        <td>
                            @if($usuario->ID_Rol == 1)
                                <span class="badge badge-admin">Administrador</span>
                            @elseif($usuario->ID_Rol == 2)
                                <span class="badge badge-user">Usuario</span>
                            @else
                                <span class="badge badge-guest">Invitado</span>
                            @endif
                        </td>
                        <td>
                            @if($usuario->Estatus == 1)
                                <span class="status-active">Activo</span>
                            @else
                                <span class="status-inactive">Inactivo</span>
                            @endif
                        </td>
                        <td class="actions">
                            <a href="{{ route('usuarios.edit', $usuario->ID_Usuario) }}" class="btn btn-edit">Editar</a>
                            <form action="{{ route('usuarios.destroy', $usuario->ID_Usuario) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>