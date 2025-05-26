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