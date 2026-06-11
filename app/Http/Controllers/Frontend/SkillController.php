<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TechnologieCategory;
use App\Models\Technology;
use App\Models\ProfileSetting;
use Illuminate\Support\Facades\Log;

class SkillController extends Controller
{
    /**
     * Mostrar la página de habilidades/tecnologías del portafolio
     * 
     * Muestra:
     * - Todas las categorías de tecnologías (Lenguajes, Databases, etc.)
     * - Tecnologías agrupadas por categoría
     * - Nivel de dominio de cada tecnología (básico, intermedio, avanzado)
     * - Porcentaje de dominio para barras de progreso
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // ============================================
            // CATEGORÍAS CON TECNOLOGÍAS
            // ============================================
            
            // Obtener todas las categorías activas con sus tecnologías activas
            $categories = TechnologieCategory::where('is_active', true)
                ->with(['technologies' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('id', 'asc'); // Ordenar por dominio
                }])
                ->get()
                ->filter(function ($category) {
                    // Filtrar categorías que tengan al menos 1 tecnología
                    return $category->technologies->count() > 0;
                });
            
            // ============================================
            // RETORNAR VISTA
            // ============================================
            
            return view('frontend.pages.skills', compact('categories'));
            
        } catch (\Exception $e) {
            Log::error('Error al cargar página de habilidades: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            if (config('app.debug')) {
                throw $e;
            }
            
            abort(500, 'Error al cargar la página de habilidades');
        }
    }
}