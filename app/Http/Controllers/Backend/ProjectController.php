<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Mostrar listado de proyectos
     */
    public function index()
    {
        try {
            Log::info('Acceso a listado de proyectos', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
            ]);

            $projects = Project::with(['technologies'])
                ->withCount(['technologies', 'galleries'])
                ->latest()
                ->get();
            
            return view('backend.projects.index', compact('projects'));
            
        } catch (\Exception $e) {
            Log::error('Error al cargar proyectos: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('backend.dashboard')
                ->with('error', 'Error al cargar los proyectos.');
        }
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        Log::info('Acceso a formulario de creación de proyecto', [
            'user_id' => auth()->id(),
        ]);
        $technologies = Technology::active()->orderBy('id')->get();

        return view('backend.projects.create', compact('technologies'));
    }

    /**
     * Guardar nuevo proyecto
     */
    public function store(ProjectRequest $request)
    {
        try {
            Log::info('Iniciando creación de proyecto', [
                'user_id' => auth()->id(),
                'data' => $request->validated(),
            ]);

            DB::beginTransaction();

            $validated = $request->validated();

            // Procesar imagen thumbnail si existe
            if ($request->hasFile('thumbnail_image')) {
                $validated['thumbnail_image'] = $request->file('thumbnail_image')
                    ->store('projects/thumbnails', 'public');
                
                Log::info('Thumbnail de proyecto guardado', [
                    'path' => $validated['thumbnail_image'],
                ]);
            }

            $project = Project::create($validated);

            // Sincronizar tecnologías si vienen
            if ($request->has('technologies')) {
                $project->technologies()->sync($request->input('technologies', []));
                
                Log::info('Tecnologías asociadas al proyecto', [
                    'project_id' => $project->id,
                    'technologies' => $request->input('technologies', []),
                ]);
            }

            Cache::forget('projects');
            Cache::forget('active_projects');
            Cache::forget('featured_projects');

            DB::commit();

            Log::info('Proyecto creado exitosamente', [
                'project_id' => $project->id,
                'title' => $project->title,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.projects.index')
                ->with('success', 'Proyecto creado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al crear proyecto: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'request_data' => $request->validated(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el proyecto. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Mostrar detalle de proyecto
     */
    public function show(Project $project)
    {
        Log::info('Visualización de proyecto', [
            'project_id' => $project->id,
            'title' => $project->title,
            'user_id' => auth()->id(),
        ]);

        $project->load(['technologies', 'galleries']);

        return view('backend.projects.show', compact('project'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Project $project)
    {
        Log::info('Acceso a formulario de edición de proyecto', [
            'project_id' => $project->id,
            'title' => $project->title,
            'user_id' => auth()->id(),
        ]);

        $technologies = Technology::active()->orderBy('id')->get();
        
        // IDs de tecnologías ya asociadas
        $selectedTechnologies = $project->technologies->pluck('id')->toArray();

        return view('backend.projects.edit', compact('project', 'technologies', 'selectedTechnologies'));
    }

    /**
     * Actualizar proyecto existente
     */
    public function update(ProjectRequest $request, Project $project)
    {
        try {
            Log::info('Iniciando actualización de proyecto', [
                'project_id' => $project->id,
                'title' => $project->title,
                'user_id' => auth()->id(),
            ]);

            DB::beginTransaction();

            $validated = $request->validated();

            // Procesar nueva imagen thumbnail si existe
            if ($request->hasFile('thumbnail_image')) {
                // Eliminar thumbnail anterior
                if ($project->thumbnail_image && Storage::disk('public')->exists($project->thumbnail_image)) {
                    Storage::disk('public')->delete($project->thumbnail_image);
                }
                
                $validated['thumbnail_image'] = $request->file('thumbnail_image')
                    ->store('projects/thumbnails', 'public');
                
                Log::info('Thumbnail de proyecto actualizado', [
                    'new_path' => $validated['thumbnail_image'],
                ]);
            }

            $project->update($validated);

            // Sincronizar tecnologías
            if ($request->has('technologies')) {
                $project->technologies()->sync($request->input('technologies', []));
                
                Log::info('Tecnologías del proyecto actualizadas', [
                    'project_id' => $project->id,
                    'technologies' => $request->input('technologies', []),
                ]);
            } else {
                // Si no vienen tecnologías, desvincular todas
                $project->technologies()->sync([]);
            }

            Cache::forget('projects');
            Cache::forget('active_projects');
            Cache::forget('featured_projects');
            Cache::forget('project_' . $project->id);

            DB::commit();

            Log::info('Proyecto actualizado exitosamente', [
                'project_id' => $project->id,
                'title' => $project->title,
                'changes' => $project->getChanges(),
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.projects.index')
                ->with('success', 'Proyecto actualizado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar proyecto: ' . $e->getMessage(), [
                'project_id' => $project->id,
                'user_id' => auth()->id(),
                'request_data' => $request->validated(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el proyecto. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Eliminar proyecto
     */
    public function destroy(Project $project)
    {
        try {
            Log::info('Intento de eliminar proyecto', [
                'project_id' => $project->id,
                'title' => $project->title,
                'user_id' => auth()->id(),
            ]);

            DB::beginTransaction();

            // Desvincular tecnologías
            $project->technologies()->detach();

            // Eliminar imágenes de galería asociadas
            foreach ($project->galleries as $gallery) {
                if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                    Storage::disk('public')->delete($gallery->image_path);
                }
                $gallery->delete();
            }

            // Eliminar thumbnail si existe
            if ($project->thumbnail_image && Storage::disk('public')->exists($project->thumbnail_image)) {
                Storage::disk('public')->delete($project->thumbnail_image);
            }

            $title = $project->title;
            $project->delete();

            Cache::forget('projects');
            Cache::forget('active_projects');
            Cache::forget('featured_projects');

            DB::commit();

            Log::info('Proyecto eliminado exitosamente', [
                'project_id' => $project->id,
                'title' => $title,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.projects.index')
                ->with('success', 'Proyecto eliminado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al eliminar proyecto: ' . $e->getMessage(), [
                'project_id' => $project->id,
                'user_id' => auth()->id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al eliminar el proyecto.');
        }
    }

}