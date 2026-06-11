<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContactSubmission extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla
     */
    protected $table = 'contact_submissions';

    /**
     * Campos asignables en masa
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'is_read',
        'replied_at',
        'ip_address',
        'user_agent',
    ];

    /**
     * Casteo de tipos de datos
     */
    protected $casts = [
        'is_read' => 'boolean',
        'replied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope: Mensajes no leídos
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: Mensajes leídos
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope: Mensajes respondidos
     */
    public function scopeReplied($query)
    {
        return $query->whereNotNull('replied_at');
    }

    /**
     * Scope: Mensajes pendientes (sin responder)
     */
    public function scopePending($query)
    {
        return $query->whereNull('replied_at');
    }

    /**
     * Scope: Mensajes recientes (últimos 7 días)
     */
    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', now()->subDays(7));
    }

    /**
     * Scope: Mensajes de hoy
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope: Buscar por nombre, email o asunto
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('subject', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%");
        });
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * Badge de estado (texto)
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->is_read ? 'Leído' : 'No Leído';
    }

    /**
     * Badge de estado (color)
     */
    public function getStatusColorAttribute(): string
    {
        return $this->is_read ? 'success' : 'warning';
    }

    /**
     * Badge de estado de respuesta (texto)
     */
    public function getReplyStatusBadgeAttribute(): string
    {
        return $this->replied_at ? 'Respondido' : 'Pendiente';
    }

    /**
     * Badge de estado de respuesta (color)
     */
    public function getReplyStatusColorAttribute(): string
    {
        return $this->replied_at ? 'info' : 'secondary';
    }

    /**
     * Fecha formateada (d/m/Y H:i)
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * Tiempo transcurrido
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Mensaje truncado (para listas)
     */
    public function getTruncatedMessageAttribute(): string
    {
        return Str::limit($this->message, 100);
    }

    /**
     * Asunto truncado
     */
    public function getTruncatedSubjectAttribute(): string
    {
        return Str::limit($this->subject ?? 'Sin asunto', 50);
    }

    /**
     * Teléfono formateado (si existe)
     */
    public function getFormattedPhoneAttribute(): ?string
    {
        return $this->phone ?? 'N/A';
    }

    /**
     * Link de WhatsApp
     */
    public function getWhatsappLinkAttribute(): ?string
    {
        if (!$this->phone) {
            return null;
        }

        $phone = str_replace(['+', ' ', '-'], '', $this->phone);
        $message = urlencode("Hola {$this->name}, gracias por contactarme.");
        
        return "https://wa.me/{$phone}?text={$message}";
    }

    /**
     * Link mailto
     */
    public function getMailtoLinkAttribute(): string
    {
        $subject = urlencode($this->subject ? "Re: {$this->subject}" : "Respuesta a tu consulta");
        $body = urlencode("Hola {$this->name},\n\nGracias por contactarme.\n\n");
        
        return "mailto:{$this->email}?subject={$subject}&body={$body}";
    }

    /**
     * Verificar si es reciente (menos de 24 horas)
     */
    public function getIsRecentAttribute(): bool
    {
        return $this->created_at->diffInHours() < 24;
    }

    /**
     * Navegador desde user agent
     */
    public function getBrowserAttribute(): string
    {
        if (empty($this->user_agent)) {
            return 'Desconocido';
        }

        if (str_contains($this->user_agent, 'Edg')) return 'Edge';
        if (str_contains($this->user_agent, 'Chrome')) return 'Chrome';
        if (str_contains($this->user_agent, 'Firefox')) return 'Firefox';
        if (str_contains($this->user_agent, 'Safari')) return 'Safari';
        
        return 'Otro';
    }

    /**
     * Sistema operativo desde user agent
     */
    public function getOperatingSystemAttribute(): string
    {
        if (empty($this->user_agent)) {
            return 'Desconocido';
        }

        if (str_contains($this->user_agent, 'Windows')) return 'Windows';
        if (str_contains($this->user_agent, 'Mac')) return 'macOS';
        if (str_contains($this->user_agent, 'Linux')) return 'Linux';
        if (str_contains($this->user_agent, 'Android')) return 'Android';
        if (str_contains($this->user_agent, 'iOS')) return 'iOS';
        
        return 'Otro';
    }

    /**
     * Verificar si es móvil
     */
    public function getIsMobileAttribute(): bool
    {
        if (empty($this->user_agent)) {
            return false;
        }

        return str_contains($this->user_agent, 'Mobile') || 
               str_contains($this->user_agent, 'Android') ||
               str_contains($this->user_agent, 'iPhone');
    }

    // ============================================
    // MUTATORS
    // ============================================

    /**
     * Limpiar y formatear nombre
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = ucwords(strtolower(trim($value)));
    }

    /**
     * Email a minúsculas
     */
    public function setEmailAttribute($value): void
    {
        $this->attributes['email'] = strtolower(trim($value));
    }

    /**
     * Limpiar teléfono (solo números y +)
     */
    public function setPhoneAttribute($value): void
    {
        $this->attributes['phone'] = $value ? preg_replace('/[^0-9+]/', '', $value) : null;
    }

    // ============================================
    // MÉTODOS HELPER
    // ============================================

    /**
     * Marcar como leído
     */
    public function markAsRead(): bool
    {
        $this->is_read = true;
        return $this->save();
    }

    /**
     * Marcar como no leído
     */
    public function markAsUnread(): bool
    {
        $this->is_read = false;
        return $this->save();
    }

    /**
     * Marcar como respondido
     */
    public function markAsReplied(): bool
    {
        $this->replied_at = now();
        $this->is_read = true;
        return $this->save();
    }

    /**
     * Alternar estado de lectura
     */
    public function toggleRead(): bool
    {
        $this->is_read = !$this->is_read;
        return $this->save();
    }

    /**
     * Resumen del mensaje
     */
    public function getSummary(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->formatted_phone,
            'subject' => $this->subject ?? 'Sin asunto',
            'status' => $this->status_badge,
            'reply_status' => $this->reply_status_badge,
            'time_ago' => $this->time_ago,
            'is_recent' => $this->is_recent,
            'browser' => $this->browser,
            'os' => $this->operating_system,
        ];
    }

    /**
     * Estadísticas para dashboard
     */
    public static function getStatistics(): array
    {
        return [
            'total' => self::count(),
            'today' => self::today()->count(),
            'unread' => self::unread()->count(),
            'pending' => self::pending()->count(),
        ];
    }
}