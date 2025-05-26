@extends('layouts.app', ['title' => 'Mi Carrito - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="postit-note blue-note p-6">
            <h1 class="text-2xl font-bold mb-6">Mi Carrito</h1>

            @if(session('success'))
                <div class="alert alert-success mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $cartItems = auth()->user()->cartItems()->with('course')->get();
                $total = $cartItems->sum('price');
            @endphp

            @if($cartItems->isEmpty())
                <p class="text-gray-600">Tu carrito está vacío</p>
                <a href="{{ route('courses.index') }}" class="btn btn-primary mt-4">
                    Explorar Cursos
                </a>
            @else
                <div class="space-y-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Mi Carrito</h2>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Vaciar Carrito
                            </button>
                        </form>
                    </div>
                    @foreach($cartItems as $item)
                        <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                            <div>
                                <h3 class="font-medium">{{ $item->course->title }}</h3>
                                <p class="text-sm text-gray-600">{{ optional($item->course->instructor)->name ?? 'Profesor' }}</p>
                                <p class="text-sm font-medium">${{ number_format($item->price, 2) }}</p>
                            </div>
                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    @endforeach

                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Total:</span>
                            <span class="font-bold text-lg">${{ number_format($total, 2) }}</span>
                        </div>
                        <form action="{{ route('cart.checkout') }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600">
                                Proceder al Pago
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 