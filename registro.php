<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $verificar = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $verificar->bind_param("s", $email);
    $verificar->execute();
    $resultado = $verificar->get_result();

    if ($resultado->num_rows > 0) {
        echo "Correo ya registrado";
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'cliente')");
        $stmt->bind_param("sss", $nombre, $email, $password);
        if ($stmt->execute()) {
            echo "Registro exitoso";
        } else {
            echo "Error al registrar";
        }
    }
}
?>
