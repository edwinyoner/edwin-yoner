<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    /**
     * Mostrar listado de proyectos del portafolio
     */
    public function index()
    {
        try {
            $projects = Project::where('is_active', true)
                ->with([
                    'technologies' => fn($q) => $q->where('is_active', true),
                    'galleries',
                ])
                ->orderBy('year', 'desc')
                ->orderBy('id', 'asc')
                ->get();

            return view('frontend.pages.projects', compact('projects'));

        } catch (\Exception $e) {
            Log::error('Error al cargar listado de proyectos: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            if (config('app.debug')) throw $e;

            abort(500, 'Error al cargar la página de proyectos.');
        }
    }

    /**
     * Mostrar detalle de un proyecto específico
     */
    public function show(string $slug)
    {
        try {
            $project = Project::where('slug', $slug)
                ->where('is_active', true)
                ->with([
                    'technologies' => fn($q) => $q->where('is_active', true)
                                                   ->orderBy('proficiency_percentage', 'desc'),
                    'galleries'    => fn($q) => $q->orderBy('id', 'asc'),
                ])
                ->firstOrFail();

            // Proyectos relacionados: los más recientes excluyendo el actual
            $relatedProjects = Project::where('is_active', true)
                ->where('id', '!=', $project->id)
                ->with(['technologies' => fn($q) => $q->where('is_active', true)])
                ->orderBy('year', 'desc')
                ->orderBy('id', 'asc')
                ->limit(3)
                ->get();

            return view('frontend.pages.projects', compact('project', 'relatedProjects'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Proyecto no encontrado.');

        } catch (\Exception $e) {
            Log::error('Error al cargar detalle de proyecto: ' . $e->getMessage(), [
                'slug'  => $slug,
                'trace' => $e->getTraceAsString(),
            ]);

            if (config('app.debug')) throw $e;

            abort(500, 'Error al cargar el detalle del proyecto.');
        }
    }
}