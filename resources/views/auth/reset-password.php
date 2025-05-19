@extends('layouts.app', ['title' => 'Restablecer Contraseña - EduCreativo'])

@section('content')
<div class="auth-container notebook-bg">
    <div class="container">
        <div class="auth-box">
            <a href="{{ route('home') }}" class="logo-link">
                <img src="{{ asset('images/logo-edu.png') }}" alt="Logo" class="logo-small">
                <h1>PinCode</h1>
            </a>
            
            <div class="postit-note green-note auth-form-container">
                @if (session('status'))
                <div class="success-container">
                    <div class="success-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <h2>¡Correo Enviado!</h2>
                    <p>Hemos enviado un enlace de restablecimiento de contraseña a tu correo electrónico. Por favor revisa tu bandeja de entrada y sigue las instrucciones.</p>
                    <p class="small-text">Si no recibes el correo en unos minutos, revisa tu carpeta de spam.</p>
                </div>
                @else
                <h2>Restablecer Contraseña</h2>
                
                <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
                
                @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
                
                <form action="{{ route('password.email') }}" method="post" class="auth-form">
                    @csrf
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="tu@email.com" required>
                    </div>
                    
                    <button type="submit" class="btn btn-green">Enviar Enlace de Restablecimiento</button>
                </form>
                @endif
                
                <div class="note-corner"></div>
            </div>
            
            <div class="back-link">
                <a href="{{ route('login') }}">← Volver a Iniciar Sesión</a>
            </div>
        </div>
    </div>
</div>
@endsection