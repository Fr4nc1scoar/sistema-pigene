<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dependents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('id_card')->nullable(); // Cédula (puede ser menor de edad sin cedula, pero user pidió campo)
            $table->string('name'); // Apellidos y Nombres
            $table->date('birthdate'); // Fec Nac
            $table->string('relationship'); // Parentesco
            $table->string('condition')->default('Ninguna'); // Condición
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dependents');
    }
};
