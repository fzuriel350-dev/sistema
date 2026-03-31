<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Esta función añade las columnas necesarias para que Breeze funcione con tu tabla.
     */
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Añadimos password después del email
            $table->string('password')->after('email'); 
            
            // Añadimos el rol para tu Práctica 6 (valor por defecto 'usuario')
            $table->string('rol')->default('usuario')->after('password'); 
            
            // Campo necesario para la opción "Recordarme" de Breeze
            $table->rememberToken()->after('rol'); 
        });
    }

    /**
     * Reverse the migrations.
     * Esta función borra las columnas si decides deshacer el cambio.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['password', 'rol', 'remember_token']);
        });
    }
};