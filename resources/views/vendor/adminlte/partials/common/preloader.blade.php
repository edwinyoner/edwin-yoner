{{-- resources/views/vendor/adminlte/partials/common/preeloader.blade.php --}}
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

<div class="{{ $preloaderHelper->makePreloaderClasses() }}"
     style="{{ $preloaderHelper->makePreloaderStyle() }}">

    @hasSection('preloader')
        {{-- Contenido personalizado por página --}}
        @yield('preloader')
    @else
        {{-- ============================================ --}}
        {{-- PRELOADER DINÁMICO CON LOGO DEL PORTAFOLIO --}}
        {{-- ============================================ --}}
        @if(portfolio('logo_path'))
            <img src="{{ logo() }}"
                 class="img-circle {{ config('adminlte.preloader.img.effect', 'animation__shake') }}"
                 alt="{{ $profileSettings->full_name ?? 'Edwin Yoner' }}"
                 width="{{ config('adminlte.preloader.img.width', 60) }}"
                 height="{{ config('adminlte.preloader.img.height', 60) }}"
                 style="animation-iteration-count: infinite; object-fit: contain;">
        @else
            {{-- Fallback: Iniciales animadas --}}
            <div class="{{ config('adminlte.preloader.img.effect', 'animation__shake') }}"
                 style="animation-iteration-count: infinite;
                        width: {{ config('adminlte.preloader.img.width', 60) }}px;
                        height: {{ config('adminlte.preloader.img.height', 60) }}px;
                        background: {{ color('primary') }};
                        color: {{ color('text_light') }};
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-weight: 700;
                        font-size: 1.5rem;">
                {{ strtoupper(substr($profileSettings->full_name ?? 'EY', 0, 2)) }}
            </div>
        @endif
    @endif

</div>