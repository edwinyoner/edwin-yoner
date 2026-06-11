<?php

return [

    // ============================================
    // CONFIGURACIÓN GENERAL
    // ============================================
    'title' => 'Edwin Yoner',
    'title_prefix' => '',
    'title_postfix' => '',

    'use_ico_only' => true,
    'use_full_favicon' => false,

    'google_fonts' => [
        'allowed' => true,
    ],

    // ============================================
    // LOGO DEL SIDEBAR
    // ============================================
    'logo' => '<b>Edwin Yoner</b>',
    'logo_img' => 'vendor/adminlte/dist/img/Logo.png', // Cambia por tu logo
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Edwin Yoner - Portafolio',

    // ============================================
    // LOGO DE AUTENTICACIÓN (LOGIN)
    // ============================================
    'auth_logo' => [
        'enabled' => true,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/Logo.png', // Cambia por tu logo
            'alt' => 'Edwin Yoner - Portafolio',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    // ============================================
    // PRELOADER (PANTALLA DE CARGA)
    // ============================================
    'preloader' => [
        'enabled' => false,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/Logo.png',
            'alt' => 'Edwin Yoner',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    // ============================================
    // MENÚ DE USUARIO
    // ============================================
    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    // ============================================
    // LAYOUT
    // ============================================
    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,
    'layout_dark_mode' => null,

    // ============================================
    // CLASES DE VISTAS DE AUTENTICACIÓN
    // ============================================
    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => 'text-center',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    // ============================================
    // CLASES DEL PANEL ADMIN
    // ============================================
    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    // ============================================
    // SIDEBAR
    // ============================================
    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    // ============================================
    // BARRA LATERAL DERECHA (Control Sidebar)
    // ============================================
    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    // ============================================
    // URLS
    // ============================================
    'use_route_url' => false,
    'dashboard_url' => '/dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'forgot-password',
    'password_email_url' => 'forgot-password',
    'profile_url' => '/user/profile',
    'disable_darkmode_routes' => false,

    // ============================================
    // LARAVEL ASSET BUNDLING
    // ============================================
    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    // ============================================
    // MENÚ DEL SIDEBAR
    // ============================================
    'menu' => [
        // ========== BARRA SUPERIOR ==========
        [
            'type' => 'navbar-search',
            'text' => 'Buscar...',
            'topnav_right' => false,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => false,
        ],
        [
            'type' => 'darkmode-widget',
            'topnav_right' => true,
        ],

        // ========== BÚSQUEDA EN SIDEBAR ==========
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Buscar',
        ],

        // ========== PANEL PRINCIPAL ==========
        [
            'header' => 'PANEL PRINCIPAL',
            'classes' => 'text-uppercase',
        ],

        [
            'text' => 'Dashboard',
            'route' => 'backend.dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'icon_color' => 'primary',
        ],

        // ========== CONFIGURACIÓN DEL PORTAFOLIO ==========
        [
            'header' => 'CONFIGURACIÓN',
            'classes' => 'text-uppercase',
        ],

        [
            'text' => 'Perfil Personal',
            'route' => 'backend.profile-settings.index',
            'icon' => 'fas fa-user-circle',
            'icon_color' => 'info',
            'can' => 'ver configuracion perfil',
            'active' => ['profile-settings*'],
        ],

        [
            'text' => 'Ajustes del Portafolio',
            'route' => 'backend.portfolio-settings.index',
            'icon' => 'fas fa-cog',
            'icon_color' => 'primary',
            'can' => 'ver configuracion portafolio',
            'active' => ['portfolio-settings*'],
        ],
        [
            'header' => 'CONFIGURACIÓN DEL CONTENIDO',
            'classes' => 'text-uppercase',
        ],
        [
            'text' => 'Redes Sociales',
            'route' => 'backend.social-links.index',
            'icon' => 'fab fa-linkedin',
            'icon_color' => 'info',
            'can' => 'ver redes sociales',
            'active' => ['social-links*'],
        ],

        [
            'text' => 'Categorías de Tecnologías',
            'route' => 'backend.technology-categories.index',
            'icon' => 'fas fa-folder',
            'icon_color' => 'warning',
            'can' => 'ver categorias tecnologias',
            'active' => ['technology-categories*'],
        ],

        [
            'text' => 'Tecnologías',
            'route' => 'backend.technologies.index',
            'icon' => 'fas fa-code',
            'icon_color' => 'success',
            'can' => 'ver tecnologias',
            'active' => ['technologies*'],
        ],

        [
            'text' => 'Proyectos',
            'route' => 'backend.projects.index',
            'icon' => 'fas fa-project-diagram',
            'icon_color' => 'purple',
            'can' => 'ver proyectos',
            'active' => ['projects*'],
        ],

        [
            'text' => 'Documentos',
            'route' => 'backend.documents.index',
            'icon' => 'fas fa-file-pdf',
            'icon_color' => 'danger',
            'can' => 'ver documentos',
            'active' => ['documents*'],
        ],

        [
            'text' => 'Mensajes Recibidos',
            'route' => 'backend.contact-submissions.index',
            'icon' => 'fas fa-envelope',
            'icon_color' => 'teal',
            'can' => 'ver mensajes contacto',
            'active' => ['contact-submissions*'],
        ],

        // ========== GESTIÓN DE USUARIOS ==========
        [
            'header' => 'ADMINISTRACIÓN',
            'classes' => 'text-uppercase',
        ],

        [
            'text' => 'Usuarios',
            'route' => 'backend.users.index',
            'icon' => 'fas fa-users',
            'icon_color' => 'primary',
            'can' => 'ver usuarios',
            'active' => ['users*'],
        ],

        [
            'text' => 'Roles',
            'route' => 'backend.roles.index',
            'icon' => 'fas fa-user-tag',
            'icon_color' => 'success',
            'can' => 'ver roles',
            'active' => ['roles*'],
        ],

        [
            'text' => 'Permisos',
            'route' => 'backend.permissions.index',
            'icon' => 'fas fa-key',
            'icon_color' => 'warning',
            'can' => 'ver permisos',
            'active' => ['permissions*'],
        ],
    ],

    // ============================================
    // FILTROS DE MENÚ
    // ============================================
    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    // ============================================
    // PLUGINS
    // ============================================
    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'DatatablesPlugins' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.html5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.print.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/jszip/jszip.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/pdfmake.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/vfs_fonts.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'BootstrapSwitch' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-switch/js/bootstrap-switch.min.js',
                ],
            ],
        ],
        'Summernote' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/summernote/summernote-bs4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/summernote/summernote-bs4.min.css',
                ],
            ],
        ],
    ],

    // ============================================
    // IFRAME MODE
    // ============================================
    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    // ============================================
    // LIVEWIRE
    // ============================================
    'livewire' => false,
];