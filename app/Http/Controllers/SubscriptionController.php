<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = [
            'basic' => [
                'name' => 'Plan Básico',
                'price' => 9.99,
                'course_limit' => 5,
                'features' => [
                    'Acceso a 5 cursos simultáneos',
                    'Actualizaciones mensuales',
                    'Soporte por email',
                    'Acceso a recursos básicos',
                    'Certificados de finalización'
                ]
            ],
            'premium' => [
                'name' => 'Plan Premium',
                'price' => 19.99,
                'course_limit' => 'Ilimitado',
                'features' => [
                    'Acceso ilimitado a todos los cursos',
                    'Actualizaciones semanales',
                    'Soporte prioritario 24/7',
                    'Certificados de finalización',
                    'Proyectos prácticos',
                    'Acceso a recursos premium',
                    'Mentorías personalizadas'
                ]
            ]
        ];

        $currentSubscription = auth()->user()->subscriptions()
            ->where('is_active', true)
            ->where('ends_at', '>', now())
            ->first();

        // Obtener el número de cursos actuales del usuario
        $currentCourses = auth()->user()->courses()->count();

        return view('subscriptions.index', compact('plans', 'currentSubscription', 'currentCourses'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_type' => 'required|in:basic,premium'
        ]);

        // Verificar si el usuario ya tiene una suscripción activa
        $activeSubscription = auth()->user()->subscriptions()
            ->where('is_active', true)
            ->where('ends_at', '>', now())
            ->first();

        if ($activeSubscription) {
            return back()->with('error', 'Ya tienes una suscripción activa');
        }

        // Verificar límite de cursos para plan básico
        if ($request->plan_type === 'basic') {
            $currentCourses = auth()->user()->courses()->count();
            if ($currentCourses >= 5) {
                return back()->with('error', 'Ya tienes 5 cursos. Actualiza a Premium para acceder a más cursos.');
            }
        }

        $plans = [
            'basic' => 9.99,
            'premium' => 19.99
        ];

        // Crear nueva suscripción
        $subscription = new Subscription([
            'plan_type' => $request->plan_type,
            'price' => $plans[$request->plan_type],
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'is_active' => true,
            'payment_status' => 'pending'
        ]);

        auth()->user()->subscriptions()->save($subscription);

        return redirect()->route('subscriptions.index')
            ->with('success', '¡Suscripción creada con éxito!');
    }

    public function cancel()
    {
        $subscription = auth()->user()->subscriptions()
            ->where('is_active', true)
            ->where('ends_at', '>', now())
            ->first();

        if ($subscription) {
            $subscription->update(['is_active' => false]);
            return back()->with('success', 'Suscripción cancelada con éxito');
        }

        return back()->with('error', 'No se encontró una suscripción activa');
    }
} 