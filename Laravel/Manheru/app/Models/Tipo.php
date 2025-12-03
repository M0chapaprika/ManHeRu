<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'Tipos';
    protected $primaryKey = 'ID_Tipo';
    public $timestamps = false;
    
    protected $fillable = [
        'Nombre',  // Nombre del campo según tu BD
        'Estatus'
    ];
    
    protected $casts = [
        'Estatus' => 'boolean'
    ];
    
    /**
     * Relación con Productos
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'ID_Tipo', 'ID_Tipo');
    }
}