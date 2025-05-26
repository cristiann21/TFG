@extends('layouts.app', ['title' => 'Planes de Suscripción - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
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

        @if($currentSubscription)
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">¡Suscripción Activa!</strong>
                <p class="block sm:inline"> Tu plan {{ ucfirst($currentSubscription->plan_type) }} está activo hasta {{ $currentSubscription->ends_at->format('d/m/Y') }}</p>
                <form action="{{ route('subscriptions.cancel') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="text-green-700 underline hover:text-green-900">
                        Cancelar suscripción
                    </button>
                </form>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($plans as $type => $plan)
                <div class="border border-gray-200 rounded-lg shadow-lg bg-white p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="text-2xl font-bold mb-2 text-center">{{ $plan['name'] }}</h2>
                        <div class="text-3xl font-bold mb-4 text-center">
                            {{ number_format($plan['price'], 2) }} €
                            <span class="text-gray-500 text-lg">/mes</span>
                        </div>
                        <div class="mb-4 text-center">
                            <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Límite de cursos: 
                                @if($plan['course_limit'] === 'Ilimitado')
                                    {{ $plan['course_limit'] }}
                                @else
                                    {{ $plan['course_limit'] }} cursos
                                @endif
                            </span>
                        </div>
                        @if($plan['course_limit'] !== 'Ilimitado')
                            <div class="text-sm text-gray-500 text-center mb-4">
                                Cursos actuales: {{ $currentCourses }}/{{ $plan['course_limit'] }}
                            </div>
                        @endif
                        <ul class="space-y-2 mb-6">
                            @foreach($plan['features'] as $feature)
                                <li class="text-gray-700 flex items-center">
                                    <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        @if(!$currentSubscription)
                            <form action="{{ route('subscriptions.subscribe') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan_type" value="{{ $type }}">
                                <button type="submit" class="w-full bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors font-semibold">
                                    Suscribirse
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-lg cursor-not-allowed font-semibold">
                                Ya tienes una suscripción activa
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 