@extends('layouts.app', ['title' => 'Editar Perfil - PinCode'])

@section('content')
<div class="container">
    <div class="profile-edit-page">
        <h1>Editar Perfil</h1>
        
        <form method="POST" action="{{ route('profile.update') }}" class="profile-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            @if(auth()->user()->isTeacher())
                <div class="form-group">
                    <label for="avatar">Foto de Perfil</label>
                    <div class="avatar-preview mb-3">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset(auth()->user()->avatar) }}" alt="Avatar actual" class="current-avatar">
                        @else
                            <div class="no-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <input type="file" id="avatar" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                    <p class="text-sm text-gray-500 mt-1">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</p>
                    @error('avatar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endif
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Guardar Cambios
                </button>
                <a href="{{ route('profile.index') }}" class="btn btn-outline">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.profile-edit-page {
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.profile-edit-page h1 {
    color: var(--color-text);
    margin-bottom: 2rem;
    text-align: center;
}

.profile-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
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

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    font-family: var(--font-handwritten);
    font-weight: 700;
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
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

.btn-outline {
    background-color: transparent;
    color: var(--color-text);
    border: 2px solid var(--color-border);
}

.btn-outline:hover {
    background-color: var(--color-background);
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

.avatar-preview {
    width: 150px;
    height: 150px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid var(--color-secondary);
}

.current-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-avatar {
    width: 100%;
    height: 100%;
    background-color: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 3rem;
}

@media (max-width: 768px) {
    .profile-edit-page {
        padding: 1rem;
        margin: 1rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.querySelector('.avatar-preview');
    
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'current-avatar';
                    avatarPreview.innerHTML = '';
                    avatarPreview.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush
@endsection 