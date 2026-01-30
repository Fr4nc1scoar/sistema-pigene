<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_scales', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('grade'); // Grado
            $table->string('step');  // Paso
            $table->decimal('amount', 20, 2); // Monto base
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_scales');
    }
};
