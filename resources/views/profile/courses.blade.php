@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Mis Cursos Creados</h1>
            <a href="{{ route('courses.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Crear Nuevo Curso
            </a>
        </div>

        @if($courses->isEmpty())
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <p class="text-gray-600 mb-4">No has creado ningún curso todavía.</p>
                <a href="{{ route('courses.create') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Crear mi Primer Curso
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courses as $course)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        @if($course->image)
                            <img src="{{ asset($course->image) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">Sin imagen</span>
                            </div>
                        @endif
                        
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $course->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($course->description, 100) }}</p>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-green-600 font-bold">${{ number_format($course->price, 2) }}</span>
                                <div class="space-x-2">
                                    <a href="{{ route('courses.edit', $course) }}" class="text-blue-500 hover:text-blue-600">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('¿Estás seguro de que quieres eliminar este curso?')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection 