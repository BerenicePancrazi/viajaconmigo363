<?php
include 'conexion.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=clientes.xls");

$sql = "SELECT id, nombre, email, fecha_registro FROM usuarios WHERE rol = 'cliente'";
$resultado = mysqli_query($conexion, $sql);

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Fecha de Registro</th></tr>";
while ($row = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>{$row['id']}</td><td>{$row['nombre']}</td><td>{$row['email']}</td><td>{$row['fecha_registro']}</td>";
    echo "</tr>";
}
echo "</table>";
?>
