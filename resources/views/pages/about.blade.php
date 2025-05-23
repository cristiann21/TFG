@extends('layouts.app', ['title' => 'Nosotros - PinCode'])

@section('content')
<div class="about-page">
    <div class="container">
        <div class="about-content">
            <h1>Sobre PinCode</h1>
            <p class="lead">Aprende programación de una manera divertida y efectiva</p>
            
            <div class="about-sections">
                <section class="about-section">
                    <h2>Nuestra Misión</h2>
                    <p>En PinCode, creemos que aprender a programar debe ser accesible, divertido y práctico. Nuestra misión es ayudar a personas de todas las edades a desarrollar habilidades de programación a través de cursos interactivos y proyectos reales.</p>
                </section>

                <section class="about-section">
                    <h2>¿Por qué elegirnos?</h2>
                    <ul>
                        <li>Cursos diseñados por expertos en la industria</li>
                        <li>Metodología práctica y hands-on</li>
                        <li>Proyectos reales para construir tu portafolio</li>
                        <li>Comunidad activa de estudiantes</li>
                        <li>Soporte personalizado</li>
                    </ul>
                </section>

                <section class="about-section">
                    <h2>Nuestro Equipo</h2>
                    <p>Somos un equipo apasionado de educadores, desarrolladores y diseñadores comprometidos con hacer que el aprendizaje de la programación sea una experiencia enriquecedora y divertida.</p>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.about-page {
    padding: 4rem 0;
}

.about-content {
    max-width: 800px;
    margin: 0 auto;
}

.about-content h1 {
    font-family: var(--font-handwritten);
    font-size: 2.5rem;
    color: var(--color-primary);
    text-align: center;
    margin-bottom: 1rem;
}

.about-content .lead {
    font-size: 1.25rem;
    color: var(--color-text-light);
    text-align: center;
    margin-bottom: 3rem;
}

.about-sections {
    display: grid;
    gap: 2rem;
}

.about-section {
    background: white;
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-sm);
}

.about-section h2 {
    font-family: var(--font-handwritten);
    font-size: 1.5rem;
    color: var(--color-primary);
    margin-bottom: 1rem;
}

.about-section p {
    color: var(--color-text);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.about-section ul {
    list-style: none;
    padding: 0;
}

.about-section ul li {
    color: var(--color-text);
    padding: 0.5rem 0;
    padding-left: 1.5rem;
    position: relative;
}

.about-section ul li:before {
    content: "→";
    position: absolute;
    left: 0;
    color: var(--color-primary);
}

@media (max-width: 768px) {
    .about-page {
        padding: 2rem 0;
    }

    .about-content h1 {
        font-size: 2rem;
    }

    .about-section {
        padding: 1.5rem;
    }
}
</style>
@endpush 