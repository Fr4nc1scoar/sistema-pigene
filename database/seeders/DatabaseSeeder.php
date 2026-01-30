<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cargar catálogos primero
        $this->call(CatalogSeeder::class);

        // 2. Crear usuario admin si no existe
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@clebne.gob.ve',
        ]);

        // 3. Crear 30 empleados
        Employee::factory(30)->create();
    }
}
