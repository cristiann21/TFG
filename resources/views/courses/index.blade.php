@extends('layouts.app', ['title' => 'Cursos - PinCode'])

@section('content')
<div class="courses-page notebook-bg">
    <div class="container">
        <!-- Hero Section -->
        <div class="courses-hero">
            <div class="hero-content">
                <h1>Explora Nuestros Cursos</h1>
                <p>Descubre cursos de los lenguajes de programación más populares y comienza tu viaje de aprendizaje.</p>
            </div>
        </div>

        <div class="courses-container">
            <!-- Filtros y Buscador -->
            <div class="filters-container">
                <div class="postit-note blue-note filter-card">
                    <form action="{{ route('courses.index') }}" method="GET" id="filter-form" class="filters-form">
                        <div class="filters-grid">
                            <!-- Buscador -->
                            <div class="filter-group search-group">
                                <label for="search">Buscar</label>
                                <div class="search-input">
                                    <input type="text" id="search" name="search" value="{{ $search }}" placeholder="Buscar cursos...">
                                    <button type="submit" class="search-btn">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Filtro por Lenguaje -->
                            <div class="filter-group">
                                <label for="language">Lenguaje</label>
                                <select id="language" name="language" class="filter-select">
                                    <option value="">Todos los lenguajes</option>
                                    @foreach($languages as $lang)
                                        <option value="{{ $lang }}" {{ $language == $lang ? 'selected' : '' }}>{{ $lang }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filtro por Categoría -->
                            <div class="filter-group">
                                <label for="category">Categoría</label>
                                <select id="category" name="category" class="filter-select">
                                    <option value="">Todas las categorías</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filtro por Nivel -->
                            <div class="filter-group">
                                <label for="level">Nivel</label>
                                <select id="level" name="level" class="filter-select">
                                    <option value="">Todos los niveles</option>
                                    @foreach($levels as $lvl)
                                        <option value="{{ $lvl }}" {{ $level == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Ordenamiento -->
                            <div class="filter-group">
                                <label for="sort">Ordenar por</label>
                                <select id="sort" name="sort" class="filter-select">
                                    <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Lenguajes Populares</option>
                                    <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                                    <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                                    <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Más Recientes</option>
                                </select>
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn btn-blue">Aplicar Filtros</button>
                                <a href="{{ route('courses.index') }}" class="btn btn-outline">Limpiar</a>
                            </div>
                        </div>
                    </form>
                    <div class="note-corner"></div>
                </div>
            </div>

            <!-- Listado de Cursos -->
            <div class="courses-list">
                <!-- Resultados y Ordenamiento Móvil -->
                <div class="courses-list-header">
                    <div class="results-count">
                        <p>{{ $courses->total() }} cursos encontrados</p>
                    </div>
                    <div class="mobile-filter-toggle">
                        <button id="show-filters" class="btn btn-sm btn-outline">
                            <i class="fas fa-filter"></i>
                            Filtros
                        </button>
                    </div>
                </div>

                @if($courses->isEmpty())
                    <div class="no-courses">
                        <div class="postit-note yellow-note">
                            <h3>No se encontraron cursos</h3>
                            <p>Intenta con otros filtros o términos de búsqueda.</p>
                            <div class="note-corner"></div>
                        </div>
                    </div>
                @else
                    <div class="courses-grid">
                        @foreach($courses as $course)
                            <div class="course-card {{ ['yellow-note', 'blue-note', 'green-note', 'pink-note', 'purple-note'][($loop->index % 5)] }}">
                                <div class="course-image">
                                    <img src="{{ $course->image ? asset($course->image) : asset('images/course'.($loop->index % 3 + 1).'.png') }}" alt="{{ $course->title }}">
                                    <span class="course-language">{{ $course->language ?? 'General' }}</span>
                                    <span class="course-level">{{ $course->level }}</span>
                                </div>
                                <div class="course-content">
                                    <h3>{{ $course->title }}</h3>
                                    <p>{{ Str::limit($course->description, 100) }}</p>
                                    <div class="course-meta">
                                        <span class="course-price">{{ number_format($course->price, 2) }} €</span>
                                        <span class="course-category">{{ optional($course->category)->name ?? 'Sin categoría' }}</span>
                                    </div>
                                    <div class="course-footer">
                                        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm {{ ['btn-yellow', 'btn-blue', 'btn-green', 'btn-pink', 'btn-purple'][($loop->index % 5)] }}">Ver Curso</a>
                                    </div>
                                </div>
                                <div class="note-corner"></div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Botón Cargar Más -->
                    @if($courses->hasMorePages())
                        <div class="load-more-container">
                            <button id="load-more" class="btn btn-blue" data-page="1">
                                Cargar más cursos
                            </button>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/views/courses.css') }}">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle mobile filters
    const filterToggle = document.getElementById('show-filters');
    const filtersContainer = document.querySelector('.filters-container');
    
    if (filterToggle) {
        filterToggle.addEventListener('click', function() {
            filtersContainer.classList.toggle('active');
            document.body.style.overflow = filtersContainer.classList.contains('active') ? 'hidden' : '';
        });
    }

    // Cerrar filtros al hacer clic fuera
    filtersContainer.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Auto-submit form when select changes
    const filterForm = document.getElementById('filter-form');
    const filterSelects = filterForm.querySelectorAll('select');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            filterForm.submit();
        });
    });

    // Cargar más cursos
    const loadMoreBtn = document.getElementById('load-more');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const currentPage = parseInt(this.dataset.page);
            const nextPage = currentPage + 1;
            
            // Obtener los parámetros de la URL actual
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('page', nextPage);
            
            // Mostrar indicador de carga
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando...';
            this.disabled = true;
            
            // Realizar la petición AJAX
            fetch(`${window.location.pathname}?${urlParams.toString()}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newCourses = doc.querySelector('.courses-grid').innerHTML;
                    
                    // Añadir los nuevos cursos
                    document.querySelector('.courses-grid').insertAdjacentHTML('beforeend', newCourses);
                    
                    // Actualizar el botón
                    this.dataset.page = nextPage;
                    this.innerHTML = 'Cargar más cursos';
                    this.disabled = false;
                    
                    // Ocultar el botón si no hay más páginas
                    if (!doc.querySelector('#load-more')) {
                        this.parentElement.remove();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.innerHTML = 'Error al cargar más cursos';
                    this.disabled = false;
                });
        });
    }
});
</script>
@endpush