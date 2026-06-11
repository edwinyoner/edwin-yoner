<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Documentos descargables del portafolio
     * (CV, certificados, portfolio PDF, etc.)
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            
            // ============================================
            // INFORMACIÓN DEL DOCUMENTO
            // ============================================
            $table->string('title')
                ->comment('Nombre del documento (ej: Curriculum Vitae, Certificado Python)');
            
            $table->text('description')
                ->nullable()
                ->comment('Descripción breve del documento (opcional)');
            
            // ============================================
            // ARCHIVO
            // ============================================
            $table->string('file_path')
                ->nullable()
                ->comment('Ruta del archivo (storage/documents/cv-edwin-yoner.pdf)');
            
            $table->string('file_name')
                ->comment('Nombre original del archivo');
            
            // ============================================
            // VISUALIZACIÓN
            // ============================================
            $table->string('icon_class')
                ->default('fas fa-file-pdf')
                ->comment('Clase de icono FontAwesome (ej: fas fa-file-pdf, fas fa-certificate)');
            
            $table->string('color', 7)
                ->default('#ef4444')
                ->comment('Color del documento para UI (hex)');
            
            // ============================================
            // ESTADÍSTICAS
            // ============================================
            $table->unsignedInteger('download_count')
                ->default(0)
                ->comment('Contador de descargas');
            
            // ============================================
            // ESTADO
            // ============================================
            $table->boolean('is_active')
                ->default(true)
                ->comment('Mostrar/ocultar documento');
            
            $table->timestamps();
            
            // ============================================
            // ÍNDICES
            // ============================================
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};