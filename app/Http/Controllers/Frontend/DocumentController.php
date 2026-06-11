<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    /**
     * Mostrar listado de documentos descargables
     */
    public function index()
    {
        try {
            $documents = Document::active()->orderBy('id')->get();
            $stats     = Document::getStats();

            return view('frontend.pages.documents', compact('documents', 'stats'));

        } catch (\Exception $e) {
            Log::error('Error al cargar página de documentos: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            if (config('app.debug')) throw $e;

            abort(500, 'Error al cargar la página de documentos.');
        }
    }

    /**
     * Descargar documento e incrementar contador
     */
    public function download(int $id)
    {
        try {
            $document = Document::active()->findOrFail($id);

            if (!$document->file_path || !Storage::disk('public')->exists($document->file_path)) {
                Log::warning('Archivo no encontrado en storage al intentar descargar', [
                    'document_id' => $id,
                    'file_path'   => $document->file_path,
                ]);
                abort(404, 'El archivo no está disponible.');
            }

            $document->incrementDownloads();

            Log::info('Documento descargado', [
                'document_id'    => $document->id,
                'title'          => $document->title,
                'file_name'      => $document->file_name,
                'download_count' => $document->download_count,
                'ip'             => request()->ip(),
            ]);

            return response()->download(
                Storage::disk('public')->path($document->file_path),
                $document->file_name,
                ['Content-Type' => 'application/pdf']
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Documento no encontrado.');

        } catch (\Exception $e) {
            Log::error('Error al descargar documento: ' . $e->getMessage(), [
                'document_id' => $id,
                'trace'       => $e->getTraceAsString(),
            ]);

            if (config('app.debug')) throw $e;

            abort(500, 'Error al descargar el documento. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Ver documento en el navegador (nueva pestaña, sin incrementar descargas)
     */
    public function view(int $id)
    {
        try {
            $document = Document::active()->findOrFail($id);

            if (!$document->file_path || !Storage::disk('public')->exists($document->file_path)) {
                Log::warning('Archivo no encontrado en storage al intentar visualizar', [
                    'document_id' => $id,
                    'file_path'   => $document->file_path,
                ]);
                abort(404, 'El archivo no está disponible.');
            }

            Log::info('Documento visualizado', [
                'document_id' => $document->id,
                'title'       => $document->title,
                'ip'          => request()->ip(),
            ]);

            return response()->file(
                Storage::disk('public')->path($document->file_path),
                ['Content-Type' => 'application/pdf']
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Documento no encontrado.');

        } catch (\Exception $e) {
            Log::error('Error al visualizar documento: ' . $e->getMessage(), [
                'document_id' => $id,
                'trace'       => $e->getTraceAsString(),
            ]);

            if (config('app.debug')) throw $e;

            abort(500, 'Error al visualizar el documento.');
        }
    }
}