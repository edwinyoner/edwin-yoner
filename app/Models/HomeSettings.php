<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class HomeSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_description',
        'hero_image',
        'hero_vehicle_image',
        'about_section_title',
        'about_section_text',
        'about_section_image',
        'services_section_title',
        'partners_section_title',
        'cta_title',
        'cta_description',
        'cta_background_image',
        'meta_title',
        'meta_description',
    ];

    // ============================================
    // ACCESSORS & MUTATORS
    // ============================================

    /**
     * Formatear hero_title en Title Case
     */
    protected function heroTitle(): Attribute
    {
        // return Attribute::make(
        //     get: fn($value) => $value ? ucwords(strtolower($value)) : null,
        //     set: fn($value) => $value ? ucwords(strtolower($value)) : null,
        // );
        return Attribute::make(
            get: fn($value) => $value ? $this->formatTitleCase($value) : null,
            set: fn($value) => $value ? $this->formatTitleCase($value) : null,
        );
    }

    /**
     * Formatear hero_subtitle en Title Case
     */
    protected function heroSubtitle(): Attribute
    {
        // return Attribute::make(
        //     get: fn($value) => $value ? ucwords(strtolower($value)) : null,
        //     set: fn($value) => $value ? ucwords(strtolower($value)) : null,
        // );
        return Attribute::make(
            get: fn($value) => $value ? $this->formatTitleCase($value) : null,
            set: fn($value) => $value ? $this->formatTitleCase($value) : null,
        );
    }

    /**
     * Formatear hero_description: Primera letra en mayúscula
     */
    protected function heroDescription(): Attribute
    {
        // return Attribute::make(
        //     get: fn($value) => $value ? ucfirst(strtolower($value)) : null,
        //     set: fn($value) => $value ? ucfirst(strtolower($value)) : null,
        // );
        return Attribute::make(
            get: fn($value) => $value ? $this->formatSentenceCase($value) : null,
            set: fn($value) => $value ? $this->formatSentenceCase($value) : null,
        );
    }

    /**
     * Formatear about_section_title en Title Case
     */
    protected function aboutSectionTitle(): Attribute
    {
        // return Attribute::make(
        //     get: fn($value) => $value ? ucwords(strtolower($value)) : null,
        //     set: fn($value) => $value ? ucwords(strtolower($value)) : null,
        // );
        return Attribute::make(
            get: fn($value) => $value ? $this->formatTitleCase($value) : null,
            set: fn($value) => $value ? $this->formatTitleCase($value) : null,
        );
    }

    /**
     * Formatear about_section_text: Primera letra en mayúscula
     */
    protected function aboutSectionText(): Attribute
    {
        // return Attribute::make(
        //     get: fn($value) => $value ? ucfirst($value) : null,
        //     set: fn($value) => $value ? ucfirst($value) : null,
        // );
        return Attribute::make(
            get: fn($value) => $value ? $this->formatSentenceCase($value) : null,
            set: fn($value) => $value ? $this->formatSentenceCase($value) : null,
        );
    }

    /**
     * Formatear services_section_title en Title Case
     */
    protected function servicesSectionTitle(): Attribute
    {
        // return Attribute::make(
        //     get: fn($value) => $value ? ucwords(strtolower($value)) : null,
        //     set: fn($value) => $value ? ucwords(strtolower($value)) : null,
        // );
        return Attribute::make(
            get: fn($value) => $value ? $this->formatTitleCase($value) : null,
            set: fn($value) => $value ? $this->formatTitleCase($value) : null,
        );
    }

    /**
     * Formatear partners_section_title en Title Case
     */
    protected function partnersSectionTitle(): Attribute
    {
        // return Attribute::make(
        //     get: fn($value) => $value ? ucwords(strtolower($value)) : null,
        //     set: fn($value) => $value ? ucwords(strtolower($value)) : null,
        // );
        return Attribute::make(
            get: fn($value) => $value ? $this->formatTitleCase($value) : null,
            set: fn($value) => $value ? $this->formatTitleCase($value) : null,
        );
    }

    /**
     * Formatear cta_title en Title Case
     */
    protected function ctaTitle(): Attribute
    {
        // return Attribute::make(
        //     get: fn($value) => $value ? ucwords(strtolower($value)) : null,
        //     set: fn($value) => $value ? ucwords(strtolower($value)) : null,
        // );
        return Attribute::make(
            get: fn($value) => $value ? $this->formatTitleCase($value) : null,
            set: fn($value) => $value ? $this->formatTitleCase($value) : null,
        );
    }

    /**
     * Formatear cta_description: Primera letra en mayúscula
     */
    protected function ctaDescription(): Attribute
    {
        // return Attribute::make(
        //     get: fn($value) => $value ? ucfirst($value) : null,
        //     set: fn($value) => $value ? ucfirst($value) : null,
        // );
        return Attribute::make(
            get: fn($value) => $value ? $this->formatSentenceCase($value) : null,
            set: fn($value) => $value ? $this->formatSentenceCase($value) : null,
        );
    }

    // ============================================
    // HELPERS
    // ============================================

    /**
     * Obtener URL completa de hero_image
     */
    public function getHeroImageUrlAttribute()
    {
        return $this->hero_image 
            ? asset('storage/' . $this->hero_image) 
            : null;
    }

    /**
     * Obtener URL completa de hero_vehicle_image
     */
    public function getHeroVehicleImageUrlAttribute()
    {
        return $this->hero_vehicle_image 
            ? asset('storage/' . $this->hero_vehicle_image) 
            : null;
    }

    /**
     * Obtener URL completa de about_section_image
     */
    public function getAboutSectionImageUrlAttribute()
    {
        return $this->about_section_image 
            ? asset('storage/' . $this->about_section_image) 
            : null;
    }

    /**
     * Obtener URL completa de cta_background_image
     */
    public function getCtaBackgroundImageUrlAttribute()
    {
        return $this->cta_background_image 
            ? asset('storage/' . $this->cta_background_image) 
            : null;
    }
 /**
     * Formatear Title Case respetando signos de apertura ¿ y ¡
     * Ejemplos:
     * "¿quiénes somos?" → "¿Quiénes Somos?"
     * "¡listo para trabajar!" → "¡Listo Para Trabajar!"
     * "¿necesitas una cotización?" → "¿Necesitas Una Cotización?"
     */
    /**
     * Formatear Title Case respetando signos ¿¡ y protegiendo siglas comunes
     */
    private function formatTitleCase(string $value): string
    {
        // 1. Quitar espacios extras
        $value = trim($value);

        // 2. Convertir todo a minúsculas (soporte UTF-8)
        $value = mb_strtolower($value, 'UTF-8');

        // 3. Proteger siglas comunes (S.A.C., S.A., E.I.R.L., etc.)
        $siglas = [
            's.a.c.' => 'S.A.C.',
            's.a.'   => 'S.A.',
            'e.i.r.l.' => 'E.I.R.L.',
            's.r.l.' => 'S.R.L.',
            'ltda.'  => 'LTDA.',
            'sac'    => 'SAC',
            'sa'     => 'SA',
            'companny'  => 'Company',
            'xyz'   => 'XYZ',
            'corporation' => 'Corporation',
        ];

        foreach ($siglas as $minus => $mayus) {
            $value = str_replace($minus, $mayus, $value);
        }

        // 4. Poner en mayúscula la primera letra después de signos y oraciones
        $value = preg_replace_callback('/(^|¿|¡|[.!?]\s+)([a-z])/u', function ($matches) {
            return $matches[1] . mb_strtoupper($matches[2], 'UTF-8');
        }, $value);

        // 5. Aplicar Title Case al resto
        $value = mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');

        // 6. Volver a forzar las siglas (por si Title Case las tocó)
        foreach ($siglas as $minus => $mayus) {
            $value = str_replace(mb_strtoupper($minus, 'UTF-8'), $mayus, $value);
            $value = str_replace(mb_convert_case($minus, MB_CASE_TITLE, 'UTF-8'), $mayus, $value);
        }

        return $value;
    }

    /**
     * Formatear como oración normal (Sentence Case):
     * - Solo la primera letra de cada oración en mayúscula.
     * - Respeta ¿ y ¡ al inicio.
     * - Protege siglas comunes como S.A.C., E.I.R.L., etc.
     */
    private function formatSentenceCase(string $value): string
    {
        // 1. Quitar espacios extras
        $value = trim($value);

        // 2. Convertir todo a minúsculas (soporte UTF-8)
        $value = mb_strtolower($value, 'UTF-8');

        // 3. Proteger siglas comunes ANTES de cualquier cambio
        $siglas = [
            's.a.c.'    => 'S.A.C.',
            's.a.'      => 'S.A.',
            'e.i.r.l.'  => 'E.I.R.L.',
            's.r.l.'    => 'S.R.L.',
            // 'ltda.'     => 'LTDA.',
            // 'sac'       => 'SAC',
            // 'sa'        => 'SA',
            'companny'  => 'Company',
            'xyz'   => 'XYZ',
            'corporation' => 'Corporation',
        ];

        // Guardamos las siglas temporalmente con un marcador único
        $placeholders = [];
        $i = 0;
        foreach ($siglas as $minus => $mayus) {
            $placeholder = "__SIGLA_{$i}__";
            $placeholders[$placeholder] = $mayus;
            $value = str_replace($minus, $placeholder, $value);
            $i++;
        }

        // 4. Poner en mayúscula solo la primera letra de cada oración
        // Incluye: inicio, después de . ! ? + espacio, y después de ¿ o ¡
        $value = preg_replace_callback(
            '/(^|¿|¡|[.!?]\s+)([a-z])/u',
            fn($m) => $m[1] . mb_strtoupper($m[2], 'UTF-8'),
            $value
        );

        // 5. Restaurar las siglas protegidas
        foreach ($placeholders as $placeholder => $sigla) {
            $value = str_replace($placeholder, $sigla, $value);
        }

        return $value;
    }
}
