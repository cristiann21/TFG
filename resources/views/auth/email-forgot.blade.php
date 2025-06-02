<!DOCTYPE html>
<html>
<head>
    <title>Restablecer Contraseña - PinCode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="PinCode Logo" class="logo">
        <h1>Restablecer Contraseña</h1>
    </div>

    <div class="content">
        <p>Hola,</p>
        
        <p>Has recibido este correo porque solicitaste restablecer tu contraseña en PinCode.</p>
        
        <p>Para restablecer tu contraseña, haz clic en el siguiente botón:</p>
        
        <div style="text-align: center;">
            <a href="{{ $resetUrl }}" class="button">Restablecer Contraseña</a>
        </div>
        
        <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>
        
        <p>Este enlace expirará en 24 horas.</p>
    </div>

    <div class="footer">
        <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
        <p>&copy; {{ date('Y') }} PinCode. Todos los derechos reservados.</p>
    </div>
</body>
</html>
