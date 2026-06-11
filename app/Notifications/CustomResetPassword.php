<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    protected $token;

    /**
     * Create a new notification instance.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     * 
     * @Author: Edwin Yoner
     * @Date: 2025-09-12
     * @Change: Vista Blade personalizada con colores dinámicos del portafolio
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // Obtener configuración del portafolio y perfil
        $portfolio = portfolio();
        $profile = \App\Models\ProfileSetting::first();
        
        // Colores dinámicos (usando helpers)
        $primaryColor = color('primary');
        $secondaryColor = color('secondary');
        
        // Convertir hex a RGB para sombras (usando helper)
        $primaryColorRGB = hexToRgb($primaryColor);
        
        // Generar tonos claros para el fondo (usando helper)
        $primaryColorLight = adjustBrightness($primaryColor, 200);
        $primaryColorLighter = adjustBrightness($primaryColor, 220);

        // Vista Blade con variables dinámicas
        return (new MailMessage)
            ->subject('Restablecimiento de contraseña - ' . ($profile->full_name ?? 'Portafolio'))
            ->view('emails.reset-password', [
                'user' => $notifiable,
                'url' => $url,
                
                // Información del portafolio
                'ownerName' => $profile->full_name ?? 'Portafolio',
                'ownerTitle' => $profile->professional_title ?? 'Bach. Ingeniería De Sistemas E Informática',
                'supportEmail' => $portfolio->email_contact ?? null,
                'logoUrl' => $portfolio->logo_path 
                    ? asset('storage/' . $portfolio->logo_path) 
                    : null,
                
                // Colores dinámicos
                'primaryColor' => $primaryColor,
                'secondaryColor' => $secondaryColor,
                'primaryColorRGB' => $primaryColorRGB,
                'primaryColorLight' => $primaryColorLight,
                'primaryColorLighter' => $primaryColorLighter,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}