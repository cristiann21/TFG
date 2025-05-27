@extends('layouts.app', ['title' => 'Política de Privacidad - PinCode'])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="terms-page">
        <h1>Política de Privacidad</h1>
        <p class="last-updated">Última actualización: {{ date('d/m/Y') }}</p>

        <div class="terms-content">
            <section class="terms-section">
                <h2>1. Información que Recopilamos</h2>
                <p>En PinCode, recopilamos la siguiente información:</p>
                <ul>
                    <li>Información de registro (nombre, correo electrónico, contraseña)</li>
                    <li>Información de perfil (foto, biografía, preferencias)</li>
                    <li>Información de pago (datos de tarjeta de crédito procesados de forma segura)</li>
                    <li>Información de uso (cursos visitados, progreso, calificaciones)</li>
                </ul>
            </section>

            <section class="terms-section">
                <h2>2. Uso de la Información</h2>
                <p>Utilizamos tu información para:</p>
                <ul>
                    <li>Proporcionar y mejorar nuestros servicios</li>
                    <li>Personalizar tu experiencia de aprendizaje</li>
                    <li>Procesar pagos y mantener tu cuenta</li>
                    <li>Enviar actualizaciones y comunicaciones importantes</li>
                </ul>
            </section>

            <section class="terms-section">
                <h2>3. Protección de Datos</h2>
                <p>Nos comprometemos a proteger tu información personal mediante:</p>
                <ul>
                    <li>Encriptación de datos sensibles</li>
                    <li>Acceso restringido a la información personal</li>
                    <li>Monitoreo regular de seguridad</li>
                    <li>Cumplimiento de normativas de protección de datos</li>
                </ul>
            </section>

            <section class="terms-section">
                <h2>4. Cookies y Tecnologías Similares</h2>
                <p>Utilizamos cookies y tecnologías similares para:</p>
                <ul>
                    <li>Mantener tu sesión activa</li>
                    <li>Recordar tus preferencias</li>
                    <li>Analizar el uso del sitio</li>
                    <li>Mejorar nuestros servicios</li>
                </ul>
            </section>

            <section class="terms-section">
                <h2>5. Compartir Información</h2>
                <p>No compartimos tu información personal con terceros excepto:</p>
                <ul>
                    <li>Cuando es necesario para proporcionar nuestros servicios</li>
                    <li>Cuando es requerido por ley</li>
                    <li>Con tu consentimiento explícito</li>
                </ul>
            </section>

            <section class="terms-section">
                <h2>6. Tus Derechos</h2>
                <p>Tienes derecho a:</p>
                <ul>
                    <li>Acceder a tu información personal</li>
                    <li>Corregir datos inexactos</li>
                    <li>Solicitar la eliminación de tus datos</li>
                    <li>Oponerte al procesamiento de tus datos</li>
                </ul>
            </section>

            <section class="terms-section">
                <h2>7. Contacto</h2>
                <p>Si tienes preguntas sobre nuestra política de privacidad, contáctanos a través de nuestro formulario de contacto.</p>
            </section>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/views/privacy.css') }}">
@endpush 