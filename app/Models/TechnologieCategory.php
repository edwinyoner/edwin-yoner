<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnologieCategory extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla
     */
    protected $table = 'technologie_categories';

    /**
     * Campos asignables en masa
     */
    protected $fillable = [
        'name',
        'name_en',
        'slug',
        'icon_class',
        'color',
        'description',
        'is_active',
    ];

    /**
     * Casteo de tipos de datos
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Relación: Una categoría tiene muchas tecnologías
     */
    public function technologies()
    {
        return $this->hasMany(Technology::class, 'technologie_category_id');
    }

    /**
     * Relación: Solo tecnologías activas
     */
    public function activeTechnologies()
    {
        return $this->hasMany(Technology::class, 'technologie_category_id')
                    ->where('is_active', true);
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope: Solo categorías activas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Buscar por nombre o slug
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%")
                     ->orWhere('slug', 'like', "%{$term}%");
    }

    /**
     * Scope: Buscar por slug
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * Nombre según idioma actual
     */
    public function getLocalizedNameAttribute(): string
    {
        $locale = app()->getLocale();
        
        if ($locale === 'en' && !empty($this->name_en)) {
            return $this->name_en;
        }
        
        return $this->name;
    }

    /**
     * Badge de estado
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->is_active ? 'Activa' : 'Inactiva';
    }

    /**
     * Color del badge de estado
     */
    public function getStatusColorAttribute(): string
    {
        return $this->is_active ? 'success' : 'secondary';
    }

    /**
     * Icono con fallback
     */
    public function getIconWithFallbackAttribute(): string
    {
        return $this->icon_class ?? 'fas fa-folder';
    }

    /**
     * Color con fallback
     */
    public function getColorWithFallbackAttribute(): string
    {
        return $this->color ?? '#3b82f6';
    }

    /**
     * Contador de tecnologías
     */
    public function getTechnologiesCountAttribute(): int
    {
        return $this->technologies()->count();
    }

    /**
     * Contador de tecnologías activas
     */
    public function getActiveTechnologiesCountAttribute(): int
    {
        return $this->activeTechnologies()->count();
    }

    // ============================================
    // MUTATORS
    // ============================================

    /**
     * Generar slug automáticamente desde el nombre
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = ucwords(trim($value));
        
        // Auto-generar slug si no existe
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
        }
    }

    /**
     * Formatear slug
     */
    public function setSlugAttribute($value): void
    {
        $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
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
     * Verificar si la categoría está visible
     */
    public function isVisible(): bool
    {
        return $this->is_active === true;
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
     * Verificar si tiene tecnologías asociadas
     */
    public function hasTechnologies(): bool
    {
        return $this->technologies()->exists();
    }

    /**
     * Obtener tecnologías activas de la categoría
     */
    public function getActiveTechnologiesList(): array
    {
        return $this->activeTechnologies()
                    ->pluck('name', 'id')
                    ->toArray();
    }

    /**
     * Resumen de la categoría
     */
    public function getSummary(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->localized_name,
            'slug' => $this->slug,
            'icon' => $this->icon_with_fallback,
            'color' => $this->color_with_fallback,
            'technologies_count' => $this->technologies_count,
            'active_technologies_count' => $this->active_technologies_count,
            'status' => $this->status_badge,
        ];
    }

    // ============================================
    // MÉTODOS ESTÁTICOS
    // ============================================

    /**
     * Obtener todas las categorías activas con sus tecnologías
     */
    public static function getActiveWithTechnologies()
    {
        return self::active()
                   ->with('activeTechnologies')
                   ->get();
    }

    /**
     * Buscar categoría por slug
     */
    public static function findBySlug(string $slug)
    {
        return self::where('slug', $slug)->first();
    }
}