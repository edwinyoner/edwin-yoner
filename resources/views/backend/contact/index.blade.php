@extends('layouts.main')

@section('subtitle', 'Configuración de Contact')
@section('content_header_title', 'Página Contact')
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
    <div class="card-header bg-gradient-info text-white text-center py-3 mb-4">
        <h2 class="mb-0">CONFIGURACIÓN DE CONTACT</h2>
        <div class="mt-2">
            <span class="ml-2"><i class="fas fa-phone-alt mr-1"></i> Página de Contacto</span>
        </div>
    </div>

    <div class="row">
        <!-- Card de resumen -->
        <div class="col-md-12">
            <x-adminlte-card theme="info" icon="fas fa-phone-alt" title="Configuración Actual">
                
                <!-- Hero Section -->
                <div class="mb-4">
                    <h5 class="text-info"><i class="fas fa-image mr-2"></i>Hero Section</h5>
                    <div class="pl-3">
                        <p><strong>Título:</strong> {{ $settings->hero_title }}</p>
                        <p><strong>Subtítulo:</strong> {{ $settings->hero_subtitle ?? 'No definido' }}</p>
                    </div>
                </div>

                <hr>

                <!-- Offices Section -->
                <div class="mb-4">
                    <h5 class="text-info"><i class="fas fa-building mr-2"></i>Sección de Oficinas</h5>
                    <div class="pl-3">
                        <p><strong>Título:</strong> {{ $settings->offices_section_title }}</p>
                    </div>
                </div>

                <hr>

                <!-- Form Section -->
                <div class="mb-4">
                    <h5 class="text-info"><i class="fas fa-envelope mr-2"></i>Sección de Formulario</h5>
                    <div class="pl-3">
                        <p><strong>Título:</strong> {{ $settings->form_section_title }}</p>
                    </div>
                </div>

                <hr>

                <!-- CTA -->
                <div class="mb-4">
                    <h5 class="text-info"><i class="fas fa-bullhorn mr-2"></i>Call to Action</h5>
                    <div class="pl-3">
                        <p><strong>Título:</strong> {{ $settings->cta_title }}</p>
                        <p><strong>Botón:</strong> {{ $settings->cta_button_text }}</p>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('backend.dashboard') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Dashboard
                    </a>
                    
                    <div>
                        <a href="{{ route('backend.contact.show') }}" class="btn btn-info btn-sm mr-2">
                            <i class="fas fa-eye mr-1"></i> Ver Detalles
                        </a>
                        <a href="{{ route('backend.contact.edit') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit mr-1"></i> Editar
                        </a>
                    </div>
                </div>

            </x-adminlte-card>
        </div>
    </div>

    <!-- Cards de estadísticas -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\ContactSubmission::unread()->count() }}</h3>
                    <p>Mensajes Sin Leer</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <a href="{{ route('backend.contact_submissions.index') }}" class="small-box-footer">
                    Ver más <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ \App\Models\Headquarter::active()->count() }}</h3>
                    <p>Sedes Activas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="{{ route('backend.headquarter.index') }}" class="small-box-footer">
                    Ver más <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \App\Models\SocialLink::active()->count() }}</h3>
                    <p>Redes Sociales</p>
                </div>
                <div class="icon">
                    <i class="fas fa-share-alt"></i>
                </div>
                <a href="{{ route('backend.social_link.index') }}" class="small-box-footer">
                    Ver más <i class="fas fa-arrow-circle-right"></i>
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