@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            

            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-4">Detalle de respuestas:</h3>
                
                @foreach($results as $index => $result)
                <br>
                    <div class="mb-4 p-4 rounded-lg {{ $result['isCorrect'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        <p class="font-medium mb-2">{{ $index + 1 }}. {{ $result['question'] }}</p>
                        <div class="ml-4">
                            <p class="mb-2">
                                <span class="font-medium">Tu respuesta:</span>
                                <span class="font-semibold">{{ $result['userAnswer'] }}</span>
                            </p>
                            @if($result['isCorrect'])
                                <p class="text-green-600 font-semibold">
                                    Respuesta correcta ✓
                                </p>
                            @else
                                <p class="text-red-600 font-semibold mb-2">
                                    Respuesta incorrecta ✗
                                </p>
                                <p class="text-green-600">
                                    <span class="font-medium">Respuesta correcta:</span>
                                    <span class="font-semibold">{{ $result['correctAnswer'] }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <br>
            <h2 class="text-2xl font-bold mb-4">Resultados del Test</h2>
            
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-lg">Puntuación:</span>
                    <span class="text-xl font-bold {{ $passed ? 'text-green-600' : 'text-red-600' }}">
                        {{ $score }}/{{ $totalQuestions }}
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-{{ $passed ? 'green' : 'red' }}-600 h-4 rounded-full" 
                         style="width: {{ ($score/$totalQuestions) * 100 }}%"></div>
                </div>
            </div>
            <br>
            <div class="text-center">
                @if($passed)
                    <p class="text-green-600 text-xl font-bold mb-4">¡Felicidades! Has aprobado el test.</p>
                @else
                    <p class="text-red-600 text-xl font-bold mb-4">No has aprobado el test. Necesitas un 50% para aprobar.</p>
                @endif
                
                <a href="{{ route('courses.show', $course) }}" class="btn btn-primary">
                    Volver al curso
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 