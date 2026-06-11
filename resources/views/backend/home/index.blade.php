@extends('layouts.main')

@section('subtitle', 'Configuración de Home')
@section('content_header_title', 'Página Home')
@section('content_header_subtitle', 'Vista general de la configuración')

@section('content_body')
<div class="container-fluid">

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <x-adminlte-alert theme="success" id="success-alert" title="Éxito" dismissable>
            {{ session('success') }}
        </x-adminlte-alert>
    @endif

    {{-- Mensaje de error --}}
    @if (session('error'))
        <x-adminlte-alert theme="danger" id="error-alert" title="Error" dismissable>
            {{ session('error') }}
        </x-adminlte-alert>
    @endif

    <!-- Título -->
    <div class="card-header bg-gradient-primary text-white text-center py-3 mb-4">
        <h2 class="mb-0">CONFIGURACIÓN DE HOME</h2>
        <div class="mt-2">
            <span class="ml-2"><i class="fas fa-home mr-1"></i> Página Principal</span>
        </div>
    </div>

    <div class="row">
        <!-- Card de resumen -->
        <div class="col-md-12">
            <x-adminlte-card theme="primary" icon="fas fa-home" title="Configuración Actual">
                
                <!-- Hero Section -->
                <div class="mb-4">
                    <h5 class="text-primary"><i class="fas fa-image mr-2"></i>Hero Section</h5>
                    <div class="pl-3">
                        <p><strong>Título:</strong> {{ $settings->hero_title }}</p>
                        <p><strong>Subtítulo:</strong> {{ $settings->hero_subtitle ?? 'No definido' }}</p>
                        @if($settings->hero_image)
                            <div class="mb-2">
                                <strong>Imagen de fondo:</strong><br>
                                <img src="{{ asset('storage/' . $settings->hero_image) }}" alt="Hero Image" class="img-thumbnail" style="max-width: 300px;">
                            </div>
                        @endif
                    </div>
                </div>

                <hr>

                <!-- About Preview -->
                <div class="mb-4">
                    <h5 class="text-primary"><i class="fas fa-info-circle mr-2"></i>Sección About</h5>
                    <div class="pl-3">
                        <p><strong>Título:</strong> {{ $settings->about_section_title }}</p>
                        <p><strong>Texto:</strong> {{ Str::limit($settings->about_section_text, 150) }}</p>
                    </div>
                </div>

                <hr>

                <!-- SEO -->
                <div class="mb-4">
                    <h5 class="text-primary"><i class="fas fa-search mr-2"></i>SEO</h5>
                    <div class="pl-3">
                        <p><strong>Meta Title:</strong> {{ $settings->meta_title ?? 'No definido' }}</p>
                        <p><strong>Meta Description:</strong> {{ Str::limit($settings->meta_description, 100) ?? 'No definido' }}</p>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('backend.dashboard') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Dashboard
                    </a>
                    
                    <div>
                        <a href="{{ route('backend.home.show') }}" class="btn btn-info btn-sm mr-2">
                            <i class="fas fa-eye mr-1"></i> Ver Detalles
                        </a>
                        <a href="{{ route('backend.home.edit') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit mr-1"></i> Editar
                        </a>
                    </div>
                </div>

            </x-adminlte-card>
        </div>
    </div>

    <!-- Cards de estadísticas -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\HomeStat::count() }}</h3>
                    <p>Estadísticas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <a href="{{ route('backend.home_stats.index') }}" class="small-box-footer">
                    Ver más <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\HomeFeature::count() }}</h3>
                    <p>Características</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('backend.home_features.index') }}" class="small-box-footer">
                    Ver más <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \App\Models\Partner::count() }}</h3>
                    <p>Socios</p>
                </div>
                <div class="icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <a href="{{ route('backend.partners.index') }}" class="small-box-footer">
                    Ver más <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><i class="fas fa-globe"></i></h3>
                    <p>Vista Pública</p>
                </div>
                <div class="icon">
                    <i class="fas fa-eye"></i>
                </div>
                <a href="{{ route('frontend.home') }}" target="_blank" class="small-box-footer">
                    Ver sitio <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>
    </div>

</div>
@stop

@push('css')
<style>
    #success-alert, #error-alert {
        transition: opacity 0.5s ease;
    }
    #success-alert[style*="display: none"],
    #error-alert[style*="display: none"] {
        opacity: 0;
    }
</style>
@endpush

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 3000);
        }

        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.display = 'none';
            }, 5000);
        }
    });
</script>
@endpush