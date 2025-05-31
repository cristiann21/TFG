@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@section('content')
   
    @push('styles')
    <style>
    .html-practice-btn-section {
        width: 100vw;
        background: #e3f6e3;
        padding: 60px 0 0 0;
        display: flex;
        justify-content: center;
    }
    .html-practice-btn-container {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .postit-btn {
        display: block;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        padding: 32px 0;
        background:rgb(252, 217, 255);
        color: #222;
        font-size: 2rem;
        font-weight: bold;
        border: none;
        border-radius: 30px;
        box-shadow: 2px 6px 18px #0002, 0 2px 0 rgb(208, 122, 230);
        cursor: pointer;
        transition: transform 0.1s, box-shadow 0.1s;
        text-align: center;
        margin-top: 16px;
        margin-bottom: 32px;
        letter-spacing: 1px;
    }
    .postit-btn:hover {
        transform: scale(1.04) rotate(-2deg);
        box-shadow: 4px 12px 24px #0003, 0 4px 0rgb(217, 122, 230);
        background:rgb(253, 196, 255);
    }
    </style>
    @endpush
    <!-- Hero Section - Paper Style -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h2>Aprende a tu ritmo con nuestros cursos</h2>
                    <p>Descubre una nueva forma de aprender con nuestros cursos diseñados para inspirar tu creatividad.</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary">Explorar Cursos</a>
                </div>
                <div class="hero-image">
                    <div class="image-container">
                        <img src="{{ asset('images/apre.jpg') }}" alt="Estudiantes aprendiendo">
                        <div class="pushpin red-pin"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="paper-edge"></div>
    </section>

    <!-- Featured Courses - Post-it Style -->
    <section id="courses" class="courses">
        <div class="container">
            <div class="section-heading">
                <h2>Nuestros Cursos Destacados</h2>
            </div>
            
            <div class="courses-grid">
                @foreach($featuredCourses as $course)
                    <div class="course-card {{ ['yellow-note', 'blue-note', 'green-note'][($loop->index % 3)] }}">
                        <div class="course-image">
                            <img src="{{ $course->image ? asset($course->image) : asset('images/course'.($loop->index+1).'.png') }}" alt="{{ $course->title }}">
                            <span class="course-category {{ ['yellow-category', 'blue-category', 'green-category'][($loop->index % 3)] }}">
                                {{ ['Diseño', 'Programación', 'Marketing'][($loop->index % 3)] }}
                            </span>
                        </div>
                        <div class="course-content">
                            <h3>{{ $course->title }}</h3>
                            <p>{{ Str::limit($course->description, 100) }}</p>
                            <div class="course-footer">
                                <span class="lessons-count">{{ rand(8, 15) }} lecciones</span>
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-sm {{ ['btn-yellow', 'btn-blue', 'btn-green'][($loop->index % 3)] }}">Ver Curso</a>
                            </div>
                        </div>
                        <div class="note-corner"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="stats grid-bg">
        <div class="html-practice-btn-container">
            <button class="postit-btn" onclick="window.location.href='{{ url('/practica-html') }}'">Practica HTML</button>
        </div>
    </section>
    
    <!-- Features Section - Post-it Style -->
    <section class="features cork-bg">
        <div class="container">
            <div class="section-heading">
                <h2>¿Por qué elegirnos?</h2>
            </div>

            <div class="features-grid"> 
                <div class="postit-note yellow-note">
                    <div class="feature-icon">
                    <i class="fa-solid fa-graduation-cap font-size-30"></i>
                    </div>
                    <h3>Aprendizaje Flexible</h3>
                    <p>Estudia a tu propio ritmo y desde cualquier lugar.</p>
                </div>

                <div class="postit-note blue-note">
                    <div class="feature-icon">
                    <i class="fa-solid fa-keyboard fa-size-40"></i>
                    </div>
                    <h3>Proyectos Prácticos</h3>
                    <p>Aprende haciendo con proyectos del mundo real.</p>
                </div>

                <div class="postit-note green-note">
                    <div class="feature-icon">
                    <i class="fa-solid fa-user-group"></i>
                    </div>
                    <h3>Comunidad Activa</h3>
                    <p>Conecta con otros estudiantes y profesores.</p>
                </div>

                <div class="postit-note pink-note">
                    <div class="feature-icon">
                    <i class="fa-solid fa-handshake-angle"></i>
                    </div>
                    <h3>Soporte Personalizado</h3>
                    <p>Recibe ayuda personalizada para superar tus desafíos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials - Post-it Style -->
    <section class="testimonials cork-bg">
        <div class="container">
            <div class="section-heading">
                <h2>Lo que dicen nuestros estudiantes</h2>
            </div>

            <div class="testimonials-grid">
                <div class="postit-note pink-note">
                    <div class="testimonial-header">
                        <div class="testimonial-image">
                            <img src="{{ asset('images/students/maria.png') }}" alt="Estudiante">
                        </div>
                        <div class="testimonial-info">
                            <h3>María García</h3>
                            <p>Estudiante de Diseño Gráfico</p>
                        </div>
                    </div>
                    <p class="testimonial-text">
                        "Los cursos son increíbles. He aprendido más en un mes que en todo un año de universidad. La metodología es muy práctica y los profesores están siempre disponibles."
                    </p>
                </div>

                <div class="postit-note purple-note">
                    <div class="testimonial-header">
                        <div class="testimonial-image">
                            <img src="{{ asset('images/students/carlos.png') }}" alt="Estudiante">
                        </div>
                        <div class="testimonial-info">
                            <h3>Carlos Rodríguez</h3>
                            <p>Estudiante de Programación</p>
                        </div>
                    </div>
                    <p class="testimonial-text">
                        "Gracias a estos cursos pude cambiar de carrera y conseguir mi primer trabajo como desarrollador. El contenido es actual y relevante para la industria."
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter - Post-it Style -->
    <section class="newsletter">
        <div class="container">
            <div class="postit-note orange-note newsletter-container">
                <h3>Suscríbete a nuestro boletín</h3>
                <p>Recibe información sobre nuevos cursos y consejos de aprendizaje.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Tu correo electrónico" required>
                    <button type="submit" class="btn btn-orange">Suscribirse</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Stats Section - Educational Style -->
    <section class="stats grid-bg">
        <div class="container">
            <div class="section-heading">
                <h2>Nuestros Números</h2>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">50+</div>
                    <p>Cursos Disponibles</p>
                </div>
                <div class="stat-card">
                    <div class="stat-number">10,000+</div>
                    <p>Estudiantes Activos</p>
                </div>
                <div class="stat-card">
                    <div class="stat-number">95%</div>
                    <p>Tasa de Satisfacción</p>
                </div>
                <div class="stat-card">
                    <div class="stat-number">24/7</div>
                    <p>Soporte al Estudiante</p>
                </div>
            </div>
        </div>
    </section>
@endsection