@extends('layouts.main')

@section('subtitle', 'Redes Sociales')
@section('content_header_title', 'Redes Sociales')
@section('content_header_subtitle', 'Gestión de enlaces a redes sociales')

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_body')
<div class="container-fluid">

    {{-- ============================================ --}}
    {{-- CABECERA --}}
    {{-- ============================================ --}}
    <div class="card-header text-white text-center py-3 mb-4"
         style="background: linear-gradient(135deg, {{ color('primary') }}, {{ color('secondary') }});">
        <h2 class="mb-0">GESTIÓN DE REDES SOCIALES</h2>
        <div class="mt-2">
            <span class="ml-2">
                <i class="fas fa-share-alt mr-1"></i> Redes Sociales
            </span>
            <span class="badge badge-light text-dark">
                {{ $socialLinks->count() }} Redes
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
    @elseif(session('error'))
        <x-adminlte-alert theme="danger" id="error-alert" title="Error" dismissable>
            {{ session('error') }}
        </x-adminlte-alert>
    @endif

    {{-- ============================================ --}}
    {{-- CONTENIDO PRINCIPAL --}}
    {{-- ============================================ --}}
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="mb-3 text-right">
                <a href="{{ route('backend.social-links.create') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus mr-2"></i> Crear Red Social
                </a>
            </div>

            <x-adminlte-card theme="primary" title="Redes Sociales Registradas" icon="fas fa-share-alt">

                @php
                    $heads = [
                        ['label' => 'ID',       'width' => 5],
                        ['label' => 'Icono',    'width' => 10],
                        ['label' => 'Nombre',   'width' => 20],
                        ['label' => 'URL',      'width' => 40],
                        ['label' => 'Color',    'width' => 10],
                        ['label' => 'Estado',   'width' => 10],
                        ['label' => 'Acciones', 'no-export' => true, 'width' => 15],
                    ];

                    $config = [
                        'language'  => ['url' => asset('/assets/js/es-ES.json')],
                        'responsive'=> true,
                        'autoWidth' => false,
                        'paging'    => true,
                        'searching' => true,
                        'ordering'  => true,
                        'pageLength'=> 10,
                    ];
                @endphp

                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config"
                                      striped hoverable bordered sm>
                    @foreach($socialLinks as $socialLink)
                        <tr>
                            {{-- ID --}}
                            <td>{{ $socialLink->id }}</td>

                            {{-- Icono --}}
                            <td class="text-center">
                                <i class="{{ $socialLink->icon_with_fallback }} fa-2x"
                                   style="color: {{ $socialLink->color_with_fallback }};"></i>
                            </td>

                            {{-- Nombre --}}
                            <td><strong>{{ $socialLink->name }}</strong></td>

                            {{-- URL --}}
                            <td>
                                <a href="{{ $socialLink->url }}" target="_blank" class="text-primary">
                                    {{ Str::limit($socialLink->url, 50) }}
                                    <i class="fas fa-external-link-alt ml-1"></i>
                                </a>
                            </td>

                            {{-- Color --}}
                            <td class="text-center">
                                <span class="badge"
                                      style="background-color: {{ $socialLink->color_with_fallback }};
                                             color: white;">
                                    {{ $socialLink->color_with_fallback }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="text-center">
                                <span class="badge badge-{{ $socialLink->status_color }}">
                                    {{ $socialLink->status_badge }}
                                </span>
                            </td>

                            {{-- Acciones --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center">

                                    {{-- Ver --}}
                                    <a href="{{ route('backend.social-links.show', $socialLink->id) }}"
                                       class="btn btn-sm btn-outline-info shadow-sm mx-1"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Editar --}}
                                    <a href="{{ route('backend.social-links.edit', $socialLink->id) }}"
                                       class="btn btn-sm btn-outline-primary shadow-sm mx-1"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Toggle Estado --}}
                                    <form class="d-inline" method="POST"
                                          action="{{ route('backend.social-links.toggle-status', $socialLink->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-{{ $socialLink->is_active ? 'warning' : 'success' }} shadow-sm mx-1"
                                                title="{{ $socialLink->is_active ? 'Desactivar' : 'Activar' }}">
                                            <i class="fas fa-{{ $socialLink->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </button>
                                    </form>

                                    {{-- Eliminar --}}
                                    <form id="deleteForm{{ $socialLink->id }}"
                                          class="d-inline" method="POST"
                                          action="{{ route('backend.social-links.destroy', $socialLink->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger shadow-sm mx-1"
                                                title="Eliminar"
                                                onclick="confirmDelete({{ $socialLink->id }}, '{{ $socialLink->name }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>

            </x-adminlte-card>

            <div class="mt-3">
                <a href="{{ route('backend.dashboard') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Volver al Dashboard
                </a>
            </div>

        </div>
    </div>
</div>
@stop

@push('css')
<style>
    #success-alert, #error-alert { transition: opacity 0.5s ease; }

    #table1 tbody tr:hover {
        background-color: rgba({{ hexToRgb(color('primary')) }}, 0.05) !important;
    }

    .badge-light {
        background-color: white !important;
        color: {{ color('text_dark') }} !important;
        font-weight: 600;
    }
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ============================================
    // AUTO-HIDE ALERTS
    // ============================================
    const successAlert = document.getElementById('success-alert');
    const errorAlert   = document.getElementById('error-alert');

    if (successAlert) {
        setTimeout(() => {
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.style.display = 'none', 500);
        }, 3000);
    }

    if (errorAlert) {
        setTimeout(() => {
            errorAlert.style.opacity = '0';
            setTimeout(() => errorAlert.style.display = 'none', 500);
        }, 5000);
    }
});

// ============================================
// CONFIRM DELETE
// ============================================
function confirmDelete(id, name) {
    Swal.fire({
        title: '¿Eliminar red social?',
        text: `¿Estás seguro de eliminar "${name}"? Esta acción no se puede revertir.`,
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
            document.getElementById('deleteForm' + id).submit();
        }
    });
}
</script>
@endpush