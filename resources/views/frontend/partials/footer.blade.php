<footer class="footer-main">
    <div class="footer-container">
        <div class="footer-grid">

            {{-- ============================================ --}}
            {{-- COLUMNA 1: Marca + Bio + Ubicación --}}
            {{-- ============================================ --}}
            <div class="footer-col footer-col--brand">

                @if(portfolio('logo_path'))
                    <img src="{{ logo() }}" alt="{{ profile('full_name') ?? 'Edwin Yoner' }}" class="footer-logo">
                @else
                    <div class="footer-brand">
                        {{ strtoupper(profile('full_name') ?? 'Edwin Yoner') }}
                    </div>
                @endif
                @if(profile('professional_title'))
                    <p class="footer-bio">{{ profile('professional_title') }}</p>
                @endif
                @if(profile('bio_short'))
                    <p class="footer-bio">{{ profile('bio_short') }}</p>
                @endif

                @php $location = profileLocation(); @endphp
                @if($location)
                    <p class="footer-location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $location }}
                    </p>
                @endif

            </div>

            {{-- ============================================ --}}
            {{-- COLUMNA 2: Navegación --}}
            {{-- ============================================ --}}
            <div class="footer-col">
                <h3 class="footer-section-title">{{ __('messages.navigation') }}</h3>
                <ul class="footer-list">
                    <li>
                        <a href="{{ route('frontend.home') }}" class="footer-link">
                            <i class="fas fa-home"></i> {{ __('messages.home') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.skills.index') }}" class="footer-link">
                            <i class="fas fa-code"></i> {{ __('messages.skills') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.projects.index') }}" class="footer-link">
                            <i class="fas fa-project-diagram"></i> {{ __('messages.projects') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.documents.index') }}" class="footer-link">
                            <i class="fas fa-file-pdf"></i> {{ __('messages.documents') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.contact.index') }}" class="footer-link">
                            <i class="fas fa-envelope"></i> {{ __('messages.contact') }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- ============================================ --}}
            {{-- COLUMNA 3: Contacto --}}
            {{-- ============================================ --}}
            <div class="footer-col">
                <h3 class="footer-section-title">{{ __('messages.contact') }}</h3>
                <ul class="footer-list">

                    @if(portfolio('email_contact'))
                        <li>
                            <a href="mailto:{{ portfolio('email_contact') }}" class="footer-link">
                                <i class="fas fa-envelope"></i>
                                {{ portfolio('email_contact') }}
                            </a>
                        </li>
                    @endif

                    @if(portfolio('phone'))
                        <li>
                            <a href="tel:{{ portfolio('phone') }}" class="footer-link">
                                <i class="fas fa-phone"></i>
                                {{ portfolio('phone') }}
                            </a>
                        </li>
                    @endif

                    @if(portfolio('whatsapp_number'))
                        <li>
                            <a href="{{ whatsappLink() }}" target="_blank" rel="noopener noreferrer"
                                class="footer-link footer-link--whatsapp">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp
                            </a>
                        </li>
                    @endif

                </ul>
            </div>

            {{-- ============================================ --}}
            {{-- COLUMNA 4: Redes Sociales --}}
            {{-- ============================================ --}}
            <div class="footer-col">
                <h3 class="footer-section-title">{{ __('messages.follow_me') }}</h3>

                <div class="footer-social-grid">
                    @forelse($socialLinks as $social)
                        <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer" class="social-icon"
                            title="{{ $social->name }}" aria-label="{{ $social->name }}"
                            style="--social-color: {{ $social->color ?? 'var(--color-primary)' }}">
                            <i class="{{ $social->icon }}"></i>
                        </a>
                    @empty
                        <p class="footer-empty-text">{{ __('messages.connect_via_contact') }}</p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- ============================================ --}}
        {{-- COPYRIGHT --}}
        {{-- ============================================ --}}
        <div class="footer-copyright">
            <p>
                &copy; {{ date('Y') }}
                <span class="footer-copyright-name">
                    {{ profile('full_name') ?? 'Edwin Yoner Flores Rupay' }}
                </span>.
                {{ __('messages.all_rights_reserved') }}
            </p>
        </div>

    </div>
</footer>

<style>
    /* ========================================== */
    /* FOOTER PRINCIPAL                           */
    /* ========================================== */
    .footer-main {
        background-color: var(--bg-section);
        border-top: 2px solid var(--color-primary);
        padding: 4rem 0 2rem;
        color: var(--text-main);
    }

    .footer-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* ========================================== */
    /* GRID — 4 columnas → 2 → 1                 */
    /* ========================================== */
    .footer-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr 1fr;
        gap: 2.5rem;
    }

    .footer-col--brand {
        padding-right: 1rem;
    }

    /* ========================================== */
    /* MARCA                                      */
    /* ========================================== */
    .footer-logo {
        height: 3rem;
        object-fit: contain;
        margin-bottom: 1rem;
        display: block;
    }

    .footer-brand {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--color-primary);
        letter-spacing: 0.06em;
        margin-bottom: 1rem;
    }

    .footer-bio {
        font-size: 0.875rem;
        color: var(--text-muted);
        line-height: 1.65;
        margin-bottom: 0.75rem;
    }

    .footer-location {
        font-size: 0.875rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .footer-location i {
        color: var(--color-primary);
    }

    /* ========================================== */
    /* TÍTULOS DE SECCIÓN                         */
    /* ========================================== */
    .footer-section-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-main);
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--color-primary);
        display: inline-block;
        margin-bottom: 1.25rem;
    }

    /* ========================================== */
    /* LISTAS                                     */
    /* ========================================== */
    .footer-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    /* ========================================== */
    /* ENLACES                                    */
    /* ========================================== */
    .footer-link {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        color: var(--text-muted);
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .footer-link i {
        width: 1.1rem;
        color: var(--color-primary);
        flex-shrink: 0;
    }

    .footer-link:hover {
        color: var(--color-primary);
        transform: translateX(4px);
        text-decoration: none;
    }

    .footer-link--whatsapp:hover {
        color: #25d366;
    }

    .footer-link--whatsapp:hover i {
        color: #25d366;
    }

    /* ========================================== */
    /* REDES SOCIALES                             */
    /* ========================================== */
    .footer-social-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.25rem;
    }

    .social-icon {
        width: 30px;
        height: 30px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 1.2rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        background: var(--color-primary);
        color: #000;
        border-color: var(--social-color, var(--color-primary));
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(212, 175, 55, 0.35);
        text-decoration: none;
    }

    .footer-empty-text {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    /* ========================================== */
    /* COPYRIGHT                                  */
    /* ========================================== */
    .footer-copyright {
        margin-top: 3rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(212, 175, 55, 0.15);
        text-align: center;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .footer-copyright-name {
        color: var(--color-primary);
        font-weight: 600;
    }

    /* ========================================== */
    /* RESPONSIVE                                 */
    /* ========================================== */
    @media (max-width: 1024px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .footer-col--brand {
            padding-right: 0;
        }
    }

    @media (max-width: 640px) {
        .footer-main {
            padding: 3rem 0 1.5rem;
        }

        .footer-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .footer-social-grid {
            gap: 0.5rem;
        }
    }
</style>