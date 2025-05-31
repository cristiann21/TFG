@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Crear Test para {{ $course->title }}</h1>

            <form action="{{ route('quizzes.store', $course) }}" method="POST" id="quizForm">
                @csrf
                
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700">Título del Test</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>

                <div id="questions-container">
                    <!-- Las preguntas se añadirán aquí dinámicamente -->
                </div>

                <div class="mt-4">
                    <button type="button" id="add-question" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Añadir Pregunta
                    </button>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Guardar Test
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
                <button type="button" class="remove-question inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Eliminar
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pregunta</label>
                <input type="text" name="questions[${questionCount}][question_text]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Opción A</label>
                    <input type="text" name="questions[${questionCount}][option_a]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Opción B</label>
                    <input type="text" name="questions[${questionCount}][option_b]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Opción C</label>
                    <input type="text" name="questions[${questionCount}][option_c]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Opción D</label>
                    <input type="text" name="questions[${questionCount}][option_d]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base" required>
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Respuesta Correcta</label>
                <select name="questions[${questionCount}][correct_option]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base" required>
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