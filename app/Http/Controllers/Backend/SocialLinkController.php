<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use App\Http\Requests\SocialLinkRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class SocialLinkController extends Controller
{
    /**
     * Display a listing of the social links.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $socialLinks = SocialLink::all();
            
            return view('backend.social-links.index', compact('socialLinks'));
            
        } catch (\Exception $e) {
            Log::error('Error al cargar redes sociales: ' . $e->getMessage());
            
            return redirect()->route('backend.dashboard')
                ->with('error', 'Error al cargar las redes sociales.');
        }
    }

    /**
     * Show the form for creating a new social link.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.social-links.create');
    }

    /**
     * Store a newly created social link in storage.
     *
     * @param SocialLinkRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SocialLinkRequest $request)
    {
        try {
            DB::beginTransaction();

            $socialLink = SocialLink::create($request->validated());

            DB::commit();

            Log::info('Red social creada exitosamente', [
                'social_link_id' => $socialLink->id,
                'name' => $socialLink->name,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.social-links.index')
                ->with('success', 'Red social creada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al crear red social: ' . $e->getMessage(), [
                'request_data' => $request->validated(),
                'exception' => $e,
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la red social. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Display the specified social link.
     *
     * @param SocialLink $socialLink
     * @return \Illuminate\View\View
     */
    public function show(SocialLink $socialLink)
    {
        return view('backend.social-links.show', compact('socialLink'));
    }

    /**
     * Show the form for editing the specified social link.
     *
     * @param SocialLink $socialLink
     * @return \Illuminate\View\View
     */
    public function edit(SocialLink $socialLink)
    {
        return view('backend.social-links.edit', compact('socialLink'));
    }

    /**
     * Update the specified social link in storage.
     *
     * @param SocialLinkRequest $request
     * @param SocialLink $socialLink
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SocialLinkRequest $request, SocialLink $socialLink)
    {
        try {
            DB::beginTransaction();

            $socialLink->update($request->validated());

            DB::commit();

            Log::info('Red social actualizada exitosamente', [
                'social_link_id' => $socialLink->id,
                'name' => $socialLink->name,
                'changes' => $socialLink->getChanges(),
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.social-links.index')
                ->with('success', 'Red social actualizada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar red social: ' . $e->getMessage(), [
                'social_link_id' => $socialLink->id,
                'request_data' => $request->validated(),
                'exception' => $e,
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la red social. Por favor, intenta nuevamente.');
        }
    }
    

    /**
     * Remove the specified social link from storage.
     *
     * @param SocialLink $socialLink
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SocialLink $socialLink)
    {
        try {
            DB::beginTransaction();

            $name = $socialLink->name;
            $socialLink->delete();

            DB::commit();

            Log::info('Red social eliminada', [
                'social_link_id' => $socialLink->id,
                'name' => $name,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('backend.social-links.index')
                ->with('success', 'Red social eliminada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al eliminar red social: ' . $e->getMessage(), [
                'social_link_id' => $socialLink->id,
                'exception' => $e,
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al eliminar la red social.');
        }
    }

    /**
     * Toggle the active status of the social link.
     *
     * @param SocialLink $socialLink
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(SocialLink $socialLink)
    {
        try {
            DB::beginTransaction();

            $socialLink->toggleActive();

            DB::commit();

            Log::info('Estado de red social actualizado', [
                'social_link_id' => $socialLink->id,
                'name' => $socialLink->name,
                'new_status' => $socialLink->is_active,
                'user_id' => auth()->id(),
            ]);

            $message = $socialLink->is_active 
                ? 'Red social activada correctamente.' 
                : 'Red social desactivada correctamente.';

            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al cambiar estado de red social: ' . $e->getMessage(), [
                'social_link_id' => $socialLink->id,
                'exception' => $e,
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al cambiar el estado de la red social.');
        }
    }
}