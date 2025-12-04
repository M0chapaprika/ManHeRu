<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Solo insertar si no hay datos
        if (DB::table('roles')->count() == 0) {
            DB::table('roles')->insert([
                [
                    'ID_Rol' => 1,
                    'Nombre' => 'Administrador',
                    'Estatus' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'ID_Rol' => 2,
                    'Nombre' => 'Usuario',
                    'Estatus' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'ID_Rol' => 3,
                    'Nombre' => 'Invitado',
                    'Estatus' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]);
            
            $this->command->info('Roles insertados: Administrador, Usuario, Invitado');
        }
    }
}