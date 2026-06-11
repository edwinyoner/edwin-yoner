{{-- resources/views/emails/contact-submission.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nuevo Mensaje de Contacto - {{ company('short_name') }}</title>
    <style>
        /* ================================================ */
        /* Reset básico */
        /* ================================================ */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', 'Helvetica', sans-serif;
            background-color: #f4f4f4;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ================================================ */
        /* Contenedor principal */
        /* ================================================ */
        .email-wrapper {
            width: 100%;
            background-color: #f4f4f4;
            padding: 20px 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* ================================================ */
        /* Header - USA COLORES DINÁMICOS */
        /* ================================================ */
        .email-header {
            /* 🎨 GRADIENTE DINÁMICO desde la BD */
            background: linear-gradient(135deg, {{ color('primary') }} 0%, {{ color('secondary') }} 100%);
            color: {{ color('text_light') }};
            padding: 30px 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .email-header p {
            margin: 10px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }

        /* ================================================ */
        /* Contenido */
        /* ================================================ */
        .email-body {
            padding: 30px 20px;
        }

        /* Alerta (colores semánticos - se mantienen fijos) */
        .alert-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 4px;
        }

        .alert-box p {
            margin: 0;
            color: #856404;
            font-size: 14px;
            font-weight: 600;
        }

        /* ================================================ */
        /* Información del remitente */
        /* ================================================ */
        .sender-info {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .sender-info h2 {
            margin: 0 0 15px 0;
            font-size: 18px;
            color: #333333;
            /* 🎨 BORDE DINÁMICO con color corporativo */
            border-bottom: 2px solid {{ color('primary') }};
            padding-bottom: 10px;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 12px;
        }

        .info-label {
            display: table-cell;
            width: 30%;
            font-weight: 700;
            color: #555555;
            font-size: 14px;
            vertical-align: top;
            padding-right: 10px;
        }

        .info-value {
            display: table-cell;
            width: 70%;
            color: #333333;
            font-size: 14px;
            word-break: break-word;
        }

        .info-value a {
            /* 🎨 LINKS con color corporativo */
            color: {{ color('primary') }};
            text-decoration: none;
        }

        .info-value a:hover {
            text-decoration: underline;
        }

        /* ================================================ */
        /* Mensaje */
        /* ================================================ */
        .message-box {
            background-color: #ffffff;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .message-box h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
            color: #333333;
            font-weight: 700;
        }

        .message-content {
            color: #555555;
            font-size: 14px;
            line-height: 1.6;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        /* ================================================ */
        /* Metadatos */
        /* ================================================ */
        .metadata {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .metadata h4 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #666666;
            font-weight: 700;
        }

        .metadata-row {
            font-size: 12px;
            color: #777777;
            margin-bottom: 5px;
        }

        .metadata-label {
            font-weight: 600;
            color: #555555;
        }

        /* ================================================ */
        /* Botones de acción - COLORES DINÁMICOS */
        /* ================================================ */
        .action-buttons {
            text-align: center;
            margin: 25px 0;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        /* 🎨 BOTÓN PRIMARIO con color corporativo */
        .btn-primary {
            background-color: {{ color('primary') }};
            color: {{ color('text_light') }} !important;
        }

        .btn-primary:hover {
            /* 🎨 Hover 20 tonos más oscuro */
            background-color: {{ adjustBrightness(color('primary'), -20) }};
        }

        /* Botón de WhatsApp (color semántico fijo) */
        .btn-success {
            background-color: #25d366;
            color: #ffffff !important;
        }

        .btn-success:hover {
            background-color: #1da851;
        }

        /* ================================================ */
        /* Footer */
        /* ================================================ */
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .email-footer p {
            margin: 5px 0;
            color: #666666;
            font-size: 12px;
        }

        .email-footer a {
            /* 🎨 LINKS del footer con color corporativo */
            color: {{ color('primary') }};
            text-decoration: none;
        }

        /* ================================================ */
        /* Badges */
        /* ================================================ */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Badges semánticos (colores fijos para claridad) */
        .badge-dni {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .badge-ruc {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }

        .badge-new {
            background-color: #fff3cd;
            color: #856404;
        }

        /* ================================================ */
        /* Responsive */
        /* ================================================ */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: 0 !important;
                border-radius: 0 !important;
            }

            .email-header h1 {
                font-size: 20px;
            }

            .email-body {
                padding: 20px 15px;
            }

            .info-row {
                display: block;
            }

            .info-label,
            .info-value {
                display: block;
                width: 100%;
            }

            .info-label {
                margin-bottom: 5px;
            }

            .btn {
                display: block;
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            
            {{-- ============================================ --}}
            {{-- HEADER --}}
            {{-- ============================================ --}}
            <div class="email-header">
                <h1>📧 Nuevo Mensaje de Contacto</h1>
                <p>Has recibido un nuevo mensaje desde el formulario de contacto web</p>
            </div>

            {{-- ============================================ --}}
            {{-- BODY --}}
            {{-- ============================================ --}}
            <div class="email-body">
                
                {{-- Alerta de nuevo mensaje --}}
                <div class="alert-box">
                    <p>
                        ⚠️ <strong>Acción requerida:</strong> 
                        Este es un nuevo mensaje de contacto que requiere tu atención.
                    </p>
                </div>

                {{-- Información del Remitente --}}
                <div class="sender-info">
                    <h2>👤 Información del Remitente</h2>

                    <div class="info-row">
                        <div class="info-label">Nombre:</div>
                        <div class="info-value">
                            <strong>{{ $submission->name }}</strong>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Email:</div>
                        <div class="info-value">
                            <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Teléfono:</div>
                        <div class="info-value">
                            <a href="tel:{{ $submission->phone }}">{{ $submission->formatted_phone }}</a>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Documento:</div>
                        <div class="info-value">
                            <span class="badge {{ $submission->document_type == 'DNI' ? 'badge-dni' : 'badge-ruc' }}">
                                {{ $submission->document_type }}
                            </span>
                            {{ $submission->dni_ruc }}
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Asunto:</div>
                        <div class="info-value">
                            <strong>{{ $submission->subject }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Mensaje --}}
                <div class="message-box">
                    <h3>💬 Mensaje:</h3>
                    <div class="message-content">{{ $submission->message }}</div>
                </div>

                {{-- Botones de Acción --}}
                <div class="action-buttons">
                    <a href="mailto:{{ $submission->email }}?subject=Re: {{ urlencode($submission->subject) }}" 
                       class="btn btn-primary">
                        ✉️ Responder por Email
                    </a>
                    <a href="{{ $submission->whatsapp_link }}" 
                       class="btn btn-success" 
                       target="_blank">
                        📱 Responder por WhatsApp
                    </a>
                </div>

                {{-- Metadatos --}}
                <div class="metadata">
                    <h4>📊 Información Técnica</h4>
                    
                    <div class="metadata-row">
                        <span class="metadata-label">ID de Envío:</span> 
                        #{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}
                    </div>
                    
                    <div class="metadata-row">
                        <span class="metadata-label">Fecha y Hora:</span> 
                        {{ $submittedAt }}
                    </div>
                    
                    <div class="metadata-row">
                        <span class="metadata-label">Dirección IP:</span> 
                        {{ $submission->ip_address ?? 'No disponible' }}
                    </div>
                    
                    <div class="metadata-row">
                        <span class="metadata-label">Navegador:</span> 
                        {{ $submission->browser }} 
                        @if($submission->is_mobile)
                            <span class="badge badge-new">📱 Móvil</span>
                        @endif
                    </div>
                    
                    <div class="metadata-row">
                        <span class="metadata-label">Sistema Operativo:</span> 
                        {{ $submission->operating_system }}
                    </div>
                </div>

                {{-- Enlace al Dashboard (opcional) --}}
                {{-- 
                <div style="text-align: center; margin-top: 20px;">
                    <p style="color: #666; font-size: 13px; margin-bottom: 10px;">
                        Puedes gestionar este mensaje desde el panel de administración:
                    </p>
                    <a href="{{ route('backend.contact-submissions.show', $submission) }}" 
                       class="btn btn-primary"
                       style="font-size: 13px; padding: 10px 25px;">
                        🔗 Ver en Dashboard
                    </a>
                </div>
                --}}

            </div>

            {{-- ============================================ --}}
            {{-- FOOTER DINÁMICO --}}
            {{-- ============================================ --}}
            <div class="email-footer">
                <p>
                    <strong>{{ company('company_name') }}</strong><br>
                    {{ company('tagline') }}
                </p>
                <p>
                    📧 <a href="mailto:{{ company('email_contact') }}">{{ company('email_contact') }}</a> | 
                    🌐 <a href="{{ url('/') }}" target="_blank">{{ config('app.url') }}</a>
                </p>
                <p style="color: #999; font-size: 11px; margin-top: 15px;">
                    Este es un mensaje automático generado por el sistema de contacto web.<br>
                    Por favor, no responder directamente a este correo.
                </p>
            </div>

        </div>
    </div>
</body>
</html>