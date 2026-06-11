<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class NewUserCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $loginUrl;
    public $verificationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $password, $loginUrl, $verificationUrl)
    {
        $this->user = $user;
        $this->password = $password;
        $this->loginUrl = $loginUrl;
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Obtener configuración del portafolio
        $portfolio = portfolio();
        $profile = \App\Models\ProfileSetting::first();
        $ownerName = $profile->full_name ?? config('app.name');

        return new Envelope(
            from: new Address(
                $portfolio->email_contact ?? 'noreply@portafolio.com',
                $ownerName . ' - Admin Panel'
            ),
            subject: 'Bienvenido al Panel de Administración - Confirma tu cuenta',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
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

        return new Content(
            view: 'emails.new-user-credentials',
            with: [
                'user' => $this->user,
                'password' => $this->password,
                'loginUrl' => $this->loginUrl,
                'verificationUrl' => $this->verificationUrl,
                
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
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}