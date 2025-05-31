@extends('layouts.app')

<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                        PinCode
                    </a>
                </div>

                <!-- Navegación Principal -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('home') }}" 
                       class="{{ request()->routeIs('home') ? 'active' : '' }} nav-link">
                        <i class="fas fa-home mr-2"></i>
                        Inicio
                    </a>

                    <a href="{{ route('courses.index') }}" 
                       class="{{ request()->routeIs('courses.index') && !request()->routeIs('courses.create') ? 'active' : '' }} nav-link">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Cursos
                    </a>

                    @if(auth()->user()->isTeacher())
                        <a href="{{ route('courses.create') }}" 
                           class="{{ request()->routeIs('courses.create') ? 'active' : '' }} nav-link">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Añadir Curso
                        </a>
                    @endif
                </div>
            </div>

            <!-- Menú de Usuario -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    @if(auth()->user()->isTeacher())
                        <a href="{{ route('profile.courses') }}" class="btn btn-primary mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            Mis Cursos Creados
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="btn btn-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Editar Perfil
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@push('styles')
<style>
.btn-orange {
    background-color: #f97316;
    color: white;
}

.btn-orange:hover {
    background-color: #ea580c;
    opacity: 0.9;
    transform: translateY(-1px);
}
</style>
@endpush 