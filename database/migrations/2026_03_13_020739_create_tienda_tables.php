<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void {
        // 1. Creamos primero la tabla de categorías
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Nombre único según criterios [cite: 28, 123]
            $table->string('descripcion')->nullable(); // Descripción para Faker 
            $table->timestamps();
        });

        // 2. Luego la tabla de productos con su relación
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // [cite: 41]
            $table->text('descripcion')->nullable(); // [cite: 42]
            $table->decimal('precio', 8, 2); // [cite: 44]
            $table->integer('stock'); // [cite: 45]
            
            // Relación con categorías (Llave foránea) [cite: 16, 48]
            $table->foreignId('categoria_id')
                  ->constrained('categorias')
                  ->onDelete('cascade');
                  
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void {
        // El orden inverso es importante para no romper las llaves foráneas
        Schema::dropIfExists('productos');
        Schema::dropIfExists('categorias');
    }
};