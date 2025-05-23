@extends('layouts.app', ['title' => 'Iniciar Sesión - PinCode', 'hideFooter' => true, 'hideHeader' => true])

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="postit-note {{ request()->has('role') && request()->role === 'teacher' ? 'yellow-note' : 'blue-note' }} auth-card">
            <h2>
                @if(request()->has('role') && request()->role === 'teacher')
                    <i class="fas fa-chalkboard-teacher"></i>
                    Acceso Profesor
                @else
                    Iniciar Sesión
                @endif
            </h2>
            <p>
                @if(request()->has('role') && request()->role === 'teacher')
                    Accede con tus credenciales de profesor para gestionar cursos.
                @else
                    ¡Bienvenido de nuevo! Ingresa tus credenciales para continuar.
                @endif
            </p>
            
            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf
                @if(request()->has('role') && request()->role === 'teacher')
                    <input type="hidden" name="role" value="teacher">
                @endif
                
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Recordarme</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-primary">
                    @if(request()->has('role') && request()->role === 'teacher')
                        <i class="fas fa-chalkboard-teacher"></i>
                        Acceder como Profesor
                    @else
                        Iniciar Sesión
                    @endif
                </button>
            </form>

            <div class="auth-links">
                @if(request()->has('role') && request()->role === 'teacher')
                    <p><a href="{{ route('login') }}" class="switch-role">
                        <i class="fas fa-user-graduate"></i>
                        Cambiar a Acceso Estudiante
                    </a></p>
                @else
                    <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
                    <p><a href="{{ route('password.request') }}" class="forgot-password">¿Olvidaste tu contraseña?</a></p>
                    <p class="teacher-link">
                        <a href="{{ route('login') }}?role=teacher" class="teacher-btn">
                            <i class="fas fa-chalkboard-teacher"></i>
                            Acceder como Profesor
                        </a>
                    </p>
                @endif
            </div>
            <div class="note-corner"></div>
        </div>
    </div>
</div>

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
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.auth-card h2 i {
    color: var(--color-secondary);
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

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0.5rem 0;
}

.remember-me {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.remember-me input[type="checkbox"] {
    width: 16px;
    height: 16px;
    cursor: pointer;
    accent-color: var(--color-secondary);
}

.remember-me label {
    font-size: 0.9rem;
    color: var(--color-text);
    cursor: pointer;
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

.teacher-link {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--color-border);
}

.teacher-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--color-primary);
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.teacher-btn:hover {
    color: var(--color-secondary);
    text-decoration: underline;
}

.teacher-btn i {
    font-size: 1.1rem;
}

.switch-role {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--color-text);
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.switch-role:hover {
    color: var(--color-secondary);
    text-decoration: underline;
}

.switch-role i {
    font-size: 1.1rem;
}

.btn {
    width: 100%;
    padding: 0.75rem 1.5rem;
    font-family: var(--font-handwritten);
    font-weight: 700;
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
    margin-top: 0.5rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
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
    
    .form-options {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
}
</style>
@endpush
