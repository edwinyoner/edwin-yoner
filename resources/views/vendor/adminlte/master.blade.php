{{-- resources/views/vendor/adminlte/master.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ============================================ --}}
    {{-- META TAGS DEL DESARROLLADOR --}}
    {{-- ============================================ --}}
    <meta name="author" content="{{ $profileSettings->full_name ?? 'Edwin Yoner Flores Rupay' }}">
    <meta name="developer" content="{{ $profileSettings->full_name ?? 'Edwin Yoner Flores Rupay' }}">
    <meta name="description" content="{{ $profileSettings->professional_title ?? 'Bach. Ingeniería De Sistemas E Informática' }}">
    @if($profileSettings?->email)
        <meta name="contact" content="{{ $profileSettings->email }}">
    @endif
    @if($profileSettings?->github_url)
        <meta name="github" content="{{ $profileSettings->github_url }}">
    @endif

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- ============================================ --}}
    {{-- TITLE DINÁMICO --}}
    {{-- ============================================ --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', $profileSettings->full_name ?? 'Edwin Yoner Flores Rupay'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets (depends on Laravel asset bundling tool) --}}
    @if(config('adminlte.enabled_laravel_mix', false))
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @else
        @switch(config('adminlte.laravel_asset_bundling', false))
            @case('mix')
                <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_css_path', 'css/app.css')) }}">
            @break

            @case('vite')
                @vite([config('adminlte.laravel_css_path', 'resources/css/app.css'), config('adminlte.laravel_js_path', 'resources/js/app.js')])
            @break

            @case('vite_js_only')
                @vite(config('adminlte.laravel_js_path', 'resources/js/app.js'))
            @break

            @default
                <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
                <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
                <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

                @if(config('adminlte.google_fonts.allowed', true))
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
                @endif
        @endswitch
    @endif

    {{-- Extra Configured Plugins Stylesheets --}}
    @include('adminlte::plugins', ['type' => 'css'])

    {{-- Livewire Styles --}}
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    {{-- ============================================ --}}
    {{-- FAVICON DINÁMICO DESDE BASE DE DATOS --}}
    {{-- ============================================ --}}
    @if(config('adminlte.use_ico_only'))
        {{-- Modo simple: solo favicon principal --}}
        <link rel="shortcut icon" href="{{ logo('favicon') }}" />
        <link rel="icon" type="image/png" href="{{ logo('favicon') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        {{-- Modo completo: favicon para todas las plataformas --}}
        <link rel="shortcut icon" href="{{ logo('favicon') }}" />
        <link rel="icon" type="image/png" href="{{ logo('favicon') }}" />
        
        {{-- Apple Touch Icons (todos apuntan al mismo logo) --}}
        <link rel="apple-touch-icon" sizes="57x57" href="{{ logo('favicon') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ logo('favicon') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ logo('favicon') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ logo('favicon') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ logo('favicon') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ logo('favicon') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ logo('favicon') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ logo('favicon') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ logo('favicon') }}">
        
        {{-- Favicons de diferentes tamaños --}}
        <link rel="icon" type="image/png" sizes="16x16" href="{{ logo('favicon') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ logo('favicon') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ logo('favicon') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ logo('favicon') }}">
        
        {{-- Windows Metro Tiles con color corporativo --}}
        <meta name="msapplication-TileColor" content="{{ color('primary') }}">
        <meta name="msapplication-TileImage" content="{{ logo('favicon') }}">
        
        {{-- Theme color para navegadores móviles --}}
        <meta name="theme-color" content="{{ color('primary') }}">
    @else
        {{-- Fallback: si no hay configuración, usar favicon dinámico simple --}}
        <link rel="shortcut icon" href="{{ logo('favicon') }}" />
        <link rel="icon" type="image/png" href="{{ logo('favicon') }}" />
        <meta name="theme-color" content="{{ color('primary') }}">
    @endif

</head>

<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts (depends on Laravel asset bundling tool) --}}
    @if(config('adminlte.enabled_laravel_mix', false))
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @else
        @switch(config('adminlte.laravel_asset_bundling', false))
            @case('mix')
                <script src="{{ mix(config('adminlte.laravel_js_path', 'js/app.js')) }}"></script>
            @break

            @case('vite')
            @case('vite_js_only')
            @break

            @default
                <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
                <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
                <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
        @endswitch
    @endif

    {{-- Extra Configured Plugins Scripts --}}
    @include('adminlte::plugins', ['type' => 'js'])

    {{-- Livewire Script --}}
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

</body>

</html>