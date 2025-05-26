@extends('layouts.app', ['title' => 'Crear Curso - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="postit-note blue-note p-6">
            <h1 class="text-2xl font-bold mb-6">
                <i class="fas fa-plus-circle mr-2"></i>
                Crear Nuevo Curso
            </h1>

            @if(session('success'))
                <div class="alert alert-success mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-6">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título del Curso
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        required
                    >
                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Descripción
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="form-control @error('description') is-invalid @enderror"
                        required
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Precio (€)
                        </label>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            step="0.01"
                            min="0"
                            class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price') }}"
                            required
                        >
                        @error('price')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-2">
                            Nivel
                        </label>
                        <select
                            id="level"
                            name="level"
                            class="form-control @error('level') is-invalid @enderror"
                            required
                        >
                            <option value="">Selecciona un nivel</option>
                            <option value="Principiante" {{ old('level') == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                            <option value="Intermedio" {{ old('level') == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                            <option value="Avanzado" {{ old('level') == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                        </select>
                        @error('level')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                            Lenguaje de Programación
                        </label>
                        <input
                            type="text"
                            id="language"
                            name="language"
                            class="form-control @error('language') is-invalid @enderror"
                            value="{{ old('language') }}"
                            required
                        >
                        @error('language')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Categoría
                        </label>
                        <select
                            id="category_id"
                            name="category_id"
                            class="form-control @error('category_id') is-invalid @enderror"
                            required
                        >
                            <option value="">Selecciona una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Imagen del Curso
                    </label>
                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/*"
                        class="form-control @error('image') is-invalid @enderror"
                    >
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
                    </p>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('courses.index') }}" class="btn btn-outline">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Crear Curso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 