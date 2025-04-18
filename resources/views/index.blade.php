<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    die("Debes iniciar sesión para acceder a la página de inicio. <a href='Forms/login.php'>Inicia sesión</a>");
}

echo "<h2>Bienvenido, " . $_SESSION['nombre'] . "!</h2>";

// Mostrar los cursos (aquí solo una muestra estática, puedes usar el código de conexión a la base de datos para mostrarlos dinámicamente)
echo "<h3>Lista de Cursos:</h3>";
echo "<ul>";
echo "<li>Curso de Introducción a PHP</li>";
echo "<li>Curso de PHP con MySQL</li>";
echo "<li>Curso de Desarrollo Web Avanzado</li>";
echo "</ul>";
?>
