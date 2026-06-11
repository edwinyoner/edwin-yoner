<?php

use App\Models\PortfolioSetting;
use App\Models\ProfileSetting;
use Illuminate\Support\Facades\Cache;

// =============================================================
// PORTFOLIO SETTINGS
// Cubre: logo, favicon, colores, contacto, configuración sitio
// Tabla: portfolio_settings
// =============================================================

if (!function_exists('portfolio')) {
    /**
     * Obtiene configuración del portafolio (portfolio_settings).
     *
     * Uso:
     * - portfolio()                    → objeto completo
     * - portfolio('primary_color')     → '#d4af37'
     * - portfolio('email_contact')     → 'correo@ejemplo.com'
     * - portfolio('whatsapp_number')   → '51987654321'
     * - portfolio('logo_path')         → 'portfolio/logo.png'
     */
    function portfolio($key = null): mixed
    {
        $settings = Cache::remember('portfolio_settings', 3600, function () {
            return PortfolioSetting::first();
        });

        return $key
            ? ($settings?->$key ?? null)
            : $settings;
    }
}

// =============================================================
// PROFILE SETTINGS
// Cubre: nombre, título, bio, ciudad, país, foto de perfil
// Tabla: profile_settings
// =============================================================

if (!function_exists('profile')) {
    /**
     * Obtiene configuración del perfil personal (profile_settings).
     *
     * Uso:
     * - profile()                      → objeto completo
     * - profile('full_name')           → 'Edwin Yoner Flores Rupay'
     * - profile('professional_title')  → 'Bach. Ingeniería De Sistemas E Informática'
     * - profile('bio_short')           → 'Texto corto...'
     * - profile('bio_long')            → 'Texto largo...'
     * - profile('city')                → 'Lima'
     * - profile('country')             → 'Perú'
     * - profile('profile_image')       → 'profile/photo.jpg'
     */
    function profile($key = null): mixed
    {
        $settings = Cache::remember('profile_settings', 3600, function () {
            return ProfileSetting::first();
        });

        return $key
            ? ($settings?->$key ?? null)
            : $settings;
    }
}

// =============================================================
// LOGO
// Lee desde portfolio_settings (logo_path / favicon_path)
// =============================================================

if (!function_exists('logo')) {
    /**
     * Obtiene URL del logo.
     *
     * Uso:
     * - logo()           → logo principal
     * - logo('favicon')  → favicon
     */
    function logo($type = 'main'): string
    {
        $portfolio = portfolio();

        if (!$portfolio) {
            return match ($type) {
                'favicon' => asset('assets/images/favicon.ico'),
                default   => asset('assets/images/logo.png'),
            };
        }

        return match ($type) {
            'favicon' => $portfolio->favicon_path
                ? asset('storage/' . $portfolio->favicon_path)
                : asset('assets/images/favicon.ico'),
            default   => $portfolio->logo_path
                ? asset('storage/' . $portfolio->logo_path)
                : asset('assets/images/logo.png'),
        };
    }
}

// =============================================================
// COLORES
// Lee desde portfolio_settings
// =============================================================

if (!function_exists('color')) {
    /**
     * Obtiene un color de la paleta del portafolio.
     *
     * Uso:
     * - color()              → color primario
     * - color('primary')     → '#d4af37'
     * - color('secondary')   → '#434b4d'
     * - color('tertiary')    → '#f9fafb'
     * - color('text_dark')   → '#1f2937'
     * - color('text_light')  → '#f9fafb'
     */
    function color($type = 'primary'): string
    {
        $portfolio = portfolio();

        if (!$portfolio) {
            return match ($type) {
                'primary'    => '#d4af37',
                'secondary'  => '#434b4d',
                'tertiary'   => '#f9fafb',
                'text_dark'  => '#1f2937',
                'text_light' => '#ffffff',
                default      => '#d4af37',
            };
        }

        $field = $type . '_color';
        return $portfolio->$field ?? '#d4af37';
    }
}

// =============================================================
// UTILIDADES DE COLOR
// =============================================================

if (!function_exists('adjustBrightness')) {
    /**
     * Ajusta el brillo de un color hexadecimal.
     *
     * Uso:
     * - adjustBrightness('#d4af37', -20)  → más oscuro
     * - adjustBrightness('#d4af37',  20)  → más claro
     */
    function adjustBrightness($hex, $steps): string
    {
        $hex = str_replace('#', '', $hex);

        $r = max(0, min(255, hexdec(substr($hex, 0, 2)) + $steps));
        $g = max(0, min(255, hexdec(substr($hex, 2, 2)) + $steps));
        $b = max(0, min(255, hexdec(substr($hex, 4, 2)) + $steps));

        return '#'
            . str_pad(dechex($r), 2, '0', STR_PAD_LEFT)
            . str_pad(dechex($g), 2, '0', STR_PAD_LEFT)
            . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('hexToRgb')) {
    /**
     * Convierte HEX a RGB separado por comas (para uso en rgba()).
     *
     * Uso:
     * - hexToRgb('#ffffff')  → '255,255,255'
     * - hexToRgb('#d4af37')  → '212,175,55'
     */
    function hexToRgb($hex): string
    {
        $hex = str_replace('#', '', $hex);

        if (strlen($hex) === 3) {
            $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        return "$r,$g,$b";
    }
}

// =============================================================
// WHATSAPP
// Lee desde portfolio_settings.whatsapp_number
// =============================================================

if (!function_exists('whatsappLink')) {
    /**
     * Genera enlace de WhatsApp con mensaje predefinido.
     *
     * Uso:
     * - whatsappLink()
     * - whatsappLink('Hola, me interesa contactarte')
     */
    function whatsappLink($message = null): string
    {
        $whatsapp = portfolio('whatsapp_number');

        if (!$whatsapp) {
            return '#';
        }

        $number = preg_replace('/[^0-9]/', '', $whatsapp);

        if (!str_starts_with($number, '51')) {
            $number = '51' . $number;
        }

        $text = urlencode($message ?? '¡Hola! Me interesa contactarte.');

        return "https://wa.me/{$number}?text={$text}";
    }
}

// =============================================================
// LOCATION
// Combina city + country desde profile_settings
// Equivale a company('full_address') del proyecto base
// =============================================================

if (!function_exists('profileLocation')) {
    /**
     * Retorna la ubicación formateada del perfil.
     *
     * Uso:
     * - profileLocation()          → 'Lima, Perú'
     * - profileLocation(', ')      → 'Lima, Perú'  (separador custom)
     */
    function profileLocation($separator = ', '): string
    {
        $city    = profile('city');
        $country = profile('country');

        return implode($separator, array_filter([$city, $country]));
    }
}