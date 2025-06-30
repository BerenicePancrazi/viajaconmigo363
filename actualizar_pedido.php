<?php
require_once 'conexion.php'; // Incluye tu conexión a la base de datos
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $input = json_decode(file_get_contents('php://input'), true);

  $id = intval($input['id']);
  $nuevoEstado = $input['estado'];

  // Validación mínima
  if (!$id || !in_array($nuevoEstado, ['pendiente', 'entregado', 'anulado'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
  }

  // Traer datos del pedido original
  $sql = "SELECT * FROM reservas WHERE id = $id";
  $result = $conn->query($sql);

  if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Pedido no encontrado']);
    exit;
  }

  $pedido = $result->fetch_assoc();

  // Actualizar estado
  $conn->query("UPDATE reservas SET estado = '$nuevoEstado' WHERE id = $id");

  // Mover a historial si es entregado
  if ($nuevoEstado === 'entregado') {
    $stmt = $conn->prepare("INSERT INTO pedidos_historial (usuario_id, paquete_id, fecha_reserva, estado) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $pedido['usuario_id'], $pedido['paquete_id'], $pedido['fecha_reserva'], $nuevoEstado);
    $stmt->execute();

    // Eliminar del original
    $conn->query("DELETE FROM reservas WHERE id = $id");
  }

  echo json_encode(['success' => true]);
} else {
  http_response_code(405);
  echo json_encode(['error' => 'Método no permitido']);
}
?>
