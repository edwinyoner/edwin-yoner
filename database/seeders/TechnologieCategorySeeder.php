<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TechnologieCategory;

class TechnologieCategorySeeder extends Seeder
{
    /**
     * Categorías de tecnologías para organizar el stack técnico
     */
    public function run(): void
    {
        $categories = [
            // ============================================
            // SISTEMAS OPERATIVOS
            // ============================================
            [
                'name' => 'Sistemas Operativos',
                'name_en' => 'Operating Systems',
                'slug' => 'operating-systems',
                'icon_class' => 'fas fa-desktop',
                'color' => '#2563eb', // Azul oscuro
                'description' => 'Sistemas operativos utilizados',
                'is_active' => true,
            ],

            // ============================================
            // LENGUAJES (Frontend + Backend + VHDL unificados)
            // ============================================
            [
                'name' => 'Lenguajes',
                'name_en' => 'Languages',
                'slug' => 'languages',
                'icon_class' => 'fas fa-code',
                'color' => '#8b5cf6', // Morado
                'description' => 'Lenguajes de programación, marcado, estilos y descripción de hardware (ej. Java, Python, HTML, CSS, VHDL)',
                'is_active' => true,
            ],

            // ============================================
            // FRAMEWORKS & LIBRERÍAS
            // ============================================
            [
                'name' => 'Frameworks & Librerías',
                'name_en' => 'Frameworks & Libraries',
                'slug' => 'frameworks-libraries',
                'icon_class' => 'fas fa-cubes',
                'color' => '#ec4899', // Rosa
                'description' => 'Frameworks y librerías para desarrollo web, móvil y de escritorio',
                'is_active' => true,
            ],

            // ============================================
            // BASES DE DATOS
            // ============================================
            [
                'name' => 'Bases de Datos',
                'name_en' => 'Databases',
                'slug' => 'databases',
                'icon_class' => 'fas fa-database',
                'color' => '#10b981', // Verde
                'description' => 'Sistemas de gestión de bases de datos relacionales y no relacionales',
                'is_active' => true,
            ],

            // ============================================
            // IoT
            // ============================================
            [
                'name' => 'IoT',
                'name_en' => 'IoT',
                'slug' => 'iot',
                'icon_class' => 'fas fa-microchip',
                'color' => '#ef4444', // Rojo
                'description' => 'Internet de las Cosas y desarrollo de hardware',
                'is_active' => true,
            ],

            // ============================================
            // IA
            // ============================================
            [
                'name' => 'IA',
                'name_en' => 'AI',
                'slug' => 'ia',
                'icon_class' => 'fas fa-robot',
                'color' => '#f59e0b', // Naranja/Ámbar
                'description' => 'Inteligencia Artificial y Modelos de Aprendizaje',
                'is_active' => true,
            ],            

            // ============================================
            // CLOUD
            // ============================================
            [
                'name' => 'Cloud',
                'name_en' => 'Cloud',
                'slug' => 'cloud',
                'icon_class' => 'fas fa-cloud',
                'color' => '#06b6d4', // Cyan (Cambiado para no repetir)
                'description' => 'Servicios en la nube e infraestructura',
                'is_active' => true,
            ],

            // ============================================
            // DEVOPS
            // ============================================
            [
                'name' => 'DevOps',
                'name_en' => 'DevOps',
                'slug' => 'devops',
                'icon_class' => 'fas fa-infinity', // Ícono de infinito más común en DevOps
                'color' => '#14b8a6', // Teal (Cambiado para no repetir)
                'description' => 'Herramientas de integración y despliegue continuo',
                'is_active' => true,
            ],

            // ============================================
            // CONTROL DE VERSIONES
            // ============================================
            [
                'name' => 'Control de Versiones',
                'name_en' => 'Version Control',
                'slug' => 'version-control',
                'icon_class' => 'fas fa-code-branch',
                'color' => '#4b5563', // Gris Oscuro
                'description' => 'Sistemas de control de versiones para gestión de código fuente',
                'is_active' => true,
            ],

            // ============================================
            // HERRAMIENTAS & OTROS
            // ============================================
            [
                'name' => 'Herramientas & Otros',
                'name_en' => 'Tools & Others',
                'slug' => 'tools-others',
                'icon_class' => 'fas fa-tools',
                'color' => '#9ca3af', // Gris Claro
                'description' => 'Editores de código, IDEs y otras herramientas de desarrollo',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            TechnologieCategory::updateOrCreate(
                ['slug' => $category['slug']], // Buscar por slug
                $category // Actualizar o crear con estos datos
            );
        }

        $this->command->info('Categorías de tecnologías creadas/actualizadas correctamente.');
    }
}
