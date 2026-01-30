<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('id_card')->unique(); // Cédula
            
            $table->string('employee_type'); // Tipo de Trabajador (String abierto para flexibilidad)

            $table->foreignId('position_id')->constrained('positions')->onDelete('restrict');
            $table->foreignId('salary_scale_id')->constrained('salary_scales')->onDelete('restrict');

            $table->date('institution_entry_date'); // Ingreso CLEBNE
            $table->date('public_admin_entry_date'); // Antigüedad Total

            // Datos Bancarios
            $table->string('bank_name');
            $table->string('account_type');
            $table->string('account_number', 20); // Validar 20 dígitos

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
