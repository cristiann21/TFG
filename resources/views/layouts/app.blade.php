<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    @if(!isset($hideHeader) || !$hideHeader)
        <header class="main-header">
            <div class="container">
                <div class="header-content">
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset('images/logo.png') }}" alt="PinCode Logo">
                        <h1>PinCode</h1>
                    </a>

                    <nav class="main-nav">
                        <ul>
                            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a></li>
                            <li><a href="{{ route('courses.index') }}" class="{{ request()->routeIs('courses.*') ? 'active' : '' }}">Cursos</a></li>
                            @if(auth()->check() && auth()->user()->role === 'teacher')
                                <li><a href="{{ route('courses.create') }}" class="{{ request()->routeIs('courses.create') ? 'active' : '' }}">Añadir Curso</a></li>
                            @endif
                            <li><a href="{{ route('subscriptions.index') }}" class="{{ request()->routeIs('subscriptions.*') ? 'active' : '' }}">
                                @if(auth()->check() && auth()->user()->hasActiveSubscription())
                                    <span class="text-green-400">Suscripción Activa</span>
                                @else
                                    Suscripciones
                                @endif
                            </a></li>
                            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Nosotros</a></li>
                            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contacto</a></li>
                        </ul>
                    </nav>

                    <div class="auth-buttons">
                        <div class="flex items-center space-x-4">
                            @auth
                                <a href="{{ route('profile.index') }}" class="text-gray-300 hover:text-white">{{ auth()->user()->name }}</a>
                                <span class="text-gray-400">|</span>
                                
                                <a href="{{ route('cart.index') }}" class="text-gray-300 hover:text-white">
                                    Mi Carrito ({{ auth()->user()->cartItems()->count() }})
                                </a>
                                <form action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        
                                        Cerrar Sesión
                                    </button>
                                </form>
                            @else
                            
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Iniciar Sesión | </a>
                                <a href="{{ route('register') }}" class="text-gray-700 hover:text-gray-900">Registrarse</a>
                            @endauth
                        </div>
                    </div>

                    <button class="mobile-menu-toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </header>

        <nav class="mobile-menu">
            <ul>
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li><a href="{{ route('courses.index') }}">Cursos</a></li>
                @if(auth()->check() && auth()->user()->isTeacher())
                    <li><a href="{{ route('courses.create') }}">Añadir Curso</a></li>
                @endif
                <li><a href="{{ route('subscriptions.index') }}">
                    @if(auth()->check() && auth()->user()->hasActiveSubscription())
                        <span class="text-green-400">Suscripción Activa</span>
                    @else
                        Suscripciones
                    @endif
                </a></li>
                <li><a href="{{ route('about') }}">Nosotros</a></li>
                <li><a href="{{ route('contact') }}">Contacto</a></li>
                @auth
                    <li><a href="{{ route('profile.index') }}">Mi Perfil</a></li>
                    <li><a href="{{ route('cart.index') }}">Mi Carrito ({{ auth()->user()->cartItems()->count() }})</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Cerrar Sesión</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                    <li><a href="{{ route('register') }}">Registrarse</a></li>
                @endauth
            </ul>
        </nav>
    @endif

    <main>
        @yield('content')
    </main>

    @if(!isset($hideFooter) || !$hideFooter)
        <footer class="main-footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="PinCode Logo">
                        <h2>PinCode</h2>
                        <p>Aprende programación de una manera divertida y efectiva.</p>
                    </div>

                    <div class="footer-links">
                        <div class="footer-column">
                            <h3>Enlaces</h3>
                            <ul>
                                <li><a href="{{ route('courses.index') }}">Cursos</a></li>
                                <li><a href="{{ route('about') }}">Nosotros</a></li>
                                <li><a href="{{ route('contact') }}">Contacto</a></li>
                            </ul>
                        </div>

                        <div class="footer-column">
                            <h3>Legal</h3>
                            <ul>
                                <li><a href="{{ route('terms') }}">Términos y Condiciones</a></li>
                                <li><a href="{{ route('privacy') }}">Política de Privacidad</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} PinCode. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    @endif

    <!-- Scripts -->
    <script>
        // Toggle mobile menu
        document.querySelector('.mobile-menu-toggle').addEventListener('click', function() {
            this.classList.toggle('active');
            document.querySelector('.mobile-menu').classList.toggle('active');
        });
    </script>
    @stack('scripts')

    @push('styles')
    <style>
    .user-profile {
        position: relative;
    }

    .profile-dropdown {
        position: relative;
    }

    .profile-trigger {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        border: none;
        background: none;
        cursor: pointer;
        border-radius: var(--border-radius);
        transition: background-color 0.3s ease;
    }

    .profile-trigger:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-name {
        font-weight: 500;
        color: var(--color-text);
    }

    .profile-trigger i {
        font-size: 0.8rem;
        color: var(--color-text-light);
        transition: transform 0.3s ease;
    }

    .profile-dropdown.active .profile-trigger i {
        transform: rotate(180deg);
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        min-width: 200px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 0.5rem 0;
        margin-top: 0.5rem;
        display: none;
        z-index: 1000;
    }

    .profile-dropdown.active .dropdown-menu {
        display: block;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: var(--color-text);
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .dropdown-item i {
        width: 1rem;
        text-align: center;
    }

    .dropdown-divider {
        height: 1px;
        background-color: var(--color-border);
        margin: 0.5rem 0;
    }

    .dropdown-item.text-danger {
        color: var(--color-danger);
    }

    @media (max-width: 768px) {
        .user-name {
            display: none;
        }
        
        .dropdown-menu {
            right: -1rem;
        }
    }
    </style>
    @endpush

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileDropdown = document.querySelector('.profile-dropdown');
        const profileTrigger = document.querySelector('.profile-trigger');

        if (profileTrigger) {
            profileTrigger.addEventListener('click', function(e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('active');
            });

            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target)) {
                    profileDropdown.classList.remove('active');
                }
            });
        }
    });
    </script>
    @endpush
</body>
</html>