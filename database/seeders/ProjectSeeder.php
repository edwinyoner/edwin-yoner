<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectCategory;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Proyectos destacados del portafolio
     */
    public function run(): void
    {
        $projects = [
            // ============================================
            // PROYECTO 1: SMART PARKING SYSTEM
            // ============================================
            [
                'title' => 'Smart Parking System',
                'slug' => 'smart-parking-system',
                
                // Descripción corta (aparece en la card)
                'short_description' => 'Sistema inteligente de gestión de estacionamientos utilizando sensores IoT, Arduino y comunicación MQTT para monitoreo en tiempo real de espacios disponibles.',
                
                // Descripción completa (aparece en el modal)
                'long_description' => 'Smart Parking System es una solución integral de Internet de las Cosas diseñada para optimizar la gestión de estacionamientos mediante tecnología de sensores y comunicación en tiempo real.

El sistema utiliza sensores ultrasónicos conectados a placas Arduino para detectar la disponibilidad de espacios de estacionamiento. La información se transmite mediante el protocolo MQTT a un servidor central que procesa y almacena los datos en tiempo real.

La plataforma web desarrollada en Laravel permite a los administradores monitorear el estado de los espacios, generar reportes de ocupación, y visualizar estadísticas mediante dashboards interactivos. Los usuarios pueden consultar la disponibilidad de espacios a través de una aplicación web responsive.

Características principales:
- Monitoreo en tiempo real de espacios de estacionamiento
- Comunicación mediante protocolo MQTT para IoT
- Dashboard administrativo con estadísticas y reportes
- Notificaciones automáticas de disponibilidad
- Sistema escalable para múltiples zonas de estacionamiento
- Integración con bases de datos para histórico de datos',
                
                'thumbnail_image' => null, // TODO: Subir imagen del proyecto
                'video_url' => null, // TODO: Agregar video demo de YouTube (opcional)
                'project_url' => null, // TODO: Si está online, agregar URL
                'repository_url' => 'https://github.com/edwinyoner/smart-parking-system', // ← CAMBIAR por tu repo real
                'year' => 2025,
                'is_active' => true,
            ],

            // ============================================
            // PROYECTO 2: SISTEMA DE GESTIÓN PATRIMONIAL
            // ============================================
            [
                'title' => 'Sistema de Gestión Patrimonial',
                'slug' => 'sistema-gestion-patrimonial',
                
                // Descripción corta (aparece en la card)
                'short_description' => 'Plataforma web empresarial para el control y administración integral de activos patrimoniales, inventarios y asignación de bienes institucionales.',
                
                // Descripción completa (aparece en el modal)
                'long_description' => 'Sistema de Gestión Patrimonial es una solución empresarial desarrollada para facilitar el control, seguimiento y administración de activos y bienes patrimoniales de organizaciones e instituciones.

La plataforma permite registrar, clasificar y dar seguimiento a todos los activos de la institución, desde equipos tecnológicos hasta mobiliario e infraestructura. El sistema automatiza procesos de inventario, asignación de bienes a trabajadores, transferencias entre áreas y generación de reportes para auditorías.

Desarrollado con tecnologías modernas como Laravel para el backend y Angular para el frontend, el sistema ofrece una interfaz intuitiva y potentes funcionalidades de gestión.

Características principales:
- Registro y catalogación completa de activos patrimoniales
- Control de asignaciones y devoluciones de bienes
- Generación automática de códigos patrimoniales
- Sistema de alertas para mantenimientos preventivos
- Reportes personalizables para auditorías
- Control de depreciación de activos
- Gestión de transferencias entre áreas/sedes
- Trazabilidad completa del ciclo de vida de los bienes
- Generación de actas y documentos oficiales
- Dashboard con indicadores clave de gestión patrimonial',
                
                'thumbnail_image' => null, // TODO: Subir imagen del proyecto
                'video_url' => null, // TODO: Agregar video demo de YouTube (opcional)
                'project_url' => null, // TODO: Si está online, agregar URL
                'repository_url' => null, // NULL si es proyecto privado
                'year' => 2025,
                'is_active' => true,
            ],
        ];

        foreach ($projects as $projectData) {
            Project::updateOrCreate(
                ['slug' => $projectData['slug']], // Buscar por slug
                $projectData // Actualizar o crear con estos datos
            );
        }

        $this->command->info('Proyectos creados/actualizados correctamente.');
        $this->command->info('Total: ' . count($projects) . ' proyectos agregados.');
    }
}