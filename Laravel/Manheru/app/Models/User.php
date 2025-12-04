<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'ID_Usuario';
    public $timestamps = false;  // Tu tabla no tiene timestamps

    protected $fillable = [
        'Nombre',
        'Gmail',
        'Contrasena',
        'Telefono',
        'Estatus',
        'ID_Rol',
        'ID_Direccion'
    ];

    protected $hidden = [
        'Contrasena',
        'remember_token',
    ];

    protected $casts = [
        'Estatus' => 'boolean',
        'ID_Rol' => 'integer'
    ];

    /**
     * Obtener el email para autenticación
     */
    public function getEmailAttribute()
    {
        return $this->Gmail;
    }

    /**
     * Obtener el nombre para autenticación
     */
    public function getNameAttribute()
    {
        return $this->Nombre;
    }

    /**
     * Obtener la contraseña para autenticación
     */
    public function getAuthPassword()
    {
        return $this->Contrasena;
    }

    /**
     * Verificar si es administrador
     */
    public function esAdministrador()
    {
        return $this->ID_Rol == 1;
    }

    /**
     * Verificar si está activo
     */
    public function estaActivo()
    {
        return $this->Estatus == 1;
    }
}