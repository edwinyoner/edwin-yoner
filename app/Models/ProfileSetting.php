<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileSetting extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla
     */
    protected $table = 'profile_settings';

    /**
     * Campos asignables en masa
     */
    protected $fillable = [
        'profile_image',
        'full_name',
        'professional_title',
        'bio_short',
        'bio_long',
        'city',
        'country',
    ];

    /**
     * Casteo de tipos de datos
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * URL completa de la imagen de perfil
     */
    public function getProfileImageUrlAttribute(): ?string
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return asset('images/default-profile.jpg');
    }

    /**
     * Primer nombre (solo el primer nombre)
     */
    public function getFirstNameAttribute(): string
    {
        return explode(' ', $this->full_name)[0] ?? '';
    }

    /**
     * Ubicación completa (ciudad, país)
     */
    public function getFullLocationAttribute(): string
    {
        return implode(', ', array_filter([$this->city, $this->country]));
    }

    /**
     * Bio resumida (primeras 150 caracteres)
     */
    public function getBioExcerptAttribute(): string
    {
        if (!$this->bio_short) {
            return '';
        }
        return strlen($this->bio_short) > 150 
            ? substr($this->bio_short, 0, 150) . '...' 
            : $this->bio_short;
    }

    // ============================================
    // MUTATORS
    // ============================================

    /**
     * Formatear nombre completo (capitalizado)
     */
    public function setFullNameAttribute($value): void
    {
        $this->attributes['full_name'] = ucwords(strtolower(trim($value)));
    }

    /**
     * Formatear título profesional (capitalizado)
     */
    public function setProfessionalTitleAttribute($value): void
    {
        $this->attributes['professional_title'] = ucwords(strtolower(trim($value)));
    }

    /**
     * Formatear ciudad (capitalizado)
     */
    public function setCityAttribute($value): void
    {
        $this->attributes['city'] = ucwords(strtolower(trim($value)));
    }

    /**
     * Formatear país (capitalizado)
     */
    public function setCountryAttribute($value): void
    {
        $this->attributes['country'] = ucwords(strtolower(trim($value)));
    }

    // ============================================
    // MÉTODOS HELPER
    // ============================================

    /**
     * Obtener perfil activo (singleton - solo hay un registro)
     */
    public static function getProfile()
    {
        return self::first() ?? new self();
    }

    /**
     * Verificar si tiene imagen de perfil
     */
    public function hasProfileImage(): bool
    {
        return !empty($this->profile_image);
    }

    /**
     * Resumen del perfil
     */
    public function getSummary(): array
    {
        return [
            'name' => $this->full_name,
            'title' => $this->professional_title,
            'location' => $this->full_location,
            'image_url' => $this->profile_image_url,
        ];
    }
}