<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfileSetting;

class ProfileSettingSeeder extends Seeder
{
    /**
     * Datos del perfil personal para el portafolio
     * IMPORTANTE: Solo puede haber UN registro en esta tabla (singleton)
     */
    public function run(): void
    {
        ProfileSetting::updateOrCreate(
            ['id' => 1], // Siempre el mismo ID
            [
                // ============================================
                // INFORMACIÓN PERSONAL
                // ============================================
                'profile_image' => null, // TODO: Subir foto y cambiar por: 'profile/edwin-yoner.jpg'
                
                'full_name' => 'Edwin Yoner',
                
                'professional_title' => 'Bach. Ingeniería de Sistemas e Informática',
                
                // ============================================
                // BIOGRAFÍA CORTA (Para sección HERO/HOME)
                // ============================================
                'bio_short' => 'Apasionado por la tecnología con conocimiento integral en áreas clave como Inteligencia Artificial, Internet de las Cosas, Cloud Computing, Big Data, Sistemas Operativos, Software y Hardware.',
                
                // ============================================
                // BIOGRAFÍA EXTENDIDA (Para modal "Leer más")
                // ============================================
                'bio_long' => 'Bach. Ingeniería De Sistemas E Informática con amplia experiencia en el desarrollo de aplicaciones web y sistemas embebidos. Especializado en tecnologías como Laravel, Spring Boot, Angular, y con sólidos conocimientos en IoT utilizando Arduino, Raspberry Pi y protocolos como MQTT.

Me apasiona crear soluciones tecnológicas innovadoras que resuelvan problemas reales, desde sistemas de Smart Parking hasta plataformas gubernamentales de alto impacto. Comprometido con el aprendizaje continuo y las mejores prácticas de desarrollo de software.

Experiencia trabajando con bases de datos relacionales (MySQL, PostgreSQL, Oracle Database, SQL Server) y tecnologías de vanguardia en Inteligencia Artificial y Cloud Computing.',
                
                // ============================================
                // UBICACIÓN
                // ============================================
                'city' => 'Lima',
                'country' => 'Perú',
            ]
        );

        $this->command->info('Perfil personal creado/actualizado correctamente.');
    }
}