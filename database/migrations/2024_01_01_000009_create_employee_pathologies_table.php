<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_pathologies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('pathology_id')->constrained('pathologies')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['employee_id', 'pathology_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_pathologies');
    }
};
