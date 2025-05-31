<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function checkout(Course $course)
    {
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $course->title,
                            'description' => $course->description,
                        ],
                        'unit_amount' => $course->price * 100, // Stripe usa centavos
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.success', ['course' => $course->id]),
                'cancel_url' => route('stripe.cancel'),
                'metadata' => [
                    'course_id' => $course->id,
                    'user_id' => auth()->id()
                ]
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    public function success(Course $course)
    {
        try {
            // Añadir el curso al usuario
            auth()->user()->courses()->attach($course->id);

            // Crear registro de compra
            auth()->user()->purchases()->create([
                'total' => $course->price
            ]);

            return redirect()->route('courses.show', $course)
                ->with('success', '¡Compra realizada con éxito! Ya puedes acceder al curso.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar la compra: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->route('courses.index')
            ->with('error', 'Pago cancelado');
    }
} 