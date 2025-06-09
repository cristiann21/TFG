@extends('layouts.app', ['title' => 'Recuperar Contraseña - PinCode', 'hideFooter' => true, 'hideHeader' => true])

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="postit-note  auth-card">
            <h2>Recuperar Contraseña</h2>
            <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña</p>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                @csrf
                
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') border-red-500 @enderror" value="{{ old('email') }}" autofocus>
                    @error('email')
                        <span style="color: red; text-sm mt-1 block">El correo electrónico no está registrado</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">
                    Enviar enlace de recuperación
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