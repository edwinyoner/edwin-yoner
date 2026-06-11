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
        Schema::create('portfolio_settings', function (Blueprint $table) {
            $table->id();

            // ============================================
            // IDENTIDAD VISUAL
            // ============================================
            $table->string('logo_path')->nullable()
                ->comment('Logo personal (opcional)');

            $table->string('favicon_path')->nullable()
                ->comment('Favicon del sitio');

            // ============================================
            // PALETA DE COLORES (para tema personalizado)
            // ============================================
            $table->string('primary_color', 7)->default('#d4af37')
                ->comment('Color primario (dorado)');

            $table->string('secondary_color', 7)->default('#1f2937')
                ->comment('Color secundario (gris)');

            $table->string('tertiary_color', 7)->default('#f9fafb')
                ->comment('Color terciario (blanco)');

            $table->string('text_dark_color', 7)->default('#1f2937')
                ->comment('Texto para modo claro');

            $table->string('text_light_color', 7)->default('#f9fafb')
                ->comment('Texto para modo oscuro');

            // ============================================
            // CONTACTO
            // ============================================
            $table->string('email_contact')->nullable()
                ->comment('Email principal');

            $table->string('phone', 20)->nullable()
                ->comment('Teléfono');

            $table->string('whatsapp_number', 20)->nullable()
                ->comment('WhatsApp (formato: 51912345678)');

            // ============================================
            // CONFIGURACIÓN SITIO
            // ============================================
            $table->boolean('enable_dark_mode')->default(true)
                ->comment('Permitir tema oscuro');

            $table->boolean('enable_multilang')->default(true)
                ->comment('Activar multiidioma ES/EN');

            $table->string('default_language', 2)->default('es')
                ->comment('Idioma por defecto (es/en)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_settings');
    }
};