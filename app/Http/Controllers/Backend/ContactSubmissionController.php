<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactSubmissionController extends Controller
{
    /**
     * Mostrar listado de mensajes de contacto
     */
    public function index()
    {
        try {
            Log::info('Acceso a listado de mensajes de contacto', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
            ]);

            $submissions = ContactSubmission::latest()->get();
            
            return view('backend.contact-submissions.index', compact('submissions'));
            
        } catch (\Exception $e) {
            Log::error('Error al cargar mensajes de contacto: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('backend.dashboard')
                ->with('error', 'Error al cargar los mensajes de contacto.');
        }
    }

    /**
     * Mostrar detalle de mensaje de contacto
     */
    public function show(ContactSubmission $contactSubmission)
    {
        try {
            Log::info('Visualización de mensaje de contacto', [
                'submission_id' => $contactSubmission->id,
                'name' => $contactSubmission->name,
                'user_id' => auth()->id(),
            ]);

            DB::beginTransaction();

            // Marcar como leído si no lo está
            if (!$contactSubmission->is_read) {
                $contactSubmission->markAsRead();
                
                Log::info('Mensaje marcado como leído automáticamente', [
                    'submission_id' => $contactSubmission->id,
                ]);
            }

            DB::commit();

            return view('backend.contact-submissions.show', compact('contactSubmission'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al cargar mensaje de contacto: ' . $e->getMessage(), [
                'submission_id' => $contactSubmission->id,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('backend.contact-submissions.index')
                ->with('error', 'Error al cargar el mensaje de contacto.');
        }
    }

    /**
     * Eliminar mensaje de contacto
     */
    public function destroy(ContactSubmission $contactSubmission)
    {
        try {
            Log::info('Intento de eliminar mensaje de contacto', [
                'submission_id' => $contactSubmission->id,
                'name' => $contactSubmission->name,
                'email' => $contactSubmission->email,
                'user_id' => auth()->id(),
            ]);

            DB::beginTransaction();

            $name = $contactSubmission->name;
            $contactSubmission->delete();

            DB::commit();

            Log::info('Mensaje de contacto eliminado exitosamente', [
                'submission_id' => $contactSubmission->id,
                'name' => $name,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.contact-submissions.index')
                ->with('success', 'Mensaje de contacto eliminado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al eliminar mensaje de contacto: ' . $e->getMessage(), [
                'submission_id' => $contactSubmission->id,
                'user_id' => auth()->id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al eliminar el mensaje de contacto.');
        }
    }

    /**
     * Alternar estado leído/no leído
     */
    public function toggleRead(ContactSubmission $contactSubmission)
    {
        try {
            Log::info('Cambiando estado de lectura de mensaje', [
                'submission_id' => $contactSubmission->id,
                'current_status' => $contactSubmission->is_read,
                'user_id' => auth()->id(),
            ]);

            DB::beginTransaction();

            if ($contactSubmission->is_read) {
                $contactSubmission->markAsUnread();
                $message = 'Mensaje marcado como no leído.';
            } else {
                $contactSubmission->markAsRead();
                $message = 'Mensaje marcado como leído.';
            }

            DB::commit();

            Log::info('Estado de lectura actualizado', [
                'submission_id' => $contactSubmission->id,
                'new_status' => $contactSubmission->is_read,
                'user_id' => auth()->id(),
            ]);

            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al cambiar estado de lectura: ' . $e->getMessage(), [
                'submission_id' => $contactSubmission->id,
                'user_id' => auth()->id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al actualizar el estado de lectura.');
        }
    }

    /**
     * Marcar mensaje como respondido
     */
    public function markAsReplied(ContactSubmission $contactSubmission)
    {
        try {
            Log::info('Marcando mensaje como respondido', [
                'submission_id' => $contactSubmission->id,
                'name' => $contactSubmission->name,
                'user_id' => auth()->id(),
            ]);

            DB::beginTransaction();

            $contactSubmission->markAsReplied();

            DB::commit();

            Log::info('Mensaje marcado como respondido', [
                'submission_id' => $contactSubmission->id,
                'replied_at' => $contactSubmission->replied_at,
                'user_id' => auth()->id(),
            ]);

            return redirect()->back()
                ->with('success', 'Mensaje marcado como respondido correctamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al marcar mensaje como respondido: ' . $e->getMessage(), [
                'submission_id' => $contactSubmission->id,
                'user_id' => auth()->id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al marcar el mensaje como respondido.');
        }
    }
}