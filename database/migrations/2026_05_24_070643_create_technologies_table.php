<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tecnologías individuales
     * (Laravel, Angular, MySQL, Docker, etc.)
     */
    public function up(): void
    {
        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            
            // ============================================
            // RELACIÓN CON CATEGORÍA
            // ============================================
            $table->foreignId('technologie_category_id')
                ->constrained('technologie_categories')
                ->onDelete('cascade')
                ->comment('ID de la categoría a la que pertenece');
            
            // ============================================
            // INFORMACIÓN DE LA HABILIDAD
            // ============================================
            $table->string('name')
                ->comment('Nombre de la tecnología (ej: Laravel, Angular, MySQL)');
            
            $table->string('slug')
                ->comment('Identificador único (ej: laravel, angular, mysql)');
            
            $table->string('icon_path')
                ->nullable()
                ->comment('Ruta del logo/icono (ej: storage/skills/laravel.svg)');
            
            $table->string('icon_class')
                ->nullable()
                ->comment('Clase de icono alternativa (ej: fab fa-laravel)');
            
            $table->string('color', 7)
                ->nullable()
                ->comment('Color oficial de la tecnología (ej: #FF2D20 para Laravel)');
            
            // ============================================
            // NIVEL DE DOMINIO (OPCIONAL)
            // ============================================
            $table->enum('proficiency_level', ['basico', 'intermedio', 'avanzado', 'experto'])
                ->default('intermedio')
                ->comment('Nivel de dominio de la tecnología');
            
            $table->integer('proficiency_percentage')
                ->default(50)
                ->comment('Porcentaje de dominio (0-100) para barras de progreso');
            
            // ============================================
            // ESTADO
            // ============================================
            $table->boolean('is_active')
                ->default(true)
                ->comment('Mostrar/ocultar habilidad');
            
            $table->timestamps();
            
            // ============================================
            // ÍNDICES
            // ============================================
            $table->index('technologie_category_id');
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technologies');
    }
};