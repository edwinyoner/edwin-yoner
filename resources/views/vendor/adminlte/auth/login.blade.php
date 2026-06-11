{{-- resources/views/vendor/adminlte/auth/login.blade.php --}}
@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <style>
        :root {
            --color-primary:      {{ color('primary') }};
            --color-primary-dark: {{ adjustBrightness(color('primary'), -20) }};
            --color-secondary:    {{ color('secondary') }};
        }

        .login-page {
            background: linear-gradient(135deg, #f4f4f4 0%, #e0e0e0 100%);
        }

        .login-box {
            width: 400px;
            margin: 7% auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,.15);
            overflow: hidden;
            border: 1px solid #cfcacb;
        }

        /* ============================================ */
        /* LOGO */
        /* ============================================ */
        .login-logo {
            text-align: center;
            color: #ffffff;
            padding: 30px 20px 20px;
        }

        .login-logo img {
            max-height: 120px;
            max-width: 200px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .login-logo a {
            color: #ffffff;
            font-size: 20px;
            font-weight: 500;
            text-decoration: none;
            display: block;
            line-height: 1.4;
        }

        /* Fallback: iniciales cuando no hay logo */
        .login-logo-fallback {
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: bold;
            color: var(--color-primary);
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
        }

        /* ============================================ */
        /* FORMULARIO */
        /* ============================================ */
        .login-card-body {
            padding: 40px 30px;
        }

        .login-card-body .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid #cfcacb;
        }

        .login-card-body .input-group-text {
            background-color: #f8f9fa;
            border-radius: 8px 0 0 8px;
            color: var(--color-primary);
        }

        /* ============================================ */
        /* BOTÓN */
        /* ============================================ */
        .btn-login-custom {
            background: linear-gradient(145deg, var(--color-primary) 50%, var(--color-secondary) 50%);
            border: 1px solid var(--color-primary-dark);
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            transition: all .3s ease;
        }

        .btn-login-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0,0,0,.3);
            opacity: .95;
        }

        /* ============================================ */
        /* CHECKBOX RECORDARME */
        /* ============================================ */
        .icheck-primary > input:first-child:checked + label::before,
        .icheck-primary > input:first-child:checked + input[type="hidden"] + label::before {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        /* ============================================ */
        /* LINK OLVIDÉ CONTRASEÑA */
        /* ============================================ */
        .forgot-password-link {
            color: var(--color-primary);
            font-weight: 500;
            text-decoration: none;
        }

        .forgot-password-link:hover {
            text-decoration: underline;
            color: var(--color-primary-dark);
        }

        /* ============================================ */
        /* RESPONSIVE */
        /* ============================================ */
        @media (max-width: 576px) {
            .login-box {
                width: 90%;
                margin: 15% auto;
            }

            .login-logo img  { max-height: 100px; }
            .login-logo a    { font-size: 16px; }
        }
    </style>
@stop

{{-- ============================================ --}}
{{-- HEADER: LOGO + NOMBRE --}}
{{-- ============================================ --}}
@section('auth_header')
    <div class="login-logo">
        @if(portfolio('logo_path'))
            <img src="{{ logo() }}"
                 alt="{{ $profileSettings->full_name ?? 'Edwin Yoner' }}">
        @else
            <div class="login-logo-fallback">
                {{ strtoupper(substr($profileSettings->full_name ?? 'EY', 0, 2)) }}
            </div>
        @endif

        <a href="{{ url('/') }}">
            <b>{{ $profileSettings->full_name ?? 'Edwin Yoner' }}</b>
        </a>
    </div>
@stop

{{-- ============================================ --}}
{{-- BODY: FORMULARIO --}}
{{-- ============================================ --}}
@section('auth_body')
    @php
        $loginUrl     = View::getSection('login_url')          ?? config('adminlte.login_url',          'login');
        $passResetUrl = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset');

        if (config('adminlte.use_route_url', false)) {
            $loginUrl     = $loginUrl     ? route($loginUrl)     : '';
            $passResetUrl = $passResetUrl ? route($passResetUrl) : '';
        } else {
            $loginUrl     = $loginUrl     ? url($loginUrl)     : '';
            $passResetUrl = $passResetUrl ? url($passResetUrl) : '';
        }
    @endphp

    <p class="login-box-msg" style="font-size:18px; color:#4b4b4b;">
        Autenticarse para iniciar sesión
    </p>

    {{-- Errores de validación --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            @foreach($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Advertencias de sesión --}}
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('warning') }}
        </div>
    @endif

    <form action="{{ $loginUrl }}" method="POST">
        @csrf

        {{-- Email --}}
        <div class="input-group mb-3">
            <input type="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}"
                   placeholder="Correo electrónico"
                   autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Contraseña --}}
        <div class="input-group mb-3">
            <input type="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Contraseña">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Recordarme + Botón --}}
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary">
                    <input type="checkbox"
                           name="remember"
                           id="remember"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Recordarme</label>
                </div>
            </div>
            <div class="col-5">
                <button type="submit"
                        class="btn btn-block btn-login-custom"
                        style="color:white;">
                    Acceder
                </button>
            </div>
        </div>

    </form>
@stop

{{-- ============================================ --}}
{{-- FOOTER: OLVIDÉ CONTRASEÑA --}}
{{-- ============================================ --}}
@section('auth_footer')
    @if($passResetUrl)
        <p class="text-center mt-3">
            <a href="{{ $passResetUrl }}" class="forgot-password-link">
                ¿Olvidé mi contraseña?
            </a>
        </p>
    @endif
@stop