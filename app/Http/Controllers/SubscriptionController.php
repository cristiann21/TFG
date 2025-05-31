<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class SubscriptionController extends Controller
{
    protected $subscriptionPlans = [
        'free' => [
            'name' => 'Plan Free',
            'price' => 0,
            'course_limit' => 0,
            'features' => [
                'Acceso a cursos gratuitos',
                'Actualizaciones mensuales',
                'Sin soporte por email',
                'Acceso a recursos básicos'
            ]
        ],
        'trial' => [
            'name' => 'Plan de Prueba',
            'price' => 0,
            'course_limit' => 3,
            'features' => [
                'Acceso a 3 cursos seleccionados',
                'Actualizaciones mensuales',
                'Soporte por email',
                'Acceso a recursos básicos'
            ]
        ],
        'premium' => [
            'name' => 'Plan Premium',
            'price' => 9.99,
            'course_limit' => 25,
            'features' => [
                'Acceso a todos los cursos',
                'Actualizaciones mensuales',
                'Soporte por email prioritario',
                'Acceso anticipado a nuevos cursos',
                'Acceso a recursos premium'
            ]
        ]
    ];

    public function index()
    {
        $user = Auth::user();
        $currentSubscription = $user->subscriptions()->where('is_active', true)->first();
        return view('subscriptions.index', compact('currentSubscription'));
    }

    public function checkout($plan)
    {
        if (!array_key_exists($plan, $this->subscriptionPlans)) {
            return redirect()->route('subscriptions.index')->with('error', 'Plan no válido');
        }

        $user = Auth::user();
        $currentSubscription = $user->subscriptions()->where('is_active', true)->first();

        // Si el usuario ya tiene el plan que intenta activar
        if ($currentSubscription && $currentSubscription->plan_type === $plan) {
            return redirect()->route('subscriptions.index')->with('error', 'Ya tienes este plan activo');
        }

        // Si es plan free o trial, activar directamente
        if ($plan === 'free' || $plan === 'trial') {
            try {
                DB::beginTransaction();

                // Desactivar todas las suscripciones activas
                $user->subscriptions()->where('is_active', true)->update(['is_active' => false]);

                // Crear la nueva suscripción
                $subscription = new Subscription();
                $subscription->user_id = $user->id;
                $subscription->plan_type = $plan;
                $subscription->is_active = true;
                $subscription->price = 0;
                $subscription->starts_at = now();
                $subscription->payment_status = 'completed';
                
                // Establecer la fecha de expiración según el plan
                if ($plan === 'free') {
                    $subscription->ends_at = null; // Plan gratuito sin expiración
                } elseif ($plan === 'trial') {
                    $subscription->ends_at = now()->addDays(7); // 7 días de prueba
                }

                if (!$subscription->save()) {
                    throw new \Exception('Error al guardar la suscripción');
                }

                DB::commit();

                return redirect()->route('subscriptions.index')
                    ->with('success', 'Suscripción actualizada correctamente');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('subscriptions.index')
                    ->with('error', 'Error al procesar la suscripción: ' . $e->getMessage());
            }
        }

        // Para plan premium, procesar con Stripe
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $this->subscriptionPlans[$plan]['name'],
                        ],
                        'unit_amount' => $this->subscriptionPlans[$plan]['price'] * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('subscriptions.success', ['plan' => $plan]),
                'cancel_url' => route('subscriptions.cancel'),
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return redirect()->route('subscriptions.index')->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    public function process($plan)
    {
        try {
            DB::beginTransaction();

            // Desactivar todas las suscripciones activas
            auth()->user()->subscriptions()->where('is_active', true)->update(['is_active' => false]);

            // Crear la nueva suscripción
            $subscription = new Subscription();
            $subscription->user_id = auth()->id();
            $subscription->plan_type = $plan;
            $subscription->is_active = true;
            $subscription->price = $this->subscriptionPlans[$plan]['price'];
            $subscription->starts_at = now();
            $subscription->payment_status = 'completed';
            
            // Establecer la fecha de expiración según el plan
            if ($plan === 'free') {
                $subscription->ends_at = null; // Plan gratuito sin expiración
            } elseif ($plan === 'trial') {
                $subscription->ends_at = now()->addDays(7); // 7 días de prueba
            } else {
                $subscription->ends_at = now()->addMonth(); // 1 mes para premium
            }

            if (!$subscription->save()) {
                throw new \Exception('Error al guardar la suscripción');
            }

            DB::commit();

            return redirect()->route('subscriptions.index')
                ->with('success', 'Suscripción actualizada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('subscriptions.index')
                ->with('error', 'Error al procesar la suscripción: ' . $e->getMessage());
        }
    }

    public function success(Request $request, $plan)
    {
        return $this->process($plan);
    }

    public function cancel()
    {
        return redirect()->route('subscriptions.index')->with('error', 'Pago cancelado');
    }
} 