{{-- resources/views/frontend/pages/home.blade.php --}}

@if(!isset($isSection))
@extends('frontend.layouts.app')
@section('title', __('messages.home'))
@section('content')
@endif

{{-- ============================================ --}}
{{-- SECCIÓN HERO --}}
{{-- ============================================ --}}
<section id="inicio" class="home-section">

    {{-- Fondo animado de partículas --}}
    <canvas id="particle-canvas" class="home-section__canvas"></canvas>

    {{-- Contenedor centrado --}}
    <div class="profile-wrapper">

        {{-- ======================================== --}}
        {{-- CARD PRINCIPAL --}}
        {{-- ======================================== --}}
        <article class="profile-card" data-aos="fade-up" data-aos-duration="1000">

            {{-- ---- BAND superior (franja dorada) ---- --}}
            <div class="profile-card__band"></div>

            {{-- ---- FOTO (sobresale de la band) ---- --}}
            <div class="profile-card__photo-wrap">
                @if($profile->profile_image)
                    <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="{{ $profile->full_name }}"
                        class="profile-card__photo">
                @else
                    <div class="profile-card__photo-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
            </div>

            {{-- ---- CUERPO DEL CARD ---- --}}
            <div class="profile-card__body">

                {{-- Nombre --}}
                <h1 class="profile-card__name">
                    {{ strtoupper($profile->full_name) }}
                </h1>

                {{-- Título profesional --}}
                <h2 class="profile-card__title">
                    {{ strtoupper($profile->professional_title) }}
                </h2>

                {{-- Biografía corta --}}
                @if($profile->bio_short)
                    <div class="profile-card__bio">
                        <p class="profile-card__bio-text">{{ $profile->bio_short }}</p>
                    </div>
                @endif

                {{-- Redes sociales --}}
                @if($socialLinks->count() > 0)
                    <div class="profile-card__socials">
                        @foreach($socialLinks as $social)
                            <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer"
                                class="profile-card__social-link" title="{{ $social->name }}" data-aos="zoom-in"
                                data-aos-delay="{{ $loop->index * 100 }}">
                                <i class="{{ $social->icon }}"></i>
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Ubicación --}}
                {{-- @if($profile->city || $profile->country)
                <p class="profile-card__location">
                    <i class="fas fa-map-marker-alt profile-card__location-icon"></i>
                    {{ implode(', ', array_filter([$profile->city, $profile->country])) }}
                </p>
                @endif --}}

                @if($profile->city || $profile->country)
                    <span class="profile-card__location">
                        <i class="fas fa-map-marker-alt profile-card__location-icon"></i>
                        {{ implode(', ', array_filter([$profile->city, $profile->country])) }}
                    </span>
                @endif


            </div>{{-- /.profile-card__body --}}

        </article>{{-- /.profile-card --}}

    </div>{{-- /.profile-wrapper --}}

</section>{{-- /.home-section --}}

@if(!isset($isSection))
    @endsection
@endif

@push('styles')
    <style>
        /* ==============================================
                           PROFILE SECTION — sección fullscreen
                           ============================================== */
        .home-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-page);
            overflow: hidden;
            padding: 2rem 1rem;
        }

        /* Canvas de partículas al fondo */
        .home-section__canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        /* ==============================================
                           PROFILE WRAPPER — centra el card
                           ============================================== */
        .profile-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 520px;
            /* card compacto tipo el ejemplo */
            /* 📚 Espacio extra arriba para que la foto no se corte */
            padding-top: 80px;
        }

        /* ==============================================
                           PROFILE CARD — bloque principal BEM
                           ============================================== */
        .profile-card {
            position: relative;
            background: var(--bg-card);
            border: 2px solid var(--color-primary);
            border-radius: 20px;
            text-align: center;
            box-shadow:
                0 0 40px rgba(212, 175, 55, 0.25),
                inset 0 0 60px rgba(0, 0, 0, 0.4);
            overflow: visible;
            /* permite que la foto sobresalga */
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-4px);
            box-shadow:
                0 0 60px rgba(212, 175, 55, 0.45),
                inset 0 0 60px rgba(0, 0, 0, 0.4);
        }

        /* ==============================================
                           PROFILE CARD — FRANJA superior (band)
                           📚 Equivale al área azul del ejemplo de referencia
                           ============================================== */
        .profile-card__band {
            height: 110px;
            border-radius: 18px 18px 0 0;
            background: linear-gradient(135deg,
                    var(--color-primary) 0%,
                    var(--color-secondary, #b8960c) 100%);
        }

        /* ==============================================
                           PROFILE CARD — FOTO
                           📚 Circular sobresaliendo de la band, centrada
                           ============================================== */
        .profile-card__photo-wrap {
            position: absolute;
            top: 0;
            /* relativo a .profile-card */
            left: 50%;
            transform: translate(-50%, 30px);
            /* 30 px desde la parte superior de la band */
            width: 160px;
            height: 160px;
            z-index: 3;
        }

        /* Anillo giratorio dorado */
        .profile-card__photo-wrap::before {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            background: linear-gradient(45deg,
                    var(--color-primary),
                    var(--color-secondary, #b8960c),
                    var(--color-primary));
            animation: profile-photo-spin 3s linear infinite;
            z-index: -1;
        }

        .profile-card__photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid var(--bg-page);
            display: block;
        }

        .profile-card__photo-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: var(--bg-section);
            border: 4px solid var(--bg-page);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--color-primary);
        }

        @keyframes profile-photo-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* ==============================================
                           PROFILE CARD — CUERPO
                           📚 Padding-top alto para que el texto
                              no quede debajo de la foto superpuesta
                           ============================================== */
        .profile-card__body {
            padding: 110px 2rem 2.5rem;
            /* 110 px ≈ mitad foto + margen */
            color: var(--text-main);
        }

        /* ==============================================
                           PROFILE CARD — NOMBRE
                           ============================================== */
        .profile-card__name {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            margin-bottom: 0.6rem;
            color: var(--text-main);
            text-shadow: 0 0 18px rgba(212, 175, 55, 0.45);
            line-height: 1.2;
        }

        /* ==============================================
                           PROFILE CARD — TÍTULO PROFESIONAL
                           ============================================== */
        .profile-card__title {
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            color: var(--color-primary);
            margin-bottom: 1.8rem;
            text-transform: uppercase;
            display: inline-block;
            border-bottom: 2px solid var(--color-primary);
            padding-bottom: 0.4rem;
        }

        /* ==============================================
                           PROFILE CARD — BIOGRAFÍA
                           ============================================== */
        .profile-card__bio {
            margin-bottom: 2rem;
        }

        .profile-card__bio-text {
            font-size: 0.97rem;
            line-height: 1.8;
            color: var(--text-muted);
            text-align: center;
        }

        /* ==============================================
                           PROFILE CARD — REDES SOCIALES
                           ============================================== */
        .profile-card__socials {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.8rem;
        }

        .profile-card__social-link {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.35rem;
            color: var(--text-main);
            background-color: rgba(var(--text-main-rgb), 0.08);
            border: 2px solid rgba(var(--text-main-rgb), 0.18);
            transition: all 0.3s ease;
        }

        .profile-card__social-link:hover {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: #000;
            transform: translateY(-4px) scale(1.1);
            box-shadow: 0 8px 22px rgba(212, 175, 55, 0.4);
        }

        /* ==============================================
                           PROFILE CARD — UBICACIÓN
                           ============================================== */
        /* .profile-card__location {
                                font-size: 0.88rem;
                                color: var(--text-muted);
                                letter-spacing: 0.05em;
                            }

                            .profile-card__location-icon {
                                color: var(--color-primary);
                                margin-right: 0.35rem;
                            } */

        .profile-card__location {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.04em;
            color: var(--color-primary);
            background-color: rgba(212, 175, 55, 0.12);
            border: 1px solid rgba(212, 175, 55, 0.35);
            border-radius: 999px;
            padding: 0.3rem 0.85rem;
        }

        .profile-card__location-icon {
            font-size: 0.75rem;
        }


        /* ==============================================
                           RESPONSIVE
                           ============================================== */
        @media (max-width: 600px) {
            .profile-wrapper {
                padding-top: 70px;
            }

            .profile-card__band {
                height: 90px;
            }

            .profile-card__photo-wrap {
                width: 130px;
                height: 130px;
                transform: translate(-50%, 20px);
            }

            .profile-card__body {
                padding: 90px 1.5rem 2rem;
            }

            .profile-card__name {
                font-size: 1.45rem;
            }

            .profile-card__title {
                font-size: 0.85rem;
            }

            .profile-card__bio-text {
                font-size: 0.9rem;
            }

            .profile-card__social-link {
                width: 40px;
                height: 40px;
                font-size: 1.15rem;
            }
        }

        @media (max-width: 400px) {
            .profile-card__photo-wrap {
                width: 110px;
                height: 110px;
            }

            .profile-card__name {
                font-size: 1.25rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        /* ==============================================
           PARTÍCULAS — efecto red de puntos conectados
           ============================================== */

        document.addEventListener('DOMContentLoaded', function () {
            createParticleCanvas('particle-canvas', '.home-section');
        });
    </script>
@endpush