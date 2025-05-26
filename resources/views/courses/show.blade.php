@extends('layouts.app', ['title' => $course->title . ' - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="course-detail-page notebook-bg">
            <div class="container">
                <!-- Breadcrumbs -->
                <div class="breadcrumbs">
                    <a href="{{ route('home') }}">Inicio</a>
                    <span class="separator">/</span>
                    <a href="{{ route('courses.index') }}">Cursos</a>
                    <span class="separator">/</span>
                    <span class="current">{{ $course->title }}</span>
                </div>

                <!-- Curso Header -->
                <div class="course-header">
                    <div class="course-header-content">
                        <div class="course-info">
                            <div class="course-badges">
                                @if($course->language)
                                    <span class="badge badge-language">{{ $course->language }}</span>
                                @endif
                                <span class="badge badge-level">{{ $course->level }}</span>
                                @if($course->category)
                                    <span class="badge badge-category">{{ $course->category->name }}</span>
                                @endif
                            </div>
                            <h1>{{ $course->title }}</h1>
                            <p class="course-tagline">{{ Str::limit($course->description, 120) }}</p>
                            
                            <div class="course-meta">
                                <div class="meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="meta-icon">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                    <span>Creado por <strong>{{ optional($course->instructor)->name ?? 'Profesor' }}</strong></span>
                                </div>
                                <div class="meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="meta-icon">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span>Última actualización: <strong>{{ $course->updated_at->format('d/m/Y') }}</strong></span>
                                </div>
                                <div class="meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="meta-icon">
                                        <path d="M23 12a11 11 0 1 1-22 0 11 11 0 0 1 22 0z"></path>
                                        <path d="M12 6v6l4 2"></path>
                                    </svg>
                                    <span><strong>{{ rand(10, 30) }}</strong> horas de contenido</span>
                                </div>
                            </div>
                        </div>
                        <div class="course-image-container">
                            <div class="course-image">
                                <img src="{{ $course->image ? asset($course->image) : asset('images/course1.png') }}" alt="{{ $course->title }}">
                                <div class="pushpin red-pin"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido Principal -->
                <div class="course-content-container">
                    <div class="course-main-content">
                        <!-- Descripción del Curso -->
                        <div class="content-section">
                            <div class="postit-note blue-note">
                                <h2>Descripción del Curso</h2>
                                <div class="course-description">
                                    <p>{{ $course->description }}</p>
                                    <p>Este curso está diseñado para ayudarte a dominar {{ $course->language ?? 'este tema' }} de manera efectiva. Aprenderás desde los conceptos básicos hasta técnicas avanzadas que te permitirán desarrollar proyectos reales.</p>
                                    <p>El contenido está estructurado de manera progresiva, permitiéndote construir sobre lo aprendido en cada lección. Incluye ejercicios prácticos, proyectos y evaluaciones para reforzar tu aprendizaje.</p>
                                </div>
                                <div class="note-corner"></div>
                            </div>
                        </div>

                        <!-- Lo que aprenderás -->
                        <div class="content-section">
                            <div class="postit-note yellow-note">
                                <h2>Lo que aprenderás</h2>
                                <div class="learning-objectives">
                                    <ul>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <span>Dominar los fundamentos de {{ $course->language ?? 'la materia' }}</span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <span>Crear proyectos prácticos desde cero</span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <span>Implementar buenas prácticas y patrones de diseño</span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <span>Resolver problemas comunes en el desarrollo</span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <span>Optimizar el rendimiento de tus aplicaciones</span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <span>Prepararte para entrevistas técnicas</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="note-corner"></div>
                            </div>
                        </div>

                        <!-- Contenido del Curso -->
                        <div class="content-section">
                            <div class="postit-note green-note">
                                <h2>Contenido del Curso</h2>
                                <div class="course-curriculum">
                                    <div class="curriculum-section">
                                        <div class="section-header" data-toggle="section-1">
                                            <h3>Módulo 1: Introducción a {{ $course->language ?? 'la materia' }}</h3>
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="section-content" id="section-1">
                                            <ul>
                                                <li>
                                                    <div class="lesson-info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <polygon points="10 8 16 12 10 16 10 8"></polygon>
                                                        </svg>
                                                        <span>Lección 1: Configuración del entorno</span>
                                                    </div>
                                                    <span class="lesson-duration">15:30</span>
                                                </li>
                                                <li>
                                                    <div class="lesson-info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <polygon points="10 8 16 12 10 16 10 8"></polygon>
                                                        </svg>
                                                        <span>Lección 2: Conceptos básicos</span>
                                                    </div>
                                                    <span class="lesson-duration">22:45</span>
                                                </li>
                                                <li>
                                                    <div class="lesson-info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                            <polyline points="14 2 14 8 20 8"></polyline>
                                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                                            <polyline points="10 9 9 9 8 9"></polyline>
                                                        </svg>
                                                        <span>Ejercicio: Primer proyecto</span>
                                                    </div>
                                                    <span class="lesson-duration">10:00</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="curriculum-section">
                                        <div class="section-header" data-toggle="section-2">
                                            <h3>Módulo 2: Fundamentos Avanzados</h3>
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="section-content" id="section-2">
                                            <ul>
                                                <li>
                                                    <div class="lesson-info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <polygon points="10 8 16 12 10 16 10 8"></polygon>
                                                        </svg>
                                                        <span>Lección 3: Estructuras de datos</span>
                                                    </div>
                                                    <span class="lesson-duration">28:15</span>
                                                </li>
                                                <li>
                                                    <div class="lesson-info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <polygon points="10 8 16 12 10 16 10 8"></polygon>
                                                        </svg>
                                                        <span>Lección 4: Algoritmos</span>
                                                    </div>
                                                    <span class="lesson-duration">32:20</span>
                                                </li>
                                                <li>
                                                    <div class="lesson-info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                            <polyline points="14 2 14 8 20 8"></polyline>
                                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                                            <polyline points="10 9 9 9 8 9"></polyline>
                                                        </svg>
                                                        <span>Ejercicio: Implementación práctica</span>
                                                    </div>
                                                    <span class="lesson-duration">15:45</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="curriculum-section">
                                        <div class="section-header" data-toggle="section-3">
                                            <h3>Módulo 3: Proyecto Final</h3>
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="section-content" id="section-3">
                                            <ul>
                                                <li>
                                                    <div class="lesson-info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <polygon points="10 8 16 12 10 16 10 8"></polygon>
                                                        </svg>
                                                        <span>Lección 5: Planificación del proyecto</span>
                                                    </div>
                                                    <span class="lesson-duration">20:10</span>
                                                </li>
                                                <li>
                                                    <div class="lesson-info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <polygon points="10 8 16 12 10 16 10 8"></polygon>
                                                        </svg>
                                                        <span>Lección 6: Implementación</span>
                                                    </div>
                                                    <span class="lesson-duration">45:30</span>
                                                </li>
                                                <li>
                                                    <div class="lesson-info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                            <polyline points="14 2 14 8 20 8"></polyline>
                                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                                            <polyline points="10 9 9 9 8 9"></polyline>
                                                        </svg>
                                                        <span>Proyecto Final: Entrega y evaluación</span>
                                                    </div>
                                                    <span class="lesson-duration">30:00</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="note-corner"></div>
                            </div>
                        </div>

                        <!-- Requisitos -->
                        <div class="content-section">
                            <div class="postit-note pink-note">
                                <h2>Requisitos</h2>
                                <div class="requirements">
                                    <ul>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                            </svg>
                                            <span>Conocimientos básicos de programación</span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                            </svg>
                                            <span>Computadora con sistema operativo Windows, macOS o Linux</span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                            </svg>
                                            <span>Conexión a Internet para descargar las herramientas necesarias</span>
                                        </li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                            </svg>
                                            <span>Ganas de aprender y practicar</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="note-corner"></div>
                            </div>
                        </div>

                        <!-- Instructor -->
                        <div class="content-section">
                            <div class="postit-note purple-note">
                                <h2>Sobre el Instructor</h2>
                                <div class="instructor-info">
                                    <div class="instructor-header">
                                        <div class="instructor-avatar">
                                            <img src="{{ asset('images/teacher-avatar.png') }}" alt="{{ optional($course->instructor)->name ?? 'Profesor' }}">
                                        </div>
                                        <div class="instructor-details">
                                            <h3>{{ optional($course->instructor)->name ?? 'Profesor' }}</h3>
                                            <p>Experto en {{ $course->language ?? 'Desarrollo' }}</p>
                                        </div>
                                    </div>
                                    <div class="instructor-bio">
                                        <p>Instructor con más de 10 años de experiencia en el campo. Ha trabajado en proyectos para empresas de renombre y ha ayudado a miles de estudiantes a alcanzar sus metas profesionales.</p>
                                        <p>Su enfoque práctico y su capacidad para explicar conceptos complejos de manera sencilla lo convierten en uno de los instructores mejor valorados de la plataforma.</p>
                                    </div>
                                </div>
                                <div class="note-corner"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="course-sidebar">
                        <div class="course-card">
                            <div class="course-price-box">
                                <div class="course-price">{{ number_format($course->price, 2) }} €</div>
                                @if($course->discount_price)
                                    <div class="course-discount">
                                        <span class="original-price">{{ number_format($course->price, 2) }} €</span>
                                        <span class="discount-percentage">{{ round((($course->price - $course->discount_price) / $course->price) * 100) }}% dto.</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="course-actions">
                                @auth
                                    @if(auth()->user()->getRemainingCourses() > 0)
                                        <form action="{{ route('courses.obtain', $course->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Obtener curso</button>
                                        </form>
                                        <p class="mt-2">Cursos restantes: {{ auth()->user()->getRemainingCourses() }}</p>
                                    @else
                                        <p class="text-danger">No tienes cursos disponibles para obtener.</p>
                                    @endif
                                    @if(!auth()->user()->courses()->where('course_id', $course->id)->exists())
                                        @if(session('success') && session('success') === 'Curso añadido al carrito')
                                            <div class="mb-2 text-green-600 text-sm">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        @if(auth()->user()->cartItems()->where('course_id', $course->id)->exists())
                                            <button disabled class="btn btn-secondary btn-block cursor-not-allowed">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                    <circle cx="9" cy="21" r="1"></circle>
                                                    <circle cx="20" cy="21" r="1"></circle>
                                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                                </svg>
                                                Ya está en el carrito
                                            </button>
                                        @else
                                            <form action="{{ route('cart.add', $course) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                        <circle cx="9" cy="21" r="1"></circle>
                                                        <circle cx="20" cy="21" r="1"></circle>
                                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                                    </svg>
                                                    Añadir al Carrito
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <button disabled class="btn btn-secondary btn-block cursor-not-allowed">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                            </svg>
                                            Ya tienes este curso
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                            <polyline points="10 17 15 12 10 7"></polyline>
                                            <line x1="15" y1="12" x2="3" y2="12"></line>
                                        </svg>
                                        Inicia sesión para comprar
                                    </a>
                                @endauth
                                @auth
                                    @if(auth()->user()->favorites()->where('course_id', $course->id)->exists())
                                        <form action="{{ route('courses.removeFromFavorites', $course->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline btn-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                                </svg>
                                                Quitar de Favoritos
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('courses.addToFavorites', $course->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline btn-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                                </svg>
                                                Añadir a Favoritos
                                            </button>
                                        </form>
                                    @endif
                                    @if(session('success') && (session('success') === 'Curso añadido a favoritos' || session('success') === 'Curso eliminado de favoritos'))
                                        <div class="mt-2 text-green-600 text-sm">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                @endauth
                            </div>
                            
                            <div class="course-includes">
                                <h3>Este curso incluye:</h3>
                                <ul>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M23 12a11 11 0 1 1-22 0 11 11 0 0 1 22 0z"></path>
                                            <path d="M12 6v6l4 2"></path>
                                        </svg>
                                        <span>{{ rand(10, 30) }} horas de vídeo bajo demanda</span>
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                        <span>{{ rand(5, 15) }} artículos y recursos</span>
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                        </svg>
                                        <span>Acceso a foro de preguntas</span>
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span>{{ rand(3, 8) }} ejercicios prácticos</span>
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                        </svg>
                                        <span>Certificado de finalización</span>
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        </svg>
                                        <span>Acceso de por vida</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="course-guarantee">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 8v4l3 3"></path>
                                </svg>
                                <p>Garantía de devolución de 30 días</p>
                            </div>
                        </div>
                        
                        <!-- Cursos Relacionados -->
                        <div class="related-courses">
                            <h3>Cursos Relacionados</h3>
                            @if(isset($relatedCourses) && count($relatedCourses) > 0)
                                @foreach($relatedCourses as $relatedCourse)
                                    <div class="related-course-item">
                                        <div class="related-course-image">
                                            <img src="{{ $relatedCourse->image ? asset($relatedCourse->image) : asset('images/course'.($loop->index % 3 + 1).'.png') }}" alt="{{ $relatedCourse->title }}">
                                        </div>
                                        <div class="related-course-info">
                                            <h4>{{ Str::limit($relatedCourse->title, 40) }}</h4>
                                            <div class="related-course-meta">
                                                <span class="related-course-language">{{ $relatedCourse->language ?? 'General' }}</span>
                                                <span class="related-course-price">{{ number_format($relatedCourse->price, 2) }} €</span>
                                            </div>
                                            <a href="{{ route('courses.show', $relatedCourse) }}" class="btn btn-sm btn-outline">Ver Curso</a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No hay cursos relacionados disponibles.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Expandir/colapsar secciones del curriculum
        const sectionHeaders = document.querySelectorAll('.section-header');
        
        sectionHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const sectionId = this.getAttribute('data-toggle');
                const sectionContent = document.getElementById(sectionId);
                const toggleIcon = this.querySelector('.toggle-icon');
                
                if (sectionContent.style.display === 'none' || !sectionContent.style.display) {
                    sectionContent.style.display = 'block';
                    toggleIcon.textContent = '-';
                } else {
                    sectionContent.style.display = 'none';
                    toggleIcon.textContent = '+';
                }
            });
        });
        
        // Inicialmente ocultar todas las secciones excepto la primera
        const sectionContents = document.querySelectorAll('.section-content');
        sectionContents.forEach((section, index) => {
            if (index !== 0) {
                section.style.display = 'none';
            }
        });
        
        // Actualizar los iconos de toggle
        const toggleIcons = document.querySelectorAll('.toggle-icon');
        toggleIcons[0].textContent = '-';
    });
</script>
@endsection