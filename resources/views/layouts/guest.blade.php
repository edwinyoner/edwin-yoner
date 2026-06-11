{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ============================================ --}}
    {{-- TÍTULO Y FAVICON DINÁMICOS --}}
    {{-- ============================================ --}}
    <title>{{ config('app.name', profile('full_name')) }} - Acceso</title>

    <!-- Favicon Dinámico -->
    <link rel="icon" type="image/png" href="{{ logo('favicon') }}">
    <link rel="shortcut icon" href="{{ logo('favicon') }}">
    <link rel="apple-touch-icon" href="{{ logo('favicon') }}">

    {{-- ============================================ --}}
    {{-- META TAGS --}}
    {{-- ============================================ --}}
    <meta name="description" content="Panel de administración de {{ profile('full_name') }}">
    <meta name="robots" content="noindex, nofollow">

    {{-- ============================================ --}}
    {{-- FONTS --}}
    {{-- ============================================ --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    {{-- ============================================ --}}
    {{-- SCRIPTS Y ESTILOS BASE --}}
    {{-- ============================================ --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ============================================ --}}
    {{-- COLORES CORPORATIVOS DINÁMICOS --}}
    {{-- ============================================ --}}
    <style>
        :root {
            /* ========================================== */
            /* PALETA DE COLORES CORPORATIVOS DINÁMICOS */
            /* ========================================== */
            --color-primary: {{ color('primary') }};
            --color-primary-dark: {{ adjustBrightness(color('primary'), -20) }};
            --color-primary-light: {{ adjustBrightness(color('primary'), 40) }};
            --color-primary-rgb: {{ hexToRgb(color('primary')) }};
            
            --color-secondary: {{ color('secondary') }};
            --color-secondary-dark: {{ adjustBrightness(color('secondary'), -20) }};
            --color-secondary-rgb: {{ hexToRgb(color('secondary')) }};
            
            --color-tertiary: {{ color('tertiary') }};
            --color-text-dark: {{ color('text_dark') }};
            --color-text-light: {{ color('text_light') }};
            
            /* Gradientes corporativos */
            --gradient-primary: linear-gradient(135deg, {{ color('primary') }} 0%, {{ color('secondary') }} 100%);
            --gradient-light: linear-gradient(135deg, {{ adjustBrightness(color('primary'), 40) }} 0%, {{ adjustBrightness(color('secondary'), 40) }} 100%);
        }

        /* ========================================== */
        /* BODY Y CONTAINER */
        /* ========================================== */
        body {
            font-family: 'Figtree', sans-serif;
            background: var(--gradient-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Patrón de fondo animado */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba({{ hexToRgb(color('primary')) }}, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba({{ hexToRgb(color('secondary')) }}, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba({{ hexToRgb(color('tertiary')) }}, 0.1) 0%, transparent 50%);
            animation: float-pattern 20s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes float-pattern {
            0%, 100% { transform: translate(0, 0); }
            33% { transform: translate(30px, -30px); }
            66% { transform: translate(-20px, 20px); }
        }

        /* ========================================== */
        /* CARD DE AUTENTICACIÓN */
        /* ========================================== */
        .auth-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 3rem 2.5rem;
            position: relative;
            z-index: 10;
            animation: slide-up 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dark .auth-card {
            background: #1e293b;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        /* ========================================== */
        /* LOGO Y HEADER */
        /* ========================================== */
        .auth-logo {
            display: block;
            margin: 0 auto 2rem;
            max-width: 180px;
            max-height: 80px;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba({{ hexToRgb(color('primary')) }}, 0.3));
            animation: logo-float 3s ease-in-out infinite;
        }

        @keyframes logo-float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .auth-title {
            text-align: center;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--color-text-dark);
            margin-bottom: 0.5rem;
        }

        .dark .auth-title {
            color: white;
        }

        .auth-subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 2rem;
        }

        .dark .auth-subtitle {
            color: #9ca3af;
        }

        /* ========================================== */
        /* FORMULARIOS */
        /* ========================================== */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .dark .form-label {
            color: #d1d5db;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 4px rgba(var(--color-primary-rgb), 0.1);
            background: white;
        }

        .dark .form-input {
            background: #0f172a;
            border-color: #334155;
            color: white;
        }

        .dark .form-input:focus {
            background: #0f172a;
            border-color: var(--color-primary);
        }

        /* Input con error */
        .form-input.error {
            border-color: #ef4444;
        }

        .form-input.error:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .form-error {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* ========================================== */
        /* CHECKBOX Y REMEMBER ME */
        /* ========================================== */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-checkbox {
            width: 1.125rem;
            height: 1.125rem;
            border: 2px solid #d1d5db;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .form-checkbox:checked {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .form-checkbox:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb), 0.1);
        }

        .checkbox-label {
            font-size: 0.875rem;
            color: #374151;
            cursor: pointer;
        }

        .dark .checkbox-label {
            color: #d1d5db;
        }

        /* ========================================== */
        /* BOTONES */
        /* ========================================== */
        .btn-primary-auth {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: var(--gradient-primary);
            color: white;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(var(--color-primary-rgb), 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-primary-auth::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, 
                {{ adjustBrightness(color('primary'), 20) }} 0%, 
                {{ adjustBrightness(color('secondary'), 20) }} 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-primary-auth:hover::before {
            opacity: 1;
        }

        .btn-primary-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(var(--color-primary-rgb), 0.5);
        }

        .btn-primary-auth:active {
            transform: translateY(0);
        }

        .btn-primary-auth span {
            position: relative;
            z-index: 1;
        }

        .btn-secondary-auth {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: transparent;
            color: var(--color-primary);
            font-weight: 600;
            font-size: 1rem;
            border: 2px solid var(--color-primary);
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary-auth:hover {
            background: var(--color-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(var(--color-primary-rgb), 0.3);
        }

        /* ========================================== */
        /* LINKS */
        /* ========================================== */
        .auth-link {
            color: var(--color-primary);
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            position: relative;
        }

        .auth-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--color-primary);
            transition: width 0.3s ease;
        }

        .auth-link:hover::after {
            width: 100%;
        }

        .auth-link:hover {
            color: var(--color-primary-dark);
        }

        /* ========================================== */
        /* DIVIDER */
        /* ========================================== */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, #e5e7eb, transparent);
        }

        .dark .divider::before,
        .dark .divider::after {
            background: linear-gradient(to right, transparent, #334155, transparent);
        }

        .divider span {
            color: #9ca3af;
            font-size: 0.875rem;
        }

        /* ========================================== */
        /* FOOTER */
        /* ========================================== */
        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .dark .auth-footer {
            border-top-color: #334155;
        }

        .auth-footer-text {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .dark .auth-footer-text {
            color: #9ca3af;
        }

        /* ========================================== */
        /* VALIDATION ERRORS */
        /* ========================================== */
        .validation-errors {
            background: #fee2e2;
            border: 1px solid #fecaca;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .dark .validation-errors {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
        }

        .validation-errors ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .validation-errors li {
            color: #991b1b;
            font-size: 0.875rem;
            padding: 0.25rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dark .validation-errors li {
            color: #fca5a5;
        }

        .validation-errors li::before {
            content: '⚠️';
        }

        /* ========================================== */
        /* STATUS MESSAGE */
        /* ========================================== */
        .status-message {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: #166534;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dark .status-message {
            background: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.2);
            color: #86efac;
        }

        .status-message::before {
            content: '✓';
            font-weight: bold;
            font-size: 1.125rem;
        }

        /* ========================================== */
        /* RESPONSIVE */
        /* ========================================== */
        @media (max-width: 640px) {
            .auth-card {
                padding: 2rem 1.5rem;
                border-radius: 1rem;
            }

            .auth-logo {
                max-width: 140px;
                margin-bottom: 1.5rem;
            }

            .auth-title {
                font-size: 1.5rem;
            }

            .form-input {
                padding: 0.625rem 0.875rem;
                font-size: 1rem;
            }

            .btn-primary-auth,
            .btn-secondary-auth {
                padding: 0.75rem 1.25rem;
            }
        }

        /* ========================================== */
        /* LOADING STATE */
        /* ========================================== */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1rem;
            height: 1rem;
            border: 2px solid white;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: translateY(-50%) rotate(360deg); }
        }

        /* ========================================== */
        /* UTILITIES */
        /* ========================================== */
        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .gap-4 {
            gap: 1rem;
        }
    </style>

    {{-- Estilos adicionales por página --}}
    @stack('styles')

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body>
    <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        {{-- ============================================ --}}
        {{-- CONTENIDO PRINCIPAL (Login/Register Forms) --}}
        {{-- ============================================ --}}
        {{ $slot }}
    </div>

    {{-- ============================================ --}}
    {{-- SCRIPTS ADICIONALES --}}
    {{-- ============================================ --}}
    @stack('scripts')

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>