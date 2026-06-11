@extends('layouts.main')

@section('subtitle', 'Perfil Personal')
@section('content_header_title', 'Perfil')
@section('content_header_subtitle', 'Vista general del perfil personal')

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
        <h2 class="mb-0">PERFIL PERSONAL</h2>
        <div class="mt-2">
            <span class="ml-2">
                <i class="fas fa-user mr-1"></i> Información Personal &nbsp;|&nbsp;
                <i class="fas fa-align-left mr-1"></i> Biografía &nbsp;|&nbsp;
                <i class="fas fa-map-marker-alt mr-1"></i> Ubicación
            </span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" icon="fas fa-user" title="Configuración Actual del Perfil">

                <div class="row align-items-start">

                    {{-- ============================================ --}}
                    {{-- DATOS PRINCIPALES --}}
                    {{-- ============================================ --}}
                    <div class="col-md-8">

                        {{-- INFORMACIÓN PERSONAL --}}
                        <h6 class="text-muted text-uppercase font-weight-bold mb-2">
                            <i class="fas fa-id-card mr-1"></i> Información Personal
                        </h6>
                        <p class="mb-1">
                            <strong>Nombre Completo:</strong>
                            {{ $profile->full_name ?? '—' }}
                        </p>
                        <p class="mb-1">
                            <strong>Título Profesional:</strong>
                            {{ $profile->professional_title ?? '—' }}
                        </p>
                        <p class="mb-1">
                            <strong>Ubicación:</strong>
                            {{ $profile->full_location ?? '—' }}
                        </p>

                        <hr>

                        {{-- BIOGRAFÍA --}}
                        <h6 class="text-muted text-uppercase font-weight-bold mb-2">
                            <i class="fas fa-align-left mr-1"></i> Biografía
                        </h6>
                        <p class="mb-1">
                            <strong>Descripción Corta:</strong><br>
                            <span class="text-muted">
                                {{ $profile->bio_short ?? '—' }}
                            </span>
                        </p>

                        @if($profile->bio_long)
                            <p class="mb-1 mt-2">
                                <strong>Biografía Extendida:</strong><br>
                                <span class="text-muted">
                                    {{ Str::limit($profile->bio_long, 200) }}
                                </span>
                            </p>
                        @endif

                    </div>

                    {{-- ============================================ --}}
                    {{-- FOTO DE PERFIL --}}
                    {{-- ============================================ --}}
                    <div class="col-md-4 text-center">
                        <p class="text-muted text-uppercase font-weight-bold mb-2">
                            <small>Foto de Perfil</small>
                        </p>
                        @if($profile->profile_image)
                            <img src="{{ asset('storage/' . $profile->profile_image) }}"
                                 alt="{{ $profile->full_name }}"
                                 class="img-fluid rounded-circle shadow"
                                 style="width:160px; height:160px; object-fit:cover;
                                        border:4px solid var(--admin-primary);">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center
                                        justify-content-center mx-auto"
                                 style="width:160px; height:160px;
                                        border:4px solid var(--admin-primary);">
                                <i class="fas fa-user fa-5x text-muted"></i>
                            </div>
                        @endif
                        <small class="text-muted d-block mt-2">
                            {{ $profile->profile_image ? 'Foto cargada' : 'Sin foto' }}
                        </small>
                    </div>

                </div>

                {{-- ============================================ --}}
                {{-- BOTONES --}}
                {{-- ============================================ --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('backend.dashboard') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('backend.profile-settings.edit') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit mr-1"></i> Editar Perfil
                    </a>
                </div>

            </x-adminlte-card>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- ESTADÍSTICAS --}}
    {{-- ============================================ --}}
    <div class="row mt-4">

        {{-- Foto de perfil --}}
        <div class="col-md-4">
            <div class="small-box {{ $profile->profile_image ? 'bg-success' : 'bg-warning' }}">
                <div class="inner">
                    <h3><i class="fas fa-{{ $profile->profile_image ? 'check' : 'times' }}"></i></h3>
                    <p>Foto de Perfil</p>
                </div>
                <div class="icon">
                    <i class="fas fa-camera"></i>
                </div>
                <a href="{{ route('backend.profile-settings.edit') }}" class="small-box-footer">
                    {{ $profile->profile_image ? 'Cambiar foto' : 'Agregar foto' }}
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- Biografía --}}
        <div class="col-md-4">
            <div class="small-box {{ $profile->bio_short ? 'bg-success' : 'bg-warning' }}">
                <div class="inner">
                    <h3><i class="fas fa-{{ $profile->bio_short ? 'check' : 'times' }}"></i></h3>
                    <p>Descripción Corta</p>
                </div>
                <div class="icon">
                    <i class="fas fa-align-left"></i>
                </div>
                <a href="{{ route('backend.profile-settings.edit') }}" class="small-box-footer">
                    {{ $profile->bio_short ? 'Actualizar' : 'Agregar descripción' }}
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- Ver portafolio público --}}
        <div class="col-md-4">
            <div class="small-box bg-info">
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