<?php

namespace Database\Seeders;

use App\Models\Direction;
use App\Models\EconomicConcept;
use App\Models\Medicine;
use App\Models\Pathology;
use App\Models\Position;
use App\Models\SalaryScale;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Direcciones
        $directions = [
            'Presidencia',
            'Secretaría de Cámara',
            'Dirección General',
            'Consultoría Jurídica',
            'Administración y Finanzas',
            'Talento Humano',
            'Servicios Generales',
            'Tecnología e Informática'
        ];

        foreach ($directions as $dir) {
            Direction::firstOrCreate(['name' => $dir]);
        }

        // 2. Tabuladores (Ejemplo simplificado)
        $scales = [
            ['code' => 'T1-G1-P1', 'grade' => '1', 'step' => '1', 'amount' => 130.00],
            ['code' => 'T1-G2-P1', 'grade' => '2', 'step' => '1', 'amount' => 150.00],
            ['code' => 'P1-G1-P1', 'grade' => 'PRO-1', 'step' => '1', 'amount' => 300.00],
            ['code' => 'ALT-01', 'grade' => 'ALTO', 'step' => 'N/A', 'amount' => 500.00],
        ];

        foreach ($scales as $scale) {
            SalaryScale::firstOrCreate(['code' => $scale['code']], $scale);
        }

        // 3. Cargos (Asignados aleatoriamente a direcciones para el demo)
        $positions = [
            ['name' => 'Diputado Presidente', 'level' => 'Alto Nivel'],
            ['name' => 'Director General', 'level' => 'Alto Nivel'],
            ['name' => 'Analista de RRHH I', 'level' => 'Administrativo'],
            ['name' => 'Analista de RRHH II', 'level' => 'Administrativo'],
            ['name' => 'Asistente Administrativo', 'level' => 'Administrativo'],
            ['name' => 'Obrero de Mantenimiento', 'level' => 'Obrero'],
            ['name' => 'Chófer', 'level' => 'Obrero'],
            ['name' => 'Programador Senior', 'level' => 'Administrativo'],
        ];

        $dirIds = Direction::pluck('id')->toArray();

        foreach ($positions as $pos) {
            Position::firstOrCreate(['name' => $pos['name']], [
                'direction_id' => $dirIds[array_rand($dirIds)], // Asignar a dirección random
                'level' => $pos['level']
            ]);
        }

        // 4. Conceptos Económicos
        $concepts = [
            ['name' => 'Bono de Transporte', 'type' => 'ASIGNACION', 'is_fixed' => true],
            ['name' => 'Prima por Hijos', 'type' => 'ASIGNACION', 'is_fixed' => false],
            ['name' => 'Prima de Profesión', 'type' => 'ASIGNACION', 'is_fixed' => true],
            ['name' => 'Seguro Social (IVSS)', 'type' => 'DEDUCCION', 'is_fixed' => true],
            ['name' => 'Faov', 'type' => 'DEDUCCION', 'is_fixed' => true],
        ];

        foreach ($concepts as $concept) {
            EconomicConcept::firstOrCreate(['name' => $concept['name']], $concept);
        }

        // 5. Salud
        $pathologies = ['Hipertensión', 'Diabetes Tip I', 'Asma', 'Alergia al Polvo'];
        foreach ($pathologies as $p) {
            Pathology::firstOrCreate(['name' => $p]);
        }

        $medicines = ['Losartán Potásico', 'Insulina', 'Salbutamol', 'Loratadina'];
        foreach ($medicines as $m) {
            Medicine::firstOrCreate(['name' => $m]);
        }
    }
}
