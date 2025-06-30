<?php
include 'conexion.php'; // conecta y crea $conexion

// 1. Si se recibe ID para eliminar
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql_delete = "DELETE FROM paquetes WHERE id = $id";
    if (mysqli_query($conexion, $sql_delete)) {
        header("Location: eliminar_paquete.php?mensaje=paquete_eliminado");
        exit;
    } else {
        echo "Error al eliminar paquete: " . mysqli_error($conexion);
    }
}

// 2. Mostrar mensaje si viene
if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'paquete_eliminado') {
    $mensaje = "<div class='notification'><div class='notification-content'><h4>¡Éxito!</h4><p>Paquete eliminado con éxito.</p></div></div>";
} else {
    $mensaje = "";
}

// 3. Consulta para mostrar todos los paquetes
$sql = "SELECT * FROM paquetes";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Listado de Paquetes</title>
  <style>
    /* TODO: Copia aquí todo el CSS que me diste */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body { 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #8f6aca 0%, #764ba2 100%);
      min-height: 100vh;
      color: #2d3748;
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 20px;
      background: rgba(255,255,255,0.95);
      border-radius: 15px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    }

    h2 {
      color: #2d3748;
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 30px;
      text-align: center;
    }

    .notification {
      background: linear-gradient(45deg, #48bb78, #38a169);
      color: white;
      padding: 15px 20px;
      border-radius: 10px;
      margin-bottom: 25px;
      display: flex;
      justify-content: center;
      align-items: center;
      animation: slideIn 0.3s ease;
      font-size: 18px;
      font-weight: 600;
    }

    @keyframes slideIn {
      from { transform: translateX(300px); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }

    table.data-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      font-size: 16px;
    }

    .data-table th {
      background: #f7fafc;
      text-align: left;
      padding: 12px 15px;
      font-weight: 600;
      color: #4a5568;
      border-bottom: 2px solid #e2e8f0;
    }

    .data-table td {
      padding: 12px 15px;
      border-bottom: 1px solid #e2e8f0;
      vertical-align: middle;
    }

    .data-table tr:hover td {
      background: #f7fafc;
    }

    .btn {
      padding: 8px 16px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
      text-align: center;
      font-size: 14px;
    }

    .btn-edit {
      background: linear-gradient(45deg, #4299e1, #3182ce);
      color: white;
      margin-right: 10px;
    }
    .btn-edit:hover {
      box-shadow: 0 8px 25px rgba(66, 153, 225, 0.3);
      transform: translateY(-2px);
    }

    .btn-delete {
      background: linear-gradient(45deg, #e53e3e, #c53030);
      color: white;
      border: none;
    }
    .btn-delete:hover {
      box-shadow: 0 8px 25px rgba(229, 62, 62, 0.3);
      transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 600px) {
      .data-table th, .data-table td {
        padding: 8px 10px;
        font-size: 14px;
      }
      h2 {
        font-size: 24px;
      }
      .btn {
        padding: 6px 12px;
        font-size: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Listado de Paquetes</h2>

    <?= $mensaje ?>

    <table class="data-table" aria-label="Listado de paquetes">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Destino</th>
          <th>Precio</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['nombre']) ?></td>
          <td><?= htmlspecialchars($row['destino']) ?></td>
          <td>$<?= number_format($row['precio'], 2) ?> <?= htmlspecialchars($row['moneda']) ?></td>
          <td>
            <a href="editar_paquete.php?id=<?= $row['id'] ?>" class="btn btn-edit" aria-label="Editar paquete <?= htmlspecialchars($row['nombre']) ?>">✏️ Editar</a>
            <form method="POST" action="eliminar_paquete.php" style="display:inline;" onsubmit="return confirm('¿Seguro querés eliminar este paquete?');" aria-label="Eliminar paquete <?= htmlspecialchars($row['nombre']) ?>">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <button type="submit" class="btn btn-delete">🗑️ Eliminar</button>
            </form>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>
