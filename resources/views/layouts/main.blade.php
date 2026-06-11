{{-- resources/views/layouts/main.blade.php --}}
@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Renombrar la sección de contenido --}}

@section('content')
    @yield('content_body')
@stop

{{-- Crear un pie de página común --}}
@section('footer')
    <div class="float-right text-muted">
        Versión {{ config('app.version', '1.0.0') }}
    </div>

    <strong>
        &copy; {{ now()->year }} 
        <a href="{{ config('app.url', '#') }}" class="text-primary font-weight-bold">
            {{ profile('full_name') ?? 'EDWIN YONER' }}
        </a>Todos los derechos reservados.
    </strong>
@stop


{{-- Agregar código JavaScript/Jquery común --}}

@push('js')
<script>

    $(document).ready(function() {
        // Add your common script logic here...
    });

</script>
@endpush

{{-- Agregar personalizaciones CSS comunes --}}

@push('css')
<style type="text/css">

    /* ========================================== */
    /* VARIABLES CSS DINÁMICAS PARA ADMINLTE */
    /* ========================================== */
    :root {
        --admin-primary: {{ color('primary') }};
        --admin-primary-dark: {{ adjustBrightness(color('primary'), -20) }};
        --admin-primary-light: {{ adjustBrightness(color('primary'), 20) }};
        --admin-secondary: {{ color('secondary') }};
        --admin-tertiary: {{ color('tertiary') }};
        --admin-gradient: linear-gradient(135deg, {{ color('primary') }}, {{ color('secondary') }});
    }

    /* ========================================== */
    /* NAVBAR SUPERIOR */
    /* ========================================== */
    /* .main-header.navbar {
        background: var(--admin-gradient) !important;
        border-bottom: 3px solid var(--admin-primary-dark);
    }

    .main-header .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .main-header .navbar-nav .nav-link:hover {
        color: #fff !important;
        background-color: rgba(0, 0, 0, 0.1);
    } */

    /* ========================================== */
    /* SIDEBAR LATERAL */
    /* ========================================== */
    /* .main-sidebar {
        background-color: {{ color('tertiary') }} !important;
    } */

    /* Logo del sidebar */
    /* .brand-link {
        background-color: var(--admin-primary) !important;
        border-bottom: 2px solid var(--admin-primary-dark);
        color: #fff !important;
    } */

    /* .brand-link:hover {
        background-color: var(--admin-primary-dark) !important;
    } */

    /* Items del menú sidebar */
    /* .nav-sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    .nav-sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
    } */

    /* Item activo del menú */
    /* .nav-sidebar .nav-link.active {
        background-color: var(--admin-primary) !important;
        color: #fff !important;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    } */

    /* Submenú del sidebar */
    /* .nav-treeview > .nav-item > .nav-link {
        color: rgba(255, 255, 255, 0.7) !important;
        padding-left: 2rem;
    }

    .nav-treeview > .nav-item > .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.08) !important;
        color: #fff !important;
    }

    .nav-treeview > .nav-item > .nav-link.active {
        background-color: rgba(255, 255, 255, 0.15) !important;
        color: #fff !important;
    } */

    /* ========================================== */
    /* BOTONES PRIMARIOS */
    /* ========================================== */
    .btn-primary {
        background-color: var(--admin-primary) !important;
        border-color: var(--admin-primary) !important;
        color: #fff !important;
    }

    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active {
        background-color: var(--admin-primary-dark) !important;
        border-color: var(--admin-primary-dark) !important;
        box-shadow: 0 4px 12px rgba({{ hexToRgb(color('primary')) }}, 0.3);
    }

    .btn-outline-primary {
        color: var(--admin-primary) !important;
        border-color: var(--admin-primary) !important;
    }

    .btn-outline-primary:hover,
    .btn-outline-primary:focus,
    .btn-outline-primary:active {
        background-color: var(--admin-primary) !important;
        border-color: var(--admin-primary) !important;
        color: #fff !important;
    }

    /* ========================================== */
    /* ENLACES Y TEXTOS */
    /* ========================================== */
    a {
        color: var(--admin-primary);
    }

    a:hover {
        color: var(--admin-primary-dark);
    }

    .text-primary {
        color: var(--admin-primary) !important;
    }

    /* ========================================== */
    /* BADGES */
    /* ========================================== */
    .badge-primary {
        background-color: var(--admin-primary) !important;
    }

    /* ========================================== */
    /* CARDS */
    /* ========================================== */
    .card-primary:not(.card-outline) > .card-header {
        background-color: var(--admin-primary) !important;
        border-color: var(--admin-primary) !important;
    }

    .card-primary.card-outline {
        border-top: 3px solid var(--admin-primary) !important;
    }

    .card-primary.card-outline > .card-header {
        border-bottom: 1px solid var(--admin-primary) !important;
    }

    /* ========================================== */
    /* PAGINACIÓN */
    /* ========================================== */
    .page-item.active .page-link {
        background-color: var(--admin-primary) !important;
        border-color: var(--admin-primary) !important;
    }

    .page-link {
        color: var(--admin-primary) !important;
    }

    .page-link:hover {
        color: var(--admin-primary-dark) !important;
        background-color: rgba({{ hexToRgb(color('primary')) }}, 0.1);
    }

    /* ========================================== */
    /* FORMS - CHECKBOXES Y RADIOS */
    /* ========================================== */
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: var(--admin-primary) !important;
        border-color: var(--admin-primary) !important;
    }

    .form-control:focus {
        border-color: var(--admin-primary) !important;
        box-shadow: 0 0 0 0.2rem rgba({{ hexToRgb(color('primary')) }}, 0.25) !important;
    }

    /* ========================================== */
    /* SELECT2 */
    /* ========================================== */
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: var(--admin-primary) !important;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--multiple:focus {
        border-color: var(--admin-primary) !important;
    }

    /* ========================================== */
    /* PROGRESS BARS */
    /* ========================================== */
    .progress-bar {
        background-color: var(--admin-primary) !important;
    }

    /* ========================================== */
    /* ALERTS */
    /* ========================================== */
    .alert-primary {
        background-color: rgba({{ hexToRgb(color('primary')) }}, 0.1) !important;
        border-color: var(--admin-primary) !important;
        color: var(--admin-primary-dark) !important;
    }

    /* ========================================== */
    /* TABS */
    /* ========================================== */
    .nav-tabs .nav-link.active {
        border-top-color: var(--admin-primary) !important;
        border-top-width: 3px !important;
        color: var(--admin-primary) !important;
    }

    .nav-tabs .nav-link:hover {
        border-top-color: var(--admin-primary-light) !important;
    }

    /* ========================================== */
    /* BREADCRUMB */
    /* ========================================== */
    .breadcrumb-item.active {
        color: var(--admin-primary) !important;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: var(--admin-primary) !important;
    }

    /* ========================================== */
    /* FOOTER */
    /* ========================================== */
    .main-footer {
        border-top: 2px solid var(--admin-primary);
    }

    /* ========================================== */
    /* DATATABLES */
    /* ========================================== */
    table.dataTable thead th {
        border-bottom: 2px solid var(--admin-primary) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--admin-primary) !important;
        border-color: var(--admin-primary) !important;
        color: #fff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--admin-primary-light) !important;
        border-color: var(--admin-primary-light) !important;
        color: #fff !important;
    }

    /* ========================================== */
    /* LOADING SPINNER */
    /* ========================================== */
    .spinner-border-primary {
        color: var(--admin-primary) !important;
    }

    /* ========================================== */
    /* CUSTOM SWITCHES */
    /* ========================================== */
    .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
        background-color: var(--admin-primary) !important;
        border-color: var(--admin-primary) !important;
    }

    /* ========================================== */
    /* TOAST NOTIFICATIONS */
    /* ========================================== */
    .toast-header {
        background-color: var(--admin-primary) !important;
        color: #fff !important;
    }

    /* ========================================== */
    /* RESPONSIVE */
    /* ========================================== */
    @media (max-width: 767.98px) {
        .main-sidebar {
            box-shadow: 0 0 15px rgba({{ hexToRgb(color('primary')) }}, 0.3);
        }
    }
</style>
@endpush