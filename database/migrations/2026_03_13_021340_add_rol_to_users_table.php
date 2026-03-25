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
        Schema::table('users', function (Blueprint $table) {
            // Agregamos la columna rol después del email
            // El valor por defecto 'user' asegura que los usuarios nuevos no sean admin por error
            $table->string('rol')->default('user')->after('email'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminamos la columna si se revierte la migración (rollback)
            $table->dropColumn('rol');
        });
    }
};