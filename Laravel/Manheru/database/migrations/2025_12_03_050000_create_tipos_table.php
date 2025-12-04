<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Tipos', function (Blueprint $table) {
            $table->id('ID_Tipo');  // Cambiado para que sea autoincremental como tu BD
            $table->string('Nombre', 100);  // Nombre correcto según tu BD
            $table->boolean('Estatus')->default(true);  // Agregado según tu BD
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Tipos');
    }
};