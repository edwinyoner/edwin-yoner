@extends('layouts.main')

@section('subtitle', 'Panel Principal')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Estadísticas y resumen del portafolio')

@section('plugins.Chartjs', true)

@section('content_body')
<div class="container-fluid">

    {{-- ============================================ --}}
    {{-- ALERTAS Y NOTIFICACIONES --}}
    {{-- ============================================ --}}
    @if($contactsNeedingReply > 0 || $projectsNeedingAttention > 0 || $technologiesInactive > 0)
        <div class="row mb-3">
            @if($contactsNeedingReply > 0)
                <div class="col-md-4">
                    <x-adminlte-alert theme="warning" icon="fas fa-envelope" dismissable>
                        <strong>{{ $contactsNeedingReply }} mensaje(s) sin responder</strong><br>
                        <a href="{{ route('backend.contact-submissions.index') }}" class="alert-link">Ver mensajes</a>
                    </x-adminlte-alert>
                </div>
            @endif

            @if($projectsNeedingAttention > 0)
                <div class="col-md-4">
                    <x-adminlte-alert theme="info" icon="fas fa-exclamation-circle" dismissable>
                        <strong>{{ $projectsNeedingAttention }} proyecto(s) inactivo(s)</strong><br>
                        <a href="{{ route('backend.projects.index') }}" class="alert-link">Ver proyectos</a>
                    </x-adminlte-alert>
                </div>
            @endif

            @if($technologiesInactive > 0)
                <div class="col-md-4">
                    <x-adminlte-alert theme="secondary" icon="fas fa-code" dismissable>
                        <strong>{{ $technologiesInactive }} tecnología(s) inactiva(s)</strong><br>
                        <a href="{{ route('backend.technologies.index') }}" class="alert-link">Ver tecnologías</a>
                    </x-adminlte-alert>
                </div>
            @endif
        </div>
    @endif

    {{-- ============================================ --}}
    {{-- ESTADÍSTICAS PRINCIPALES --}}
    {{-- ============================================ --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $totalProjects }}" text="Proyectos Totales"
                icon="fas fa-project-diagram" theme="primary"
                url="{{ route('backend.projects.index') }}" url-text="Ver proyectos" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $activeProjects }}" text="Proyectos Activos"
                icon="fas fa-check-circle" theme="success"
                url="{{ route('backend.projects.index') }}" url-text="Ver detalles" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $totalTechnologies }}" text="Tecnologías"
                icon="fas fa-code" theme="warning"
                url="{{ route('backend.technologies.index') }}" url-text="Ver tecnologías" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $totalDocuments }}" text="Documentos"
                icon="fas fa-file-pdf" theme="info"
                url="{{ route('backend.documents.index') }}" url-text="Ver documentos" />
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- CONTACTO Y MÉTRICAS --}}
    {{-- ============================================ --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $totalContactSubmissions }}" text="Mensajes Recibidos"
                icon="fas fa-envelope" theme="danger"
                url="{{ route('backend.contact-submissions.index') }}" url-text="Ver mensajes" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $unreadContacts }}" text="Mensajes Sin Leer"
                icon="fas fa-envelope-open-text" theme="warning"
                url="{{ route('backend.contact-submissions.index') }}" url-text="Ver no leídos" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $totalDownloads }}" text="Descargas Totales"
                icon="fas fa-download" theme="primary"
                url="{{ route('backend.documents.index') }}" url-text="Ver estadísticas" />
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- GRÁFICOS Y DOCUMENTOS MÁS DESCARGADOS --}}
    {{-- ============================================ --}}
    <div class="row">

        {{-- Tecnologías por Categoría --}}
        <div class="col-md-4">
            <x-adminlte-card title="Tecnologías por Categoría" theme="warning" icon="fas fa-chart-bar">
                <canvas id="technologiesByCategoryChart" style="height: 250px;"></canvas>
            </x-adminlte-card>
        </div>

        {{-- Tecnologías Más Usadas en Proyectos --}}
        <div class="col-md-4">
            <x-adminlte-card title="Tecnologías Más Usadas en Proyectos" theme="success" icon="fas fa-chart-line">
                <canvas id="topTechnologiesChart" style="height: 250px;"></canvas>
            </x-adminlte-card>
        </div>

        {{-- Documentos Más Descargados --}}
        <div class="col-md-4">
            <x-adminlte-card title="Documentos Más Descargados" theme="info" icon="fas fa-trophy">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Documento</th>
                                <th>Icono</th>
                                <th class="text-right">Descargas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topDocuments as $index => $document)
                                <tr>
                                    <td>
                                        @if($index === 0)
                                            <i class="fas fa-trophy text-warning"></i>
                                        @elseif($index === 1)
                                            <i class="fas fa-medal text-secondary"></i>
                                        @elseif($index === 2)
                                            <i class="fas fa-award text-danger"></i>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('backend.documents.show', $document->id) }}">
                                            {{ Str::limit($document->title, 30) }}
                                        </a>
                                    </td>
                                    {{-- ✅ icon_class + color en lugar de document_type --}}
                                    <td>
                                        <i class="{{ $document->icon_class }}"
                                           style="color: {{ $document->color }}; font-size: 1.2rem;"></i>
                                    </td>
                                    <td class="text-right">
                                        <strong>{{ number_format($document->download_count) }}</strong>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No hay documentos con descargas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-adminlte-card>
        </div>

    </div>

    {{-- ============================================ --}}
    {{-- ÚLTIMOS REGISTROS --}}
    {{-- ============================================ --}}
    <div class="row">

        {{-- Últimos Proyectos --}}
        <div class="col-md-6">
            <x-adminlte-card title="Últimos Proyectos Creados" theme="success" icon="fas fa-list">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Año</th>  {{-- ✅ Sin categoría en projects --}}
                                <th>Estado</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestProjects as $project)
                                <tr>
                                    <td>
                                        <a href="{{ route('backend.projects.show', $project->id) }}">
                                            {{ Str::limit($project->title, 30) }}
                                        </a>
                                    </td>
                                    {{-- ✅ year en lugar de category --}}
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ $project->year ?? 'S/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $project->is_active ? 'success' : 'danger' }}">
                                            {{ $project->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $project->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No hay proyectos registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-adminlte-card>
        </div>

        {{-- Últimas Tecnologías --}}
        <div class="col-md-6">
            <x-adminlte-card title="Últimas Tecnologías Agregadas" theme="info" icon="fas fa-code">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Proyectos</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestTechnologies as $technology)
                                <tr>
                                    <td>
                                        <a href="{{ route('backend.technologies.show', $technology->id) }}">
                                            {{-- ✅ icon_path en lugar de logo_path --}}
                                            @if($technology->icon_path)
                                                <img src="{{ asset('storage/' . $technology->icon_path) }}"
                                                     alt="{{ $technology->name }}"
                                                     style="height:20px; width:20px; object-fit:contain;"
                                                     class="mr-1">
                                            @elseif(!$technology->icon_class && $technology->slug)
                                                {{-- Simple Icons CDN --}}
                                                <img src="https://cdn.simpleicons.org/{{ $technology->slug }}/{{ ltrim($technology->color ?? 'd4af37', '#') }}"
                                                     alt="{{ $technology->name }}"
                                                     style="height:20px; width:20px; object-fit:contain;"
                                                     class="mr-1">
                                            @elseif($technology->icon_class)
                                                <i class="{{ $technology->icon_class }} mr-1"
                                                   style="color: {{ $technology->color ?? 'var(--admin-primary)' }}"></i>
                                            @endif
                                            {{ $technology->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">
                                            {{ $technology->category->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info">
                                            {{ $technology->projects_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $technology->is_active ? 'success' : 'danger' }}">
                                            {{ $technology->is_active ? 'Activa' : 'Inactiva' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No hay tecnologías registradas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-adminlte-card>
        </div>

    </div>

    {{-- ============================================ --}}
    {{-- ÚLTIMOS MENSAJES DE CONTACTO --}}
    {{-- ============================================ --}}
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Últimos Mensajes de Contacto" theme="danger" icon="fas fa-envelope">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Asunto</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestContacts as $contact)
                                <tr class="{{ !$contact->is_read ? 'font-weight-bold' : '' }}">
                                    <td>
                                        @if(!$contact->is_read)
                                            <i class="fas fa-circle text-danger mr-2" style="font-size:8px;"></i>
                                        @endif
                                        {{ $contact->name }}
                                    </td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ Str::limit($contact->subject ?? '(sin asunto)', 40) }}</td>
                                    <td>
                                        @if($contact->replied_at)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Respondido
                                            </span>
                                        @elseif($contact->is_read)
                                            <span class="badge badge-warning">
                                                <i class="fas fa-envelope-open"></i> Leído
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-envelope"></i> Nuevo
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">
                                        {{ $contact->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('backend.contact-submissions.show', $contact->id) }}"
                                           class="btn btn-sm btn-info" title="Ver mensaje">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>No hay mensajes de contacto</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($totalContactSubmissions > 5)
                    <div class="text-center mt-3">
                        <a href="{{ route('backend.contact-submissions.index') }}" class="btn btn-primary">
                            Ver todos los mensajes ({{ $totalContactSubmissions }})
                        </a>
                    </div>
                @endif
            </x-adminlte-card>
        </div>
    </div>

</div>
@stop

{{-- ============================================ --}}
{{-- JAVASCRIPT --}}
{{-- ============================================ --}}
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Colores del portafolio desde PHP
        const brandColors = {
            primary:       '{{ color("primary") }}',
            secondary:     '{{ color("secondary") }}',
            tertiary:      '{{ color("tertiary") }}',
            primaryDark:   '{{ adjustBrightness(color("primary"), -20) }}',
            secondaryDark: '{{ adjustBrightness(color("secondary"), -20) }}',
        };

        function adjustClientBrightness(hex, percent) {
            hex = hex.replace('#', '');
            const num = parseInt(hex, 16);
            const amt = Math.round(2.55 * percent);
            const R = Math.min(255, Math.max(0, (num >> 16) + amt));
            const G = Math.min(255, Math.max(0, ((num >> 8) & 0x00FF) + amt));
            const B = Math.min(255, Math.max(0, (num & 0x0000FF) + amt));
            return '#' + ((1 << 24) + (R << 16) + (G << 8) + B)
                .toString(16).slice(1).toUpperCase();
        }

        // ============================================
        // GRÁFICO: TECNOLOGÍAS POR CATEGORÍA (BAR)
        // ============================================
        const catCtx = document.getElementById('technologiesByCategoryChart').getContext('2d');
        new Chart(catCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($technologiesByCategory->pluck('name')) !!},
                datasets: [{
                    label: 'Cantidad de Tecnologías',
                    data: {!! json_encode($technologiesByCategory->pluck('technologies_count')) !!},
                    backgroundColor: brandColors.tertiary,
                    borderColor: adjustClientBrightness(brandColors.tertiary, -20),
                    borderWidth: 2,
                    borderRadius: 5,
                    hoverBackgroundColor: brandColors.secondary,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, color: '#666' }, grid: { color: 'rgba(0,0,0,.05)' } },
                    x: { ticks: { color: '#666' }, grid: { display: false } }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: brandColors.primary,
                        titleColor: '#fff', bodyColor: '#fff',
                        padding: 12,
                        borderColor: brandColors.primaryDark, borderWidth: 1
                    }
                }
            }
        });

        // ============================================
        // GRÁFICO: TECNOLOGÍAS MÁS USADAS (HORIZONTAL BAR)
        // ============================================
        const techCtx = document.getElementById('topTechnologiesChart').getContext('2d');
        new Chart(techCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topTechnologies->pluck('name')) !!},
                datasets: [{
                    label: 'Proyectos usando esta tecnología',
                    data: {!! json_encode($topTechnologies->pluck('projects_count')) !!},
                    backgroundColor: brandColors.primary,
                    borderColor: brandColors.primaryDark,
                    borderWidth: 2,
                    borderRadius: 5,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { beginAtZero: true, ticks: { stepSize: 1, color: '#666' } },
                    y: { ticks: { color: '#666' } }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: brandColors.primary, padding: 12 }
                }
            }
        });

    });
</script>
@endpush