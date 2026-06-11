<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioSettingRequest;
use App\Models\PortfolioSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PortfolioSettingController extends Controller
{
    /**
     * Mostrar configuración del portafolio (resumen)
     * 
     * Ruta: GET /portfolio-settings
     * Vista: backend.portfolio-settings.index
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            // Obtener configuración (singleton - siempre existe 1 registro)
            $settings = PortfolioSetting::firstOrFail();

            return view('backend.portfolio-settings.index', compact('settings'));
            
        } catch (\Exception $e) {
            Log::error('Error al cargar configuración del portafolio: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('backend.dashboard')
                ->with('error', 'No se pudo cargar la configuración del portafolio.');
        }
    }

    /**
     * Mostrar formulario de edición de configuración
     * 
     * Ruta: GET /portfolio-settings/edit
     * Vista: backend.portfolio-settings.edit
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        try {
            // Obtener configuración actual
            $settings = PortfolioSetting::firstOrFail();

            return view('backend.portfolio-settings.edit', compact('settings'));
            
        } catch (\Exception $e) {
            Log::error('Error al cargar formulario de edición: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('backend.portfolio-settings.index')
                ->with('error', 'No se pudo cargar el formulario de edición.');
        }
    }

    /**
     * Actualizar configuración del portafolio
     * 
     * Ruta: PUT /portfolio-settings
     * 
     * Actualiza:
     * - Identidad visual (logo, favicon)
     * - Paleta de colores (5 colores)
     * - Información de contacto (email, teléfono, WhatsApp)
     * - Configuración del sitio (dark mode, multiidioma)
     *
     * @param PortfolioSettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PortfolioSettingRequest $request)
    {
        try {
            Log::info('Iniciando actualización de configuración del portafolio', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
            ]);

            DB::beginTransaction();

            // Obtener configuración actual
            $settings = PortfolioSetting::firstOrFail();
            $validated = $request->validated();

            // ============================================
            // PROCESAR IMÁGENES
            // ============================================
            
            // Logo del portafolio
            if ($request->hasFile('logo_path')) {
                // Eliminar logo anterior si existe
                if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
                    Storage::disk('public')->delete($settings->logo_path);
                }
                
                // Guardar nuevo logo
                $validated['logo_path'] = $request->file('logo_path')
                    ->store('portfolio/logos', 'public');
                
                Log::info('Logo actualizado', [
                    'new_path' => $validated['logo_path'],
                ]);
            }

            // Favicon
            if ($request->hasFile('favicon_path')) {
                // Eliminar favicon anterior si existe
                if ($settings->favicon_path && Storage::disk('public')->exists($settings->favicon_path)) {
                    Storage::disk('public')->delete($settings->favicon_path);
                }
                
                // Guardar nuevo favicon
                $validated['favicon_path'] = $request->file('favicon_path')
                    ->store('portfolio/favicons', 'public');
                
                Log::info('Favicon actualizado', [
                    'new_path' => $validated['favicon_path'],
                ]);
            }

            // ============================================
            // ACTUALIZAR CONFIGURACIÓN
            // ============================================
            $settings->update($validated);

            // ============================================
            // LIMPIAR CACHÉ
            // ============================================
            Cache::forget('portfolio_settings');
            Cache::forget('portfolio_colors');
            
            DB::commit();

            Log::info('Configuración del portafolio actualizada correctamente', [
                'user_id' => auth()->id(),
                'updated_fields' => array_keys($validated),
            ]);

            return redirect()->route('backend.portfolio-settings.index')
                ->with('success', 'La configuración del portafolio ha sido actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar configuración del portafolio: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al actualizar la configuración: ' . $e->getMessage())
                ->withInput();
        }
    }
}