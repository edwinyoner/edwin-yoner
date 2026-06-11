@extends('layouts.main')

@section('subtitle', 'Detalle de Categoría')
@section('content_header_title', 'Tecnologías')
@section('content_header_subtitle', 'Detalle de categoría de tecnologías')

@section('content_body')
<div class="container-fluid">
    <div class="row justify-content-center">

        {{-- ============================================ --}}
        {{-- COLUMNA IZQUIERDA: INFORMACIÓN --}}
        {{-- ============================================ --}}
        <div class="col-md-5">
            <x-adminlte-card title="Información de la Categoría"
                             theme="info" icon="fas fa-folder">

                {{-- Icono grande --}}
                <div class="text-center mb-4">
                    <i class="{{ $technologyCategory->icon_with_fallback }} fa-5x"
                       style="color: {{ $technologyCategory->color_with_fallback }};"></i>
                    <h4 class="mt-3 font-weight-bold">{{ $technologyCategory->name }}</h4>
                    @if($technologyCategory->name_en)
                        <small class="text-muted">{{ $technologyCategory->name_en }}</small>
                    @endif
                </div>

                <hr>

                <div class="mb-2">
                    <strong>ID:</strong>
                    <span class="text-muted">{{ $technologyCategory->id }}</span>
                </div>

                <div class="mb-2">
                    <strong>Slug:</strong>
                    <code>{{ $technologyCategory->slug }}</code>
                </div>

                <div class="mb-2">
                    <strong>Icono:</strong>
                    <code>{{ $technologyCategory->icon_with_fallback }}</code>
                </div>

                <div class="mb-2">
                    <strong>Color:</strong>
                    <span class="badge"
                          style="background-color: {{ $technologyCategory->color_with_fallback }};
                                 color: white; padding: 6px 12px;">
                        {{ $technologyCategory->color_with_fallback }}
                    </span>
                </div>

                <div class="mb-2">
                    <strong>Estado:</strong>
                    <span class="badge badge-{{ $technologyCategory->status_color }}">
                        {{ $technologyCategory->status_badge }}
                    </span>
                </div>

                @if($technologyCategory->description)
                    <div class="mb-2">
                        <strong>Descripción:</strong>
                        <p class="text-muted mb-0 mt-1">{{ $technologyCategory->description }}</p>
                    </div>
                @endif

                <div class="mb-2">
                    <strong>Creada:</strong>
                    <span class="text-muted">
                        {{ $technologyCategory->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>

                <div class="mb-2">
                    <strong>Actualizada:</strong>
                    <span class="text-muted">
                        {{ $technologyCategory->updated_at->format('d/m/Y H:i') }}
                    </span>
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('backend.technology-categories.index') }}"
                       class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Volver
                    </a>
                    <a href="{{ route('backend.technology-categories.edit', $technologyCategory->id) }}"
                       class="btn btn-sm btn-primary">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>
                </div>

            </x-adminlte-card>
        </div>

        {{-- ============================================ --}}
        {{-- COLUMNA DERECHA: TECNOLOGÍAS ASOCIADAS --}}
        {{-- ============================================ --}}
        <div class="col-md-7">
            <x-adminlte-card icon="fas fa-code" theme="primary">

                <x-slot name="title">
                    Tecnologías Asociadas
                    <span class="badge badge-primary ml-2">
                        {{ $technologyCategory->technologies->count() }}
                    </span>
                </x-slot>

                @if($technologyCategory->technologies->isEmpty())
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>No hay tecnologías en esta categoría.</p>
                        <a href="{{ route('backend.technologies.create') }}"
                           class="btn btn-sm btn-success">
                            <i class="fas fa-plus mr-1"></i> Agregar tecnología
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Icono</th>
                                    <th>Nombre</th>
                                    <th>Nivel</th>
                                    <th class="text-center">%</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($technologyCategory->technologies as $tech)
                                    <tr>
                                        {{-- Icono --}}
                                        <td class="text-center" style="width:50px;">
                                            @if($tech->icon_path)
                                                <img src="{{ asset('storage/' . $tech->icon_path) }}"
                                                     alt="{{ $tech->name }}"
                                                     style="width:24px; height:24px; object-fit:contain;">
                                            @elseif(!$tech->icon_class && $tech->slug)
                                                <img src="https://cdn.simpleicons.org/{{ $tech->slug }}/{{ ltrim($tech->color ?? 'd4af37', '#') }}"
                                                     alt="{{ $tech->name }}"
                                                     style="width:24px; height:24px; object-fit:contain;">
                                            @elseif($tech->icon_class)
                                                <i class="{{ $tech->icon_class }}"
                                                   style="color: {{ $tech->color ?? 'var(--admin-primary)' }};
                                                          font-size:1.2rem;"></i>
                                            @else
                                                <span class="badge badge-secondary"
                                                      style="font-size:.7rem;">
                                                    {{ strtoupper(substr($tech->name, 0, 2)) }}
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Nombre --}}
                                        <td>
                                            <strong>{{ $tech->name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                <code>{{ $tech->slug }}</code>
                                            </small>
                                        </td>

                                        {{-- Nivel --}}
                                        <td>
                                            <span class="badge badge-secondary"
                                                  style="font-size:.75rem;">
                                                {{ ucfirst($tech->proficiency_level) }}
                                            </span>
                                        </td>

                                        {{-- Porcentaje --}}
                                        <td class="text-center" style="width:80px;">
                                            <div class="progress" style="height:8px;">
                                                <div class="progress-bar"
                                                     style="width:{{ $tech->proficiency_percentage }}%;
                                                            background-color: {{ $tech->color ?? 'var(--admin-primary)' }};">
                                                </div>
                                            </div>
                                            <small class="text-muted">
                                                {{ $tech->proficiency_percentage }}%
                                            </small>
                                        </td>

                                        {{-- Estado --}}
                                        <td class="text-center">
                                            <span class="badge badge-{{ $tech->is_active ? 'success' : 'danger' }}">
                                                {{ $tech->is_active ? 'Activa' : 'Inactiva' }}
                                            </span>
                                        </td>

                                        {{-- Acción --}}
                                        <td class="text-center">
                                            <a href="{{ route('backend.technologies.edit', $tech->id) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Editar tecnología">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right mt-3">
                        <a href="{{ route('backend.technologies.create') }}"
                           class="btn btn-sm btn-success">
                            <i class="fas fa-plus mr-1"></i> Agregar tecnología
                        </a>
                    </div>
                @endif

            </x-adminlte-card>
        </div>

    </div>
</div>
@stop