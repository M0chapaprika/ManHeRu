<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Especificar el nombre de la tabla
    protected $table = 'usuarios';

    // Especificar la clave primaria
    protected $primaryKey = 'ID_Usuario';

    // Desactivar timestamps si no los usas
    public $timestamps = false;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Nombre',
        'Gmail',
        'Contrasena',
        'Telefono',
        'Estatus',
        'ID_Rol',
        'ID_Direccion'
    ];

    /**
     * Los atributos que deben estar ocultos para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'Contrasena',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Estatus' => 'boolean',
    ];

    /**
     * Sobrescribir el método para obtener el email
     * Laravel espera un campo 'email', pero nosotros tenemos 'Gmail'
     */
    public function getEmailAttribute()
    {
        return $this->Gmail;
    }

    /**
     * Sobrescribir el método para obtener el nombre
     * Laravel espera un campo 'name', pero nosotros tenemos 'Nombre'
     */
    public function getNameAttribute()
    {
        return $this->Nombre;
    }

    /**
     * Sobrescribir el método para obtener la contraseña
     * Laravel espera un campo 'password', pero nosotros tenemos 'Contrasena'
     */
    public function getAuthPassword()
    {
        return $this->Contrasena;
    }
}