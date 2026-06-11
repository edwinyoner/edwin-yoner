@extends('layouts.main')

@section('subtitle', 'Crear Red Social')
@section('content_header_title', 'Redes Sociales')
@section('content_header_subtitle', 'Crear nueva red social')

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
        <div class="col-md-8 col-lg-6">
            <x-adminlte-card title="Crear Nueva Red Social" theme="success" icon="fas fa-share-alt" collapsible>

                <form method="POST" action="{{ route('backend.social-links.store') }}">
                    @csrf

                    {{-- Nombre --}}
                    <x-adminlte-input name="name"
                                      label="Nombre de la Red Social"
                                      placeholder="Ej: GitHub"
                                      value="{{ old('name') }}"
                                      required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-success">
                                <i class="fas fa-tag text-white"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>

                    {{-- Icono --}}
                    <x-adminlte-input name="icon"
                                      label="Icono (FontAwesome)"
                                      placeholder="Ej: fab fa-github"
                                      value="{{ old('icon') }}"
                                      required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-success">
                                <i class="fas fa-icons text-white"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <small class="form-text text-muted mb-3">
                        Busca iconos en:
                        <a href="https://fontawesome.com/icons" target="_blank">FontAwesome</a><br>
                        Ejemplos:
                        <code>fab fa-github</code>,
                        <code>fab fa-linkedin</code>,
                        <code>fab fa-youtube</code>
                    </small>

                    {{-- URL --}}
                    <x-adminlte-input name="url"
                                      label="URL del Perfil"
                                      type="url"
                                      placeholder="https://github.com/EDWIN-YONER"
                                      value="{{ old('url') }}"
                                      required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-success">
                                <i class="fas fa-link text-white"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>

                    {{-- Color --}}
                    <div class="form-group">
                        <label>Color <small class="text-muted">(Opcional)</small></label>
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
                                   placeholder="#181717"
                                   value="{{ old('color') }}"
                                   maxlength="7">
                            <div class="input-group-append">
                                <input type="color"
                                       id="colorPicker"
                                       class="form-control"
                                       style="width:60px; padding:2px;"
                                       value="{{ old('color', '#000000') }}">
                            </div>
                        </div>
                        @error('color')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">
                            Formato: #RRGGBB — Ej: #181717 (GitHub), #0A66C2 (LinkedIn)
                        </small>
                    </div>

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
                            <label class="custom-control-label font-weight-bold" for="is_active">
                                Red Social Activa
                            </label>
                        </div>
                    </div>

                    {{-- Preview --}}
                    <div class="alert alert-light border text-center mt-3">
                        <strong class="d-block mb-2">Vista Previa</strong>
                        <i id="iconPreview" class="fas fa-share-alt fa-3x" style="color:#000000;"></i>
                        <p class="mt-2 mb-0 font-weight-bold" id="namePreview">Nombre de la Red</p>
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.social-links.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Volver
                        </a>
                        <x-adminlte-button class="btn-sm"
                                           type="submit"
                                           label="Guardar"
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
    const iconInput   = document.querySelector('input[name="icon"]');
    const nameInput   = document.querySelector('input[name="name"]');

    // Sincronizar color picker ↔ input texto
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

    // Preview icono en tiempo real
    iconInput?.addEventListener('input', function () {
        iconPreview.className = (this.value.trim() || 'fas fa-share-alt') + ' fa-3x';
    });

    // Preview nombre en tiempo real
    nameInput?.addEventListener('input', function () {
        namePreview.textContent = this.value.trim() || 'Nombre de la Red';
    });

    // Auto-hide alertas
    const successAlert = document.getElementById('success-alert');
    if (successAlert) setTimeout(() => successAlert.style.display = 'none', 3000);

    const errorAlert = document.getElementById('error-alert');
    if (errorAlert) setTimeout(() => errorAlert.style.display = 'none', 10000);
});
</script>
@endpush