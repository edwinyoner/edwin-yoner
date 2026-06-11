<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a {{ $ownerName }} - Panel de Administración</title>
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
        .welcome-section {
            text-align: center;
            margin-bottom: 35px;
        }
        .welcome-section h2 {
            color: {{ $primaryColor }};
            font-size: 26px;
            margin-bottom: 12px;
            font-weight: 600;
        }
        .welcome-section p {
            color: #555;
            font-size: 16px;
            margin-bottom: 0;
        }
        .credentials-box {
            background: #f9f9f9;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            border-left: 5px solid {{ $primaryColor }};
            box-shadow: 0 4px 15px rgba({{ $primaryColorRGB }}, 0.08);
        }
        .credentials-box h3 {
            color: {{ $primaryColor }};
            margin: 0 0 20px 0;
            font-size: 20px;
            font-weight: 600;
        }
        .credential-item {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
            padding: 12px 15px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        .credential-label {
            font-weight: 600;
            color: #4b4b4b;
            width: 110px;
            flex-shrink: 0;
            font-size: 15px;
        }
        .credential-value {
            color: {{ $primaryColor }};
            font-family: 'Courier New', monospace;
            font-weight: 500;
            font-size: 15px;
            word-break: break-all;
        }
        .verification-section {
            background: linear-gradient(135deg, {{ $primaryColorLight }} 0%, {{ $primaryColorLighter }} 100%);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 35px 0;
            border: 1px dashed {{ $primaryColor }};
        }
        .verification-section h3 {
            color: {{ $primaryColor }};
            margin: 0 0 15px 0;
            font-size: 20px;
        }
        .verification-section p {
            color: #555;
            margin-bottom: 25px;
            font-size: 15px;
        }
        .btn-verify {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 700;
            font-size: 17px;
            box-shadow: 0 8px 25px rgba({{ $primaryColorRGB }}, 0.3);
            transition: all 0.3s ease;
        }
        .btn-verify:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba({{ $primaryColorRGB }}, 0.4);
        }
        .login-section {
            text-align: center;
            margin: 30px 0;
        }
        .btn-login {
            display: inline-block;
            padding: 12px 35px;
            background-color: #4b4b4b;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #333;
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
            font-weight: 500;
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
                padding: 25px 20px;
            }
            .header {
                padding: 30px 15px;
            }
            .credential-item {
                flex-direction: column;
                align-items: flex-start;
            }
            .credential-label {
                width: auto;
                margin-bottom: 8px;
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
            <div class="welcome-section">
                <h2>¡Bienvenido, {{ $user->name }}!</h2>
                <p>Tu cuenta en el <strong>Panel de Administración del Portafolio</strong> ha sido creada exitosamente.</p>
            </div>

            <!-- Verificación de correo -->
            <div class="verification-section">
                <h3>Verifica tu correo electrónico</h3>
                <p>Para activar tu cuenta y garantizar la seguridad, por favor confirma tu dirección de correo haciendo clic en el botón:</p>
                <a href="{{ $verificationUrl }}" class="btn-verify">Verificar mi correo</a>
                <p style="font-size: 13px; color: #777; margin-top: 20px;">
                    Si el botón no funciona, copia y pega este enlace en tu navegador:<br>
                    <span class="url-highlight">{{ $verificationUrl }}</span>
                </p>
            </div>

            <!-- Credenciales -->
            <div class="credentials-box">
                <h3>Tus credenciales de acceso</h3>
                <p>Una vez verificado tu correo, podrás iniciar sesión con:</p>

                <div class="credential-item">
                    <div class="credential-label">Usuario:</div>
                    <div class="credential-value">{{ $user->email }}</div>
                </div>

                <div class="credential-item">
                    <div class="credential-label">Contraseña:</div>
                    <div class="credential-value">{{ $password }}</div>
                </div>
            </div>

            <!-- Acceso al sistema -->
            {{-- <div class="login-section">
                <p><strong>¿Listo para comenzar?</strong></p>
                <a href="{{ $loginUrl }}" class="btn-login" target="_blank">Iniciar sesión en el panel</a>
            </div> --}}

            <!-- Nota de seguridad -->
            <div class="security-note">
                <p><strong>Recomendación de seguridad:</strong> Cambia tu contraseña temporal después del primer inicio de sesión. Nunca compartas tus credenciales.</p>
            </div>

            <p style="color: #666; font-size: 14px; text-align: center; margin-top: 30px;">
                Si no solicitaste esta cuenta, ignora este correo. La cuenta será desactivada automáticamente si no se verifica en las próximas 24 horas.
            </p>
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