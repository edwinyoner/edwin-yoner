@extends('layouts.main')

@section('subtitle', 'Configuración del Portafolio')
@section('content_header_title', 'Portafolio')
@section('content_header_subtitle', 'Vista general de la configuración')

@section('content_body')
<div class="container-fluid">

    {{-- ============================================ --}}
    {{-- ALERTAS --}}
    {{-- ============================================ --}}
    @if(session('success'))
        <x-adminlte-alert theme="success" id="success-alert" title="Éxito" dismissable>
            {{ session('success') }}
        </x-adminlte-alert>
    @endif

    @if(session('error'))
        <x-adminlte-alert theme="danger" id="error-alert" title="Error" dismissable>
            {{ session('error') }}
        </x-adminlte-alert>
    @endif

    {{-- ============================================ --}}
    {{-- CABECERA --}}
    {{-- ============================================ --}}
    <div class="card-header bg-gradient-primary text-white text-center py-3 mb-4">
        <h2 class="mb-0">CONFIGURACIÓN DEL PORTAFOLIO</h2>
        <div class="mt-2">
            <span class="ml-2">
                <i class="fas fa-palette mr-1"></i> Identidad Visual &nbsp;|&nbsp;
                <i class="fas fa-phone mr-1"></i> Contacto &nbsp;|&nbsp;
                <i class="fas fa-cogs mr-1"></i> Configuración del Sitio
            </span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" icon="fas fa-cogs" title="Configuración Actual">

                <div class="row align-items-center">

                    {{-- ============================================ --}}
                    {{-- DATOS PRINCIPALES --}}
                    {{-- ============================================ --}}
                    <div class="col-md-8">

                        {{-- COLORES --}}
                        <h6 class="text-muted text-uppercase font-weight-bold mb-2">
                            <i class="fas fa-palette mr-1"></i> Paleta de Colores
                        </h6>
                        <div class="d-flex flex-wrap mb-3" style="gap: .5rem;">
                            @foreach([
                                'Color Primario'    => $settings->primary_color,
                                'Color Secundario'  => $settings->secondary_color,
                                'Color Terciario'   => $settings->tertiary_color,
                                'Texto Oscuro'      => $settings->text_dark_color,
                                'Texto Claro'       => $settings->text_light_color,
                            ] as $label => $hex)
                                <div class="d-flex align-items-center">
                                    <span style="
                                        display:inline-block;
                                        width:24px; height:24px;
                                        background:{{ $hex }};
                                        border-radius:4px;
                                        border:1px solid #dee2e6;
                                        margin-right:5px;">
                                    </span>
                                    <small><strong>{{ $label }}:</strong> {{ $hex }}</small>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        {{-- CONTACTO --}}
                        <h6 class="text-muted text-uppercase font-weight-bold mb-2">
                            <i class="fas fa-address-card mr-1"></i> Contacto
                        </h6>
                        <p class="mb-1">
                            <strong>Email:</strong>
                            {{ $settings->email_contact ?? '—' }}
                        </p>
                        <p class="mb-1">
                            <strong>Teléfono:</strong>
                            {{ $settings->formatted_phone ?? '—' }}
                        </p>
                        <p class="mb-1">
                            <strong>WhatsApp:</strong>
                            {{ $settings->whatsapp_number ?? '—' }}
                        </p>

                        <hr>

                        {{-- CONFIGURACIÓN DEL SITIO --}}
                        <h6 class="text-muted text-uppercase font-weight-bold mb-2">
                            <i class="fas fa-cogs mr-1"></i> Configuración del Sitio
                        </h6>
                        <p class="mb-1">
                            <strong>Modo oscuro:</strong>
                            <span class="badge badge-{{ $settings->enable_dark_mode ? 'success' : 'secondary' }}">
                                {{ $settings->enable_dark_mode ? 'Habilitado' : 'Deshabilitado' }}
                            </span>
                        </p>
                        <p class="mb-1">
                            <strong>Multiidioma:</strong>
                            <span class="badge badge-{{ $settings->enable_multilang ? 'success' : 'secondary' }}">
                                {{ $settings->enable_multilang ? 'Habilitado' : 'Deshabilitado' }}
                            </span>
                        </p>
                        <p class="mb-1">
                            <strong>Idioma por defecto:</strong>
                            <span class="badge badge-info">
                                {{ strtoupper($settings->default_language) }}
                            </span>
                        </p>

                    </div>

                    {{-- ============================================ --}}
                    {{-- LOGO Y FAVICON --}}
                    {{-- ============================================ --}}
                    <div class="col-md-4 text-center">

                        {{-- Logo --}}
                        <p class="text-muted text-uppercase font-weight-bold mb-1">
                            <small>Logo</small>
                        </p>
                        @if($settings->logo_path)
                            <img src="{{ asset('storage/' . $settings->logo_path) }}"
                                 alt="Logo del portafolio"
                                 class="img-fluid rounded shadow mb-3"
                                 style="max-height:150px; object-fit:contain;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3"
                                 style="height:150px;">
                                <i class="fas fa-image fa-4x text-muted"></i>
                            </div>
                        @endif

                        {{-- Favicon --}}
                        <p class="text-muted text-uppercase font-weight-bold mb-1">
                            <small>Favicon</small>
                        </p>
                        @if($settings->favicon_path)
                            <img src="{{ asset('storage/' . $settings->favicon_path) }}"
                                 alt="Favicon"
                                 class="rounded shadow"
                                 style="width:48px; height:48px; object-fit:contain;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                 style="width:48px; height:48px; margin:0 auto;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- ============================================ --}}
                {{-- BOTONES --}}
                {{-- ============================================ --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('backend.dashboard') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('backend.portfolio-settings.edit') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit mr-1"></i> Editar Configuración
                    </a>
                </div>

            </x-adminlte-card>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- ESTADÍSTICAS --}}
    {{-- ============================================ --}}
    <div class="row mt-4">

        {{-- Porcentaje completado --}}
        <div class="col-md-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $settings->completion_percentage }}%</h3>
                    <p>Configuración Completa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('backend.portfolio-settings.edit') }}"
                   class="small-box-footer">
                    Completar <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- Imágenes cargadas --}}
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ ($settings->logo_path ? 1 : 0) + ($settings->favicon_path ? 1 : 0) }} / 2</h3>
                    <p>Imágenes Cargadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-images"></i>
                </div>
                <a href="{{ route('backend.portfolio-settings.edit') }}"
                   class="small-box-footer">
                    Gestionar <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- Ver sitio --}}
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><i class="fas fa-globe"></i></h3>
                    <p>Ver Portafolio Público</p>
                </div>
                <div class="icon">
                    <i class="fas fa-external-link-alt"></i>
                </div>
                <a href="{{ route('frontend.home') }}" target="_blank" class="small-box-footer">
                    Abrir sitio <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

    </div>

</div>
@stop

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) setTimeout(() => successAlert.style.display = 'none', 3000);

        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) setTimeout(() => errorAlert.style.display = 'none', 8000);
    });
</script>
@endpush