@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="postit-note blue-note p-6">
            <!-- Encabezado -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold mb-4">
                    <i class="fas fa-crown mr-2"></i>
                    Elige tu plan
                </h1>
                <p class="text-gray-600">
                    Al suscribirte a nuestro plan premium aceptas nuestros 
                    <a href="#" class="text-blue-600 hover:underline">Términos y Condiciones</a>
                </p>
            </div>

            <!-- Tabla de Planes -->
            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="w-full" border="1" text-align="center">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="p-4 text-center">Contenido</th>
                            <th class="p-4 text-center">FREE</th>
                            <th class="p-4 text-center bg-blue-50 relative">
                                PREMIUM
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500"></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="p-4 font-medium">Cursos disponibles</td>
                            <td class="p-4 text-center">3</td>
                            <td class="p-4 text-center bg-blue-50">Ilimitados</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-4 font-medium">Contenido premium</td>
                            <td class="p-4 text-center">
                                <i class="fas fa-times text-red-500"></i>
                            </td>
                            <td class="p-4 text-center bg-blue-50">
                                <i class="fas fa-check text-green-500"></i>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-4 font-medium">Soporte prioritario</td>
                            <td class="p-4 text-center">
                                <i class="fas fa-times text-red-500"></i>
                            </td>
                            <td class="p-4 text-center bg-blue-50">
                                <i class="fas fa-check text-green-500"></i>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-4 font-medium">Certificados</td>
                            <td class="p-4 text-center">
                                <i class="fas fa-times text-red-500"></i>
                            </td>
                            <td class="p-4 text-center bg-blue-50">
                                <i class="fas fa-check text-green-500"></i>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-4 font-medium">Acceso anticipado a cursos</td>
                            <td class="p-4 text-center">
                                <i class="fas fa-times text-red-500"></i>
                            </td>
                            <td class="p-4 text-center bg-blue-50">
                                <i class="fas fa-check text-green-500"></i>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-4 font-medium">Soporte por email</td>
                            <td class="p-4 text-center">
                                <i class="fas fa-check text-green-500"></i>
                            </td>
                            <td class="p-4 text-center bg-blue-50">
                                <i class="fas fa-check text-green-500"></i>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-4 font-medium">Precio</td>
                            <td class="p-4 text-center font-bold">Gratis</td>
                            <td class="p-4 text-center bg-blue-50 font-bold">9,99 €/mes</td>
                        </tr>
                        <tr>
                            <td class="p-4"></td>
                            <td class="p-4 text-center">
                                @if(!auth()->user()->hasActiveSubscription())
                                    <button class="btn btn-secondary" disabled>
                                        <i class="fas fa-check mr-2"></i>
                                        Plan Actual
                                    </button>
                                @else
                                    <form action="{{ route('subscriptions.downgrade') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary">
                                            <i class="fas fa-arrow-down mr-2"></i>
                                            Cambiar a Free
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="p-4 text-center bg-blue-50">
                                @if(auth()->user()->hasActiveSubscription() && auth()->user()->subscriptions()->where('is_active', true)->first()->plan_type === 'premium')
                                    <button class="btn btn-primary" disabled>
                                        <i class="fas fa-check mr-2"></i>
                                        Plan Actual
                                    </button>
                                @else
                                    <form action="{{ route('subscriptions.upgrade') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-crown mr-2"></i>
                                            Suscribirse al Premium
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 