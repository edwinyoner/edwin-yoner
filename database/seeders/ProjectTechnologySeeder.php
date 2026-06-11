<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Technology;

class ProjectTechnologySeeder extends Seeder
{
    /**
     * Asociar tecnologías a cada proyecto
     * IMPORTANTE: Ejecutar después de ProjectSeeder y TechnologySeeder
     */
    public function run(): void
    {
        // ============================================
        // CONFIGURACIÓN DE TECNOLOGÍAS POR PROYECTO
        // ============================================
        $projectTechnologies = [
            // SMART PARKING SYSTEM
            'smart-parking-system' => [
                'html',
                'css',
                'javascript',
                'typescript',
                'angular',
                'flutter',
                'esp32',
                'java',
                'spring',
                'oracledatabase',
                'mysql',
                'postgresql',
                'mongodb',
                'git',
            ],

            // SISTEMA DE GESTIÓN PATRIMONIAL
            'sistema-gestion-patrimonial' => [
                'laravel',
                'php',
                'html',
                'css',
                'javascript',
                'bootstrap',
                'git',
            ],
        ];

        // ============================================
        // ASOCIAR TECNOLOGÍAS A CADA PROYECTO
        // ============================================
        foreach ($projectTechnologies as $projectSlug => $technologySlugs) {
            // Buscar el proyecto
            $project = Project::where('slug', $projectSlug)->first();

            if (!$project) {
                $this->command->warn("Proyecto '{$projectSlug}' no encontrado. Saltando...");
                continue;
            }

            // Buscar IDs de las tecnologías
            $technologyIds = Technology::whereIn('slug', $technologySlugs)
                                      ->pluck('id')
                                      ->toArray();

            // Validar que se encontraron tecnologías
            if (empty($technologyIds)) {
                $this->command->warn("No se encontraron tecnologías para '{$project->title}'");
                continue;
            }

            // Asociar tecnologías al proyecto (tabla pivot: project_technology)
            $project->technologies()->sync($technologyIds);

            $this->command->info("  ✓ {$project->title}: {$project->technologies()->count()} tecnologías asociadas");
        }

        $this->command->info('Tecnologías asociadas a proyectos correctamente.');
    }
}