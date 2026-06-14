<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PortfolioSetting;
use App\Models\ProfileSetting;
use App\Models\SocialLink;
use App\Models\ContactSubmission;
use App\Http\Requests\ContactSubmissionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactFormSubmitted;

class ContactController extends Controller
{
    /**
     * Mostrar la página de contacto del portafolio
     * 
     * Muestra:
     * - Formulario de contacto
     * - Información de contacto (email, teléfono, WhatsApp)
     * - Redes sociales
     * - Ubicación
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // ============================================
            // CONFIGURACIÓN Y PERFIL
            // ============================================
            
            // Configuración del portafolio (email, teléfono, WhatsApp)
            $settings = PortfolioSetting::firstOrFail();
            
            // Perfil personal (nombre, foto, ubicación)
            $profile = ProfileSetting::firstOrFail();
            
            // Redes sociales activas
            $socialLinks = SocialLink::where('is_active', true)
                ->orderBy('id')
                ->get();
            
            return view('frontend.pages.contact', compact(
                'settings',
                'profile',
                'socialLinks'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error al cargar página de contacto: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            abort(500, 'Error al cargar la página de contacto. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Guardar nuevo mensaje de contacto
     *
     * @param ContactSubmissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactSubmissionRequest $request)
    {
        try {
            DB::beginTransaction();

            // ============================================
            // CREAR REGISTRO EN BASE DE DATOS
            // ============================================
            $submission = ContactSubmission::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone, // Opcional (nullable)
                'subject' => $request->subject, // Opcional (nullable)
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'is_read' => false,
                'replied_at' => null,
            ]);

            // ============================================
            // ENVIAR EMAIL DE NOTIFICACIÓN
            // ============================================
            $this->sendNotificationEmail($submission);

            DB::commit();

            // ============================================
            // LOG DEL ENVÍO EXITOSO
            // ============================================
            Log::info('Nuevo mensaje de contacto recibido en portafolio', [
                'submission_id' => $submission->id,
                'name' => $submission->name,
                'email' => $submission->email,
                'subject' => $submission->subject ?? 'Sin asunto',
                'ip' => $submission->ip_address,
            ]);

            // ============================================
            // REDIRECCIONAR CON MENSAJE DE ÉXITO
            // ============================================
            return redirect()->route('frontend.contact.index')->with(
                'success',
                '¡Gracias por contactarme! Tu mensaje ha sido enviado exitosamente. ' .
                'Te responderé a la brevedad posible.'
            );
            
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al procesar mensaje de contacto: ' . $e->getMessage(), [
                'request_data' => $request->except(['_token', 'g-recaptcha-response']),
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('frontend.contact.index')
                ->withInput()
                ->with(
                    'error',
                    'Hubo un error al enviar tu mensaje. Por favor, intenta nuevamente ' .
                    'o contáctame directamente por email o WhatsApp.'
                );
        }
    }

    /**
     * Enviar email de notificación al propietario del portafolio
     *
     * @param ContactSubmission $submission
     * @return void
     */
    protected function sendNotificationEmail(ContactSubmission $submission): void
    {
        try {
            // ============================================
            // CONFIGURAR DESTINATARIOS
            // ============================================
            
            // Obtener email de contacto desde configuración
            $portfolioEmail = PortfolioSetting::first()->email_contact ?? null;
            
            // Lista de emails (puedes agregar más o configurar en .env)
            $recipients = array_filter([
                $portfolioEmail,
                //config('mail.from.address'), // Email configurado en .env
                // Puedes agregar emails adicionales:
                // 'edwinyoner@gmail.com',
            ]);

            // Validar que haya al menos un destinatario válido
            $recipients = array_filter($recipients, function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            });

            if (empty($recipients)) {
                Log::warning('No hay destinatarios válidos configurados para notificaciones de contacto');
                return;
            }

            // ============================================
            // ENVIAR EMAIL
            // ============================================
            Mail::to($recipients)->send(new ContactFormSubmitted($submission));

            Log::info('Email de notificación enviado correctamente', [
                'submission_id' => $submission->id,
                'recipients' => $recipients,
            ]);
            
        } catch (\Exception $e) {
            // Log del error pero no fallar la operación principal
            // El mensaje se guardó en BD, el email es secundario
            Log::error('Error al enviar email de notificación: ' . $e->getMessage(), [
                'submission_id' => $submission->id,
                'exception' => $e,
            ]);
        }
    }
}