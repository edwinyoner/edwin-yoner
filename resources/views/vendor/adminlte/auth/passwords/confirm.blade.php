{{-- resources/views/vendor/adminlte/auth/passwords/confirm.blade.php --}}
@extends('adminlte::master')

@section('adminlte_css')
    <style>
        :root {
            --lockscreen-primary:    {{ color('primary') }};
            --lockscreen-secondary:  {{ color('secondary') }};
            --lockscreen-gradient:   linear-gradient(135deg, {{ color('primary') }} 0%, {{ color('secondary') }} 100%);
        }

        body.lockscreen {
            background: var(--lockscreen-gradient);
        }

        .lockscreen-logo a {
            color: white !important;
            text-shadow: 0 2px 4px rgba(0,0,0,.2);
        }

        .lockscreen-name {
            color: white !important;
            font-weight: 600;
            text-shadow: 0 1px 3px rgba(0,0,0,.2);
        }

        .lockscreen-credentials .form-control {
            border: 2px solid rgba(255,255,255,.3);
            background: rgba(255,255,255,.95);
        }

        .lockscreen-credentials .form-control:focus {
            border-color: white;
            box-shadow: 0 0 0 .2rem rgba(255,255,255,.3);
        }

        .lockscreen-credentials .btn {
            background: white;
            border: none;
            transition: all .3s ease;
        }

        .lockscreen-credentials .btn:hover {
            background: rgba(255,255,255,.9);
            transform: scale(1.1);
        }

        .lockscreen-credentials .btn i {
            color: var(--lockscreen-primary) !important;
        }

        .help-block {
            color: white !important;
            text-shadow: 0 1px 3px rgba(0,0,0,.2);
        }

        .text-center a {
            color: white !important;
            text-decoration: underline;
            font-weight: 500;
        }

        .text-center a:hover {
            color: rgba(255,255,255,.8) !important;
        }

        .lockscreen-subitem .text-danger {
            color: #ff6b6b !important;
            background: white;
            padding: .5rem 1rem;
            border-radius: .25rem;
            display: inline-block;
        }

        .lockscreen-image img {
            border: 3px solid white;
            box-shadow: 0 4px 8px rgba(0,0,0,.2);
        }

        .lockscreen-wrapper {
            background: rgba(255,255,255,.1);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0,0,0,.2);
        }
    </style>
    @yield('css')
@stop

@section('classes_body', 'lockscreen')

@php
    $passResetUrl = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset');
    $dashboardUrl = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home');

    if (config('adminlte.use_route_url', false)) {
        $passResetUrl = $passResetUrl ? route($passResetUrl) : '';
        $dashboardUrl = $dashboardUrl ? route($dashboardUrl) : '';
    } else {
        $passResetUrl = $passResetUrl ? url($passResetUrl) : '';
        $dashboardUrl = $dashboardUrl ? url($dashboardUrl) : '';
    }
@endphp

@section('body')
    <div class="lockscreen-wrapper">

        {{-- ============================================ --}}
        {{-- LOGO DINÁMICO DESDE BASE DE DATOS --}}
        {{-- ============================================ --}}
        <div class="lockscreen-logo">
            <a href="{{ $dashboardUrl }}">
                @if(portfolio('logo_path'))
                    <img src="{{ logo() }}"
                         alt="{{ $profileSettings->full_name ?? 'Edwin Yoner' }}"
                         height="50"
                         class="mb-2">
                    <br>
                @endif
                <b>{{ $profileSettings->full_name ?? 'Edwin Yoner' }}</b>
            </a>
        </div>

        {{-- ============================================ --}}
        {{-- NOMBRE DEL USUARIO AUTENTICADO --}}
        {{-- ============================================ --}}
        <div class="lockscreen-name">
            {{ Auth::user()->name ?? Auth::user()->email }}
        </div>

        {{-- ============================================ --}}
        {{-- LOCKSCREEN ITEM --}}
        {{-- ============================================ --}}
        <div class="lockscreen-item">
            @if(config('adminlte.usermenu_image'))
                <div class="lockscreen-image">
                    <img src="{{ Auth::user()->adminlte_image() }}"
                         alt="{{ Auth::user()->name }}">
                </div>
            @endif

            <form method="POST"
                  action="{{ route('password.confirm') }}"
                  class="lockscreen-credentials @if(!config('adminlte.usermenu_image')) ml-0 @endif">
                @csrf

                <div class="input-group">
                    <input id="password"
                           type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="{{ __('adminlte::adminlte.password') }}"
                           required
                           autofocus>

                    <div class="input-group-append">
                        <button type="submit" class="btn" title="Confirmar">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- ============================================ --}}
        {{-- ERROR DE CONTRASEÑA --}}
        {{-- ============================================ --}}
        @error('password')
            <div class="lockscreen-subitem text-center" role="alert">
                <b class="text-danger">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </b>
            </div>
        @enderror

        {{-- ============================================ --}}
        {{-- MENSAJE DE AYUDA --}}
        {{-- ============================================ --}}
        <div class="help-block text-center">
            {{ __('adminlte::adminlte.confirm_password_message') }}
        </div>

        {{-- ============================================ --}}
        {{-- ENLACES ADICIONALES --}}
        {{-- ============================================ --}}
        <div class="text-center mt-3">
            <a href="{{ $passResetUrl }}">
                <i class="fas fa-key mr-1"></i>
                {{ __('adminlte::adminlte.i_forgot_my_password') }}
            </a>
        </div>

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop