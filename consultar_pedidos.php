<?php
header('Content-Type: application/json');
require_once 'conexion.php'; // Asegúrate de tener este archivo con conexión mysqli o PDO

$sql = "
SELECT 
    r.id,
    u.nombre AS cliente,
    p.nombre AS paquete,
    p.precio,
    r.fecha_reserva,
    r.estado
FROM reservas r
JOIN usuarios u ON r.usuario_id = u.id
JOIN paquetes p ON r.paquete_id = p.id
ORDER BY r.fecha_reserva DESC
";

$resultado = $conn->query($sql);

$pedidos = [];
while ($row = $resultado->fetch_assoc()) {
    $pedidos[] = $row;
}

echo json_encode($pedidos);
?>
