@extends('layouts.app', ['title' => 'Editar Curso - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Editar Curso: {{ $course->title }}</h1>

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
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

                <!-- Información básica del curso -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Información del Curso</h2>
                    <!-- Campos del curso -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Título</label>
                            <input type="text" name="title" value="{{ old('title', $course->title) }}" 
                                   class="form-input w-full @error('title') border-red-500 @enderror" required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Precio (€)</label>
                            <input type="number" name="price" step="0.01" value="{{ old('price', $course->price) }}" 
                                   class="form-input w-full @error('price') border-red-500 @enderror" required>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lenguaje</label>
                            <input type="text" name="language" value="{{ old('language', $course->language) }}" 
                                   class="form-input w-full @error('language') border-red-500 @enderror" required>
                            @error('language')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nivel</label>
                            <select name="level" class="form-select w-full @error('level') border-red-500 @enderror" required>
                                <option value="Principiante" {{ old('level', $course->level) == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                                <option value="Intermedio" {{ old('level', $course->level) == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                                <option value="Avanzado" {{ old('level', $course->level) == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                            </select>
                            @error('level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                            <select name="category_id" class="form-select w-full @error('category_id') border-red-500 @enderror" required>
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <textarea name="description" rows="4" 
                                  class="form-textarea w-full @error('description') border-red-500 @enderror" required>{{ old('description', $course->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">URL del Video</label>
                        <input type="url" name="video_url" value="{{ old('video_url', $course->video_url) }}" 
                               class="form-input w-full @error('video_url') border-red-500 @enderror">
                        @error('video_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Imagen del Curso</label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif" 
                               class="form-input w-full @error('image') border-red-500 @enderror">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($course->image)
                            <div class="mt-2">
                                <img src="{{ asset($course->image) }}" alt="Imagen actual" style="width: 400px; height: 200px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07);">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sección de Tests -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Tests del Curso</h2>
                        <a href="{{ route('quizzes.create', $course) }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>
                            Crear Nuevo Test
                        </a>
                    </div>

                    @if($course->quizzes->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($course->quizzes as $quiz)
                                <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="font-semibold text-lg">{{ $quiz->title }}</h3>
                                            <p class="text-gray-600 text-sm">{{ $quiz->description }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('quizzes.edit', ['course' => $course, 'quiz' => $quiz]) }}" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit mr-1"></i>
                                                Editar
                                            </a>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <i class="fas fa-question-circle mr-2"></i>
                                            {{ $quiz->questions->count() }} preguntas
                                        </div>
                                        <div class="flex items-center mt-1">
                                            <i class="fas fa-clock mr-2"></i>
                                            Creado: {{ $quiz->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-6 text-center">
                            <p class="text-gray-600 mb-4">No hay tests disponibles para este curso.</p>
                            <a href="{{ route('quizzes.create', $course) }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i>
                                Crear Primer Test
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('courses.show', $course) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Guardar Cambios
                    </button>
                </div>
            </form>

            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="mt-4 flex justify-end">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('¿Estás seguro de que deseas eliminar este curso? Esta acción no se puede deshacer.')">
                    Eliminar Curso
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.btn {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-sm {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
}

.btn-primary {
    background-color: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background-color: #2563eb;
}

.btn-outline {
    border: 1px solid #3b82f6;
    color: #3b82f6;
}

.btn-outline:hover {
    background-color: #3b82f6;
    color: white;
}

.btn-danger {
    background-color: #ef4444;
    color: white;
}

.btn-icon {
    margin-right: 0.5rem;
}

.btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.form-input, .form-select, .form-textarea {
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    padding: 0.5rem;
    width: 100%;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.border-red-500 {
    border-color: #ef4444;
}
</style>
@endpush 