<?php

use Illuminate\Support\Facades\Route;

// ============================================
// 🌐 FRONTEND CONTROLLERS (Public)
// ============================================
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\Frontend\SkillController as FrontendSkillController;
use App\Http\Controllers\Frontend\ProjectController as FrontendProjectController;
use App\Http\Controllers\Frontend\DocumentController as FrontendDocumentController;
use App\Http\Controllers\Frontend\ContactController as FrontendContactController;

// ============================================
// 🔒 BACKEND CONTROLLERS (Admin Panel)
// ============================================

// Dashboard
use App\Http\Controllers\Backend\DashboardController as BackendDashboardController;

// CMS - Settings (Singleton)
use App\Http\Controllers\Backend\ProfileSettingController as BackendProfileSettingController;
use App\Http\Controllers\Backend\PortfolioSettingController as BackendPortfolioSettingController;

// CMS - Social Links
use App\Http\Controllers\Backend\SocialLinkController as BackendSocialLinkController;

// CMS - Technologies
use App\Http\Controllers\Backend\TechnologieCategoryController as BackendTechnologieCategoryController;
use App\Http\Controllers\Backend\TechnologyController as BackendTechnologyController;

// CMS - Projects
use App\Http\Controllers\Backend\ProjectController as BackendProjectController;
use App\Http\Controllers\Backend\ProjectGalleryController as BackendProjectGalleryController;

// CMS - Documents
use App\Http\Controllers\Backend\DocumentController as BackendDocumentController;

// CMS - Contact
use App\Http\Controllers\Backend\ContactSubmissionController as BackendContactSubmissionController;

// User Management
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LanguageController;

/* ========================================== */
/* RUTA PARA CAMBIO DE IDIOMA */
/* ========================================== */
/* 📚 EXPLICACIÓN: Ruta POST para cambiar idioma */
/* Se usa POST (no GET) por seguridad y para evitar cache */
Route::post('/language/switch', [LanguageController::class, 'switch'])
    ->name('language.switch');

// ============================================
// 🌐 FRONTEND ROUTES (Public - Sin autenticación)
// ============================================

// Home / Inicio
Route::get('/', [FrontendHomeController::class, 'index'])->name('frontend.home');

// Skills / Habilidades
Route::get('/habilidades', [FrontendSkillController::class, 'index'])->name('frontend.skills.index');

// Projects / Proyectos
Route::get('/proyectos', [FrontendProjectController::class, 'index'])->name('frontend.projects.index');
Route::get('/proyectos/{slug}', [FrontendProjectController::class, 'show'])->name('frontend.projects.show');

// Documents / Documentos
Route::get('/documentos', [FrontendDocumentController::class, 'index'])->name('frontend.documents.index');
Route::get('/documentos/{id}/descargar', [FrontendDocumentController::class, 'download'])->name('frontend.documents.download');
Route::get('/documentos/{id}/ver', [FrontendDocumentController::class, 'view'])->name('frontend.documents.view');

// Contact / Contacto
Route::get('/contacto', [FrontendContactController::class, 'index'])->name('frontend.contact.index');
Route::post('/contacto', [FrontendContactController::class, 'store'])->name('frontend.contact.store');

// ============================================
// 🌐 RUTAS MULTIIDIOMA (Cambiar idioma)
// ============================================
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['es', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// ============================================
// 🔒 BACKEND ROUTES (Admin Panel)
// ============================================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'user.status'
])->name('backend.')->group(function () {

    // ============================================
    // 📊 Dashboard
    // ============================================
    Route::get('/dashboard', [BackendDashboardController::class, 'index'])->name('dashboard');

    // ============================================
    // 📝 CMS - Settings (Singleton - Solo editar, no crear/eliminar)
    // ============================================

    // Profile Settings (Perfil personal)
    Route::prefix('profile-settings')->name('profile-settings.')->group(function () {
        Route::get('/', [BackendProfileSettingController::class, 'index'])->name('index');
        Route::get('/edit', [BackendProfileSettingController::class, 'edit'])->name('edit');
        Route::put('/', [BackendProfileSettingController::class, 'update'])->name('update');
    });

    // Portfolio Settings (Configuración general)
    Route::prefix('portfolio-settings')->name('portfolio-settings.')->group(function () {
        Route::get('/', [BackendPortfolioSettingController::class, 'index'])->name('index');
        Route::get('/edit', [BackendPortfolioSettingController::class, 'edit'])->name('edit');
        Route::put('/', [BackendPortfolioSettingController::class, 'update'])->name('update');
    });

    // ============================================
    // 📝 CMS - Social Links (CRUD)
    // ============================================
    Route::resource('social-links', BackendSocialLinkController::class)->names('social-links');
    Route::patch('/social-links/{socialLink}/toggle-status', [BackendSocialLinkController::class, 'toggleStatus'])
        ->name('social-links.toggle-status');

    // ============================================
    // 💻 CMS - Technologies (CRUD)
    // ============================================

    // Technology Categories
    Route::resource('technology-categories', BackendTechnologieCategoryController::class)->names('technology-categories');

    // Technologies
    Route::resource('technologies', BackendTechnologyController::class)->names('technologies');

    // ============================================
    // 🚀 CMS - Projects (CRUD)
    // ============================================

    // Projects
    Route::resource('projects', BackendProjectController::class)->names('projects');

    // Project Galleries (Anidado dentro de proyectos)
    Route::prefix('projects/{project}/gallery')->name('projects-gallery.')->group(function () {
        // Route::get('/', [BackendProjectGalleryController::class, 'index'])->name('index');
        // Route::get('/create', [BackendProjectGalleryController::class, 'create'])->name('create');
        Route::post('/', [BackendProjectGalleryController::class, 'store'])->name('store');
        // Route::get('/{gallery}/edit', [BackendProjectGalleryController::class, 'edit'])->name('edit');
        // Route::put('/{gallery}', [BackendProjectGalleryController::class, 'update'])->name('update');
        Route::delete('/{gallery}', [BackendProjectGalleryController::class, 'destroy'])->name('destroy');
    });

    // ============================================
    // 📄 CMS - Documents (CRUD)
    // ============================================
    Route::resource('documents', BackendDocumentController::class)->names('documents');
    Route::patch('/documents/{document}/toggle-status', [BackendDocumentController::class, 'toggleStatus'])
        ->name('documents.toggle_status');
    Route::get('/documents/{document}/download', [BackendDocumentController::class, 'download'])
        ->name('documents.download');
    

    // ============================================
    // 📧 CMS - Contact Submissions (Solo leer/eliminar)
    // ============================================
    Route::prefix('contact-submissions')->name('contact-submissions.')->group(function () {
        Route::get('/', [BackendContactSubmissionController::class, 'index'])->name('index');
        Route::get('/{contactSubmission}', [BackendContactSubmissionController::class, 'show'])->name('show');
        Route::delete('/{contactSubmission}', [BackendContactSubmissionController::class, 'destroy'])->name('destroy');
        Route::patch('/{contactSubmission}/toggle-read', [BackendContactSubmissionController::class, 'toggleRead'])
            ->name('toggle_read');
        Route::patch('/{contactSubmission}/mark-replied', [BackendContactSubmissionController::class, 'markAsReplied'])
            ->name('mark_replied');
    });

    // ============================================
    // 👥 User & Role Management
    // ============================================
    Route::resource('users', UserController::class)->names('users');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('permissions', PermissionController::class)->names('permissions');

    Route::post('/users/{userId}/assign-role', [UserController::class, 'assignRole'])
        ->name('users.assignRole');
    Route::post('/users/send-credentials', [UserController::class, 'sendCredentials'])
        ->name('users.send_credentials');
    Route::post('/users/update-password-and-send', [UserController::class, 'updatePasswordAndSend'])
        ->name('users.update_password_and_send');
});

// ============================================
// 🔧 UTILIDADES
// ============================================

// Verificar configuración de storage (solo para desarrollo)
Route::get('/verify-storage', function() {
    $checks = [
        'storage_link_exists' => is_link(public_path('storage')),
        'storage_directory_exists' => is_dir(storage_path('app/public')),
        'storage_writable' => is_writable(storage_path('app/public')),
        'public_writable' => is_writable(public_path()),
    ];
    
    return response()->json($checks);
})->middleware('auth')->name('verify.storage');