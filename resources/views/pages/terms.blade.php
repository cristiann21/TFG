@extends('layouts.app', ['title' => 'Términos y Condiciones - PinCode'])

@section('content')
<div class="container">
    <div class="terms-page">
        <h1>Términos y Condiciones</h1>
        <p class="last-updated">Última actualización: {{ now()->format('d/m/Y') }}</p>

        <div class="terms-content">
            <section class="terms-section">
                <h2>1. Aceptación de los Términos</h2>
                <p>Al registrarte y utilizar PinCode, aceptas estar sujeto a estos términos y condiciones. Si no estás de acuerdo con alguna parte de estos términos, no podrás acceder a nuestros servicios.</p>
            </section>

            <section class="terms-section">
                <h2>2. Cuenta de Usuario</h2>
                <ul>
                    <li>Debes proporcionar información precisa y completa al registrarte.</li>
                    <li>Eres responsable de mantener la confidencialidad de tu cuenta y contraseña.</li>
                    <li>Debes notificarnos inmediatamente sobre cualquier uso no autorizado de tu cuenta.</li>
                    <li>Nos reservamos el derecho de suspender o terminar cuentas que violen estos términos.</li>
                </ul>
            </section>

            <section class="terms-section">
                <h2>3. Uso del Servicio</h2>
                <ul>
                    <li>El acceso a los cursos está sujeto a la compra o suscripción correspondiente.</li>
                    <li>El contenido de los cursos es para uso personal y educativo.</li>
                    <li>No está permitido compartir, distribuir o revender el contenido de los cursos.</li>
                    <li>Nos reservamos el derecho de modificar o descontinuar cualquier curso o servicio.</li>
                </ul>
            </section>

            <section class="terms-section">
                <h2>4. Propiedad Intelectual</h2>
                <ul>
                    <li>Todos los derechos de propiedad intelectual del contenido de los cursos pertenecen a PinCode o a sus respectivos propietarios.</li>
                    <li>No está permitido copiar, modificar, distribuir o crear trabajos derivados del contenido.</li>
                    <li>Los materiales proporcionados son para uso personal y educativo únicamente.</li>
                </ul>
            </section>

            <section class="terms-section">
                <h2>5. Privacidad</h2>
                <p>Tu privacidad es importante para nosotros. Nuestra política de privacidad describe cómo recopilamos, usamos y protegemos tu información personal.</p>
            </section>

            <section class="terms-section">
                <h2>6. Modificaciones</h2>
                <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Las modificaciones entrarán en vigor inmediatamente después de su publicación en el sitio.</p>
            </section>

            <section class="terms-section">
                <h2>7. Contacto</h2>
                <p>Si tienes alguna pregunta sobre estos términos, por favor contáctanos a través de nuestro formulario de contacto.</p>
            </section>
        </div>
    </div>
</div>

@push('styles')
<style>
.terms-page {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.terms-page h1 {
    color: var(--color-text);
    text-align: center;
    margin-bottom: 0.5rem;
    font-size: 2rem;
}

.last-updated {
    text-align: center;
    color: var(--color-text-light);
    font-size: 0.9rem;
    margin-bottom: 2rem;
}

.terms-content {
    color: var(--color-text);
}

.terms-section {
    margin-bottom: 2rem;
}

.terms-section h2 {
    color: var(--color-text);
    font-size: 1.25rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--color-border);
}

.terms-section p {
    line-height: 1.6;
    margin-bottom: 1rem;
}

.terms-section ul {
    list-style-type: disc;
    margin-left: 1.5rem;
    margin-bottom: 1rem;
}

.terms-section li {
    line-height: 1.6;
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .terms-page {
        margin: 1rem;
        padding: 1.5rem;
    }

    .terms-page h1 {
        font-size: 1.75rem;
    }

    .terms-section h2 {
        font-size: 1.1rem;
    }
}
</style>
@endpush
@endsection 