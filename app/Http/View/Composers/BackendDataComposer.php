<?php

namespace App\Http\View\Composers;

use App\Models\ProfileSetting;
use App\Models\PortfolioSetting;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Composer para el backend (panel de administración).
 *
 * Solo comparte datos globales de configuración:
 * - profileSettings  → nombre, título, foto
 * - portfolioSettings → colores, logo, contacto
 *
 * ⚠️ NO comparte $socialLinks ni ningún otro listado
 * que los controladores del backend manejen con lógica propia.
 * Cada controlador es responsable de cargar y filtrar sus datos.
 */
class BackendDataComposer
{
    public function compose(View $view): void
    {
        try {
            $profileSettings = Cache::remember('profile_settings', 3600, function () {
                return ProfileSetting::first();
            });

            $portfolioSettings = Cache::remember('portfolio_settings', 3600, function () {
                return PortfolioSetting::first();
            });

            $view->with([
                'profileSettings'   => $profileSettings,
                'portfolioSettings' => $portfolioSettings,
            ]);

        } catch (\Exception $e) {
            Log::error('Error en BackendDataComposer: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            $view->with([
                'profileSettings'   => null,
                'portfolioSettings' => null,
            ]);
        }
    }
}