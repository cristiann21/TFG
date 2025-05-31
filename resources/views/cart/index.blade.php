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

            @if(session('error'))
                <div class="alert alert-danger mb-6">
                    {{ session('error') }}
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
                          
                        </form>
                    </div>

                    @foreach($cartItems as $item)
                        <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                            <div>
                                <h3 class="font-medium">{{ $item->course->title }}</h3>
                                <p class="text-sm text-gray-600">{{ optional($item->course->instructor)->name ?? 'Profesor' }}</p>
                                <p class="text-sm font-medium">{{ number_format($item->price, 2) }} €</p>
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
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium">Subtotal:</span>
                            <span class="font-bold">{{ number_format($total, 2) }} €</span>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-medium">IVA (21%):</span>
                            <span class="font-bold">{{ number_format($total * 0.21, 2) }} €</span>
                        </div>
                        <div class="flex justify-between items-center border-t pt-2">
                            <span class="font-medium text-lg">Total:</span>
                            <span class="font-bold text-lg">{{ number_format($total * 1.21, 2) }} €</span>
                        </div>

                        <div class="flex space-x-4">
                            <form action="{{ route('cart.checkout') }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="btn btn-primary w-full">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    Proceder al Pago
                                </button>
                            </form>
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline">
                                    <i class="fas fa-trash mr-2"></i>
                                    Vaciar Carrito
                                </button>
                            </form>
                        </div>

                        <p class="text-sm text-gray-500 mt-2 text-center">
                            El pago se procesará de forma segura a través de Stripe
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 
