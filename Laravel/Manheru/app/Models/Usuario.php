<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'Usuarios';
    protected $primaryKey = 'ID_Usuario';
    public $timestamps = true;

    protected $fillable = [
        'Nombre',
        'Gmail',
        'Contrasena',
        'Telefono',
        'Estatus',
        'ID_Rol',
        'ID_Direccion'
    ];

    protected $hidden = ['Contrasena'];
}
