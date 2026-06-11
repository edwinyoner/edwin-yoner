<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla
     */
    protected $table = 'technologies';

    /**
     * Campos asignables en masa
     */
    protected $fillable = [
        'technologie_category_id',
        'name',
        'slug',
        'icon_path',
        'icon_class',
        'color',
        'proficiency_level',
        'proficiency_percentage',
        'is_active',
    ];

    /**
     * Casteo de tipos de datos
     */
    protected $casts = [
        'technologie_category_id' => 'integer',
        'proficiency_percentage' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Relación: Una tecnología pertenece a una categoría
     */
    public function category()
    {
        return $this->belongsTo(TechnologieCategory::class, 'technologie_category_id');
    }

    /**
     * Relación: Una tecnología puede estar en muchos proyectos (many-to-many)
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_technology', 'technology_id', 'project_id')
                    ->withTimestamps();
    }

    /**
     * Relación: Solo proyectos activos
     */
    public function activeProjects()
    {
        return $this->belongsToMany(Project::class, 'project_technology', 'technology_id', 'project_id')
                    ->where('is_active', true)
                    ->withTimestamps();
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope: Solo tecnologías activas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filtrar por categoría
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('technologie_category_id', $categoryId);
    }

    /**
     * Scope: Filtrar por nivel de dominio
     */
    public function scopeByProficiency($query, $level)
    {
        return $query->where('proficiency_level', $level);
    }

    /**
     * Scope: Solo tecnologías expertas
     */
    public function scopeExpert($query)
    {
        return $query->where('proficiency_level', 'experto');
    }

    /**
     * Scope: Solo tecnologías avanzadas o expertas
     */
    public function scopeHighLevel($query)
    {
        return $query->whereIn('proficiency_level', ['avanzado', 'experto']);
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
     * URL del icono completa
     */
    public function getIconUrlAttribute(): ?string
    {
        if ($this->icon_path) {
            return asset('storage/' . $this->icon_path);
        }
        return null;
    }

    /**
     * Icono (path o class) con fallback
     */
    public function getIconAttribute(): string
    {
        return $this->icon_path ?? $this->icon_class ?? 'fas fa-code';
    }

    /**
     * Color con fallback
     */
    public function getColorWithFallbackAttribute(): string
    {
        return $this->color ?? '#3b82f6';
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
     * Nivel de dominio en español
     */
    public function getProficiencyLabelAttribute(): string
    {
        return match($this->proficiency_level) {
            'basico' => 'Básico',
            'intermedio' => 'Intermedio',
            'avanzado' => 'Avanzado',
            'experto' => 'Experto',
            default => 'Intermedio',
        };
    }

    /**
     * Nivel de dominio en inglés
     */
    public function getProficiencyLabelEnAttribute(): string
    {
        return match($this->proficiency_level) {
            'basico' => 'Basic',
            'intermedio' => 'Intermediate',
            'avanzado' => 'Advanced',
            'experto' => 'Expert',
            default => 'Intermediate',
        };
    }

    /**
     * Color del badge según nivel de dominio
     */
    public function getProficiencyColorAttribute(): string
    {
        return match($this->proficiency_level) {
            'basico' => 'info',
            'intermedio' => 'primary',
            'avanzado' => 'warning',
            'experto' => 'success',
            default => 'secondary',
        };
    }

    /**
     * Porcentaje formateado
     */
    public function getFormattedPercentageAttribute(): string
    {
        return $this->proficiency_percentage . '%';
    }

    /**
     * Nombre de la categoría
     */
    public function getCategoryNameAttribute(): string
    {
        return $this->category->name ?? 'Sin categoría';
    }

    /**
     * Contador de proyectos
     */
    public function getProjectsCountAttribute(): int
    {
        return $this->projects()->count();
    }

    /**
     * Contador de proyectos activos
     */
    public function getActiveProjectsCountAttribute(): int
    {
        return $this->activeProjects()->count();
    }

    /**
     * Verificar si es tecnología principal (alta dominio)
     */
    public function getIsMainTechnologyAttribute(): bool
    {
        return in_array($this->proficiency_level, ['avanzado', 'experto']);
    }

    // ============================================
    // MUTATORS
    // ============================================

    /**
     * Generar slug automáticamente desde el nombre
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = trim($value);
        
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

    /**
     * Validar porcentaje (0-100)
     */
    public function setProficiencyPercentageAttribute($value): void
    {
        $this->attributes['proficiency_percentage'] = max(0, min(100, (int)$value));
    }

    // ============================================
    // MÉTODOS HELPER
    // ============================================

    /**
     * Verificar si la tecnología está visible
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
     * Verificar si tiene icono de imagen (path)
     */
    public function hasIconImage(): bool
    {
        return !empty($this->icon_path);
    }

    /**
     * Verificar si tiene icono de clase (FontAwesome)
     */
    public function hasIconClass(): bool
    {
        return !empty($this->icon_class);
    }

    /**
     * Verificar si está en proyectos
     */
    public function isUsedInProjects(): bool
    {
        return $this->projects()->exists();
    }

    /**
     * Resumen de la tecnología
     */
    public function getSummary(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category' => $this->category_name,
            'icon_url' => $this->icon_url,
            'icon_class' => $this->icon_class,
            'color' => $this->color_with_fallback,
            'proficiency' => $this->proficiency_label,
            'percentage' => $this->proficiency_percentage,
            'projects_count' => $this->projects_count,
            'status' => $this->status_badge,
        ];
    }

    // ============================================
    // MÉTODOS ESTÁTICOS
    // ============================================

    /**
     * Obtener tecnologías principales (avanzado/experto)
     */
    public static function getMainTechnologies()
    {
        return self::active()
                   ->highLevel()
                   ->with('category')
                   ->get();
    }

    /**
     * Buscar tecnología por slug
     */
    public static function findBySlug(string $slug)
    {
        return self::where('slug', $slug)->first();
    }

    /**
     * Obtener tecnologías agrupadas por categoría
     */
    public static function getGroupedByCategory()
    {
        return self::active()
                   ->with('category')
                   ->get()
                   ->groupBy('category.name');
    }
}