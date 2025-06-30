<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $reserva_id = intval($_GET['id']);

    // Obtener info de la reserva
    $sql = "SELECT * FROM reservas WHERE id = $reserva_id";
    $res = $conexion->query($sql);

    if ($res && $res->num_rows > 0) {
        $reserva = $res->fetch_assoc();

        $usuario_id = $reserva['usuario_id'];
        $paquete_id = $reserva['paquete_id'];
        $numero_pedido = $reserva['numero_pedido'];
        $fecha_reserva = $reserva['fecha_reserva'];

        // Obtener precio desde paquete
        $sql_paquete = "SELECT precio FROM paquetes WHERE id = $paquete_id";
        $resultado_paquete = $conexion->query($sql_paquete);
        $fila_paquete = $resultado_paquete->fetch_assoc();
        $total = $fila_paquete['precio'];

        // Insertar en historial_pedidos
        $sql1 = "INSERT INTO historial_pedidos (usuario_id, paquete_id, numero_pedido, fecha_entrega, total)
                 VALUES ('$usuario_id', '$paquete_id', '$numero_pedido', NOW(), '$total')";

        // Insertar en ventas
        $sql2 = "INSERT INTO ventas (numero_pedido, usuario_id, paquete_id, total)
                 VALUES ('$numero_pedido', '$usuario_id', '$paquete_id', '$total')";

        // Eliminar de reservas
        $sql3 = "DELETE FROM reservas WHERE id = $reserva_id";

        if ($conexion->query($sql1) && $conexion->query($sql2) && $conexion->query($sql3)) {
            echo "<script>alert('Pedido entregado, venta registrada y reserva movida a historial.'); window.location.href='ver_pedidos.php';</script>";
        } else {
            echo "Error al procesar entrega: " . $conexion->error;
        }
    } else {
        echo "Reserva no encontrada.";
    }
} else {
    echo "ID de reserva no proporcionado.";
}
?>
