<footer class="main-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="{{ asset('images/logo.png') }}" alt="EduCreativo Logo">
                <h2>PinCode</h2>
                <p>Transformando la educación online con cursos creativos y divertidos.</p>
            </div>
            
            <div class="footer-links">
                <div class="footer-column">
                    <h3>Enlaces</h3>
                    <ul>
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('courses.index') }}">Cursos</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Soporte</h3>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Contacto</a></li>
                        <li><a href="#">Ayuda</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Legal</h3>
                    <ul>
                        <li><a href="#">Términos</a></li>
                        <li><a href="#">Privacidad</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} PinCode. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>