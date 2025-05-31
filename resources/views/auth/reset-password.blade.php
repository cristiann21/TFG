@extends('layouts.app', ['title' => 'Restablecer Contraseña - PinCode', 'hideFooter' => true, 'hideHeader' => true])

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="postit-note auth-card">
            <h2>Restablecer Contraseña</h2>
            <p>Ingresa tu nueva contraseña para continuar</p>
            
            <form method="POST" action="{{ route('password.update') }}" class="auth-form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>El correo electrónico no está registrado</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">Nueva contraseña</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>La contraseña debe tener al menos 6 caracteres</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    Restablecer Contraseña
                </button>
            </form>

            <div class="auth-links">
                <p>¿Recordaste tu contraseña? <a href="{{ route('login') }}">Inicia sesión</a></p>
            </div>
            <div class="note-corner"></div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
