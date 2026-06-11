@extends('layouts.main')

@section('subtitle', 'Nueva Categoría')
@section('content_header_title', 'Tecnologías')
@section('content_header_subtitle', 'Crear nueva categoría de tecnologías')

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
        <div class="col-md-8 col-lg-7">
            <x-adminlte-card title="Nueva Categoría de Tecnologías"
                             theme="success" icon="fas fa-folder-plus">

                <form method="POST"
                      action="{{ route('backend.technology-categories.store') }}">
                    @csrf

                    {{-- ======================================== --}}
                    {{-- NOMBRE --}}
                    {{-- ======================================== --}}
                    <x-adminlte-input name="name"
                                      label="Nombre (ES)"
                                      placeholder="Ej: Backend"
                                      value="{{ old('name') }}"
                                      required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-success">
                                <i class="fas fa-tag text-white"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>

                    {{-- ======================================== --}}
                    {{-- NOMBRE EN INGLÉS --}}
                    {{-- ======================================== --}}
                    <x-adminlte-input name="name_en"
                                      label="Nombre (EN)"
                                      placeholder="Ej: Backend"
                                      value="{{ old('name_en') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-success">
                                <i class="fas fa-globe text-white"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>

                    {{-- ======================================== --}}
                    {{-- SLUG --}}
                    {{-- ======================================== --}}
                    <x-adminlte-input name="slug"
                                      label="Slug"
                                      placeholder="Ej: backend"
                                      value="{{ old('slug') }}"
                                      required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-success">
                                <i class="fas fa-link text-white"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <small class="form-text text-muted mb-3">
                        Solo minúsculas, números y guiones. Se genera automáticamente desde el nombre.
                    </small>

                    {{-- ======================================== --}}
                    {{-- ICONO --}}
                    {{-- ======================================== --}}
                    <x-adminlte-input name="icon_class"
                                      label="Icono (FontAwesome)"
                                      placeholder="Ej: fas fa-server"
                                      value="{{ old('icon_class') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-success">
                                <i class="fas fa-icons text-white"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <small class="form-text text-muted mb-3">
                        Busca en <a href="https://fontawesome.com/icons" target="_blank">FontAwesome</a>.
                        Ejemplos: <code>fas fa-code</code>, <code>fas fa-server</code>, <code>fab fa-js</code>
                    </small>

                    {{-- ======================================== --}}
                    {{-- COLOR --}}
                    {{-- ======================================== --}}
                    <div class="form-group">
                        <label>Color</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success">
                                    <i class="fas fa-palette text-white"></i>
                                </span>
                            </div>
                            <input type="text"
                                   class="form-control @error('color') is-invalid @enderror"
                                   name="color"
                                   id="color"
                                   placeholder="#3B82F6"
                                   value="{{ old('color', '#3B82F6') }}"
                                   maxlength="7">
                            <div class="input-group-append">
                                <input type="color"
                                       id="colorPicker"
                                       class="form-control"
                                       value="{{ old('color', '#3B82F6') }}"
                                       style="width:60px; padding:2px;">
                            </div>
                        </div>
                        @error('color')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">Formato: #RRGGBB</small>
                    </div>

                    {{-- ======================================== --}}
                    {{-- DESCRIPCIÓN --}}
                    {{-- ======================================== --}}
                    <div class="form-group">
                        <label for="description">
                            Descripción
                            <small class="text-muted">(Opcional)</small>
                        </label>
                        <textarea name="description"
                                  id="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="3"
                                  maxlength="500"
                                  placeholder="Descripción breve de la categoría...">{{ old('description') }}</textarea>
                        <small class="form-text text-muted d-flex justify-content-between">
                            <span>Máx. 500 caracteres.</span>
                            <span id="desc-count">0 / 500</span>
                        </small>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
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
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="is_active">
                                Categoría Activa
                            </label>
                        </div>
                    </div>

                    {{-- ======================================== --}}
                    {{-- PREVIEW --}}
                    {{-- ======================================== --}}
                    <div class="alert alert-light border text-center mt-3">
                        <strong class="d-block mb-2">Vista Previa</strong>
                        <i id="iconPreview" class="fas fa-folder fa-3x" style="color:#3B82F6;"></i>
                        <p class="mt-2 mb-0 font-weight-bold" id="namePreview">Nombre de la Categoría</p>
                    </div>

                    {{-- ======================================== --}}
                    {{-- BOTONES --}}
                    {{-- ======================================== --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.technology-categories.index') }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Volver
                        </a>
                        <x-adminlte-button class="btn-sm"
                                           type="submit"
                                           label="Guardar Categoría"
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

    const colorInput  = document.getElementById('color');
    const colorPicker = document.getElementById('colorPicker');
    const iconPreview = document.getElementById('iconPreview');
    const namePreview = document.getElementById('namePreview');
    const nameInput   = document.querySelector('input[name="name"]');
    const slugInput   = document.querySelector('input[name="slug"]');
    const iconInput   = document.querySelector('input[name="icon_class"]');
    const descArea    = document.getElementById('description');
    const descCount   = document.getElementById('desc-count');

    // ============================================
    // SINCRONIZAR COLOR PICKER ↔ INPUT TEXTO
    // ============================================
    colorPicker.addEventListener('input', function () {
        colorInput.value = this.value.toUpperCase();
        iconPreview.style.color = this.value;
    });

    colorInput.addEventListener('input', function () {
        if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
            colorPicker.value = this.value;
            iconPreview.style.color = this.value;
        }
    });

    // ============================================
    // AUTO-GENERAR SLUG DESDE NOMBRE
    // ============================================
    nameInput?.addEventListener('input', function () {
        namePreview.textContent = this.value.trim() || 'Nombre de la Categoría';

        // Generar slug: minúsculas, sin tildes, guiones
        const slug = this.value
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // quitar tildes
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');

        slugInput.value = slug;
    });

    // ============================================
    // PREVIEW ICONO EN TIEMPO REAL
    // ============================================
    iconInput?.addEventListener('input', function () {
        iconPreview.className = (this.value.trim() || 'fas fa-folder') + ' fa-3x';
    });

    // ============================================
    // CONTADOR DESCRIPCIÓN
    // ============================================
    descArea?.addEventListener('input', function () {
        const len = this.value.length;
        descCount.textContent = `${len} / 500`;
        descCount.style.color = len > 450 ? '#dc3545' : '';
    });

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