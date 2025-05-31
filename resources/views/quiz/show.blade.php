@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="postit-note blue-note">
            <h1 class="text-2xl font-bold mb-6">Test del Curso: {{ $course->title }}</h1>

            @if(session('error'))
                <div class="alert alert-danger mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('quiz.submit', $course) }}" method="POST">
                @csrf
                <div class="space-y-6">
                    @foreach($quiz->questions as $index => $question)
                        <div class="bg-white rounded-lg p-6 shadow-sm">
                            <h3 class="font-semibold mb-4">{{ $index + 1 }}. {{ $question->question }}</h3>
                            <div class="space-y-3">
                                @foreach($question->options as $key => $option)
                                    <label class="flex items-center space-x-3">
                                        <input type="radio" 
                                               name="answers[{{ $question->id }}]" 
                                               value="{{ $key }}"
                                               class="form-radio text-primary">
                                        <span>{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    <button type="submit" class="btn btn-primary w-full">
                        Enviar Respuestas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 