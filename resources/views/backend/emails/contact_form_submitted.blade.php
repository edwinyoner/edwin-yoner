<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Mensaje de Contacto - {{ profile('full_name') }}</title>
    <style>
        body {
            margin: 0; padding: 0;
            font-family: 'Arial', 'Helvetica', sans-serif;
            background-color: #f4f4f4;
        }

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
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .email-header {
            background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }

        .email-header h1 { margin: 0; font-size: 24px; font-weight: 700; }
        .email-header p  { margin: 10px 0 0 0; font-size: 14px; opacity: 0.9; }

        .email-body { padding: 30px 20px; }

        .alert-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 4px;
        }

        .alert-box p { margin: 0; color: #856404; font-size: 14px; font-weight: 600; }

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
            border-bottom: 2px solid {{ $primaryColor }};
            padding-bottom: 10px;
        }

        .info-row    { display: table; width: 100%; margin-bottom: 12px; }
        .info-label  { display: table-cell; width: 30%; font-weight: 700; color: #555; font-size: 14px; vertical-align: top; padding-right: 10px; }
        .info-value  { display: table-cell; width: 70%; color: #333; font-size: 14px; word-break: break-word; }
        .info-value a { color: {{ $primaryColor }}; text-decoration: none; }

        .message-box {
            background-color: #ffffff;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .message-box h3 { margin: 0 0 10px 0; font-size: 16px; color: #333; font-weight: 700; }
        .message-content { color: #555; font-size: 14px; line-height: 1.6; white-space: pre-wrap; word-wrap: break-word; }

        .metadata {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .metadata h4      { margin: 0 0 10px 0; font-size: 14px; color: #666; font-weight: 700; }
        .metadata-row     { font-size: 12px; color: #777; margin-bottom: 5px; }
        .metadata-label   { font-weight: 600; color: #555; }

        .action-buttons { text-align: center; margin: 25px 0; }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-primary  { background-color: {{ $primaryColor }}; color: #000000 !important; }
        .btn-success  { background-color: #25d366; color: #ffffff !important; }

        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .email-footer p   { margin: 5px 0; color: #666; font-size: 12px; }
        .email-footer a   { color: {{ $primaryColor }}; text-decoration: none; }

        @media only screen and (max-width: 600px) {
            .email-container { width: 100% !important; border-radius: 0 !important; }
            .email-body { padding: 20px 15px; }
            .info-row, .info-label, .info-value { display: block; width: 100%; }
            .btn { display: block; width: 100%; margin: 10px 0; }
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    <div class="email-container">

        {{-- HEADER --}}
        <div class="email-header">
            <h1>📧 Nuevo Mensaje de Contacto</h1>
            <p>Has recibido un nuevo mensaje desde el formulario de contacto</p>
        </div>

        {{-- BODY --}}
        <div class="email-body">

            <div class="alert-box">
                <p>⚠️ <strong>Acción requerida:</strong> Este mensaje requiere tu atención.</p>
            </div>

            {{-- Información del remitente --}}
            <div class="sender-info">
                <h2>👤 Información del Remitente</h2>

                <div class="info-row">
                    <div class="info-label">Nombre:</div>
                    <div class="info-value"><strong>{{ $submission->name }}</strong></div>
                </div>

                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">
                        <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a>
                    </div>
                </div>

                @if($submission->phone)
                <div class="info-row">
                    <div class="info-label">Teléfono:</div>
                    <div class="info-value">
                        <a href="tel:{{ $submission->phone }}">{{ $submission->phone }}</a>
                    </div>
                </div>
                @endif

                @if($submission->subject)
                <div class="info-row">
                    <div class="info-label">Asunto:</div>
                    <div class="info-value"><strong>{{ $submission->subject }}</strong></div>
                </div>
                @endif

            </div>

            {{-- Mensaje --}}
            <div class="message-box">
                <h3>💬 Mensaje:</h3>
                <div class="message-content">{{ $submission->message }}</div>
            </div>

            {{-- Botones --}}
            <div class="action-buttons">
                <a href="{{ $submission->mailto_link }}" class="btn btn-primary">
                    ✉️ Responder por Email
                </a>
                @if($submission->whatsapp_link)
                <a href="{{ $submission->whatsapp_link }}" class="btn btn-success" target="_blank">
                    📱 Responder por WhatsApp
                </a>
                @endif
            </div>

            {{-- Metadatos --}}
            <div class="metadata">
                <h4>📊 Información Técnica</h4>

                <div class="metadata-row">
                    <span class="metadata-label">ID:</span>
                    #{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}
                </div>

                <div class="metadata-row">
                    <span class="metadata-label">Fecha:</span>
                    {{ $submittedAt }}
                </div>

                <div class="metadata-row">
                    <span class="metadata-label">IP:</span>
                    {{ $submission->ip_address ?? 'No disponible' }}
                </div>

                <div class="metadata-row">
                    <span class="metadata-label">Navegador:</span>
                    {{ $submission->browser }}
                    @if($submission->is_mobile) 📱 Móvil @endif
                </div>

                <div class="metadata-row">
                    <span class="metadata-label">Sistema:</span>
                    {{ $submission->operating_system }}
                </div>
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="email-footer">
            <p>
                <strong>{{ $ownerName }}</strong><br>
                {{ $ownerTitle }}
            </p>
            <p>
                📧 <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a> |
                🌐 <a href="{{ $websiteUrl }}" target="_blank">{{ $websiteDomain }}</a>
            </p>
            <p style="color:#999; font-size:11px; margin-top:15px;">
                Mensaje automático del sistema de contacto. No responder directamente.
            </p>
        </div>

    </div>
</div>
</body>
</html>