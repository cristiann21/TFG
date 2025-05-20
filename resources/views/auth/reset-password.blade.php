@extends('layouts.app', ['title' => 'Restablecer Contraseña'])

@section('content')
<div class="auth-container notebook-bg">
    <div class="container">
        <div class="auth-box">
            <div class="postit-note green-note auth-form-container">
                <h2>Restablecer Contraseña</h2>
                
                <form action="{{ route('password.update') }}" method="POST" class="auth-form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" 
                               value="{{ $email ?? old('email') }}" 
                               required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Nueva Contraseña</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" id="password_confirmation" 
                               name="password_confirmation" required>
                    </div>
                    
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    
                    <button type="submit" class="btn btn-green">Restablecer Contraseña</button>
                </form>
                
                <div class="note-corner"></div>
            </div>
        </div>
    </div>
</div>
@endsection
