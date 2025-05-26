@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Mis Cursos</h1>
                <a href="{{ route('profile.index') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i>Volver al perfil
                </a>
            </div>

            @if(auth()->user()->courses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(auth()->user()->courses as $course)
                        <div class="course-card bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="relative">
                                <img src="{{ $course->image ? asset($course->image) : asset('images/course1.png') }}" 
                                     alt="{{ $course->title }}" 
                                     class="w-full h-48 object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-sm">
                                        {{ $course->language }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <h3 class="text-xl font-semibold mb-2">{{ $course->title }}</h3>
                                <p class="text-gray-600 mb-4">{{ Str::limit($course->description, 100) }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img src="{{ asset('images/teacher-avatar.png') }}" 
                                             alt="{{ $course->teacher->name }}" 
                                             class="w-8 h-8 rounded-full mr-2">
                                        <span class="text-sm text-gray-600">{{ $course->teacher->name }}</span>
                                    </div>
                                    <a href="{{ route('courses.show', $course) }}" 
                                       class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                        Ver Contenido
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-graduation-cap text-6xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">No tienes cursos adquiridos</h3>
                    <p class="text-gray-600 mb-4">Explora nuestra selección de cursos y comienza tu aprendizaje</p>
                    <a href="{{ route('courses.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Ver Cursos Disponibles
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 