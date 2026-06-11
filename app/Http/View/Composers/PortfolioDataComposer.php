<?php

namespace App\Http\View\Composers;

use App\Models\ProfileSetting;
use App\Models\PortfolioSetting;
use App\Models\SocialLink;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Composer para compartir datos del portafolio en todas las vistas.
 * Incluye configuración del perfil, portafolio y redes sociales.
 */
class PortfolioDataComposer
{
    /**
     * Vincula datos a la vista.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        try {
            // Cachear configuración del perfil por 1 hora
            $profileSettings = Cache::remember('profile_settings', 3600, function () {
                return ProfileSetting::first();
            });

            // Cachear configuración del portafolio por 1 hora
            $portfolioSettings = Cache::remember('portfolio_settings', 3600, function () {
                return PortfolioSetting::first();
            });

            // Cachear redes sociales activas por 1 hora
            $socialLinks = Cache::remember('social_links_active', 3600, function () {
                return SocialLink::active()->get();
            });

            // Compartir con todas las vistas
            $view->with([
                'profileSettings' => $profileSettings,
                'portfolioSettings' => $portfolioSettings,
                'socialLinks' => $socialLinks,
            ]);

        } catch (\Exception $e) {
            Log::error('Error en PortfolioDataComposer: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Datos por defecto en caso de error
            $view->with([
                'profileSettings' => null,
                'portfolioSettings' => null,
                'socialLinks' => collect([]),
            ]);
        }
    }
}