<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    die("No has iniciado sesión");
}

$usuario_id = $_SESSION['usuario_id'];
$paquete_id = $_POST['paquete_id'];
$numero_pedido = rand(10000, 99999); // Número aleatorio (podés hacerlo más robusto)

$sql = "INSERT INTO reservas (usuario_id, paquete_id, numero_pedido)
        VALUES ($usuario_id, $paquete_id, $numero_pedido)";

if ($conexion->query($sql)) {
    echo "<script>alert('Compra registrada con número de pedido $numero_pedido'); window.location.href='cliente_inicio.php';</script>";
} else {
    echo "Error al registrar la compra: " . $conexion->error;
}
$total = $paquete['precio']; // ya se obtiene el precio
echo "El total a pagar es: $" . number_format($total, 2);
// Aquí podrías redirigir a una pasarela real en el futuro

?>
