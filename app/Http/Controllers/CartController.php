<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Course;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('course')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function add(Course $course)
    {
        // Verificar si el curso ya está en el carrito
        if (auth()->user()->cartItems()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'Ya tienes este curso en tu carrito');
        }

        // Verificar si el usuario ya tiene el curso
        if (auth()->user()->courses()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'Ya tienes este curso en tu cuenta');
        }

        // Añadir al carrito
        auth()->user()->cartItems()->create([
            'course_id' => $course->id,
            'price' => $course->price
        ]);

        return back()->with('success', 'Curso añadido al carrito');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) {
            return back()->with('error', 'No tienes permiso para realizar esta acción');
        }

        $cartItem->delete();
        return back()->with('success', 'Curso eliminado del carrito');
    }

    public function checkout()
    {
        $cartItems = auth()->user()->cartItems()->with('course')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Tu carrito está vacío');
        }

        // Aquí iría la lógica de pago
        // Por ahora solo añadimos los cursos al usuario
        foreach ($cartItems as $item) {
            auth()->user()->courses()->attach($item->course_id);
        }

        // Limpiar el carrito
        auth()->user()->cartItems()->delete();

        return redirect()->route('profile')->with('success', '¡Compra realizada con éxito!');
    }
} 