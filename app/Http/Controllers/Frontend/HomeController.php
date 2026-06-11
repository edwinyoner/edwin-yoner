<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProfileSetting;
use App\Models\PortfolioSetting;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Página de inicio del portafolio
     * 
     * Muestra:
     * - Perfil personal (profile_image, full_name, professional_title, bio_short, city, country)
     * - Redes sociales
     */
    public function index()
    {
        try {
            // ============================================
            // CONFIGURACIÓN Y PERFIL
            // ============================================
            
            // Perfil personal (singleton)
            $profile = ProfileSetting::firstOrFail();
            
            // Configuración del portafolio (colores, contacto)
            $settings = PortfolioSetting::firstOrFail();
            
            // Redes sociales activas
            $socialLinks = SocialLink::where('is_active', true)
                ->orderBy('id')
                ->get();
            
            // ============================================
            // RETORNAR VISTA
            // ============================================
            
            return view('frontend.pages.home', compact(
                'profile',
                'settings',
                'socialLinks'
            ));

        } catch (\Exception $e) {
            Log::error('Error al cargar página Home del portafolio: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // En desarrollo, mostrar el error; en producción, página genérica
            if (config('app.debug')) {
                throw $e;
            }
            
            abort(500, 'Error al cargar la página de inicio');
        }
    }
}