@extends('layouts.app', ['title' => 'Registro - PinCode', 'hideFooter' => true, 'hideHeader' => true])

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="postit-note yellow-note auth-card">
            <h2>Crear Cuenta</h2>
            <p>¡Únete a nuestra comunidad! Crea tu cuenta para comenzar.</p>
            
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
    
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
                
                <div class="form-terms">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" name="terms" id="terms" required {{ old('terms') ? 'checked' : '' }}>
                        <label for="terms">
                            Acepto los <a href="{{ route('terms') }}" target="_blank">términos y condiciones</a>
                        </label>
                    </div>
                    @error('terms')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">
                    Registrarse
                </button>
            </form>

            <div class="auth-links">
                <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia Sesión</a></p>
            </div>
            <div class="note-corner"></div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.auth-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background-color: var(--color-background);
    background-image: linear-gradient(#f1f5f9 1px, transparent 1px);
    background-size: 100% 28px;
}

.auth-container {
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
}

.auth-card {
    background: var(--color-yellow-bg);
    border-radius: var(--border-radius);
    padding: 2rem;
    box-shadow: var(--shadow-md);
    position: relative;
    transform: rotate(-1deg);
}

.auth-card h2 {
    font-family: var(--font-handwritten);
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--color-text);
    margin-bottom: 1rem;
    text-align: center;
}

.auth-card p {
    font-family: var(--font-handwritten);
    color: var(--color-text-light);
    margin-bottom: 1.5rem;
    text-align: center;
}

.auth-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    margin-bottom: 0;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--color-text);
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border-radius: var(--border-radius);
    border: 2px solid var(--color-border);
    font-family: var(--font-handwritten);
    background-color: white;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--color-secondary);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.form-text {
    font-size: 0.875rem;
    color: var(--color-text-light);
    margin-top: 0.25rem;
}

.form-terms {
    margin: 1rem 0;
}

.checkbox-wrapper {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.checkbox-wrapper input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-top: 0.25rem;
    cursor: pointer;
    accent-color: var(--color-secondary);
}

.checkbox-wrapper label {
    font-size: 0.9rem;
    color: var(--color-text);
    line-height: 1.4;
    cursor: pointer;
}

.checkbox-wrapper a {
    color: var(--color-secondary);
    text-decoration: none;
    font-weight: 500;
}

.checkbox-wrapper a:hover {
    text-decoration: underline;
}

.form-terms .invalid-feedback {
    margin-top: 0.5rem;
    margin-left: 2rem;
}

.btn {
    width: 100%;
    padding: 0.75rem 1.5rem;
    font-family: var(--font-handwritten);
    font-weight: 700;
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
    margin-top: 0.5rem;
}

.btn-primary {
    background-color: var(--color-secondary);
    color: white;
    border: 2px dashed #d97706;
}

.btn-primary:hover {
    transform: scale(1.05);
    background-color: #d97706;
}

.auth-links {
    text-align: center;
    margin-top: 1.5rem;
}

.auth-links a {
    color: var(--color-secondary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.auth-links a:hover {
    color: #d97706;
    text-decoration: underline;
}

.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: var(--border-radius);
    font-size: 0.875rem;
}

.alert-success {
    background-color: #dcfce7;
    color: #166534;
    border: 1px solid #86efac;
}

.invalid-feedback {
    display: block;
    color: #dc2626;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.is-invalid {
    border-color: #dc2626 !important;
}

@media (max-width: 576px) {
    .auth-card {
        padding: 1.5rem;
    }
    
    .auth-card h2 {
        font-size: 1.5rem;
    }
    
    .form-terms {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>
@endpush