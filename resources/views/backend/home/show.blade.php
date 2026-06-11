@extends('layouts.main')

@section('subtitle', 'Detalles de Home')
@section('content_header_title', 'Página Home')
@section('content_header_subtitle', 'Vista detallada de la configuración')

@section('content_body')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <x-adminlte-card title="Configuración Completa de Home" theme="info" icon="fas fa-home">

                <!-- Hero Section -->
                <h5 class="text-primary border-bottom pb-2"><i class="fas fa-image mr-2"></i>Hero Section</h5>
                <div class="mb-4 pl-3">
                    <div class="mb-3">
                        <strong>Título Principal:</strong>
                        <span class="text-muted">{{ $settings->hero_title }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Subtítulo:</strong>
                        <span class="text-muted">{{ $settings->hero_subtitle ?? 'No definido' }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Descripción:</strong>
                        <span class="text-muted">{{ $settings->hero_description ?? 'No definida' }}</span>
                    </div>
                    @if($settings->hero_image)
                        <div class="mb-3">
                            <strong>Imagen de Fondo:</strong><br>
                            <img src="{{ asset('storage/' . $settings->hero_image) }}" alt="Hero" class="img-thumbnail mt-2" style="max-width: 400px;">
                        </div>
                    @endif
                    @if($settings->hero_vehicle_image)
                        <div class="mb-3">
                            <strong>Imagen del Vehículo:</strong><br>
                            <img src="{{ asset('storage/' . $settings->hero_vehicle_image) }}" alt="Vehicle" class="img-thumbnail mt-2" style="max-width: 300px;">
                        </div>
                    @endif
                </div>

                <hr>

                <!-- About Preview -->
                <h5 class="text-primary border-bottom pb-2"><i class="fas fa-info-circle mr-2"></i>Sección About</h5>
                <div class="mb-4 pl-3">
                    <div class="mb-3">
                        <strong>Título:</strong>
                        <span class="text-muted">{{ $settings->about_section_title }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Texto:</strong>
                        <p class="text-muted">{{ $settings->about_section_text }}</p>
                    </div>
                    @if($settings->about_section_image)
                        <div class="mb-3">
                            <strong>Imagen:</strong><br>
                            <img src="{{ asset('storage/' . $settings->about_section_image) }}" alt="About" class="img-thumbnail mt-2" style="max-width: 300px;">
                        </div>
                    @endif
                </div>

                <hr>

                <!-- Section Titles -->
                <h5 class="text-primary border-bottom pb-2"><i class="fas fa-heading mr-2"></i>Títulos de Secciones</h5>
                <div class="mb-4 pl-3">
                    <div class="mb-3">
                        <strong>Título de Servicios:</strong>
                        <span class="text-muted">{{ $settings->services_section_title }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Título de Clientes:</strong>
                        <span class="text-muted">{{ $settings->partners_section_title }}</span>
                    </div>
                </div>

                <hr>

                <!-- CTA Section -->
                <h5 class="text-primary border-bottom pb-2"><i class="fas fa-bullhorn mr-2"></i>Call to Action</h5>
                <div class="mb-4 pl-3">
                    <div class="mb-3">
                        <strong>Título:</strong>
                        <span class="text-muted">{{ $settings->cta_title }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Descripción:</strong>
                        <span class="text-muted">{{ $settings->cta_description ?? 'No definida' }}</span>
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
                <h5 class="text-primary border-bottom pb-2"><i class="fas fa-search mr-2"></i>SEO</h5>
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
                    <a href="{{ route('backend.home.index') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <a href="{{ route('backend.home.edit') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>

            </x-adminlte-card>
        </div>
    </div>
</div>
@stop