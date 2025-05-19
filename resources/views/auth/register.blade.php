@extends('layouts.app', ['title' => 'Registro - EduCreativo'])

@section('content')
<div class="auth-container notebook-bg">
    <div class="container">
        <div class="auth-box">
            <a href="{{ route('home') }}" class="logo-link">
                <img src="{{ asset('images/logo-edu.png') }}" alt="Logo" class="logo-small">
                <h1>PinCode</h1>
            </a>
            
            <div class="postit-note yellow-note auth-form-container">
                <h2>Crear una Cuenta</h2>
                
                @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
                
                <form action="{{ route('register') }}" method="post" class="auth-form">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nombre Completo</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Tu nombre" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="tu@email.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                    </div>
                    
                    <div class="form-terms">
                        <input type="checkbox" id="accept_terms" name="accept_terms" {{ old('accept_terms') ? 'checked' : '' }}>
                        <label for="accept_terms">
                            Acepto los <a href="#">Términos y Condiciones</a> y la <a href="#">Política de Privacidad</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-yellow">Registrarse</button>
                </form>
                
                <div class="auth-links">
                    <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia Sesión</a></p>
                </div>
                
                <div class="note-corner"></div>
            </div>
            
            <div class="back-link">
                <a href="{{ route('home') }}">← Volver a la página principal</a>
            </div>
        </div>
    </div>
</div>
@endsection