{{-- resources/views/frontend/pages/contact.blade.php --}}

@if(!isset($isSection))
@extends('frontend.layouts.app')
@section('title', __('messages.contact'))
@section('content')
@endif

{{-- ============================================ --}}
{{-- SECCIÓN CONTACTO --}}
{{-- ============================================ --}}
<section id="contacto" class="contact-section">

    <canvas id="contact-canvas" class="contact-section__canvas"></canvas>

    <div class="contact__container">

        {{-- ======================================== --}}
        {{-- ENCABEZADO --}}
        {{-- ======================================== --}}
        <div class="contact__header" data-aos="fade-down">
            <h1 class="contact__title">{{ __('messages.contact_me') }}</h1>
            <div class="contact__subtitle">
                <p class="contact__subtitle-text">{{ __('messages.get_in_touch') }}</p>
            </div>
        </div>

        {{-- ======================================== --}}
        {{-- ALERTAS --}}
        {{-- ======================================== --}}
        @if(session('success'))
            <div class="contact__alert contact__alert--success" data-aos="fade-up">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="contact__alert contact__alert--error" data-aos="fade-up">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- ======================================== --}}
        {{-- GRID 2 COLUMNAS --}}
        {{-- ======================================== --}}
        <div class="contact__grid">

            {{-- ---- COLUMNA IZQUIERDA: FORMULARIO ---- --}}
            <div class="contact__col contact__col--form" data-aos="fade-right">

                <div class="contact-form__card">

                    <div class="contact-form__card-header">
                        <i class="fas fa-envelope contact-form__card-icon"></i>
                        <h2 class="contact-form__card-title">{{ __('messages.send_message') }}</h2>
                    </div>

                    <form action="{{ route('frontend.contact.store') }}" method="POST"
                        class="contact-form needs-recaptcha" id="contact-form" novalidate>
                        @csrf

                        {{-- Nombre --}}
                        <div class="contact-form__group">
                            <label for="name" class="contact-form__label">
                                {{ __('messages.your_name') }}
                                <span class="contact-form__required">*</span>
                            </label>
                            <div class="contact-form__input-wrap">
                                <i class="fas fa-user contact-form__icon"></i>
                                <input type="text" id="name" name="name"
                                    class="contact-form__input @error('name') contact-form__input--invalid @enderror"
                                    value="{{ old('name') }}" placeholder="{{ __('messages.full_name') }}" required>
                            </div>
                            @error('name')
                                <span class="contact-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="contact-form__group">
                            <label for="email" class="contact-form__label">
                                {{ __('messages.your_email') }}
                                <span class="contact-form__required">*</span>
                            </label>
                            <div class="contact-form__input-wrap">
                                <i class="fas fa-envelope contact-form__icon"></i>
                                <input type="email" id="email" name="email"
                                    class="contact-form__input @error('email') contact-form__input--invalid @enderror"
                                    value="{{ old('email') }}" placeholder="correo@ejemplo.com" required>
                            </div>
                            @error('email')
                                <span class="contact-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Teléfono --}}
                        <div class="contact-form__group">
                            <label for="phone" class="contact-form__label">
                                {{ __('messages.your_phone') }}
                                <span class="contact-form__optional">({{ __('messages.optional') }})</span>
                            </label>
                            <div class="contact-form__input-wrap">
                                <i class="fas fa-phone contact-form__icon"></i>
                                <input type="tel" id="phone" name="phone"
                                    class="contact-form__input @error('phone') contact-form__input--invalid @enderror"
                                    value="{{ old('phone') }}" placeholder="+51 987 654 321">
                            </div>
                            @error('phone')
                                <span class="contact-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Asunto --}}
                        <div class="contact-form__group">
                            <label for="subject" class="contact-form__label">
                                {{ __('messages.subject') }}
                                <span class="contact-form__optional">({{ __('messages.optional') }})</span>
                            </label>
                            <div class="contact-form__input-wrap">
                                <i class="fas fa-tag contact-form__icon"></i>
                                <input type="text" id="subject" name="subject"
                                    class="contact-form__input @error('subject') contact-form__input--invalid @enderror"
                                    value="{{ old('subject') }}" placeholder="{{ __('messages.subject') }}">
                            </div>
                            @error('subject')
                                <span class="contact-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Mensaje --}}
                        <div class="contact-form__group">
                            <label for="message" class="contact-form__label">
                                {{ __('messages.message') }}
                                <span class="contact-form__required">*</span>
                            </label>
                            <div class="contact-form__input-wrap">
                                <i class="fas fa-comment-dots contact-form__icon contact-form__icon--textarea"></i>
                                <textarea id="message" name="message"
                                    class="contact-form__textarea @error('message') contact-form__input--invalid @enderror"
                                    rows="5" placeholder="{{ __('messages.write_message') }}"
                                    required>{{ old('message') }}</textarea>
                            </div>
                            @error('message')
                                <span class="contact-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="contact-form__submit">
                            <i class="fas fa-paper-plane"></i>
                            {{ __('messages.send_message') }}
                        </button>
                        <p class="contact-form__recaptcha">
                            Este sitio está protegido por reCAPTCHA y se aplican la
                            <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Política de
                                Privacidad</a>
                            y los
                            <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Términos de
                                Servicio</a>
                            de Google.
                        </p>
                        {{-- <p class="contact-form__privacy">
                            <i class="fas fa-shield-alt"></i>
                            {{ __('messages.privacy_note') }}
                        </p> --}}
                    </form>
                </div>{{-- /.contact-form__card --}}

            </div>{{-- /.contact__col--form --}}

            {{-- ---- COLUMNA DERECHA: INFO ---- --}}
            <div class="contact__col contact__col--info" data-aos="fade-left">

                {{-- Card información --}}
                <div class="info-card">
                    <div class="info-card__header">
                        <i class="fas fa-address-card info-card__header-icon"></i>
                        <h2 class="info-card__header-title">{{ __('messages.contact_info') }}</h2>
                    </div>

                    <div class="info-card__list">

                        @if($settings->email_contact)
                            <div class="info-card__item">
                                <div class="info-card__icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-card__content">
                                    <h3 class="info-card__label">{{ __('messages.email') }}</h3>
                                    <a href="mailto:{{ $settings->email_contact }}" class="info-card__value">
                                        {{ $settings->email_contact }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($settings->phone)
                            <div class="info-card__item">
                                <div class="info-card__icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-card__content">
                                    <h3 class="info-card__label">{{ __('messages.phone') }}</h3>
                                    <a href="tel:{{ $settings->phone }}" class="info-card__value">
                                        {{ $settings->phone }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($settings->whatsapp_number)
                            <div class="info-card__item">
                                <div class="info-card__icon info-card__icon--whatsapp">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div class="info-card__content">
                                    <h3 class="info-card__label">WhatsApp</h3>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number) }}"
                                        target="_blank" rel="noopener noreferrer" class="info-card__value">
                                        +{{ $settings->whatsapp_number }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($profile->city || $profile->country)
                            <div class="info-card__item">
                                <div class="info-card__icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-card__content">
                                    <h3 class="info-card__label">{{ __('messages.location') }}</h3>
                                    <p class="info-card__value">
                                        {{ implode(', ', array_filter([$profile->city, $profile->country])) }}
                                    </p>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>{{-- /.info-card --}}

                {{-- Card redes sociales --}}
                @if($socialLinks->count() > 0)
                    <div class="social-card">
                        <div class="social-card__header">
                            {{-- <i class="fas fa-share-alt social-card__header-icon"></i> --}}
                            <h2 class="social-card__header-title">{{ __('messages.follow_me') }}</h2>
                        </div>
                        <div class="social-card__links">
                            @foreach($socialLinks as $social)
                                <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer" class="social-card__link"
                                    title="{{ $social->name }}" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                                    <i class="{{ $social->icon }}"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Card disponibilidad --}}
                <div class="availability-card">
                    <div class="availability-card__header">
                        {{-- <i class="fas fa-clock availability-card__header-icon"></i> --}}
                        <h3 class="availability-card__title">{{ __('messages.available_for_work') }}</h3>
                    </div>
                    <p class="availability-card__text">{{ __('messages.open_to_opportunities') }}</p>
                    <div class="availability-card__badge">
                        <span class="availability-card__dot"></span>
                        {{ __('messages.available') }}
                    </div>
                </div>

            </div>{{-- /.contact__col--info --}}

        </div>{{-- /.contact__grid --}}

    </div>{{-- /.contact__container --}}

</section>{{-- /.contact-section --}}

@if(!isset($isSection))
    @endsection
@endif

@push('styles')
    <style>
        /* ==============================================
                       CONTACT SECTION
                       ============================================== */
        .contact-section {
            position: relative;
            min-height: 100vh;
            background-color: var(--bg-page);
            padding: 3.5rem 0;
            overflow: hidden;
        }

        .contact-section__canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        /* ==============================================
                       CONTACT CONTAINER
                       ============================================== */
        .contact__container {
            position: relative;
            z-index: 2;
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* ==============================================
                       CONTACT HEADER
                       ============================================== */
        .contact__header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .contact__title {
            font-size: 3rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: var(--text-main);
            text-shadow: 0 0 28px rgba(212, 175, 55, 0.6);
            margin-bottom: 0.9rem;
            text-transform: uppercase;
        }

        .contact__subtitle {
            display: inline-block;
            padding: 0.45rem 1.8rem;
            border-top: 2px solid var(--color-primary);
            border-bottom: 2px solid var(--color-primary);
        }

        .contact__subtitle-text {
            color: var(--color-primary);
            font-size: 1.1rem;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin: 0;
        }

        /* ==============================================
                       ALERTAS — BEM con modificadores
                       ============================================== */
        .contact__alert {
            max-width: 780px;
            margin: 0 auto 1.8rem;
            padding: 0.9rem 1.4rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.92rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            animation: contact-alert-slide 0.3s ease;
        }

        @keyframes contact-alert-slide {
            from {
                opacity: 0;
                transform: translateY(-16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .contact__alert--success {
            background: rgba(16, 185, 129, 0.18);
            border: 2px solid #10b981;
            color: #10b981;
        }

        .contact__alert--error {
            background: rgba(239, 68, 68, 0.18);
            border: 2px solid #ef4444;
            color: #ef4444;
        }

        /* ==============================================
                       CONTACT GRID — 2 columnas igual altura
                       📚 align-items:stretch hace que ambas columnas
                          tengan la misma altura. Cada columna es
                          flex-column para repartir el espacio interno.
                       ============================================== */
        .contact__grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: stretch;
            /* ← clave para igual altura */
        }

        .contact__col {
            display: flex;
            flex-direction: column;
        }

        /* ==============================================
                       CONTACT FORM CARD
                       📚 flex:1 hace que el card del formulario
                          llene toda la altura de su columna
                       ============================================== */
        .contact-form__card {
            flex: 1;
            /* ← llena la columna */
            background: var(--bg-card);
            border: 2px solid var(--color-primary);
            border-radius: 18px;
            padding: 2.2rem;
            box-shadow:
                0 0 35px rgba(212, 175, 55, 0.25),
                inset 0 0 55px rgba(0, 0, 0, 0.45);
            display: flex;
            flex-direction: column;
        }

        .contact-form__card-header {
            text-align: center;
            margin-bottom: 1.8rem;
        }

        .contact-form__card-icon {
            font-size: 2.6rem;
            color: var(--color-primary);
            margin-bottom: 0.8rem;
            display: block;
            filter: drop-shadow(0 0 12px var(--color-primary));
        }

        .contact-form__card-title {
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        /* ==============================================
                       CONTACT FORM — campos
                       ============================================== */
        .contact-form {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .contact-form__group {
            margin-bottom: 1.2rem;
        }

        .contact-form__label {
            display: block;
            font-weight: 600;
            font-size: 0.82rem;
            color: var(--text-main);
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .contact-form__required {
            color: #ef4444;
            margin-left: 0.2rem;
        }

        .contact-form__optional {
            color: var(--text-muted);
            text-transform: lowercase;
            font-weight: 400;
            font-size: 0.75rem;
        }

        .contact-form__input-wrap {
            position: relative;
        }

        .contact-form__icon {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-primary);
            font-size: 1rem;
            pointer-events: none;
        }

        .contact-form__icon--textarea {
            top: 0.85rem;
            transform: none;
        }

        .contact-form__input,
        .contact-form__textarea {
            width: 100%;
            padding: 0.65rem 0.9rem 0.65rem 2.7rem;
            background: rgba(var(--text-main-rgb), 0.05);
            border: 2px solid rgba(212, 175, 55, 0.28);
            border-radius: 8px;
            color: var(--text-main);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .contact-form__input:focus,
        .contact-form__textarea:focus {
            outline: none;
            border-color: var(--color-primary);
            background: rgba(var(--text-main-rgb), 0.08);
            box-shadow: 0 0 13px rgba(212, 175, 55, 0.28);
        }

        .contact-form__input::placeholder,
        .contact-form__textarea::placeholder {
            color: var(--text-muted);
        }

        .contact-form__input--invalid {
            border-color: #ef4444 !important;
        }

        .contact-form__textarea {
            resize: vertical;
            min-height: 130px;
        }

        .contact-form__error {
            display: block;
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.35rem;
            font-weight: 500;
        }

        .contact-form__submit {
            width: 100%;
            padding: 0.85rem 1.8rem;
            background: var(--color-primary);
            color: #000;
            border: 2px solid transparent;
            border-radius: 9px;
            font-weight: 700;
            font-size: 0.92rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: auto;
            /* empuja el botón hacia abajo */
            padding-top: 0.85rem;
        }

        .contact-form__submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 22px rgba(212, 175, 55, 0.48);
            border-color: var(--color-primary);
        }

        .contact-form__submit:active {
            transform: translateY(-1px);
        }

        .contact-form__privacy {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.75rem;
            margin-top: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
        }

        .contact-form__recaptcha {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.72rem;
            margin-top: 0.75rem;
            line-height: 1.5;
        }

        .contact-form__recaptcha a {
            color: var(--color-primary);
            text-decoration: none;
        }

        .contact-form__recaptcha a:hover {
            text-decoration: underline;
        }

        /* ==============================================
                       INFO CARD
                       📚 flex:1 → crece para igualar la columna derecha
                       ============================================== */
        .info-card {
            flex: 1;
            /* ← crece y empuja social + availability hacia abajo */
            background: var(--bg-card);
            border: 2px solid var(--color-primary);
            border-radius: 18px;
            padding: 2.2rem;
            box-shadow:
                0 0 35px rgba(212, 175, 55, 0.25),
                inset 0 0 55px rgba(0, 0, 0, 0.45);
            margin-bottom: 1.5rem;
        }

        .info-card__header {
            text-align: center;
            margin-bottom: 1.6rem;
        }

        .info-card__header-icon {
            font-size: 2.6rem;
            color: var(--color-primary);
            margin-bottom: 0.7rem;
            display: block;
            filter: drop-shadow(0 0 12px var(--color-primary));
        }

        .info-card__header-title {
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .info-card__list {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .info-card__item {
            display: flex;
            align-items: flex-start;
            gap: 0.9rem;
            padding: 0.85rem;
            background: rgba(var(--text-main-rgb), 0.05);
            border-radius: 10px;
            border: 1px solid rgba(212, 175, 55, 0.18);
            transition: all 0.3s ease;
        }

        .info-card__item:hover {
            background: rgba(var(--text-main-rgb), 0.08);
            border-color: var(--color-primary);
            transform: translateX(4px);
        }

        .info-card__icon {
            width: 44px;
            height: 44px;
            background: rgba(212, 175, 55, 0.18);
            border: 2px solid var(--color-primary);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.3rem;
            color: var(--color-primary);
        }

        .info-card__icon--whatsapp {
            background: rgba(37, 211, 102, 0.18);
            border-color: #25d366;
            color: #25d366;
        }

        .info-card__content {
            flex-grow: 1;
        }

        .info-card__label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.2rem;
        }

        .info-card__value {
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--text-main);
            word-break: break-all;
            transition: color 0.2s;
        }

        a.info-card__value:hover {
            color: var(--color-primary);
        }

        /* ==============================================
                       SOCIAL CARD
                       ============================================== */
        .social-card {
            background: var(--bg-card);
            border: 2px solid var(--color-primary);
            border-radius: 18px;
            padding: 2rem;
            box-shadow:
                0 0 35px rgba(212, 175, 55, 0.25),
                inset 0 0 55px rgba(0, 0, 0, 0.45);
            margin-bottom: 1.5rem;
        }

        .social-card__header {
            text-align: center;
            margin-bottom: 1.4rem;
        }

        .social-card__header-icon {
            font-size: 2.3rem;
            color: var(--color-primary);
            margin-bottom: 0.6rem;
            display: block;
            filter: drop-shadow(0 0 12px var(--color-primary));
        }

        .social-card__header-title {
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .social-card__links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.85rem;
        }

        .social-card__link {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(var(--text-main-rgb), 0.08);
            border: 2px solid rgba(212, 175, 55, 0.28);
            border-radius: 50%;
            color: var(--color-primary);
            font-size: 1.35rem;
            transition: all 0.3s ease;
        }

        .social-card__link:hover {
            background: var(--color-primary);
            border-color: var(--color-primary);
            color: #000;
            transform: translateY(-4px) scale(1.1);
            box-shadow: 0 8px 22px rgba(212, 175, 55, 0.4);
        }

        /* ==============================================
                       AVAILABILITY CARD
                       ============================================== */
        .availability-card {
            background: var(--bg-card);
            border: 2px solid var(--color-primary);
            border-radius: 18px;
            padding: 2rem;
            box-shadow:
                0 0 35px rgba(212, 175, 55, 0.25),
                inset 0 0 55px rgba(0, 0, 0, 0.45);
        }

        .availability-card__header {
            text-align: center;
            margin-bottom: 0.9rem;
        }

        .availability-card__header-icon {
            font-size: 2.2rem;
            color: var(--color-primary);
            margin-bottom: 0.5rem;
            display: block;
        }

        .availability-card__title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .availability-card__text {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.88rem;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .availability-card__badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.65rem 1.4rem;
            background: rgba(16, 185, 129, 0.18);
            border: 2px solid #10b981;
            border-radius: 9px;
            color: #10b981;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .availability-card__dot {
            width: 9px;
            height: 9px;
            background: #10b981;
            border-radius: 50%;
            animation: availability-pulse 2s infinite;
        }

        @keyframes availability-pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }

            50% {
                box-shadow: 0 0 0 9px rgba(16, 185, 129, 0);
            }
        }

        /* ==============================================
                       RESPONSIVE
                       ============================================== */
        @media (max-width: 1024px) {
            .contact__grid {
                grid-template-columns: 1fr;
            }

            /* En mobile la info va primero */
            .contact__col--info {
                order: -1;
            }

            .contact__col--form {
                order: 0;
            }

            /* En mobile no necesitamos flex:1 en las cards */
            .contact-form__card,
            .info-card {
                flex: none;
            }
        }

        @media (max-width: 768px) {
            .contact__title {
                font-size: 2.3rem;
            }

            .contact__subtitle-text {
                font-size: 0.95rem;
            }

            .contact-form__card,
            .info-card,
            .social-card,
            .availability-card {
                padding: 1.8rem 1.4rem;
            }

            .contact-form__card-title,
            .info-card__header-title,
            .social-card__header-title {
                font-size: 1.35rem;
            }
        }

        @media (max-width: 480px) {
            .contact__title {
                font-size: 1.9rem;
            }

            .contact-form__card,
            .info-card,
            .social-card,
            .availability-card {
                padding: 1.4rem 1rem;
            }

            .info-card__item {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .info-card__item:hover {
                transform: none;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* ==============================================
               PARTÍCULAS
               ============================================== */
            const canvas = document.getElementById('contact-canvas');
            if (!canvas) return;

            const section = document.querySelector('.contact-section');
            const ctx = canvas.getContext('2d');

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = section ? section.offsetHeight : window.innerHeight;
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            const PARTICLE_COUNT = 80;
            const MAX_DISTANCE = 150;
            const particles = [];

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.vx = (Math.random() - 0.5) * 0.5;
                    this.vy = (Math.random() - 0.5) * 0.5;
                    this.radius = 2;
                }
                update() {
                    this.x += this.vx;
                    this.y += this.vy;
                    if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
                }
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(212, 175, 55, 0.6)';
                    ctx.fill();
                }
            }

            for (let i = 0; i < PARTICLE_COUNT; i++) particles.push(new Particle());

            function connectParticles() {
                for (let i = 0; i < particles.length; i++) {
                    for (let j = i + 1; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < MAX_DISTANCE) {
                            const opacity = (1 - dist / MAX_DISTANCE) * 0.3;
                            ctx.beginPath();
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.strokeStyle = `rgba(212, 175, 55, ${opacity})`;
                            ctx.lineWidth = 1;
                            ctx.stroke();
                        }
                    }
                }
            }

            let animationId;
            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => { p.update(); p.draw(); });
                connectParticles();
                animationId = requestAnimationFrame(animate);
            }
            animate();

            document.addEventListener('turbo:before-visit', () => cancelAnimationFrame(animationId));
        });
    </script>
@endpush