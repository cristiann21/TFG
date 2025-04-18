<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class cursos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = User::where('role', 'admin')->first();

        Cursos::create([
            'title' => 'Curso de Laravel Básico',
            'description' => 'Aprende Laravel desde cero.',
            'price' => 29.99,
            'level' => 'Básico',
            'language' => 'PHP',
            'created_by' => $admin->id,
        ]);

        Cursos::create([
            'title' => 'Curso de JavaScript Avanzado',
            'description' => 'DOM, async y más.',
            'price' => 39.99,
            'level' => 'Avanzado',
            'language' => 'JavaScript',
            'created_by' => $admin->id,
        ]);
    }

}
