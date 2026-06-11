<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Categorías de tecnologías
     * (Frontend, Backend, Databases, DevOps, IoT, etc.)
     */
    public function up(): void
    {
        Schema::create('technologie_categories', function (Blueprint $table) {
            $table->id();
            
            // ============================================
            // INFORMACIÓN DE LA CATEGORÍA
            // ============================================
            $table->string('name')
                ->comment('Nombre de la categoría (ej: Frontend, Backend, Databases)');
            
            $table->string('name_en')
                ->nullable()
                ->comment('Nombre en inglés (para multiidioma)');
            
            $table->string('slug')
                ->unique()
                ->comment('Identificador único (ej: frontend, backend, databases)');
            
            $table->string('icon_class')
                ->nullable()
                ->comment('Clase de icono FontAwesome (ej: fas fa-code, fas fa-server)');
            
            $table->string('color', 7)
                ->default('#3b82f6')
                ->comment('Color hex de la categoría (para UI)');
            
            // ============================================
            // DESCRIPCIÓN (OPCIONAL)
            // ============================================
            $table->text('description')
                ->nullable()
                ->comment('Descripción corta de la categoría (opcional)');
            
            // ============================================
            // ESTADO
            // ============================================
            
            $table->boolean('is_active')
                ->default(true)
                ->comment('Mostrar/ocultar categoría');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technologie_categories');
    }
};