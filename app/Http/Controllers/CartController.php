<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Course;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('course')->get();
        $total = $cartItems->sum(function($item) {
            return $item->course->price;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Course $course)
    {
        $user = auth()->user();

        // Verificar si el curso ya está en el carrito
        if ($user->cartItems()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'Este curso ya está en tu carrito.');
        }

        // Verificar si el usuario ya tiene el curso
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'Ya tienes este curso en tu cuenta.');
        }

        // Añadir el curso al carrito
        $user->cartItems()->create([
            'course_id' => $course->id,
            'price' => $course->price
        ]);

        return back();
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->user_id === auth()->id()) {
            $cartItem->delete();
        }

        return back()->with('success', 'Curso eliminado del carrito');
    }

    public function checkout()
    {
        $cartItems = auth()->user()->cartItems()->with('course')->get();
        
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'El carrito está vacío');
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $lineItems = $cartItems->map(function($item) {
                $priceWithVAT = $item->course->price * 1.21; // Añadir 21% IVA
                return [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $item->course->title,
                            'description' => Str::limit($item->course->description, 100),
                        ],
                        'unit_amount' => (int)($priceWithVAT * 100), // Convertir a centavos
                    ],
                    'quantity' => 1,
                ];
            })->toArray();

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('cart.success'),
                'cancel_url' => route('cart.cancel'),
                'metadata' => [
                    'user_id' => auth()->id()
                ]
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    public function success()
    {
        try {
            $cartItems = auth()->user()->cartItems()->with('course')->get();
            
            // Añadir los cursos al usuario
            foreach ($cartItems as $item) {
                auth()->user()->courses()->attach($item->course_id);
                
                // Crear registro de compra
                auth()->user()->purchases()->create([
                    'total' => $item->course->price
                ]);
            }

            // Limpiar el carrito
            auth()->user()->cartItems()->delete();

            return redirect()->route('courses.index')
                ->with('success', '¡Compra realizada con éxito!')
                ->with('show_enrolled_courses_link', true);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar la compra: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->route('cart.index')
            ->with('error', 'Pago cancelado');
    }

    public function clear()
    {
        auth()->user()->cartItems()->delete();
        return back()->with('success', 'Carrito vaciado');
    }
} 