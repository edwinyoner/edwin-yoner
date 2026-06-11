<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Http\Requests\DocumentRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Mostrar listado de documentos
     */
    public function index()
    {
        try {
            Log::info('Acceso a listado de documentos', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
            ]);

            $documents = Document::latest()->get();
            
            return view('backend.documents.index', compact('documents'));
            
        } catch (\Exception $e) {
            Log::error('Error al cargar documentos: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('backend.dashboard')
                ->with('error', 'Error al cargar los documentos.');
        }
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        Log::info('Acceso a formulario de creación de documento', [
            'user_id' => auth()->id(),
        ]);

        return view('backend.documents.create');
    }

    /**
     * Guardar nuevo documento
     */
    public function store(DocumentRequest $request)
    {
        try {
            Log::info('Iniciando creación de documento', [
                'user_id' => auth()->id(),
                'title' => $request->input('title'),
            ]);

            DB::beginTransaction();

            $validated = $request->validated();

            // Procesar archivo PDF si existe
            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                $validated['file_path'] = $file->store('documents/', 'public');
                $validated['file_name'] = $file->getClientOriginalName();
                
                Log::info('Archivo PDF guardado', [
                    'path' => $validated['file_path'],
                ]);
            }

            $document = Document::create($validated);

            $this->clearDocumentCache();

            DB::commit();

            Log::info('Documento creado exitosamente', [
                'document_id' => $document->id,
                'title' => $document->title,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.documents.index')
                ->with('success', 'Documento creado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al crear documento: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el documento. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Mostrar detalle de documento
     */
    public function show(Document $document)
    {
        Log::info('Visualización de documento', [
            'document_id' => $document->id,
            'title' => $document->title,
            'user_id' => auth()->id(),
        ]);

        return view('backend.documents.show', compact('document'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Document $document)
    {
        Log::info('Acceso a formulario de edición de documento', [
            'document_id' => $document->id,
            'title' => $document->title,
            'user_id' => auth()->id(),
        ]);

        return view('backend.documents.edit', compact('document'));
    }

    /**
     * Actualizar documento existente
     */
    public function update(DocumentRequest $request, Document $document)
    {
        try {
            Log::info('Iniciando actualización de documento', [
                'document_id' => $document->id,
                'title' => $document->title,
                'user_id' => auth()->id(),
            ]);

            DB::beginTransaction();

            $validated = $request->validated();

            // Procesar nuevo archivo PDF si existe
            if ($request->hasFile('file_path')) {
                // Eliminar archivo anterior
                if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                    Log::info('Archivo anterior eliminado', [
                        'path' => $document->file_path,
                    ]);
                }
                
                $file = $request->file('file_path');
                $validated['file_path'] = $file->store('documents/', 'public');
                $validated['file_name'] = $file->getClientOriginalName();
                
                Log::info('Archivo PDF actualizado', [
                    'new_path' => $validated['file_path'],
                ]);
            }

            $document->update($validated);

            $this->clearDocumentCache();

            DB::commit();

            Log::info('Documento actualizado exitosamente', [
                'document_id' => $document->id,
                'title' => $document->title,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.documents.index')
                ->with('success', 'Documento actualizado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar documento: ' . $e->getMessage(), [
                'document_id' => $document->id,
                'user_id' => auth()->id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el documento. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Eliminar documento
     */
    public function destroy(Document $document)
    {
        try {
            Log::info('Intento de eliminar documento', [
                'document_id' => $document->id,
                'title' => $document->title,
                'user_id' => auth()->id(),
            ]);

            DB::beginTransaction();

            // Eliminar archivo PDF si existe
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
                Log::info('Archivo PDF eliminado', [
                    'path' => $document->file_path,
                ]);
            }

            $title = $document->title;
            $document->delete();

            $this->clearDocumentCache();

            DB::commit();

            Log::info('Documento eliminado exitosamente', [
                'document_id' => $document->id,
                'title' => $title,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.documents.index')
                ->with('success', 'Documento eliminado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al eliminar documento: ' . $e->getMessage(), [
                'document_id' => $document->id,
                'user_id' => auth()->id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al eliminar el documento.');
        }
    }

    /**
     * Limpiar caché de documentos
     */
    private function clearDocumentCache(): void
    {
        Cache::forget('documents');
        Cache::forget('active_documents');
    }
}