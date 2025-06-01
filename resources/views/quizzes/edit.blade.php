@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Editar Test</h1>

            <form action="{{ route('quizzes.update', ['course' => $course, 'quiz' => $quiz]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título del Test</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $quiz->title) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $quiz->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-4">Preguntas</h2>
                    <div id="questions-container">
                        @foreach($quiz->questions as $index => $question)
                            <div class="question-item bg-gray-50 p-4 rounded-lg mb-4">
                                <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium">Pregunta {{ $index + 1 }}</h3>
                                    <button type="button" class="remove-question inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pregunta</label>
                                    <input type="text" name="questions[{{ $index }}][question]" 
                                           value="{{ old("questions.{$index}.question", $question->question) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    @php
                                        $options = json_decode($question->options, true);
                                    @endphp
                                    @foreach(['a', 'b', 'c', 'd'] as $option)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Opción {{ strtoupper($option) }}</label>
                                            <input type="text" name="questions[{{ $index }}][options][{{ $option }}]" 
                                                   value="{{ old("questions.{$index}.options.{$option}", $options[$option] ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Respuesta Correcta</label>
                                    <select name="questions[{{ $index }}][correct_option]" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
                                        @foreach(['a', 'b', 'c', 'd'] as $option)
                                            <option value="{{ $option }}" {{ old("questions.{$index}.correct_option", $question->correct_option) == array_search($option, ['a', 'b', 'c', 'd']) ? 'selected' : '' }}>
                                                Opción {{ strtoupper($option) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="add-question" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Añadir Pregunta
                    </button>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('courses.show', $course) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Guardar Cambios
                    </button>
                </div>
            </form>

            <form action="{{ route('quizzes.destroy', ['course' => $course, 'quiz' => $quiz]) }}" method="POST" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('¿Estás seguro de que deseas eliminar este test? Esta acción no se puede deshacer.')">
                    Eliminar Test
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const questionsContainer = document.getElementById('questions-container');
    const addQuestionButton = document.getElementById('add-question');
    let questionCount = {{ count($quiz->questions) }};

    function createQuestionElement(index) {
        const template = `
            <div class="question-item bg-gray-50 p-4 rounded-lg mb-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Pregunta ${index + 1}</h3>
                    <button type="button" class="remove-question inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Eliminar
                    </button>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pregunta</label>
                    <input type="text" name="questions[${index}][question]" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    ${['a', 'b', 'c', 'd'].map(option => `
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Opción ${option.toUpperCase()}</label>
                            <input type="text" name="questions[${index}][options][${option}]" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
                        </div>
                    `).join('')}
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Respuesta Correcta</label>
                    <select name="questions[${index}][correct_option]" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
                        ${['a', 'b', 'c', 'd'].map(option => `
                            <option value="${option}">Opción ${option.toUpperCase()}</option>
                        `).join('')}
                    </select>
                </div>
            </div>
        `;
        return template;
    }

    addQuestionButton.addEventListener('click', function() {
        const questionElement = document.createElement('div');
        questionElement.innerHTML = createQuestionElement(questionCount);
        questionsContainer.appendChild(questionElement.firstElementChild);
        questionCount++;
    });

    questionsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-question')) {
            const questionItem = e.target.closest('.question-item');
            questionItem.remove();
        }
    });
});
</script>
@endpush
@endsection 