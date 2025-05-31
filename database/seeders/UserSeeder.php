<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario de prueba
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'student'
        ]);

        // Crear suscripción free para el usuario
        Subscription::create([
            'user_id' => $user->id,
            'plan_type' => 'free',
            'price' => 0,
            'starts_at' => now(),
            'ends_at' => now()->addDays(30),
            'is_active' => true,
            'payment_status' => 'completed'
        ]);

        // Crear usuario profesor de prueba
        $teacher = User::create([
            'name' => 'Test Teacher',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher'
        ]);

        // Crear suscripción free para el profesor
        Subscription::create([
            'user_id' => $teacher->id,
            'plan_type' => 'free',
            'price' => 0,
            'starts_at' => now(),
            'ends_at' => now()->addDays(30),
            'is_active' => true,
            'payment_status' => 'completed'
        ]);
    }
} 