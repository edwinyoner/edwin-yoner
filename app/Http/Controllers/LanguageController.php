<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Cambia el idioma de la aplicación
     * 
     * FLUJO:
     * 1. Valida que el idioma sea 'es' o 'en'
     * 2. Guarda en session (persiste durante la sesión del usuario)
     * 3. Redirige a la página anterior
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch(Request $request)
    {
        // Validar que el idioma sea válido
        $request->validate([
            'language' => 'required|in:es,en'
        ]);

        // Guardar idioma en sesión
        // Session::put() guarda datos que persisten mientras el usuario navega
        Session::put('locale', $request->language);
        
        // Redirigir a la página anterior
        // back() devuelve al usuario a la URL de donde vino
        return redirect()->back()->with('success', __('messages.language') . ' ' . strtoupper($request->language));
    }
}