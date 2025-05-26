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

                    <!-- Paginación -->
                    <div class="pagination-container">
                        {{ $courses->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.courses-page {
    min-height: 100vh;
    padding: 2rem 0;
}

.courses-hero {
    text-align: center;
    margin-bottom: 2rem;
}

.courses-hero h1 {
    font-family: var(--font-handwritten);
    font-size: 2.5rem;
    color: var(--color-primary);
    margin-bottom: 1rem;
}

.courses-hero p {
    font-size: 1.2rem;
    color: var(--color-text-light);
    max-width: 600px;
    margin: 0 auto;
}

.courses-container {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.filters-container {
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.filter-card {
    padding: 1.5rem;
}

.filters-grid {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group label {
    font-family: var(--font-handwritten);
    color: var(--color-text);
    font-size: 1.1rem;
}

.search-group {
    grid-column: 1 / -1;
}

.search-input {
    position: relative;
}

.search-input input {
    width: 100%;
    padding: 0.75rem 1rem;
    padding-right: 3rem;
    border: 2px solid var(--color-border);
    border-radius: var(--border-radius);
    font-family: var(--font-handwritten);
}

.search-btn {
    position: absolute;
    right: 0.5rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--color-primary);
    cursor: pointer;
    padding: 0.5rem;
}

.filter-select {
    padding: 0.75rem 1rem;
    border: 2px solid var(--color-border);
    border-radius: var(--border-radius);
    font-family: var(--font-handwritten);
    background-color: white;
    cursor: pointer;
}

.filter-select:focus {
    outline: none;
    border-color: var(--color-primary);
}

.filter-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.courses-list {
    min-height: 500px;
}

.courses-list-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.results-count p {
    color: var(--color-text-light);
    font-size: 1.1rem;
}

.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.course-card {
    position: relative;
    transition: transform 0.3s ease;
}

.course-card:hover {
    transform: translateY(-5px);
}

.course-image {
    position: relative;
    border-radius: var(--border-radius) var(--border-radius) 0 0;
    overflow: hidden;
}

.course-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.course-language,
.course-level {
    position: absolute;
    top: 1rem;
    padding: 0.25rem 0.75rem;
    border-radius: var(--border-radius);
    font-size: 0.9rem;
    font-weight: 500;
}

.course-language {
    left: 1rem;
    background: var(--color-primary);
    color: white;
}

.course-level {
    right: 1rem;
    background: rgba(255, 255, 255, 0.9);
    color: var(--color-text);
}

.course-content {
    padding: 1.5rem;
}

.course-content h3 {
    font-family: var(--font-handwritten);
    font-size: 1.5rem;
    color: var(--color-text);
    margin-bottom: 1rem;
}

.course-content p {
    color: var(--color-text-light);
    margin-bottom: 1rem;
    line-height: 1.5;
}

.course-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.course-price {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--color-primary);
}

.course-category {
    font-size: 0.9rem;
    color: var(--color-text-light);
}

.course-footer {
    text-align: right;
}

.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

@media (max-width: 1024px) {
    .courses-container {
        grid-template-columns: 1fr;
    }

    .filters-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        padding: 1rem;
        display: none;
    }

    .filters-container.active {
        display: block;
    }

    .filter-card {
        max-width: 500px;
        margin: 2rem auto;
        max-height: calc(100vh - 4rem);
        overflow-y: auto;
    }
}

@media (max-width: 768px) {
    .courses-page {
        padding: 1rem 0;
    }

    .courses-hero h1 {
        font-size: 2rem;
    }

    .courses-grid {
        grid-template-columns: 1fr;
    }
}
</style>
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
});
</script>
@endpush