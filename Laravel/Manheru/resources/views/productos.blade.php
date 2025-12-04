<!-- En la sección de cada producto, agrega: -->
@auth
    @if(Auth::user()->ID_Rol == 1)
        <div class="producto-acciones" style="margin-top: 10px;">
            <a href="{{ route('productos.edit', $producto->id) }}" 
               class="btn-editar" 
               style="background: #3498db; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; margin-right: 5px;">
                Editar
            </a>
            <form action="{{ route('productos.destroy', $producto->id) }}" 
                  method="POST" 
                  style="display: inline;"
                  onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="btn-eliminar" 
                        style="background: #e74c3c; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;">
                    Eliminar
                </button>
            </form>
            
            <form action="{{ route('productos.toggle', $producto->id) }}" 
                  method="POST" 
                  style="display: inline; margin-left: 5px;">
                @csrf
                <button type="submit" 
                        class="btn-toggle" 
                        style="background: {{ $producto->disponible ? '#f39c12' : '#27ae60' }}; 
                               color: white; 
                               padding: 5px 10px; 
                               border: none; 
                               border-radius: 4px; 
                               cursor: pointer;">
                    {{ $producto->disponible ? 'Marcar como Agotado' : 'Marcar como Disponible' }}
                </button>
            </form>
        </div>
    @endif
@endauth