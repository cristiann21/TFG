@extends('layouts.app', ['title' => 'Contacto - PinCode'])

@section('content')
<div class="contact-page notebook-bg">
    <div class="container">
        <!-- Hero Section -->
        <div class="contact-hero">
            <div class="hero-content">
                <h1>Contacto</h1>
                <p>¿Tienes alguna pregunta? ¡Estamos aquí para ayudarte!</p>
            </div>
        </div>

        <div class="contact-grid">
            <!-- Formulario de Contacto -->
            <div class="contact-form-container">
                <div class="postit-note blue-note">
                    <h2>Envíanos un mensaje</h2>
                    <form method="POST" action="{{ route('contact.send') }}" class="contact-form">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Asunto</label>
                            <input type="text" id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
                            @error('subject')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Mensaje</label>
                            <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" rows="5" required>{{ old('message') }}</textarea>
                            @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Enviar Mensaje
                        </button>
                    </form>
                    <div class="note-corner"></div>
                </div>
            </div>
            
            <!-- Información de Contacto -->
            <div class="contact-info">
                <div class="postit-note yellow-note">
                    <h2>Información de Contacto</h2>
                    <div class="info-content">
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h3>Correo Electrónico</h3>
                                <p>contacto@pincode.com</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <h3>Teléfono</h3>
                                <p>+1 234 567 890</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h3>Dirección</h3>
                                <p>123 Calle Principal<br>Ciudad, País</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h3>Horario de Atención</h3>
                                <p>Lunes a Viernes: 9:00 - 18:00<br>Sábados: 10:00 - 14:00</p>
                            </div>
                        </div>
                    </div>
                    <div class="note-corner"></div>
                </div>

                <!-- Redes Sociales -->
                <div class="postit-note green-note">
                    <h2>Síguenos</h2>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <i class="fab fa-facebook"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-twitter"></i>
                            <span>Twitter</span>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-instagram"></i>
                            <span>Instagram</span>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-linkedin"></i>
                            <span>LinkedIn</span>
                        </a>
                    </div>
                    <div class="note-corner"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.contact-page {
    padding: 4rem 0;
}

.contact-hero {
    text-align: center;
    margin-bottom: 3rem;
}

.contact-hero h1 {
    font-family: var(--font-handwritten);
    font-size: 2.5rem;
    color: var(--color-primary);
    margin-bottom: 1rem;
}

.contact-hero p {
    font-size: 1.2rem;
    color: var(--color-text-light);
    max-width: 600px;
    margin: 0 auto;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.contact-form-container {
    margin-bottom: 2rem;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-family: var(--font-handwritten);
    color: var(--color-text);
    font-size: 1.1rem;
}

.form-control {
    padding: 0.75rem 1rem;
    border: 2px solid var(--color-border);
    border-radius: var(--border-radius);
    font-family: var(--font-handwritten);
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--color-primary);
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.info-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.info-item i {
    font-size: 1.5rem;
    color: var(--color-primary);
    margin-top: 0.25rem;
}

.info-item h3 {
    font-family: var(--font-handwritten);
    font-size: 1.1rem;
    color: var(--color-text);
    margin-bottom: 0.25rem;
}

.info-item p {
    color: var(--color-text-light);
    line-height: 1.4;
}

.social-links {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.social-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: var(--border-radius);
    text-decoration: none;
    color: var(--color-text);
    transition: all 0.3s ease;
}

.social-link:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.social-link i {
    font-size: 1.25rem;
    color: var(--color-primary);
}

@media (max-width: 768px) {
    .contact-page {
        padding: 2rem 0;
    }

    .contact-grid {
        grid-template-columns: 1fr;
    }

    .contact-hero h1 {
        font-size: 2rem;
    }

    .social-links {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush 