<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\PortfolioDataComposer;
use App\Http\View\Composers\BackendDataComposer;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // ============================================
        // FRONTEND — vistas públicas del portafolio
        // ============================================
        // Comparte: profileSettings + portfolioSettings + socialLinks (activos)
        // Usado en: home, skills, projects, documents, contact, partials, etc.
        View::composer('frontend.*', PortfolioDataComposer::class);

        // ============================================
        // BACKEND — panel de administración
        // ============================================
        // Comparte: profileSettings + portfolioSettings (SIN socialLinks)
        // Cada controlador carga sus propios datos con sus propios filtros.
        View::composer('backend.*',   BackendDataComposer::class);
        View::composer('adminlte::*', BackendDataComposer::class);
    }
}