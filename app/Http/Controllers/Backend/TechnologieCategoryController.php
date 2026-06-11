<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TechnologieCategory;
use App\Http\Requests\TechnologieCategoryRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TechnologieCategoryController extends Controller
{
    /**
     * Mostrar listado de categorías de tecnologías
     * 
     * Ruta: GET /technology-categories
     * Vista: backend.technology-categories.index
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            Log::info('Acceso a listado de categorías de tecnologías', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
            ]);

            // Obtener categorías ordenadas con conteo de tecnologías
            $categories = TechnologieCategory::withCount('technologies')
                ->orderBy('name')
                ->get();
            
            return view('backend.technology-categories.index', compact('categories'));
            
        } catch (\Exception $e) {
            Log::error('Error al cargar categorías de tecnologías: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('backend.dashboard')
                ->with('error', 'Error al cargar las categorías de tecnologías.');
        }
    }

    /**
     * Mostrar formulario de creación de categoría
     * 
     * Ruta: GET /technology-categories/create
     * Vista: backend.technology-categories.create
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        Log::info('Acceso a formulario de creación de categoría de tecnologías', [
            'user_id' => auth()->id(),
        ]);

        return view('backend.technology-categories.create');
    }

    /**
     * Guardar nueva categoría de tecnologías
     * 
     * Ruta: POST /technology-categories
     * 
     * Campos procesados:
     * - name, name_en (multiidioma)
     * - slug (auto-generado si no viene)
     * - icon_class (clase FontAwesome/Bootstrap Icons)
     * - color (hexadecimal)
     * - description
     * - is_active
     *
     * @param TechnologieCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TechnologieCategoryRequest $request)
    {
        try {
            Log::info('Iniciando creación de categoría de tecnologías', [
                'user_id' => auth()->id(),
                'data' => $request->validated(),
            ]);

            DB::beginTransaction();

            $category = TechnologieCategory::create($request->validated());

            // Limpiar caché relacionado
            Cache::forget('technology_categories');
            Cache::forget('active_technology_categories');

            DB::commit();

            Log::info('Categoría de tecnologías creada exitosamente', [
                'category_id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.technology_category.index')
                ->with('success', 'Categoría de tecnologías creada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al crear categoría de tecnologías: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'request_data' => $request->validated(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la categoría de tecnologías. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Mostrar detalle de categoría específica
     * 
     * Ruta: GET /technology-categories/{technology_category}
     * Vista: backend.technology-categories.show
     *
     * @param TechnologieCategory $technologyCategory
     * @return \Illuminate\View\View
     */
    public function show(TechnologieCategory $technologyCategory)
    {
        Log::info('Visualización de categoría de tecnologías', [
            'category_id' => $technologyCategory->id,
            'name' => $technologyCategory->name,
            'user_id' => auth()->id(),
        ]);

        // Cargar tecnologías asociadas
        $technologyCategory->load(['technologies' => function($query) {
            $query->orderBy('name');
        }]);

        return view('backend.technology-categories.show', compact('technologyCategory'));
    }

    /**
     * Mostrar formulario de edición de categoría
     * 
     * Ruta: GET /technology-categories/{technology_category}/edit
     * Vista: backend.technology-categories.edit
     *
     * @param TechnologieCategory $technologyCategory
     * @return \Illuminate\View\View
     */
    public function edit(TechnologieCategory $technologyCategory)
    {
        Log::info('Acceso a formulario de edición de categoría de tecnologías', [
            'category_id' => $technologyCategory->id,
            'name' => $technologyCategory->name,
            'user_id' => auth()->id(),
        ]);

        return view('backend.technology-categories.edit', compact('technologyCategory'));
    }

    /**
     * Actualizar categoría de tecnologías existente
     * 
     * Ruta: PUT /technology-categories/{technology_category}
     *
     * @param TechnologieCategoryRequest $request
     * @param TechnologieCategory $technologyCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TechnologieCategoryRequest $request, TechnologieCategory $technologyCategory)
    {
        try {
            Log::info('Iniciando actualización de categoría de tecnologías', [
                'category_id' => $technologyCategory->id,
                'name' => $technologyCategory->name,
                'user_id' => auth()->id(),
            ]);

            DB::beginTransaction();

            $technologyCategory->update($request->validated());

            // Limpiar caché relacionado
            Cache::forget('technology_categories');
            Cache::forget('active_technology_categories');
            Cache::forget('technology_category_' . $technologyCategory->id);

            DB::commit();

            Log::info('Categoría de tecnologías actualizada exitosamente', [
                'category_id' => $technologyCategory->id,
                'name' => $technologyCategory->name,
                'changes' => $technologyCategory->getChanges(),
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.technology-categories.index')
                ->with('success', 'Categoría de tecnologías actualizada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar categoría de tecnologías: ' . $e->getMessage(), [
                'category_id' => $technologyCategory->id,
                'user_id' => auth()->id(),
                'request_data' => $request->validated(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la categoría de tecnologías. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Eliminar categoría de tecnologías
     * 
     * Ruta: DELETE /technology-categories/{technology_category}
     * 
     * IMPORTANTE: No eliminar si tiene tecnologías asociadas
     *
     * @param TechnologieCategory $technologyCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TechnologieCategory $technologyCategory)
    {
        try {
            Log::info('Intento de eliminar categoría de tecnologías', [
                'category_id' => $technologyCategory->id,
                'name' => $technologyCategory->name,
                'user_id' => auth()->id(),
            ]);

            // Verificar si tiene tecnologías asociadas
            $technologiesCount = $technologyCategory->technologies()->count();
            
            if ($technologiesCount > 0) {
                Log::warning('Intento de eliminar categoría con tecnologías asociadas', [
                    'category_id' => $technologyCategory->id,
                    'technologies_count' => $technologiesCount,
                ]);

                return redirect()->back()
                    ->with('error', "No se puede eliminar la categoría porque tiene {$technologiesCount} tecnología(s) asociada(s). Elimina o reasigna las tecnologías primero.");
            }

            DB::beginTransaction();

            $name = $technologyCategory->name;
            $technologyCategory->delete();

            // Limpiar caché relacionado
            Cache::forget('technology_categories');
            Cache::forget('active_technology_categories');

            DB::commit();

            Log::info('Categoría de tecnologías eliminada exitosamente', [
                'category_id' => $technologyCategory->id,
                'name' => $name,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.technology-categories.index')
                ->with('success', 'Categoría de tecnologías eliminada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al eliminar categoría de tecnologías: ' . $e->getMessage(), [
                'category_id' => $technologyCategory->id,
                'user_id' => auth()->id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al eliminar la categoría de tecnologías.');
        }
    }
}