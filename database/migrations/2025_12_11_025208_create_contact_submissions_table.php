<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Mensajes de contacto del portafolio
     */
    public function up(): void
    {
        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            
            // ============================================
            // INFORMACIÓN DEL REMITENTE
            // ============================================
            $table->string('name')
                ->comment('Nombre completo del remitente');
            
            $table->string('email')
                ->comment('Correo electrónico del remitente');
            
            $table->string('phone', 20)
                ->nullable()
                ->comment('Teléfono del remitente (opcional, formato internacional)');
            
            // ============================================
            // CONTENIDO DEL MENSAJE
            // ============================================
            $table->string('subject')
                ->nullable()
                ->comment('Asunto del mensaje (opcional)');
            
            $table->text('message')
                ->comment('Mensaje completo del remitente');
            
            // ============================================
            // ESTADO Y SEGUIMIENTO
            // ============================================
            $table->boolean('is_read')
                ->default(false)
                ->comment('Indica si el mensaje ha sido leído');
            
            $table->timestamp('replied_at')
                ->nullable()
                ->comment('Fecha y hora de respuesta');
            
            // ============================================
            // SEGURIDAD Y AUDITORÍA
            // ============================================
            $table->string('ip_address', 45)
                ->nullable()
                ->comment('Dirección IP del remitente (IPv4 o IPv6)');
            
            $table->text('user_agent')
                ->nullable()
                ->comment('Navegador y sistema operativo del remitente');
            
            $table->timestamps();
            
            // ============================================
            // ÍNDICES
            // ============================================
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
    }
};