@extends('layouts.app', ['title' => 'Olvidé mi contraseña'])

@section('content')
<div class="auth-container">
    <h2>¿Olvidaste tu contraseña?</h2>
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <label for="email">Correo Electrónico</label>
        <input type="email" name="email" required>
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit">Enviar enlace de restablecimiento</button>
    </form>
</div>
@endsection
