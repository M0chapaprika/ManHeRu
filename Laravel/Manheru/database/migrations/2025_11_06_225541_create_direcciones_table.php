<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id('ID_Direccion'); 
            $table->string('Calle', 255);
            $table->string('NumeroExterior', 20)->nullable();
            $table->string('NumeroInterior', 20)->nullable();
            $table->string('Colonia', 100);
            $table->string('Ciudad', 100);
            $table->string('Estado', 100);
            $table->string('CodigoPostal', 10);
            $table->string('Pais', 100)->default('México');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};