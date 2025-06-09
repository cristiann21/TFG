@extends('layouts.app', ['title' => $course->title . ' - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <div class="flex flex-col">
                    <p class="font-bold mb-2">{{ session('success') }}</p>
                    @if(session('show_enrolled_courses_link'))
                        <p class="mb-2">Puedes acceder a este curso desde tus cursos adquiridos.</p>
                        <a href="{{ route('profile.enrolled-courses') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            Ver Mis Cursos Adquiridos
                        </a>
                    @endif
                </div>
            </div>
        @endif

        @if(session('cart_success'))
            <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                <div class="flex flex-col">
                    <p class="font-bold mb-2">{{ session('cart_success') }}</p>
                    <a href="{{ route('cart.index') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Ver Carrito
                    </a>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
                @if(session('show_subscription_button'))
                    <div class="mt-2">
                        <a href="{{ route('subscriptions.index') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Ver Planes de Suscripción
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <div class="course-detail-page notebook-bg">
            <div class="container">
                <!-- Curso Header -->
                <div class="course-header bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="course-header-content flex flex-col md:flex-row gap-6">
                        <div class="course-info flex-1">
                            <div class="course-badges flex flex-wrap gap-2 mb-4">
                                @if($course->language)
                                    <span class="badge badge-language bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">{{ $course->language }}</span>
                                @endif
                                <span class="badge badge-level bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">{{ $course->level }}</span>
                                @if($course->category)
                                    <span class="badge badge-category bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">{{ $course->category->name }}</span>
                                @endif
                            </div>
                            <h1 class="text-3xl font-bold mb-4">{{ $course->title }}</h1>
                            <p class="course-tagline text-gray-600 mb-6">{{ Str::limit($course->description, 120) }}</p>
                            
                            <div class="course-meta space-y-3">
                                <div class="meta-item flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                    <span>Creado por <strong>{{ optional($course->instructor)->name ?? 'Profesor' }}</strong></span>
                                </div>
                                <div class="meta-item flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span>Última actualización: <strong>{{ $course->updated_at->format('d/m/Y') }}</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="course-image-container flex-shrink-0">
                            <div class="course-image relative">
                                <img src="{{ $course->image ? asset($course->image) : asset('images/course1.png') }}" 
                                     alt="{{ $course->title }}"
                                     class="w-64 h-48 object-cover rounded-lg shadow-md">
                                <div class="pushpin red-pin absolute -top-2 -right-2"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido Principal -->
                <div class="course-content-container">
                    <div class="course-main-content">
                        @if(auth()->check() && (auth()->user()->courses->contains($course) || auth()->user()->id === $course->instructor_id))
                            <!-- Contenido del Curso para Usuarios que lo han Comprado o son el Creador -->
                            <div class="content-section">
                                <div class="postit-note blue-note">
                                    <h2>Contenido del Curso</h2>
                                    @if($course->video_url)
                                        <div class="video-container mb-6">
                                            <iframe 
                                                width="100%" 
                                                height="400" 
                                                src="{{ str_replace(['youtu.be/', 'www.youtube.com/watch?v='], ['youtube.com/embed/', 'youtube.com/embed/'], $course->video_url) }}" 
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    @endif

                                    <!-- Sección de Tests -->
                                    <div class="quiz-section mt-6">
                                        <h3 class="text-xl font-bold mb-4">Tests del Curso</h3>
                                        @php
                                            $quizzes = $course->quizzes;
                                            $hasQuizzes = $quizzes && $quizzes->count() > 0;
                                        @endphp
                                        
                                        @if($hasQuizzes)
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                @foreach($quizzes as $quiz)
                                                    <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                                                        <h4 class="font-semibold text-lg mb-2">{{ $quiz->title }}</h4>
                                                        <p class="text-gray-600 text-sm mb-4">{{ $quiz->description }}</p>
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex items-center text-sm text-gray-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <polyline points="12 6 12 12 16 14"></polyline>
                                                                </svg>
                                                                {{ $quiz->questions->count() }} preguntas
                                                            </div>
                                                            <a href="{{ route('quizzes.show', ['course' => $course->id, 'quiz' => $quiz->id]) }}" 
                                                               class="btn btn-primary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                                    <path d="M12 20h9"></path>
                                                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                                                </svg>
                                                                Realizar Test
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="bg-white rounded-lg p-6 border border-gray-200">
                                                <p class="text-gray-600 mb-4">No hay tests disponibles para este curso.</p>
                                                @if(auth()->check() && auth()->user()->id === $course->instructor_id)
                                                    <a href="{{ route('quizzes.create', $course) }}" class="btn btn-primary">
                                                        <i class="fas fa-plus mr-2"></i>
                                                        Crear Test
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
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
                                </div>
                            </div>

                            <!-- Contenido del Curso -->
                            <div class="content-section">
                                <div class="postit-note green-note">
                                    <h2>Contenido del Curso</h2>
                                    <div class="course-curriculum">
                                        <div class="curriculum-section">
                                            <div class="section-header" data-toggle="section-1">
                                                <h3>Contenido Actual</h3>
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
                                                            <span>Video: Fundamentos del Curso</span>
                                                        </div>
                                                        <span class="lesson-duration">1:30 - 2:00 horas</span>
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
                                                            <span>Test de Evaluación</span>
                                                        </div>
                                                        <span class="lesson-duration">15 minutos</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class="curriculum-section">
                                            <div class="section-header" data-toggle="section-2">
                                                <h3>Próximamente</h3>
                                                <span class="toggle-icon">+</span>
                                            </div>
                                            <div class="section-content" id="section-2">
                                                <div class="coming-soon-message">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <path d="M12 6v6l4 2"></path>
                                                    </svg>
                                                    <p>¡Próximamente se añadirán más videos y cursos para seguir aprendiendo!</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                </div>
                            </div>

                            <!-- Instructor -->
                            <div class="content-section">
                                <div class="postit-note purple-note">
                                    <h2>Sobre el Instructor</h2>
                                    <div class="instructor-info">
                                        <div class="instructor-header">
                                            <div class="instructor-avatar">
                                                @if($course->instructor && $course->instructor->avatar)
                                                    <img src="{{ asset($course->instructor->avatar) }}" alt="{{ $course->instructor->name }}">
                                                @else
                                                    <div class="no-avatar">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="instructor-details">
                                                <h3>{{ $course->instructor->name ?? 'Profesor' }}</h3>
                                                <p>Experto en {{ $course->language ?? 'Desarrollo' }}</p>
                                            </div>
                                        </div>
                                        <div class="instructor-bio">
                                            <p>Instructor con más de 10 años de experiencia en el campo. Ha trabajado en proyectos para empresas de renombre y ha ayudado a miles de estudiantes a alcanzar sus metas profesionales.</p>
                                            <p>Su enfoque práctico y su capacidad para explicar conceptos complejos de manera sencilla lo convierten en uno de los instructores mejor valorados de la plataforma.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección de Tests -->
                            @if(auth()->check() && auth()->user()->courses->contains($course))
                                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                                    <h2 class="text-xl font-bold mb-4">Tests Disponibles</h2>
                                    
                                    @if($course->quizzes->count() > 0)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($course->quizzes as $quiz)
                                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                                    <h3 class="font-semibold text-lg mb-2">{{ $quiz->title }}</h3>
                                                    <p class="text-gray-600 text-sm mb-4">{{ $quiz->description }}</p>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center text-sm text-gray-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <polyline points="12 6 12 12 16 14"></polyline>
                                                            </svg>
                                                            {{ $quiz->questions->count() }} preguntas
                                                        </div>
                                                        <a href="{{ route('quizzes.show', ['course' => $course, 'quiz' => $quiz]) }}" class="btn btn-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                                <path d="M12 20h9"></path>
                                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                                            </svg>
                                                            Realizar Test
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    @else
                                        <div class="text-center py-8">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-4 text-gray-400">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                                <polyline points="10 9 9 9 8 9"></polyline>
                                            </svg>
                                            <p class="text-gray-500">No hay tests disponibles para este curso</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endif
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
                                    @if(auth()->user()->id === $course->instructor_id)
                                        <!-- Acciones para el creador del curso -->
                                        <div class="space-y-4">
                                            @if(auth()->user()->favorites()->where('course_id', $course->id)->exists())
                                                <form action="{{ route('courses.favorites.remove', ['course' => $course->id]) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-block">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                                        </svg>
                                                        Quitar de Favoritos
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('courses.favorites.add', ['course' => $course->id]) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-block">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                                        </svg>
                                                        Añadir a Favoritos
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('courses.edit', $course) }}" class="btn btn-outline btn-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                </svg>
                                                Editar Curso
                                            </a>
                                        </div>
                                    @else
                                        <!-- Acciones para otros usuarios -->
                                        @if(auth()->user()->courses()->where('course_id', $course->id)->exists())
                                            <button disabled class="btn btn-secondary btn-block cursor-not-allowed">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                </svg>
                                                Ya tienes este curso
                                            </button>
                                        @elseif(auth()->user()->subscriptions()->where('is_active', true)->first()?->plan_type === 'free')
                                            <div class="text-center">
                                                <p class="text-gray-600 mb-4">¡Suscríbete o compra este curso para acceder a todo su contenido!</p>
                                                <a href="{{ route('subscriptions.index') }}" class="btn btn-primary btn-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                        <circle cx="12" cy="7" r="4"></circle>
                                                    </svg>
                                                    Ver Planes de Suscripción
                                                </a>
                                            </div>
                                        @else
                                            <form action="{{ route('courses.obtain', $course->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Obtener curso</button>
                                            </form>
                                            <p class="mt-2">Cursos restantes: {{ auth()->user()->getRemainingCourses() }}</p>
                                        @endif
                                        @if(!auth()->user()->courses()->where('course_id', $course->id)->exists())
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

                                            <!-- Botón de Añadir a Favoritos -->
                                            @if(auth()->user()->favorites()->where('course_id', $course->id)->exists())
                                                <form action="{{ route('courses.favorites.remove', ['course' => $course->id]) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-block">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                                        </svg>
                                                        Quitar de Favoritos
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('courses.favorites.add', ['course' => $course->id]) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-block">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                                        </svg>
                                                        Añadir a Favoritos
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
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
                            </div>
                            
                            <div class="course-includes">
                                <h3>Este curso incluye:</h3>
                                <ul>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M23 12a11 11 0 1 1-22 0 11 11 0 0 1 22 0z"></path>
                                            <path d="M12 6v6l4 2"></path>
                                        </svg>
                                        <span>Videos del contenido</span>
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                        <span>Tests de evaluación</span>
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

@push('styles')
<style>
.instructor-info {
    padding: 1rem;
}

.instructor-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.instructor-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid var(--color-secondary);
}

.instructor-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.instructor-avatar .no-avatar {
    width: 100%;
    height: 100%;
    background-color: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 2.5rem;
}

.instructor-details h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--color-text);
    margin-bottom: 0.5rem;
}

.instructor-details p {
    color: var(--color-text-light);
    font-size: 1rem;
}

.instructor-bio {
    color: var(--color-text);
    line-height: 1.6;
}

.instructor-bio p {
    margin-bottom: 1rem;
}

.instructor-bio p:last-child {
    margin-bottom: 0;
}

.course-description {
    font-family: var(--font-handwritten);
    color: var(--color-text);
    line-height: 1.6;
}

.course-description h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--color-primary);
}

.course-description h4 {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 1.5rem 0 1rem;
    color: var(--color-secondary);
}

.course-description h5 {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 1rem 0;
    color: var(--color-text);
}

.course-description ul {
    list-style-type: none;
    padding-left: 1.5rem;
    margin-bottom: 1rem;
}

.course-description ul li {
    position: relative;
    margin-bottom: 0.5rem;
}

.course-description ul li:before {
    content: "•";
    color: var(--color-secondary);
    font-weight: bold;
    position: absolute;
    left: -1rem;
}

.course-content {
    background: var(--color-background);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin: 1rem 0;
}

.module {
    border: 2px dashed var(--color-border);
    border-radius: var(--border-radius);
    padding: 1rem;
    margin-bottom: 1rem;
}

.lesson {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: white;
    border-radius: var(--border-radius);
    margin: 0.5rem 0;
}

.lesson-title {
    font-weight: 500;
    color: var(--color-text);
}

.lesson-duration {
    color: var(--color-text-light);
    font-size: 0.9rem;
}

.coming-soon-message {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.9);
    border-radius: var(--border-radius);
    margin: 1rem 0;
}

.coming-soon-message svg {
    color: var(--color-secondary);
    flex-shrink: 0;
}

.coming-soon-message p {
    color: var(--color-text);
    font-family: var(--font-handwritten);
    font-size: 1.1rem;
    margin: 0;
}
</style>
@endpush

@if(!auth()->user()->courses->contains($course))
   
@endif
