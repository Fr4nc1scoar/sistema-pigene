<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_economic_concepts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('economic_concept_id')->constrained('economic_concepts')->onDelete('cascade');
            $table->timestamps();
            
            // Evitar duplicados del mismo concepto para el mismo empleado
            $table->unique(['employee_id', 'economic_concept_id'], 'emp_concept_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_economic_concepts');
    }
};
