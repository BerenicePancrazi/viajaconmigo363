<?php
$host = "localhost"; // o IP del servidor
$user = "root"; // usuario de la base de datos
$pass = ""; // contraseña
$dbname = "viaje_db"; // nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

echo "Conexión exitosa a la base de datos";
?>
