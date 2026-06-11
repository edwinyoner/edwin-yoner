{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ============================================ --}}
    {{-- TÍTULO Y FAVICON DINÁMICOS --}}
    {{-- ============================================ --}}
    <title>{{ $profileSettings->full_name ?? config('app.name') }} - Panel de Administración</title>

    <link rel="icon" type="image/png" href="{{ logo('favicon') }}">
    <link rel="shortcut icon" href="{{ logo('favicon') }}">
    <link rel="apple-touch-icon" href="{{ logo('favicon') }}">

    {{-- ============================================ --}}
    {{-- FONTS --}}
    {{-- ============================================ --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- ============================================ --}}
    {{-- ICONOS --}}
    {{-- ============================================ --}}
    <iconify-icon icon="simple-icons:laravel"></iconify-icon>

    {{-- ============================================ --}}
    {{-- SCRIPTS Y ESTILOS BASE --}}
    {{-- ============================================ --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ============================================ --}}
    {{-- COLORES DINÁMICOS DESDE BASE DE DATOS --}}
    {{-- ============================================ --}}
    <style>
        :root {
            --color-primary:
                {{ color('primary') }}
            ;
            --color-primary-dark:
                {{ adjustBrightness(color('primary'), -20) }}
            ;
            --color-primary-light:
                {{ adjustBrightness(color('primary'), 20) }}
            ;
            --color-primary-rgb:
                {{ hexToRgb(color('primary')) }}
            ;

            --color-secondary:
                {{ color('secondary') }}
            ;
            --color-secondary-dark: {{ adjustBrightness(color('secondary'), -20) }};
            --color-secondary-rgb:
                {{ hexToRgb(color('secondary')) }}
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

            --gradient-bg: linear-gradient(135deg,
                    {{ color('primary') }}
                    0%,
                    {{ color('secondary') }}
                    100%);
        }

        /* ========================================== */
        /* OVERRIDES TAILWIND CON COLORES DINÁMICOS */
        /* ========================================== */
        .bg-indigo-600,
        .bg-gray-800 {
            background-color: var(--color-primary) !important;
        }

        .hover\:bg-indigo-700:hover,
        .hover\:bg-gray-700:hover {
            background-color: var(--color-primary-dark) !important;
        }

        .focus\:ring-indigo-500:focus,
        .focus\:border-indigo-500:focus {
            --tw-ring-color: rgba(var(--color-primary-rgb), 0.5) !important;
            border-color: var(--color-primary) !important;
        }

        .text-indigo-600 {
            color: var(--color-primary) !important;
        }

        .hover\:text-indigo-900:hover {
            color: var(--color-primary-dark) !important;
        }

        .border-indigo-400 {
            border-color: var(--color-primary-light) !important;
        }

        /* ========================================== */
        /* DARK MODE */
        /* ========================================== */
        .dark .dark\:bg-gray-900 {
            background-color: #0f172a !important;
        }

        .dark .dark\:bg-gray-800 {
            background-color: #1e293b !important;
        }

        .dark .dark\:bg-gray-700 {
            background-color: #334155 !important;
        }

        .dark header {
            background-color: #1e293b !important;
            border-bottom: 1px solid rgba(var(--color-primary-rgb), 0.1);
        }

        .dark .bg-gray-800 {
            background-color: var(--color-primary) !important;
        }

        .dark .hover\:bg-gray-700:hover {
            background-color: var(--color-primary-dark) !important;
        }

        /* ========================================== */
        /* NAVEGACIÓN */
        /* ========================================== */
        nav .active {
            background-color: rgba(var(--color-primary-rgb), 0.1);
            color: var(--color-primary);
            border-left: 3px solid var(--color-primary);
        }

        nav a:hover:not(.active) {
            background-color: rgba(var(--color-primary-rgb), 0.05);
            color: var(--color-primary);
        }

        /* ========================================== */
        /* UTILIDADES */
        /* ========================================== */
        .bg-primary-custom {
            background-color: var(--color-primary) !important;
        }

        .bg-gradient-primary {
            background: var(--gradient-bg) !important;
        }

        .text-primary-custom {
            color: var(--color-primary) !important;
        }

        .border-primary-custom {
            border-color: var(--color-primary) !important;
        }

        .shadow-primary {
            box-shadow: 0 4px 14px rgba(var(--color-primary-rgb), 0.3);
        }

        .hover-bg-primary:hover {
            background-color: var(--color-primary) !important;
            color: white !important;
        }

        /* ========================================== */
        /* BOTONES */
        /* ========================================== */
        .btn-primary-admin {
            background-color: var(--color-primary);
            color: white;
            padding: .5rem 1rem;
            border-radius: .375rem;
            font-weight: 500;
            transition: all .3s ease;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        .btn-primary-admin:hover {
            background-color: var(--color-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(var(--color-primary-rgb), 0.4);
        }

        .btn-secondary-admin {
            background-color: var(--color-secondary);
            color: white;
            padding: .5rem 1rem;
            border-radius: .375rem;
            font-weight: 500;
            transition: all .3s ease;
        }

        .btn-secondary-admin:hover {
            background-color: var(--color-secondary-dark);
        }

        .btn-outline-primary-admin {
            background-color: transparent;
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
            padding: .5rem 1rem;
            border-radius: .375rem;
            font-weight: 500;
            transition: all .3s ease;
        }

        .btn-outline-primary-admin:hover {
            background-color: var(--color-primary);
            color: white;
        }

        /* ========================================== */
        /* BADGES */
        /* ========================================== */
        .badge-primary {
            background-color: rgba(var(--color-primary-rgb), 0.1);
            color: var(--color-primary);
            padding: .25rem .75rem;
            border-radius: 9999px;
            font-size: .75rem;
            font-weight: 600;
        }

        .badge-success {
            background-color: #dcfce7;
            color: #166534;
            padding: .25rem .75rem;
            border-radius: 9999px;
            font-size: .75rem;
            font-weight: 600;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
            padding: .25rem .75rem;
            border-radius: 9999px;
            font-size: .75rem;
            font-weight: 600;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
            padding: .25rem .75rem;
            border-radius: 9999px;
            font-size: .75rem;
            font-weight: 600;
        }

        /* ========================================== */
        /* CARDS */
        /* ========================================== */
        .card-admin {
            background: white;
            border-radius: .5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .1);
            padding: 1.5rem;
            transition: all .3s ease;
        }

        .dark .card-admin {
            background: #1e293b;
        }

        .card-admin:hover {
            box-shadow: 0 4px 12px rgba(var(--color-primary-rgb), 0.15);
            transform: translateY(-2px);
        }

        .card-header-admin {
            border-bottom: 2px solid var(--color-primary);
            padding-bottom: .75rem;
            margin-bottom: 1rem;
        }

        /* ========================================== */
        /* TABLAS */
        /* ========================================== */
        .table-admin {
            width: 100%;
            border-collapse: collapse;
        }

        .table-admin thead {
            background: var(--gradient-bg);
            color: white;
        }

        .table-admin thead th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: .75rem;
            letter-spacing: .05em;
        }

        .table-admin tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color .2s ease;
        }

        .dark .table-admin tbody tr {
            border-bottom: 1px solid #334155;
        }

        .table-admin tbody tr:hover {
            background-color: rgba(var(--color-primary-rgb), 0.05);
        }

        .table-admin tbody td {
            padding: 1rem;
        }

        /* ========================================== */
        /* FORMULARIOS */
        /* ========================================== */
        .form-label-admin {
            display: block;
            font-size: .875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: .5rem;
        }

        .dark .form-label-admin {
            color: #d1d5db;
        }

        .form-input-admin {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: .375rem;
            padding: .625rem;
            font-size: .875rem;
            transition: all .3s ease;
        }

        .form-input-admin:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb), 0.1);
        }

        .dark .form-input-admin {
            background-color: #334155;
            border-color: #475569;
            color: white;
        }

        /* ========================================== */
        /* ALERTS */
        /* ========================================== */
        .alert-info {
            background-color: rgba(var(--color-primary-rgb), .1);
            border-left: 4px solid var(--color-primary);
            padding: 1rem;
            border-radius: .375rem;
            color: var(--color-primary-dark);
        }

        .alert-success {
            background-color: #dcfce7;
            border-left: 4px solid #16a34a;
            padding: 1rem;
            border-radius: .375rem;
            color: #166534;
        }

        .alert-warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 1rem;
            border-radius: .375rem;
            color: #92400e;
        }

        .alert-danger {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            padding: 1rem;
            border-radius: .375rem;
            color: #991b1b;
        }

        /* ========================================== */
        /* TRANSICIONES GLOBALES */
        /* ========================================== */
        * {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(.4, 0, .2, 1);
            transition-duration: 150ms;
        }
    </style>

    @stack('styles')
    @livewireStyles
</head>

<body class="font-sans antialiased">

    <x-banner />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        {{-- Navegación (Jetstream) --}}
        @livewire('navigation-menu')

        {{-- Cabecera de página --}}
        @if(isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- Contenido principal --}}
        <main>
            {{ $slot }}
        </main>

    </div>

    @stack('modals')
    @stack('scripts')
    @livewireScripts

</body>

</html>