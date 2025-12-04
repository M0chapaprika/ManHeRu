<?php
// database/migrations/xxxx_create_usuarios_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('ID_Usuario');
            $table->string('Nombre', 100);
            $table->string('Gmail', 255)->unique();
            $table->string('Contrasena', 255);
            $table->string('Telefono', 20);
            $table->boolean('Estatus')->default(1);
            $table->integer('ID_Rol')->default(2);
            $table->unsignedBigInteger('ID_Direccion')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Foreign keys (agregarlas aquí es correcto)
            $table->foreign('ID_Rol')
                  ->references('ID_Rol')
                  ->on('roles')
                  ->onDelete('set null');

            $table->foreign('ID_Direccion')
                  ->references('ID_Direccion')
                  ->on('direcciones')
                  ->onDelete('set null');
        });
    }

    public function down(): void
{
    // Eliminar foreign keys si existen
    if (Schema::hasTable('usuarios')) {
        Schema::table('usuarios', function (Blueprint $table) {
            // Verificar si la foreign key existe antes de eliminarla
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $foreignKeys = $sm->listTableForeignKeys('usuarios');
            
            foreach ($foreignKeys as $foreignKey) {
                if ($foreignKey->getForeignTableName() === 'direcciones') {
                    $table->dropForeign(['ID_Direccion']);
                }
                if ($foreignKey->getForeignTableName() === 'roles') {
                    $table->dropForeign(['ID_Rol']);
                }
            }
        });
    }
    
    // Luego eliminar la tabla
    Schema::dropIfExists('usuarios');
}
};


