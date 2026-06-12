{{-- resources/views/frontend/layouts/app.blade.php --}}
<!DOCTYPE html>
{{-- ============================================ --}}
{{-- IMPORTANTE: data-theme controla el tema (dark/light) --}}
{{-- El script al final del

<head> lo inicializa antes del render --}}
    {{-- ============================================ --}}
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- ============================================ --}}
        {{-- INICIALIZACIÓN DE TEMA (ANTES DE RENDER) --}}
        {{-- ============================================ --}}
        {{-- 📚 EXPLICACIÓN: Este script se ejecuta ANTES de cargar el CSS --}}
        {{-- para evitar el "flash" de tema incorrecto al cargar la página --}}
        <script>
            (function () {
                // Obtener tema guardado o detectar preferencia del sistema
                const savedTheme = localStorage.getItem('theme');
                const systemPreference = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                const theme = savedTheme || systemPreference;

                // Aplicar tema inmediatamente
                document.documentElement.setAttribute('data-theme', theme);
            })();
        </script>

        {{-- ============================================ --}}
        {{-- PRELOAD DEL LOGO PARA EVITAR LAG --}}
        {{-- ============================================ --}}
        @if($portfolioSettings?->logo_path)
            <link rel="preload" href="{{ logo() }}" as="image">
        @endif

        {{-- ============================================ --}}
        {{-- TITLE Y META TAGS DINÁMICOS --}}
        {{-- ============================================ --}}
        {{-- EXPLICACIÓN: __() es el helper de traducción de Laravel --}}
        {{-- Busca en lang/es/messages.php o lang/en/messages.php --}}

        <title>
            {{ profile('full_name') ?? __('messages.portfolio') }} | @yield('title', __('messages.home'))
        </title>

        <!-- SEO -->
        <meta name="description"
            content="@yield('meta_description', profile('bio_short') ?? __('messages.professional_portfolio'))">
        <meta name="keywords"
            content="@yield('meta_keywords', (profile('professional_title') ?? '') . ', ' . __('messages.developer') . ', ' . __('messages.portfolio'))">
        <meta name="author" content="{{ profile('full_name') ?? __('messages.developer') }}">

        <!-- Open Graph -->
        <meta property="og:title"
            content="@yield('og_title', (profile('full_name') ?? __('messages.portfolio')) . ' - ' . (profile('professional_title') ?? ''))">
        <meta property="og:description"
            content="@yield('og_description', profile('bio_short') ?? __('messages.professional_portfolio'))">
        <meta property="og:image" content="@yield('og_image', logo())">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
        <meta property="og:locale" content="{{ app()->getLocale() }}">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ profile('full_name') ?? __('messages.portfolio') }}">
        <meta name="twitter:description" content="{{ profile('bio_short') ?? '' }}">

        {{-- ============================================ --}}
        {{-- FAVICON DINÁMICO --}}
        {{-- ============================================ --}}
        <link rel="icon" type="image/png" href="{{ logo('favicon') }}?v={{ time() }}">
        <link rel="shortcut icon" href="{{ logo('favicon') }}?v={{ time() }}">
        <link rel="apple-touch-icon" href="{{ logo('favicon') }}?v={{ time() }}">

        {{-- ============================================ --}}
        {{-- FONTS --}}
        {{-- ============================================ --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- ============================================ --}}
        {{-- CSS LIBRARIES --}}
        {{-- ============================================ --}}

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- Iconify Icons --}}
        <iconify-icon icon="simple-icons:laravel"></iconify-icon>

        {{-- Devicon Icons --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">

        <!-- AOS (Animate On Scroll) -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        <!-- Swiper CSS (Carrusel) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        <!-- Tailwind CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- ============================================ --}}
        {{-- SISTEMA DE TEMAS CON CSS VARIABLES --}}
        {{-- ============================================ --}}
        <style>
            /* ========================================== */
            /* 📚 EXPLICACIÓN: CSS VARIABLES POR TEMA */
            /* ========================================== */
            /* Las variables cambian según [data-theme="dark"] o [data-theme="light"] */
            /* Esto permite cambiar TODA la paleta con solo cambiar un atributo HTML */

            :root {
                /* ========================================== */
                /* COLORES DEL PORTAFOLIO (DESDE BD) */
                /* ========================================== */
                --color-primary:
                    {{ color('primary') }}
                ;
                --color-secondary:
                    {{ color('secondary') }}
                ;
                --color-tertiary:
                    {{ color('tertiary') }}
                ;
                --color-text-dark:
                    {{ color('text_dark') }}
                ;
                --color-text-light:
                    {{ color('text_light') }}
                ;

                /* Gradiente dinámico */
                --gradient-bg: linear-gradient(135deg,
                        {{ color('primary') }}
                        0%,
                        {{ color('secondary') }}
                        100%);

                /* Colores derivados (hover states) */
                --color-primary-dark:
                    {{ adjustBrightness(color('primary'), -20) }}
                ;
                --color-secondary-dark:
                    {{ adjustBrightness(color('secondary'), -20) }}
                ;

                /* ========================================== */
                /* TEMA CLARO (DEFAULT) */
                /* ========================================== */
                --bg-page: #F8FAFC;
                --bg-section: #f8fafc;

                /* Tema claro: Fondo plano o un gradiente muy sutil claro */
                --bg-card: #ffffff;

                --text-main: #1e293b;
                --text-muted: #64748b;
                --border-color: #e2e8f0;
                --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);

                --text-main-rgb: 30, 41, 59;
                --text-muted-rgb: 100, 116, 139;
            }

            /* ========================================== */
            /* TEMA OSCURO */
            /* ========================================== */
            /* 📚 EXPLICACIÓN: Cuando HTML tiene data-theme="dark" */
            /* todas estas variables se sobrescriben automáticamente */
            [data-theme="dark"] {
                --bg-page: #020202;
                --bg-section: #020202;

                /* AQUÍ ASIGNAS EL GRADIENTE AL TEMA OSCURO */
                --bg-card: linear-gradient(135deg, rgba(0, 0, 0, 0.9) 0%, rgba(20, 20, 20, 0.95) 100%);

                --text-main: #f8fafc;
                --text-muted: #94a3b8;
                --border-color: #334155;
                --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.5);
                --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.5);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
            }

            /* ========================================== */
            /* ESTILOS BASE */
            /* ========================================== */
            body {
                font-family: 'Figtree', sans-serif;
                background-color: var(--bg-page);
                color: var(--text-main);
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            /* ========================================== */
            /* UTILIDADES PERSONALIZADAS CON COLORES DINÁMICOS */
            /* ========================================== */

            /* Fondos de tema */
            .bg-theme-page {
                background-color: var(--bg-page) !important;
            }

            .bg-theme-section {
                background-color: var(--bg-section) !important;
            }

            .bg-theme-card {
                background-color: var(--bg-card) !important;
            }

            /* Textos de tema */
            .text-theme-main {
                color: var(--text-main) !important;
            }

            .text-theme-muted {
                color: var(--text-muted) !important;
            }

            /* Bordes de tema */
            .border-theme {
                border-color: var(--border-color) !important;
            }

            /* Sombras de tema */
            .shadow-theme-sm {
                box-shadow: var(--shadow-sm) !important;
            }

            .shadow-theme-md {
                box-shadow: var(--shadow-md) !important;
            }

            .shadow-theme-lg {
                box-shadow: var(--shadow-lg) !important;
            }

            /* ========================================== */
            /* FONDOS DE COLORES PRIMARIOS */
            /* ========================================== */
            .bg-primary {
                background-color: var(--color-primary) !important;
            }

            .bg-secondary {
                background-color: var(--color-secondary) !important;
            }

            .bg-tertiary {
                background-color: var(--color-tertiary) !important;
            }

            .bg-gradient-primary {
                background: var(--gradient-bg) !important;
            }

            /* ========================================== */
            /* TEXTOS */
            /* ========================================== */
            .text-primary {
                color: var(--color-primary) !important;
            }

            .text-secondary {
                color: var(--color-secondary) !important;
            }

            .text-tertiary {
                color: var(--color-tertiary) !important;
            }

            /* ========================================== */
            /* BORDES */
            /* ========================================== */
            .border-primary {
                border-color: var(--color-primary) !important;
            }

            .border-secondary {
                border-color: var(--color-secondary) !important;
            }

            /* ========================================== */
            /* HOVERS */
            /* ========================================== */
            .hover-primary:hover {
                color: var(--color-primary) !important;
            }

            .hover-bg-primary:hover {
                background-color: var(--color-primary) !important;
            }

            .hover-bg-secondary:hover {
                background-color: var(--color-secondary) !important;
            }

            /* ========================================== */
            /* BOTONES PERSONALIZADOS */
            /* ========================================== */
            /* 📚 EXPLICACIÓN: Botones reutilizables con estilos dinámicos */
            /* Usa var(--color-primary) para que cambien con la BD */
            .btn-primary-custom {
                background-color: var(--color-primary);
                color: var(--color-text-light);
                padding: 0.75rem 1.5rem;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
                display: inline-block;
                text-decoration: none;
                text-align: center;
                border: none;
                font-weight: 500;
            }

            .btn-primary-custom:hover {
                background-color: var(--color-primary-dark);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                color: var(--color-text-light);
            }

            .btn-secondary-custom {
                background-color: var(--color-secondary);
                color: var(--color-text-light);
                padding: 0.75rem 1.5rem;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
            }

            .btn-secondary-custom:hover {
                background-color: var(--color-secondary-dark);
                color: var(--color-text-light);
            }

            .btn-outline-primary-custom {
                background-color: transparent;
                color: var(--color-primary);
                border: 2px solid var(--color-primary);
                padding: 0.75rem 1.5rem;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
            }

            .btn-outline-primary-custom:hover {
                background-color: var(--color-primary);
                color: var(--color-text-light);
            }

            /* ========================================== */
            /* OVERRIDE BOOTSTRAP CON COLORES DINÁMICOS */
            /* ========================================== */
            .btn-danger {
                background-color: var(--color-primary);
                border-color: var(--color-primary);
            }

            .btn-danger:hover {
                background-color: var(--color-primary-dark);
                border-color: var(--color-primary-dark);
            }

            .btn-outline-danger {
                color: var(--color-primary);
                border-color: var(--color-primary);
            }

            .btn-outline-danger:hover {
                background-color: var(--color-primary);
                border-color: var(--color-primary);
                color: var(--color-text-light);
            }

            .text-danger {
                color: var(--color-primary) !important;
            }

            .bg-danger {
                background-color: var(--color-primary) !important;
            }

            a.text-primary {
                color: var(--color-primary) !important;
            }

            a.text-primary:hover {
                color: var(--color-primary-dark) !important;
            }

            /* ========================================== */
            /* UTILIDADES GENERALES */
            /* ========================================== */
            html {
                scroll-behavior: smooth;
            }

            a {
                transition: color 0.3s ease, background-color 0.3s ease;
            }

            .shadow-primary {
                box-shadow: 0 4px 14px rgba(var(--color-primary), 0.3);
            }

            .shadow-secondary {
                box-shadow: 0 4px 14px rgba(var(--color-secondary), 0.3);
            }

            /* ========================================== */
            /* BOTÓN DE TOGGLE DE TEMA */
            /* ========================================== */
            /* 📚 EXPLICACIÓN: Estilos para el botón que cambiará el tema */
            /* Este botón irá en el header, pero definimos estilos aquí */
            .theme-toggle {
                background: var(--bg-card);
                border: 1px solid var(--border-color);
                color: var(--text-main);
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .theme-toggle:hover {
                background: var(--color-primary);
                color: var(--color-text-light);
                transform: rotate(180deg);
            }

            /* ========================================== */
            /* SELECTOR DE IDIOMA */
            /* ========================================== */
            .lang-selector {
                display: flex;
                gap: 0.5rem;
                align-items: center;
            }

            .lang-btn {
                padding: 0.25rem 0.75rem;
                border-radius: 0.375rem;
                background: transparent;
                color: var(--text-muted);
                border: 1px solid var(--border-color);
                cursor: pointer;
                transition: all 0.3s ease;
                font-size: 0.875rem;
                font-weight: 500;
            }

            .lang-btn:hover {
                background: var(--bg-card);
                color: var(--text-main);
            }

            .lang-btn.active {
                background: var(--color-primary);
                color: var(--color-text-light);
                border-color: var(--color-primary);
            }

            /* Oculta insignia flotante reCAPTCHA v3 */
            .grecaptcha-badge {
                visibility: hidden !important;
            }
        </style>

        {{-- ============================================ --}}
        {{-- RECAPTCHA V3 --}}
        {{-- ============================================ --}}
        <script
            src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
        <script>
            document.addEventListener('submit', function (e) {
                const form = e.target;

                // Solo aplicar a formularios con clase 'needs-recaptcha'
                if (!form.classList.contains('needs-recaptcha')) {
                    return;
                }

                e.preventDefault();

                grecaptcha.ready(function () {
                    grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'submit' })
                        .then(function (token) {
                            let recaptchaResponse = document.createElement('input');
                            recaptchaResponse.setAttribute('type', 'hidden');
                            recaptchaResponse.setAttribute('name', 'g-recaptcha-response');
                            recaptchaResponse.setAttribute('value', token);
                            form.appendChild(recaptchaResponse);
                            form.submit();
                        });
                });
            });
        </script>

        {{-- Estilos adicionales por página --}}
        @stack('styles')
    </head>

<body class="antialiased">
    {{-- ============================================ --}}
    {{-- HEADER / NAVBAR --}}
    {{-- ============================================ --}}
    @include('frontend.partials.header')

    {{-- ============================================ --}}
    {{-- CONTENIDO PRINCIPAL --}}
    {{-- ============================================ --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- ============================================ --}}
    {{-- FOOTER --}}
    {{-- ============================================ --}}
    @include('frontend.partials.footer')

    {{-- ============================================ --}}
    {{-- JAVASCRIPT LIBRARIES --}}
    {{-- ============================================ --}}

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <!-- GSAP (Animaciones) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- AOS (Animate On Scroll) -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 1000,
                    easing: 'ease-out-cubic',
                    once: true,
                    offset: 100,
                    delay: 100,
                });
            }
        });
    </script>

    <!-- Swiper JS (Carruseles) -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    {{-- ============================================ --}}
    {{-- SISTEMA DE TEMAS - JAVASCRIPT --}}
    {{-- ============================================ --}}
    {{-- 📚 EXPLICACIÓN: Funciones globales para manejar el tema --}}
    <script>
        /* ========================================== */
        /* FUNCIÓN PARA CAMBIAR EL TEMA */
        /* ========================================== */
        /* 📚 EXPLICACIÓN: Esta función se llama desde el botón toggle */
        /* 1. Lee el tema actual del atributo data-theme */
        /* 2. Calcula el nuevo tema (dark ↔ light) */
        /* 3. Actualiza el HTML y localStorage */
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';

            // Aplicar nuevo tema
            html.setAttribute('data-theme', newTheme);

            // Guardar preferencia en localStorage
            localStorage.setItem('theme', newTheme);

            // Actualizar ícono del botón (si existe)
            updateThemeIcon(newTheme);
        }

        /* ========================================== */
        /* ACTUALIZAR ÍCONO DEL TOGGLE */
        /* ========================================== */
        /* 📚 EXPLICACIÓN: Cambia el ícono de sol/luna según el tema */
        function updateThemeIcon(theme) {
            const themeIcon = document.getElementById('theme-icon');
            if (themeIcon) {
                if (theme === 'dark') {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                } else {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                }
            }
        }

        /* ========================================== */
        /* INICIALIZACIÓN AL CARGAR LA PÁGINA */
        /* ========================================== */
        /* 📚 EXPLICACIÓN: Cuando la página termina de cargar */
        /* actualizamos el ícono según el tema ya aplicado */
        document.addEventListener('DOMContentLoaded', function () {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            updateThemeIcon(currentTheme);

            // Detectar cambios en preferencia del sistema
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!localStorage.getItem('theme')) {
                    const newTheme = e.matches ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', newTheme);
                    updateThemeIcon(newTheme);
                }
            });
        });
    </script>

    {{-- ============================================ --}}
    {{-- CAMBIO DE IDIOMA - JAVASCRIPT --}}
    {{-- ============================================ --}}
    {{-- 📚 EXPLICACIÓN: Función para cambiar idioma --}}
    {{-- Laravel maneja esto con Session::put('locale') --}}
    <script>
        function changeLanguage(lang) {
            // Crear formulario dinámico para cambiar idioma
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('language.switch') }}'; // Ruta que crearemos después

            // Token CSRF
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';

            // Idioma seleccionado
            const langInput = document.createElement('input');
            langInput.type = 'hidden';
            langInput.name = 'language';
            langInput.value = lang;

            form.appendChild(csrfInput);
            form.appendChild(langInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>

    @include('frontend.partials.particles')

    {{-- Scripts adicionales por página --}}
    @stack('scripts')
</body>

</html>