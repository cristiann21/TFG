@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $quiz->title }}</h1>
    <p>{{ $quiz->description }}</p>

    <form action="{{ route('quizzes.submit', ['course' => $course->id, 'quiz' => $quiz->id]) }}" method="POST">
        @csrf
        @foreach($quiz->questions as $question)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $question->question }}</h5>
                    @foreach(json_decode($question->options) as $index => $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $index }}" id="question{{ $question->id }}_option{{ $index }}">
                            <label class="form-check-label" for="question{{ $question->id }}_option{{ $index }}">
                                {{ $option }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Enviar respuestas</button>
    </form>
</div>
@endsection 