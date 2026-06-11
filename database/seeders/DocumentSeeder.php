<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;

class DocumentSeeder extends Seeder
{
    /**
     * Documentos descargables del portafolio
     * (CV, certificados, portfolio PDF, etc.)
     */
    public function run(): void
    {
        $documents = [
            // ============================================
            // CURRICULUM VITAE
            // ============================================
            [
                'title' => 'Curriculum Vitae - Edwin Yoner Flores Rupay',
                'description' => 'CV profesional actualizado con experiencia en desarrollo Full Stack, IoT, Inteligencia Artificial y Cloud Computing.',
                'file_path' => null, // TODO: Subir CV → 'documents/cv-edwin-yoner-2026.pdf'
                'file_name' => 'CV-Edwin-Yoner-Flores-Rupay.pdf',
                'icon_class' => 'fas fa-file-pdf',
                'color' => '#D32F2F', // Rojo (PDF)
                'download_count' => 0,
                'is_active' => true,
            ],

            // ============================================
            // CERTIFICADOS
            // ============================================

            // ============================================
            // PORTFOLIO PDF (OPCIONAL)
            // ============================================
            [
                'title' => 'Portfolio Completo - Edwin Yoner',
                'description' => 'Portafolio completo en formato PDF con detalle de proyectos, tecnologías y experiencia profesional.',
                'file_path' => null, // TODO: 'documents/portfolio-edwin-yoner-2026.pdf'
                'file_name' => 'Portfolio-Edwin-Yoner-2026.pdf',
                'icon_class' => 'fas fa-file-word',
                'color' => '#2B579A', // Azul
                'download_count' => 0,
                'is_active' => false, // Desactivado hasta que tengas el PDF
            ],
        ];

        foreach ($documents as $document) {
            Document::updateOrCreate(
                [
                    'file_name' => $document['file_name'], // Buscar por nombre de archivo
                ],
                $document // Actualizar o crear con estos datos
            );
        }

        $this->command->info('Documentos creados/actualizados correctamente.');
        $this->command->info('Total: ' . count($documents) . ' documentos agregados.');
        $this->command->warn('Recuerda subir los archivos PDF a storage/app/public/documents/');
    }
}