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
            'email' => 'admin@pigene.com',
            'password' => bcrypt('password'), // Asegurar password conocido
        ]);

        // 3. Crear 11 empleados (uno de cada tipo)
        $types = [
            'Legislador', 
            'Director', 
            'Empleado', 
            'Obrero', 
            'Contratado',
            'Legislador Jubilado', 
            'Director Jubilado', 
            'Empleados y Obreros Jubilados', 
            'Alto Funcionario Pensionado', 
            'Alto Nivel Pensionado', 
            'Empleados y Obreros Pensionados'
        ];

        foreach ($types as $type) {
            Employee::factory()->create([
                'employee_type' => $type,
                // Personalizar un poco para que se vean diferentes
                'institution_entry_date' => now()->subYears(rand(1, 20)),
            ]);
        }
    }
}
