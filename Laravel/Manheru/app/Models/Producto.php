<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'Productos';
    protected $primaryKey = 'ID_Producto';
    public $timestamps = false;
    
    protected $fillable = [
        'Nombre',
        'Estatus',
        'ID_Tipo'
    ];
    
    protected $casts = [
        'Estatus' => 'boolean'
    ];
    
    /**
     * Relación con la tabla Tipos
     */
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'ID_Tipo', 'ID_Tipo');
    }
}