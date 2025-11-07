<?php

namespace Database\Seeders;

use App\Models\Usuario; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Usuario::create([
            'Nombre' => 'Test User',
            'Gmail' => 'test@example.com',
            'Contrasena' => Hash::make('password'),
            'Telefono' => '1234567890',
            'Estatus' => 1,
            'ID_Rol' => 1,
            'ID_Direccion' => 1, 
        ]);
    }
}