<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;

class CourseSeeder extends Seeder
{
    public function run(): void
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
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        // Crear un profesor de ejemplo si no existe
        $teacher = User::firstOrCreate(
            ['email' => 'profesor@example.com'],
            [
                'name' => 'Profesor Ejemplo',
                'password' => bcrypt('password'),
                'role' => 'teacher'
            ]
        );

        // Crear cursos de ejemplo
        $cursos = [
            [
                'title' => 'Introducción a PHP',
                'description' => 'Aprende los fundamentos de PHP desde cero.',
                'price' => 19.99,
                'level' => 'Principiante',
                'language' => 'PHP',
                'category_id' => 1,
            ],
            [
                'title' => 'Laravel Básico',
                'description' => 'Crea aplicaciones web modernas con Laravel.',
                'price' => 29.99,
                'level' => 'Principiante',
                'language' => 'PHP',
                'category_id' => 1,
            ],
            [
                'title' => 'JavaScript para Principiantes',
                'description' => 'Domina el lenguaje de la web.',
                'price' => 24.99,
                'level' => 'Principiante',
                'language' => 'JavaScript',
                'category_id' => 1,
            ],
            [
                'title' => 'Python desde Cero',
                'description' => 'Empieza a programar con Python de manera sencilla.',
                'price' => 21.99,
                'level' => 'Principiante',
                'language' => 'Python',
                'category_id' => 3,
            ],
            [
                'title' => 'CSS y Diseño Web',
                'description' => 'Aprende a crear sitios web atractivos y responsivos.',
                'price' => 17.99,
                'level' => 'Principiante',
                'language' => 'CSS',
                'category_id' => 1,
            ],
        ];

        foreach ($cursos as $curso) {
            $curso['created_by'] = $teacher->id;
            Course::create($curso);
        }

        // Crear cursos adicionales aleatorios
        $languages = ['JavaScript', 'Python', 'Java', 'C#', 'PHP', 'C++', 'TypeScript', 'Ruby', 'Swift', 'Kotlin'];
        $levels = ['Principiante', 'Intermedio', 'Avanzado'];

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