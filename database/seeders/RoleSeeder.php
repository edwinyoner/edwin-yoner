<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================
        // ROLES DEL SISTEMA
        // ============================================
        // Admin: Acceso total al sistema
        // Editor: Puede gestionar contenido del portafolio
        // Viewer: Solo lectura
        // ============================================
        
        $roles = ['Admin', 'Editor', 'Viewer'];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role, 
                'guard_name' => 'web'
            ]);

            // Para usuarios API (tokens)
            // Role::firstOrCreate([
            //     'name' => $role, 
            //     'guard_name' => 'sanctum'
            // ]);
        }

        $this->command->info('✓ ' . count($roles) . ' roles creados exitosamente.');
    }
}