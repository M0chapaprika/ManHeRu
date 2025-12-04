<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario Administrador (ID_Rol = 1)
        User::create([
            'Nombre' => 'Administrador ManHeRu',
            'Gmail' => 'admin@manheru.com',
            'Contrasena' => Hash::make('Admin123!'),
            'Telefono' => '555-100-0000',
            'Estatus' => 1,
            'ID_Rol' => 1, // Administrador
        ]);

        // Usuario Normal (ID_Rol = 2)
        User::create([
            'Nombre' => 'Usuario Demo',
            'Gmail' => 'usuario@manheru.com',
            'Contrasena' => Hash::make('Usuario123!'),
            'Telefono' => '555-200-0000',
            'Estatus' => 1,
            'ID_Rol' => 2, // Usuario normal
        ]);

        // Usuario Invitado (ID_Rol = 3)
        User::create([
            'Nombre' => 'Invitado Demo',
            'Gmail' => 'invitado@manheru.com',
            'Contrasena' => Hash::make('Invitado123!'),
            'Telefono' => '555-300-0000',
            'Estatus' => 1,
            'ID_Rol' => 3, // Invitado
        ]);

        // Crear algunos usuarios de prueba adicionales
        $usuarios = [
            [
                'Nombre' => 'María González',
                'Gmail' => 'maria.g@example.com',
                'Contrasena' => Hash::make('Maria123!'),
                'Telefono' => '555-111-2233',
                'Estatus' => 1,
                'ID_Rol' => 2,
            ],
            [
                'Nombre' => 'Carlos López',
                'Gmail' => 'carlos.l@example.com',
                'Contrasena' => Hash::make('Carlos123!'),
                'Telefono' => '555-222-3344',
                'Estatus' => 1,
                'ID_Rol' => 2,
            ]
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }

        $this->command->info('Usuarios de prueba creados exitosamente');
    }
}