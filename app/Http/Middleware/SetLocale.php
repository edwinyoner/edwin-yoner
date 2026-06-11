<?php
// app/Http/Middleware/SetLocale.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Middleware que detecta y aplica el idioma
     * 
     * FLUJO:
     * 1. Se ejecuta ANTES de cada request
     * 2. Lee idioma de Session
     * 3. Si no hay idioma guardado, usa 'es' por defecto
     * 4. Aplica el idioma con App::setLocale()
     * 
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener idioma de la sesión, si no existe usar 'es'
        $locale = Session::get('locale', 'es');
        
        // Aplicar idioma a la aplicación
        // App::setLocale() cambia el idioma activo en toda la app
        // Esto hace que __('messages.home') busque en lang/es/ o lang/en/
        App::setLocale($locale);
        
        // Continuar con el request
        return $next($request);
    }
}