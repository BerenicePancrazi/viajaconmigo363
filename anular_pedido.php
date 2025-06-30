<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "UPDATE reservas SET estado = 'cancelada' WHERE id = $id";

    if ($conexion->query($sql)) {
        echo "<script>alert('Pedido anulado exitosamente'); window.location.href = 'pedidos_pendientes.php';</script>";
    } else {
        echo "Error al anular el pedido: " . $conexion->error;
    }
} else {
    echo "ID no especificado.";
}
?>
