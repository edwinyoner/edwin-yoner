<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla
     */
    protected $table = 'projects';

    /**
     * Campos asignables en masa
     */
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'long_description',
        'thumbnail_image',
        'video_url',
        'project_url',
        'repository_url',
        'year',
        'is_active',
    ];

    /**
     * Casteo de tipos de datos
     */
    protected $casts = [
        'year' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Relación: Un proyecto tiene muchas imágenes en galería
     */
    public function galleries()
    {
        return $this->hasMany(ProjectGallery::class, 'project_id');
    }

    /**
     * Relación: Un proyecto usa muchas tecnologías (many-to-many)
     */
    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'project_technology', 'project_id', 'technology_id')
                    ->withTimestamps();
    }

    /**
     * Relación: Solo tecnologías activas
     */
    public function activeTechnologies()
    {
        return $this->belongsToMany(Technology::class, 'project_technology', 'project_id', 'technology_id')
                    ->where('technologies.is_active', true)
                    ->withTimestamps();
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope: Solo proyectos activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filtrar por año
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Scope: Proyectos recientes (último año)
     */
    public function scopeRecent($query)
    {
        return $query->where('year', '>=', now()->year - 1);
    }

    /**
     * Scope: Buscar por título o descripción
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('title', 'like', "%{$term}%")
                     ->orWhere('short_description', 'like', "%{$term}%")
                     ->orWhere('slug', 'like', "%{$term}%");
    }

    /**
     * Scope: Buscar por slug
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * Scope: Ordenar por más reciente
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('year', 'desc')->orderBy('created_at', 'desc');
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * URL completa de la imagen thumbnail
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail_image) {
            return asset('storage/' . $this->thumbnail_image);
        }
        
        return asset('images/default-project.jpg');
    }

    /**
     * Badge de estado
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->is_active ? 'Activo' : 'Inactivo';
    }

    /**
     * Color del badge de estado
     */
    public function getStatusColorAttribute(): string
    {
        return $this->is_active ? 'success' : 'secondary';
    }

    /**
     * Descripción corta truncada (para cards)
     */
    public function getShortDescriptionExcerptAttribute(): string
    {
        if (!$this->short_description) {
            return '';
        }
        return Str::limit($this->short_description, 120);
    }

    /**
     * Descripción larga truncada (preview en modal)
     */
    public function getLongDescriptionExcerptAttribute(): string
    {
        if (!$this->long_description) {
            return '';
        }
        return Str::limit($this->long_description, 300);
    }

    /**
     * Año formateado
     */
    public function getFormattedYearAttribute(): string
    {
        return $this->year ? (string)$this->year : 'N/A';
    }

    /**
     * Verificar si tiene video demo
     */
    public function getHasVideoAttribute(): bool
    {
        return !empty($this->video_url);
    }

    /**
     * Verificar si tiene URL de proyecto en producción
     */
    public function getHasProjectUrlAttribute(): bool
    {
        return !empty($this->project_url);
    }

    /**
     * Verificar si tiene repositorio
     */
    public function getHasRepositoryAttribute(): bool
    {
        return !empty($this->repository_url);
    }

    /**
     * ID del video de YouTube (si es YouTube)
     */
    public function getYoutubeIdAttribute(): ?string
    {
        if (!$this->video_url) {
            return null;
        }

        // Extraer ID de YouTube de diferentes formatos
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $this->video_url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * URL embed de YouTube
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (!$this->youtube_id) {
            return null;
        }

        return "https://www.youtube.com/embed/{$this->youtube_id}";
    }

    /**
     * Thumbnail de YouTube
     */
    public function getYoutubeThumbnailAttribute(): ?string
    {
        if (!$this->youtube_id) {
            return null;
        }

        return "https://img.youtube.com/vi/{$this->youtube_id}/maxresdefault.jpg";
    }

    /**
     * Contador de imágenes en galería
     */
    public function getGalleriesCountAttribute(): int
    {
        return $this->galleries()->count();
    }

    /**
     * Contador de tecnologías usadas
     */
    public function getTechnologiesCountAttribute(): int
    {
        return $this->technologies()->count();
    }

    /**
     * Lista de nombres de tecnologías
     */
    public function getTechnologiesListAttribute(): array
    {
        return $this->activeTechnologies()
                    ->pluck('name')
                    ->toArray();
    }

    /**
     * Tecnologías agrupadas por categoría
     */
    public function getTechnologiesByCategoryAttribute()
    {
        return $this->activeTechnologies()
                    ->with('category')
                    ->get()
                    ->groupBy('category.name');
    }

    /**
     * Verificar si es proyecto reciente (último año)
     */
    public function getIsRecentAttribute(): bool
    {
        return $this->year >= now()->year - 1;
    }

    // ============================================
    // MUTATORS
    // ============================================

    /**
     * Generar slug automáticamente desde el título
     */
    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = trim($value);
        
        // Auto-generar slug si no existe
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    /**
     * Formatear slug
     */
    public function setSlugAttribute($value): void
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Validar año (entre 2000 y año actual + 1)
     */
    public function setYearAttribute($value): void
    {
        if ($value) {
            $currentYear = now()->year;
            $this->attributes['year'] = max(2000, min($currentYear + 1, (int)$value));
        } else {
            $this->attributes['year'] = null;
        }
    }

    // ============================================
    // MÉTODOS HELPER
    // ============================================

    /**
     * Verificar si el proyecto está visible
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
     * Verificar si tiene galería de imágenes
     */
    public function hasGallery(): bool
    {
        return $this->galleries()->exists();
    }

    /**
     * Verificar si tiene tecnologías asociadas
     */
    public function hasTechnologies(): bool
    {
        return $this->technologies()->exists();
    }

    /**
     * Asociar tecnologías al proyecto (sync)
     */
    public function syncTechnologies(array $technologyIds): void
    {
        $this->technologies()->sync($technologyIds);
    }

    /**
     * Agregar una tecnología al proyecto
     */
    public function addTechnology(int $technologyId): void
    {
        $this->technologies()->attach($technologyId);
    }

    /**
     * Remover una tecnología del proyecto
     */
    public function removeTechnology(int $technologyId): void
    {
        $this->technologies()->detach($technologyId);
    }

    /**
     * Obtener todas las URLs del proyecto
     */
    public function getLinks(): array
    {
        return [
            'project' => $this->project_url,
            'repository' => $this->repository_url,
            'video' => $this->video_url,
        ];
    }

    /**
     * Resumen del proyecto
     */
    public function getSummary(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'year' => $this->formatted_year,
            'thumbnail' => $this->thumbnail_url,
            'technologies' => $this->technologies_list,
            'galleries_count' => $this->galleries_count,
            'has_video' => $this->has_video,
            'has_demo' => $this->has_project_url,
            'has_repository' => $this->has_repository,
            'status' => $this->status_badge,
        ];
    }

    // ============================================
    // MÉTODOS ESTÁTICOS
    // ============================================

    /**
     * Buscar proyecto por slug
     */
    public static function findBySlug(string $slug)
    {
        return self::where('slug', $slug)
                   ->with(['galleries', 'technologies.category'])
                   ->first();
    }

    /**
     * Obtener proyectos destacados (con eager loading)
     */
    public static function getFeatured(int $limit = 6)
    {
        return self::active()
                   ->with(['technologies'])
                   ->latest()
                   ->limit($limit)
                   ->get();
    }

    /**
     * Obtener todos los años de proyectos (para filtros)
     */
    public static function getAvailableYears(): array
    {
        return self::active()
                   ->whereNotNull('year')
                   ->distinct()
                   ->orderBy('year', 'desc')
                   ->pluck('year')
                   ->toArray();
    }
}