{{-- resources/views/vendor/adminlte/auth/passwords/email.blade.php --}}
@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@php
    $passEmailUrl = View::getSection('password_email_url') ?? config('adminlte.password_email_url', 'password/email');

    if (config('adminlte.use_route_url', false)) {
        $passEmailUrl = $passEmailUrl ? route($passEmailUrl) : '';
    } else {
        $passEmailUrl = $passEmailUrl ? url($passEmailUrl) : '';
    }
@endphp

@section('auth_header', __('adminlte::adminlte.password_reset_message'))

{{-- ============================================ --}}
{{-- CSS PERSONALIZADO CON COLORES DINÁMICOS --}}
{{-- ============================================ --}}
@section('auth_css')
<style>
    /* ============================================ */
    /* COLORES CORPORATIVOS */
    /* ============================================ */
    :root {
        --auth-primary: {{ color('primary') }};
        --auth-primary-dark: {{ adjustBrightness(color('primary'), -20) }};
        --auth-primary-rgb: {{ hexToRgb(color('primary')) }};
    }

    /* ============================================ */
    /* ALERT SUCCESS CON COLORES CORPORATIVOS */
    /* ============================================ */
    .alert-success {
        background-color: rgba(var(--auth-primary-rgb), 0.1) !important;
        border-left: 4px solid var(--auth-primary) !important;
        color: var(--auth-primary-dark) !important;
        border-radius: 0.5rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success::before {
        content: '✓';
        font-weight: bold;
        font-size: 1.25rem;
        margin-right: 0.5rem;
        color: var(--auth-primary);
    }

    /* ============================================ */
    /* INPUT CON FOCUS CORPORATIVO */
    /* ============================================ */
    .form-control:focus {
        border-color: var(--auth-primary) !important;
        box-shadow: 0 0 0 0.2rem rgba(var(--auth-primary-rgb), 0.25) !important;
    }

    .input-group-text {
        background-color: rgba(var(--auth-primary-rgb), 0.05);
        border-color: #ced4da;
    }

    .form-control:focus ~ .input-group-append .input-group-text {
        border-color: var(--auth-primary);
    }

    /* ============================================ */
    /* BOTÓN MEJORADO CON GRADIENTE */
    /* ============================================ */
    .btn-primary {
        background: linear-gradient(135deg, var(--auth-primary), var(--auth-primary-dark)) !important;
        border: none !important;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(var(--auth-primary-rgb), 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(var(--auth-primary-rgb), 0.4);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    /* ============================================ */
    /* MENSAJE DE ERROR MEJORADO */
    /* ============================================ */
    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
    }

    .invalid-feedback::before {
        content: '⚠';
        margin-right: 0.5rem;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .is-invalid:focus {
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }

    /* ============================================ */
    /* HEADER DEL AUTH */
    /* ============================================ */
    .login-box-msg {
        color: #6c757d;
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }
</style>
@endsection

@section('auth_body')

    {{-- ============================================ --}}
    {{-- SUCCESS ALERT CON ANIMACIÓN --}}
    {{-- ============================================ --}}
    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    {{-- ============================================ --}}
    {{-- FORMULARIO DE RECUPERACIÓN --}}
    {{-- ============================================ --}}
    <form action="{{ route('password.email') }}" method="post">
        @csrf

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" 
                   name="email" 
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" 
                   placeholder="{{ __('adminlte::adminlte.email') }}" 
                   autofocus
                   required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Send reset link button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-paper-plane mr-2"></span>
            {{ __('adminlte::adminlte.send_password_reset_link') }}
        </button>

    </form>

@stop

{{-- ============================================ --}}
{{-- JAVASCRIPT OPCIONAL --}}
{{-- ============================================ --}}
@section('auth_js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide success alert después de 8 segundos
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }, 8000);
        }

        // Focus animation en input
        const emailInput = document.querySelector('input[name="email"]');
        if (emailInput) {
            emailInput.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            emailInput.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        }
    });
</script>
@endsection