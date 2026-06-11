<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectGallery extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla
     */
    protected $table = 'project_galleries';

    /**
     * Campos asignables en masa
     */
    protected $fillable = [
        'project_id',
        'image_path',
        'caption',
    ];

    /**
     * Casteo de tipos de datos
     */
    protected $casts = [
        'project_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Relación: Una imagen pertenece a un proyecto
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * URL completa de la imagen
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return asset('images/default-gallery.jpg');
    }

    /**
     * Nombre del archivo
     */
    public function getFilenameAttribute(): string
    {
        return basename($this->image_path);
    }

    /**
     * Caption con fallback
     */
    public function getCaptionOrFilenameAttribute(): string
    {
        return $this->caption ?? $this->filename;
    }

    // ============================================
    // MUTATORS
    // ============================================

    /**
     * Limpiar caption
     */
    public function setCaptionAttribute($value): void
    {
        $this->attributes['caption'] = $value ? trim($value) : null;
    }

    // ============================================
    // MÉTODOS HELPER
    // ============================================

    /**
     * Verificar si tiene caption
     */
    public function hasCaption(): bool
    {
        return !empty($this->caption);
    }

    /**
     * Resumen de la imagen
     */
    public function getSummary(): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'image_url' => $this->image_url,
            'filename' => $this->filename,
            'caption' => $this->caption,
        ];
    }
}