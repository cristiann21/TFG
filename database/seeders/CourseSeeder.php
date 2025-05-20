<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Course;
use App\Models\Teacher;

class CourseSeeder extends Seeder
{
    public function run()
    {
        // Crear categorías
        $categories = [
            ['name' => 'Desarrollo Web', 'slug' => 'desarrollo-web'],
            ['name' => 'Desarrollo Móvil', 'slug' => 'desarrollo-movil'],
            ['name' => 'Ciencia de Datos', 'slug' => 'ciencia-datos'],
            ['name' => 'DevOps', 'slug' => 'devops'],
            ['name' => 'Inteligencia Artificial', 'slug' => 'inteligencia-artificial'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Crear un profesor de ejemplo si no existe
        $teacher = Teacher::firstOrCreate(
            ['email' => 'profesor@example.com'],
            [
                'name' => 'Profesor Ejemplo',
                'password' => bcrypt('password'),
            ]
        );

        // Lenguajes populares
        $languages = [
            'JavaScript', 'Python', 'Java', 'C#', 'PHP', 
            'C++', 'TypeScript', 'Ruby', 'Swift', 'Kotlin'
        ];

        // Niveles
        $levels = ['Principiante', 'Intermedio', 'Avanzado'];

        // Crear cursos de ejemplo
        $courses = [
            [
                'title' => 'JavaScript Moderno: De cero a experto',
                'description' => 'Aprende JavaScript desde cero, sin conocimientos previos. Incluye Node.js, Express, MongoDB y más.',
                'price' => 49.99,
                'level' => 'Principiante',
                'language' => 'JavaScript',
                'category_id' => 1,
                
            ],
            [
                'title' => 'Python para Ciencia de Datos',
                'description' => 'Domina Python y sus librerías principales para análisis de datos: NumPy, Pandas, Matplotlib y Scikit-Learn.',
                'price' => 59.99,
                'level' => 'Intermedio',
                'language' => 'Python',
                'category_id' => 3,
            ],
            [
                'title' => 'Desarrollo de Aplicaciones Android con Kotlin',
                'description' => 'Crea aplicaciones Android modernas con Kotlin, Jetpack Compose y arquitectura MVVM.',
                'price' => 54.99,
                'level' => 'Intermedio',
                'language' => 'Kotlin',
                'category_id' => 2,
            ],
            [
                'title' => 'Desarrollo Web Full Stack con PHP y Laravel',
                'description' => 'Aprende a crear aplicaciones web completas con PHP, Laravel, MySQL y Vue.js.',
                'price' => 64.99,
                'level' => 'Intermedio',
                'language' => 'PHP',
                'category_id' => 1,
            ],
            [
                'title' => 'Desarrollo de APIs RESTful con Node.js',
                'description' => 'Crea APIs robustas y escalables con Node.js, Express y MongoDB.',
                'price' => 44.99,
                'level' => 'Intermedio',
                'language' => 'JavaScript',
                'category_id' => 1,
            ],
            [
                'title' => 'Machine Learning con Python',
                'description' => 'Aprende los fundamentos del Machine Learning y crea modelos predictivos con Python.',
                'price' => 69.99,
                'level' => 'Avanzado',
                'language' => 'Python',
                'category_id' => 5,
            ],
            [
                'title' => 'Desarrollo de Aplicaciones iOS con Swift',
                'description' => 'Crea aplicaciones iOS modernas con Swift, SwiftUI y patrones de diseño.',
                'price' => 59.99,
                'level' => 'Intermedio',
                'language' => 'Swift',
                'category_id' => 2,
            ],
            [
                'title' => 'Desarrollo de Juegos con Unity y C#',
                'description' => 'Aprende a crear juegos 2D y 3D con Unity y C# desde cero.',
                'price' => 54.99,
                'level' => 'Principiante',
                'language' => 'C#',
                'category_id' => 1,
            ],
            [
                'title' => 'TypeScript para Desarrolladores JavaScript',
                'description' => 'Mejora tus habilidades de JavaScript aprendiendo TypeScript y programación orientada a objetos.',
                'price' => 39.99,
                'level' => 'Intermedio',
                'language' => 'TypeScript',
                'category_id' => 1,
            ],
            [
                'title' => 'DevOps con Docker y Kubernetes',
                'description' => 'Aprende a implementar CI/CD, contenedores y orquestación para tus aplicaciones.',
                'price' => 74.99,
                'level' => 'Avanzado',
                'language' => 'Go',
                'category_id' => 4,
            ],
            [
                'title' => 'Desarrollo Web con Ruby on Rails',
                'description' => 'Crea aplicaciones web rápidamente con Ruby on Rails siguiendo las mejores prácticas.',
                'price' => 49.99,
                'level' => 'Principiante',
                'language' => 'Ruby',
                'category_id' => 1,
            ],
            [
                'title' => 'Programación en C++ Moderna',
                'description' => 'Domina C++ moderno (C++17/C++20) y crea aplicaciones eficientes y robustas.',
                'price' => 59.99,
                'level' => 'Avanzado',
                'language' => 'C++',
                'category_id' => 1,
            ],
        ];

        foreach ($courses as $courseData) {
            $courseData['created_by'] = $teacher->id;
            Course::create($courseData);
        }

        // Crear cursos adicionales aleatorios
        for ($i = 0; $i < 20; $i++) {
            $language = $languages[array_rand($languages)];
            $level = $levels[array_rand($levels)];
            $categoryId = rand(1, 5);
            
            Course::create([
                'title' => "Curso de {$language} " . ($i + 1),
                'description' => "Este es un curso de {$language} de nivel {$level} que te enseñará todo lo necesario para dominar este lenguaje.",
                'price' => rand(20, 100) + 0.99,
                'level' => $level,
                'language' => $language,
                'category_id' => $categoryId,
                'created_by' => $teacher->id,
            ]);
        }
    }
}