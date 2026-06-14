<?php

namespace App\Mail;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The contact submission instance.
     *
     * @var ContactSubmission
     */
    public $submission;

    /**
     * Create a new message instance.
     *
     * @param ContactSubmission $submission
     */
    public function __construct(ContactSubmission $submission)
    {
        $this->submission = $submission;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        // Obtener configuración del portafolio
        $portfolio = portfolio();
        $profile = \App\Models\ProfileSetting::first();
        $ownerName = $profile->full_name ?? 'Portafolio';
        
        return new Envelope(
            from: new Address(
                config('mail.from.address'), // Email configurado en .env
                $ownerName . ' - Formulario de Contacto'
            ),
            replyTo: [
                new Address($this->submission->email, $this->submission->name)
            ],
            subject: '[Nuevo Mensaje] ' . $this->submission->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content(): Content
    {
        // Obtener configuración del portafolio y perfil
        $portfolio = portfolio();
        $profile = \App\Models\ProfileSetting::first();
        
        // Colores dinámicos (usando el helper)
        $primaryColor = color('primary');
        $secondaryColor = color('secondary');
        $primaryColorDark = adjustBrightness($primaryColor, -20);

        // URLs
        $websiteUrl = url('/');
        $websiteDomain = parse_url($websiteUrl, PHP_URL_HOST);

        return new Content(
            view: 'backend.emails.contact_form_submitted',
            with: [
                'submission' => $this->submission,
                'submittedAt' => $this->submission->created_at->format('d/m/Y H:i:s'),
                
                // Información del perfil
                'ownerName' => $profile->full_name ?? 'Edwin Yoner',
                'ownerTitle' => $profile->professional_title ?? 'Bach. Ingeniería de Sistemas E Informática',
                
                // Información del portafolio
                'contactEmail' => $portfolio->email_contact ?? null,
                'websiteUrl' => $websiteUrl,
                'websiteDomain' => $websiteDomain,
                
                // Colores dinámicos
                'primaryColor' => $primaryColor,
                'secondaryColor' => $secondaryColor,
                'primaryColorDark' => $primaryColorDark,
            ],
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

    /**
     * Get the tags for the message.
     *
     * @return array<string>
     */
    public function tags(): array
    {
        return ['contact-form', 'notification', 'portfolio'];
    }

    /**
     * Get the metadata for the message.
     *
     * @return $this
     */
    public function metadata($key = null, $value = null)
    {
        if ($key === null) {
            return $this;
        }

        return $this->withMetadata($key, $value);
    }
}