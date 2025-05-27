@extends('layouts.app', ['title' => 'Mis Cursos Creados - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="postit-note blue-note p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Mis Cursos Creados</h1>
                <a href="{{ route('courses.create') }}" class="btn btn-green">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Crear Nuevo Curso
                </a>
            </div>

            @if($courses->isEmpty())
                <div class="postit-note yellow-note p-6 text-center">
                    <h3 class="text-xl font-bold mb-4">No has creado ningún curso todavía</h3>
                    <p class="text-gray-600 mb-4">¡Comienza tu viaje como instructor creando tu primer curso!</p>
                    <a href="{{ route('courses.create') }}" class="btn btn-blue">
                        Crear mi Primer Curso
                    </a>
                    <div class="note-corner"></div>
                </div>
            @else
                <div class="courses-grid">
                    @foreach($courses as $course)
                        <div class="course-card {{ ['yellow-note', 'blue-note', 'green-note', 'pink-note', 'purple-note'][($loop->index % 5)] }}">
                            <div class="course-image">
                                <img src="{{ $course->image ? asset($course->image) : asset('images/course'.($loop->index % 3 + 1).'.png') }}" alt="{{ $course->title }}">
                                <span class="course-language">{{ $course->language ?? 'General' }}</span>
                                <span class="course-level">{{ $course->level }}</span>
                                <span class="course-category">{{ optional($course->category)->name ?? 'Sin categoría' }}</span>
                            </div>
                            <div class="course-content">
                                <h3>{{ $course->title }}</h3>
                                <p>{{ Str::limit($course->description, 100) }}</p>
                                <div class="course-meta">
                                    <span class="course-price">{{ number_format($course->price, 2) }} €</span>
                                </div>
                                <div class="course-footer">
                                    <div class="course-actions">
                                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-blue">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-red" onclick="return confirm('¿Estás seguro de que quieres eliminar este curso?')">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="note-corner"></div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/views/profile-courses.css') }}">
@endpush 