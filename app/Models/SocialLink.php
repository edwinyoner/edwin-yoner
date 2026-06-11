<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialLink extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nombre de la tabla
     */
    protected $table = 'social_links';

    /**
     * Campos asignables en masa
     */
    protected $fillable = [
        'name',
        'icon',
        'url',
        'color',
        'is_active',
    ];

    /**
     * Casteo de tipos de datos
     */
    protected $casts = [
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope: Solo redes sociales activas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Buscar por nombre
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%");
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * Badge de estado (texto)
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->is_active ? 'Activo' : 'Inactivo';
    }

    /**
     * Badge de estado (color)
     */
    public function getStatusColorAttribute(): string
    {
        return $this->is_active ? 'success' : 'danger';
    }

    /**
     * Icono con fallback por defecto
     */
    public function getIconWithFallbackAttribute(): string
    {
        return $this->icon ?? 'fas fa-link';
    }

    /**
     * Color con fallback por defecto
     */
    public function getColorWithFallbackAttribute(): string
    {
        return $this->color ?? '#000000';
    }

    /**
     * Nombre formateado (capitalizado)
     */
    public function getFormattedNameAttribute(): string
    {
        return ucwords(strtolower($this->name));
    }

    /**
     * Verificar si la URL es válida
     */
    public function getIsValidUrlAttribute(): bool
    {
        return filter_var($this->url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Obtener dominio de la URL
     */
    public function getDomainAttribute(): ?string
    {
        $parsed = parse_url($this->url);
        return $parsed['host'] ?? null;
    }

    /**
     * Verificar si es WhatsApp
     */
    public function getIsWhatsappAttribute(): bool
    {
        return str_contains(strtolower($this->name), 'whatsapp');
    }

    // ============================================
    // MUTATORS
    // ============================================

    /**
     * Convertir nombre a título capitalizado
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = ucwords(strtolower(trim($value)));
    }

    /**
     * Convertir URL a minúsculas
     */
    public function setUrlAttribute($value): void
    {
        $this->attributes['url'] = strtolower(trim($value));
    }

    /**
     * Asegurar que color tenga prefijo #
     */
    public function setColorAttribute($value): void
    {
        if (!empty($value)) {
            if (!str_starts_with($value, '#')) {
                $value = '#' . $value;
            }
            $this->attributes['color'] = strtoupper($value);
        } else {
            $this->attributes['color'] = null;
        }
    }

    // ============================================
    // MÉTODOS HELPER
    // ============================================

    /**
     * Verificar si el link está visible
     */
    public function isVisible(): bool
    {
        return $this->is_active;
    }

    /**
     * Alternar estado activo/inactivo
     */
    public function toggleActive(): bool
    {
        $this->is_active = !$this->is_active;
        return $this->save();
    }

    /**
     * Resumen del link social
     */
    public function getSummary(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => $this->icon_with_fallback,
            'color' => $this->color_with_fallback,
            'domain' => $this->domain,
            'status' => $this->status_badge,
        ];
    }
}