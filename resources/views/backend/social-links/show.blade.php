@extends('layouts.main')

@section('subtitle', 'Detalle de Red Social')
@section('content_header_title', 'Redes Sociales')
@section('content_header_subtitle', 'Detalles de la red social')

@section('content_body')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <x-adminlte-card title="Información de la Red Social" theme="info" icon="fas fa-share-alt">

                {{-- Icono grande centrado --}}
                <div class="text-center mb-4">
                    <i class="{{ $socialLink->icon_with_fallback }} fa-5x"
                       style="color: {{ $socialLink->color_with_fallback }};"></i>
                </div>

                <div class="mb-3">
                    <strong>ID:</strong>
                    <span class="text-muted">{{ $socialLink->id }}</span>
                </div>

                <div class="mb-3">
                    <strong>Nombre:</strong>
                    <span class="text-muted">{{ $socialLink->name }}</span>
                </div>

                <div class="mb-3">
                    <strong>Icono:</strong>
                    <code>{{ $socialLink->icon_with_fallback }}</code>
                </div>

                <div class="mb-3">
                    <strong>URL:</strong>
                    <a href="{{ $socialLink->url }}" target="_blank" class="text-primary">
                        {{ $socialLink->url }}
                        <i class="fas fa-external-link-alt ml-1"></i>
                    </a>
                </div>

                <div class="mb-3">
                    <strong>Dominio:</strong>
                    <span class="text-muted">{{ $socialLink->domain }}</span>
                </div>

                <div class="mb-3">
                    <strong>Color:</strong>
                    <span class="badge"
                          style="background-color: {{ $socialLink->color_with_fallback }};
                                 color: white; padding: 8px 15px;">
                        {{ $socialLink->color_with_fallback }}
                    </span>
                </div>

                <div class="mb-3">
                    <strong>Estado:</strong>
                    <span class="badge badge-{{ $socialLink->status_color }}">
                        {{ $socialLink->status_badge }}
                    </span>
                </div>

                {{-- Vista previa --}}
                <div class="mb-3">
                    <strong>Vista Previa:</strong>
                    <div class="card bg-light mt-2 p-4">
                        <div class="text-center">
                            <a href="{{ $socialLink->url }}"
                               target="_blank"
                               style="color: {{ $socialLink->color_with_fallback }};
                                      text-decoration: none;">
                                <i class="{{ $socialLink->icon_with_fallback }} fa-3x mb-2"></i>
                                <p class="mb-0 font-weight-bold">{{ $socialLink->name }}</p>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('backend.social-links.index') }}"
                       class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Volver
                    </a>
                    <a href="{{ route('backend.social-links.edit', $socialLink->id) }}"
                       class="btn btn-sm btn-primary">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>
                </div>

            </x-adminlte-card>
        </div>
    </div>
</div>
@stop