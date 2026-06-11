@extends('layouts.main')

@section('subtitle', 'Editar Contact')
@section('content_header_title', 'Página Contact')
@section('content_header_subtitle', 'Editar configuración de la página de Contacto')

@section('plugins.Sweetalert2', true)

@section('content_body')
<div class="container-fluid">

    @if (session('success'))
        <x-adminlte-alert theme="success" id="success-alert" title="Éxito" dismissable>
            {{ session('success') }}
        </x-adminlte-alert>
    @endif

    @if ($errors->any())
        <x-adminlte-alert theme="danger" id="error-alert" title="Errores" dismissable>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-adminlte-alert>
    @endif

    @if (session('error'))
        <x-adminlte-alert theme="danger" id="error-alert" title="Error" dismissable>
            {{ session('error') }}
        </x-adminlte-alert>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-12">
            <x-adminlte-card title="Editar Configuración de Contact" theme="warning" icon="fas fa-edit">

                <form method="POST" action="{{ route('backend.contact.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Tabs --}}
                    <ul class="nav nav-tabs" id="contactTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="hero-tab" data-toggle="tab" href="#hero" role="tab">
                                <i class="fas fa-image mr-1"></i> Hero
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="offices-tab" data-toggle="tab" href="#offices" role="tab">
                                <i class="fas fa-building mr-1"></i> Oficinas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="form-tab" data-toggle="tab" href="#form" role="tab">
                                <i class="fas fa-envelope mr-1"></i> Formulario
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cta-tab" data-toggle="tab" href="#cta" role="tab">
                                <i class="fas fa-bullhorn mr-1"></i> CTA
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab">
                                <i class="fas fa-search mr-1"></i> SEO
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="contactTabContent">
                        
                        {{-- TAB 1: HERO SECTION --}}
                        <div class="tab-pane fade show active" id="hero" role="tabpanel">
                            <h5 class="text-warning mb-3"><i class="fas fa-image mr-2"></i>Hero Section</h5>

                            {{-- Título --}}
                            <x-adminlte-input name="hero_title" label="Título Principal" 
                                placeholder="Ej: Contáctanos"
                                value="{{ old('hero_title', $settings->hero_title) }}" 
                                required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-heading text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            {{-- Subtítulo --}}
                            <x-adminlte-input name="hero_subtitle" label="Subtítulo" 
                                placeholder="Ej: Estamos aquí para ayudarte"
                                value="{{ old('hero_subtitle', $settings->hero_subtitle) }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-text-height text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            {{-- Imagen de Hero --}}
                            <div class="form-group">
                                <label>Imagen de Fondo</label>
                                @if($settings->hero_image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $settings->hero_image) }}" alt="Hero actual" class="img-thumbnail" style="max-width: 300px;">
                                        <p class="text-muted mt-1">Imagen actual</p>
                                    </div>
                                @endif
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="hero_image" name="hero_image" accept="image/*">
                                    <label class="custom-file-label" for="hero_image">Seleccionar imagen</label>
                                </div>
                                <small class="form-text text-muted">Formatos: JPG, PNG, WEBP. Máx: 2MB. Recomendado: 1920x600px</small>
                            </div>
                        </div>

                        {{-- TAB 2: OFFICES SECTION --}}
                        <div class="tab-pane fade" id="offices" role="tabpanel">
                            <h5 class="text-warning mb-3"><i class="fas fa-building mr-2"></i>Sección de Oficinas</h5>

                            {{-- Título --}}
                            <x-adminlte-input name="offices_section_title" label="Título" 
                                placeholder="Ej: Nuestras Oficinas"
                                value="{{ old('offices_section_title', $settings->offices_section_title) }}" 
                                required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-heading text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            {{-- Descripción --}}
                            <x-adminlte-textarea name="offices_section_description" label="Descripción" 
                                placeholder="Descripción de las oficinas..." rows="4">
                                {{ old('offices_section_description', $settings->offices_section_description) }}
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-align-left text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-textarea>
                        </div>

                        {{-- TAB 3: FORM SECTION --}}
                        <div class="tab-pane fade" id="form" role="tabpanel">
                            <h5 class="text-warning mb-3"><i class="fas fa-envelope mr-2"></i>Sección de Formulario</h5>

                            {{-- Título --}}
                            <x-adminlte-input name="form_section_title" label="Título" 
                                placeholder="Ej: Envíanos un Mensaje"
                                value="{{ old('form_section_title', $settings->form_section_title) }}" 
                                required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-heading text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            {{-- Descripción --}}
                            <x-adminlte-textarea name="form_section_description" label="Descripción" 
                                placeholder="Descripción del formulario..." rows="4">
                                {{ old('form_section_description', $settings->form_section_description) }}
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-align-left text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-textarea>
                        </div>

                        {{-- TAB 4: CTA --}}
                        <div class="tab-pane fade" id="cta" role="tabpanel">
                            <h5 class="text-warning mb-3"><i class="fas fa-bullhorn mr-2"></i>Call to Action</h5>

                            {{-- Título CTA --}}
                            <x-adminlte-input name="cta_title" label="Título del CTA" 
                                placeholder="Ej: ¿Tienes alguna pregunta?"
                                value="{{ old('cta_title', $settings->cta_title) }}" 
                                required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-heading text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            {{-- Descripción CTA --}}
                            <x-adminlte-textarea name="cta_description" label="Descripción" 
                                placeholder="Texto motivacional..." rows="3">
                                {{ old('cta_description', $settings->cta_description) }}
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-align-left text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-textarea>

                            {{-- Botón Texto --}}
                            <x-adminlte-input name="cta_button_text" label="Texto del Botón" 
                                placeholder="Ej: Contáctanos Ahora"
                                value="{{ old('cta_button_text', $settings->cta_button_text) }}" 
                                required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-mouse-pointer text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            {{-- Botón URL --}}
                            <x-adminlte-input name="cta_button_url" label="URL del Botón" 
                                placeholder="Ej: /contact"
                                value="{{ old('cta_button_url', $settings->cta_button_url) }}" 
                                required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-link text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            {{-- Imagen de Fondo CTA --}}
                            <div class="form-group">
                                <label>Imagen de Fondo (Opcional)</label>
                                @if($settings->cta_background_image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $settings->cta_background_image) }}" alt="CTA actual" class="img-thumbnail" style="max-width: 300px;">
                                        <p class="text-muted mt-1">Imagen actual</p>
                                    </div>
                                @endif
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="cta_background_image" name="cta_background_image" accept="image/*">
                                    <label class="custom-file-label" for="cta_background_image">Seleccionar imagen</label>
                                </div>
                                <small class="form-text text-muted">Imagen de fondo para la sección CTA</small>
                            </div>
                        </div>

                        {{-- TAB 5: SEO --}}
                        <div class="tab-pane fade" id="seo" role="tabpanel">
                            <h5 class="text-warning mb-3"><i class="fas fa-search mr-2"></i>SEO</h5>

                            {{-- Meta Title --}}
                            <x-adminlte-input name="meta_title" label="Meta Title" 
                                placeholder="Título SEO (máx 60 caracteres)"
                                value="{{ old('meta_title', $settings->meta_title) }}" 
                                maxlength="60">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-tag text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <small class="form-text text-muted">Ideal: 50-60 caracteres</small>

                            {{-- Meta Description --}}
                            <x-adminlte-textarea name="meta_description" label="Meta Description" 
                                placeholder="Descripción SEO (máx 160 caracteres)" rows="3" maxlength="160">
                                {{ old('meta_description', $settings->meta_description) }}
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-warning">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-textarea>
                            <small class="form-text text-muted">Ideal: 150-160 caracteres</small>
                        </div>

                    </div>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.contact.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Volver
                        </a>
                        <x-adminlte-button class="btn-sm" type="submit" label="Guardar Cambios" 
                            theme="warning" icon="fas fa-save" />
                    </div>

                </form>

            </x-adminlte-card>
        </div>
    </div>
</div>
@stop

@push('css')
<style>
    #success-alert, #error-alert {
        transition: opacity 0.5s ease;
    }
    #success-alert[style*="display: none"],
    #error-alert[style*="display: none"] {
        opacity: 0;
    }
</style>
@endpush

@push('js')
<script>
    // Preview de archivos
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Seleccionar imagen';
            const label = this.nextElementSibling;
            label.textContent = fileName;
        });
    });

    // Cerrar alertas
    document.addEventListener('DOMContentLoaded', function () {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => successAlert.style.display = 'none', 3000);
        }

        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            setTimeout(() => errorAlert.style.display = 'none', 10000);
        }
    });
</script>
@endpush