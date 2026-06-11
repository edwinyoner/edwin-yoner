<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Models\TechnologieCategory;
use App\Http\Requests\TechnologyRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TechnologyController extends Controller
{
    /**
     * Mostrar listado de tecnologías
     */
    public function index()
    {
        try {
            Log::info('Acceso a listado de tecnologías', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
            ]);

            $technologies = Technology::with('category')
                ->withCount('projects')
                ->orderBy('id')
                ->get();
            
            return view('backend.technologies.index', compact('technologies'));
            
        } catch (\Exception $e) {
            Log::error('Error al cargar tecnologías: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('backend.dashboard')
                ->with('error', 'Error al cargar las tecnologías.');
        }
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        Log::info('Acceso a formulario de creación de tecnología', [
            'user_id' => auth()->id(),
        ]);

        $categories = TechnologieCategory::active()->orderBy('name')->get();

        return view('backend.technologies.create', compact('categories'));
    }

    /**
     * Guardar nueva tecnología
     */
    public function store(TechnologyRequest $request)
    {
        try {
            Log::info('Iniciando creación de tecnología', [
                'user_id' => auth()->id(),
                'data' => $request->validated(),
            ]);

            DB::beginTransaction();

            $validated = $request->validated();

            // Procesar logo si existe
            if ($request->hasFile('icon_path')) {
                $validated['icon_path'] = $request->file('icon_path')
                    ->store('technologies/icons', 'public');
                
                Log::info('Icono de tecnología guardado', [
                    'path' => $validated['icon_path'],
                ]);
            }

            $technology = Technology::create($validated);

            Cache::forget('technologies');
            Cache::forget('active_technologies');
            Cache::forget('technologies_by_category');

            DB::commit();

            Log::info('Tecnología creada exitosamente', [
                'technology_id' => $technology->id,
                'name' => $technology->name,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.technologies.index')
                ->with('success', 'Tecnología creada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al crear tecnología: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'request_data' => $request->validated(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la tecnología. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Mostrar detalle de tecnología
     */
    public function show(Technology $technology)
    {
        Log::info('Visualización de tecnología', [
            'technology_id' => $technology->id,
            'name' => $technology->name,
            'user_id' => auth()->id(),
        ]);

        $technology->load(['category', 'projects']);

        return view('backend.technologies.show', compact('technology'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Technology $technology)
    {
        Log::info('Acceso a formulario de edición de tecnología', [
            'technology_id' => $technology->id,
            'name' => $technology->name,
            'user_id' => auth()->id(),
        ]);

        $categories = TechnologieCategory::active()->orderBy('name')->get();

        return view('backend.technologies.edit', compact('technology', 'categories'));
    }

    /**
     * Actualizar tecnología existente
     */
    public function update(TechnologyRequest $request, Technology $technology)
    {
        try {
            Log::info('Iniciando actualización de tecnología', [
                'technology_id' => $technology->id,
                'name' => $technology->name,
                'user_id' => auth()->id(),
            ]);

            DB::beginTransaction();

            $validated = $request->validated();

            // Procesar nuevo logo si existe
            if ($request->hasFile('icon_path')) {
                // Eliminar logo anterior
                if ($technology->icon_path && Storage::disk('public')->exists($technology->icon_path)) {
                    Storage::disk('public')->delete($technology->icon_path);
                }
                
                $validated['icon_path'] = $request->file('icon_path')
                    ->store('technologies/icons', 'public');
                
                Log::info('Icono de tecnología actualizado', [
                    'new_path' => $validated['icon_path'],
                ]);
            }

            $technology->update($validated);

            Cache::forget('technologies');
            Cache::forget('active_technologies');
            Cache::forget('technologies_by_category');
            Cache::forget('technology_' . $technology->id);

            DB::commit();

            Log::info('Tecnología actualizada exitosamente', [
                'technology_id' => $technology->id,
                'name' => $technology->name,
                'changes' => $technology->getChanges(),
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.technologies.index')
                ->with('success', 'Tecnología actualizada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar tecnología: ' . $e->getMessage(), [
                'technology_id' => $technology->id,
                'user_id' => auth()->id(),
                'request_data' => $request->validated(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la tecnología. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Eliminar tecnología
     */
    public function destroy(Technology $technology)
    {
        try {
            Log::info('Intento de eliminar tecnología', [
                'technology_id' => $technology->id,
                'name' => $technology->name,
                'user_id' => auth()->id(),
            ]);

            // Verificar si está asociada a proyectos
            $projectsCount = $technology->projects()->count();
            
            if ($projectsCount > 0) {
                Log::warning('Intento de eliminar tecnología con proyectos asociados', [
                    'technology_id' => $technology->id,
                    'projects_count' => $projectsCount,
                ]);

                return redirect()->back()
                    ->with('error', "No se puede eliminar la tecnología porque está asociada a {$projectsCount} proyecto(s). Desvincula los proyectos primero.");
            }

            DB::beginTransaction();

            // Eliminar icono si existe
            if ($technology->icon_path && Storage::disk('public')->exists($technology->icon_path)) {
                Storage::disk('public')->delete($technology->icon_path);
            }

            $name = $technology->name;
            $technology->delete();

            Cache::forget('technologies');
            Cache::forget('active_technologies');
            Cache::forget('technologies_by_category');

            DB::commit();

            Log::info('Tecnología eliminada exitosamente', [
                'technology_id' => $technology->id,
                'name' => $name,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.technologies.index')
                ->with('success', 'Tecnología eliminada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al eliminar tecnología: ' . $e->getMessage(), [
                'technology_id' => $technology->id,
                'user_id' => auth()->id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al eliminar la tecnología.');
        }
    }
}