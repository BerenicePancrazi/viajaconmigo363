<?php
include 'conexion.php';
// Validar permisos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $conexion->real_escape_string($_POST['codigo']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);
    $precio = (float)$_POST['precio'];
    $categoria = $conexion->real_escape_string($_POST['categoria']); // ej: 'vuelo', 'hotel', 'auto'

    $sql = "INSERT INTO productos (codigo, descripcion, precio, categoria) VALUES ('$codigo', '$descripcion', $precio, '$categoria')";
    if ($conexion->query($sql)) {
        echo "Producto agregado con éxito.";
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>

<h2>Agregar Producto</h2>
<form method="POST">
  <label>Código de producto:</label><br>
  <input type="text" name="codigo" required><br>

  <label>Descripción:</label><br>
  <textarea name="descripcion" required></textarea><br>

  <label>Precio unitario:</label><br>
  <input type="number" step="0.01" name="precio" required><br>

  <label>Categoría:</label><br>
  <select name="categoria" required>
    <option value="vuelo">Vuelo</option>
    <option value="hotel">Hotel</option>
    <option value="auto">Alquiler de auto</option>
    <option value="otro">Otro</option>
  </select><br><br>

  <button type="submit">Agregar producto</button>
</form>
