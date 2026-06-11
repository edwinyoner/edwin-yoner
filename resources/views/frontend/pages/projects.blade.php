@if(!isset($isSection))
@extends('frontend.layouts.app')
@section('title', __('messages.projects'))
@section('content')
@endif

<section id="proyectos" class="projects-section">
     {{-- Fondo animado de partículas --}}
    <canvas id="particle-canvas" class="projects-section__canvas"></canvas>

    <div class="projects-container">

        {{-- TÍTULO --}}
        <div class="projects-header" data-aos="fade-down">
            <h1 class="projects-title">{{ __('messages.my_projects') }}</h1>
            <div class="projects-subtitle">
                <p>{{ __('messages.portfolio') }} & {{ __('messages.recent_projects') }}</p>
            </div>
        </div>

        {{-- GRID --}}
        @if($projects->count() > 0)
        <div class="projects-flex">
            @foreach($projects as $project)
            <div class="project-card" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 60 }}">

                {{-- ZONA 1: Thumbnail (altura fija) --}}
                <div class="proj-zone proj-zone--thumb">
                    @if($project->thumbnail_image)
                        <img src="{{ asset('storage/' . $project->thumbnail_image) }}"
                             alt="{{ $project->title }}"
                             class="project-image"
                             loading="lazy">
                    @else
                        <div class="project-placeholder">
                            <i class="fas fa-code"></i>
                        </div>
                    @endif
                    @if($project->year)
                        <span class="project-year-badge">{{ $project->year }}</span>
                    @endif
                </div>

                {{-- ZONA 2: Título (altura fija, 2 líneas) --}}
                <div class="proj-zone proj-zone--title">
                    <h3 class="project-title">{{ $project->title }}</h3>
                </div>

                {{-- ZONA 3: Descripción (altura fija, 3 líneas) --}}
                <div class="proj-zone proj-zone--description">
                    @if($project->short_description)
                        <p class="project-description">{{ $project->short_description }}</p>
                    @endif
                </div>

                {{-- ZONA 4: Tecnologías (altura fija) --}}
                <div class="proj-zone proj-zone--techs">
                    @if($project->technologies->count() > 0)
                        @foreach($project->technologies->take(4) as $tech)
                            <span class="tech-badge"
                                  style="background:{{ $tech->color ?? 'var(--color-primary)' }}18;
                                         color:{{ $tech->color ?? 'var(--color-primary)' }};
                                         border-color:{{ $tech->color ?? 'var(--color-primary)' }};">
                                {{ $tech->name }}
                            </span>
                        @endforeach
                        @if($project->technologies->count() > 4)
                            <span class="tech-badge-more">+{{ $project->technologies->count() - 4 }}</span>
                        @endif
                    @endif
                </div>

                {{-- ZONA 5: Botón (altura fija) --}}
                <div class="proj-zone proj-zone--action">
                    <button class="project-btn" onclick="openModal({{ $project->id }})">
                        <i class="fas fa-eye"></i>
                        {{ __('messages.view_details') }}
                    </button>
                </div>

            </div>
            @endforeach
        </div>

        @else
        <div class="no-projects" data-aos="fade-up">
            <i class="fas fa-folder-open"></i>
            <p>{{ __('messages.no_projects_yet') }}</p>
        </div>
        @endif

    </div>
</section>

{{-- ============================================ --}}
{{-- MODALES PRE-RENDERIZADOS (sin lag) --}}
{{-- ============================================ --}}
@foreach($projects as $project)
<div id="modal-{{ $project->id }}" class="project-modal" role="dialog" aria-modal="true">
    <div class="modal-overlay" onclick="closeModal({{ $project->id }})"></div>
    <div class="modal-container">

        <button class="modal-close" onclick="closeModal({{ $project->id }})" aria-label="Cerrar">
            <i class="fas fa-times"></i>
        </button>

        <div class="modal-body">

            {{-- Imagen principal --}}
            @if($project->thumbnail_image)
            <div class="modal-image-wrap">
                <img src="{{ asset('storage/' . $project->thumbnail_image) }}"
                     alt="{{ $project->title }}"
                     class="modal-main-image"
                     loading="lazy">
                @if($project->year)
                    <span class="modal-year-badge">{{ $project->year }}</span>
                @endif
            </div>
            @endif

            {{-- Encabezado --}}
            <div class="modal-header">
                <h2 class="modal-title">{{ $project->title }}</h2>
                @if(!$project->thumbnail_image && $project->year)
                    <span class="modal-year-inline">{{ $project->year }}</span>
                @endif
            </div>

            {{-- Descripción --}}
            @if($project->long_description || $project->short_description)
            <div class="modal-description">
                {!! nl2br(e($project->long_description ?? $project->short_description)) !!}
            </div>
            @endif

            {{-- Tecnologías --}}
            @if($project->technologies->count() > 0)
            <div class="modal-section">
                <h3 class="modal-section-title">
                    <i class="fas fa-code"></i> Tecnologías Utilizadas
                </h3>
                <div class="modal-tech-grid">
                    @foreach($project->technologies as $tech)
                        <span class="modal-tech-badge"
                              style="background:{{ $tech->color ?? 'var(--color-primary)' }}18;
                                     color:{{ $tech->color ?? 'var(--color-primary)' }};
                                     border-color:{{ $tech->color ?? 'var(--color-primary)' }};">
                            {{ $tech->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Galería --}}
            @if($project->galleries->count() > 0)
            <div class="modal-section">
                <h3 class="modal-section-title">
                    <i class="fas fa-images"></i> Galería
                </h3>
                <div class="modal-gallery-grid">
                    @foreach($project->galleries as $gallery)
                    <div class="modal-gallery-item">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}"
                             alt="{{ $gallery->caption ?? $project->title }}"
                             loading="lazy"
                             onclick="openLightbox(this.src)">
                        @if($gallery->caption)
                            <span class="gallery-caption">{{ $gallery->caption }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Botones de acción --}}
            @if($project->repository_url || $project->video_url || $project->project_url)
            <div class="modal-actions">
                @if($project->repository_url)
                <a href="{{ $project->repository_url }}" target="_blank" rel="noopener"
                   class="modal-btn btn-repo">
                    <i class="fab fa-github"></i> Repositorio
                </a>
                @endif
                @if($project->video_url)
                <a href="{{ $project->video_url }}" target="_blank" rel="noopener"
                   class="modal-btn btn-video">
                    <i class="fab fa-youtube"></i> Ver Demo
                </a>
                @endif
                @if($project->project_url)
                <a href="{{ $project->project_url }}" target="_blank" rel="noopener"
                   class="modal-btn btn-site">
                    <i class="fas fa-external-link-alt"></i> Ir al Sitio
                </a>
                @endif
            </div>
            @endif

        </div>
    </div>
</div>
@endforeach

{{-- LIGHTBOX simple para galería --}}
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <img id="lightbox-img" src="" alt="Imagen ampliada">
</div>

@if(!isset($isSection))
@endsection
@endif

@push('styles')
<style>
    /* ========================================== */
    /* SECCIÓN */
    /* ========================================== */
    .projects-section {
        position: relative;
        min-height: 100vh;
        background-color: var(--bg-page);
        padding: 5rem 0;
        overflow: hidden;
    }

    #particle-canvas {
        position: absolute;
        inset: 0;
        width: 100%; height: 100%;
        z-index: 1;
    }

    .projects-container {
        position: relative;
        z-index: 2;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* ========================================== */
    /* HEADER */
    /* ========================================== */
    .projects-header { text-align: center; margin-bottom: 4rem; }

    .projects-title {
        font-size: 3.5rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        color: var(--text-main);
        text-shadow: 0 0 30px rgba(212,175,55,0.6);
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    .projects-subtitle {
        display: inline-block;
        padding: 0.5rem 2rem;
        border-top: 2px solid var(--color-primary);
        border-bottom: 2px solid var(--color-primary);
    }

    .projects-subtitle p {
        color: var(--color-primary);
        font-size: 1.25rem;
        font-weight: 500;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        margin: 0;
    }

    /* ========================================== */
    /* GRID */
    /* ========================================== */
    .projects-flex {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 2.2rem;
    }

    /* ========================================== */
    /* CARD — zonas fijas */
    /* ========================================== */
    .project-card {
        background: var(--bg-card);
        border: 3px solid var(--color-primary);
        border-radius: 18px;
        overflow: hidden;
        width: 360px;
        flex: 0 0 360px;
        display: flex;
        flex-direction: column;
        transition: all 0.4s ease;
        box-shadow: 0 0 25px rgba(212,175,55,0.2);
    }

    .project-card:hover {
        transform: translateY(-12px);
        border-color: var(--color-secondary);
        box-shadow: 0 0 45px rgba(212,175,55,0.45);
    }

    .proj-zone { width: 100%; }

    /* ZONA 1: thumbnail — 220px fijo */
    .proj-zone--thumb {
        position: relative;
        height: 220px;
        overflow: hidden;
        background: var(--bg-section);
        flex-shrink: 0;
    }

    .project-image {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
        display: block;
    }

    .project-card:hover .project-image { transform: scale(1.08); }

    .project-placeholder {
        width: 100%; height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: var(--color-primary);
    }

    .project-year-badge {
        position: absolute;
        top: 12px; right: 12px;
        background: rgba(0,0,0,0.75);
        color: var(--color-primary);
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.8rem;
        border: 1px solid var(--color-primary);
    }

    /* ZONA 2: título — 64px fijo, 2 líneas */
    .proj-zone--title {
        height: 64px;
        display: flex;
        align-items: center;
        padding: 0 1.4rem;
        flex-shrink: 0;
    }

    .project-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-main);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin: 0;
    }

    /* ZONA 3: descripción — 72px fijo, 3 líneas */
    .proj-zone--description {
        height: 72px;
        padding: 0 1.4rem;
        flex-shrink: 0;
        overflow: hidden;
    }

    .project-description {
        color: var(--text-muted);
        font-size: 0.88rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin: 0;
    }

    /* ZONA 4: tecnologías — 52px fijo */
    .proj-zone--techs {
        height: 52px;
        padding: 0 1.4rem;
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
        gap: 0.4rem;
        overflow: hidden;
        flex-shrink: 0;
    }

    .tech-badge {
        padding: 0.25rem 0.7rem;
        font-size: 0.75rem;
        border-radius: 20px;
        border: 1px solid;
        font-weight: 600;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .tech-badge-more {
        padding: 0.25rem 0.7rem;
        background: rgba(255,255,255,0.06);
        color: var(--text-muted);
        border-radius: 20px;
        font-size: 0.75rem;
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* ZONA 5: botón — 72px fijo */
    .proj-zone--action {
        height: 72px;
        display: flex;
        align-items: center;
        padding: 0 1.4rem;
        flex-shrink: 0;
    }

    .project-btn {
        width: 100%;
        padding: 0.85rem;
        background: linear-gradient(135deg, var(--color-primary), #f1c40f);
        color: #000;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .project-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(212,175,55,0.5);
    }

    /* ========================================== */
    /* SIN PROYECTOS */
    /* ========================================== */
    .no-projects {
        text-align: center;
        padding: 4rem 0;
        color: var(--text-muted);
    }

    .no-projects i {
        font-size: 5rem;
        color: var(--color-primary);
        margin-bottom: 1.5rem;
        display: block;
    }

    /* ========================================== */
    /* MODAL */
    /* ========================================== */
    .project-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease;
    }

    .project-modal.active {
        opacity: 1;
        pointer-events: all;
    }

    .modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.92);
        backdrop-filter: blur(6px);
    }

    .modal-container {
        position: relative;
        width: 100%;
        max-width: 900px;
        max-height: 90vh;
        background: var(--bg-card);
        border: 2px solid var(--color-primary);
        border-radius: 20px;
        overflow-y: auto;
        box-shadow: 0 0 60px rgba(212,175,55,0.4);
        transform: scale(0.92);
        transition: transform 0.25s ease;
        scrollbar-width: thin;
        scrollbar-color: var(--color-primary) transparent;
    }

    .project-modal.active .modal-container { transform: scale(1); }

    .modal-close {
        position: sticky;
        top: 1rem;
        float: right;
        margin: 1rem 1rem 0 0;
        width: 44px; height: 44px;
        background: rgba(255,255,255,0.05);
        border: 2px solid var(--color-primary);
        color: var(--color-primary);
        border-radius: 50%;
        font-size: 1.2rem;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        background: var(--color-primary);
        color: #000;
        transform: rotate(90deg);
    }

    .modal-body { padding: 1.5rem 2rem 2rem; clear: both; }

    /* Imagen modal */
    .modal-image-wrap {
        position: relative;
        width: 100%;
        height: 320px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .modal-main-image {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
    }

    .modal-year-badge {
        position: absolute;
        top: 12px; right: 12px;
        background: rgba(0,0,0,0.8);
        color: var(--color-primary);
        padding: 0.4rem 1rem;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.85rem;
        border: 1px solid var(--color-primary);
    }

    /* Header modal */
    .modal-header { margin-bottom: 1.5rem; }

    .modal-title {
        font-size: 1.9rem;
        font-weight: 700;
        color: var(--text-main);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0 0 0.5rem;
    }

    .modal-year-inline {
        display: inline-block;
        background: var(--color-primary);
        color: #000;
        padding: 0.3rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    /* Descripción */
    .modal-description {
        color: var(--text-main);
        line-height: 1.85;
        font-size: 1rem;
        margin-bottom: 1.5rem;
        text-align: justify;
    }

    /* Secciones */
    .modal-section { margin-bottom: 1.5rem; }

    .modal-section-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--color-primary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Tecnologías modal */
    .modal-tech-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    .modal-tech-badge {
        padding: 0.45rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.85rem;
        border: 1px solid;
    }

    /* Galería modal */
    .modal-gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 0.8rem;
    }

    .modal-gallery-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid transparent;
        transition: border-color 0.3s;
    }

    .modal-gallery-item:hover { border-color: var(--color-primary); }

    .modal-gallery-item img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        display: block;
        cursor: pointer;
        transition: transform 0.3s;
    }

    .modal-gallery-item:hover img { transform: scale(1.05); }

    .gallery-caption {
        display: block;
        padding: 0.3rem 0.5rem;
        font-size: 0.75rem;
        color: var(--text-muted);
        background: rgba(0,0,0,0.5);
        text-align: center;
    }

    /* Botones modal */
    .modal-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(212,175,55,0.2);
    }

    .modal-btn {
        flex: 1;
        min-width: 160px;
        padding: 0.9rem 1.2rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: 2px solid transparent;
    }

    .btn-repo {
        background: transparent;
        color: var(--text-main);
        border-color: var(--text-main);
    }
    .btn-repo:hover {
        background: var(--text-main);
        color: var(--bg-card);
        text-decoration: none;
    }

    .btn-video {
        background: #ff0000;
        color: #fff;
        border-color: #ff0000;
    }
    .btn-video:hover {
        background: #cc0000;
        border-color: #cc0000;
        box-shadow: 0 6px 20px rgba(255,0,0,0.4);
        text-decoration: none;
        transform: translateY(-2px);
    }

    .btn-site {
        background: var(--color-primary);
        color: #000;
        border-color: var(--color-primary);
    }
    .btn-site:hover {
        background: transparent;
        color: var(--color-primary);
        box-shadow: 0 6px 20px rgba(212,175,55,0.4);
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* ========================================== */
    /* LIGHTBOX */
    /* ========================================== */
    .lightbox {
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(0,0,0,0.95);
        display: none;
        align-items: center;
        justify-content: center;
        cursor: zoom-out;
    }

    .lightbox.active { display: flex; }

    .lightbox img {
        max-width: 92vw;
        max-height: 92vh;
        border-radius: 8px;
        border: 2px solid var(--color-primary);
        object-fit: contain;
    }

    /* ========================================== */
    /* RESPONSIVE */
    /* ========================================== */
    @media (max-width: 768px) {
        .projects-title    { font-size: 2.5rem; }
        .projects-subtitle p { font-size: 1rem; }
        .project-card      { width: 320px; flex: 0 0 320px; }
        .modal-body        { padding: 1rem 1.2rem 1.5rem; }
        .modal-title       { font-size: 1.5rem; }
        .modal-image-wrap  { height: 220px; }
        .modal-actions     { flex-direction: column; }
        .modal-btn         { min-width: 100%; }
    }

    @media (max-width: 480px) {
        .projects-title    { font-size: 2rem; }
        .project-card      { width: 100%; flex: 0 0 100%; max-width: 360px; }
        .proj-zone--thumb  { height: 200px; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ========================================== */
    /* CANVAS PARTÍCULAS */
    /* ========================================== */
    const canvas  = document.getElementById('particle-canvas');
    if (!canvas) return;
    const ctx     = canvas.getContext('2d');
    const section = document.querySelector('.projects-section');

    function resizeCanvas() {
        canvas.width  = window.innerWidth;
        canvas.height = section.offsetHeight;
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    const particles = [];
    const COUNT = 80, MAX_DIST = 150;

    class Particle {
        constructor() {
            this.x  = Math.random() * canvas.width;
            this.y  = Math.random() * canvas.height;
            this.vx = (Math.random() - 0.5) * 0.5;
            this.vy = (Math.random() - 0.5) * 0.5;
        }
        update() {
            this.x += this.vx; this.y += this.vy;
            if (this.x < 0 || this.x > canvas.width)  this.vx *= -1;
            if (this.y < 0 || this.y > canvas.height)  this.vy *= -1;
        }
        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, 2, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(212,175,55,0.6)';
            ctx.fill();
        }
    }

    for (let i = 0; i < COUNT; i++) particles.push(new Particle());

    function connectParticles() {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const d  = Math.sqrt(dx*dx + dy*dy);
                if (d < MAX_DIST) {
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.strokeStyle = `rgba(212,175,55,${(1 - d/MAX_DIST)*0.3})`;
                    ctx.lineWidth = 1;
                    ctx.stroke();
                }
            }
        }
    }

    (function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => { p.update(); p.draw(); });
        connectParticles();
        requestAnimationFrame(animate);
    })();

});

/* ========================================== */
/* MODAL — sin construcción de HTML en runtime */
/* ========================================== */
let currentModal = null;

function openModal(id) {
    if (currentModal) closeModal(currentModal);
    const modal = document.getElementById('modal-' + id);
    if (!modal) return;
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    currentModal = id;
}

function closeModal(id) {
    const modal = document.getElementById('modal-' + id);
    if (!modal) return;
    modal.classList.remove('active');
    document.body.style.overflow = '';
    currentModal = null;
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && currentModal) closeModal(currentModal);
});

/* ========================================== */
/* LIGHTBOX */
/* ========================================== */
function openLightbox(src) {
    const lb = document.getElementById('lightbox');
    document.getElementById('lightbox-img').src = src;
    lb.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
    document.body.style.overflow = currentModal ? 'hidden' : '';
}
</script>
@endpush