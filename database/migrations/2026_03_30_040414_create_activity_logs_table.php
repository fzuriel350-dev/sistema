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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('accion'); 
            $table->string('producto_nombre'); 
            $table->string('descripcion');
            
            // IMPORTANTE: Especificamos 'usuarios' porque así se llama tu tabla de User
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('usuarios') // <--- Cambiado de users a usuarios
                  ->nullOnDelete();
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};