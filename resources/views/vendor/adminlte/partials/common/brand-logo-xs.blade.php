{{-- resources/views/vendor/adminlte/partials/common/brand-logo-xs.blade.php --}}
@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

<a href="{{ $dashboard_url }}"
    @if($layoutHelper->isLayoutTopnavEnabled())
        class="navbar-brand {{ config('adminlte.classes_brand') }}"
    @else
        class="brand-link {{ config('adminlte.classes_brand') }}"
    @endif>

    {{-- ============================================ --}}
    {{-- LOGO DINÁMICO DESDE BASE DE DATOS --}}
    {{-- ============================================ --}}
    @if(portfolio('logo_path'))
        <img src="{{ logo() }}"
             alt="{{ $portfolioSettings->full_name ?? 'Admin' }}"
             class="brand-image"
             style="object-fit: contain; border-radius: 10%;">
    @else
        {{-- Fallback: Iniciales del nombre --}}
        <span class="brand-image img-circle elevation-3
                     d-flex align-items-center justify-content-center"
              style="opacity:.8; width:33px; height:33px;
                     background: {{ color('primary') }};
                     color: {{ color('text_light') }};
                     font-weight:bold; font-size:14px;">
            {{ strtoupper(substr($profileSettings->full_name ?? 'EY', 0, 2)) }}
        </span>
    @endif

    {{-- ============================================ --}}
    {{-- NOMBRE DINÁMICO DESDE BASE DE DATOS --}}
    {{-- ============================================ --}}
    <span class="brand-text font-weight-light {{ config('adminlte.classes_brand_text') }}">
        <b>{{ $profileSettings->full_name ?? 'Edwin Yoner' }}</b>
    </span>

</a>