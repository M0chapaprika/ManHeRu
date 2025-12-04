<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla
    protected $table = 'roles';

    // Especificar la clave primaria
    protected $primaryKey = 'ID_Rol';

    // Los campos que se pueden asignar en masa
    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Estatus'
    ];

    // Los campos que deben ser convertidos a tipos nativos
    protected $casts = [
        'Estatus' => 'boolean'
    ];

    // Relación con usuarios (si la necesitas)
    public function usuarios()
    {
        return $this->hasMany(User::class, 'ID_Rol', 'ID_Rol');
    }

    // Scope para roles activos
    public function scopeActivos($query)
    {
        return $query->where('Estatus', 1);
    }

    // Método para verificar si es administrador
    public function esAdministrador()
    {
        return $this->ID_Rol === 1;
    }

    // Método para verificar si es usuario normal
    public function esUsuario()
    {
        return $this->ID_Rol === 2;
    }
}