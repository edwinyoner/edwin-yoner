@extends('layouts.main')

@section('subtitle', 'Detalle del Mensaje')
@section('content_header_title', 'Mensajes de Contacto')
@section('content_header_subtitle', 'Detalle del mensaje recibido')

@section('plugins.Sweetalert2', true)

@section('content_body')
<div class="container-fluid">

    {{-- ============================================ --}}
    {{-- CABECERA --}}
    {{-- ============================================ --}}
    <div class="card-header text-white text-center py-3 mb-4"
         style="background: linear-gradient(135deg, {{ color('primary') }}, {{ color('secondary') }});">
        <h2 class="mb-0">DETALLE DEL MENSAJE</h2>
        <div class="mt-2">
            <span class="ml-2">
                <i class="fas fa-envelope mr-1"></i> {{ $contactSubmission->name }}
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

    <div class="row">

        {{-- ============================================ --}}
        {{-- COLUMNA IZQUIERDA --}}
        {{-- ============================================ --}}
        <div class="col-lg-8">

            {{-- Remitente --}}
            <x-adminlte-card theme="primary" title="Información del Remitente"
                             icon="fas fa-user">
                <table class="table table-bordered table-sm mb-0">
                    <tbody>
                        <tr>
                            <th style="width:30%;">ID</th>
                            <td>#{{ $contactSubmission->id }}</td>
                        </tr>
                        <tr>
                            <th>Nombre</th>
                            <td><strong>{{ $contactSubmission->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                <a href="{{ $contactSubmission->mailto_link }}">
                                    {{ $contactSubmission->email }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Teléfono</th>
                            <td>
                                @if($contactSubmission->phone)
                                    <a href="tel:{{ $contactSubmission->phone }}">
                                        {{ $contactSubmission->phone }}
                                    </a>
                                    @if($contactSubmission->whatsapp_link)
                                        <a href="{{ $contactSubmission->whatsapp_link }}"
                                           target="_blank"
                                           class="btn btn-xs btn-success ml-2"
                                           style="font-size:.75rem;">
                                            <i class="fab fa-whatsapp mr-1"></i> WhatsApp
                                        </a>
                                    @endif
                                @else
                                    <span class="text-muted">No proporcionado</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha de envío</th>
                            <td>
                                {{ $contactSubmission->formatted_date }}
                                <br>
                                <small class="text-muted">{{ $contactSubmission->time_ago }}</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </x-adminlte-card>

            {{-- Asunto --}}
            <x-adminlte-card theme="primary" title="Asunto" icon="fas fa-tag">
                <p class="lead mb-0">
                    {{ $contactSubmission->subject ?? 'Sin asunto' }}
                </p>
            </x-adminlte-card>

            {{-- Mensaje --}}
            <x-adminlte-card theme="primary" title="Mensaje" icon="fas fa-comment">
                <div class="p-3 rounded" style="background: rgba(0,0,0,.04); white-space: pre-wrap;">
                    {!! nl2br(e($contactSubmission->message)) !!}
                </div>
            </x-adminlte-card>

        </div>

        {{-- ============================================ --}}
        {{-- COLUMNA DERECHA --}}
        {{-- ============================================ --}}
        <div class="col-lg-4">

            {{-- Estado --}}
            <x-adminlte-card theme="secondary" title="Estado" icon="fas fa-info-circle">
                <table class="table table-sm mb-0">
                    <tbody>
                        <tr>
                            <th>Lectura</th>
                            <td>
                                <span class="badge badge-{{ $contactSubmission->status_color }}">
                                    {{ $contactSubmission->status_badge }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Respuesta</th>
                            <td>
                                <span class="badge badge-{{ $contactSubmission->reply_status_color }}">
                                    {{ $contactSubmission->reply_status_badge }}
                                </span>
                                @if($contactSubmission->replied_at)
                                    <br>
                                    <small class="text-muted">
                                        {{ $contactSubmission->replied_at->format('d/m/Y H:i') }}
                                    </small>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </x-adminlte-card>

            {{-- Auditoría técnica --}}
            <x-adminlte-card theme="secondary" title="Datos Técnicos" icon="fas fa-shield-alt">
                <table class="table table-sm mb-0">
                    <tbody>
                        <tr>
                            <th>IP</th>
                            <td><code>{{ $contactSubmission->ip_address ?? 'N/A' }}</code></td>
                        </tr>
                        <tr>
                            <th>Navegador</th>
                            <td>{{ $contactSubmission->browser }}</td>
                        </tr>
                        <tr>
                            <th>Sistema</th>
                            <td>{{ $contactSubmission->operating_system }}</td>
                        </tr>
                        <tr>
                            <th>Dispositivo</th>
                            <td>
                                @if($contactSubmission->is_mobile)
                                    <i class="fas fa-mobile-alt mr-1"></i> Móvil
                                @else
                                    <i class="fas fa-desktop mr-1"></i> Escritorio
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </x-adminlte-card>

            {{-- Acciones --}}
            <x-adminlte-card theme="secondary" title="Acciones" icon="fas fa-cogs">

                {{-- Responder por email --}}
                <a href="{{ $contactSubmission->mailto_link }}"
                   class="btn btn-primary btn-block mb-2">
                    <i class="fas fa-reply mr-1"></i> Responder por Email
                </a>

                {{-- WhatsApp --}}
                @if($contactSubmission->whatsapp_link)
                    <a href="{{ $contactSubmission->whatsapp_link }}"
                       target="_blank"
                       class="btn btn-success btn-block mb-2">
                        <i class="fab fa-whatsapp mr-1"></i> Responder por WhatsApp
                    </a>
                @endif

                {{-- Marcar como respondido --}}
                @if(!$contactSubmission->replied_at)
                    <form method="POST"
                          action="{{ route('backend.contact-submissions.mark_replied', $contactSubmission->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-info btn-block mb-2">
                            <i class="fas fa-check mr-1"></i> Marcar como Respondido
                        </button>
                    </form>
                @endif

                {{-- Toggle leído/no leído --}}
                <form method="POST"
                      action="{{ route('backend.contact-submissions.toggle_read', $contactSubmission->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="btn btn-{{ $contactSubmission->is_read ? 'warning' : 'secondary' }} btn-block mb-2">
                        <i class="fas fa-{{ $contactSubmission->is_read ? 'envelope' : 'envelope-open' }} mr-1"></i>
                        {{ $contactSubmission->is_read ? 'Marcar como No Leído' : 'Marcar como Leído' }}
                    </button>
                </form>

                {{-- Eliminar --}}
                <form id="deleteForm" method="POST"
                      action="{{ route('backend.contact-submissions.destroy', $contactSubmission->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="btn btn-danger btn-block"
                            onclick="confirmDelete('{{ addslashes($contactSubmission->name) }}')">
                        <i class="fas fa-trash mr-1"></i> Eliminar Mensaje
                    </button>
                </form>

            </x-adminlte-card>

        </div>
    </div>

    {{-- Navegación --}}
    <div class="mt-1">
        <a href="{{ route('backend.contact-submissions.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Volver al listado
        </a>
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

function confirmDelete(name) {
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
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>
@endpush