<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================
        // OBTENER ROLES
        // ============================================
        $adminRole = Role::where('name', 'Admin')->first();
        $editorRole = Role::where('name', 'Editor')->first();
        $viewerRole = Role::where('name', 'Viewer')->first();

        // ============================================
        // ADMIN: Acceso total al sistema
        // ============================================
        $adminPermissions = Permission::all();
        $adminRole->syncPermissions($adminPermissions);

        // ============================================
        // EDITOR: Gestión de contenido del portafolio
        // ============================================
        $editorPermissions = [
            // Dashboard
            'ver dashboard',

            // Configuración del portafolio (puede editar perfil y settings)
            'ver configuracion perfil',
            'editar configuracion perfil',
            'ver configuracion portafolio',
            'editar configuracion portafolio',

            // Redes Sociales
            'ver redes sociales',
            'crear redes sociales',
            'actualizar redes sociales',
            'eliminar redes sociales',

            // Categorías y Tecnologías
            'ver categorias tecnologias',
            'crear categorias tecnologias',
            'actualizar categorias tecnologias',
            'eliminar categorias tecnologias',
            'ver tecnologias',
            'crear tecnologias',
            'actualizar tecnologias',
            'eliminar tecnologias',

            // Categorías y Proyectos
            'ver categorias proyectos',
            'crear categorias proyectos',
            'actualizar categorias proyectos',
            'eliminar categorias proyectos',
            'ver proyectos',
            'crear proyectos',
            'actualizar proyectos',
            'eliminar proyectos',

            // Galería de Proyectos
            'ver galeria proyectos',
            'crear galeria proyectos',
            'actualizar galeria proyectos',
            'eliminar galeria proyectos',

            // Documentos
            'ver documentos',
            'crear documentos',
            'actualizar documentos',
            'eliminar documentos',
            'descargar documentos',

            // Mensajes de Contacto
            'ver mensajes contacto',
            'marcar como leido',
            'marcar como respondido',
        ];

        $editorRole->syncPermissions($editorPermissions);

        // ============================================
        // VIEWER: Solo lectura
        // ============================================
        $viewerPermissions = [
            // Dashboard
            'ver dashboard',

            // Solo visualización
            'ver configuracion perfil',
            'ver configuracion portafolio',
            'ver redes sociales',
            'ver categorias tecnologias',
            'ver tecnologias',
            'ver categorias proyectos',
            'ver proyectos',
            'ver galeria proyectos',
            'ver documentos',
            'descargar documentos',
            'ver mensajes contacto',
        ];

        $viewerRole->syncPermissions($viewerPermissions);

        // ============================================
        // REPORTE DE ASIGNACIÓN
        // ============================================
        $this->command->info('✓ Permisos asignados a roles exitosamente.');
        $this->command->info('  - Admin: ' . $adminRole->permissions->count() . ' permisos (acceso total)');
        $this->command->info('  - Editor: ' . $editorRole->permissions->count() . ' permisos (gestión de contenido)');
        $this->command->info('  - Viewer: ' . $viewerRole->permissions->count() . ' permisos (solo lectura)');
    }
}