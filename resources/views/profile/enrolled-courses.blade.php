@extends('layouts.app', ['title' => 'Mis Cursos Adquiridos - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="postit-note blue-note p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Mis Cursos Adquiridos</h1>
            </div>

            @if($courses->isEmpty())
                <div class="postit-note yellow-note p-6 text-center">
                    <h3 class="text-xl font-bold mb-4">No has adquirido ningún curso todavía</h3>
                    <p class="text-gray-600 mb-4">¡Explora nuestra plataforma y encuentra el curso perfecto para ti!</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-blue">
                        Explorar Cursos
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
                            </div>
                            <div class="course-content">
                                <h3>{{ $course->title }}</h3>
                                <p>{{ Str::limit($course->description, 100) }}</p>
                                <div class="course-meta">
                                    <span class="course-category">{{ optional($course->category)->name ?? 'Sin categoría' }}</span>
                                </div>
                                <div class="course-footer">
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-sm {{ ['btn-yellow', 'btn-blue', 'btn-green', 'btn-pink', 'btn-purple'][($loop->index % 5)] }}">
                                        Ver Curso
                                    </a>
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