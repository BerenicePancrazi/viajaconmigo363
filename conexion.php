<?php
$servidor = "localhost"; // También puedes probar con "127.0.0.1"
$usuario = "root"; 
$contrasena = ""; // Déjalo vacío si no tienes contraseña
$base_datos = "viaje_db"; // Asegúrate de que la base de datos exista en phpMyAdmin

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
} else {
    echo "✅ Conexión exitosa a la base de datos.";
}
?>
