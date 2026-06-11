@extends('layouts.main')

@section('subtitle', 'Detalle de Tecnología')
@section('content_header_title', 'Tecnologías')
@section('content_header_subtitle', 'Detalle de tecnología')

@section('content_body')
<div class="container-fluid">
    <div class="row justify-content-center">

        {{-- ============================================ --}}
        {{-- COLUMNA IZQUIERDA: INFORMACIÓN --}}
        {{-- ============================================ --}}
        <div class="col-md-5">
            <x-adminlte-card title="Información de la Tecnología"
                             theme="info" icon="fas fa-code">

                {{-- Icono grande --}}
                <div class="text-center mb-4">
                    @if($technology->icon_path)
                        <img src="{{ asset('storage/' . $technology->icon_path) }}"
                             alt="{{ $technology->name }}"
                             style="width:80px; height:80px; object-fit:contain;">
                    @elseif($technology->icon_class)
                        <i class="{{ $technology->icon_class }}"
                           style="font-size:80px; color:{{ $technology->color_with_fallback }};"></i>
                    @elseif($technology->slug)
                        <img src="https://cdn.simpleicons.org/{{ $technology->slug }}/{{ ltrim($technology->color_with_fallback, '#') }}"
                             alt="{{ $technology->name }}"
                             style="width:80px; height:80px; object-fit:contain;"
                             onerror="this.outerHTML='<span class=\'badge badge-secondary\' style=\'font-size:2rem;padding:.75rem 1.25rem;\'>{{ strtoupper(substr($technology->name, 0, 2)) }}</span>'">
                    @else
                        <span class="badge badge-secondary"
                              style="font-size:2rem; padding:.75rem 1.25rem;">
                            {{ strtoupper(substr($technology->name, 0, 2)) }}
                        </span>
                    @endif

                    <h4 class="mt-3 font-weight-bold">{{ $technology->name }}</h4>
                    <span class="badge badge-secondary">
                        {{ $technology->category->name ?? '—' }}
                    </span>
                </div>

                <hr>

                <div class="mb-2">
                    <strong>ID:</strong>
                    <span class="text-muted">{{ $technology->id }}</span>
                </div>

                <div class="mb-2">
                    <strong>Slug:</strong>
                    <code>{{ $technology->slug }}</code>
                </div>

                @if($technology->icon_class)
                    <div class="mb-2">
                        <strong>Icono (clase):</strong>
                        <code>{{ $technology->icon_class }}</code>
                    </div>
                @endif

                @if($technology->icon_path)
                    <div class="mb-2">
                        <strong>Icono (archivo):</strong>
                        <code>{{ $technology->icon_path }}</code>
                    </div>
                @endif

                <div class="mb-2">
                    <strong>Color:</strong>
                    <span class="badge"
                          style="background-color: {{ $technology->color_with_fallback }};
                                 color:white; padding:5px 12px;">
                        {{ $technology->color_with_fallback }}
                    </span>
                </div>

                <div class="mb-2">
                    <strong>Estado:</strong>
                    <span class="badge badge-{{ $technology->status_color }}">
                        {{ $technology->status_badge }}
                    </span>
                </div>

                <div class="mb-2">
                    <strong>Creada:</strong>
                    <span class="text-muted">
                        {{ $technology->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>

                <div class="mb-2">
                    <strong>Actualizada:</strong>
                    <span class="text-muted">
                        {{ $technology->updated_at->format('d/m/Y H:i') }}
                    </span>
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('backend.technologies.index') }}"
                       class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Volver
                    </a>
                    <a href="{{ route('backend.technologies.edit', $technology->id) }}"
                       class="btn btn-sm btn-primary">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>
                </div>

            </x-adminlte-card>
        </div>

        {{-- ============================================ --}}
        {{-- COLUMNA DERECHA: NIVEL Y PROYECTOS --}}
        {{-- ============================================ --}}
        <div class="col-md-7">

            {{-- Card nivel de dominio --}}
            <x-adminlte-card title="Nivel de Dominio" theme="primary" icon="fas fa-chart-bar">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge badge-{{ $technology->proficiency_color }} px-3 py-2"
                          style="font-size:.9rem;">
                        {{ $technology->proficiency_label }}
                    </span>
                    <strong style="font-size:1.5rem; color:{{ $technology->color_with_fallback }};">
                        {{ $technology->proficiency_percentage }}%
                    </strong>
                </div>

                <div class="progress" style="height:14px; border-radius:8px;">
                    <div class="progress-bar"
                         style="width:{{ $technology->proficiency_percentage }}%;
                                background-color: {{ $technology->color_with_fallback }};
                                border-radius:8px;
                                box-shadow: 0 0 8px {{ $technology->color_with_fallback }};">
                    </div>
                </div>

                <div class="row mt-3 text-center">
                    @foreach([
                        'basico'     => ['label' => 'Básico',     'color' => 'info',    'range' => '1–33%'],
                        'intermedio' => ['label' => 'Intermedio', 'color' => 'primary', 'range' => '34–66%'],
                        'avanzado'   => ['label' => 'Avanzado',   'color' => 'warning', 'range' => '67–100%'],
                    ] as $value => $item)
                        <div class="col-3">
                            <span class="badge badge-{{ $item['color'] }}
                                {{ $technology->proficiency_level === $value ? '' : 'opacity-50' }}"
                                  style="{{ $technology->proficiency_level !== $value ? 'opacity:.4;' : '' }}">
                                {{ $item['label'] }}
                            </span>
                            <small class="d-block text-muted">{{ $item['range'] }}</small>
                        </div>
                    @endforeach
                </div>

            </x-adminlte-card>

            {{-- Card proyectos asociados --}}
            <x-adminlte-card theme="success" icon="fas fa-project-diagram">

                <x-slot name="title">
                    Proyectos Asociados
                    <span class="badge badge-success ml-2">
                        {{ $technology->projects->count() }}
                    </span>
                </x-slot>

                @if($technology->projects->isEmpty())
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p class="mb-0">Esta tecnología no está en ningún proyecto aún.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Proyecto</th>
                                    <th class="text-center">Año</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($technology->projects as $project)
                                    <tr>
                                        <td>
                                            <strong>{{ Str::limit($project->title, 35) }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-secondary">
                                                {{ $project->year ?? '—' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $project->is_active ? 'success' : 'danger' }}">
                                                {{ $project->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('backend.projects.show', $project->id) }}"
                                               class="btn btn-sm btn-outline-info"
                                               title="Ver proyecto">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </x-adminlte-card>

        </div>

    </div>
</div>
@stop