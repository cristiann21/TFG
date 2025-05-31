<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
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
    }
} 