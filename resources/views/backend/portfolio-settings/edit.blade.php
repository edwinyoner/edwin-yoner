@extends('layouts.main')

@section('subtitle', 'Editar Portafolio')
@section('content_header_title', 'Portafolio')
@section('content_header_subtitle', 'Editar configuración del portafolio')

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

    @if(session('error'))
        <x-adminlte-alert theme="danger" id="session-error-alert" title="Error" dismissable>
            {{ session('error') }}
        </x-adminlte-alert>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-12">
            <x-adminlte-card title="Editar Configuración del Portafolio" theme="primary" icon="fas fa-cogs">

                <form method="POST"
                      action="{{ route('backend.portfolio-settings.update') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- ============================================ --}}
                    {{-- TABS --}}
                    {{-- ============================================ --}}
                    <ul class="nav nav-tabs" id="portfolioTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="images-tab" data-toggle="tab" href="#images" role="tab">
                                <i class="fas fa-images mr-1"></i> Imágenes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="colors-tab" data-toggle="tab" href="#colors" role="tab">
                                <i class="fas fa-palette mr-1"></i> Colores
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab">
                                <i class="fas fa-phone mr-1"></i> Contacto
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="site-tab" data-toggle="tab" href="#site" role="tab">
                                <i class="fas fa-sliders-h mr-1"></i> Configuración Sitio
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="portfolioTabContent">

                        {{-- ============================================ --}}
                        {{-- TAB: IMÁGENES --}}
                        {{-- ============================================ --}}
                        <div class="tab-pane fade show active" id="images" role="tabpanel">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-images mr-2"></i>Identidad Visual
                            </h5>

                            {{-- Logo --}}
                            <div class="form-group">
                                <label>Logo del Portafolio</label>
                                @if($settings->logo_path)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $settings->logo_path) }}"
                                             alt="Logo actual"
                                             class="img-thumbnail"
                                             style="max-height:150px; object-fit:contain;">
                                        <small class="d-block text-muted mt-1">Logo actual</small>
                                    </div>
                                @endif
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input"
                                           name="logo_path"
                                           id="logo_path"
                                           accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml">
                                    <label class="custom-file-label" for="logo_path">
                                        Seleccionar logo
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    PNG, JPG, SVG, WEBP. Máx. 5MB. Recomendado: 300×100px.
                                </small>
                                @error('logo_path')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Favicon --}}
                            <div class="form-group">
                                <label>Favicon</label>
                                @if($settings->favicon_path)
                                    <div class="mb-2 d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $settings->favicon_path) }}"
                                             alt="Favicon actual"
                                             style="width:48px; height:48px; object-fit:contain;">
                                        <small class="text-muted ml-2">Favicon actual</small>
                                    </div>
                                @endif
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input"
                                           name="favicon_path"
                                           id="favicon_path"
                                           accept=".ico,image/png">
                                    <label class="custom-file-label" for="favicon_path">
                                        Seleccionar favicon
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    ICO o PNG. Máx. 512KB. Recomendado: 512×512px.
                                </small>
                                @error('favicon_path')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- ============================================ --}}
                        {{-- TAB: COLORES --}}
                        {{-- ============================================ --}}
                        <div class="tab-pane fade" id="colors" role="tabpanel">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-palette mr-2"></i>Paleta de Colores
                            </h5>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-1"></i>
                                <strong>Importante:</strong> Estos colores se aplican en tiempo real
                                en todo el frontend del portafolio.
                            </div>

                            <div class="row">
                                {{-- Color Primario --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="primary_color">
                                            <i class="fas fa-circle"
                                               style="color: {{ old('primary_color', $settings->primary_color) }}"></i>
                                            Color Primario <span class="text-danger">*</span>
                                        </label>
                                        <input type="color"
                                               name="primary_color"
                                               id="primary_color"
                                               class="form-control form-control-color"
                                               value="{{ old('primary_color', $settings->primary_color) }}"
                                               required
                                               style="height:50px;">
                                        <small class="text-muted">Dorado — color dominante</small>
                                        @error('primary_color')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Color Secundario --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="secondary_color">
                                            <i class="fas fa-circle"
                                               style="color: {{ old('secondary_color', $settings->secondary_color) }}"></i>
                                            Color Secundario <span class="text-danger">*</span>
                                        </label>
                                        <input type="color"
                                               name="secondary_color"
                                               id="secondary_color"
                                               class="form-control form-control-color"
                                               value="{{ old('secondary_color', $settings->secondary_color) }}"
                                               required
                                               style="height:50px;">
                                        <small class="text-muted">Complementario al primario</small>
                                        @error('secondary_color')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Color Terciario --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tertiary_color">
                                            <i class="fas fa-circle"
                                               style="color: {{ old('tertiary_color', $settings->tertiary_color) }}"></i>
                                            Color Terciario <span class="text-danger">*</span>
                                        </label>
                                        <input type="color"
                                               name="tertiary_color"
                                               id="tertiary_color"
                                               class="form-control form-control-color"
                                               value="{{ old('tertiary_color', $settings->tertiary_color) }}"
                                               required
                                               style="height:50px;">
                                        <small class="text-muted">Acentos y énfasis</small>
                                        @error('tertiary_color')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Texto Oscuro --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="text_dark_color">
                                            <i class="fas fa-circle"
                                               style="color: {{ old('text_dark_color', $settings->text_dark_color) }}"></i>
                                            Texto Oscuro <span class="text-danger">*</span>
                                        </label>
                                        <input type="color"
                                               name="text_dark_color"
                                               id="text_dark_color"
                                               class="form-control form-control-color"
                                               value="{{ old('text_dark_color', $settings->text_dark_color) }}"
                                               required
                                               style="height:50px;">
                                        <small class="text-muted">Para tema claro (fondos claros)</small>
                                        @error('text_dark_color')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Texto Claro --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="text_light_color">
                                            <i class="fas fa-circle"
                                               style="color: {{ old('text_light_color', $settings->text_light_color) }}"></i>
                                            Texto Claro <span class="text-danger">*</span>
                                        </label>
                                        <input type="color"
                                               name="text_light_color"
                                               id="text_light_color"
                                               class="form-control form-control-color"
                                               value="{{ old('text_light_color', $settings->text_light_color) }}"
                                               required
                                               style="height:50px;">
                                        <small class="text-muted">Para tema oscuro (fondos oscuros)</small>
                                        @error('text_light_color')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Preview de colores --}}
                            <div class="card bg-light mt-3">
                                <div class="card-header">
                                    <strong><i class="fas fa-eye mr-1"></i> Vista Previa</strong>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-around flex-wrap">
                                        @foreach([
                                            'primary'   => ['label' => 'Primario',   'id' => 'preview-primary'],
                                            'secondary' => ['label' => 'Secundario', 'id' => 'preview-secondary'],
                                            'tertiary'  => ['label' => 'Terciario',  'id' => 'preview-tertiary'],
                                        ] as $key => $item)
                                            <div class="text-center m-2">
                                                <div id="{{ $item['id'] }}"
                                                     style="width:80px; height:80px;
                                                            background:{{ old($key . '_color', $settings->{$key . '_color'}) }};
                                                            border-radius:8px;
                                                            box-shadow:0 2px 4px rgba(0,0,0,.1);">
                                                </div>
                                                <small class="d-block mt-2 font-weight-bold">
                                                    {{ $item['label'] }}
                                                </small>
                                            </div>
                                        @endforeach

                                        {{-- Degradado --}}
                                        <div class="text-center m-2">
                                            <div id="preview-gradient"
                                                 style="width:80px; height:80px;
                                                        background: linear-gradient(135deg,
                                                            {{ old('primary_color', $settings->primary_color) }} 0%,
                                                            {{ old('secondary_color', $settings->secondary_color) }} 100%);
                                                        border-radius:8px;
                                                        box-shadow:0 2px 4px rgba(0,0,0,.1);">
                                            </div>
                                            <small class="d-block mt-2 font-weight-bold">Degradado</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ============================================ --}}
                        {{-- TAB: CONTACTO --}}
                        {{-- ============================================ --}}
                        <div class="tab-pane fade" id="contact" role="tabpanel">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-address-card mr-2"></i>Información de Contacto
                            </h5>

                            <x-adminlte-input name="email_contact"
                                              label="Email de Contacto"
                                              type="email"
                                              placeholder="correo@ejemplo.com"
                                              value="{{ old('email_contact', $settings->email_contact) }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            <x-adminlte-input name="phone"
                                              label="Teléfono"
                                              placeholder="+51 987 654 321"
                                              value="{{ old('phone', $settings->phone) }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-phone text-primary"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            <x-adminlte-input name="whatsapp_number"
                                              label="WhatsApp (solo números con código de país)"
                                              placeholder="51987654321"
                                              value="{{ old('whatsapp_number', $settings->whatsapp_number) }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fab fa-whatsapp text-success"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        {{-- ============================================ --}}
                        {{-- TAB: CONFIGURACIÓN DEL SITIO --}}
                        {{-- ============================================ --}}
                        <div class="tab-pane fade" id="site" role="tabpanel">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-sliders-h mr-2"></i>Configuración del Sitio
                            </h5>

                            {{-- Modo Oscuro --}}
                            <div class="form-group">
                                <label>Modo Oscuro</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio"
                                               id="dark_mode_on"
                                               name="enable_dark_mode"
                                               class="custom-control-input"
                                               value="1"
                                               {{ old('enable_dark_mode', $settings->enable_dark_mode) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="dark_mode_on">
                                            <i class="fas fa-moon mr-1"></i> Habilitado
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio"
                                               id="dark_mode_off"
                                               name="enable_dark_mode"
                                               class="custom-control-input"
                                               value="0"
                                               {{ !old('enable_dark_mode', $settings->enable_dark_mode) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="dark_mode_off">
                                            <i class="fas fa-sun mr-1"></i> Deshabilitado
                                        </label>
                                    </div>
                                </div>
                                @error('enable_dark_mode')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Multiidioma --}}
                            <div class="form-group">
                                <label>Multiidioma (ES / EN)</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio"
                                               id="multilang_on"
                                               name="enable_multilang"
                                               class="custom-control-input"
                                               value="1"
                                               {{ old('enable_multilang', $settings->enable_multilang) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="multilang_on">
                                            Habilitado
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio"
                                               id="multilang_off"
                                               name="enable_multilang"
                                               class="custom-control-input"
                                               value="0"
                                               {{ !old('enable_multilang', $settings->enable_multilang) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="multilang_off">
                                            Deshabilitado
                                        </label>
                                    </div>
                                </div>
                                @error('enable_multilang')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Idioma por defecto --}}
                            <div class="form-group">
                                <label for="default_language">
                                    Idioma por Defecto <span class="text-danger">*</span>
                                </label>
                                <select name="default_language"
                                        id="default_language"
                                        class="form-control @error('default_language') is-invalid @enderror">
                                    <option value="es"
                                        {{ old('default_language', $settings->default_language) === 'es' ? 'selected' : '' }}>
                                        🇵🇪 Español
                                    </option>
                                    <option value="en"
                                        {{ old('default_language', $settings->default_language) === 'en' ? 'selected' : '' }}>
                                        🇺🇸 English
                                    </option>
                                </select>
                                @error('default_language')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                    </div>{{-- /.tab-content --}}

                    {{-- ============================================ --}}
                    {{-- BOTONES --}}
                    {{-- ============================================ --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.portfolio-settings.index') }}" class="btn btn-secondary btn-sm">
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
    // CUSTOM FILE INPUT — mostrar nombre de archivo
    // ============================================
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function () {
            const fileName = this.files[0]?.name || 'Seleccionar archivo';
            this.nextElementSibling.textContent = fileName;
        });
    });

    // ============================================
    // PREVIEW DE COLORES EN TIEMPO REAL
    // ============================================
    const colorMap = {
        primary_color:   'preview-primary',
        secondary_color: 'preview-secondary',
        tertiary_color:  'preview-tertiary',
    };

    Object.entries(colorMap).forEach(([inputId, previewId]) => {
        const input   = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        if (!input || !preview) return;

        input.addEventListener('input', function () {
            preview.style.background = this.value;
            updateGradient();
        });
    });

    function updateGradient() {
        const gradient = document.getElementById('preview-gradient');
        const primary  = document.getElementById('primary_color')?.value;
        const secondary = document.getElementById('secondary_color')?.value;
        if (gradient && primary && secondary) {
            gradient.style.background =
                `linear-gradient(135deg, ${primary} 0%, ${secondary} 100%)`;
        }
    }

});
</script>
@endpush