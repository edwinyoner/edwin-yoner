@extends('layouts.main')

@section('subtitle', 'Editar Tecnología')
@section('content_header_title', 'Tecnologías')
@section('content_header_subtitle', 'Editar tecnología del portafolio')

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

    @if(session('error'))
        <x-adminlte-alert theme="danger" id="session-error-alert" title="Error" dismissable>
            {{ session('error') }}
        </x-adminlte-alert>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <x-adminlte-card title="Editar Tecnología"
                             theme="warning" icon="fas fa-code">

                <form method="POST"
                      action="{{ route('backend.technologies.update', $technology->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- ======================================== --}}
                    {{-- CATEGORÍA --}}
                    {{-- ======================================== --}}
                    <div class="form-group">
                        <label for="technologie_category_id">
                            Categoría <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning">
                                    <i class="fas fa-folder text-white"></i>
                                </span>
                            </div>
                            <select name="technologie_category_id"
                                    id="technologie_category_id"
                                    class="form-control @error('technologie_category_id') is-invalid @enderror"
                                    required>
                                <option value="">— Selecciona una categoría —</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ old('technologie_category_id', $technology->technologie_category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('technologie_category_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <hr>

                    {{-- ======================================== --}}
                    {{-- NOMBRE --}}
                    {{-- ======================================== --}}
                    <x-adminlte-input name="name"
                                      label="Nombre"
                                      placeholder="Ej: Laravel"
                                      value="{{ old('name', $technology->name) }}"
                                      required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-warning">
                                <i class="fas fa-tag text-white"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>

                    {{-- ======================================== --}}
                    {{-- SLUG --}}
                    {{-- ======================================== --}}
                    <x-adminlte-input name="slug"
                                      label="Slug (Simple Icons)"
                                      placeholder="Ej: laravel"
                                      value="{{ old('slug', $technology->slug) }}"
                                      required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-warning">
                                <i class="fas fa-link text-white"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <small class="form-text text-muted mb-3">
                        ⚠️ Cambiar el slug afecta el icono de Simple Icons.
                        Busca slugs en <a href="https://simpleicons.org" target="_blank">simpleicons.org</a>.
                    </small>

                    {{-- ======================================== --}}
                    {{-- ICONO --}}
                    {{-- ======================================== --}}
                    <div class="row">
                        {{-- Icono archivo (prioridad 1) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Icono (imagen subida)
                                    <small class="text-muted">— Prioridad 1</small>
                                </label>
                                @if($technology->icon_path)
                                    <div class="mb-2 d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $technology->icon_path) }}"
                                             alt="{{ $technology->name }}"
                                             style="width:36px; height:36px; object-fit:contain;">
                                        <small class="text-muted ml-2">Icono actual</small>
                                    </div>
                                @endif
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input @error('icon_path') is-invalid @enderror"
                                           name="icon_path"
                                           id="icon_path"
                                           accept="image/svg+xml,image/png,image/jpeg,image/webp">
                                    <label class="custom-file-label" for="icon_path">
                                        {{ $technology->icon_path ? 'Cambiar imagen' : 'Seleccionar imagen' }}
                                    </label>
                                </div>
                                <small class="form-text text-muted">SVG, PNG, JPG, WEBP. Máx. 512KB.</small>
                                @error('icon_path')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Icono FontAwesome (prioridad 3) --}}
                        <div class="col-md-6">
                            <x-adminlte-input name="icon_class"
                                              label="Icono FontAwesome — Prioridad 3"
                                              placeholder="Ej: fab fa-laravel"
                                              value="{{ old('icon_class', $technology->icon_class) }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-icons text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                    </div>

                    <div class="alert alert-light border mb-3" style="font-size:.85rem;">
                        <i class="fas fa-info-circle text-info mr-1"></i>
                        <strong>Prioridad de icono:</strong>
                        <span class="badge badge-primary">1</span> Imagen subida →
                        <span class="badge badge-success">2</span> Simple Icons (slug) →
                        <span class="badge badge-warning">3</span> FontAwesome (icon_class) →
                        <span class="badge badge-secondary">4</span> Iniciales
                    </div>

                    {{-- ======================================== --}}
                    {{-- COLOR --}}
                    {{-- ======================================== --}}
                    <div class="form-group">
                        <label>Color Oficial</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning">
                                    <i class="fas fa-palette text-white"></i>
                                </span>
                            </div>
                            <input type="text"
                                   class="form-control @error('color') is-invalid @enderror"
                                   name="color"
                                   id="color"
                                   placeholder="#FF2D20"
                                   value="{{ old('color', $technology->color) }}"
                                   maxlength="7">
                            <div class="input-group-append">
                                <input type="color"
                                       id="colorPicker"
                                       class="form-control"
                                       value="{{ old('color', $technology->color) ?? '#3B82F6' }}"
                                       style="width:60px; padding:2px;">
                            </div>
                        </div>
                        @error('color')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">Formato: #RRGGBB</small>
                    </div>

                    <hr>

                    {{-- ======================================== --}}
                    {{-- NIVEL Y PORCENTAJE --}}
                    {{-- ======================================== --}}
                    <div class="row">
                        {{-- Nivel --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proficiency_level">
                                    Nivel de Dominio <span class="text-danger">*</span>
                                </label>
                                <select name="proficiency_level"
                                        id="proficiency_level"
                                        class="form-control @error('proficiency_level') is-invalid @enderror"
                                        required>
                                    @foreach([
                                        'basico'     => ['label' => 'Básico',     'range' => '1–33%'],
                                        'intermedio' => ['label' => 'Intermedio', 'range' => '34–66%'],
                                        'avanzado'   => ['label' => 'Avanzado',   'range' => '67–100%'],
                                    ] as $value => $item)
                                        <option value="{{ $value }}"
                                                {{ old('proficiency_level', $technology->proficiency_level) === $value ? 'selected' : '' }}>
                                            {{ $item['label'] }} ({{ $item['range'] }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('proficiency_level')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Porcentaje --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proficiency_percentage">
                                    Porcentaje <span class="text-danger">*</span>
                                    <span id="percentage-value" class="badge badge-primary ml-1">
                                        {{ old('proficiency_percentage', $technology->proficiency_percentage) }}%
                                    </span>
                                </label>
                                <input type="range"
                                       class="form-control-range @error('proficiency_percentage') is-invalid @enderror"
                                       name="proficiency_percentage"
                                       id="proficiency_percentage"
                                       min="0" max="100" step="5"
                                       value="{{ old('proficiency_percentage', $technology->proficiency_percentage) }}">
                                @error('proficiency_percentage')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Barra de progreso preview --}}
                    <div class="progress mb-3" style="height:10px;">
                        <div id="progress-preview"
                             class="progress-bar"
                             style="width:{{ old('proficiency_percentage', $technology->proficiency_percentage) }}%;
                                    background-color: {{ $technology->color_with_fallback }};
                                    transition: width .3s ease, background-color .3s ease;">
                        </div>
                    </div>

                    {{-- ======================================== --}}
                    {{-- ESTADO --}}
                    {{-- ======================================== --}}
                    <div class="form-group">
                        <label>Estado</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox"
                                   class="custom-control-input"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $technology->is_active) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="is_active">
                                Tecnología Activa
                            </label>
                        </div>
                    </div>

                    {{-- ======================================== --}}
                    {{-- PREVIEW --}}
                    {{-- ======================================== --}}
                    <div class="alert alert-light border text-center mt-3">
                        <strong class="d-block mb-2">Vista Previa</strong>
                        <div id="iconPreviewWrap"
                             style="height:60px; display:flex; align-items:center; justify-content:center;">
                            {{-- Preview inicial según datos actuales --}}
                            @if($technology->icon_path)
                                <img src="{{ asset('storage/' . $technology->icon_path) }}"
                                     style="width:52px; height:52px; object-fit:contain;">
                            @elseif($technology->icon_class)
                                <i class="{{ $technology->icon_class }}"
                                   style="font-size:52px; color:{{ $technology->color_with_fallback }};"></i>
                            @elseif($technology->slug)
                                <img src="https://cdn.simpleicons.org/{{ $technology->slug }}/{{ ltrim($technology->color_with_fallback, '#') }}"
                                     alt="{{ $technology->name }}"
                                     style="width:52px; height:52px; object-fit:contain;"
                                     onerror="this.outerHTML='<span class=\'badge badge-secondary\' style=\'font-size:1.5rem;padding:.5rem 1rem;\'>{{ strtoupper(substr($technology->name, 0, 2)) }}</span>'">
                            @else
                                <span class="badge badge-secondary"
                                      style="font-size:1.5rem; padding:.5rem 1rem;">
                                    {{ strtoupper(substr($technology->name, 0, 2)) }}
                                </span>
                            @endif
                        </div>
                        <p class="mt-2 mb-0 font-weight-bold" id="namePreview">
                            {{ $technology->name }}
                        </p>
                        <small class="text-muted" id="categoryPreview">
                            {{ $technology->category->name ?? 'Sin categoría' }}
                        </small>
                    </div>

                    {{-- ======================================== --}}
                    {{-- BOTONES --}}
                    {{-- ======================================== --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.technologies.index') }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Volver
                        </a>
                        <x-adminlte-button class="btn-sm"
                                           type="submit"
                                           label="Actualizar Tecnología"
                                           theme="warning"
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
    #success-alert, #error-alert,
    #session-error-alert { transition: opacity 0.5s ease; }

    input[type="range"] { width:100%; margin-top:.5rem; }
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const nameInput      = document.querySelector('input[name="name"]');
    const slugInput      = document.querySelector('input[name="slug"]');
    const iconClassInput = document.querySelector('input[name="icon_class"]');
    const colorInput     = document.getElementById('color');
    const colorPicker    = document.getElementById('colorPicker');
    const categorySelect = document.getElementById('technologie_category_id');
    const levelSelect    = document.getElementById('proficiency_level');
    const percentRange   = document.getElementById('proficiency_percentage');
    const percentBadge   = document.getElementById('percentage-value');
    const progressBar    = document.getElementById('progress-preview');
    const namePreview    = document.getElementById('namePreview');
    const categoryPreview= document.getElementById('categoryPreview');
    const iconWrap       = document.getElementById('iconPreviewWrap');
    const fileInput      = document.getElementById('icon_path');

    // ============================================
    // COLOR PICKER ↔ INPUT TEXTO
    // ============================================
    colorPicker.addEventListener('input', function () {
        colorInput.value = this.value.toUpperCase();
        progressBar.style.backgroundColor = this.value;
        updateIconPreview();
    });

    colorInput.addEventListener('input', function () {
        if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
            colorPicker.value = this.value;
            progressBar.style.backgroundColor = this.value;
            updateIconPreview();
        }
    });

    // ============================================
    // NOMBRE → preview
    // ============================================
    nameInput?.addEventListener('input', function () {
        namePreview.textContent = this.value.trim() || 'Nombre de la Tecnología';
    });

    // ============================================
    // SLUG → preview Simple Icons
    // ============================================
    slugInput?.addEventListener('input', updateIconPreview);

    // ============================================
    // ICON CLASS → preview FontAwesome
    // ============================================
    iconClassInput?.addEventListener('input', updateIconPreview);

    // ============================================
    // PREVIEW IMAGEN SUBIDA
    // ============================================
    fileInput?.addEventListener('change', function () {
        const label = this.nextElementSibling;
        label.textContent = this.files[0]?.name || 'Seleccionar imagen';

        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                iconWrap.innerHTML = `<img src="${e.target.result}"
                    style="width:52px; height:52px; object-fit:contain;">`;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // ============================================
    // PREVIEW INTELIGENTE — múltiples fuentes
    // ============================================
    function updateIconPreview() {
        const slug      = slugInput?.value.trim()      || '';
        const iconClass = iconClassInput?.value.trim() || '';
        const color     = colorInput.value             || '#3B82F6';

        if (iconClass) {
            iconWrap.innerHTML = `<i class="${iconClass}"
                style="font-size:52px; color:${color};"></i>`;
            return;
        }

        if (slug) {
            const hexColor = color.replace('#', '');
            const src = `https://cdn.simpleicons.org/${slug}/${hexColor}`;
            const img = new Image();
            img.onload = () => {
                iconWrap.innerHTML = `<img src="${src}" alt="${slug}"
                    style="width:52px; height:52px; object-fit:contain;">`;
            };
            img.onerror = () => {
                iconWrap.innerHTML = `<span class="badge badge-secondary"
                    style="font-size:1.5rem; padding:.5rem 1rem;">
                    ${slug.substring(0, 2).toUpperCase()}
                </span>`;
            };
            img.src = src;
            return;
        }

        iconWrap.innerHTML = `<span class="badge badge-secondary"
            style="font-size:1.5rem; padding:.5rem 1rem;">??</span>`;
    }

    // ============================================
    // PORCENTAJE — RANGE SLIDER
    // ============================================
    percentRange?.addEventListener('input', function () {
        percentBadge.textContent = this.value + '%';
        progressBar.style.width  = this.value + '%';
    });

    // ============================================
    // NIVEL → SUGERIR PORCENTAJE
    // ============================================
    const levelDefaults = {
        'basico':      25,
        'intermedio':  50,
        'avanzado':    75,
    };

    levelSelect?.addEventListener('change', function () {
        const suggested = levelDefaults[this.value] ?? 50;
        percentRange.value       = suggested;
        percentBadge.textContent = suggested + '%';
        progressBar.style.width  = suggested + '%';
    });

    // ============================================
    // CATEGORÍA → PREVIEW
    // ============================================
    categorySelect?.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        categoryPreview.textContent = selected.value
            ? selected.textContent.trim()
            : 'Sin categoría';
    });

    // ============================================
    // AUTO-HIDE ALERTAS
    // ============================================
    const successAlert      = document.getElementById('success-alert');
    const errorAlert        = document.getElementById('error-alert');
    const sessionErrorAlert = document.getElementById('session-error-alert');

    if (successAlert)      setTimeout(() => successAlert.style.display = 'none', 3000);
    if (errorAlert)        setTimeout(() => errorAlert.style.display = 'none', 10000);
    if (sessionErrorAlert) setTimeout(() => sessionErrorAlert.style.display = 'none', 8000);
});
</script>
@endpush