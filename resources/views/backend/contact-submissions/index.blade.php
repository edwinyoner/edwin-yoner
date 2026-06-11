@extends('layouts.main')

@section('subtitle', 'Mensajes de Contacto')
@section('content_header_title', 'Contacto')
@section('content_header_subtitle', 'Mensajes recibidos')

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_body')
<div class="container-fluid">

    {{-- ============================================ --}}
    {{-- CABECERA --}}
    {{-- ============================================ --}}
    <div class="card-header text-white text-center py-3 mb-4"
         style="background: linear-gradient(135deg, {{ color('primary') }}, {{ color('secondary') }});">
        <h2 class="mb-0">MENSAJES DE CONTACTO</h2>
        <div class="mt-2">
            <span class="ml-2">
                <i class="fas fa-envelope mr-1"></i> Mensajes
            </span>
            <span class="badge badge-light text-dark">
                {{ $submissions->count() }} mensajes
            </span>
            @php $unread = $submissions->where('is_read', false)->count(); @endphp
            @if($unread > 0)
                <span class="badge badge-warning ml-1">
                    <i class="fas fa-envelope mr-1"></i> {{ $unread }} sin leer
                </span>
            @endif
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
    {{-- TABLA --}}
    {{-- ============================================ --}}
    <div class="row">
        <div class="col-12">

            <x-adminlte-card theme="primary" title="Mensajes Recibidos"
                             icon="fas fa-envelope">

                @php
                    $heads = [
                        ['label' => 'ID',        'width' => 4],
                        ['label' => 'Remitente', 'width' => 22],
                        ['label' => 'Asunto',    'width' => 22],
                        ['label' => 'Lectura',   'width' => 10],
                        ['label' => 'Respuesta', 'width' => 10],
                        ['label' => 'Fecha',     'width' => 12],
                        ['label' => 'Acciones', 'no-export' => true, 'width' => 12],
                    ];

                    $config = [
                        'language'   => ['url' => asset('/assets/js/es-ES.json')],
                        'responsive' => true,
                        'autoWidth'  => false,
                        'paging'     => true,
                        'searching'  => true,
                        'ordering'   => true,
                        'pageLength' => 10,
                        'order'      => [[0, 'desc']],
                    ];
                @endphp

                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config"
                                      striped hoverable bordered sm>
                    @foreach($submissions as $submission)
                        <tr class="{{ !$submission->is_read ? 'font-weight-bold' : '' }}">

                            {{-- ID --}}
                            <td>{{ $submission->id }}</td>

                            {{-- Remitente --}}
                            <td>
                                <div>{{ $submission->name }}</div>
                                <small class="text-muted">{{ $submission->email }}</small>
                                @if($submission->phone)
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-phone fa-xs mr-1"></i>{{ $submission->phone }}
                                    </small>
                                @endif
                            </td>

                            {{-- Asunto / Mensaje --}}
                            <td>
                                <div>{{ $submission->truncated_subject }}</div>
                                <small class="text-muted">{{ $submission->truncated_message }}</small>
                            </td>

                            {{-- Estado lectura --}}
                            <td class="text-center">
                                <span class="badge badge-{{ $submission->status_color }}">
                                    {{ $submission->status_badge }}
                                </span>
                            </td>

                            {{-- Estado respuesta --}}
                            <td class="text-center">
                                <span class="badge badge-{{ $submission->reply_status_color }}">
                                    {{ $submission->reply_status_badge }}
                                </span>
                            </td>

                            {{-- Fecha --}}
                            <td>
                                <div>{{ $submission->formatted_date }}</div>
                                <small class="text-muted">{{ $submission->time_ago }}</small>
                            </td>

                            {{-- Acciones --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center">

                                    {{-- Ver --}}
                                    <a href="{{ route('backend.contact-submissions.show', $submission->id) }}"
                                       class="btn btn-sm btn-outline-info shadow-sm mx-1"
                                       title="Ver detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Eliminar --}}
                                    <form id="deleteForm{{ $submission->id }}"
                                          class="d-inline" method="POST"
                                          action="{{ route('backend.contact-submissions.destroy', $submission->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger shadow-sm mx-1"
                                                title="Eliminar"
                                                onclick="confirmDelete({{ $submission->id }}, '{{ addslashes($submission->name) }}')">
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

function confirmDelete(id, name) {
    Swal.fire({
        title: '¿Eliminar mensaje?',
        html: `¿Estás seguro de eliminar el mensaje de <strong>"${name}"</strong>?<br>
               <small class="text-muted">Esta acción no se puede deshacer.</small>`,
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