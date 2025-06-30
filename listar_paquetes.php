
<?php
$conexion = new mysqli("localhost", "root", "", "viajes_db");

if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT * FROM paquetes ORDER BY fecha_creacion DESC";
$resultado = $conexion->query($sql);

$paquetes = [];

while ($row = $resultado->fetch_assoc()) {
  $paquetes[] = $row;
}

echo json_encode($paquetes);
$conexion->close();
?>
