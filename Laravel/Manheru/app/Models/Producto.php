<?php
// app/Models/Producto.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla
    protected $table = 'productos';

    // Los campos que se pueden asignar en masa
    protected $fillable = [
        'nombre',
        'descripcion', 
        'categoria',
        'imagen',
        'precio',
        'disponible'
    ];

    // Los campos que deben ser convertidos a tipos nativos
    protected $casts = [
        'precio' => 'decimal:2',
        'disponible' => 'boolean'
    ];

    // Mutador para el nombre (opcional)
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = ucfirst(strtolower($value));
    }

    // Accesor para precio formateado
    public function getPrecioFormateadoAttribute()
    {
        return '$' . number_format($this->precio, 2);
    }

    // Accesor para disponibilidad en texto
    public function getDisponibilidadTextoAttribute()
    {
        return $this->disponible ? 'Disponible' : 'Agotado';
    }
}