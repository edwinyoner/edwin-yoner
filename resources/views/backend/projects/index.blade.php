@extends('layouts.main')

@section('subtitle', 'Proyectos')
@section('content_header_title', 'Proyectos')
@section('content_header_subtitle', 'Gestión de proyectos del portafolio')

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_body')
<div class="container-fluid">

    {{-- ============================================ --}}
    {{-- CABECERA --}}
    {{-- ============================================ --}}
    <div class="card-header text-white text-center py-3 mb-4"
        style="background: linear-gradient(135deg, {{ color('primary') }}, {{ color('secondary') }});">
        <h2 class="mb-0">GESTIÓN DE PROYECTOS</h2>
        <div class="mt-2">
            <span class="ml-2">
                <i class="fas fa-project-diagram mr-1"></i> Proyectos
            </span>
            <span class="badge badge-light text-dark">
                {{ $projects->count() }} proyectos
            </span>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- ALERTAS --}}
    {{-- ============================================ --}}
    @if(session('success'))
        <x-adminlte-alert theme="success" id="success-alert" title="Éxito" dismissable>
            {{ session('success') }}
        </x-adminlte-alert>
    @elseif(session('error'))
        <x-adminlte-alert theme="danger" id="error-alert" title="Error" dismissable>
            {{ session('error') }}
        </x-adminlte-alert>
    @endif

    {{-- ============================================ --}}
    {{-- CONTENIDO PRINCIPAL --}}
    {{-- ============================================ --}}
    <div class="row">
        <div class="col-12">

            <div class="mb-3 text-right">
                <a href="{{ route('backend.projects.create') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus mr-1"></i> Nuevo Proyecto
                </a>
            </div>

            <x-adminlte-card theme="primary" title="Proyectos Registrados" icon="fas fa-project-diagram">

                @php
                    $heads = [
                        ['label' => 'ID', 'width' => 4],
                        ['label' => 'Thumbnail', 'width' => 8],
                        ['label' => 'Título', 'width' => 22],
                        ['label' => 'Año', 'width' => 6],
                        ['label' => 'Tecnologías', 'width' => 8],
                        ['label' => 'Galería', 'width' => 7],
                        ['label' => 'Links', 'width' => 10],
                        ['label' => 'Estado', 'width' => 8],
                        ['label' => 'Acciones', 'no-export' => true, 'width' => 15],
                    ];

                    $config = [
                        'language' => ['url' => asset('/assets/js/es-ES.json')],
                        'responsive' => true,
                        'autoWidth' => false,
                        'paging' => true,
                        'searching' => true,
                        'ordering' => true,
                        'pageLength' => 10,
                    ];
                @endphp

                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" striped hoverable bordered sm>
                    @foreach($projects as $project)
                        <tr>
                            {{-- ID --}}
                            <td>{{ $project->id }}</td>

                            {{-- Thumbnail --}}
                            <td class="text-center">
                                @if($project->thumbnail_image)
                                    <img src="{{ asset('storage/' . $project->thumbnail_image) }}" alt="{{ $project->title }}"
                                        style="width:50px; height:40px;
                                                        object-fit:cover; border-radius:4px;">
                                @else
                                    <div class="bg-light d-flex align-items-center
                                                        justify-content-center" style="width:50px; height:40px;
                                                        border-radius:4px; margin:0 auto;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>

                            {{-- Título --}}
                            <td>
                                <strong>{{ Str::limit($project->title, 40) }}</strong>
                                @if($project->short_description)
                                    <br>
                                    <small class="text-muted">
                                        {{ Str::limit($project->short_description, 60) }}
                                    </small>
                                @endif
                            </td>

                            {{-- Año --}}
                            <td class="text-center">
                                <span class="badge badge-secondary">
                                    {{ $project->year ?? '—' }}
                                </span>
                            </td>

                            {{-- Tecnologías --}}
                            <td class="text-center">
                                <span class="badge badge-info"
                                    title="{{ $project->technologies->pluck('name')->join(', ') }}">
                                    {{ $project->technologies_count }}
                                    <i class="fas fa-code ml-1"></i>
                                </span>
                            </td>

                            {{-- Galería --}}
                            <td class="text-center">
                                <a href="{{ route('backend.projects.show', $project->id) }}" class="badge badge-secondary"
                                    title="Ver galería">
                                    {{ $project->galleries_count }}
                                    <i class="fas fa-images ml-1"></i>
                                </a>
                            </td>

                            {{-- Links --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center" style="gap:.25rem;">
                                    @if($project->project_url)
                                        <a href="{{ $project->project_url }}" target="_blank"
                                            class="btn btn-xs btn-outline-success" title="Ver proyecto online"
                                            style="padding:2px 6px;">
                                            <i class="fas fa-globe"></i>
                                        </a>
                                    @endif
                                    @if($project->repository_url)
                                        @php
                                            $repoUrl = $project->repository_url;
                                            $repoIcon = str_contains($repoUrl, 'github.com')
                                                ? 'fab fa-github'
                                                : (str_contains($repoUrl, 'gitlab.com')
                                                    ? 'fab fa-gitlab'
                                                    : (str_contains($repoUrl, 'bitbucket.org')
                                                        ? 'fab fa-bitbucket'
                                                        : 'fab fa-git-alt')); // POR DEFECTO: Ícono genérico de Git

                                        @endphp
                                        <a href="{{ $repoUrl }}" target="_blank" class="btn btn-xs btn-outline-dark"
                                            title="Ver repositorio" style="padding:2px 6px;">
                                            <i class="{{ $repoIcon }}"></i>
                                        </a>
                                    @endif
                                    @if($project->video_url)
                                        <a href="{{ $project->video_url }}" target="_blank"
                                            class="btn btn-xs btn-outline-danger" title="Ver video demo"
                                            style="padding:2px 6px;">
                                            <i class="fab fa-youtube"></i>
                                        </a>
                                    @endif
                                    @if(!$project->project_url && !$project->repository_url && !$project->video_url)
                                        <span class="text-muted small">—</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Estado --}}
                            <td class="text-center">
                                <span class="badge badge-{{ $project->status_color }}">
                                    {{ $project->status_badge }}
                                </span>
                            </td>

                            {{-- Acciones --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center">

                                    {{-- Ver --}}
                                    <a href="{{ route('backend.projects.show', $project->id) }}"
                                        class="btn btn-sm btn-outline-info shadow-sm mx-1" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Editar --}}
                                    <a href="{{ route('backend.projects.edit', $project->id) }}"
                                        class="btn btn-sm btn-outline-primary shadow-sm mx-1" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Eliminar --}}
                                    <form id="deleteForm{{ $project->id }}" class="d-inline" method="POST"
                                        action="{{ route('backend.projects.destroy', $project->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger shadow-sm mx-1"
                                            title="Eliminar"
                                            onclick="confirmDelete({{ $project->id }}, '{{ addslashes($project->title) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>

            </x-adminlte-card>

            <div class="mt-3">
                <a href="{{ route('backend.dashboard') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Dashboard
                </a>
            </div>

        </div>
    </div>
</div>
@stop

@push('css')
    <style>
        #success-alert,
        #error-alert {
            transition: opacity 0.5s ease;
        }

        #table1 tbody tr:hover {
            background-color: rgba({{ hexToRgb(color('primary')) }}, 0.05) !important;
        }

        .badge-light {
            background-color: white !important;
            color:
                {{ color('text_dark') }}
                !important;
            font-weight: 600;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');

            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.style.display = 'none', 500);
                }, 3000);
            }

            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.style.opacity = '0';
                    setTimeout(() => errorAlert.style.display = 'none', 500);
                }, 5000);
            }
        });

        // ============================================
        // CONFIRM DELETE
        // ============================================
        function confirmDelete(id, title) {
            Swal.fire({
                title: '¿Eliminar proyecto?',
                html: `¿Estás seguro de eliminar <strong>"${title}"</strong>?<br>
                   <small class="text-muted">Se eliminarán también todas las imágenes de galería asociadas.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '{{ color("primary") }}',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Eliminando...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => Swal.showLoading(),
                    });
                    document.getElementById('deleteForm' + id).submit();
                }
            });
        }
    </script>
@endpush