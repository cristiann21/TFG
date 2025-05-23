<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recuperar Contraseña - PinCode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        h1 {
            color: #2563eb;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('images/logo.png') }}" alt="PinCode Logo" class="logo">
        <h1>Recuperar Contraseña</h1>
        <p>Hola,</p>
        <p>Hemos recibido una solicitud para restablecer tu contraseña en PinCode. Si no realizaste esta solicitud, puedes ignorar este correo.</p>
        <p>Para restablecer tu contraseña, haz clic en el siguiente botón:</p>
        <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" class="button">
            Restablecer Contraseña
        </a>
        <p>Este enlace expirará en 60 minutos por razones de seguridad.</p>
        <div class="footer">
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
            <p>&copy; {{ date('Y') }} PinCode. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
