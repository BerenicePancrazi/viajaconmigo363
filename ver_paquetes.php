<?php
include("conexion.php");

// Traer todos los paquetes
$sql = "SELECT * FROM paquetes";
$resultado = mysqli_query($conexio, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Paquetes disponibles</title>
  <style>
    table { width: 80%; margin: auto; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background-color: #f2f2f2; }
    .eliminar { color: red; text-decoration: none; font-weight: bold; }
  </style>
</head>
<body>
  <h2 style="text-align:center;">📦 Paquetes disponibles</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Descripción</th>
      <th>Precio</th>
      <th>Acciones</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
      <tr>
        <td><?= $row['id_paquete'] ?></td>
        <td><?= $row['nombre'] ?></td>
        <td><?= $row['descripcion'] ?></td>
        <td>$<?= $row['precio'] ?></td>
        <td>
          <a class="eliminar" href="eliminar_paquete.php?id=<?= $row['id_paquete'] ?>" onclick="return confirm('¿Estás seguro de que querés eliminar este paquete?')">🗑️ Eliminar</a>
        </td>
      </tr>
    <?php } ?>
  </table>
</body>
</html>
