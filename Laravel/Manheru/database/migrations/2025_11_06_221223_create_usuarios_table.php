<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('ID_Usuario');
            $table->string('Nombre', 100);
            $table->string('Gmail', 255)->unique();
            $table->string('Contrasena', 255);
            $table->string('Telefono', 20);
            $table->boolean('Estatus')->default(1);
            $table->unsignedBigInteger('ID_Rol')->nullable();
            $table->unsignedBigInteger('ID_Direccion')->nullable();
            $table->timestamps();

            $table->foreign('ID_Rol')->references('ID_Rol')->on('roles')->onDelete('set null');
            $table->foreign('ID_Direccion')->references('ID_Direccion')->on('direcciones')->onDelete('set null');
        });

        // Insertar usuarios con contraseñas HASHEADAS
        DB::table('usuarios')->insert([
            [
                'Nombre' => 'Ian Rodriguez',
                'Gmail' => 'ianrodriguez@gmail.com',
                'Contrasena' => Hash::make('23486910'),
                'Telefono' => '5551234567',
                'Estatus' => 1,
                'ID_Rol' => 1,
                'ID_Direccion' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nombre' => 'Maria Pérez',
                'Gmail' => 'mariaperez@gmail.com',
                'Contrasena' => Hash::make('dave987'),
                'Telefono' => '5559876543',
                'Estatus' => 1,
                'ID_Rol' => 2,
                'ID_Direccion' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nombre' => 'Carlos López',
                'Gmail' => 'carloslopez@gmail.com',
                'Contrasena' => Hash::make('passe456'),
                'Telefono' => '5556543210',
                'Estatus' => 1,
                'ID_Rol' => 3,
                'ID_Direccion' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};