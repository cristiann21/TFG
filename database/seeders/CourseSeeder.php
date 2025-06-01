<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizQuestion;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Curso de prueba gratis sin test
        Course::create([
            'title' => 'Introducción a la Programación',
            'description' => 'Aprende los conceptos básicos de programación con este curso gratuito. Ideal para principiantes que quieren dar sus primeros pasos en el mundo del desarrollo.',
            'price' => 0,
            'image' => 'courses/intro-programming.jpg',
            'video_url' => 'https://www.youtube.com/embed/example1',
            'level' => 'Principiante',
            'created_by' => 1
        ]);

        // Curso premium de 10 euros
        Course::create([
            'title' => 'Desarrollo Web Avanzado',
            'description' => 'Domina las tecnologías web más demandadas. Aprende HTML5, CSS3, JavaScript y frameworks modernos para crear aplicaciones web profesionales.',
            'price' => 10,
            'image' => 'courses/web-development.jpg',
            'video_url' => 'https://www.youtube.com/embed/example2',
            'level' => 'Intermedio',
            'created_by' => 1
        ]);

        // Curso de 5 euros
        Course::create([
            'title' => 'Bases de Datos SQL',
            'description' => 'Aprende a diseñar y gestionar bases de datos relacionales. Desde consultas básicas hasta optimización avanzada de bases de datos.',
            'price' => 5,
            'image' => 'courses/sql-database.jpg',
            'video_url' => 'https://www.youtube.com/embed/example3',
            'level' => 'Principiante',
            'created_by' => 1
        ]);

        // Curso de prueba gratis con quiz
        $course = Course::create([
            'title' => 'Fundamentos de Python',
            'description' => 'Introducción completa al lenguaje Python. Aprende desde cero con ejercicios prácticos y un quiz final para evaluar tus conocimientos.',
            'price' => 0,
            'level' => 'Principiante',
            'image' => 'courses/python-basics.jpg',
            'video_url' => 'https://www.youtube.com/embed/example4',
            'created_by' => 1
        ]);

        // Crear quiz para el curso
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Quiz Final de Python',
            'description' => 'Evalúa tus conocimientos sobre los fundamentos de Python',
            'passing_score' => 70
        ]);

        // Crear preguntas para el quiz
        QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => '¿Qué es Python?',
            'options' => json_encode([
                'Un lenguaje de programación interpretado',
                'Un sistema operativo',
                'Una base de datos',
                'Un framework web'
            ]),
            'correct_option' => 0
        ]);

        QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => '¿Cómo se declara una variable en Python?',
            'options' => json_encode([
                'var x = 5',
                'let x = 5',
                'x = 5',
                'const x = 5'
            ]),
            'correct_option' => 2
        ]);
    }
} 