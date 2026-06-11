@if(!isset($isSection))
    @extends('frontend.layouts.app')
    @section('title', __('messages.skills'))
    @section('content')
@endif

<section class="skills-section">

    <canvas id="particle-canvas" class="skills-section__canvas"></canvas>

    <div class="skills__container">

        {{-- ENCABEZADO --}}
        <div class="skills__header" data-aos="fade-down">
            <h1 class="skills__title">{{ __('messages.my_skills') }}</h1>
            <div class="skills__subtitle">
                <p class="skills__subtitle-text">
                    {{ __('messages.technologies') }} & {{ __('messages.tools') }}
                </p>
            </div>
        </div>

        {{-- CATEGORÍAS --}}
        @foreach($categories as $category)
        <div class="skill-category"
             data-aos="fade-up"
             data-aos-delay="{{ $loop->index * 100 }}">

            <div class="skill-category__header">
                <h2 class="skill-category__title">
                    @if($category->icon_class)
                        <span class="skill-category__icon">
                            <i class="{{ $category->icon_class }}"></i>
                        </span>
                    @endif
                    {{ strtoupper($category->name) }}
                </h2>
                <div class="skill-category__divider"></div>
            </div>

            <div class="skill-category__grid">
                @foreach($category->technologies as $tech)
                <div class="tech-card"
                     data-aos="zoom-in"
                     data-aos-delay="{{ $loop->index * 50 }}">

                    {{-- ZONA 1: Nombre — altura fija, 2 líneas máx --}}
                    <div class="tech-card__zone tech-card__zone--name">
                        <div class="tech-card__name-inner">
                            <span class="tech-card__name">{{ $tech->name }}</span>
                        </div>
                    </div>

                    {{-- ZONA 2: Logo — altura fija --}}
                    <div class="tech-card__zone tech-card__zone--logo">
                        @if($tech->icon_path)
                            <img src="{{ asset('storage/' . $tech->icon_path) }}"
                                 alt="{{ $tech->name }}"
                                 class="tech-card__logo"
                                 loading="lazy">
                        @elseif(!$tech->icon_class && $tech->slug)
                            <img src="https://cdn.simpleicons.org/{{ $tech->slug }}/{{ ltrim($tech->color ?? 'd4af37', '#') }}"
                                 alt="{{ $tech->name }}"
                                 class="tech-card__logo tech-card__logo--simple"
                                 loading="lazy">
                        @elseif($tech->icon_class)
                            <i class="{{ $tech->icon_class }} tech-card__logo--icon"
                               style="color: {{ $tech->color ?? 'var(--color-primary)' }}"></i>
                        @else
                            <div class="tech-card__logo-placeholder">
                                {{ strtoupper(substr($tech->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>

                    {{-- ZONA 3: Progreso — altura fija --}}
                    <div class="tech-card__zone tech-card__zone--progress">
                        <div class="tech-card__progress">
                            <div class="tech-card__progress-meta">
                                <span class="tech-card__progress-label">
                                    @switch($tech->proficiency_level)
                                        @case('basico')     {{ __('messages.basic') }}        @break
                                        @case('intermedio') {{ __('messages.intermediate') }} @break
                                        @case('avanzado')   {{ __('messages.advanced') }}     @break
                                    @endswitch
                                </span>
                                <span class="tech-card__progress-percent">
                                    {{ $tech->proficiency_percentage }}%
                                </span>
                            </div>
                            <div class="tech-card__progress-bar">
                                <div class="tech-card__progress-fill"
                                     style="width: 0%;
                                            background-color: {{ $tech->color ?? 'var(--color-primary)' }}"
                                     data-width="{{ $tech->proficiency_percentage }}%">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>

        </div>
        @endforeach

    </div>
</section>

@if(!isset($isSection))
    @endsection
@endif

@push('styles')
<style>
/* ============================================== */
/* SECCIÓN                                        */
/* ============================================== */
.skills-section {
    position: relative;
    min-height: 100vh;
    background-color: var(--bg-page);
    padding: 4rem 0;
    overflow: hidden;
}

.skills-section__canvas {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    z-index: 1;
}

.skills__container {
    position: relative;
    z-index: 2;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* ============================================== */
/* HEADER                                         */
/* ============================================== */
.skills__header { text-align: center; margin-bottom: 4rem; }

.skills__title {
    font-size: 3.5rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: var(--text-main);
    text-shadow: 0 0 30px rgba(212,175,55,0.6);
    margin-bottom: 1rem;
    text-transform: uppercase;
}

.skills__subtitle {
    display: inline-block;
    padding: 0.5rem 2rem;
    border-top: 2px solid var(--color-primary);
    border-bottom: 2px solid var(--color-primary);
}

.skills__subtitle-text {
    color: var(--color-primary);
    font-size: 1.2rem;
    font-weight: 500;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    margin: 0;
}

/* ============================================== */
/* CATEGORÍA                                      */
/* ============================================== */
.skill-category { margin-bottom: 4rem; }

.skill-category__header { text-align: center; margin-bottom: 2.5rem; }

.skill-category__title {
    font-size: 2rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: var(--text-main);
    margin-bottom: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 1rem;
}

.skill-category__icon {
    color: var(--color-primary);
    font-size: 2.2rem;
}

.skill-category__divider {
    width: 200px;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--color-primary), transparent);
    margin: 0 auto;
}

.skill-category__grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 2.5rem;
}

/* ============================================== */
/* TECH CARD — contenedor         n                */
/* ============================================== */
.tech-card {
    background: var(--bg-card);
    border: 3px solid var(--color-primary);
    border-radius: 15px;
    padding: 1.25rem;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 0 20px rgba(212,175,55,0.2),
                inset 0 0 40px rgba(0,0,0,0.5);
    flex: 0 0 220px;
    width: 220px;
    display: flex;
    flex-direction: column;
    gap: 0;
}

.tech-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 0 40px rgba(212,175,55,0.5),
                inset 0 0 40px rgba(0,0,0,0.5);
    border-color: var(--color-secondary);
}

/* ============================================== */
/* ZONAS FIJAS                                    */
/* ============================================== */
.tech-card__zone {
    width: 100%;
    flex-shrink: 0;
}

/* ZONA 1: Nombre — 60px fijo, 2 líneas máx */
.tech-card__zone--name {
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.tech-card__name-inner {
    background: linear-gradient(135deg,
        rgba(139,115,46,0.3),
        rgba(212,175,55,0.2));
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    border: 1px solid rgba(212,175,55,0.3);
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tech-card__name {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--text-main);
    letter-spacing: 0.05em;
    text-transform: uppercase;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin: 0;
}

/* ZONA 2: Logo — 110px fijo */
.tech-card__zone--logo {
    height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.tech-card__logo {
    max-width: 80px;
    max-height: 80px;
    object-fit: contain;
    filter: drop-shadow(0 0 8px rgba(255,255,255,0.2));
    transition: all 0.3s ease;
}

.tech-card:hover .tech-card__logo {
    transform: scale(1.1);
    filter: drop-shadow(0 0 18px rgba(212,175,55,0.6));
}

.tech-card__logo--simple {
    max-width: 80px;
    max-height: 80px;
}

.tech-card__logo--icon {
    font-size: 4rem;
    filter: drop-shadow(0 0 8px rgba(255,255,255,0.2));
    transition: all 0.3s ease;
}

.tech-card:hover .tech-card__logo--icon {
    transform: scale(1.1);
    filter: drop-shadow(0 0 18px currentColor);
}

.tech-card__logo-placeholder {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1a1a1a, #2a2a2a);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-primary);
    border: 2px solid var(--color-primary);
}

/* ZONA 3: Progreso — altura fija */
.tech-card__zone--progress { height: auto; }

.tech-card__progress {
    background: rgba(255,255,255,0.04);
    border-radius: 8px;
    padding: 0.85rem;
    border: 1px solid rgba(212,175,55,0.2);
}

.tech-card__progress-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.6rem;
    font-size: 0.78rem;
}

.tech-card__progress-label {
    color: var(--text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.tech-card__progress-percent {
    color: var(--color-primary);
    font-weight: 700;
}

.tech-card__progress-bar {
    width: 100%;
    height: 7px;
    background: rgba(255,255,255,0.08);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);
}

.tech-card__progress-fill {
    height: 100%;
    border-radius: 10px;
    transition: width 1s ease;
    animation: progress-glow 2s ease-in-out infinite;
}

@keyframes progress-glow {
    0%, 100% { box-shadow: 0 0 6px currentColor; }
    50%       { box-shadow: 0 0 14px currentColor; }
}

/* ============================================== */
/* RESPONSIVE                                     */
/* ============================================== */
@media (max-width: 1199px) {
    .tech-card { flex: 0 0 220px; width: 220px; }
}

@media (max-width: 991px) {
    .skills__title         { font-size: 2.5rem; }
    .skills__subtitle-text { font-size: 1rem; }
    .skill-category__title { font-size: 1.5rem; }
    .skill-category__grid  { gap: 1.25rem; }
    .tech-card { flex: 0 0 200px; width: 200px; }
}

@media (max-width: 767px) {
    .skill-category__grid { gap: 1rem; }
    .tech-card {
        flex: 0 0 calc(50% - 0.5rem);
        width: calc(50% - 0.5rem);
    }
}

@media (max-width: 479px) {
    .skills__title         { font-size: 2rem; }
    .skill-category__title { font-size: 1.3rem; flex-direction: column; gap: 0.5rem; }
    .tech-card {
        flex: 0 0 100%;
        width: 100%;
        max-width: 300px;
    }
    .tech-card__zone--logo { height: 90px; }
    .tech-card__logo,
    .tech-card__logo-placeholder { max-width: 70px; max-height: 70px; width: 70px; height: 70px; }
    .tech-card__logo--icon { font-size: 3.2rem; }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================
       PARTÍCULAS
       ============================================ */
    const canvas = document.getElementById('particle-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    function resizeCanvas() {
        canvas.width  = window.innerWidth;
        canvas.height = document.body.scrollHeight;
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    const PARTICLE_COUNT = 100;
    const MAX_DISTANCE   = 150;
    const particles      = [];

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

    for (let i = 0; i < PARTICLE_COUNT; i++) particles.push(new Particle());

    function connectParticles() {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const d  = Math.sqrt(dx*dx + dy*dy);
                if (d < MAX_DISTANCE) {
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.strokeStyle = `rgba(212,175,55,${(1 - d/MAX_DISTANCE)*0.3})`;
                    ctx.lineWidth = 1;
                    ctx.stroke();
                }
            }
        }
    }

    let animId;
    (function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => { p.update(); p.draw(); });
        connectParticles();
        animId = requestAnimationFrame(animate);
    })();

    document.addEventListener('turbo:before-visit', () => cancelAnimationFrame(animId));

    /* ============================================
       BARRAS DE PROGRESO — IntersectionObserver
       Se animan solo cuando el card es visible
       ============================================ */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const fill = entry.target.querySelector('.tech-card__progress-fill');
                if (fill) {
                    const target = fill.dataset.width;
                    setTimeout(() => { fill.style.width = target; }, 100);
                }
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.4 });

    document.querySelectorAll('.tech-card').forEach(c => observer.observe(c));
});
</script>
@endpush