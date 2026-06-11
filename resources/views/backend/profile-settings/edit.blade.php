@extends('layouts.main')

@section('subtitle', 'Editar Perfil')
@section('content_header_title', 'Perfil')
@section('content_header_subtitle', 'Editar perfil personal')

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
        <div class="col-md-12">
            <x-adminlte-card title="Editar Perfil Personal" theme="primary" icon="fas fa-user-edit">

                <form method="POST"
                      action="{{ route('backend.profile-settings.update') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- ============================================ --}}
                    {{-- TABS --}}
                    {{-- ============================================ --}}
                    <ul class="nav nav-tabs" id="profileTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="personal-tab"
                               data-toggle="tab" href="#personal" role="tab">
                                <i class="fas fa-user mr-1"></i> Personal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="photo-tab"
                               data-toggle="tab" href="#photo" role="tab">
                                <i class="fas fa-camera mr-1"></i> Foto
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bio-tab"
                               data-toggle="tab" href="#bio" role="tab">
                                <i class="fas fa-align-left mr-1"></i> Biografía
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="location-tab"
                               data-toggle="tab" href="#location" role="tab">
                                <i class="fas fa-map-marker-alt mr-1"></i> Ubicación
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="profileTabContent">

                        {{-- ============================================ --}}
                        {{-- TAB: PERSONAL --}}
                        {{-- ============================================ --}}
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-id-card mr-2"></i>Información Personal
                            </h5>

                            <x-adminlte-input name="full_name"
                                              label="Nombre Completo"
                                              placeholder="Edwin Yoner Flores Rupay"
                                              value="{{ old('full_name', $profile->full_name) }}"
                                              required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            <x-adminlte-input name="professional_title"
                                              label="Título Profesional"
                                              placeholder="Bachiller en Ingeniería de Sistemas e Informática"
                                              value="{{ old('professional_title', $profile->professional_title) }}"
                                              required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-briefcase text-primary"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        {{-- ============================================ --}}
                        {{-- TAB: FOTO --}}
                        {{-- ============================================ --}}
                        <div class="tab-pane fade" id="photo" role="tabpanel">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-camera mr-2"></i>Foto de Perfil
                            </h5>

                            {{-- Preview foto actual --}}
                            <div class="text-center mb-4">
                                @if($profile->profile_image)
                                    <img src="{{ asset('storage/' . $profile->profile_image) }}"
                                         alt="{{ $profile->full_name }}"
                                         id="photo-preview"
                                         class="rounded-circle shadow"
                                         style="width:160px; height:160px; object-fit:cover;
                                                border:4px solid var(--admin-primary);">
                                    <small class="d-block text-muted mt-2">Foto actual</small>
                                @else
                                    <div id="photo-preview-placeholder"
                                         class="rounded-circle bg-light d-flex align-items-center
                                                justify-content-center mx-auto shadow"
                                         style="width:160px; height:160px;
                                                border:4px solid var(--admin-primary);">
                                        <i class="fas fa-user fa-5x text-muted"></i>
                                    </div>
                                    <small class="d-block text-muted mt-2">Sin foto</small>
                                @endif
                            </div>

                            {{-- Input file --}}
                            <div class="form-group">
                                <label>Seleccionar Nueva Foto</label>
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input"
                                           name="profile_image"
                                           id="profile_image"
                                           accept="image/jpeg,image/jpg,image/png,image/webp">
                                    <label class="custom-file-label" for="profile_image">
                                        Seleccionar imagen
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    JPEG, JPG, PNG o WEBP. Máx. 2MB.
                                    Recomendado: imagen cuadrada (500×500px).
                                </small>
                                @error('profile_image')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- ============================================ --}}
                        {{-- TAB: BIOGRAFÍA --}}
                        {{-- ============================================ --}}
                        <div class="tab-pane fade" id="bio" role="tabpanel">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-align-left mr-2"></i>Biografía
                            </h5>

                            {{-- Descripción Corta --}}
                            <div class="form-group">
                                <label for="bio_short">
                                    Descripción Corta
                                    <small class="text-muted">(Aparece en la sección HOME)</small>
                                </label>
                                <textarea name="bio_short"
                                          id="bio_short"
                                          class="form-control @error('bio_short') is-invalid @enderror"
                                          rows="4"
                                          maxlength="500"
                                          placeholder="Descripción breve de 2-3 líneas sobre ti...">{{ old('bio_short', $profile->bio_short) }}</textarea>
                                <small class="form-text text-muted d-flex justify-content-between">
                                    <span>Máx. 500 caracteres.</span>
                                    <span id="bio-short-count">
                                        {{ strlen(old('bio_short', $profile->bio_short ?? '')) }} / 500
                                    </span>
                                </small>
                                @error('bio_short')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Biografía Extendida --}}
                            <div class="form-group">
                                <label for="bio_long">
                                    Biografía Extendida
                                    <small class="text-muted">(Opcional — para sección About)</small>
                                </label>
                                <textarea name="bio_long"
                                          id="bio_long"
                                          class="form-control @error('bio_long') is-invalid @enderror"
                                          rows="8"
                                          maxlength="2000"
                                          placeholder="Biografía completa, experiencia, motivaciones...">{{ old('bio_long', $profile->bio_long) }}</textarea>
                                <small class="form-text text-muted d-flex justify-content-between">
                                    <span>Máx. 2000 caracteres.</span>
                                    <span id="bio-long-count">
                                        {{ strlen(old('bio_long', $profile->bio_long ?? '')) }} / 2000
                                    </span>
                                </small>
                                @error('bio_long')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- ============================================ --}}
                        {{-- TAB: UBICACIÓN --}}
                        {{-- ============================================ --}}
                        <div class="tab-pane fade" id="location" role="tabpanel">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-map-marker-alt mr-2"></i>Ubicación
                            </h5>

                            <x-adminlte-input name="city"
                                              label="Ciudad"
                                              placeholder="Lima"
                                              value="{{ old('city', $profile->city) }}"
                                              required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-city text-primary"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            <x-adminlte-input name="country"
                                              label="País"
                                              placeholder="Perú"
                                              value="{{ old('country', $profile->country) }}"
                                              required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-globe-americas text-primary"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            {{-- Preview ubicación --}}
                            <div class="alert alert-light border mt-3">
                                <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                                <strong>Vista previa:</strong>
                                <span id="location-preview">
                                    {{ implode(', ', array_filter([$profile->city, $profile->country])) ?: '—' }}
                                </span>
                            </div>
                        </div>

                    </div>{{-- /.tab-content --}}

                    {{-- ============================================ --}}
                    {{-- BOTONES --}}
                    {{-- ============================================ --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.profile-settings.index') }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Volver
                        </a>
                        <x-adminlte-button class="btn-sm"
                                           type="submit"
                                           label="Guardar Cambios"
                                           theme="primary"
                                           icon="fas fa-save" />
                    </div>

                </form>
            </x-adminlte-card>
        </div>
    </div>

</div>
@stop

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ============================================
    // AUTO-HIDE ALERTAS
    // ============================================
    const successAlert = document.getElementById('success-alert');
    if (successAlert) setTimeout(() => successAlert.style.display = 'none', 3000);

    const errorAlert = document.getElementById('error-alert');
    if (errorAlert) setTimeout(() => errorAlert.style.display = 'none', 10000);

    // ============================================
    // CUSTOM FILE INPUT — mostrar nombre + preview foto
    // ============================================
    const photoInput = document.getElementById('profile_image');
    if (photoInput) {
        photoInput.addEventListener('change', function () {
            // Actualizar label
            const label = this.nextElementSibling;
            label.textContent = this.files[0]?.name || 'Seleccionar imagen';

            // Preview en tiempo real
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Si ya hay una imagen
                    let preview = document.getElementById('photo-preview');
                    if (preview) {
                        preview.src = e.target.result;
                    } else {
                        // Si era placeholder, reemplazarlo con img
                        const placeholder = document.getElementById('photo-preview-placeholder');
                        if (placeholder) {
                            const img = document.createElement('img');
                            img.id = 'photo-preview';
                            img.className = 'rounded-circle shadow';
                            img.style = 'width:160px; height:160px; object-fit:cover; border:4px solid var(--admin-primary);';
                            img.src = e.target.result;
                            placeholder.replaceWith(img);
                        }
                    }
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // ============================================
    // CONTADOR DE CARACTERES — bio_short y bio_long
    // ============================================
    function setupCounter(textareaId, counterId, max) {
        const textarea = document.getElementById(textareaId);
        const counter  = document.getElementById(counterId);
        if (!textarea || !counter) return;

        textarea.addEventListener('input', function () {
            const len = this.value.length;
            counter.textContent = `${len} / ${max}`;
            counter.style.color = len > max * 0.9 ? '#dc3545' : '';
        });
    }

    setupCounter('bio_short', 'bio-short-count', 500);
    setupCounter('bio_long',  'bio-long-count',  2000);

    // ============================================
    // PREVIEW UBICACIÓN EN TIEMPO REAL
    // ============================================
    const cityInput    = document.querySelector('input[name="city"]');
    const countryInput = document.querySelector('input[name="country"]');
    const locationPreview = document.getElementById('location-preview');

    function updateLocationPreview() {
        if (!locationPreview) return;
        const city    = cityInput?.value.trim()    || '';
        const country = countryInput?.value.trim() || '';
        const parts   = [city, country].filter(Boolean);
        locationPreview.textContent = parts.length ? parts.join(', ') : '—';
    }

    cityInput?.addEventListener('input', updateLocationPreview);
    countryInput?.addEventListener('input', updateLocationPreview);

});
</script>
@endpush