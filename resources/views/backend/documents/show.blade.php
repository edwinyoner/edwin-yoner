@extends('layouts.main')

@section('subtitle', 'Detalle de Documento')
@section('content_header_title', 'Documentos')
@section('content_header_subtitle', 'Detalle del documento')

@section('plugins.Sweetalert2', true)

@section('content_body')
<div class="container-fluid">

    {{-- ============================================ --}}
    {{-- CABECERA --}}
    {{-- ============================================ --}}
    <div class="card-header text-white text-center py-3 mb-4"
         style="background: linear-gradient(135deg, {{ color('primary') }}, {{ color('secondary') }});">
        <h2 class="mb-0">DETALLE DE DOCUMENTO</h2>
        <div class="mt-2">
            <span class="ml-2">
                <i class="{{ $document->icon_with_fallback }} mr-1"
                   style="color: {{ $document->color_with_fallback }};"></i>
                {{ $document->title }}
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
    @endif

    <div class="row">

        {{-- ============================================ --}}
        {{-- COLUMNA IZQUIERDA --}}
        {{-- ============================================ --}}
        <div class="col-lg-8">

            <x-adminlte-card theme="primary" title="Información del Documento"
                             icon="fas fa-info-circle">

                <table class="table table-bordered table-sm mb-0">
                    <tbody>

                        <tr>
                            <th style="width:30%;">ID</th>
                            <td>{{ $document->id }}</td>
                        </tr>

                        <tr>
                            <th>Título</th>
                            <td><strong>{{ $document->title }}</strong></td>
                        </tr>

                        <tr>
                            <th>Descripción</th>
                            <td>
                                @if($document->description)
                                    {{ $document->description }}
                                @else
                                    <span class="text-muted">Sin descripción</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Archivo</th>
                            <td>
                                @if($document->file_path)
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-secondary mr-2">
                                            {{ $document->file_extension }}
                                        </span>
                                        <span>{{ $document->file_name }}</span>
                                    </div>
                                    <div class="mt-1">
                                        @if($document->fileExists())
                                            <a href="{{ $document->file_url }}"
                                               target="_blank"
                                               class="btn btn-xs btn-outline-secondary mr-1"
                                               style="font-size:.75rem;">
                                                <i class="fas fa-external-link-alt mr-1"></i> Abrir
                                            </a>
                                            <button type="button"
                                                    class="btn btn-xs btn-outline-info mr-1"
                                                    style="font-size:.75rem;"
                                                    onclick="togglePdfPreview()">
                                                <i class="fas fa-eye mr-1"></i>
                                                <span id="previewBtnText">Ver aquí</span>
                                            </button>
                                            <a href="{{ $document->download_url }}"
                                               class="btn btn-xs btn-outline-primary"
                                               style="font-size:.75rem;">
                                                <i class="fas fa-download mr-1"></i> Descargar
                                            </a>
                                        @else
                                            <span class="badge badge-warning">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Archivo no encontrado en servidor
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">Sin archivo cargado</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Estado</th>
                            <td>
                                <span class="badge badge-{{ $document->is_active ? 'success' : 'secondary' }}">
                                    {{ $document->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Creado</th>
                            <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                        </tr>

                        <tr>
                            <th>Actualizado</th>
                            <td>{{ $document->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>

                    </tbody>
                </table>

            </x-adminlte-card>

            {{-- ============================================ --}}
            {{-- PREVISUALIZACIÓN DEL PDF --}}
            {{-- ============================================ --}}
            @if($document->file_path && $document->fileExists())
                <div id="pdfPreviewCard" class="d-none">
                    <x-adminlte-card theme="secondary" title="Previsualización del PDF"
                                     icon="fas fa-eye">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <i class="fas fa-file-pdf text-danger mr-2"></i>
                                <strong>{{ $document->file_name }}</strong>
                            </div>
                            <button type="button"
                                    class="btn btn-xs btn-outline-secondary"
                                    onclick="togglePdfPreview()">
                                <i class="fas fa-times mr-1"></i> Cerrar
                            </button>
                        </div>
                        <div style="border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden;">
                            <iframe id="pdfPreviewFrame"
                                    src=""
                                    data-src="{{ $document->file_url }}"
                                    style="width: 100%; height: 500px; border: none;"
                                    title="Vista previa del PDF">
                            </iframe>
                        </div>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-server mr-1"></i>
                            Visualizando el archivo guardado en el servidor.
                        </small>
                    </x-adminlte-card>
                </div>
            @endif

        </div>

        {{-- ============================================ --}}
        {{-- COLUMNA DERECHA --}}
        {{-- ============================================ --}}
        <div class="col-lg-4">

            {{-- Apariencia --}}
            <x-adminlte-card theme="secondary" title="Apariencia"
                             icon="fas fa-palette">
                <div class="text-center py-2">
                    <i class="{{ $document->icon_with_fallback }} fa-4x mb-2"
                       style="color: {{ $document->color_with_fallback }};"></i>
                    <div>
                        <span class="badge badge-secondary">
                            {{ $document->icon_with_fallback }}
                        </span>
                    </div>
                    <div class="mt-2 d-flex align-items-center justify-content-center">
                        <span style="display:inline-block; width:16px; height:16px;
                                     background:{{ $document->color_with_fallback }};
                                     border-radius:3px; border:1px solid #ccc; margin-right:6px;">
                        </span>
                        <code>{{ $document->color_with_fallback }}</code>
                    </div>
                </div>
            </x-adminlte-card>

            {{-- Estadísticas --}}
            <x-adminlte-card theme="secondary" title="Estadísticas"
                             icon="fas fa-chart-bar">
                <div class="text-center">
                    <p class="mb-1 text-muted small">Total de descargas</p>
                    <span class="badge badge-{{ $document->download_count > 0 ? 'info' : 'secondary' }} px-3 py-2"
                          style="font-size:1rem;">
                        <i class="fas fa-download mr-1"></i>
                        {{ $document->formatted_downloads }}
                    </span>
                </div>
            </x-adminlte-card>

            {{-- Acciones --}}
            <x-adminlte-card theme="secondary" title="Acciones"
                             icon="fas fa-cogs">

                <a href="{{ route('backend.documents.edit', $document->id) }}"
                   class="btn btn-primary btn-block mb-2">
                    <i class="fas fa-edit mr-1"></i> Editar Documento
                </a>

                <form id="deleteForm"
                      method="POST"
                      action="{{ route('backend.documents.destroy', $document->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="btn btn-danger btn-block"
                            onclick="confirmDelete({{ $document->id }}, '{{ addslashes($document->title) }}')">
                        <i class="fas fa-trash mr-1"></i> Eliminar Documento
                    </button>
                </form>

            </x-adminlte-card>

        </div>
    </div>

    {{-- Navegación --}}
    <div class="mt-1">
        <a href="{{ route('backend.documents.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Volver al listado
        </a>
    </div>

</div>
@stop

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.style.display = 'none', 500);
        }, 3000);
    }

});

// ============================================
// TOGGLE PREVISUALIZACIÓN
// ============================================
function togglePdfPreview() {
    const card    = document.getElementById('pdfPreviewCard');
    const frame   = document.getElementById('pdfPreviewFrame');
    const btnText = document.getElementById('previewBtnText');

    if (!card) return;

    const isHidden = card.classList.contains('d-none');

    if (isHidden) {
        // Cargar el src solo la primera vez
        if (!frame.src || frame.src === window.location.href) {
            frame.src = frame.dataset.src;
        }
        card.classList.remove('d-none');
        btnText.textContent = 'Ocultar';
        setTimeout(() => {
            card.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    } else {
        card.classList.add('d-none');
        btnText.textContent = 'Ver aquí';
    }
}

// ============================================
// ELIMINAR
// ============================================
function confirmDelete(id, title) {
    Swal.fire({
        title: '¿Eliminar documento?',
        html: `¿Estás seguro de eliminar <strong>"${title}"</strong>?<br>
               <small class="text-muted">El archivo PDF también será eliminado del servidor.</small>`,
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
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>
@endpush