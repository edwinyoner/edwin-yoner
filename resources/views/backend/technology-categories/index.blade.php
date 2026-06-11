@extends('layouts.main')

@section('subtitle', 'Categorías de Tecnologías')
@section('content_header_title', 'Tecnologías')
@section('content_header_subtitle', 'Gestión de categorías de tecnologías')

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_body')
<div class="container-fluid">

    {{-- ============================================ --}}
    {{-- CABECERA --}}
    {{-- ============================================ --}}
    <div class="card-header text-white text-center py-3 mb-4"
         style="background: linear-gradient(135deg, {{ color('primary') }}, {{ color('secondary') }});">
        <h2 class="mb-0">CATEGORÍAS DE TECNOLOGÍAS</h2>
        <div class="mt-2">
            <span class="ml-2">
                <i class="fas fa-folder mr-1"></i> Categorías
            </span>
            <span class="badge badge-light text-dark">
                {{ $categories->count() }} categorías
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
                <a href="{{ route('backend.technology-categories.create') }}"
                   class="btn btn-sm btn-success">
                    <i class="fas fa-plus mr-1"></i> Nueva Categoría
                </a>
            </div>

            <x-adminlte-card theme="primary" title="Categorías Registradas" icon="fas fa-folder">

                @php
                    $heads = [
                        ['label' => 'ID',           'width' => 5],
                        ['label' => 'Icono',         'width' => 8],
                        ['label' => 'Nombre',        'width' => 18],
                        ['label' => 'Nombre EN',     'width' => 15],
                        ['label' => 'Slug',          'width' => 15],
                        ['label' => 'Color',         'width' => 10],
                        ['label' => 'Tecnologías',   'width' => 10],
                        ['label' => 'Estado',        'width' => 8],
                        ['label' => 'Acciones', 'no-export' => true, 'width' => 15],
                    ];

                    $config = [
                        'language'   => ['url' => asset('/assets/js/es-ES.json')],
                        'responsive' => true,
                        'autoWidth'  => false,
                        'paging'     => true,
                        'searching'  => true,
                        'ordering'   => true,
                        'pageLength' => 10,
                    ];
                @endphp

                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config"
                                      striped hoverable bordered sm>
                    @foreach($categories as $category)
                        <tr>
                            {{-- ID --}}
                            <td>{{ $category->id }}</td>

                            {{-- Icono --}}
                            <td class="text-center">
                                <i class="{{ $category->icon_with_fallback }} fa-lg"
                                   style="color: {{ $category->color_with_fallback }};"></i>
                            </td>

                            {{-- Nombre --}}
                            <td><strong>{{ $category->name }}</strong></td>

                            {{-- Nombre EN --}}
                            <td>{{ $category->name_en ?? '—' }}</td>

                            {{-- Slug --}}
                            <td><code>{{ $category->slug }}</code></td>

                            {{-- Color --}}
                            <td class="text-center">
                                <span class="badge"
                                      style="background-color: {{ $category->color_with_fallback }};
                                             color: white;">
                                    {{ $category->color_with_fallback }}
                                </span>
                            </td>

                            {{-- Tecnologías --}}
                            <td class="text-center">
                                <a href="{{ route('backend.technology-categories.show', $category->id) }}"
                                   class="badge badge-info" title="Ver tecnologías">
                                    {{ $category->technologies_count }}
                                    <i class="fas fa-code ml-1"></i>
                                </a>
                            </td>

                            {{-- Estado --}}
                            <td class="text-center">
                                <span class="badge badge-{{ $category->status_color }}">
                                    {{ $category->status_badge }}
                                </span>
                            </td>

                            {{-- Acciones --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center">

                                    {{-- Ver --}}
                                    <a href="{{ route('backend.technology-categories.show', $category->id) }}"
                                       class="btn btn-sm btn-outline-info shadow-sm mx-1"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Editar --}}
                                    <a href="{{ route('backend.technology-categories.edit', $category->id) }}"
                                       class="btn btn-sm btn-outline-primary shadow-sm mx-1"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Eliminar --}}
                                    <form id="deleteForm{{ $category->id }}"
                                          class="d-inline" method="POST"
                                          action="{{ route('backend.technology-categories.destroy', $category->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger shadow-sm mx-1"
                                                title="Eliminar"
                                                onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}', {{ $category->technologies_count }})">
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

    // Auto-hide alertas
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
function confirmDelete(id, name, techCount) {

    // Si tiene tecnologías asociadas, advertir
    const warningText = techCount > 0
        ? `⚠️ Esta categoría tiene ${techCount} tecnología(s) asociada(s). Deberás eliminarlas primero.`
        : `¿Estás seguro de eliminar "${name}"? Esta acción no se puede revertir.`;

    Swal.fire({
        title: '¿Eliminar categoría?',
        text: warningText,
        icon: techCount > 0 ? 'error' : 'warning',
        showCancelButton: true,
        confirmButtonColor: techCount > 0 ? '#dc3545' : '{{ color("primary") }}',
        cancelButtonColor: '#6c757d',
        confirmButtonText: techCount > 0 ? 'Entendido' : 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed && techCount === 0) {
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