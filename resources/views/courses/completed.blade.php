@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="postit-note green-note text-center">
        
            <h1 class="text-3xl font-bold mb-4">¡Curso Completado!</h1>
            <p class="text-lg mb-6">Has completado exitosamente el curso "{{ $course->title }}"</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('courses.index') }}" class="btn btn-primary">
                    Explorar Más Cursos
                </a>
                <a href="{{ route('profile.courses') }}" class="btn btn-outline">
                    Ver Mis Cursos
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 