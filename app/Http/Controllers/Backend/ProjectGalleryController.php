<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectGallery;
use App\Http\Requests\ProjectGalleryRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProjectGalleryController extends Controller
{
    /**
     * Guardar nueva imagen en la galería
     *
     * Ruta: POST /projects/{project}/gallery
     */
    public function store(ProjectGalleryRequest $request, Project $project)
    {
        try {
            $currentCount = $project->galleries()->count();

            if ($currentCount >= 5) {
                return redirect()->back()
                    ->with('error', 'El proyecto ya tiene el máximo de 5 imágenes en la galería.');
            }

            DB::beginTransaction();

            $validated            = $request->validated();
            $validated['project_id'] = $project->id;

            if ($request->hasFile('image_path')) {
                $validated['image_path'] = $request->file('image_path')
                    ->store('projects/galleries/' . $project->id, 'public');
            }

            $gallery = ProjectGallery::create($validated);

            Cache::forget('project_' . $project->id);

            DB::commit();

            Log::info('Imagen de galería creada', [
                'gallery_id' => $gallery->id,
                'project_id' => $project->id,
                'user_id'    => auth()->id(),
            ]);

            return redirect()->route('backend.projects.show', $project->id)
                ->with('success', 'Imagen agregada a la galería correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al crear imagen de galería: ' . $e->getMessage(), [
                'project_id' => $project->id,
                'user_id'    => auth()->id(),
            ]);

            return redirect()->back()
                ->with('error', 'Error al agregar la imagen. Intenta nuevamente.');
        }
    }

    /**
     * Eliminar imagen de la galería
     *
     * Ruta: DELETE /projects/{project}/gallery/{gallery}
     */
    public function destroy(Project $project, ProjectGallery $gallery)
    {
        try {
            if ($gallery->project_id !== $project->id) {
                abort(404);
            }

            DB::beginTransaction();

            if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }

            $gallery->delete();

            Cache::forget('project_' . $project->id);

            DB::commit();

            Log::info('Imagen de galería eliminada', [
                'gallery_id' => $gallery->id,
                'project_id' => $project->id,
                'user_id'    => auth()->id(),
            ]);

            return redirect()->route('backend.projects.show', $project->id)
                ->with('success', 'Imagen eliminada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al eliminar imagen de galería: ' . $e->getMessage(), [
                'gallery_id' => $gallery->id,
                'project_id' => $project->id,
                'user_id'    => auth()->id(),
            ]);

            return redirect()->back()
                ->with('error', 'Error al eliminar la imagen.');
        }
    }
}