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
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            
            // ============================================
            // INFORMACIÓN DE LA RED SOCIAL
            // ============================================
            $table->string('name'); // Nombre de la red social (ej: "Facebook", "Instagram", "LinkedIn")
            $table->string('icon'); // Icono de FontAwesome (ej: "fab fa-facebook", "fab fa-instagram")
            $table->string('url'); // URL del perfil de la red social
            $table->string('color', 7)->nullable(); // Color hexadecimal de la red social (ej: "#1877F2" para Facebook)
            
            // ============================================
            // ESTADO
            // ============================================
            $table->boolean('is_active')->default(true); // Red social activa/visible en frontend

            $table->softDeletes()->comment('Fecha de eliminación suave (deleted_at)');
            
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};