@if(!isset($isSection))
@extends('frontend.layouts.app')
@section('title', __('messages.documents'))
@section('content')
@endif

<section id="documentos" class="documents-section">
    <canvas id="particle-canvas"></canvas>

    <div class="documents-container">

        {{-- TÍTULO --}}
        <div class="documents-header" data-aos="fade-down">
            <h1 class="documents-title">{{ __('messages.my_documents') }}</h1>
            <div class="documents-subtitle">
                <p>{{ __('messages.cv') }} & {{ __('messages.certificates') }}</p>
            </div>
        </div>

        {{-- GRID --}}
        @if($documents->count() > 0)
            <div class="document-section" data-aos="fade-up">

                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-file-pdf"></i>
                        {{ strtoupper(__('messages.documents')) }}
                    </h2>
                    <div class="section-divider"></div>
                </div>

                <div class="documents-flex">
                    @foreach($documents as $document)
                        <div class="document-card" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">

                            {{-- ZONA 1: Icono (altura fija) --}}
                            <div class="doc-zone doc-zone--icon">
                                <i class="{{ $document->icon_with_fallback }}"
                                    style="color: {{ $document->color_with_fallback }};"></i>
                            </div>

                            {{-- ZONA 2: Título (altura fija, 2 líneas) --}}
                            <div class="doc-zone doc-zone--title">
                                <h3 class="doc-title">{{ $document->title }}</h3>
                            </div>

                            {{-- ZONA 3: Descripción (altura fija, 3 líneas) --}}
                            <div class="doc-zone doc-zone--description">
                                @if($document->hasDescription())
                                    <p class="doc-description">{{ Str::limit($document->description, 90) }}</p>
                                @endif
                            </div>

                            {{-- ZONA 4: Metadatos (altura fija) --}}
                            <div class="doc-zone doc-zone--meta">
                                <span class="doc-meta-item">
                                    <i class="fas fa-file"></i>
                                    {{ $document->file_extension }}
                                </span>
                                <span class="doc-meta-item">
                                    <i class="fas fa-download"></i>
                                    {{ $document->download_count }}
                                </span>
                            </div>

                            {{-- ZONA 5: Botones (altura fija) --}}
                            <div class="doc-zone doc-zone--actions">
                                @if($document->file_path)
                                    <div class="doc-actions-row">
                                        {{-- <div>
                                            <a href="{{ route('frontend.documents.view', $document->id) }}" target="_blank"
                                                class="doc-btn doc-btn--view" title="{{ __('messages.view') }}">
                                                <i class="fas fa-eye"></i>
                                                {{ __('messages.view') }}
                                            </a>
                                        </div> --}}
                                        <div>
                                            <a href="{{ route('frontend.documents.download', $document->id) }}"
                                                class="doc-btn doc-btn--download" title="{{ __('messages.download') }}">
                                                <i class="fas fa-download"></i>
                                                {{ __('messages.download') }}
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <span class="doc-btn doc-btn--disabled">
                                        <i class="fas fa-ban"></i>
                                        No disponible
                                    </span>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

        @else
            <div class="no-documents" data-aos="fade-up">
                <i class="fas fa-folder-open"></i>
                <p>{{ __('messages.no_results') }}</p>
            </div>
        @endif

    </div>
</section>

@if(!isset($isSection))
    @endsection
@endif

@push('styles')
    <style>
        /* ========================================== */
        /* SECCIÓN PRINCIPAL */
        /* ========================================== */
        .documents-section {
            position: relative;
            min-height: 100vh;
            background-color: var(--bg-page);
            padding: 4rem 0;
            overflow: hidden;
        }

        #particle-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .documents-container {
            position: relative;
            z-index: 2;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* ========================================== */
        /* HEADER */
        /* ========================================== */
        .documents-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .documents-title {
            font-size: 3.5rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: var(--text-main);
            text-shadow: 0 0 30px rgba(212, 175, 55, 0.6);
            margin-bottom: 1rem;
            text-transform: uppercase;
        }

        .documents-subtitle {
            display: inline-block;
            padding: 0.5rem 2rem;
            border-top: 2px solid var(--color-primary);
            border-bottom: 2px solid var(--color-primary);
        }

        .documents-subtitle p {
            color: var(--color-primary);
            font-size: 1.2rem;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin: 0;
        }

        /* ========================================== */
        /* SECTION HEADER */
        /* ========================================== */
        .document-section {
            margin-bottom: 4rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: var(--text-main);
            margin-bottom: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 1rem;
        }

        .section-title i {
            color: var(--color-primary);
            font-size: 2.2rem;
        }

        .section-divider {
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--color-primary), transparent);
            margin: 0 auto;
        }

        /* ========================================== */
        /* GRID */
        /* ========================================== */
        .documents-flex {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
        }

        /* ========================================== */
        /* CARD — layout fijo por zonas */
        /* ========================================== */
        .document-card {
            background: var(--bg-card);
            border: 3px solid var(--color-primary);
            border-radius: 15px;
            padding: 1.5rem 1.25rem;
            width: 280px;
            flex: 0 0 280px;
            /* ancho fijo, no crece ni encoge */
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
            /* las zonas manejan su propio espaciado */
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.2),
                inset 0 0 40px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
        }

        .document-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 0 40px rgba(212, 175, 55, 0.5),
                inset 0 0 40px rgba(0, 0, 0, 0.5);
            border-color: var(--color-secondary);
        }

        /* ---- zonas internas ---- */
        .doc-zone {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ZONA 1: icono — altura fija 90px */
        .doc-zone--icon {
            height: 90px;
            margin-bottom: 1rem;
        }

        .doc-zone--icon i {
            font-size: 4rem;
            filter: drop-shadow(0 0 12px currentColor);
        }

        /* ZONA 2: título — altura fija 56px, 2 líneas máx */
        .doc-zone--title {
            height: 56px;
            margin-bottom: 0.75rem;
            align-items: flex-start;
        }

        .doc-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: center;
            line-height: 1.4;
            /* clamp a 2 líneas */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0;
            width: 100%;
        }

        /* ZONA 3: descripción — altura fija 66px, 3 líneas máx */
        .doc-zone--description {
            height: 66px;
            margin-bottom: 1rem;
            align-items: flex-start;
        }

        .doc-description {
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.5;
            text-align: center;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0;
            width: 100%;
        }

        /* ZONA 4: metadatos — altura fija 32px */
        .doc-zone--meta {
            height: 32px;
            gap: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .doc-meta-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--color-primary);
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* ZONA 5: botones — siempre al fondo */
        .doc-zone--actions {
            height: auto;
            flex-direction: column;
            gap: 0.6rem;
            margin-top: auto;
        }

        .doc-actions-row {
            display: flex;
            justify-content: space-around;
            gap: 0.6rem;
            width: 100%;
        }

        .doc-actions-row .doc-btn {
            flex: 1;
        }

        .doc-btn {
            width: 100%;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .doc-btn--download {
            background: transparent;
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .doc-btn--download:hover {
            background: var(--color-primary);
            color: #000;
            transform: translateY(-2px);
            text-decoration: none;
        }

        .doc-btn--view {
            background: transparent;
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .doc-btn--view:hover {
            background: var(--color-primary);
            color: #000;
            transform: translateY(-2px);
            text-decoration: none;
        }

        .doc-btn--disabled {
            background: transparent;
            border-color: #555;
            color: #555;
            cursor: not-allowed;
        }

        /* ========================================== */
        /* SIN DOCUMENTOS */
        /* ========================================== */
        .no-documents {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
        }

        .no-documents i {
            font-size: 5rem;
            color: var(--color-primary);
            margin-bottom: 1rem;
            display: block;
        }

        .no-documents p {
            font-size: 1.2rem;
            font-weight: 500;
        }

        /* ========================================== */
        /* RESPONSIVE */
        /* ========================================== */
        @media (max-width: 768px) {
            .documents-title {
                font-size: 2.5rem;
            }

            .documents-subtitle p {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.5rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .documents-flex {
                gap: 1.5rem;
            }

            .document-card {
                width: 260px;
                flex: 0 0 260px;
            }
        }

        @media (max-width: 480px) {
            .documents-title {
                font-size: 2rem;
            }

            .document-card {
                width: 100%;
                flex: 0 0 100%;
                max-width: 320px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* ========================================== */
            /* CANVAS PARTÍCULAS */
            /* ========================================== */
            const canvas = document.getElementById('particle-canvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const section = document.querySelector('.documents-section');

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = section.offsetHeight;
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            const particles = [];
            const COUNT = 80;
            const MAX_DIST = 150;

            class Particle {
                constructor() { this.reset(); }
                reset() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.vx = (Math.random() - 0.5) * 0.5;
                    this.vy = (Math.random() - 0.5) * 0.5;
                    this.r = 2;
                }
                update() {
                    this.x += this.vx;
                    this.y += this.vy;
                    if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
                }
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
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
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < MAX_DIST) {
                            const op = (1 - dist / MAX_DIST) * 0.3;
                            ctx.beginPath();
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.strokeStyle = `rgba(212,175,55,${op})`;
                            ctx.lineWidth = 1;
                            ctx.stroke();
                        }
                    }
                }
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => { p.update(); p.draw(); });
                connectParticles();
                requestAnimationFrame(animate);
            }

            animate();
        });
    </script>
@endpush