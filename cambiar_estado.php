<?php
include 'conexion.php';

if (isset($_POST['id']) && isset($_POST['estado'])) {
    $id = intval($_POST['id']);
    $estado = $_POST['estado'];

    $conn->query("UPDATE reservas SET estado = '$estado' WHERE id = $id");
}

header("Location: ver_reservas.php");
exit();
