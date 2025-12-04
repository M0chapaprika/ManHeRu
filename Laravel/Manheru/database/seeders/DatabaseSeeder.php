<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar seeders en orden
        $this->call([
            RolesTableSeeder::class,      // Primero los roles
            UserSeeder::class,            // Luego los usuarios
            // Agrega otros seeders aquí...
        ]);
    }
}