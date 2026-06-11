@extends('layouts.main')

@section('subtitle', 'Documentos')
@section('content_header_title', 'Documentos')
@section('content_header_subtitle', 'Gestión de documentos descargables')

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_body')
<div class="container-fluid">

    {{-- ============================================ --}}
    {{-- CABECERA --}}
    {{-- ============================================ --}}
    <div class="card-header text-white text-center py-3 mb-4"
         style="background: linear-gradient(135deg, {{ color('primary') }}, {{ color('secondary') }});">
        <h2 class="mb-0">GESTIÓN DE DOCUMENTOS</h2>
        <div class="mt-2">
            <span class="ml-2">
                <i class="fas fa-file-pdf mr-1"></i> Documentos
            </span>
            <span class="badge badge-light text-dark">
                {{ $documents->count() }} documentos
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
    <div class="row">
        <div class="col-12">

            <div class="mb-3 text-right">
                <a href="{{ route('backend.documents.create') }}"
                   class="btn btn-sm btn-success">
                    <i class="fas fa-plus mr-1"></i> Nuevo Documento
                </a>
            </div>

            <x-adminlte-card theme="primary" title="Documentos Registrados"
                             icon="fas fa-file-pdf">

                @php
                    $heads = [
                        ['label' => 'ID',          'width' => 4],
                        ['label' => 'Icono',        'width' => 6],
                        ['label' => 'Título',       'width' => 25],
                        ['label' => 'Archivo',      'width' => 18],
                        ['label' => 'Descargas',    'width' => 10],
                        ['label' => 'Estado',       'width' => 8],
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
                    @foreach($documents as $document)
                        <tr>
                            {{-- ID --}}
                            <td>{{ $document->id }}</td>

                            {{-- Icono --}}
                            <td class="text-center">
                                <i class="{{ $document->icon_with_fallback }} fa-lg"
                                   style="color: {{ $document->color_with_fallback }};"></i>
                            </td>

                            {{-- Título --}}
                            <td>
                                <strong>{{ $document->title }}</strong>
                                @if($document->description)
                                    <br>
                                    <small class="text-muted">
                                        {{ Str::limit($document->description, 60) }}
                                    </small>
                                @endif
                            </td>

                            {{-- Archivo --}}
                            <td>
                                @if($document->file_path)
                                    <div>
                                        <span class="badge badge-secondary mr-1">
                                            {{ $document->file_extension }}
                                        </span>
                                        <small class="text-muted">
                                            {{ Str::limit($document->file_name, 25) }}
                                        </small>
                                    </div>
                                    <a href="{{ $document->file_url }}"
                                       target="_blank"
                                       class="btn btn-xs btn-outline-secondary mt-1"
                                       style="padding:2px 6px; font-size:.75rem;">
                                        <i class="fas fa-eye mr-1"></i> Ver
                                    </a>
                                @else
                                    <span class="text-muted small">Sin archivo</span>
                                @endif
                            </td>

                            {{-- Descargas --}}
                            <td class="text-center">
                                <span class="badge badge-{{ $document->download_count > 0 ? 'info' : 'secondary' }}">
                                    <i class="fas fa-download mr-1"></i>
                                    {{ number_format($document->download_count) }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="text-center">
                                <span class="badge badge-{{ $document->is_active ? 'success' : 'secondary' }}">
                                    {{ $document->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>

                            {{-- Acciones --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center">

                                    {{-- Ver --}}
                                    <a href="{{ route('backend.documents.show', $document->id) }}"
                                       class="btn btn-sm btn-outline-info shadow-sm mx-1"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Editar --}}
                                    <a href="{{ route('backend.documents.edit', $document->id) }}"
                                       class="btn btn-sm btn-outline-primary shadow-sm mx-1"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Eliminar --}}
                                    <form id="deleteForm{{ $document->id }}"
                                          class="d-inline" method="POST"
                                          action="{{ route('backend.documents.destroy', $document->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger shadow-sm mx-1"
                                                title="Eliminar"
                                                onclick="confirmDelete({{ $document->id }}, '{{ addslashes($document->title) }}')">
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
                    <i class="fas fa-arrow-left mr-1"></i> Dashboard
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

function confirmDelete(id, title) {
    Swal.fire({
        title: '¿Eliminar documento?',
        html: `¿Estás seguro de eliminar <strong>"${title}"</strong>?<br>
               <small class="text-muted">El archivo PDF también será eliminado del servidor.</small>`,
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