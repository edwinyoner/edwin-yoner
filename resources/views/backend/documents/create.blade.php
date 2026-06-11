@extends('layouts.main')

@section('subtitle', 'Nuevo Documento')
@section('content_header_title', 'Documentos')
@section('content_header_subtitle', 'Crear nuevo documento')

@section('plugins.Sweetalert2', true)

@section('content_body')
<div class="container-fluid">

    {{-- ============================================ --}}
    {{-- CABECERA --}}
    {{-- ============================================ --}}
    <div class="card-header text-white text-center py-3 mb-4"
         style="background: linear-gradient(135deg, {{ color('primary') }}, {{ color('secondary') }});">
        <h2 class="mb-0">NUEVO DOCUMENTO</h2>
        <div class="mt-2">
            <span class="ml-2">
                <i class="fas fa-file-pdf mr-1"></i> Crear documento descargable
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

            <form action="{{ route('backend.documents.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="createDocumentForm">
                @csrf

                <div class="row">

                    {{-- ============================================ --}}
                    {{-- COLUMNA IZQUIERDA: datos principales --}}
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
                                       value="{{ old('title') }}"
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
                                          placeholder="Breve descripción del documento (opcional)...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Máximo 1000 caracteres.</small>
                            </div>

                            {{-- Archivo PDF --}}
                            <div class="form-group">
                                <label for="file_path">Archivo PDF</label>
                                <div class="custom-file">
                                    <input type="file"
                                           id="file_path"
                                           name="file_path"
                                           class="custom-file-input @error('file_path') is-invalid @enderror"
                                           accept=".pdf">
                                    <label class="custom-file-label" for="file_path" id="fileLabel">
                                        Seleccionar archivo PDF...
                                    </label>
                                    @error('file_path')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    Solo archivos PDF. Máximo 20MB.
                                </small>
                            </div>

                            {{-- Barra de progreso de carga --}}
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
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Vista previa local — el archivo aún no ha sido subido al servidor.
                                </small>
                            </x-adminlte-card>
                        </div>

                    </div>

                    {{-- ============================================ --}}
                    {{-- COLUMNA DERECHA: visualización y estado --}}
                    {{-- ============================================ --}}
                    <div class="col-lg-4">

                        {{-- Apariencia --}}
                        <x-adminlte-card theme="secondary" title="Apariencia"
                                         icon="fas fa-palette">

                            {{-- Icono --}}
                            <div class="form-group">
                                <label for="icon_class">Clase de Icono</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i id="iconPreview" class="{{ old('icon_class', 'fas fa-file-pdf') }}"></i>
                                        </span>
                                    </div>
                                    <input type="text"
                                           id="icon_class"
                                           name="icon_class"
                                           class="form-control @error('icon_class') is-invalid @enderror"
                                           value="{{ old('icon_class', 'fas fa-file-pdf') }}"
                                           placeholder="fas fa-file-pdf">
                                    @error('icon_class')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    Clase FontAwesome. Ej: <code>fas fa-certificate</code>
                                </small>
                            </div>

                            {{-- Color --}}
                            <div class="form-group">
                                <label for="color">Color</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text p-1">
                                            <input type="color"
                                                   id="colorPicker"
                                                   value="{{ old('color', '#EF4444') }}"
                                                   style="width:32px; height:32px; border:none; cursor:pointer; padding:0;">
                                        </span>
                                    </div>
                                    <input type="text"
                                           id="color"
                                           name="color"
                                           class="form-control @error('color') is-invalid @enderror"
                                           value="{{ old('color', '#EF4444') }}"
                                           placeholder="#EF4444"
                                           maxlength="7">
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Formato hex. Ej: <code>#EF4444</code></small>
                            </div>

                            {{-- Vista previa icono + color --}}
                            <div class="text-center mt-2 mb-1">
                                <i id="iconColorPreview"
                                   class="{{ old('icon_class', 'fas fa-file-pdf') }} fa-3x"
                                   style="color: {{ old('color', '#EF4444') }};"></i>
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
                                       {{ old('is_active', '1') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">
                                    Documento activo (visible en portafolio)
                                </label>
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
                                        class="btn btn-success"
                                        id="submitBtn">
                                    <i class="fas fa-save mr-1"></i> Guardar Documento
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

    let objectUrl = null;

    // ============================================
    // HELPER: formatear bytes a KB / MB
    // ============================================
    function formatBytes(bytes) {
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
    }

    // ============================================
    // ARCHIVO: validar y previsualizar
    // ============================================
    fileInput.addEventListener('change', function () {
        // Liberar URL anterior si existe
        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }

        // Ocultar previsualización anterior
        previewCard.classList.add('d-none');
        previewFrame.src = '';
        progressWrap.classList.add('d-none');
        progressBar.style.width = '0%';

        if (!this.files || !this.files[0]) {
            fileLabel.textContent = 'Seleccionar archivo PDF...';
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
            fileLabel.textContent = 'Seleccionar archivo PDF...';
            return;
        }

        // Mostrar nombre en label
        fileLabel.textContent = file.name;

        // Mostrar barra de progreso simulada mientras se lee el archivo
        progressWrap.classList.remove('d-none');
        fileSizeEl.textContent = formatBytes(file.size);

        let progress = 0;
        const interval = setInterval(() => {
            progress += 10;
            progressBar.style.width = Math.min(progress, 90) + '%';
            if (progress >= 90) clearInterval(interval);
        }, 40);

        // Crear object URL para el iframe
        objectUrl = URL.createObjectURL(file);

        previewName.textContent  = file.name;
        previewBadge.textContent = formatBytes(file.size);

        // Cuando el iframe carga, completar barra y mostrar card
        previewFrame.onload = function () {
            clearInterval(interval);
            progressBar.style.width = '100%';
            setTimeout(() => {
                progressWrap.classList.add('d-none');
                progressBar.style.width = '0%';
            }, 400);
            previewCard.classList.remove('d-none');
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
    // ICONO: actualizar preview en tiempo real
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
    document.getElementById('createDocumentForm').addEventListener('submit', function () {
        if (objectUrl) URL.revokeObjectURL(objectUrl);
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...';
    });

});
</script>
@endpush