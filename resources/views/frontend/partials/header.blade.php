<header class="header-main sticky top-0 z-50">
    <div class="header-container">

        {{-- ============================================ --}}
        {{-- FILA SUPERIOR: Título + Hamburguesa (móvil) --}}
        {{-- ============================================ --}}
        <div class="header-top-row">
            <a href="{{ route('frontend.home') }}" class="header-title" aria-label="{{ __('messages.go_home') }}">
                @if(portfolio('logo_path'))
                    <img src="{{ logo() }}" alt="Logo {{ profile('full_name') ?? 'Edwin Yoner' }}" class="header-logo">
                @else
                    {{ strtoupper(profile('full_name') ?? 'EDWIN YONER') }}
                @endif
            </a>

            {{-- Botón hamburguesa — solo visible en móvil --}}
            <button onclick="toggleMobileMenu()" class="mobile-menu-toggle" aria-label="Menú">
                <i class="fas fa-bars" id="menu-icon-open"></i>
                <i class="fas fa-times d-none" id="menu-icon-close"></i>
            </button>
        </div>

        {{-- ============================================ --}}
        {{-- NAVBAR (oculta en móvil) --}}
        {{-- ============================================ --}}
        <nav class="navbar-container">
            <div class="navbar-content">

                {{-- IZQUIERDA: Idioma --}}
                <div class="navbar-left">
                    @if($portfolioSettings?->enable_multilang)
                        <div class="lang-selector-group">
                            <form action="{{ route('language.switch') }}" method="POST" class="lang-form-inline">
                                @csrf
                                <input type="hidden" name="language" value="es">
                                <button type="submit"
                                    class="lang-btn-inline {{ app()->getLocale() == 'es' ? 'active' : '' }}"
                                    title="Español">
                                    <span class="lang-flag">🇵🇪</span>
                                    <span class="lang-text">ES</span>
                                </button>
                            </form>
                            <span class="lang-divider">/</span>
                            <form action="{{ route('language.switch') }}" method="POST" class="lang-form-inline">
                                @csrf
                                <input type="hidden" name="language" value="en">
                                <button type="submit"
                                    class="lang-btn-inline {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                    title="English">
                                    <span class="lang-flag">🇺🇸</span>
                                    <span class="lang-text">EN</span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                {{-- CENTRO: Links --}}
                <div class="navbar-center">
                    <a href="{{ route('frontend.home') }}"
                        class="nav-link {{ request()->routeIs('frontend.home') ? 'active' : '' }}">
                        {{ __('messages.home') }}
                    </a>
                    <a href="{{ route('frontend.skills.index') }}"
                        class="nav-link {{ request()->routeIs('frontend.skills.*') ? 'active' : '' }}">
                        {{ __('messages.skills') }}
                    </a>
                    <a href="{{ route('frontend.projects.index') }}"
                        class="nav-link {{ request()->routeIs('frontend.projects.*') ? 'active' : '' }}">
                        {{ __('messages.projects') }}
                    </a>
                    <a href="{{ route('frontend.documents.index') }}"
                        class="nav-link {{ request()->routeIs('frontend.documents.*') ? 'active' : '' }}">
                        {{ __('messages.documents') }}
                    </a>
                    <a href="{{ route('frontend.contact.index') }}"
                        class="nav-link {{ request()->routeIs('frontend.contact.*') ? 'active' : '' }}">
                        {{ __('messages.contact') }}
                    </a>
                </div>

                {{-- DERECHA: Tema --}}
                <div class="navbar-right">
                    @if($portfolioSettings?->enable_dark_mode)
                        <div class="theme-selector-group">
                            <button onclick="cycleTheme('light')" id="theme-btn-light" class="theme-btn-inline"
                                title="{{ __('messages.light_mode') }}">
                                <i class="fas fa-sun"></i>
                                <span class="theme-text">{{ __('messages.light_mode') }}</span>
                            </button>
                            <span class="theme-divider">/</span>
                            <button onclick="cycleTheme('dark')" id="theme-btn-dark" class="theme-btn-inline"
                                title="{{ __('messages.dark_mode') }}">
                                <i class="fas fa-moon"></i>
                                <span class="theme-text">{{ __('messages.dark_mode') }}</span>
                            </button>
                        </div>
                    @endif
                </div>

            </div>
        </nav>

        {{-- ============================================ --}}
        {{-- MENÚ MÓVIL --}}
        {{-- ============================================ --}}
        <div id="mobile-menu" class="mobile-menu">
            <div class="mobile-menu-content">

                <a href="{{ route('frontend.home') }}"
                    class="mobile-nav-link {{ request()->routeIs('frontend.home') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> {{ __('messages.home') }}
                </a>
                <a href="{{ route('frontend.skills.index') }}"
                    class="mobile-nav-link {{ request()->routeIs('frontend.skills.*') ? 'active' : '' }}">
                    <i class="fas fa-code"></i> {{ __('messages.skills') }}
                </a>
                <a href="{{ route('frontend.projects.index') }}"
                    class="mobile-nav-link {{ request()->routeIs('frontend.projects.*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase"></i> {{ __('messages.projects') }}
                </a>
                <a href="{{ route('frontend.documents.index') }}"
                    class="mobile-nav-link {{ request()->routeIs('frontend.documents.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> {{ __('messages.documents') }}
                </a>
                <a href="{{ route('frontend.contact.index') }}"
                    class="mobile-nav-link {{ request()->routeIs('frontend.contact.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> {{ __('messages.contact') }}
                </a>

                <div class="mobile-controls">

                    @if($portfolioSettings?->enable_multilang)
                        <div class="mobile-section">
                            <p class="mobile-section-title">{{ __('messages.language') }}</p>
                            <div class="mobile-btn-group">
                                <form action="{{ route('language.switch') }}" method="POST" class="mobile-form-flex">
                                    @csrf
                                    <input type="hidden" name="language" value="es">
                                    <button type="submit"
                                        class="mobile-control-btn {{ app()->getLocale() == 'es' ? 'active' : '' }}">
                                        🇵🇪 Español
                                    </button>
                                </form>
                                <form action="{{ route('language.switch') }}" method="POST" class="mobile-form-flex">
                                    @csrf
                                    <input type="hidden" name="language" value="en">
                                    <button type="submit"
                                        class="mobile-control-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}">
                                        🇺🇸 English
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if($portfolioSettings?->enable_dark_mode)
                        <div class="mobile-section">
                            <p class="mobile-section-title">{{ __('messages.theme') }}</p>
                            <div class="mobile-btn-group">
                                <button onclick="cycleTheme('light')" id="mobile-theme-light" class="mobile-control-btn">
                                    <i class="fas fa-sun"></i> Claro
                                </button>
                                <button onclick="cycleTheme('dark')" id="mobile-theme-dark" class="mobile-control-btn">
                                    <i class="fas fa-moon"></i> Oscuro
                                </button>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>

    </div>
</header>

<style>
    /* ========================================== */
    /* HEADER                                     */
    /* ========================================== */
    .header-main {
        background-color: var(--bg-section);
        border-bottom: 2px solid var(--color-primary);
        position: sticky;
        top: 0;
        z-index: 50;
    }

    .header-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* ========================================== */
    /* FILA SUPERIOR: título + hamburguesa        */
    /* ========================================== */
    .header-top-row {
        display: flex;
        align-items: center;
        justify-content: center;
        /* título centrado por defecto */
        padding: 1rem 0;
        position: relative;
    }

    .header-title {
        font-size: 2rem;
        font-weight: 500;
        color: var(--text-main);
        text-decoration: none;
        transition: all 0.3s ease;
        letter-spacing: 0.05em;
    }

    .header-title:hover {
        color: var(--color-primary);
        transform: scale(1.02);
        text-decoration: none;
    }

    .header-logo {
        height: 70px;
        object-fit: contain;
    }

    /* Hamburguesa — oculta en desktop, visible en móvil */
    .mobile-menu-toggle {
        display: none;
        background: transparent;
        border: none;
        color: var(--text-main);
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0.5rem;
        position: absolute;
        /* se posiciona a la derecha de la fila */
        right: 0;
    }

    /* ========================================== */
    /* NAVBAR (desktop)                           */
    /* ========================================== */
    .navbar-container {
        background-color: var(--bg-card);
        border-top: 1px solid var(--border-color);
    }

    .navbar-content {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        padding: 0.75rem 0;
        gap: 2rem;
    }

    /* Idioma */
    .navbar-left {
        display: flex;
        justify-content: flex-start;
    }

    .lang-selector-group {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .lang-form-inline {
        display: inline;
    }

    .lang-btn-inline {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.4rem 0.7rem;
        background: transparent;
        color: var(--text-muted);
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .lang-btn-inline:hover,
    .lang-btn-inline.active {
        color: var(--color-primary);
        background-color: var(--bg-section);
    }

    .lang-flag {
        font-size: 1.1rem;
    }

    .lang-text {
        font-size: 0.82rem;
    }

    .lang-divider,
    .theme-divider {
        color: var(--border-color);
        font-weight: 300;
    }

    /* Links centro */
    .navbar-center {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .nav-link {
        color: var(--text-main);
        font-weight: 500;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 0.4rem 0;
        position: relative;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background-color: var(--color-primary);
        transition: width 0.3s ease;
    }

    .nav-link:hover {
        color: var(--color-primary);
        text-decoration: none;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    .nav-link.active {
        color: var(--color-primary);
        font-weight: 700;
    }

    .nav-link.active::after {
        width: 100%;
    }

    /* Tema */
    .navbar-right {
        display: flex;
        justify-content: flex-end;
    }

    .theme-selector-group {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .theme-btn-inline {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.4rem 0.7rem;
        background: transparent;
        color: var(--text-muted);
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .theme-btn-inline:hover,
    .theme-btn-inline.active {
        color: var(--color-primary);
        background-color: var(--bg-section);
    }

    .theme-text {
        font-size: 0.82rem;
    }

    /* ========================================== */
    /* MENÚ MÓVIL                                 */
    /* ========================================== */
    .mobile-menu {
        background-color: var(--bg-card);
        border-top: 1px solid var(--border-color);
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.35s ease;
        display: block;
        /* nunca hidden con display, usamos max-height */
    }

    .mobile-menu.open {
        max-height: 100vh;
    }

    .mobile-menu-content {
        padding: 1rem 0;
    }

    .mobile-nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem 0;
        color: var(--text-main);
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.9rem;
        border-bottom: 1px solid var(--border-color);
        text-decoration: none;
        transition: color 0.25s;
    }

    .mobile-nav-link:hover,
    .mobile-nav-link.active {
        color: var(--color-primary);
        text-decoration: none;
    }

    .mobile-nav-link i {
        color: var(--color-primary);
        width: 1.1rem;
    }

    .mobile-controls {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 2px solid var(--border-color);
    }

    .mobile-section {
        margin-bottom: 1.25rem;
    }

    .mobile-section-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 0.6rem;
    }

    .mobile-btn-group {
        display: flex;
        gap: 0.5rem;
        justify-content: space-between;
        width: 100%;
    }

    /* Hace que los formularios de idioma se estiren por igual */
    .mobile-form-flex {
        flex: 1;
        display: flex;
    }

    /* Fuerza a TODOS los botones (tanto de idioma como de tema) a ocupar el 100% de su espacio asignado */
    .mobile-btn-group .mobile-control-btn,
    .mobile-form-flex .mobile-control-btn {
        flex: 1;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        /* Espaciado entre la bandera/icono y el texto */
        padding: 0.75rem;
        /* Ajusta el relleno para que se vean idénticos */
        box-sizing: border-box;
    }

    .mobile-control-btn {
        flex: 1;
        padding: 0.7rem 0.5rem;
        background: var(--bg-section);
        color: var(--text-main);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.25s;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }

    .mobile-control-btn:hover,
    .mobile-control-btn.active {
        background: var(--color-primary);
        color: #000;
        border-color: var(--color-primary);
    }

    .mobile-menu-toggle .d-none {
        display: none !important;
    }

    /* ========================================== */
    /* RESPONSIVE                                 */
    /* ========================================== */
    @media (max-width: 1024px) {

        /* Ocultar navbar desktop */
        .navbar-container {
            display: none;
        }

        /* Mostrar hamburguesa */
        .mobile-menu-toggle {
            display: block;
        }

        /* Título más pequeño */
        .header-title {
            font-size: 1.5rem;
        }

        .header-logo {
            height: 52px;
        }
    }

    @media (max-width: 480px) {
        .header-container {
            padding: 0 1rem;
        }

        .header-title {
            font-size: 1.2rem;
        }
    }
</style>

<script>
    /* ========================================== */
    /* MENÚ MÓVIL                                 */
    /* ========================================== */
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');

        // Alterna la clase 'open' en el menú
        menu.classList.toggle('open');

        // Controla la visibilidad de los iconos alternando una clase de control
        if (menu.classList.contains('open')) {
            iconOpen.classList.add('d-none');
            iconClose.classList.remove('d-none');
        } else {
            iconOpen.classList.remove('d-none');
            iconClose.classList.add('d-none');
        }
    }

    /* ========================================== */
    /* TEMAS                                      */
    /* ========================================== */
    function cycleTheme(selectedTheme) {
        const html = document.documentElement;

        if (selectedTheme === 'system') {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            html.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
        } else {
            html.setAttribute('data-theme', selectedTheme);
        }

        localStorage.setItem('theme', selectedTheme);
        updateThemeButtons(selectedTheme);
    }

    function updateThemeButtons(theme) {
        ['theme-btn-light', 'theme-btn-dark',
            'mobile-theme-light', 'mobile-theme-dark'].forEach(id => {
                document.getElementById(id)?.classList.remove('active');
            });

        if (theme === 'light') {
            document.getElementById('theme-btn-light')?.classList.add('active');
            document.getElementById('mobile-theme-light')?.classList.add('active');
        } else if (theme === 'dark') {
            document.getElementById('theme-btn-dark')?.classList.add('active');
            document.getElementById('mobile-theme-dark')?.classList.add('active');
        }
    }

    // Cierra el menú móvil si se hace clic fuera de él
    document.addEventListener('click', function (event) {
        const menu = document.getElementById('mobile-menu');
        const toggleBtn = document.querySelector('.mobile-menu-toggle');

        // Si el menú está abierto y el clic NO fue dentro del menú ni en el botón de la hamburguesa
        if (menu.classList.contains('open') && !menu.contains(event.target) && !toggleBtn.contains(event.target)) {
            toggleMobileMenu();
        }
    });

    /* ========================================== */
    /* INIT                                       */
    /* ========================================== */
    document.addEventListener('DOMContentLoaded', function () {
        cycleTheme(localStorage.getItem('theme') || 'dark');
    });

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (localStorage.getItem('theme') === 'system') cycleTheme('system');
    });
</script>