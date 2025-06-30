<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Login jefe manual
    if ($email === "viajaconmigo@gmail.com" && $password === "jefe123") {
        session_start();
        $_SESSION['rol'] = "jefe";
        header("Location: jefe_venta_firebase.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $usuario = $res->fetch_assoc();
        if (password_verify($password, $usuario['password'])) {
            session_start();
            $_SESSION['usuario'] = $usuario;
            header("Location: cliente_firebase.php");
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
}
?>
