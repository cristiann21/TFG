@extends('layouts.app', ['title' => 'Editar Curso - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="postit-note blue-note p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Curso
                </h1>
                <a href="{{ route('profile.courses') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a mis cursos
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Título del Curso</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}" 
                           class="form-input w-full" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                    <textarea name="description" id="description" rows="4" 
                              class="form-textarea w-full" required>{{ old('description', $course->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Precio</label>
                        <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price', $course->price) }}" 
                               class="form-input w-full" required>
                    </div>

                    <div>
                        <label for="level" class="block text-gray-700 text-sm font-bold mb-2">Nivel</label>
                        <select name="level" id="level" class="form-select w-full" required>
                            <option value="Principiante" {{ old('level', $course->level) == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                            <option value="Intermedio" {{ old('level', $course->level) == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                            <option value="Avanzado" {{ old('level', $course->level) == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="language" class="block text-gray-700 text-sm font-bold mb-2">Lenguaje de Programación</label>
                        <input type="text" name="language" id="language" value="{{ old('language', $course->language) }}" 
                               class="form-input w-full" required>
                    </div>

                    <div>
                        <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Categoría</label>
                        <select name="category_id" id="category_id" class="form-select w-full" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Imagen del Curso</label>
                    @if($course->image)
                        <div class="mb-2">
                            <img src="{{ asset($course->image) }}" alt="Imagen actual" class="w-32 h-32 object-cover rounded">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-input w-full">
                    <p class="text-sm text-gray-500 mt-1">Deja vacío para mantener la imagen actual</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Curso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 