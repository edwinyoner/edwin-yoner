<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PortfolioSetting;

class PortfolioSettingSeeder extends Seeder
{
    /**
     * Configuración general del portafolio
     * IMPORTANTE: Solo puede haber UN registro en esta tabla (singleton)
     */
    public function run(): void
    {
        PortfolioSetting::updateOrCreate(
            ['id' => 1], // Siempre el mismo ID
            [
                // ============================================
                // IDENTIDAD VISUAL
                // ============================================
                'logo_path' => null, // TODO: Subir logo si tienes uno personal
                'favicon_path' => null, // TODO: Subir favicon personalizado
                
                // ============================================
                // PALETA DE COLORES (Basado en tu diseño)
                // ============================================
                'primary_color' => '#d4af37',   // Dorado (color principal de tu diseño)
                'secondary_color' => '#434b4d', // Gris oscuro (fondo)
                'tertiary_color' => '#f9fafb',    // Blanco/gris claro (acentos)
                'text_dark_color' => '#1f2937', // Texto para modo claro
                'text_light_color' => '#f9fafb', // Texto para modo oscuro
                
                // ============================================
                // INFORMACIÓN DE CONTACTO
                // ============================================
                'email_contact' => 'edwinyoner@edwin-yoner.com', 
                'phone' => '+51931741355',
                'whatsapp_number' => '+51931741355', 
                
                // ============================================
                // CONFIGURACIÓN DE FUNCIONALIDADES
                // ============================================
                'enable_dark_mode' => true, // Activar tema oscuro/claro/sistema
                'enable_multilang' => true, // Activar español/inglés
                'default_language' => 'es', // Idioma por defecto (es/en)
            ]
        );

        $this->command->info('Configuración del portafolio creada/actualizada correctamente.');
    }
}