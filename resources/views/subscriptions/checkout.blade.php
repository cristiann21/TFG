@extends('layouts.app', ['title' => 'Checkout - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-2xl font-bold mb-6">Completar Suscripción</h1>

            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4">Resumen del Plan</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">Plan Premium</span>
                        <span class="font-semibold">9.99€/mes</span>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• 10 cursos disponibles</li>
                        <li>• Acceso a todos los cursos</li>
                        <li>• Soporte por email</li>
                        <li>• Acceso anticipado a cursos</li>
                    </ul>
                </div>
            </div>

            <form action="{{ route('subscriptions.process') }}" method="POST" id="payment-form">
                @csrf
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4">Información de Pago</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Número de Tarjeta</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="1234 5678 9012 3456">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Expiración</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="MM/AA">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">CVC</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="123">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('subscriptions.index') }}" class="text-blue-600 hover:underline">
                        Volver a planes
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Completar Suscripción
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 