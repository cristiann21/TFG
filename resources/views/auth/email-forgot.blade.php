<p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
<a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}">
    Restablecer Contraseña
</a>
<p>Si no solicitaste este cambio, ignora este correo.</p>
