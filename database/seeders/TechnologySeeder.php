<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TechnologieCategory;
use App\Models\Technology;

class TechnologySeeder extends Seeder
{
    /**
     * Tecnologías individuales del stack técnico.
     *
     * Lógica de icono en la vista (skills.blade.php):
     *   1. slug      → Simple Icons CDN (https://cdn.simpleicons.org/{slug})
     *   2. icon_path → SVG subido a storage
     *   3. icon_class→ FontAwesome / Devicon  (solo para los que NO tienen Simple Icons)
     *   4. placeholder → Iniciales del nombre
     */
    public function run(): void
    {
        $operatingSystems = TechnologieCategory::where('slug', 'operating-systems')->first();
        $languages        = TechnologieCategory::where('slug', 'languages')->first();
        $frameworks       = TechnologieCategory::where('slug', 'frameworks-libraries')->first();
        $databases        = TechnologieCategory::where('slug', 'databases')->first();
        $iot              = TechnologieCategory::where('slug', 'iot')->first();
        $ia               = TechnologieCategory::where('slug', 'ia')->first();
        $cloud            = TechnologieCategory::where('slug', 'cloud')->first();
        $repository       = TechnologieCategory::where('slug', 'version-control')->first();
        $devops           = TechnologieCategory::where('slug', 'devops')->first();
        $tools            = TechnologieCategory::where('slug', 'tools-others')->first();
        // ============================================
        // REFERENCIA DE SLUGS SIMPLE ICONS
        // ============================================
        // slug          → https://simpleicons.org/?q={nombre}
        // icon_class    → null si tiene Simple Icons, FontAwesome si no tiene
        // ============================================

        $technologies = [
            // ============================================
            // SISTEMAS OPERATIVOS
            // ============================================
            [
                'technologie_category_id' => $operatingSystems->id,
                'name' => 'Linux',
                'slug' => 'linux',
                'icon_path' => null,
                'icon_class' => 'fab fa-linux',
                'color' => '#FCC624',
                'proficiency_level' => 'basico',
                'proficiency_percentage' => 30,
                'is_active' => true,
            ],
            [
                'technologie_category_id' => $operatingSystems->id,
                'name' => 'Windows',
                'slug' => 'windows',
                'icon_path' => null,
                'icon_class' => 'fab fa-windows',
                'color' => '#0078D4',
                'proficiency_level' => 'basico',
                'proficiency_percentage' => 33,
                'is_active' => true,
            ],
            [
                'technologie_category_id' => $operatingSystems->id,
                'name' => 'macOS',
                'slug' => 'macos',
                'icon_path' => null,
                'icon_class' => 'fab fa-apple',
                'color' => '#808080', //gris
                'proficiency_level' => 'basico',
                'proficiency_percentage' => 30,
                'is_active' => true,
            ],
            // ============================================
            // LENGUAJES SOFTWARE (BACKEND AND FRONTEND) AND HARDWARE (VHDL / VERILOG)
            // ============================================
            [
                'technologie_category_id' => $languages->id,
                'name'                   => 'VHDL',
                'slug'                   => 'vhdl',            // ⚠️ No está en simpleicons estándar
                'icon_path'              => null,
                'icon_class'             => 'fas fa-microchip', // Fallback a FontAwesome
                'color'                  => '#005A9C',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 20,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $languages->id,
                'name'                   => 'Verilog',
                'slug'                   => 'verilog',         // ⚠️ Fallback a FontAwesome
                'icon_path'              => null,
                'icon_class'             => 'fas fa-memory',
                'color'                  => '#19328b',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 30,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $languages->id,
                'name'                   => 'C',
                'slug'                   => 'c',               // ✅ simpleicons.org/c
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#A8B9CC',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 50,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $languages->id,
                'name'                   => 'C++',
                'slug'                   => 'cplusplus',       // ✅ simpleicons.org/cplusplus
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#00599C',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 35,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $languages->id,
                'name'                    => 'Java',
                'slug'                    => 'java',
                'icon_path'               => null,
                'icon_class'              => 'fab fa-java',
                'color'                   => '#007396',
                'proficiency_level'       => 'intermedio',
                'proficiency_percentage'  => 50,
                'is_active'               => true,
            ],
            [
                'technologie_category_id' => $languages->id,
                'name'                   => 'Python',
                'slug'                   => 'python',          // ✅ simpleicons.org/python
                'icon_path'              => null,
                'icon_class'             => 'fab fa-python',
                'color'                  => '#3776AB',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 50,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $languages->id,
                'name'                   => 'Go',
                'slug'                   => 'go',              // ✅ simpleicons.org/go
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#00ADD8',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 50,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $languages->id,
                'name'                   => 'PHP',
                'slug'                   => 'php',             // ✅ simpleicons.org/php
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#777BB4',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 50,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $languages->id,
                'name'                   => 'HTML',
                'slug'                   => 'html5',           // ✅ simpleicons.org/html5
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#E34F26',
                'proficiency_level'      => 'avanzado',
                'proficiency_percentage' => 80,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $languages->id,
                'name'                   => 'CSS',
                'slug'                   => 'css',            // ✅ simpleicons.org/css3
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#1572B6',
                'proficiency_level'      => 'avanzado',
                'proficiency_percentage' => 80,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $languages->id,
                'name'                   => 'JavaScript',
                'slug'                   => 'javascript',      // ✅ simpleicons.org/javascript
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#F7DF1E',
                'proficiency_level'      => 'avanzado',
                'proficiency_percentage' => 70,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $languages->id,
                'name'                   => 'TypeScript',
                'slug'                   => 'typescript',      // ✅ simpleicons.org/typescript
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#3178C6',
                'proficiency_level'      => 'avanzado',
                'proficiency_percentage' => 70,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $languages->id,
                'name'                   => 'Dart',
                'slug'                   => 'dart',            // ✅ simpleicons.org/dart
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#00B4E8',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 50,
                'is_active'              => true,
            ],
            // ============================================
            // FRAMEWORKS & LIBRERÍAS
            // ============================================
            [
                'technologie_category_id' => $frameworks->id,
                'name'                   => 'Laravel',
                'slug'                   => 'laravel',         // ✅ simpleicons.org/laravel
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#FF2D20',
                'proficiency_level'      => 'avanzado',
                'proficiency_percentage' => 85,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $frameworks->id,
                'name'                   => 'Angular',
                'slug'                   => 'angular',         // ✅ simpleicons.org/angular
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#DD0031',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 50,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $frameworks->id,
                'name'                   => 'Spring Framework',
                'slug'                   => 'spring',          // ✅ simpleicons.org/spring
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#6DB33F',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 30,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $frameworks->id,
                'name'                   => 'Flutter',
                'slug'                   => 'flutter',         // ✅ simpleicons.org/flutter
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#00B4E8',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 30,
                'is_active'              => true,
            ],
            // [
            //     'technologie_category_id' => $frameworks->id,
            //     'name'                   => 'React',
            //     'slug'                   => 'react',           // ✅ simpleicons.org/react
            //     'icon_path'              => null,
            //     'icon_class'             => null,
            //     'color'                  => '#61DAFB',
            //     'proficiency_level'      => 'intermedio',
            //     'proficiency_percentage' => 65,
            //     'is_active'              => true,
            // ],
            // [
            //     'technologie_category_id' => $frameworks->id,
            //     'name'                   => 'Vue.js',
            //     'slug'                   => 'vuedotjs',        // ✅ simpleicons.org/vuedotjs
            //     'icon_path'              => null,
            //     'icon_class'             => null,
            //     'color'                  => '#42B883',
            //     'proficiency_level'      => 'intermedio',
            //     'proficiency_percentage' => 65,
            //     'is_active'              => true,
            // ],
            [
                'technologie_category_id' => $frameworks->id,
                'name'                   => 'Tailwind CSS',
                'slug'                   => 'tailwindcss',     // ✅ simpleicons.org/tailwindcss
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#06B6D4',
                'proficiency_level'      => 'avanzado',
                'proficiency_percentage' => 75,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $frameworks->id,
                'name'                   => 'Bootstrap',
                'slug'                   => 'bootstrap',       // ✅ simpleicons.org/bootstrap
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#7952B3',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 65,
                'is_active'              => true,
            ],
            // ============================================
            // BASES DE DATOS
            // ============================================
            [
                'technologie_category_id' => $databases->id,
                'name'                   => 'SQLite',
                'slug'                   => 'sqlite',          // ✅ simpleicons.org/sqlite
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#003B57',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 60,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $databases->id,
                'name'                   => 'MySQL',
                'slug'                   => 'mysql',           // ✅ simpleicons.org/mysql
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#4479A1',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 65,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $databases->id,
                'name'                   => 'Oracle Database',
                'slug'                   => 'oracledatabase',          // ✅ simpleicons.org/oracle
                'icon_path'              => null,
                'icon_class'             => 'fa fa-database',            // ⚠️ Simple Icons no tiene Oracle Database → usa icon_class
                'color'                  => '#F80000',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 50,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $databases->id,
                'name'                   => 'SQL Server',
                'slug'                   => 'microsoftsqlserver',
                'icon_path'              => null,
                'icon_class'             => 'devicon-microsoftsqlserver-plain',      // ⚠️ Simple Icons no tiene Microsoft SQL Server → usa icon_class
                'color'                  => '#CC2927',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 50,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $databases->id,
                'name'                   => 'PostgreSQL',
                'slug'                   => 'postgresql',      // ✅ simpleicons.org/postgresql
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#336791',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 50,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $databases->id,
                'name'                   => 'MongoDB',
                'slug'                   => 'mongodb',         // ✅ simpleicons.org/mongodb
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#47A248',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 30,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $databases->id,
                'name'                   => 'Redis',
                'slug'                   => 'redis',           // ✅ simpleicons.org/redis
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#DC382D',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 20,
                'is_active'              => true,
            ],

            // ============================================
            // IoT
            // ============================================
            [
                'technologie_category_id' => $iot->id,
                'name'                   => 'STM32',
                'slug'                   => 'stmicroelectronics',            // ✅ simpleicons.org/mqtt
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#03234B',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 25,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $iot->id,
                'name'                   => 'ESP32',
                'slug'                   => 'espressif',            // ✅ simpleicons.org/mqtt
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#E7352C',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 25,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $iot->id,
                'name'                   => 'Arduino',
                'slug'                   => 'arduino',         // ✅ simpleicons.org/arduino
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#00979D',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 35,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $iot->id,
                'name'                   => 'Raspberry Pi',
                'slug'                   => 'raspberrypi',     // ✅ simpleicons.org/raspberrypi
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#C51A4A',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 35,
                'is_active'              => true,
            ],

            // ============================================
            // IA
            // ============================================
            // ============================================
            // IA
            // ============================================
            [
                'technologie_category_id' => $ia->id,
                'name'                   => 'Machine Learning',
                'slug'                   => 'machine-learning',
                'icon_path'              => null,
                'icon_class'             => 'fas fa-brain',
                'color'                  => '#3B82F6',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 30,
                'is_active'              => true,
            ],

            [
                'technologie_category_id' => $ia->id,
                'name'                   => 'Deep Learning',
                'slug'                   => 'deep-learning',
                'icon_path'              => null,
                'icon_class'             => 'fas fa-network-wired',
                'color'                  => '#EC4899',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 30,
                'is_active'              => true,
            ],

            [
                'technologie_category_id' => $ia->id,
                'name'                   => 'Computer Vision',
                'slug'                   => 'computer-vision',
                'icon_path'              => null,
                'icon_class'             => 'fas fa-eye',
                'color'                  => '#8B5CF6',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 30,
                'is_active'              => true,
            ],

            [
                'technologie_category_id' => $ia->id,
                'name'                   => 'NLP',
                'slug'                   => 'nlp',
                'icon_path'              => null,
                'icon_class'             => 'fas fa-comments',
                'color'                  => '#10B981',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 30,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $ia->id,
                'name'                   => 'Computer Vision',
                'slug'                   => 'computer-vision', // ⚠️ Sin Simple Icons → usa icon_class
                'icon_path'              => null,
                'icon_class'             => 'fas fa-eye',
                'color'                  => '#8B5CF6',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 30,
                'is_active'              => true,
            ],

            // ============================================
            // CLOUD
            // ============================================
            [
                'technologie_category_id' => $cloud->id,
                'name' => 'Google Cloud',
                'slug' => 'googlecloud',
                'icon_path' => null,
                'icon_class' => 'devicon-googlecloud-plain',
                'color' => '#4285F4',
                'proficiency_level' => 'basico',
                'proficiency_percentage' => 30,
                'is_active' => true,
            ],
            [
                'technologie_category_id' => $cloud->id,
                'name' => 'Amazon Web Services',
                'slug' => 'amazonaws',
                'icon_path' => null,
                'icon_class' => 'fa-brands fa-aws',
                'color' => '#FF9900',
                'proficiency_level' => 'basico',
                'proficiency_percentage' => 20,
                'is_active' => true,
            ],
            [
                'technologie_category_id' => $cloud->id,
                'name' => 'Microsoft Azure',
                'slug' => 'microsoftazure',
                'icon_path' => null,
                'icon_class' => 'devicon-azure-plain',
                'color' => '#0078D4',
                'proficiency_level' => 'basico',
                'proficiency_percentage' => 20,
                'is_active' => true,
            ],

            // ============================================
            // DEVOPS
            // ============================================
            [
                'technologie_category_id' => $devops->id,
                'name'                   => 'Docker',
                'slug'                   => 'docker',
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#2496ED',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 25,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $devops->id,
                'name'                   => 'Kubernetes',
                'slug'                   => 'kubernetes',
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#326CE5',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 15,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $devops->id,
                'name'                   => 'GitHub Actions',
                'slug'                   => 'githubactions',
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#2088FF',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 30,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $devops->id,
                'name'                   => 'Jenkins',
                'slug'                   => 'jenkins',
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#D24939',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 10,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $devops->id,
                'name'                   => 'Terraform',
                'slug'                   => 'terraform',
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#844FBA',
                'proficiency_level'      => 'basico',
                'proficiency_percentage' => 20,
                'is_active'              => true,
            ],

            // ============================================
            // VERSION CONTROL
            // ============================================
            [
                'technologie_category_id' => $repository->id,
                'name'                   => 'Git',
                'slug'                   => 'git',             // ✅ simpleicons.org/git
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#F05032',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 50,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $repository->id,
                'name'                   => 'GitHub',
                'slug'                   => 'github',          // ✅ simpleicons.org/github
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#181717',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 50,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $repository->id,
                'name'                   => 'GitLab',
                'slug'                   => 'gitlab',
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#FC6D26',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 40,
                'is_active'              => true,
            ],
            // [
            //     'technologie_category_id' => $repository->id,
            //     'name'                   => 'Bitbucket',
            //     'slug'                   => 'bitbucket',
            //     'icon_path'              => null,
            //     'icon_class'             => null,
            //     'color'                  => '#0052CC',
            //     'proficiency_level'      => 'intermedio',
            //     'proficiency_percentage' => 50,
            //     'is_active'              => true,
            // ],

            // ============================================
            // TOOLS & OTHERS
            // ============================================
            [
                'technologie_category_id' => $tools->id,
                'name'                   => 'VS Code',
                'slug'                   => 'visualstudiocode', // ✅ simpleicons.org/visualstudiocode
                'icon_path'              => null,
                'icon_class'             => 'devicon-vscode-plain colored',
                'color'                  => '#007ACC',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 65,
                'is_active'              => true,
            ],
            [
                'technologie_category_id' => $tools->id,
                'name'                   => 'Postman',
                'slug'                   => 'postman',         // ✅ simpleicons.org/postman
                'icon_path'              => null,
                'icon_class'             => null,
                'color'                  => '#FF6C37',
                'proficiency_level'      => 'intermedio',
                'proficiency_percentage' => 45,
                'is_active'              => true,
            ],
            // [
            //     'technologie_category_id' => $tools->id,
            //     'name'                   => 'npm',
            //     'slug'                   => 'npm',             // ✅ simpleicons.org/npm
            //     'icon_path'              => null,
            //     'icon_class'             => null,
            //     'color'                  => '#CB3837',
            //     'proficiency_level'      => 'intermedio',
            //     'proficiency_percentage' => 50,
            //     'is_active'              => true,
            // ],
        ];

        foreach ($technologies as $technology) {
            Technology::updateOrCreate(
                ['slug' => $technology['slug']],
                $technology
            );
        }

        $this->command->info('✅ Tecnologías creadas/actualizadas correctamente.');
        $this->command->info('📦 Total: ' . count($technologies) . ' tecnologías.');
    }
}
