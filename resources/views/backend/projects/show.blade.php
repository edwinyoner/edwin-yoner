@extends('layouts.main')

@section('subtitle', 'Detalle de Proyecto')
@section('content_header_title', 'Proyectos')
@section('content_header_subtitle', 'Detalle del proyecto')

@section('plugins.Sweetalert2', true)

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

    <div class="row">

        {{-- ============================================ --}}
        {{-- COLUMNA IZQUIERDA: INFO PRINCIPAL --}}
        {{-- ============================================ --}}
        <div class="col-md-5">
            <x-adminlte-card title="Información del Proyecto"
                             theme="info" icon="fas fa-project-diagram">

                {{-- Thumbnail --}}
                <div class="text-center mb-3">
                    @if($project->thumbnail_image)
                        <img src="{{ asset('storage/' . $project->thumbnail_image) }}"
                             alt="{{ $project->title }}"
                             class="img-fluid rounded shadow"
                             style="max-height:220px; width:100%; object-fit:cover;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center
                                    justify-content-center"
                             style="height:180px;">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    @endif
                </div>

                <h5 class="font-weight-bold">{{ $project->title }}</h5>

                @if($project->short_description)
                    <p class="text-muted">{{ $project->short_description }}</p>
                @endif

                <hr>

                <div class="mb-2">
                    <strong>ID:</strong>
                    <span class="text-muted">{{ $project->id }}</span>
                </div>
                <div class="mb-2">
                    <strong>Slug:</strong>
                    <code>{{ $project->slug }}</code>
                </div>
                <div class="mb-2">
                    <strong>Año:</strong>
                    <span class="badge badge-secondary">{{ $project->year ?? '—' }}</span>
                </div>
                <div class="mb-2">
                    <strong>Estado:</strong>
                    <span class="badge badge-{{ $project->status_color }}">
                        {{ $project->status_badge }}
                    </span>
                </div>

                {{-- Links --}}
                @if($project->project_url || $project->repository_url || $project->video_url)
                    <hr>
                    <h6 class="font-weight-bold mb-2">
                        <i class="fas fa-link mr-1"></i> Enlaces
                    </h6>
                    <div class="d-flex flex-wrap" style="gap:.5rem;">
                        @if($project->project_url)
                            <a href="{{ $project->project_url }}" target="_blank"
                               class="btn btn-sm btn-outline-success">
                                <i class="fas fa-globe mr-1"></i> Demo
                            </a>
                        @endif
                        @if($project->repository_url)
                            @php
                                $repoIcon = str_contains($project->repository_url, 'github.com')
                                    ? 'fab fa-github'
                                    : (str_contains($project->repository_url, 'gitlab.com')
                                        ? 'fab fa-gitlab'
                                        : (str_contains($project->repository_url, 'bitbucket.org')
                                            ? 'fab fa-bitbucket'
                                            : 'fab fa-git-alt'));
                            @endphp
                            <a href="{{ $project->repository_url }}" target="_blank"
                               class="btn btn-sm btn-outline-dark">
                                <i class="{{ $repoIcon }} mr-1"></i> Repositorio
                            </a>
                        @endif
                        @if($project->video_url)
                            <a href="{{ $project->video_url }}" target="_blank"
                               class="btn btn-sm btn-outline-danger">
                                <i class="fab fa-youtube mr-1"></i> Video
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Descripción larga --}}
                @if($project->long_description)
                    <hr>
                    <h6 class="font-weight-bold mb-2">
                        <i class="fas fa-align-left mr-1"></i> Descripción Completa
                    </h6>
                    <p class="text-muted" style="font-size:.9rem; white-space:pre-line;">
                        {{ Str::limit($project->long_description, 400) }}
                    </p>
                @endif

                <hr>
                <div class="mb-1">
                    <strong>Creado:</strong>
                    <span class="text-muted">{{ $project->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="mb-1">
                    <strong>Actualizado:</strong>
                    <span class="text-muted">{{ $project->updated_at->format('d/m/Y H:i') }}</span>
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('backend.projects.index') }}"
                       class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Volver
                    </a>
                    <a href="{{ route('backend.projects.edit', $project->id) }}"
                       class="btn btn-sm btn-primary">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>
                </div>

            </x-adminlte-card>
        </div>

        {{-- ============================================ --}}
        {{-- COLUMNA DERECHA: TECNOLOGÍAS + GALERÍA --}}
        {{-- ============================================ --}}
        <div class="col-md-7">

            {{-- ======================================== --}}
            {{-- TECNOLOGÍAS --}}
            {{-- ======================================== --}}
            <x-adminlte-card theme="primary" icon="fas fa-code">
                <x-slot name="title">
                    Tecnologías Usadas
                    <span class="badge badge-primary ml-2">
                        {{ $project->technologies->count() }}
                    </span>
                </x-slot>

                @if($project->technologies->isEmpty())
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-code fa-2x mb-2"></i>
                        <p class="mb-0">Sin tecnologías asociadas.</p>
                        <a href="{{ route('backend.projects.edit', $project->id) }}"
                           class="btn btn-sm btn-primary mt-2">
                            <i class="fas fa-plus mr-1"></i> Agregar tecnologías
                        </a>
                    </div>
                @else
                    <div class="d-flex flex-wrap" style="gap:.5rem;">
                        @foreach($project->technologies as $tech)
                            <span class="badge d-flex align-items-center"
                                  style="background-color: rgba({{ hexToRgb($tech->color ?? '#3b82f6') }}, 0.15);
                                         color: {{ $tech->color ?? '#3b82f6' }};
                                         border: 1px solid {{ $tech->color ?? '#3b82f6' }};
                                         padding:.4rem .75rem; font-size:.85rem;">
                                @if($tech->icon_path)
                                    <img src="{{ asset('storage/' . $tech->icon_path) }}"
                                         style="width:14px; height:14px; object-fit:contain; margin-right:5px;">
                                @elseif($tech->icon_class)
                                    <i class="{{ $tech->icon_class }}" style="margin-right:5px;"></i>
                                @elseif($tech->slug)
                                    <img src="https://cdn.simpleicons.org/{{ $tech->slug }}/{{ ltrim($tech->color ?? '3b82f6', '#') }}"
                                         style="width:14px; height:14px; object-fit:contain; margin-right:5px;"
                                         onerror="this.style.display='none'">
                                @endif
                                {{ $tech->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </x-adminlte-card>

            {{-- ======================================== --}}
            {{-- GALERÍA INTEGRADA --}}
            {{-- ======================================== --}}
            <x-adminlte-card theme="success" icon="fas fa-images">
                <x-slot name="title">
                    Galería de Imágenes
                    <span class="badge badge-success ml-2">
                        {{ $project->galleries->count() }} / 5
                    </span>
                </x-slot>

                {{-- Barra de progreso --}}
                <div class="progress mb-3" style="height:6px;">
                    <div class="progress-bar bg-success"
                         style="width:{{ ($project->galleries->count() / 5) * 100 }}%;">
                    </div>
                </div>

                {{-- Grid de imágenes existentes --}}
                @if($project->galleries->isNotEmpty())
                    <div class="row mb-3">
                        @foreach($project->galleries as $gallery)
                            <div class="col-4 mb-2 px-1">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}"
                                         alt="{{ $gallery->caption ?? $project->title }}"
                                         class="img-fluid rounded"
                                         style="width:100%; height:90px;
                                                object-fit:cover; cursor:pointer;"
                                         onclick="openLightbox(
                                            '{{ asset('storage/' . $gallery->image_path) }}',
                                            '{{ addslashes($gallery->caption ?? '') }}'
                                         )">

                                    {{-- Botón eliminar sobre la imagen --}}
                                    <form method="POST"
                                          id="delGallery{{ $gallery->id }}"
                                          action="{{ route('backend.projects-gallery.destroy', [$project->id, $gallery->id]) }}"
                                          class="position-absolute"
                                          style="top:4px; right:4px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-xs btn-danger"
                                                style="padding:2px 6px; opacity:.85;"
                                                onclick="confirmDeleteGallery({{ $gallery->id }})"
                                                title="Eliminar imagen">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                                @if($gallery->caption)
                                    <small class="text-muted d-block text-center mt-1"
                                           style="font-size:.7rem;">
                                        {{ Str::limit($gallery->caption, 20) }}
                                    </small>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Formulario de subida inline --}}
                @if($project->galleries->count() < 5)
                    <form method="POST"
                          action="{{ route('backend.projects-gallery.store', $project->id) }}"
                          enctype="multipart/form-data"
                          class="border rounded p-3 bg-light">
                        @csrf

                        <p class="font-weight-bold mb-2 small text-uppercase text-muted">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar imagen
                        </p>

                        <div class="form-group mb-2">
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input"
                                       name="image_path"
                                       id="gallery_image"
                                       accept="image/jpeg,image/jpg,image/png,image/webp"
                                       required>
                                <label class="custom-file-label" for="gallery_image">
                                    Seleccionar imagen
                                </label>
                            </div>
                            <small class="text-muted">JPEG, PNG, WEBP. Máx. 3MB.</small>
                        </div>

                        <div class="form-group mb-2">
                            <input type="text"
                                   class="form-control form-control-sm"
                                   name="caption"
                                   placeholder="Descripción (opcional)"
                                   maxlength="255">
                        </div>

                        <button type="submit" class="btn btn-sm btn-success btn-block">
                            <i class="fas fa-upload mr-1"></i> Subir imagen
                        </button>
                    </form>
                @else
                    <div class="alert alert-warning mb-0 text-center py-2">
                        <i class="fas fa-lock mr-1"></i>
                        <small>Límite de 5 imágenes alcanzado.</small>
                    </div>
                @endif

            </x-adminlte-card>

        </div>
    </div>
</div>

{{-- Lightbox --}}
<div class="modal fade" id="lightboxModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0 pb-0">
                <h6 id="lightbox-caption" class="modal-title text-white small"></h6>
                <button type="button" class="close text-white"
                        data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center p-2">
                <img id="lightbox-img" src="" alt=""
                     class="img-fluid rounded" style="max-height:75vh;">
            </div>
        </div>
    </div>
</div>

@stop

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Auto-hide alertas
    const successAlert = document.getElementById('success-alert');
    const errorAlert   = document.getElementById('error-alert');
    if (successAlert) setTimeout(() => successAlert.style.display = 'none', 3000);
    if (errorAlert)   setTimeout(() => errorAlert.style.display = 'none', 5000);

    // Custom file input label
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function () {
            this.nextElementSibling.textContent =
                this.files[0]?.name || 'Seleccionar imagen';
        });
    });
});

function openLightbox(src, caption) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox-caption').textContent = caption || '';
    $('#lightboxModal').modal('show');
}

function confirmDeleteGallery(id) {
    Swal.fire({
        title: '¿Eliminar imagen?',
        text: 'Esta acción no se puede revertir.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '{{ color("primary") }}',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
    }).then(result => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Eliminando...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading(),
            });
            document.getElementById('delGallery' + id).submit();
        }
    });
}
</script>
@endpush