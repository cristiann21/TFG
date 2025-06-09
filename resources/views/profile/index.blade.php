@extends('layouts.app', ['title' => 'Mi Perfil - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="postit-note blue-note p-6">
            <!-- Encabezado -->
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-bold">
                    <i class="fas fa-user mr-2"></i>
                    {{ auth()->user()->name }}
                </h1>
                <div class="flex space-x-4">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Perfil
                    </a>
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

            @if(session('error'))
                <div class="alert alert-danger mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info mb-6">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Información Principal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Información Personal -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold mb-4">Información Personal</h2>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-gray-500 w-6"></i>
                            <span class="ml-2">Correo: {{ auth()->user()->email }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-user-tag text-gray-500 w-6"></i>
                            <span class="ml-2">Rol: {{ auth()->user()->isTeacher() ? 'Profesor' : 'Estudiante' }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar text-gray-500 w-6"></i>
                            <span class="ml-2">Miembro desde {{ auth()->user()->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="flex items-center">
                                <i class="fas fa-book text-gray-500 w-6"></i>
                                <span class="ml-2">Cursos Adquiridos</span>
                            </span>
                            <span class="font-semibold">{{ optional(auth()->user()->courses)->count() ?? 0 }}</span>
                        </div>
                        @if(auth()->user()->isTeacher())
                            <div class="flex items-center justify-between">
                                <span class="flex items-center">
                                    <i class="fas fa-chalkboard text-gray-500 w-6"></i>
                                    <span class="ml-2">Cursos Creados</span>
                                </span>
                                <span class="font-semibold">{{ optional(auth()->user()->createdCourses)->count() ?? 0 }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Botones de Cursos -->
            <div class="flex justify-center space-x-4 mb-8">
                @if(auth()->user()->isTeacher())
                    <a href="{{ route('profile.courses') }}" class="btn btn-primary">
                        <i class="fas fa-chalkboard mr-2"></i>
                        Mis Cursos Creados
                    </a>
                @endif
                <a href="{{ route('profile.enrolled-courses') }}" class="btn btn-primary">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Mis Cursos Adquiridos
                </a>
            </div>

            <!-- Cursos Favoritos -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <i class="fas fa-heart mr-2"></i>
                    Cursos Favoritos
                </h2>
                @if(optional(auth()->user()->favorites)->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach(auth()->user()->favorites as $favorite)
                            <div class="flex flex-col p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center justify-between mb-3">
                                    <a href="{{ route('courses.show', $favorite->id) }}" class="flex-1">
                                        <span class="font-medium hover:text-blue-600">{{ $favorite->title }}</span>
                                    </a>
                                </div>
                                <form action="{{ route('courses.favorites.remove', $favorite->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt mr-1"></i>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">No tienes cursos favoritos.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 