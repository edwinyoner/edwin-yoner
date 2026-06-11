@extends('layouts.main')

@section('subtitle', 'Detalles de Contact')
@section('content_header_title', 'Página Contact')
@section('content_header_subtitle', 'Vista detallada de la configuración')

@section('content_body')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <x-adminlte-card title="Configuración Completa de Contact" theme="info" icon="fas fa-phone-alt">

                <!-- Hero Section -->
                <h5 class="text-info border-bottom pb-2"><i class="fas fa-image mr-2"></i>Hero Section</h5>
                <div class="mb-4 pl-3">
                    <div class="mb-3">
                        <strong>Título:</strong>
                        <span class="text-muted">{{ $settings->hero_title }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Subtítulo:</strong>
                        <span class="text-muted">{{ $settings->hero_subtitle ?? 'No definido' }}</span>
                    </div>
                    @if($settings->hero_image)
                        <div class="mb-3">
                            <strong>Imagen:</strong><br>
                            <img src="{{ asset('storage/' . $settings->hero_image) }}" alt="Hero" class="img-thumbnail mt-2" style="max-width: 400px;">
                        </div>
                    @endif
                </div>

                <hr>

                <!-- Offices Section -->
                <h5 class="text-info border-bottom pb-2"><i class="fas fa-building mr-2"></i>Sección de Oficinas</h5>
                <div class="mb-4 pl-3">
                    <div class="mb-3">
                        <strong>Título:</strong>
                        <span class="text-muted">{{ $settings->offices_section_title }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Descripción:</strong>
                        <p class="text-muted">{{ $settings->offices_section_description ?? 'No definida' }}</p>
                    </div>
                </div>

                <hr>

                <!-- Form Section -->
                <h5 class="text-info border-bottom pb-2"><i class="fas fa-envelope mr-2"></i>Sección de Formulario</h5>
                <div class="mb-4 pl-3">
                    <div class="mb-3">
                        <strong>Título:</strong>
                        <span class="text-muted">{{ $settings->form_section_title }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Descripción:</strong>
                        <p class="text-muted">{{ $settings->form_section_description ?? 'No definida' }}</p>
                    </div>
                </div>

                <hr>

                <!-- CTA -->
                <h5 class="text-info border-bottom pb-2"><i class="fas fa-bullhorn mr-2"></i>Call to Action</h5>
                <div class="mb-4 pl-3">
                    <div class="mb-3">
                        <strong>Título:</strong>
                        <span class="text-muted">{{ $settings->cta_title }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Descripción:</strong>
                        <span class="text-muted">{{ $settings->cta_description ?? 'No definida' }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Botón:</strong>
                        <span class="text-muted">{{ $settings->cta_button_text }} → {{ $settings->cta_button_url }}</span>
                    </div>
                    @if($settings->cta_background_image)
                        <div class="mb-3">
                            <strong>Imagen de Fondo:</strong><br>
                            <img src="{{ asset('storage/' . $settings->cta_background_image) }}" alt="CTA" class="img-thumbnail mt-2" style="max-width: 300px;">
                        </div>
                    @endif
                </div>

                <hr>

                <!-- SEO -->
                <h5 class="text-info border-bottom pb-2"><i class="fas fa-search mr-2"></i>SEO</h5>
                <div class="mb-4 pl-3">
                    <div class="mb-3">
                        <strong>Meta Title:</strong>
                        <span class="text-muted">{{ $settings->meta_title ?? 'No definido' }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Meta Description:</strong>
                        <span class="text-muted">{{ $settings->meta_description ?? 'No definida' }}</span>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('backend.contact.index') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <a href="{{ route('backend.contact.edit') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>

            </x-adminlte-card>
        </div>
    </div>
</div>
@stop