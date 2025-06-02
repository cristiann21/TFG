@extends('layouts.app', ['title' => 'Mis Cursos Adquiridos - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-4">
    <div class="max-w-7xl mx-auto">
        <div class="postit-note blue-note p-6 mt-2">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Mis Cursos Adquiridos</h1>
            </div>

            @if($courses->isEmpty())
                <div class="text-center py-6">
                    <h3 class="text-xl font-bold mb-3">No has adquirido ningún curso todavía</h3>
                    <p class="text-gray-600 mb-4">¡Explora nuestra plataforma y encuentra el curso perfecto para ti!</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-blue">
                        Explorar Cursos
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($courses as $course)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="relative">
                                <img src="{{ $course->image ? asset($course->image) : asset('images/course'.($loop->index % 3 + 1).'.png') }}"
                                     alt="{{ $course->title }}"
                                     style="width: 400px; height: 200px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07);">
                                <div class="absolute top-2 right-2 flex space-x-2">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        {{ $course->language ?? 'General' }}
                                    </span>
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        {{ $course->level }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2">{{ $course->title }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($course->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">{{ optional($course->category)->name ?? 'Sin categoría' }}</span>
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-blue">
                                        Ver Curso
                                    </a>
                                </div>
                            </div>
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