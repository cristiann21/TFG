@extends('layouts.app', ['title' => 'Mi Perfil - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="postit-note blue-note p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold">
                        <i class="fas fa-user mr-2"></i>
                        {{ auth()->user()->name }}
                    </h1>
                    <a href="{{ route('profile.edit') }}" class="btn btn-secondary">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Perfil
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @if(!auth()->user()->isTeacher())
                        <a href="{{ route('teacher-request.show') }}" class="btn btn-primary">
                            <i class="fas fa-chalkboard-teacher mr-2"></i>
                            Solicitar ser Profesor
                        </a>
                    @endif
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold mb-4">Información Personal</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Nombre</label>
                            <p class="mt-1">{{ auth()->user()->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Email</label>
                            <p class="mt-1">{{ auth()->user()->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Rol</label>
                            <p class="mt-1">
                                @if(auth()->user()->isTeacher())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-chalkboard-teacher mr-1"></i>
                                        Profesor
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-user-graduate mr-1"></i>
                                        Estudiante
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold mb-4">Estadísticas</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Cursos Adquiridos</label>
                            <p class="mt-1">{{ auth()->user()->courses->count() }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Cursos Completados</label>
                            <p class="mt-1">{{ auth()->user()->courses->where('status', 'completed')->count() }}</p>
                        </div>
                        @if(auth()->user()->isTeacher())
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Cursos Creados</label>
                                <p class="mt-1">{{ auth()->user()->createdCourses->count() }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="stats-section">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3>Cursos Adquiridos</h3>
                            <p class="stat-value">{{ auth()->user()->courses->count() }}</p>
                            @if(auth()->user()->courses->count() > 0)
                                <a href="{{ route('profile.courses') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Ver mis cursos →
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h2>Cursos que me gustan</h2>
                @if(auth()->user()->favorites()->count() > 0)
                    <ul>
                        @foreach(auth()->user()->favorites as $favorite)
                            <li>
                                <a href="{{ route('courses.show', $favorite->id) }}" class="btn btn-outline">{{ $favorite->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No tienes cursos favoritos.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 