
<?php
include 'conexion.php';

// Consultar pedidos pendientes
$sql = "SELECT reservas.id, reservas.fecha_reserva, reservas.estado, reservas.numero_pedido,
        usuarios.nombre AS cliente_nombre,
        paquetes.nombre AS paquete_nombre,
        paquetes.precio
        FROM reservas
        INNER JOIN usuarios ON reservas.usuario_id = usuarios.id
        INNER JOIN paquetes ON reservas.paquete_id = paquetes.id
        WHERE reservas.estado = 'pendiente'";

$result = $conexion->query($sql);
if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pedidos Pendientes</title>
  <style>
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
      max-width: 1200px;
      margin: 40px auto;
      padding: 20px;
    }

    header {
      background: rgba(255, 255, 255, 0.95);
      padding: 20px 30px;
      border-radius: 15px;
      margin-bottom: 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .header-title {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .header-title h1 {
      color: #2d3748;
      font-size: 28px;
      font-weight: 700;
    }

    .admin-badge {
      background: linear-gradient(45deg, #8f6aca, #8f6aca);
      color: white;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      text-align: center;
      display: inline-block;
    }

    .btn-small {
      padding: 6px 12px;
      font-size: 13px;
    }

    .btn-info {
      background: linear-gradient(45deg, #4299e1, #3182ce);
      color: white;
    }

    .btn-danger {
      background: linear-gradient(45deg, #e53e3e, #c53030);
      color: white;
    }

    .btn-secondary {
      background: #e2e8f0;
      color: #4a5568;
    }

    .btn:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }

    .card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .card-title {
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 20px;
      color: #2d3748;
    }

    table.data-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    table.data-table th {
      background: #f7fafc;
      text-align: left;
      padding: 12px 15px;
      font-weight: 600;
      color: #4a5568;
      border-bottom: 2px solid #e2e8f0;
    }

    table.data-table td {
      padding: 12px 15px;
      border-bottom: 1px solid #e2e8f0;
    }

    table.data-table tr:hover td {
      background: #f7fafc;
    }

    .status-badge {
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      display: inline-block;
    }

    .status-pending {
      background: #fefcbf;
      color: #975a16;
    }

    @media (max-width: 768px) {
      .container {
        padding: 15px;
      }

      header {
        flex-direction: column;
        gap: 10px;
        text-align: center;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <div class="header-title">
        <h1>Gestión de Pedidos</h1>
        <span class="admin-badge">Jefe</span>
      </div>
      <a href="dashboard.php" class="btn btn-secondary">← Volver</a>
    </header>

    <div class="card">
      <h2 class="card-title">Pedidos Pendientes</h2>

      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>N° Pedido</th>
            <th>Cliente</th>
            <th>Paquete</th>
            <th>Precio</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php 
        if ($result->num_rows === 0) {
            echo "<tr><td colspan='8' style='text-align:center;'>No hay pedidos pendientes.</td></tr>";
        } else {
            while ($fila = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $fila['id'] ?></td>
              <td><?= $fila['numero_pedido'] ?? 'Sin asignar' ?></td>
              <td><?= htmlspecialchars($fila['cliente_nombre']) ?></td>
              <td><?= htmlspecialchars($fila['paquete_nombre']) ?></td>
              <td>$<?= number_format($fila['precio'], 2) ?></td>
              <td><?= $fila['fecha_reserva'] ?></td>
              <td><span class="status-badge status-pending"><?= $fila['estado'] ?></span></td>
              <td>
                  <a href="modificar_pedido.php?id=<?= $fila['id'] ?>" class="btn btn-info btn-small">Modificar</a>
                  <a href="entregar_pedido.php?id=<?= $fila['id'] ?>" class="btn btn-success btn-small" onclick="return confirm('¿Deseás entregar este pedido?')">Entregar</a>
                  <a href="eliminar_pedido.php?id=<?= $fila['id'] ?>" class="btn btn-danger btn-small" onclick="return confirm('¿Seguro que querés eliminar este pedido?')">Eliminar</a>
                  <a href="anular_pedido.php?id=<?= $fila['id'] ?>" class="btn btn-secondary btn-small" onclick="return confirm('¿Deseás anular este pedido?')">Anular</a>
              </td>
            </tr>
        <?php endwhile; 
        } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
