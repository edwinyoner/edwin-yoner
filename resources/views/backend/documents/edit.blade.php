@extends('layouts.main')

@section('subtitle', 'Editar Documento')
@section('content_header_title', 'Documentos')
@section('content_header_subtitle', 'Editar documento')

@section('plugins.Sweetalert2', true)

@section('content_body')
<div class="container-fluid">

    {{-- ============================================ --}}
    {{-- CABECERA --}}
    {{-- ============================================ --}}
    <div class="card-header text-white text-center py-3 mb-4"
         style="background: linear-gradient(135deg, {{ color('primary') }}, {{ color('secondary') }});">
        <h2 class="mb-0">EDITAR DOCUMENTO</h2>
        <div class="mt-2">
            <span class="ml-2">
                <i class="fas fa-edit mr-1"></i> {{ $document->title }}
            </span>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- ALERTAS DE ERROR GLOBAL --}}
    {{-- ============================================ --}}
    @if($errors->any())
        <x-adminlte-alert theme="danger" title="Errores de validación" dismissable>
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-adminlte-alert>
    @endif

    <div class="row">
        <div class="col-12">

            <form action="{{ route('backend.documents.update', $document->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="editDocumentForm">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- ============================================ --}}
                    {{-- COLUMNA IZQUIERDA --}}
                    {{-- ============================================ --}}
                    <div class="col-lg-8">

                        <x-adminlte-card theme="primary" title="Información del Documento"
                                         icon="fas fa-info-circle">

                            {{-- Título --}}
                            <div class="form-group">
                                <label for="title">
                                    Título <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       id="title"
                                       name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $document->title) }}"
                                       placeholder="Ej: Curriculum Vitae, Certificado Python..."
                                       maxlength="255"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Descripción --}}
                            <div class="form-group">
                                <label for="description">Descripción</label>
                                <textarea id="description"
                                          name="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="3"
                                          maxlength="1000"
                                          placeholder="Breve descripción del documento (opcional)...">{{ old('description', $document->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Máximo 1000 caracteres.</small>
                            </div>

                            {{-- Archivo PDF --}}
                            <div class="form-group">
                                <label for="file_path">Reemplazar Archivo PDF</label>

                                {{-- Archivo actual con botón ver --}}
                                @if($document->file_path)
                                    <div class="alert alert-secondary py-2 mb-2">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <i class="fas fa-file-pdf text-danger mr-2"></i>
                                                <strong>Archivo actual:</strong>
                                                <span class="ml-1">{{ $document->file_name }}</span>
                                            </div>
                                            <div>
                                                <a href="{{ $document->file_url }}"
                                                   target="_blank"
                                                   class="btn btn-xs btn-outline-secondary mr-1"
                                                   style="padding:2px 8px; font-size:.75rem;">
                                                    <i class="fas fa-external-link-alt mr-1"></i> Abrir
                                                </a>
                                                <button type="button"
                                                        class="btn btn-xs btn-outline-info"
                                                        style="padding:2px 8px; font-size:.75rem;"
                                                        onclick="previewExistingPdf('{{ $document->file_url }}', '{{ addslashes($document->file_name) }}')">
                                                    <i class="fas fa-eye mr-1"></i> Ver aquí
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning py-2 mb-2">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Sin archivo cargado.
                                    </div>
                                @endif

                                <div class="custom-file">
                                    <input type="file"
                                           id="file_path"
                                           name="file_path"
                                           class="custom-file-input @error('file_path') is-invalid @enderror"
                                           accept=".pdf">
                                    <label class="custom-file-label" for="file_path" id="fileLabel">
                                        {{ $document->file_path ? 'Subir nuevo PDF para reemplazar...' : 'Seleccionar archivo PDF...' }}
                                    </label>
                                    @error('file_path')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    Solo archivos PDF. Máximo 20MB.
                                    @if($document->file_path)
                                        Si no seleccionas un archivo, se conserva el actual.
                                    @endif
                                </small>
                            </div>

                            {{-- Barra de progreso --}}
                            <div id="uploadProgress" class="d-none mt-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Preparando archivo...</small>
                                    <small id="fileSize" class="text-muted"></small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div id="progressBar"
                                         class="progress-bar progress-bar-striped progress-bar-animated"
                                         style="width: 0%; background: {{ color('primary') }};">
                                    </div>
                                </div>
                            </div>

                        </x-adminlte-card>

                        {{-- ============================================ --}}
                        {{-- PREVISUALIZACIÓN DEL PDF --}}
                        {{-- ============================================ --}}
                        <div id="pdfPreviewCard" class="d-none">
                            <x-adminlte-card theme="secondary" title="Previsualización del PDF"
                                             icon="fas fa-eye">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <i class="fas fa-file-pdf text-danger mr-2"></i>
                                        <strong id="previewFileName"></strong>
                                        <span id="previewFileSizeBadge" class="badge badge-secondary ml-2"></span>
                                        <span id="previewSourceBadge" class="badge badge-info ml-1"></span>
                                    </div>
                                    <button type="button"
                                            class="btn btn-xs btn-outline-secondary"
                                            onclick="closePdfPreview()">
                                        <i class="fas fa-times mr-1"></i> Cerrar
                                    </button>
                                </div>
                                <div style="border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden;">
                                    <iframe id="pdfPreviewFrame"
                                            src=""
                                            style="width: 100%; height: 500px; border: none;"
                                            title="Vista previa del PDF">
                                    </iframe>
                                </div>
                                <small class="text-muted mt-1 d-block" id="previewNote"></small>
                            </x-adminlte-card>
                        </div>

                    </div>

                    {{-- ============================================ --}}
                    {{-- COLUMNA DERECHA --}}
                    {{-- ============================================ --}}
                    <div class="col-lg-4">

                        {{-- Apariencia --}}
                        <x-adminlte-card theme="secondary" title="Apariencia"
                                         icon="fas fa-palette">

                            <div class="form-group">
                                <label for="icon_class">Clase de Icono</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i id="iconPreview"
                                               class="{{ old('icon_class', $document->icon_with_fallback) }}"></i>
                                        </span>
                                    </div>
                                    <input type="text"
                                           id="icon_class"
                                           name="icon_class"
                                           class="form-control @error('icon_class') is-invalid @enderror"
                                           value="{{ old('icon_class', $document->icon_class) }}"
                                           placeholder="fas fa-file-pdf">
                                    @error('icon_class')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    Clase FontAwesome. Ej: <code>fas fa-certificate</code>
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="color">Color</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text p-1">
                                            <input type="color"
                                                   id="colorPicker"
                                                   value="{{ old('color', $document->color_with_fallback) }}"
                                                   style="width:32px; height:32px; border:none; cursor:pointer; padding:0;">
                                        </span>
                                    </div>
                                    <input type="text"
                                           id="color"
                                           name="color"
                                           class="form-control @error('color') is-invalid @enderror"
                                           value="{{ old('color', $document->color_with_fallback) }}"
                                           placeholder="#EF4444"
                                           maxlength="7">
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Formato hex. Ej: <code>#EF4444</code></small>
                            </div>

                            <div class="text-center mt-2 mb-1">
                                <i id="iconColorPreview"
                                   class="{{ old('icon_class', $document->icon_with_fallback) }} fa-3x"
                                   style="color: {{ old('color', $document->color_with_fallback) }};"></i>
                                <div class="mt-1">
                                    <small class="text-muted">Vista previa</small>
                                </div>
                            </div>

                        </x-adminlte-card>

                        {{-- Estado --}}
                        <x-adminlte-card theme="secondary" title="Estado"
                                         icon="fas fa-toggle-on">

                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', $document->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">
                                    Documento activo (visible en portafolio)
                                </label>
                            </div>

                            <hr>
                            <div class="text-center">
                                <span class="badge badge-{{ $document->download_count > 0 ? 'info' : 'secondary' }} badge-lg px-3 py-2">
                                    <i class="fas fa-download mr-1"></i>
                                    {{ $document->formatted_downloads }}
                                </span>
                            </div>

                        </x-adminlte-card>

                        {{-- Botones --}}
                        <x-adminlte-card>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('backend.documents.index') }}"
                                   class="btn btn-secondary">
                                    <i class="fas fa-times mr-1"></i> Cancelar
                                </a>
                                <button type="submit"
                                        class="btn btn-primary"
                                        id="submitBtn">
                                    <i class="fas fa-save mr-1"></i> Actualizar
                                </button>
                            </div>
                        </x-adminlte-card>

                    </div>
                </div>

            </form>

        </div>
    </div>

</div>
@stop

@push('css')
<style>
    .custom-file-label::after { content: "Examinar"; }
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const fileInput    = document.getElementById('file_path');
    const fileLabel    = document.getElementById('fileLabel');
    const previewCard  = document.getElementById('pdfPreviewCard');
    const previewFrame = document.getElementById('pdfPreviewFrame');
    const progressWrap = document.getElementById('uploadProgress');
    const progressBar  = document.getElementById('progressBar');
    const fileSizeEl   = document.getElementById('fileSize');
    const previewName  = document.getElementById('previewFileName');
    const previewBadge = document.getElementById('previewFileSizeBadge');
    const sourceBadge  = document.getElementById('previewSourceBadge');
    const previewNote  = document.getElementById('previewNote');

    let objectUrl = null;

    // ============================================
    // HELPER: formatear bytes
    // ============================================
    function formatBytes(bytes) {
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
    }

    // ============================================
    // PREVIEW ARCHIVO EXISTENTE (desde servidor)
    // ============================================
    window.previewExistingPdf = function (url, name) {
        // Si había un object URL de archivo nuevo, liberarlo
        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }

        previewName.textContent  = name;
        previewBadge.textContent = '';
        sourceBadge.textContent  = 'Archivo actual';
        sourceBadge.className    = 'badge badge-info ml-1';
        previewNote.innerHTML    = '<i class="fas fa-server mr-1"></i> Visualizando el archivo guardado en el servidor.';

        previewFrame.src = url;
        previewCard.classList.remove('d-none');

        // Scroll suave hacia la previsualización
        setTimeout(() => {
            previewCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    };

    // ============================================
    // ARCHIVO NUEVO: validar y previsualizar
    // ============================================
    fileInput.addEventListener('change', function () {
        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }

        previewCard.classList.add('d-none');
        previewFrame.src = '';
        progressWrap.classList.add('d-none');
        progressBar.style.width = '0%';

        if (!this.files || !this.files[0]) {
            fileLabel.textContent = '{{ $document->file_path ? "Subir nuevo PDF para reemplazar..." : "Seleccionar archivo PDF..." }}';
            return;
        }

        const file = this.files[0];
        const maxSize = 20 * 1024 * 1024; // 20MB

        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'Archivo muy grande',
                text: 'El archivo no puede superar los 20MB.',
                confirmButtonColor: '{{ color("primary") }}',
            });
            this.value = '';
            fileLabel.textContent = '{{ $document->file_path ? "Subir nuevo PDF para reemplazar..." : "Seleccionar archivo PDF..." }}';
            return;
        }

        fileLabel.textContent = file.name;

        // Barra de progreso simulada
        progressWrap.classList.remove('d-none');
        fileSizeEl.textContent = formatBytes(file.size);

        let progress = 0;
        const interval = setInterval(() => {
            progress += 10;
            progressBar.style.width = Math.min(progress, 90) + '%';
            if (progress >= 90) clearInterval(interval);
        }, 40);

        objectUrl = URL.createObjectURL(file);

        previewName.textContent  = file.name;
        previewBadge.textContent = formatBytes(file.size);
        sourceBadge.textContent  = 'Nuevo archivo';
        sourceBadge.className    = 'badge badge-warning ml-1';
        previewNote.innerHTML    = '<i class="fas fa-info-circle mr-1"></i> Vista previa local — este archivo reemplazará al actual al guardar.';

        previewFrame.onload = function () {
            clearInterval(interval);
            progressBar.style.width = '100%';
            setTimeout(() => {
                progressWrap.classList.add('d-none');
                progressBar.style.width = '0%';
            }, 400);
            previewCard.classList.remove('d-none');
            previewCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        };

        previewFrame.src = objectUrl;
    });

    // ============================================
    // CERRAR PREVISUALIZACIÓN
    // ============================================
    window.closePdfPreview = function () {
        previewCard.classList.add('d-none');
        previewFrame.src = '';
        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }
    };

    // ============================================
    // ICONO: preview en tiempo real
    // ============================================
    const iconInput        = document.getElementById('icon_class');
    const iconPreview      = document.getElementById('iconPreview');
    const iconColorPreview = document.getElementById('iconColorPreview');

    iconInput.addEventListener('input', function () {
        const val = this.value.trim() || 'fas fa-file-pdf';
        iconPreview.className = val;
        iconColorPreview.className = val + ' fa-3x';
    });

    // ============================================
    // COLOR: sincronizar picker ↔ input texto
    // ============================================
    const colorInput  = document.getElementById('color');
    const colorPicker = document.getElementById('colorPicker');

    colorPicker.addEventListener('input', function () {
        colorInput.value = this.value.toUpperCase();
        iconColorPreview.style.color = this.value;
    });

    colorInput.addEventListener('input', function () {
        let val = this.value.trim();
        if (!val.startsWith('#')) val = '#' + val;
        iconColorPreview.style.color = val;
        if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
            colorPicker.value = val;
        }
    });

    // ============================================
    // SUBMIT: liberar object URL y deshabilitar botón
    // ============================================
    document.getElementById('editDocumentForm').addEventListener('submit', function () {
        if (objectUrl) URL.revokeObjectURL(objectUrl);
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Actualizando...';
    });

});
</script>
@endpush