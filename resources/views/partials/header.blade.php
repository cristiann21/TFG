<header class="main-header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    <h1>PinCode</h1>
                </a>
            </div>
            
            <nav class="main-nav">
                <ul>
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a></li>
                    <li><a href="{{ route('courses.index') }}" class="{{ request()->routeIs('courses.*') ? 'active' : '' }}">Cursos</a></li>
                    <li><a href="#">Sobre Nosotros</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </nav>
            
            <div class="auth-buttons">
                @auth
                    <div class="user-menu">
                        <span>{{ Auth::user()->name }}</span>
                        <div class="dropdown-menu">
                            <a href="{{ route('profile.index') }}">Mi Perfil</a>
                            <a href="{{ route('my-courses') }}">Mis Cursos</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit">Cerrar Sesión</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
                @endauth
            </div>
            
            <button class="mobile-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<div class="mobile-menu">
    <ul>
        <li><a href="{{ route('home') }}">Inicio</a></li>
        <li><a href="{{ route('courses.index') }}">Cursos</a></li>
        <li><a href="#">Sobre Nosotros</a></li>
        <li><a href="#">Contacto</a></li>
        @auth
            <li><a href="{{ route('profile.index') }}">Mi Perfil</a></li>
            <li><a href="{{ route('my-courses') }}">Mis Cursos</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Cerrar Sesión</button>
                </form>
            </li>
        @else
            <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
            <li><a href="{{ route('register') }}">Registrarse</a></li>
        @endauth
    </ul>
</div>