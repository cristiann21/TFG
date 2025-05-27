@extends('layouts.app', ['title' => 'Planes de Suscripción - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold mb-4">Planes de Suscripción</h1>
            <p class="text-gray-600">Elige el plan que mejor se adapte a tus necesidades</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">¡Éxito!</strong> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Error:</strong> {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full bg-white rounded-lg shadow-lg text-center mb-8">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-4 px-2 text-lg font-bold"></th>
                        <th class="py-4 px-2 text-lg font-bold">FREE</th>
                        <th class="py-4 px-2 text-lg font-bold">PREMIUM</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr>
                        <td class="py-3 font-semibold">Límite de cursos</td>
                        <td>3</td>
                        <td>Ilimitado</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="py-3 font-semibold">Contenido premium</td>
                        <td><span class="text-red-500 text-xl">&#10006;</span></td>
                        <td><span class="text-green-500 text-xl">&#10004;</span></td>
                    </tr>
                    <tr>
                        <td class="py-3 font-semibold">Soporte prioritario</td>
                        <td><span class="text-red-500 text-xl">&#10006;</span></td>
                        <td><span class="text-green-500 text-xl">&#10004;</span></td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="py-3 font-semibold">Certificados</td>
                        <td><span class="text-red-500 text-xl">&#10006;</span></td>
                        <td><span class="text-green-500 text-xl">&#10004;</span></td>
                    </tr>
                    <tr>
                        <td class="py-3 font-semibold">Acceso anticipado a cursos</td>
                        <td><span class="text-red-500 text-xl">&#10006;</span></td>
                        <td><span class="text-green-500 text-xl">&#10004;</span></td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="py-3 font-semibold">Soporte por email</td>
                        <td><span class="text-green-500 text-xl">&#10004;</span></td>
                        <td><span class="text-green-500 text-xl">&#10004;</span></td>
                    </tr>
                    <tr>
                        <td class="py-3 font-semibold">Precio</td>
                        <td>Gratis</td>
                        <td>9,99 €/mes</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col md:flex-row justify-center items-center gap-6 mt-8">
            <div class="flex-1 flex flex-col items-center">
                @if($currentSubscription && $currentSubscription->plan_type === 'free')
                    <button disabled class="bg-gray-400 text-white px-8 py-3 rounded-full font-semibold shadow-md opacity-80 cursor-not-allowed text-lg">
                        Plan actual
                    </button>
                @elseif(!$currentSubscription)
                    <form action="{{ route('subscriptions.subscribe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_type" value="free">
                        <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white px-8 py-3 rounded-full font-semibold shadow-md text-lg transition-all">
                            Activar Plan Free
                        </button>
                    </form>
                @else
                    <button disabled class="bg-gray-300 text-gray-500 px-8 py-3 rounded-full font-semibold shadow-md cursor-not-allowed text-lg">
                        Ya tienes una suscripción activa
                    </button>
                @endif
            </div>
            <div class="flex-1 flex flex-col items-center">
                @if(!$currentSubscription || ($currentSubscription && $currentSubscription->plan_type !== 'premium'))
                    <form action="{{ route('subscriptions.subscribe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_type" value="premium">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-full font-semibold shadow-md text-lg transition-all">
                            Suscribirse al Plan Premium
                        </button>
                    </form>
                @else
                    <button disabled class="bg-gray-400 text-white px-8 py-3 rounded-full font-semibold shadow-md opacity-80 cursor-not-allowed text-lg">
                        Plan actual
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 