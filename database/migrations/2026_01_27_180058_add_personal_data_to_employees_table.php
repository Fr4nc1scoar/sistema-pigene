<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Identificación Personal
            $table->string('first_name')->after('id_card');
            $table->string('second_name')->nullable()->after('first_name');
            $table->string('last_name')->after('second_name');
            $table->string('second_last_name')->nullable()->after('last_name');
            
            // Datos Biográficos
            $table->date('birthdate')->nullable()->after('second_last_name');
            $table->enum('gender', ['M', 'F'])->default('M')->after('birthdate');
            $table->enum('marital_status', ['Soltero', 'Casado', 'Divorciado', 'Viudo', 'Concubinato'])->default('Soltero')->after('gender');
            
            // Contacto
            $table->text('address')->nullable()->after('marital_status');
            $table->string('phone')->nullable()->after('address');
            $table->string('email')->nullable()->after('phone');
            
            // Académico
            $table->string('education_level')->nullable()->after('email'); // Bachiller, Universitario, etc.
            $table->string('profession')->nullable()->after('education_level');
            
            // Media
            $table->string('photo_path')->nullable()->after('profession');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'second_name', 'last_name', 'second_last_name',
                'birthdate', 'gender', 'marital_status',
                'address', 'phone', 'email',
                'education_level', 'profession',
                'photo_path'
            ]);
        });
    }
};
