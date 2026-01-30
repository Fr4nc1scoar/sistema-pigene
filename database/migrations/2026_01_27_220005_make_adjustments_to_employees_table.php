<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Eliminar fecha de admin publica anterior
            $table->dropColumn('public_admin_entry_date');
            
            // Agregar años de servicio previos (integer)
            $table->integer('years_prior_service')->default(0)->after('institution_entry_date');
            
            // Agregar columnas de sueldos 1-6
            $table->decimal('salary_1', 12, 2)->nullable()->after('salary_scale_id');
            $table->decimal('salary_2', 12, 2)->nullable()->after('salary_1');
            $table->decimal('salary_3', 12, 2)->nullable()->after('salary_2');
            $table->decimal('salary_4', 12, 2)->nullable()->after('salary_3');
            $table->decimal('salary_5', 12, 2)->nullable()->after('salary_4');
            $table->decimal('salary_6', 12, 2)->nullable()->after('salary_5');
            
            // Agregar observaciones médicas
            $table->text('medical_observations')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->date('public_admin_entry_date')->nullable();
            $table->dropColumn([
                'years_prior_service', 
                'salary_1', 'salary_2', 'salary_3', 
                'salary_4', 'salary_5', 'salary_6',
                'medical_observations'
            ]);
        });
    }
};
