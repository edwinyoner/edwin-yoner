<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla pivot: Relación muchos a muchos entre proyectos y tecnologías
     * Un proyecto usa múltiples tecnologías
     * Una tecnología se usa en múltiples proyectos
     */
    public function up(): void
    {
        Schema::create('project_technology', function (Blueprint $table) {
            $table->id();
            
            // ============================================
            // RELACIONES
            // ============================================
            $table->foreignId('project_id')
                ->constrained('projects')
                ->onDelete('cascade')
                ->comment('ID del proyecto');
            
            $table->foreignId('technology_id')
                ->constrained('technologies')
                ->onDelete('cascade')
                ->comment('ID de la tecnología');
            
            $table->timestamps();
            
            // ============================================
            // ÍNDICES Y RESTRICCIONES
            // ============================================
            $table->unique(['project_id', 'technology_id']);
            $table->index('project_id');
            $table->index('technology_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_technology');
    }
};