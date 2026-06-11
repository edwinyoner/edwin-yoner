@extends('layouts.main')

@section('subtitle', 'Nuevo Proyecto')
@section('content_header_title', 'Proyectos')
@section('content_header_subtitle', 'Crear nuevo proyecto')

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

    @if($errors->any())
        <x-adminlte-alert theme="danger" id="error-alert" title="Errores de validación" dismissable>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-adminlte-alert>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-10">
            <x-adminlte-card title="Nuevo Proyecto" theme="success" icon="fas fa-project-diagram">

                <form method="POST"
                      action="{{ route('backend.projects.store') }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        {{-- ======================================== --}}
                        {{-- COLUMNA IZQUIERDA --}}
                        {{-- ======================================== --}}
                        <div class="col-md-7">

                            {{-- Título --}}
                            <x-adminlte-input name="title"
                                              label="Título del Proyecto"
                                              placeholder="Ej: Smart Parking System"
                                              value="{{ old('title') }}"
                                              required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-success">
                                        <i class="fas fa-heading text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            {{-- Slug --}}
                            <x-adminlte-input name="slug"
                                              label="Slug"
                                              placeholder="Ej: smart-parking-system"
                                              value="{{ old('slug') }}"
                                              required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-success">
                                        <i class="fas fa-link text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <small class="form-text text-muted mb-3">
                                Se genera automáticamente desde el título.
                            </small>

                            {{-- Descripción Corta --}}
                            <div class="form-group">
                                <label for="short_description">
                                    Descripción Corta
                                    <small class="text-muted">(Aparece en la card)</small>
                                </label>
                                <textarea name="short_description"
                                          id="short_description"
                                          class="form-control @error('short_description') is-invalid @enderror"
                                          rows="3"
                                          maxlength="500"
                                          placeholder="Descripción breve del proyecto (2-3 líneas)...">{{ old('short_description') }}</textarea>
                                <small class="form-text text-muted d-flex justify-content-between">
                                    <span>Máx. 500 caracteres.</span>
                                    <span id="short-desc-count">0 / 500</span>
                                </small>
                                @error('short_description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Descripción Larga --}}
                            <div class="form-group">
                                <label for="long_description">
                                    Descripción Completa
                                    <small class="text-muted">(Opcional — modal o página detalle)</small>
                                </label>
                                <textarea name="long_description"
                                          id="long_description"
                                          class="form-control @error('long_description') is-invalid @enderror"
                                          rows="6"
                                          maxlength="10000"
                                          placeholder="Descripción detallada del proyecto: objetivos, tecnologías usadas, resultados...">{{ old('long_description') }}</textarea>
                                <small class="form-text text-muted d-flex justify-content-between">
                                    <span>Máx. 10,000 caracteres.</span>
                                    <span id="long-desc-count">0 / 10000</span>
                                </small>
                                @error('long_description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Año --}}
                            <x-adminlte-input name="year"
                                              label="Año de Desarrollo"
                                              type="number"
                                              placeholder="{{ date('Y') }}"
                                              value="{{ old('year', date('Y')) }}"
                                              min="2000"
                                              max="{{ date('Y') + 1 }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-success">
                                        <i class="fas fa-calendar text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                        </div>

                        {{-- ======================================== --}}
                        {{-- COLUMNA DERECHA --}}
                        {{-- ======================================== --}}
                        <div class="col-md-5">

                            {{-- Thumbnail --}}
                            <div class="form-group">
                                <label>Imagen Principal (Thumbnail)</label>
                                <div class="text-center mb-2">
                                    <div id="thumbnail-preview"
                                         class="bg-light d-flex align-items-center
                                                justify-content-center mx-auto"
                                         style="width:100%; height:160px;
                                                border-radius:8px; border:2px dashed #dee2e6;">
                                        <div>
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                            <p class="text-muted small mt-2 mb-0">Vista previa</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input @error('thumbnail_image') is-invalid @enderror"
                                           name="thumbnail_image"
                                           id="thumbnail_image"
                                           accept="image/jpeg,image/jpg,image/png,image/webp">
                                    <label class="custom-file-label" for="thumbnail_image">
                                        Seleccionar imagen
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    JPEG, JPG, PNG, WEBP. Máx. 2MB.
                                </small>
                                @error('thumbnail_image')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <hr>

                            {{-- Project URL --}}
                            <x-adminlte-input name="project_url"
                                              label="URL del Proyecto (Producción)"
                                              type="url"
                                              placeholder="https://mi-proyecto.com"
                                              value="{{ old('project_url') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-success">
                                        <i class="fas fa-globe text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            {{-- Repository URL --}}
                            <x-adminlte-input name="repository_url"
                                              label="URL del Repositorio"
                                              type="url"
                                              placeholder="https://github.com/usuario/repo"
                                              value="{{ old('repository_url') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-success">
                                        <i class="fab fa-git-alt text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            {{-- Video URL --}}
                            <x-adminlte-input name="video_url"
                                              label="URL del Video Demo (YouTube)"
                                              type="url"
                                              placeholder="https://youtube.com/watch?v=..."
                                              value="{{ old('video_url') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-success">
                                        <i class="fab fa-youtube text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            {{-- Estado --}}
                            <div class="form-group">
                                <label>Estado</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           id="is_active"
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-bold"
                                           for="is_active">
                                        Proyecto Activo
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ======================================== --}}
                    {{-- TECNOLOGÍAS --}}
                    {{-- ======================================== --}}
                    <hr>
                    <div class="form-group">
                        <label>
                            <i class="fas fa-code mr-1"></i>
                            Tecnologías Usadas
                            <small class="text-muted">(Opcional — selección múltiple)</small>
                        </label>

                        @if($technologies->isEmpty())
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                No hay tecnologías registradas.
                                <a href="{{ route('backend.technologies.create') }}" target="_blank">
                                    Agregar tecnología
                                </a>
                            </div>
                        @else
                            {{-- Agrupar por categoría --}}
                            @php
                                $grouped = $technologies->groupBy(fn($t) => $t->category->name ?? 'Sin categoría');
                            @endphp

                            <div class="row">
                                @foreach($grouped as $categoryName => $techs)
                                    <div class="col-md-4 mb-3">
                                        <div class="card border">
                                            <div class="card-header py-2"
                                                 style="background: rgba({{ hexToRgb(color('primary')) }}, 0.1);">
                                                <small class="font-weight-bold text-uppercase">
                                                    {{ $categoryName }}
                                                </small>
                                            </div>
                                            <div class="card-body py-2">
                                                @foreach($techs as $tech)
                                                    <div class="custom-control custom-checkbox mb-1">
                                                        <input type="checkbox"
                                                               class="custom-control-input tech-checkbox"
                                                               id="tech_{{ $tech->id }}"
                                                               name="technologies[]"
                                                               value="{{ $tech->id }}"
                                                               {{ in_array($tech->id, old('technologies', [])) ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="tech_{{ $tech->id }}">
                                                            {{-- Icono mini --}}
                                                            @if(!$tech->icon_class && $tech->slug)
                                                                <img src="https://cdn.simpleicons.org/{{ $tech->slug }}/{{ ltrim($tech->color ?? 'd4af37', '#') }}"
                                                                     style="width:16px; height:16px;
                                                                            object-fit:contain; margin-right:4px;"
                                                                     onerror="this.style.display='none'">
                                                            @elseif($tech->icon_class)
                                                                <i class="{{ $tech->icon_class }}"
                                                                   style="color:{{ $tech->color ?? 'inherit' }};
                                                                          width:16px; margin-right:4px;"></i>
                                                            @endif
                                                            {{ $tech->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Contador seleccionados --}}
                            <small class="text-muted">
                                <span id="tech-count">0</span> tecnología(s) seleccionada(s)
                            </small>
                        @endif
                    </div>

                    {{-- ======================================== --}}
                    {{-- BOTONES --}}
                    {{-- ======================================== --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.projects.index') }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Volver
                        </a>
                        <x-adminlte-button class="btn-sm"
                                           type="submit"
                                           label="Guardar Proyecto"
                                           theme="success"
                                           icon="fas fa-save" />
                    </div>

                </form>
            </x-adminlte-card>
        </div>
    </div>
</div>
@stop

@push('css')
<style>
    #success-alert, #error-alert { transition: opacity 0.5s ease; }
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const titleInput    = document.querySelector('input[name="title"]');
    const slugInput     = document.querySelector('input[name="slug"]');
    const thumbInput    = document.getElementById('thumbnail_image');
    const thumbPreview  = document.getElementById('thumbnail-preview');
    const shortDesc     = document.getElementById('short_description');
    const longDesc      = document.getElementById('long_description');
    const shortCount    = document.getElementById('short-desc-count');
    const longCount     = document.getElementById('long-desc-count');
    const techCheckboxes = document.querySelectorAll('.tech-checkbox');
    const techCountEl   = document.getElementById('tech-count');

    // ============================================
    // AUTO-GENERAR SLUG DESDE TÍTULO
    // ============================================
    titleInput?.addEventListener('input', function () {
        const slug = this.value
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
        slugInput.value = slug;
    });

    // ============================================
    // PREVIEW THUMBNAIL
    // ============================================
    thumbInput?.addEventListener('change', function () {
        const label = this.nextElementSibling;
        label.textContent = this.files[0]?.name || 'Seleccionar imagen';

        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                thumbPreview.innerHTML = `<img src="${e.target.result}"
                    style="width:100%; height:160px; object-fit:cover;
                           border-radius:8px;">`;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // ============================================
    // CONTADORES DESCRIPCIÓN
    // ============================================
    function setupCounter(textarea, counter, max) {
        if (!textarea || !counter) return;
        textarea.addEventListener('input', function () {
            const len = this.value.length;
            counter.textContent = `${len} / ${max}`;
            counter.style.color = len > max * 0.9 ? '#dc3545' : '';
        });
    }

    setupCounter(shortDesc, shortCount, 500);
    setupCounter(longDesc,  longCount,  10000);

    // ============================================
    // CONTADOR TECNOLOGÍAS
    // ============================================
    function updateTechCount() {
        const checked = document.querySelectorAll('.tech-checkbox:checked').length;
        if (techCountEl) techCountEl.textContent = checked;
    }

    techCheckboxes.forEach(cb => cb.addEventListener('change', updateTechCount));
    updateTechCount();

    // ============================================
    // AUTO-HIDE ALERTAS
    // ============================================
    const successAlert = document.getElementById('success-alert');
    const errorAlert   = document.getElementById('error-alert');

    if (successAlert) setTimeout(() => successAlert.style.display = 'none', 3000);
    if (errorAlert)   setTimeout(() => errorAlert.style.display = 'none', 10000);
});
</script>
@endpush