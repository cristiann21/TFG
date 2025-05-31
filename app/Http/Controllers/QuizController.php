<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

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

        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        foreach ($request->questions as $questionData) {
            QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question' => $questionData['question_text'],
                'options' => json_encode([
                    $questionData['option_a'],
                    $questionData['option_b'],
                    $questionData['option_c'],
                    $questionData['option_d']
                ]),
                'correct_option' => array_search($questionData['correct_option'], ['a', 'b', 'c', 'd'])
            ]);
        }

        return redirect()->route('courses.show', $course)
            ->with('success', 'Test creado con éxito');
    }

    public function show(Course $course, Quiz $quiz)
    {
        return view('quizzes.show', compact('course', 'quiz'));
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
            $isCorrect = isset($answers[$question->id]) && $answers[$question->id] == $question->correct_option;
            $score += $isCorrect ? 1 : 0;
            
            $results[] = [
                'question' => $question->question,
                'userAnswer' => isset($answers[$question->id]) ? $question->options[$answers[$question->id]] : null,
                'correctAnswer' => $question->options[$question->correct_option],
                'isCorrect' => $isCorrect
            ];
        }

        $passed = ($score / $totalQuestions) >= 0.7; // 70% para aprobar

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