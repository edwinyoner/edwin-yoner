<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileSettingRequest;
use App\Models\ProfileSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileSettingController extends Controller
{
    /**
     * Mostrar configuración del perfil personal (resumen)
     * 
     * Ruta: GET /profile-settings
     * Vista: backend.profile-settings.index
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            Log::info('Acceso a configuración del perfil', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
            ]);

            // Obtener configuración del perfil (singleton - siempre existe 1 registro)
            $profile = ProfileSetting::firstOrFail();

            return view('backend.profile-settings.index', compact('profile'));
        } catch (\Exception $e) {
            Log::error('Error al cargar configuración del perfil: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('backend.dashboard')
                ->with('error', 'No se pudo cargar la configuración del perfil.');
        }
    }

    /**
     * Mostrar formulario de edición del perfil personal
     * 
     * Ruta: GET /profile-settings/edit
     * Vista: backend.profile-settings.edit
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        try {
            Log::info('Acceso a formulario de edición del perfil', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
            ]);

            // Obtener configuración actual del perfil
            $profile = ProfileSetting::firstOrFail();

            return view('backend.profile-settings.edit', compact('profile'));
        } catch (\Exception $e) {
            Log::error('Error al cargar formulario de edición del perfil: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('backend.profile.index')
                ->with('error', 'No se pudo cargar el formulario de edición.');
        }
    }

    /**
     * Actualizar configuración del perfil personal
     * 
     * Ruta: PUT /profile-settings
     * 
     * Actualiza:
     * - Información personal (nombre, título, biografía)
     * - Imágenes (foto de perfil, foto about, CV)
     * - Datos de contacto (email, teléfono, ubicación)
     * - Enlaces profesionales (GitHub, LinkedIn, etc.)
     * - Habilidades y experiencia
     *
     * @param ProfileSettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileSettingRequest $request)
    {
        try {
            Log::info('Iniciando actualización del perfil personal', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
            ]);

            DB::beginTransaction();

            // Obtener configuración actual del perfil
            $profile = ProfileSetting::firstOrFail();
            $validated = $request->validated();

            // ============================================
            // PROCESAR IMÁGENES
            // ============================================

            if ($request->hasFile('profile_image')) {
                if ($profile->profile_image && Storage::disk('public')->exists($profile->profile_image)) {
                    Storage::disk('public')->delete($profile->profile_image);
                }
                $validated['profile_image'] = $request->file('profile_image')
                    ->store('profile', 'public');
            }

            // ============================================
            // ACTUALIZAR PERFIL
            // ============================================
            $profile->update($validated);

            // ============================================
            // LIMPIAR CACHÉ
            // ============================================
            Cache::forget('profile_settings');
            Cache::forget('profile_data');
            Cache::forget('home_profile');

            DB::commit();

            Log::info('Perfil personal actualizado correctamente', [
                'user_id' => auth()->id(),
                'updated_fields' => array_keys($validated),
            ]);

            return redirect()->route('backend.profile-settings.index')
                ->with('success', 'El perfil personal ha sido actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al actualizar perfil personal: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Error al actualizar el perfil: ' . $e->getMessage())
                ->withInput();
        }
    }
}