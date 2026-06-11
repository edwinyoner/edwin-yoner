<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla de configuración de la página de perfil
     * Total: 15 campos editables + timestamps
     */
    public function up(): void
    {
        Schema::create('profile_settings', function (Blueprint $table) {
            $table->id();

            // ============================================
            // PERFIL PERSONAL
            // ============================================
            $table->string('profile_image')
                ->nullable()
                ->comment('Foto de perfil circular (storage/profile/photo.jpg)');

            $table->string('full_name')
                ->default('Edwin Yoner Flores Rupay')
                ->comment('Nombre completo');

            $table->string('professional_title')
                ->default('Bachiller en Ingeniería de Sistemas e Informática')
                ->comment('Título profesional o cargo');

            $table->text('bio_short')
                ->nullable()
                ->comment('Descripción corta (2-3 líneas) - Aparece en HOME');

            $table->text('bio_long')
                ->nullable()
                ->comment('Biografía extendida');

            // ============================================
            // UBICACIÓN
            // ============================================
            $table->string('city')
                ->default('Lima')
                ->comment('Ciudad actual');

            $table->string('country')
                ->default('Perú')
                ->comment('País');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_settings');
    }
};
