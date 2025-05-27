<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Course;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;

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

        $total = $cartItems->sum('price');

        try {
            // Crear el pago en Stripe
            $payment = auth()->user()->charge($total * 100, [
                'description' => 'Compra de cursos en PinCode',
                'metadata' => [
                    'courses' => $cartItems->pluck('course.title')->join(', '),
                    'user_id' => auth()->id(),
                    'user_email' => auth()->user()->email
                ],
                'receipt_email' => auth()->user()->email,
                'currency' => 'eur'
            ]);

            // Si el pago es exitoso, añadir los cursos al usuario
            foreach ($cartItems as $item) {
                auth()->user()->courses()->attach($item->course_id);
            }

            // Limpiar el carrito
            auth()->user()->cartItems()->delete();

            return redirect()->route('profile.courses')
                ->with('success', '¡Compra realizada con éxito! Ya puedes acceder a tus cursos.');

        } catch (IncompletePayment $exception) {
            return redirect()->route('cashier.payment', [
                $exception->payment->id, 
                'redirect' => route('profile.courses')
            ]);
        } catch (CardException $e) {
            return back()->with('error', 'Error con la tarjeta: ' . $e->getMessage());
        } catch (InvalidRequestException $e) {
            return back()->with('error', 'Error en la solicitud de pago: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Hubo un error al procesar el pago. Por favor, inténtalo de nuevo.');
        }
    }

    public function clear()
    {
        auth()->user()->cartItems()->delete();
        return back()->with('success', 'Carrito vaciado correctamente');
    }
} 