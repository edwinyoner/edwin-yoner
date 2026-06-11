<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PortfolioSetting extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla
     */
    protected $table = 'portfolio_settings';

    /**
     * Campos asignables en masa
     */
    protected $fillable = [
        'logo_path',
        'favicon_path',
        'primary_color',
        'secondary_color',
        'tertiary_color',
        'text_dark_color',
        'text_light_color',
        'email_contact',
        'phone',
        'whatsapp_number',
        'enable_dark_mode',
        'enable_multilang',
        'default_language',
    ];

    /**
     * Casteo de tipos de datos
     */
    protected $casts = [
        'enable_dark_mode' => 'boolean',
        'enable_multilang' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Summary of appends
     * @var array
     */
    protected $appends = [
        'logo_url',
        'favicon_url',
        'formatted_phone',
        'whatsapp_url',
        'mailto_link',
        'color_palette',
        'css_variables',
    ];

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * Obtiene la URL completa del logo principal.
     * Si no existe, retorna un logo por defecto.
     *
     * @return string
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
            return asset('storage/' . $this->logo_path);
        }

        // Fallback a logo estático por defecto
        return asset('assets/images/logo.png');
    }

    /**
     * Obtiene la URL completa del favicon.
     *
     * @return string
     */
    public function getFaviconUrlAttribute(): string
    {
        if ($this->favicon_path && Storage::disk('public')->exists($this->favicon_path)) {
            return asset('storage/' . $this->favicon_path);
        }

        // Fallback a favicon por defecto
        return asset('favicon.ico');
    }

    public function getHasLogoAttribute(): bool
    {
        return $this->logo_path
            && Storage::disk('public')->exists($this->logo_path);
    }

    public function getHasFaviconAttribute(): bool
    {
        return $this->favicon_path
            && Storage::disk('public')->exists($this->favicon_path);
    }

    /**
     * WhatsApp URL completa (wa.me)
     */
    public function getWhatsappUrlAttribute(): ?string
    {
        if (!$this->whatsapp_number) {
            return null;
        }

        $phone = str_replace(['+', ' ', '-'], '', $this->whatsapp_number);
        return "https://wa.me/{$phone}";
    }

    public function getWhatsappLinkAttribute(): ?string
    {
        if (!$this->whatsapp_number) {
            return null;
        }

        $number = preg_replace(
            '/[^0-9]/',
            '',
            $this->whatsapp_number
        );

        if (!str_starts_with($number, '51')) {
            $number = '51' . $number;
        }

        $message = urlencode(
            'Hola, me interesa contactarte.'
        );

        return "https://wa.me/{$number}?text={$message}";
    }

    /**
     * Link mailto para email
     */
    public function getMailtoLinkAttribute(): ?string
    {
        if (!$this->email_contact) {
            return null;
        }

        return "mailto:{$this->email_contact}";
    }

    /**
     * Teléfono formateado
     */
    public function getFormattedPhoneAttribute(): ?string
    {
        if (!$this->phone) {
            return null;
        }

        // Si es teléfono peruano (9 dígitos)
        $phone = str_replace(['+51', ' ', '-'], '', $this->phone);

        if (strlen($phone) === 9) {
            return substr($phone, 0, 3) . ' ' .
                substr($phone, 3, 3) . ' ' .
                substr($phone, 6, 3);
        }

        return $this->phone;
    }

    // ============================================
    // ACCESSORS - PALETA DE COLORES
    // ============================================

    /**
     * Paleta de colores completa
     */
    public function getColorPaletteAttribute(): array
    {
        return [
            'primary' => $this->primary_color,
            'secondary' => $this->secondary_color,
            'tertiary' => $this->tertiary_color,
            'text_dark' => $this->text_dark_color,
            'text_light' => $this->text_light_color,
        ];
    }

    /**
     * Variables CSS para tema personalizado
     */
    public function getCssVariablesAttribute(): string
    {
        return "
            --color-primary: {$this->primary_color};
            --color-secondary: {$this->secondary_color};
            --color-tertiary: {$this->tertiary_color};
            --color-text-dark: {$this->text_dark_color};
            --color-text-light: {$this->text_light_color};
        ";
    }

    public function getIsCompleteAttribute(): bool
    {
        $required = [
            'email_contact',
            'primary_color',
            'secondary_color',
            'text_dark_color',
            'text_light_color',
        ];

        foreach ($required as $field) {

            if (empty($this->$field)) {
                return false;
            }
        }

        return true;
    }

    public function getCompletionPercentageAttribute(): int
    {
        $fields = [

            'logo_path',
            'favicon_path',

            'primary_color',
            'secondary_color',
            'tertiary_color',

            'text_dark_color',
            'text_light_color',

            'email_contact',
            'phone',
            'whatsapp_number',

            'default_language',
        ];

        $completed = 0;

        foreach ($fields as $field) {

            if (!empty($this->$field)) {
                $completed++;
            }
        }

        return round(
            ($completed / count($fields)) * 100
        );
    }

    // ============================================
    // MUTATORS
    // ============================================

    /**
     * Asegurar que los colores tengan el prefijo #
     */
    public function setPrimaryColorAttribute($value): void
    {
        $this->attributes['primary_color'] = $this->formatColor($value);
    }

    public function setSecondaryColorAttribute($value): void
    {
        $this->attributes['secondary_color'] = $this->formatColor($value);
    }

    public function setTertiaryColorAttribute($value): void
    {
        $this->attributes['tertiary_color'] = $this->formatColor($value);
    }

    public function setTextDarkColorAttribute($value): void
    {
        $this->attributes['text_dark_color'] = $this->formatColor($value);
    }

    public function setTextLightColorAttribute($value): void
    {
        $this->attributes['text_light_color'] = $this->formatColor($value);
    }

    /**
     * Formatear email a minúsculas
     */
    public function setEmailContactAttribute($value): void
    {
        $this->attributes['email_contact'] = $value ? strtolower(trim($value)) : null;
    }

    /**
     * Limpiar número de teléfono
     */
    public function setPhoneAttribute($value): void
    {
        $this->attributes['phone'] = $value ? preg_replace('/[^0-9+]/', '', $value) : null;
    }

    /**
     * Limpiar número de WhatsApp
     */
    public function setWhatsappNumberAttribute($value): void
    {
        $this->attributes['whatsapp_number'] = $value ? preg_replace('/[^0-9+]/', '', $value) : null;
    }

    // ============================================
    // MÉTODOS HELPER PRIVADOS
    // ============================================

    /**
     * Formatear color hexadecimal
     */
    private function formatColor($value): string
    {
        if (empty($value)) {
            return '#000000';
        }

        $value = trim($value);

        if (!str_starts_with($value, '#')) {
            $value = '#' . $value;
        }

        return strtoupper($value);
    }

    // ============================================
    // MÉTODOS HELPER PÚBLICOS
    // ============================================

    /**
     * Obtener configuración activa (singleton - solo hay un registro)
     */
    public static function getSettings()
    {
        return self::first() ?? new self();
    }

    /**
     * Verificar si tiene logo
     */
    public function hasLogo(): bool
    {
        return !empty($this->logo_path);
    }

    /**
     * Verificar si tiene favicon personalizado
     */
    public function hasFavicon(): bool
    {
        return !empty($this->favicon_path);
    }

    /**
     * Verificar si multiidioma está habilitado
     */
    public function isMultilangEnabled(): bool
    {
        return $this->enable_multilang === true;
    }

    /**
     * Verificar si tema oscuro está habilitado
     */
    public function isDarkModeEnabled(): bool
    {
        return $this->enable_dark_mode === true;
    }

    /**
     * Obtener idioma activo
     */
    public function getCurrentLanguage(): string
    {
        return session('locale', $this->default_language);
    }

    /**
     * Resumen de configuración
     */
    public function getSummary(): array
    {
        return [
            'email' => $this->email_contact,
            'phone' => $this->formatted_phone,
            'whatsapp' => $this->whatsapp_number,
            'colors' => $this->color_palette,
            'dark_mode' => $this->enable_dark_mode,
            'multilang' => $this->enable_multilang,
            'language' => $this->default_language,
        ];
    }

    public static function clearCache(): void
    {
        Cache::forget('portfolio_settings');
    }

    public static function getInstance(): self
    {
        return Cache::remember('portfolio_settings', 3600, function () {

            return self::firstOrCreate([], [

                'primary_color'     => '#D4AF37',
                'secondary_color'   => '#1F2937',
                'tertiary_color'    => '#F9FAFB',
                'text_dark_color'   => '#1F2937',
                'text_light_color'  => '#F9FAFB',

                'email_contact'     => 'admin@edwin-yoner.com',
                'phone'             => null,
                'whatsapp_number'   => null,

                'enable_dark_mode'  => true,
                'enable_multilang'  => false,
                'default_language'  => 'es',
            ]);
        });
    }
}