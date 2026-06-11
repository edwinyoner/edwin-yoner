<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Resetear caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // ============================================
            // DASHBOARD
            // ============================================
            'ver dashboard',

            // ============================================
            // GESTIÓN DE USUARIOS
            // ============================================
            'ver usuarios',
            'crear usuarios',
            'actualizar usuarios',
            'eliminar usuarios',
            'gestionar roles de usuarios',

            // ============================================
            // GESTIÓN DE ROLES Y PERMISOS
            // ============================================
            'ver roles',
            'crear roles',
            'actualizar roles',
            'eliminar roles',
            'ver permisos',
            'crear permisos',
            'actualizar permisos',
            'eliminar permisos',

            // ============================================
            // CONFIGURACIÓN DEL PORTAFOLIO
            // ============================================
            'ver configuracion perfil',
            'editar configuracion perfil',
            'ver configuracion portafolio',
            'editar configuracion portafolio',

            // ============================================
            // REDES SOCIALES
            // ============================================
            'ver redes sociales',
            'crear redes sociales',
            'actualizar redes sociales',
            'eliminar redes sociales',

            // ============================================
            // CATEGORÍAS DE TECNOLOGÍAS
            // ============================================
            'ver categorias tecnologias',
            'crear categorias tecnologias',
            'actualizar categorias tecnologias',
            'eliminar categorias tecnologias',

            // ============================================
            // TECNOLOGÍAS
            // ============================================
            'ver tecnologias',
            'crear tecnologias',
            'actualizar tecnologias',
            'eliminar tecnologias',

            // ============================================
            // CATEGORÍAS DE PROYECTOS
            // ============================================
            'ver categorias proyectos',
            'crear categorias proyectos',
            'actualizar categorias proyectos',
            'eliminar categorias proyectos',

            // ============================================
            // PROYECTOS
            // ============================================
            'ver proyectos',
            'crear proyectos',
            'actualizar proyectos',
            'eliminar proyectos',

            // ============================================
            // GALERÍA DE PROYECTOS
            // ============================================
            'ver galeria proyectos',
            'crear galeria proyectos',
            'actualizar galeria proyectos',
            'eliminar galeria proyectos',

            // ============================================
            // DOCUMENTOS
            // ============================================
            'ver documentos',
            'crear documentos',
            'actualizar documentos',
            'eliminar documentos',
            'descargar documentos',

            // ============================================
            // MENSAJES DE CONTACTO
            // ============================================
            'ver mensajes contacto',
            'eliminar mensajes contacto',
            'marcar como leido',
            'marcar como respondido',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        $this->command->info('✓ ' . count($permissions) . ' permisos creados exitosamente.');
    }
}