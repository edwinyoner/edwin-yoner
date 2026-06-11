<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Proyectos destacados del portafolio
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            
            // ============================================
            // INFORMACIÓN PRINCIPAL
            // ============================================
            $table->string('title')
                ->comment('Nombre del proyecto (ej: Smart Parking System)');
            
            $table->string('slug')
                ->unique()
                ->comment('Identificador único (ej: smart-parking-system)');
            
            $table->text('short_description')
                ->nullable()
                ->comment('Descripción corta - Aparece en la card (2-3 líneas)');
            
            $table->longText('long_description')
                ->nullable()
                ->comment('Descripción completa - Aparece en el modal');
            
            // ============================================
            // IMÁGENES Y MULTIMEDIA
            // ============================================
            $table->string('thumbnail_image')
                ->nullable()
                ->comment('Imagen principal para la card (storage/projects/thumb-xxx.jpg)');
            
            // ============================================
            // ENLACES
            // ============================================
            $table->string('project_url')
                ->nullable()
                ->comment('URL del proyecto en producción (si está online)');
            
            $table->string('repository_url')
                ->nullable()
                ->comment('URL del repositorio en GitHub u otra plataforma');
            
            $table->string('video_url')
                ->nullable()
                ->comment('URL de YouTube con demo del proyecto');
            
            // ============================================
            // INFORMACIÓN ADICIONAL
            // ============================================
            $table->year('year')
                ->nullable()
                ->comment('Año de desarrollo del proyecto');
            
            // ============================================
            // ESTADO
            // ============================================
            $table->boolean('is_active')
                ->default(true)
                ->comment('Mostrar/ocultar proyecto');
            
            $table->timestamps();
            
            // ============================================
            // ÍNDICES
            // ============================================
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};