<?php
include("conexion.php");

$busqueda = $_GET['busqueda'] ?? '';
$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';

$sql = "SELECT * FROM reservas WHERE 1";

if (!empty($busqueda)) {
  $busqueda = mysqli_real_escape_string($conexion, $busqueda);
  $sql .= " AND (nombre_cliente LIKE '%$busqueda%' OR estado LIKE '%$busqueda%')";
}

if (!empty($desde)) {
  $sql .= " AND fecha_reserva >= '$desde'";
}

if (!empty($hasta)) {
  $sql .= " AND fecha_reserva <= '$hasta'";
}

$resultado = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reservas de Clientes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #8f6aca 0%, #764ba2 100%);
      min-height: 100vh;
      color: #2d3748;
      padding: 20px;
    }

    .container {
      max-width: 1300px;
      margin: 0 auto;
    }

    header {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(8px);
      padding: 25px 35px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 40px;
    }

    .header-title h1 {
      font-size: 30px;
      font-weight: 700;
      color: #1a202c;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .admin-badge {
      background: linear-gradient(to right, #8f6aca, #8f6aca);
      color: white;
      padding: 8px 18px;
      border-radius: 999px;
      font-size: 13px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .search-container {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      background: #ffffffdd;
      padding: 20px;
      border-radius: 14px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }

    .search-box,
    .filter-select {
      flex: 1;
      padding: 12px 18px;
      border: 2px solid #e2e8f0;
      border-radius: 10px;
      font-size: 14px;
    }

    .btn {
      padding: 12px 22px;
      border-radius: 10px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .btn-primary {
      background: linear-gradient(45deg, #8f6aca, #8f6aca);
      color: white;
    }

    .btn-success {
      background: linear-gradient(45deg, #38a169, #48bb78);
      color: white;
      font-size: 13px;
    }

    .btn-export {
      background: #2b6cb0;
      color: white;
    }

    .btn-export:hover {
      background: #2c5282;
    }

    .export-buttons {
      display: flex;
      gap: 15px;
      margin-bottom: 25px;
    }

    .data-table {
      width: 100%;
      border-collapse: collapse;
      background: #ffffff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }

    .data-table th,
    .data-table td {
      padding: 18px;
      text-align: left;
    }

    .data-table th {
      background: #f1f5f9;
      font-size: 14px;
      color: #4a5568;
    }

    .data-table tr:not(:last-child) td {
      border-bottom: 1px solid #e2e8f0;
    }

    .data-table tr:hover td {
      background-color: #edf2f7;
    }

    .form-select {
      padding: 8px 14px;
      border-radius: 8px;
      border: 1px solid #cbd5e0;
      font-size: 13px;
    }

    .status-badge {
      display: inline-block;
      padding: 6px 14px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    .status-pending {
      background: #fff3cd;
      color: #856404;
    }

    .status-delivered {
      background: #c6f6d5;
      color: #276749;
    }

    .status-cancelled {
      background: #fed7d7;
      color: #c53030;
    }

    .notification {
      background: white;
      padding: 25px;
      border-radius: 14px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.05);
      text-align: center;
    }

    .notification h4 {
      font-size: 18px;
      margin-bottom: 6px;
    }
  </style>
</head>
<body>
<div class="container">
  <header>
    <div class="header-title">
      <h1><i class="fas fa-calendar-check"></i> Reservas de Clientes</h1>
    </div>
  </header>

  <form method="GET" class="search-container">
    <input class="search-box" type="text" name="busqueda" placeholder="🔍 Buscar por nombre o estado" value="<?= $_GET['busqueda'] ?? '' ?>">
    <input type="date" class="filter-select" name="desde" value="<?= $_GET['desde'] ?? '' ?>">
    <input type="date" class="filter-select" name="hasta" value="<?= $_GET['hasta'] ?? '' ?>">
    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
  </form>

  <div class="export-buttons">
    <a href="exportar_excel.php" class="btn btn-export"><i class="fas fa-file-excel"></i> Exportar a Excel</a>
    <a href="exportar_pdf.php" class="btn btn-export"><i class="fas fa-file-pdf"></i> Exportar a PDF</a>
  </div>

  <?php if (mysqli_num_rows($resultado) > 0): ?>
    <table class="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Cliente</th>
          <th>Paquete</th>
          <th>Destino</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
      <?php while($row = mysqli_fetch_assoc($resultado)): ?>
        <tr>
          <td><?= $row['reserva_id'] ?></td>
          <td><?= $row['nombre_cliente'] ?></td>
          <td><?= $row['nombre_paquete'] ?></td>
          <td><?= $row['destino'] ?></td>
          <td><?= $row['fecha_reserva'] ?></td>
          <td>
            <span class="status-badge 
              <?= $row['estado'] == 'pendiente' ? 'status-pending' : '' ?>
              <?= $row['estado'] == 'confirmada' ? 'status-delivered' : '' ?>
              <?= $row['estado'] == 'cancelada' ? 'status-cancelled' : '' ?>">
              <?= ucfirst($row['estado']) ?>
            </span>
          </td>
          <td>
            <form method="POST" action="cambiar_estado.php" style="display:inline-block;">
              <input type="hidden" name="id" value="<?= $row['reserva_id'] ?>">
              <select name="estado" class="form-select">
                <option value="pendiente" <?= $row['estado'] == 'pendiente' ? 'selected' : '' ?>>pendiente</option>
                <option value="confirmada" <?= $row['estado'] == 'confirmada' ? 'selected' : '' ?>>confirmada</option>
                <option value="cancelada" <?= $row['estado'] == 'cancelada' ? 'selected' : '' ?>>cancelada</option>
              </select>
              <button type="submit" class="btn btn-success" title="Cambiar estado"><i class="fas fa-sync-alt"></i></button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="notification">
      <h4><i class="fas fa-info-circle"></i> Sin resultados</h4>
      <p>No se encontraron reservas con los filtros aplicados.</p>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
