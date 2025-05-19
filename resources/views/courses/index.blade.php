@extends('layouts.app', ['title' => 'Cursos - EduCreativo'])

@section('content')
<div class="courses-page notebook-bg">
    <div class="container">
        <div class="courses-header">
            <h1>Explora Nuestros Cursos</h1>
            <p>Descubre cursos de los lenguajes de programación más populares y comienza tu viaje de aprendizaje.</p>
        </div>

        <div class="courses-container">
            <!-- Filtros y Buscador -->
            <div class="filters-sidebar">
                <div class="filter-card">
                    <h3>Filtros</h3>
                    <form action="{{ route('courses.index') }}" method="GET" id="filter-form">
                        <!-- Buscador -->
                        <div class="filter-group">
                            <label for="search">Buscar</label>
                            <div class="search-input">
                                <input type="text" id="search" name="search" value="{{ $search }}" placeholder="Buscar cursos...">
                                <button type="submit" class="search-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
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

                        <!-- Filtro por Precio -->
                        <div class="filter-group">
                            <label>Precio</label>
                            <div class="price-inputs">
                                <input type="number" name="min_price" placeholder="Min" value="{{ $minPrice }}" min="0">
                                <span>-</span>
                                <input type="number" name="max_price" placeholder="Max" value="{{ $maxPrice }}" min="0">
                            </div>
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
                            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                            <a href="{{ route('courses.index') }}" class="btn btn-outline">Limpiar Filtros</a>
                        </div>
                    </form>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="4" y1="21" x2="4" y2="14"></line>
                                <line x1="4" y1="10" x2="4" y2="3"></line>
                                <line x1="12" y1="21" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12" y2="3"></line>
                                <line x1="20" y1="21" x2="20" y2="16"></line>
                                <line x1="20" y1="12" x2="20" y2="3"></line>
                                <line x1="1" y1="14" x2="7" y2="14"></line>
                                <line x1="9" y1="8" x2="15" y2="8"></line>
                                <line x1="17" y1="16" x2="23" y2="16"></line>
                            </svg>
                            Filtros
                        </button>
                    </div>
                </div>

                @if($courses->isEmpty())
                    <div class="no-courses">
                        <div class="postit-note yellow-note">
                            <h3>No se encontraron cursos</h3>
                            <p>Intenta con otros filtros o términos de búsqueda.</p>
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
                                        <span class="course-category">{{ $course->category->name ?? 'Sin categoría' }}</span>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar filtros en móvil
        const showFiltersBtn = document.getElementById('show-filters');
        const filtersSidebar = document.querySelector('.filters-sidebar');
        
        if (showFiltersBtn && filtersSidebar) {
            showFiltersBtn.addEventListener('click', function() {
                filtersSidebar.classList.toggle('show-mobile');
            });
        }
        
        // Aplicar filtros automáticamente al cambiar selects
        const filterSelects = document.querySelectorAll('.filter-select');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                document.getElementById('filter-form').submit();
            });
        });
    });
</script>
@endsection