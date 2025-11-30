<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id('ID_Rol');
            $table->string('Nombre', 100);
            $table->boolean('Estatus')->default(1);
            $table->timestamps();
        });

        // Insertar roles básicos
        DB::table('roles')->insert([
            ['Nombre' => 'Administrador', 'Estatus' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['Nombre' => 'Usuario', 'Estatus' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['Nombre' => 'Invitado', 'Estatus' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};