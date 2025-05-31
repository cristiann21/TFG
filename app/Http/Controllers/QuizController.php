<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function create(Course $course)
    {
        return view('quizzes.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_option' => 'required|in:a,b,c,d'
        ]);

        try {
            DB::beginTransaction();

            $quiz = Quiz::create([
                'course_id' => $course->id,
                'title' => $request->title,
                'description' => $request->description,
                'passing_score' => 50 // Establecer el porcentaje de aprobación al 50%
            ]);

            foreach ($request->questions as $questionData) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $questionData['question_text'],
                    'options' => json_encode([
                        'a' => $questionData['option_a'],
                        'b' => $questionData['option_b'],
                        'c' => $questionData['option_c'],
                        'd' => $questionData['option_d']
                    ]),
                    'correct_option' => array_search($questionData['correct_option'], ['a', 'b', 'c', 'd'])
                ]);
            }

            DB::commit();

            return redirect()->route('courses.show', $course)
                ->with('success', 'Test creado con éxito');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al crear el test: ' . $e->getMessage());
        }
    }

    public function show(Course $course, Quiz $quiz)
    {
        return view('quizzes.show', compact('course', 'quiz'));
    }

    public function edit(Course $course, Quiz $quiz)
    {
        return view('quizzes.edit', compact('course', 'quiz'));
    }

    public function update(Request $request, Course $course, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options.a' => 'required|string',
            'questions.*.options.b' => 'required|string',
            'questions.*.options.c' => 'required|string',
            'questions.*.options.d' => 'required|string',
            'questions.*.correct_option' => 'required|in:a,b,c,d'
        ]);

        try {
            DB::beginTransaction();

            // Actualizar el test
            $quiz->update([
                'title' => $request->title,
                'description' => $request->description
            ]);

            // Obtener las preguntas existentes
            $existingQuestions = $quiz->questions;
            $existingQuestionIds = $existingQuestions->pluck('id')->toArray();
            $updatedQuestionIds = [];

            // Actualizar o crear preguntas
            foreach ($request->questions as $index => $questionData) {
                $questionId = $request->input("questions.{$index}.id");
                
                if ($questionId && in_array($questionId, $existingQuestionIds)) {
                    // Actualizar pregunta existente
                    $question = $existingQuestions->firstWhere('id', $questionId);
                    $question->update([
                        'question' => $questionData['question'],
                        'options' => json_encode([
                            'a' => $questionData['options']['a'],
                            'b' => $questionData['options']['b'],
                            'c' => $questionData['options']['c'],
                            'd' => $questionData['options']['d']
                        ]),
                        'correct_option' => array_search($questionData['correct_option'], ['a', 'b', 'c', 'd'])
                    ]);
                    $updatedQuestionIds[] = $questionId;
                } else {
                    // Crear nueva pregunta
                    $newQuestion = QuizQuestion::create([
                        'quiz_id' => $quiz->id,
                        'question' => $questionData['question'],
                        'options' => json_encode([
                            'a' => $questionData['options']['a'],
                            'b' => $questionData['options']['b'],
                            'c' => $questionData['options']['c'],
                            'd' => $questionData['options']['d']
                        ]),
                        'correct_option' => array_search($questionData['correct_option'], ['a', 'b', 'c', 'd'])
                    ]);
                    $updatedQuestionIds[] = $newQuestion->id;
                }
            }

            // Eliminar preguntas que ya no existen
            $questionsToDelete = array_diff($existingQuestionIds, $updatedQuestionIds);
            if (!empty($questionsToDelete)) {
                QuizQuestion::whereIn('id', $questionsToDelete)->delete();
            }

            DB::commit();

            return redirect()->route('courses.show', $course)
                ->with('success', 'Test actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al actualizar el test:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()
                ->with('error', 'Error al actualizar el test: ' . $e->getMessage());
        }
    }

    public function destroy(Course $course, Quiz $quiz)
    {
        // Verificar que el test pertenece al curso
        if ($quiz->course_id !== $course->id) {
            return redirect()->route('courses.edit', $course)
                ->with('error', 'El test no pertenece a este curso.');
        }

        // Eliminar el test y sus preguntas
        $quiz->questions()->delete();
        $quiz->delete();

        return redirect()->route('courses.edit', $course)
            ->with('success', 'Test eliminado con éxito');
    }

    public function submit(Request $request, Course $course, Quiz $quiz)
    {
        $answers = $request->input('answers', []);
        
        // Verificar que todas las preguntas estén respondidas
        if (count($answers) < $quiz->questions->count()) {
            return back()->with('error', 'Debes responder todas las preguntas del test.');
        }

        $results = [];
        $score = 0;
        $totalQuestions = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $userAnswer = isset($answers[$question->id]) ? $answers[$question->id] : null;
            $options = json_decode($question->options, true);
            
            // Asegurarnos de que las opciones son un array indexado numéricamente
            if (is_array($options) && !isset($options[0])) {
                $options = array_values($options);
            }
            
            // Convertir la respuesta del usuario a índice numérico
            $userAnswerIndex = $userAnswer !== null ? array_search($userAnswer, ['a', 'b', 'c', 'd']) : null;
            
            // Verificar que el índice es válido
            if ($userAnswerIndex !== false && isset($options[$userAnswerIndex])) {
                $isCorrect = $userAnswerIndex === $question->correct_option;
                $score += $isCorrect ? 1 : 0;
                
                $results[] = [
                    'question' => $question->question,
                    'userAnswer' => $options[$userAnswerIndex],
                    'correctAnswer' => $options[$question->correct_option],
                    'isCorrect' => $isCorrect
                ];
            } else {
                $results[] = [
                    'question' => $question->question,
                    'userAnswer' => 'No respondida',
                    'correctAnswer' => $options[$question->correct_option],
                    'isCorrect' => false
                ];
            }
        }

        $passed = ($score / $totalQuestions) >= 0.5; // 50% para aprobar

        QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => auth()->id(),
            'score' => $score,
            'passed' => $passed,
            'answers' => $answers
        ]);

        return view('quizzes.results', [
            'course' => $course,
            'quiz' => $quiz,
            'results' => $results,
            'score' => $score,
            'totalQuestions' => $totalQuestions,
            'passed' => $passed
        ]);
    }
} 