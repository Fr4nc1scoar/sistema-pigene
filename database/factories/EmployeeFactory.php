<?php

namespace Database\Factories;

use App\Models\Position;
use App\Models\SalaryScale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        // Obtener IDs válidos
        $positions = Position::pluck('id')->toArray();
        $scales = SalaryScale::pluck('id')->toArray();

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

        return [
            'id_card' => $this->faker->unique()->numerify('V-########'),
            'first_name' => $this->faker->firstName(),
            'second_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'second_last_name' => $this->faker->lastName(),
            'birthdate' => $this->faker->dateTimeBetween('-60 years', '-20 years'),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'marital_status' => $this->faker->randomElement(['Soltero', 'Casado', 'Divorciado', 'Viudo']),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'education_level' => $this->faker->randomElement(['Bachiller', 'TSU', 'Universitario', 'Postgrado']),
            'profession' => $this->faker->jobTitle(),
            
            'employee_type' => $this->faker->randomElement($types),
            'position_id' => $this->faker->randomElement($positions),
            'salary_scale_id' => $this->faker->randomElement($scales),
            'institution_entry_date' => $this->faker->dateTimeBetween('-10 years', 'now'),
            'years_prior_service' => $this->faker->numberBetween(0, 15),

            // Campos requeridos por la tabla (Legacy/Original)
            'bank_name' => $this->faker->randomElement(['Banco de Venezuela', 'Banco Mercantil', 'Banesco']),
            'account_type' => 'Corriente',
            'account_number' => $this->faker->numerify('0102############'),
            
            // Campos de sueldo (base simulada)
            'salary_1' => $this->faker->randomFloat(2, 100, 3000),
            'salary_2' => 0,
            'salary_3' => 0,
            'salary_4' => 0,
            'salary_5' => 0,
            'salary_6' => 0,
            
            'health_condition' => $this->faker->optional(0.3)->sentence(), // 30% prob de tener condición
            'medical_observations' => $this->faker->optional(0.3)->text(50),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Employee $employee) {
            // Crear 1 cuenta bancaria
            $employee->bankAccounts()->create([
                'bank_name' => $this->faker->randomElement(['Banco de Venezuela', 'Banco Mercantil', 'Banesco']),
                'account_number' => $this->faker->numerify('0102############'),
                'account_type' => 'Corriente',
                'is_active' => true
            ]);

            // Crear 0-3 dependientes
            \App\Models\Dependent::factory(rand(0, 3))->create([
                'employee_id' => $employee->id
            ]);
        });
    }
}
