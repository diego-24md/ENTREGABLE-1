<?php
// Parámetros de conexión
$servername = "localhost";  // El servidor de la base de datos (en localhost si usas XAMPP)
$username = "root";         // El nombre de usuario (por defecto en XAMPP es 'root')
$password = "";             // La contraseña (por defecto en XAMPP es una cadena vacía)
$dbname = "tienda_ropa_vesta";  // El nombre de la base de datos a la que te vas a conectar

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// echo "Conexión exitosa"; // Esto es opcional para verificar que la conexión funciona correctamente
?>
