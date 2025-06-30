<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST["codigo"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $categoria = $_POST["categoria"];
    $moneda = $_POST["moneda"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];

    // Subir portada
    $portada = "";
    if (isset($_FILES["portada"]["name"]) && $_FILES["portada"]["error"] == 0) {
        $archivo = $_FILES["portada"]["name"];
        $ruta_destino = "imagenes/" . time() . "_" . $archivo;
        move_uploaded_file($_FILES["portada"]["tmp_name"], $ruta_destino);
        $portada = $ruta_destino;
    }

    $sql = "INSERT INTO paquetes (codigo, nombre, descripcion, categoria, moneda, precio, stock, portada)
            VALUES ('$codigo', '$nombre', '$descripcion', '$categoria', '$moneda', '$precio', '$stock', '$portada')";

    if ($conexion->query($sql) === TRUE) {
        header("Location: jefe_ventas.php");
        exit;
    } else {
        echo "Error al guardar: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Agregar Paquete</h2>
<form action="agregar_paquete.php" method="POST" enctype="multipart/form-data">
  <input type="text" name="codigo" placeholder="Código" required><br>
  <input type="text" name="nombre" placeholder="Nombre" required><br>
  <textarea name="descripcion" placeholder="Descripción" required></textarea><br>
  <input type="text" name="categoria" placeholder="Categoría" required><br>
  <input type="text" name="moneda" placeholder="Moneda (USD, ARS...)" required><br>
  <input type="number" step="0.01" name="precio" placeholder="Precio" required><br>
  <input type="number" name="stock" placeholder="Stock" required><br>
  <input type="file" name="portada" accept="image/*" required><br><br>
  <button type="submit">Guardar</button>

  
</form>
</body>
</html>