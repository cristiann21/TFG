@extends('layouts.app', ['title' => 'Iniciar Sesión - EduCreativo'])

@section('content')
<div class="auth-container notebook-bg">
    <div class="container">
        <div class="auth-box">
            <a href="{{ route('home') }}" class="logo-link">
                <img src="{{ asset('images/logo-edu.png') }}" alt="Logo" class="logo-small">
                <h1>PinCode</h1>
            </a>
            
            <div class="postit-note blue-note auth-form-container">
                <h2>Iniciar Sesión</h2>
                
                @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
                
                <form action="{{ route('login') }}" method="post" class="auth-form">
                    @csrf
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="tu@email.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                    
                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Recordarme</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password">¿Olvidaste tu contraseña?</a>
                    </div>
                    
                    <button type="submit" class="btn btn-blue">Iniciar Sesión</button>
                </form>
                
                <div class="auth-links">
                    <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
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