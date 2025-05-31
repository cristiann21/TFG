@extends('layouts.app', ['title' => 'Suscripciones - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-4">Planes de Suscripción</h1>
            <p class="text-xl text-gray-600">Elige el plan que mejor se adapte a tus necesidades</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-2 border-gray-300" border="1">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border-2 border-gray-300 p-4 text-left">Características</th>
                        <th class="border-2 border-gray-300 p-4 text-center">Plan Free</th>
                        <th class="border-2 border-gray-300 p-4 text-center">Plan de Prueba</th>
                        <th class="border-2 border-gray-300 p-4 text-center">Plan Premium</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-2 border-gray-300 p-4 font-semibold">Precio</td>
                        <td class="border-2 border-gray-300 p-4 text-center">Gratuito</td>
                        <td class="border-2 border-gray-300 p-4 text-center">0€/mes</td>
                        <td class="border-2 border-gray-300 p-4 text-center">9.99€/mes</td>
                    </tr>
                    <tr>
                        <td class="border-2 border-gray-300 p-4">Cursos disponibles</td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            <span class="text-red-500">✗</span> Sin acceso a cursos
                        </td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            <span class="text-green-500">✓</span> 3 cursos
                        </td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            <span class="text-green-500">✓</span> 25 cursos
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 border-gray-300 p-4">Acceso a cursos</td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            <span class="text-green-500">✓</span> Gratuitos
                        </td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            <span class="text-green-500">✓</span> Seleccionados
                        </td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            <span class="text-green-500">✓</span> Todos
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 border-gray-300 p-4">Soporte por email</td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            <span class="text-red-500">✗</span>
                        </td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            <span class="text-green-500">✓</span>
                        </td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            <span class="text-green-500">✓</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 border-gray-300 p-4">Acceso anticipado</td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            <span class="text-red-500">✗</span>
                        </td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            <span class="text-red-500">✗</span>
                        </td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            <span class="text-green-500">✓</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 border-gray-300 p-4">Acción</td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            @if($currentSubscription && $currentSubscription->plan_type === 'free')
                                <button class="w-full py-2 px-4 bg-blue-500 text-white rounded cursor-not-allowed" disabled>Plan Actual</button>
                            @else
                                <a href="{{ route('subscriptions.checkout', 'free') }}" class="btn btn-primary w-full">Cambiar a Free</a>
                            @endif
                        </td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            @if($currentSubscription && $currentSubscription->plan_type === 'trial')
                                <button class="w-full py-2 px-4 bg-blue-500 text-white rounded cursor-not-allowed" disabled>Plan Actual</button>
                            @else
                                <a href="{{ route('subscriptions.checkout', 'trial') }}" class="btn btn-primary w-full">Probar Ahora</a>
                            @endif
                        </td>
                        <td class="border-2 border-gray-300 p-4 text-center">
                            @if($currentSubscription && $currentSubscription->plan_type === 'premium')
                                <button class="w-full py-2 px-4 bg-blue-500 text-white rounded cursor-not-allowed" disabled>Plan Actual</button>
                            @else
                                <a href="{{ route('subscriptions.checkout', 'premium') }}" class="btn btn-primary w-full">Suscribirse Ahora</a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="mt-16 max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-center mb-8">Preguntas Frecuentes</h2>
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-2">¿Cómo funciona la suscripción?</h3>
                <p class="text-gray-600">Al suscribirte al plan Premium, tendrás acceso a 25 cursos disponibles en la plataforma. Puedes cancelar tu suscripción en cualquier momento.</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-2">¿Puedo cambiar de plan?</h3>
                <p class="text-gray-600">Sí, puedes cambiar entre planes en cualquier momento. Los cambios se aplicarán en tu próximo ciclo de facturación.</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-2">¿Qué métodos de pago aceptan?</h3>
                <p class="text-gray-600">Aceptamos todas las tarjetas de crédito y débito principales a través de Stripe.</p>
            </div>
        </div>
    </div>
</div>
@endsection 