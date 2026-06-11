@extends('layouts.main')

@section('subtitle', 'Tecnologías')
@section('content_header_title', 'Tecnologías')
@section('content_header_subtitle', 'Gestión de tecnologías del portafolio')

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_body')
<div class="container-fluid">

    {{-- ============================================ --}}
    {{-- CABECERA --}}
    {{-- ============================================ --}}
    <div class="card-header text-white text-center py-3 mb-4"
         style="background: linear-gradient(135deg, {{ color('primary') }}, {{ color('secondary') }});">
        <h2 class="mb-0">GESTIÓN DE TECNOLOGÍAS</h2>
        <div class="mt-2">
            <span class="ml-2">
                <i class="fas fa-code mr-1"></i> Tecnologías
            </span>
            <span class="badge badge-light text-dark">
                {{ $technologies->count() }} tecnologías
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
                <a href="{{ route('backend.technologies.create') }}"
                   class="btn btn-sm btn-success">
                    <i class="fas fa-plus mr-1"></i> Nueva Tecnología
                </a>
            </div>

            <x-adminlte-card theme="primary" title="Tecnologías Registradas" icon="fas fa-code">

                @php
                    $heads = [
                        ['label' => 'ID',          'width' => 4],
                        ['label' => 'Icono',        'width' => 7],
                        ['label' => 'Nombre',       'width' => 15],
                        ['label' => 'Categoría',    'width' => 12],
                        ['label' => 'Slug',         'width' => 12],
                        ['label' => 'Nivel',        'width' => 10],
                        ['label' => '%',            'width' => 10],
                        ['label' => 'Proyectos',    'width' => 8],
                        ['label' => 'Estado',       'width' => 8],
                        ['label' => 'Acciones', 'no-export' => true, 'width' => 14],
                    ];

                    $config = [
                        'language'   => ['url' => asset('/assets/js/es-ES.json')],
                        'responsive' => true,
                        'autoWidth'  => false,
                        'paging'     => true,
                        'searching'  => true,
                        'ordering'   => true,
                        'pageLength' => 15,
                    ];
                @endphp

                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config"
                                      striped hoverable bordered sm>
                    @foreach($technologies as $tech)
                        <tr>
                            {{-- ID --}}
                            <td>{{ $tech->id }}</td>

                            {{-- Icono --}}
                            <td class="text-center">
                                @if($tech->icon_path)
                                    <img src="{{ asset('storage/' . $tech->icon_path) }}"
                                         alt="{{ $tech->name }}"
                                         style="width:28px; height:28px; object-fit:contain;">
                                @elseif(!$tech->icon_class && $tech->slug)
                                    <img src="https://cdn.simpleicons.org/{{ $tech->slug }}/{{ ltrim($tech->color ?? 'd4af37', '#') }}"
                                         alt="{{ $tech->name }}"
                                         style="width:28px; height:28px; object-fit:contain;">
                                @elseif($tech->icon_class)
                                    <i class="{{ $tech->icon_class }}"
                                       style="color: {{ $tech->color_with_fallback }};
                                              font-size:1.4rem;"></i>
                                @else
                                    <span class="badge badge-secondary">
                                        {{ strtoupper(substr($tech->name, 0, 2)) }}
                                    </span>
                                @endif
                            </td>

                            {{-- Nombre --}}
                            <td><strong>{{ $tech->name }}</strong></td>

                            {{-- Categoría --}}
                            <td>
                                <span class="badge badge-secondary">
                                    {{ $tech->category->name ?? '—' }}
                                </span>
                            </td>

                            {{-- Slug --}}
                            <td><code>{{ $tech->slug }}</code></td>

                            {{-- Nivel --}}
                            <td>
                                <span class="badge badge-{{ $tech->proficiency_color }}">
                                    {{ $tech->proficiency_label }}
                                </span>
                            </td>

                            {{-- Porcentaje --}}
                            <td style="min-width:80px;">
                                <div class="progress" style="height:8px;">
                                    <div class="progress-bar"
                                         style="width:{{ $tech->proficiency_percentage }}%;
                                                background-color: {{ $tech->color_with_fallback }};">
                                    </div>
                                </div>
                                <small class="text-muted">
                                    {{ $tech->proficiency_percentage }}%
                                </small>
                            </td>

                            {{-- Proyectos --}}
                            <td class="text-center">
                                <span class="badge badge-info">
                                    {{ $tech->projects_count }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="text-center">
                                <span class="badge badge-{{ $tech->status_color }}">
                                    {{ $tech->status_badge }}
                                </span>
                            </td>

                            {{-- Acciones --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center">

                                    {{-- Ver --}}
                                    <a href="{{ route('backend.technologies.show', $tech->id) }}"
                                       class="btn btn-sm btn-outline-info shadow-sm mx-1"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Editar --}}
                                    <a href="{{ route('backend.technologies.edit', $tech->id) }}"
                                       class="btn btn-sm btn-outline-primary shadow-sm mx-1"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Eliminar --}}
                                    <form id="deleteForm{{ $tech->id }}"
                                          class="d-inline" method="POST"
                                          action="{{ route('backend.technologies.destroy', $tech->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger shadow-sm mx-1"
                                                title="Eliminar"
                                                onclick="confirmDelete({{ $tech->id }}, '{{ $tech->name }}', {{ $tech->projects_count }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>

            </x-adminlte-card>

            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('backend.dashboard') }}" class="btn btn-sm btn-secondary mr-2">
                    <i class="fas fa-arrow-left mr-1"></i> Dashboard
                </a>
                <a href="{{ route('backend.technology-categories.index') }}" class="btn btn-sm btn-info">
                    <i class="fas fa-folder mr-1"></i> Ver Categorías
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
function confirmDelete(id, name, projectsCount) {
    const hasProjects = projectsCount > 0;

    Swal.fire({
        title: '¿Eliminar tecnología?',
        text: hasProjects
            ? `"${name}" está en ${projectsCount} proyecto(s). Desvincúlala primero.`
            : `¿Estás seguro de eliminar "${name}"? Esta acción no se puede revertir.`,
        icon: hasProjects ? 'error' : 'warning',
        showCancelButton: true,
        confirmButtonColor: hasProjects ? '#dc3545' : '{{ color("primary") }}',
        cancelButtonColor: '#6c757d',
        confirmButtonText: hasProjects ? 'Entendido' : 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed && !hasProjects) {
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