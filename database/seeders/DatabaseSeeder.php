<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Ejecutar todos los seeders en orden:
     * php artisan db:seed
     * 
     * Ejecutar solo uno específico:
     * php artisan db:seed --class=ProfileSettingSeeder
     * 
     * Refrescar BD y ejecutar todos los seeders:
     * php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        $this->call([
            // ============================================
            // 1. SISTEMA BASE (Usuarios, Roles, Permisos)
            // ============================================
            PermissionSeeder::class,
            RoleSeeder::class,
            RolePermissionSeeder::class,
            

            // ============================================
            // 2. CONFIGURACIÓN DEL PORTAFOLIO
            // ============================================
            PortfolioSettingSeeder::class,    // Configuración general (colores, contacto)
            ProfileSettingSeeder::class,      // Perfil personal (nombre, bio, foto)
            SocialLinkSeeder::class,          // Redes sociales

            // ============================================
            // 3. CATEGORÍAS (Sin dependencias)
            // ============================================
            TechnologieCategorySeeder::class, // Frontend, Backend, Databases, etc.

            // ============================================
            // 4. ENTIDADES PRINCIPALES (Con dependencias)
            // ============================================
            TechnologySeeder::class,          // Laravel, Angular, MySQL, etc.
            ProjectSeeder::class,             // Smart Parking, Gestión Patrimonial
            
            // ============================================
            // 5. RELACIONES PIVOT (Muchos a Muchos)
            // ============================================
            ProjectTechnologySeeder::class,   // Asociar tecnologías a proyectos

            // ============================================
            // 6. DOCUMENTOS DESCARGABLES
            // ============================================
            DocumentSeeder::class,            // CV, certificados, portfolio PDF
        
            UserSeeder::class,                 // Usuario administrador con email de bienvenida
        ]);

        $this->command->info('');
        $this->command->info('¡Todos los seeders ejecutados correctamente!');
        $this->command->info('');
        $this->command->info('Resumen:');
        $this->command->info('  ✓ Sistema base configurado');
        $this->command->info('  ✓ Perfil personal creado');
        $this->command->info('  ✓ ' . \App\Models\TechnologieCategory::count() . ' categorías de tecnologías');
        $this->command->info('  ✓ ' . \App\Models\Technology::count() . ' tecnologías');
        $this->command->info('  ✓ ' . \App\Models\Project::count() . ' proyectos');
        $this->command->info('  ✓ ' . \App\Models\Document::count() . ' documentos');
        $this->command->info('  ✓ ' . \App\Models\SocialLink::count() . ' redes sociales');
        $this->command->info('');
    }
}