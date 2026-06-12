<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialLink;

class SocialLinkSeeder extends Seeder
{
    /**
     * Redes sociales para el portafolio personal de Edwin Yoner
     */
    public function run(): void
    {
        // Limpiar tabla antes de insertar (opcional)
        // SocialLink::truncate();

        $socialLinks = [
            // ============================================
            // GITHUB (Esencial para desarrollador)
            // ============================================
            [
                'name' => 'GitHub',
                'icon' => 'fab fa-github',
                'url' => 'https://github.com/edwinyoner', 
                'color' => '#181717',
                'is_active' => true,
            ],

            // ============================================
            // LINKEDIN (Profesional)
            // ============================================
            [
                'name' => 'LinkedIn',
                'icon' => 'fab fa-linkedin',
                'url' => 'https://www.linkedin.com/in/edwinyoner', 
                'color' => '#0A66C2',
                'is_active' => true,
            ],

            // ============================================
            // YOUTUBE (Canal técnico - opcional)
            // ============================================
            [
                'name' => 'YouTube',
                'icon' => 'fab fa-youtube',
                'url' => 'https://www.youtube.com/@edwinyoner', 
                'color' => '#FF0000',
                'is_active' => true,
            ],

            // ============================================
            // FACEBOOK (Personal)
            // ============================================
            [
                'name' => 'Facebook',
                'icon' => 'fab fa-facebook',
                'url' => 'https://www.facebook.com/edwinyoner',
                'color' => '#1877F2',
                'is_active' => true,
            ],

            // ============================================
            // X / TWITTER (Profesional/Tech)
            // ============================================
            [
                'name' => 'X',
                'icon' => 'fab fa-x-twitter',
                'url' => 'https://x.com/edwin_yoner', 
                'color' => '#000000',
                'is_active' => true,
            ],

            // ============================================
            // INSTAGRAM (Personal)
            // ============================================
            [
                'name' => 'Instagram',
                'icon' => 'fab fa-instagram',
                'url' => 'https://www.instagram.com/edwin_yoner', 
                'color' => '#E4405F',
                'is_active' => true,
            ],

            // ============================================
            // WHATSAPP (Contacto directo - opcional)
            // ============================================
            [
                'name' => 'WhatsApp',
                'icon' => 'fab fa-whatsapp',
                'url' => 'https://wa.me/931741355', 
                'color' => '#25D366',
                'is_active' => false, // Desactivado por defecto (privacidad)
            ],

            // ============================================
            // GITLAB (Alternativa a GitHub - opcional)
            // ============================================
            [
                'name' => 'GitLab',
                'icon' => 'fab fa-gitlab',
                'url' => 'https://gitlab.com/edwinyoner',
                'color' => '#FC6D26',
                'is_active' => false, 
            ],

            // ============================================
            // STACKOVERFLOW (Para desarrolladores - opcional)
            // ============================================
            [
                'name' => 'Stack Overflow',
                'icon' => 'fab fa-stack-overflow',
                'url' => 'https://stackoverflow.com/users/tu-id', 
                'color' => '#F58025',
                'is_active' => false, 
            ], 
        ];

        foreach ($socialLinks as $link) {
            SocialLink::updateOrCreate(
                ['name' => $link['name']], // Buscar por nombre
                $link // Actualizar o crear con estos datos
            );
        }

        $this->command->info('Redes sociales creadas/actualizadas correctamente.');
    }
}