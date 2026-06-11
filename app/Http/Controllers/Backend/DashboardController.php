<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectGallery;
use App\Models\Technology;
use App\Models\TechnologieCategory;
use App\Models\Document;
use App\Models\ContactSubmission;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Panel principal del administrador
     * 
     * Ruta: GET /dashboard
     * Vista: backend.dashboard.index
     * 
     * Muestra:
     * - Estadísticas generales del portafolio
     * - Últimos registros creados
     * - Gráficos de distribución
     * - Alertas y notificaciones
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            Log::info('Acceso al dashboard', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
            ]);

            // ============================================
            // ESTADÍSTICAS PRINCIPALES
            // ============================================
            $totalProjects = Project::count();
            $latestProjects = Project::latest()
                ->limit(5)
                ->get();
            $activeProjects     = Project::where('is_active', true)->count();

            $totalTechnologies  = Technology::count();
            $activeTechnologies = Technology::where('is_active', true)->count();
            $totalTechCategories = TechnologieCategory::count();

            $totalDocuments     = Document::count();
            $activeDocuments    = Document::where('is_active', true)->count();
            $totalDownloads     = Document::sum('download_count') ?? 0;

            $totalContactSubmissions = ContactSubmission::count();
            $unreadContacts     = ContactSubmission::where('is_read', false)->count();
            $pendingContacts    = ContactSubmission::whereNull('replied_at')->count();

            $totalProjectGalleries = ProjectGallery::count();
            $totalSocialLinks   = SocialLink::count();
            $activeSocialLinks  = SocialLink::where('is_active', true)->count();

            $totalUsers         = User::count();
            $activeUsers        = User::where('status', true)->count();

            // ============================================
            // ÚLTIMOS REGISTROS
            // ============================================
            $latestTechnologies = Technology::with('category')->latest()->limit(5)->get();
            $latestDocuments    = Document::latest()->limit(5)->get();
            $latestContacts     = ContactSubmission::latest()->limit(5)->get();

            // ============================================
            // GRÁFICOS
            // ============================================
            $technologiesByCategory = TechnologieCategory::withCount('technologies')
                ->orderBy('technologies_count', 'desc')
                ->get();

            $topTechnologies = Technology::withCount('projects')
                ->having('projects_count', '>', 0)
                ->orderBy('projects_count', 'desc')
                ->limit(10)
                ->get();

            $topDocuments = Document::where('download_count', '>', 0)
                ->orderBy('download_count', 'desc')
                ->limit(5)
                ->get();

            // ============================================
            // ALERTAS
            // ============================================
            $projectsNeedingAttention = Project::where('is_active', false)->count();
            $technologiesInactive = Technology::where('is_active', false)->count();
            $documentsInactive = Document::where('is_active', false)->count();
            $contactsNeedingReply = ContactSubmission::whereNull('replied_at')->count();
            $socialLinksInactive = SocialLink::where('is_active', false)->count();

            Log::info('Dashboard cargado exitosamente');

            return view('backend.dashboard.dashboard', compact(
                'totalProjects',
                'activeProjects',
                'totalTechnologies',
                'activeTechnologies',
                'totalTechCategories',
                'totalDocuments',
                'activeDocuments',
                'totalDownloads',
                'totalContactSubmissions',
                'unreadContacts',
                'pendingContacts',
                'totalProjectGalleries',
                'totalSocialLinks',
                'activeSocialLinks',
                'totalUsers',
                'activeUsers',
                'latestProjects',
                'latestTechnologies',
                'latestDocuments',
                'latestContacts',
                'technologiesByCategory',
                'topTechnologies',
                'topDocuments',
                'projectsNeedingAttention',
                'technologiesInactive',
                'documentsInactive',
                'contactsNeedingReply',
                'socialLinksInactive'
            ));
        } catch (\Exception $e) {
            Log::error('Error al cargar el dashboard: ' . $e->getMessage());

            return redirect()->route('frontend.home')
                ->with('error', 'Error al cargar el dashboard. Por favor intenta más tarde.');

            // Log::error('Dashboard Error', [
            //     'message' => $e->getMessage(),
            //     'file'    => $e->getFile(),
            //     'line'    => $e->getLine(),
            //     'trace'   => $e->getTraceAsString(),
            // ]);

            // dd([
            //     'message' => $e->getMessage(),
            //     'file'    => $e->getFile(),
            //     'line'    => $e->getLine(),
            // ]);
        }
    }
}
