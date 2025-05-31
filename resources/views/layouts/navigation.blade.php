@extends('layouts.app')

<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                        PinCode
                    </a>
                </div>

                <!-- Navegación Principal -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('home') }}" 
                       class="{{ request()->routeIs('home') ? 'active' : '' }} nav-link">
                        <i class="fas fa-home mr-2"></i>
                        Inicio
                    </a>

                    <a href="{{ route('courses.index') }}" 
                       class="{{ request()->routeIs('courses.index') && !request()->routeIs('courses.create') ? 'active' : '' }} nav-link">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Cursos
                    </a>

                    @if(auth()->user()->isTeacher())
                        <a href="{{ route('courses.create') }}" 
                           class="{{ request()->routeIs('courses.create') ? 'active' : '' }} nav-link">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Añadir Curso
                        </a>
                    @endif
                </div>
            </div>

            <!-- Menú de Usuario -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <div class="ml-3 relative">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('cart.index') }}" class="nav-link">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Carrito
                        </a>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 nav-link">
                                <span>{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                                <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>
                                    Mi Perfil
                                </a>

                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm bg-blue-500 text-white hover:bg-red-600 transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav> 