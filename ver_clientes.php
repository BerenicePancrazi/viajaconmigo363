<?php
include 'conexion.php';

$condicion = "WHERE rol = 'cliente'";

if (isset($_GET['busqueda']) && $_GET['busqueda'] != "") {
    $busqueda = $conexion->real_escape_string($_GET['busqueda']);
    $condicion .= " AND (nombre LIKE '%$busqueda%' OR email LIKE '%$busqueda%')";
}

$sql = "SELECT id, nombre, email, fecha_registro FROM usuarios $condicion ORDER BY fecha_registro DESC";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clientes Registrados</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #8f6aca 0%, #764ba2 100%);
      min-height: 100vh;
      color: #2d3748;
      padding: 20px;
    }
    .container {
      max-width: 1200px;
      margin: auto;
    }
    header {
      background: #ffffffee;
      backdrop-filter: blur(8px);
      padding: 25px 35px;
      border-radius: 14px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      margin-bottom: 40px;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .header-title h1 {
      font-size: 28px;
      font-weight: 700;
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
    .user-info {
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    #nombreUsuario {
      font-weight: 600;
    }
    #btnLogout {
      padding: 10px 16px;
      border-radius: 8px;
      background: #4a5568;
      color: white;
      border: none;
      cursor: pointer;
    }
    #btnLogout:hover {
      background: #2d3748;
    }
    .search-container {
      background: #ffffff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.05);
      margin-bottom: 30px;
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }
    .search-box {
      flex: 1;
      padding: 12px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      font-size: 14px;
      min-width: 200px;
    }
    .btn {
      padding: 12px 20px;
      border-radius: 8px;
      background: linear-gradient(45deg, #8f6aca, #8f6aca);
      color: white;
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: background 0.3s ease;
    }
    .btn:hover {
      background: linear-gradient(45deg, #8f6aca, #8f6aca);
    }
    .data-table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    .data-table th, .data-table td {
      padding: 16px;
      text-align: left;
    }
    .data-table th {
      background: #f7fafc;
      font-weight: 600;
      color: #4a5568;
    }
    .data-table tr:not(:last-child) td {
      border-bottom: 1px solid #e2e8f0;
    }
    .data-table tr:hover td {
      background: #f1f5f9;
    }
    .notification {
      text-align: center;
      padding: 30px;
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <div class="header-title">
        <h1><i class="fas fa-users"></i> Lista de Clientes</h1>
      </div>
      <span class="admin-badge">Clientes</span>
      <div class="user-info">
        <span id="nombreUsuario">Bienvenido</span>
        <button id="btnLogout">Cerrar sesión</button>
      </div>
    </header>

    <form method="GET" class="search-container">
      <input class="search-box" type="text" name="busqueda" placeholder="🔍 Buscar por nombre o email" value="<?= $_GET['busqueda'] ?? '' ?>">
      <button type="submit" class="btn"><i class="fas fa-search"></i> Buscar</button>
    </form>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Fecha de Registro</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['nombre']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= $row['fecha_registro'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="notification">
        <h4><i class="fas fa-info-circle"></i> Sin resultados</h4>
        <p>No se encontraron clientes con la búsqueda actual.</p>
      </div>
    <?php endif; ?>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const usuarioActivo = JSON.parse(localStorage.getItem('usuarioActivo'));

      if (usuarioActivo) {
        document.getElementById('nombreUsuario').textContent =
          `Bienvenido, ${usuarioActivo.nombre} (${usuarioActivo.email})`;
      } else {
        document.getElementById('nombreUsuario').textContent = `Bienvenido`;
      }

      document.getElementById('btnLogout').addEventListener('click', function () {
        localStorage.removeItem('usuarioActivo');
        window.location.href = 'login.php';
      });
    });
  </script>
</body>
</html>
