@extends('layouts.app', ['title' => 'Crear Curso - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="postit-note blue-note p-6">
            <h1 class="text-2xl font-bold mb-6">
                <i class="fas fa-plus-circle mr-2"></i>
                Crear Nuevo Curso
            </h1>

            <h3 class="text-2xl font-bold mb-6">
                <i class="fas fa-plus-circle mr-2"></i>
                Campos obligatorios(*)
            </h3>

            <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título del Curso*
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control @error('title') border-red-500 @enderror"
                        value="{{ old('title') }}"
                    >
                    @error('title')
                        <span style="color: red; text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Descripción*
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="form-control @error('description') border-red-500 @enderror"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <span style="color: red; text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Precio (€)*
                        </label>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            step="0.01"
                            min="0"
                            class="form-control @error('price') border-red-500 @enderror"
                            value="{{ old('price') }}"
                        >
                        @error('price')
                            <span style="color: red; text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-2">
                            Nivel*
                        </label>
                        <select
                            id="level"
                            name="level"
                            class="form-control @error('level') border-red-500 @enderror"
                        >
                            <option value="">Selecciona un nivel</option>
                            <option value="Principiante" {{ old('level') == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                            <option value="Intermedio" {{ old('level') == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                            <option value="Avanzado" {{ old('level') == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                        </select>
                        @error('level')
                            <span style="color: red; text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                            Lenguaje de Programación*
                        </label>
                        <input
                            type="text"
                            id="language"
                            name="language"
                            class="form-control @error('language') border-red-500 @enderror"
                            value="{{ old('language') }}"
                        >
                        @error('language')
                            <span style="color: red; text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Categoría*
                        </label>
                        <select
                            id="category_id"
                            name="category_id"
                            class="form-control @error('category_id') border-red-500 @enderror"
                        >
                            <option value="">Selecciona una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span style="color: red; text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Imagen del Curso*       
                    </label>
                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/*"
                        class="form-control @error('image') border-red-500 @enderror"
                    >
                    @error('image')
                        <span style="color: red; text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
                    </p>
                </div>

                <div class="mb-6">
                    <label for="video_url" class="block text-sm font-medium text-gray-700">Enlace</label>
                    <input type="url" name="video_url" id="video_url"  class="form-control @error('video_url') border-red-500 @enderror" value="{{ old('video_url') }}">

                </div>

                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                    <p class="text-blue-700">
                        <i class="fas fa-info-circle mr-2"></i>
                        Podrás crear tests para este curso después de crearlo.
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const questionsContainer = document.getElementById('questions-container');
    const addQuestionButton = document.getElementById('add-question');
    let questionCount = 0;

    function createQuestionForm() {
        const questionDiv = document.createElement('div');
        questionDiv.className = 'question-form mb-6 p-4 border rounded-lg';
        questionDiv.innerHTML = `
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Pregunta ${questionCount + 1}</h3>
                <button type="button" class="remove-question text-red-600 hover:text-red-800">
                Eliminar
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Pregunta</label>
                <input type="text" name="questions[${questionCount}][question_text]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Opción A</label>
                    <input type="text" name="questions[${questionCount}][option_a]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Opción B</label>
                    <input type="text" name="questions[${questionCount}][option_b]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Opción C</label>
                    <input type="text" name="questions[${questionCount}][option_c]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Opción D</label>
                    <input type="text" name="questions[${questionCount}][option_d]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Respuesta Correcta</label>
                <select name="questions[${questionCount}][correct_option]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Selecciona la respuesta correcta</option>
                    <option value="a">Opción A</option>
                    <option value="b">Opción B</option>
                    <option value="c">Opción C</option>
                    <option value="d">Opción D</option>
                </select>
            </div>
        `;

        // Añadir evento para eliminar pregunta
        questionDiv.querySelector('.remove-question').addEventListener('click', function() {
            questionDiv.remove();
            updateQuestionNumbers();
        });

        questionsContainer.appendChild(questionDiv);
        questionCount++;
    }

    function updateQuestionNumbers() {
        const questions = questionsContainer.querySelectorAll('.question-form');
        questions.forEach((question, index) => {
            question.querySelector('h3').textContent = `Pregunta ${index + 1}`;
            const inputs = question.querySelectorAll('input, select');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/questions\[\d+\]/, `questions[${index}]`));
                }
            });
        });
        questionCount = questions.length;
    }

    addQuestionButton.addEventListener('click', createQuestionForm);

    // Añadir primera pregunta automáticamente
    createQuestionForm();
});
</script>
@endpush
@endsection 