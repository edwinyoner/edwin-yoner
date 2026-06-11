{{-- resources/views/emails/reset-password.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - {{ $ownerName }}</title>
    <style type="text/css">
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }
        .email-container {
            max-width: 620px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #cfcacb;
        }
        .header {
            background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header img {
            max-height: 60px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .reset-section {
            background: linear-gradient(135deg, {{ $primaryColorLight }} 0%, {{ $primaryColorLighter }} 100%);
            border-radius: 12px;
            padding: 35px;
            text-align: center;
            margin: 30px 0;
            border: 1px dashed {{ $primaryColor }};
        }
        .reset-section h3 {
            color: {{ $primaryColor }};
            margin: 0 0 15px 0;
            font-size: 22px;
            font-weight: 600;
        }
        .reset-section p {
            color: #555;
            margin-bottom: 25px;
            font-size: 16px;
        }
        .btn-reset {
            display: inline-block;
            padding: 16px 45px;
            background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 700;
            font-size: 18px;
            box-shadow: 0 8px 25px rgba({{ $primaryColorRGB }}, 0.3);
            transition: all 0.3s ease;
        }
        .btn-reset:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba({{ $primaryColorRGB }}, 0.4);
        }
        .security-note {
            background: #fff5f5;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
            border-left: 4px solid {{ $primaryColor }};
        }
        .security-note p {
            color: {{ $primaryColor }};
            margin: 0;
            font-size: 14px;
            font-weight: 500;
        }
        .footer {
            background-color: #4b4b4b;
            color: #cfcacb;
            text-align: center;
            padding: 30px 20px;
            font-size: 14px;
        }
        .footer a {
            color: #cfcacb;
            text-decoration: none;
            font-weight: 600;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .url-highlight {
            word-break: break-all;
            color: {{ $primaryColor }};
            font-weight: 500;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 12px;
            }
            .content {
                padding: 30px 20px;
            }
            .header {
                padding: 30px 15px;
            }
            .btn-reset {
                padding: 14px 35px;
                font-size: 17px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $ownerName }}">
            @else
                <h1>{{ $ownerName }}</h1>
            @endif
            <p>{{ $ownerTitle }}</p>
        </div>

        <!-- Contenido principal -->
        <div class="content">
            <div class="reset-section">
                <h3>Restablecer tu contraseña</h3>
                <p>Hola <strong>{{ $user->name }}</strong>,</p>
                <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en el <strong>Panel de Administración del Portafolio</strong>.</p>
                <p>Si fuiste tú quien lo solicitó, haz clic en el botón de abajo para crear una nueva contraseña:</p>

                <a href="{{ $url }}" class="btn-reset">Restablecer contraseña</a>

                <p style="font-size: 13px; color: #777; margin-top: 25px;">
                    Este enlace expirará en <strong>60 minutos</strong> por razones de seguridad.<br>
                    Si el botón no funciona, copia y pega esta URL en tu navegador:<br>
                    <span class="url-highlight">{{ $url }}</span>
                </p>
            </div>

            <!-- Nota de seguridad -->
            <div class="security-note">
                <p><strong>Importante:</strong> Si no solicitaste este cambio, puedes ignorar este mensaje de forma segura. Tu contraseña no cambiará hasta que hagas clic en el enlace y crees una nueva.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ $ownerName }}</strong></p>
            <p>{{ $ownerTitle }}</p>
            <p>© {{ date('Y') }} {{ $ownerName }}. Todos los derechos reservados.</p>
            @if($supportEmail)
                <p>Soporte: <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a></p>
            @endif
        </div>
    </div>
</body>
</html>