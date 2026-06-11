<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla
     */
    protected $table = 'documents';

    /**
     * Campos asignables en masa
     */
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_name',
        'icon_class',
        'color',
        'download_count',
        'is_active',
    ];

    /**
     * Casteo de tipos de datos
     */
    protected $casts = [
        'download_count' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope: Solo documentos activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Buscar por título o descripción
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('title', 'like', "%{$term}%")
                     ->orWhere('description', 'like', "%{$term}%");
    }

    /**
     * Scope: Ordenar por más descargados
     */
    public function scopeMostDownloaded($query)
    {
        return $query->orderBy('download_count', 'desc');
    }

    /**
     * Scope: Ordenar por más recientes
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * URL completa del archivo
     */
    public function getFileUrlAttribute(): string
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return '#';
    }

    /**
     * URL de descarga (con tracking)
     */
    public function getDownloadUrlAttribute(): string
    {
        return route('frontend.documents.download', $this->id);
    }

    /**
     * Icono con fallback
     */
    public function getIconWithFallbackAttribute(): string
    {
        return $this->icon_class ?? 'fas fa-file-pdf';
    }

    /**
     * Color con fallback
     */
    public function getColorWithFallbackAttribute(): string
    {
        return $this->color ?? '#ef4444';
    }

    /**
     * Extensión del archivo
     */
    public function getFileExtensionAttribute(): string
    {
        return strtoupper(pathinfo($this->file_name, PATHINFO_EXTENSION));
    }

    /**
     * Verificar si es PDF
     */
    public function getIsPdfAttribute(): bool
    {
        return strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION)) === 'pdf';
    }

    /**
     * Verificar si ha sido descargado
     */
    public function getHasDownloadsAttribute(): bool
    {
        return $this->download_count > 0;
    }

    /**
     * Descargas formateadas
     */
    public function getFormattedDownloadsAttribute(): string
    {
        if ($this->download_count === 0) {
            return 'Sin descargas';
        } elseif ($this->download_count === 1) {
            return '1 descarga';
        } else {
            return number_format($this->download_count) . ' descargas';
        }
    }

    // ============================================
    // MUTATORS
    // ============================================

    /**
     * Limpiar título
     */
    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = trim($value);
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
     * Verificar si el documento está visible
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
     * Incrementar contador de descargas
     */
    public function incrementDownloads(): bool
    {
        $this->download_count++;
        return $this->save();
    }

    /**
     * Resetear contador de descargas
     */
    public function resetDownloads(): bool
    {
        $this->download_count = 0;
        return $this->save();
    }

    /**
     * Verificar si el archivo existe en storage
     */
    public function fileExists(): bool
    {
        return Storage::disk('public')->exists($this->file_path);
    }

    /**
     * Obtener ruta completa del archivo en servidor
     */
    public function getFullPath(): string
    {
        return storage_path('app/public/' . $this->file_path);
    }

    /**
     * Verificar si tiene descripción
     */
    public function hasDescription(): bool
    {
        return !empty($this->description);
    }

    /**
     * Resumen del documento
     */
    public function getSummary(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'file_name' => $this->file_name,
            'file_extension' => $this->file_extension,
            'file_url' => $this->file_url,
            'download_url' => $this->download_url,
            'downloads' => $this->download_count,
            'icon' => $this->icon_with_fallback,
            'color' => $this->color_with_fallback,
            'is_active' => $this->is_active,
        ];
    }

    // ============================================
    // MÉTODOS ESTÁTICOS
    // ============================================

    /**
     * Obtener estadísticas generales
     */
    public static function getStats(): array
    {
        return [
            'total_documents' => self::active()->count(),
            'total_downloads' => self::sum('download_count'),
            'most_downloaded' => self::active()->mostDownloaded()->first(),
        ];
    }
}