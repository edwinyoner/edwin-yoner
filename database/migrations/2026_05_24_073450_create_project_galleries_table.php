<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Galería de imágenes para cada proyecto
     */
    public function up(): void
    {
        Schema::create('project_galleries', function (Blueprint $table) {
            $table->id();
            
            // ============================================
            // RELACIÓN CON PROYECTO
            // ============================================
            $table->foreignId('project_id')
                ->constrained('projects')
                ->onDelete('cascade')
                ->comment('ID del proyecto al que pertenece esta imagen');
            
            // ============================================
            // INFORMACIÓN DE LA IMAGEN
            // ============================================
            $table->string('image_path')
                ->comment('Ruta de la imagen (storage/projects/gallery/xxx.jpg)');
            
            $table->string('caption')
                ->nullable()
                ->comment('Descripción o título de la imagen (opcional)');
            
            $table->timestamps();
            
            // ============================================
            // ÍNDICES
            // ============================================
            $table->index('project_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_galleries');
    }
};