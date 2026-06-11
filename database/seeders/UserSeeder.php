<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserCredentials;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * MODO PRODUCCIÓN: Envía emails con credenciales
     */
    public function run(): void
    {
        // ============================================
        // CONFIGURACIÓN
        // ============================================
        $email = 'edwinyoner@edwin-yoner.com';
        $name = 'Edwin Yoner';
        $password = Str::random(12); // Genera una contraseña aleatoria de 12 caracteres
        $hashedPassword = Hash::make($password);

        // ============================================
        // CREAR O ACTUALIZAR USUARIO
        // ============================================
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                //'email_verified_at' => $isDevelopment ? now() : null, // En dev: ya verificado
                //'force_password_change' => true,
                'status' => true,
            ]
        );


        $user->assignRole('Admin');


        // ============================================
        // ENVIAR EMAIL
        // ============================================

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        Mail::to($user->email)->send(
            new NewUserCredentials($user, $password, url('/login'), $verificationUrl)
        );

        // Forzar envío de notificación de verificación
        $user->sendEmailVerificationNotification();

        $this->command->info('✓ Email enviado a: ' . $user->email);


        // ============================================
        // REPORTE EN CONSOLA
        // ============================================
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('  ✓ Usuario Admin creado exitosamente');
        $this->command->info('========================================');
        $this->command->info('  Nombre:   ' . $user->name);
        $this->command->info('  Email:    ' . $user->email);

        $this->command->info('  Rol:      Admin');
        $this->command->info('  URL:      ' . url('/login'));
        $this->command->info('========================================');
        $this->command->info('');
    }
}
