<?php 
session_start();
include 'conexion.php';

// Authentication check
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'jefe') {
    header('Location: login.php');
    exit;
}

// Get current page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Function to get status color
function getStatusColor($status) {
    switch ($status) {
        case 'pendiente': return 'warning';
        case 'confirmada': return 'info';
        case 'cancelada': return 'danger';
        default: return 'secondary';
    }
}

// Fetch data based on current page
$data = [];

// Fetch packages
if ($currentPage === 'products') {
    $query = "SELECT * FROM paquetes";
    $result = mysqli_query($conexion, $query);
    $data['paquetes'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fetch orders
if ($currentPage === 'orders') {
    $query = "SELECT r.id, r.estado, r.fecha_reserva, 
                     u.nombre AS cliente_nombre, u.email AS cliente_email, 
                     p.nombre AS paquete_nombre, p.precio, p.destino 
              FROM reservas r
              JOIN usuarios u ON r.usuario_id = u.id
              JOIN paquetes p ON r.paquete_id = p.id";
    $result = mysqli_query($conexion, $query);
    $data['orders'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fetch notifications
$query = "SELECT * FROM notificaciones WHERE jefe_id = {$_SESSION['usuario_id']} ORDER BY fecha DESC LIMIT 3";
$result = mysqli_query($conexion, $query);
$notificaciones = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch quick stats
$query = "SELECT COUNT(*) AS total_paquetes FROM paquetes";
$result = mysqli_query($conexion, $query);
$totalPaquetes = mysqli_fetch_assoc($result)['total_paquetes'];

$query = "SELECT COUNT(*) AS pedidos_pendientes FROM reservas WHERE estado = 'pendiente'";
$result = mysqli_query($conexion, $query);
$pedidosPendientes = mysqli_fetch_assoc($result)['pedidos_pendientes'];

$query = "SELECT SUM(p.precio) AS ingresos_mes 
          FROM reservas r
          JOIN paquetes p ON r.paquete_id = p.id
          WHERE MONTH(r.fecha_reserva) = MONTH(CURRENT_DATE()) 
          AND YEAR(r.fecha_reserva) = YEAR(CURRENT_DATE())";
$result = mysqli_query($conexion, $query);
$ingresosMes = mysqli_fetch_assoc($result)['ingresos_mes'] ?? 0;

$query = "SELECT COUNT(DISTINCT usuario_id) AS clientes_activos 
          FROM reservas 
          WHERE fecha_reserva >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)";
$result = mysqli_query($conexion, $query);
$clientesActivos = mysqli_fetch_assoc($result)['clientes_activos'] ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Jefe de Ventas - Viaja Conmigo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #ff6b00;
            --primary-hover: #e55e00;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #2d3748;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #1a2530 100%);
            color: white;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            width: 250px;
            z-index: 100;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            border-radius: 0.25rem;
            padding: 0.75rem 1rem;
            margin-bottom: 0.25rem;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar .nav-link.active {
            background: linear-gradient(90deg, var(--primary-color), var(--primary-hover));
            color: white !important;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
        
        .stat-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .badge-status {
            min-width: 100px;
            border-radius: 20px;
            padding: 0.4em 0.8em;
            font-weight: 500;
        }
        
        .action-btn {
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }
        
        .header-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .admin-badge {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-hover));
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-hover));
            border: none;
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(45deg, var(--primary-hover), #d15400);
            color: white;
        }
        
        .upload-zone {
            border: 2px dashed #cbd5e0;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f7fafc;
        }
        
        .upload-zone:hover {
            border-color: var(--primary-color);
            background: #fef5e7;
        }
        
        .upload-zone.dragover {
            border-color: var(--primary-color);
            background: #fef5e7;
            transform: scale(1.02);
        }
        
        .preview-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .preview-card:hover {
            transform: translateY(-5px);
        }
        
        .package-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }
        
        .notification {
            background: linear-gradient(45deg, #48bb78, #38a169);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { transform: translateX(300px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 15px;
        }
        
        .tab-btn {
            padding: 10px 20px;
            background: #e2e8f0;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .tab-btn.active {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-hover));
            color: white;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .form-section {
            display: none;
            animation: fadeIn 0.3s ease;
        }
        
        .form-section.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            display: none;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top: 5px solid var(--primary-color);
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .sidebar-card {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar d-none d-md-block">
        <div class="p-3 text-center">
            <h3 class="mt-3 mb-0">Viaja Conmigo</h3>
            <p class="text-muted">Panel de Jefe de Ventas</p>
        </div>
        
        <ul class="nav flex-column mt-4">
            <li class="nav-item mb-2">
                <a class="nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>" href="?page=dashboard">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link <?= $currentPage === 'orders' ? 'active' : '' ?>" href="?page=orders">
                    <i class="bi bi-cart me-2"></i> Pedidos
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link <?= $currentPage === 'accounting' ? 'active' : '' ?>" href="?page=accounting">
                    <i class="bi bi-cash-coin me-2"></i> Contabilidad
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link <?= $currentPage === 'customers' ? 'active' : '' ?>" href="?page=customers">
                    <i class="bi bi-people me-2"></i> Clientes
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link <?= $currentPage === 'products' ? 'active' : '' ?>" href="?page=products">
                    <i class="bi bi-box me-2"></i> Productos
                </a>
            </li>
            <li class="nav-item mt-4">
                <a class="nav-link text-danger" href="logout.php">
                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div class="header-title">
                <h1>Panel Jefe de Ventas</h1>
                <span class="admin-badge">Viaja Conmigo</span>
            </div>
            <div>
                <span style="margin-right: 15px; font-weight: 600;"><i class="fas fa-user"></i> <?= $_SESSION['nombre'] ?></span>
                <button class="btn btn-secondary" onclick="cerrarSesion()"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
            </div>
        </div>

        <!-- Pestañas de navegación para móviles -->
        <div class="tabs d-md-none">
            <button class="tab-btn <?= $currentPage === 'dashboard' ? 'active' : '' ?>" data-tab="dashboard">Dashboard</button>
            <button class="tab-btn <?= $currentPage === 'products' ? 'active' : '' ?>" data-tab="products">Productos</button>
            <button class="tab-btn <?= $currentPage === 'orders' ? 'active' : '' ?>" data-tab="orders">Pedidos</button>
        </div>

        <div class="dashboard-grid">
            <div class="main-content">
                <!-- Contenido de Dashboard -->
                <div class="tab-content <?= $currentPage === 'dashboard' ? 'active' : '' ?>" id="dashboard">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Resumen de Ventas</h2>
                            <div>
                                <button class="btn btn-info"><i class="fas fa-download"></i> Exportar Reporte</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-md-4 g-4">
                                <div class="col">
                                    <div class="stat-card card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title text-muted">Paquetes Activos</h5>
                                                <i class="bi bi-box text-muted fs-4"></i>
                                            </div>
                                            <h3 class="card-text fw-bold"><?= $totalPaquetes ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="stat-card card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title text-muted">Ventas Pendientes</h5>
                                                <i class="bi bi-cart text-muted fs-4"></i>
                                            </div>
                                            <h3 class="card-text fw-bold"><?= $pedidosPendientes ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="stat-card card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title text-muted">Ingresos del Mes</h5>
                                                <i class="bi bi-currency-dollar text-muted fs-4"></i>
                                            </div>
                                            <h3 class="card-text fw-bold">$<?= number_format($ingresosMes, 2) ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="stat-card card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title text-muted">Clientes Activos</h5>
                                                <i class="bi bi-people text-muted fs-4"></i>
                                            </div>
                                            <h3 class="card-text fw-bold"><?= $clientesActivos ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Últimos Pedidos</h2>
                            <button class="btn btn-primary" onclick="mostrarTab('orders')">Ver Todos</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID Pedido</th>
                                            <th>Cliente</th>
                                            <th>Producto</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $query = "SELECT r.id, r.estado, r.fecha_reserva, 
                                                         u.nombre AS cliente_nombre, 
                                                         p.nombre AS paquete_nombre, p.precio 
                                                  FROM reservas r
                                                  JOIN usuarios u ON r.usuario_id = u.id
                                                  JOIN paquetes p ON r.paquete_id = p.id
                                                  ORDER BY r.fecha_reserva DESC LIMIT 3";
                                        $result = mysqli_query($conexion, $query);
                                        while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td class="fw-bold">#ORD-<?= $row['id'] ?></td>
                                            <td><?= $row['cliente_nombre'] ?></td>
                                            <td><?= $row['paquete_nombre'] ?></td>
                                            <td><?= date('d/m/Y', strtotime($row['fecha_reserva'])) ?></td>
                                            <td class="fw-bold">$<?= number_format($row['precio'], 2) ?></td>
                                            <td>
                                                <span class="badge bg-<?= getStatusColor($row['estado']) ?> badge-status">
                                                    <?= ucfirst($row['estado']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <?php if ($row['estado'] === 'pendiente'): ?>
                                                    <form method="post" action="actualizar_reserva.php" class="d-inline">
                                                        <input type="hidden" name="reserva_id" value="<?= $row['id'] ?>">
                                                        <input type="hidden" name="nuevo_estado" value="confirmada">
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="fas fa-check"></i> Confirmar
                                                        </button>
                                                    </form>
                                                    <?php endif; ?>
                                                    <?php if ($row['estado'] === 'confirmada'): ?>
                                                    <form method="post" action="actualizar_reserva.php" class="d-inline">
                                                        <input type="hidden" name="reserva_id" value="<?= $row['id'] ?>">
                                                        <input type="hidden" name="nuevo_estado" value="completada">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-truck"></i> Completar
                                                        </button>
                                                    </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido de Productos -->
                <div class="tab-content <?= $currentPage === 'products' ? 'active' : '' ?>" id="products">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Gestión de Productos</h2>
                            <button class="btn btn-primary" onclick="toggleFormSection()">
                                <span id="toggleText">+ Agregar Nuevo Producto</span>
                            </button>
                        </div>

                        <div class="form-section" id="formSection">
                            <div class="form-grid">
                                <div class="form-fields">
                                    <form action="guardar_paquete.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="guardar_paquete">
                                        
                                        <!-- Imagen -->
                                        <div class="form-group mb-3">
                                            <label class="form-label">Imagen Principal</label>
                                            <div class="upload-zone" onclick="document.getElementById('portadaInput').click()" 
                                                ondrop="handleDrop(event)" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                                                <div class="upload-icon">📷</div>
                                                <div class="upload-text">Arrastra tu imagen aquí</div>
                                                <div class="upload-subtext">o haz clic para seleccionar</div>
                                            </div>
                                            <input type="file" name="portada" id="portadaInput" style="display:none" accept="image/*" />
                                            <div id="imageError" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: none;">
                                                Por favor selecciona una imagen
                                            </div>
                                        </div>

                                        <!-- Nombre y Destino -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Nombre del Producto</label>
                                                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ej: Paquete a París" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Destino</label>
                                                <input type="text" id="destino" name="destino" class="form-control" placeholder="Ej: París, Francia" required>
                                            </div>
                                        </div>

                                        <!-- Descripción -->
                                        <div class="mb-3">
                                            <label class="form-label">Descripción</label>
                                            <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Describe los detalles del paquete..." rows="4" required></textarea>
                                        </div>

                                        <!-- Precio y Moneda -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Precio Unitario</label>
                                                <div class="input-group">
                                                    <select id="moneda" name="moneda" class="form-select w-25" required>
                                                        <option value="USD">USD</option>
                                                        <option value="ARS">ARS</option>
                                                        <option value="EUR">EUR</option>
                                                    </select>
                                                    <input type="number" id="precio" name="precio" class="form-control" placeholder="0.00" step="0.01" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Duración (días)</label>
                                                <input type="number" id="duracion" name="duracion" class="form-control" placeholder="Ej: 7" min="1" required>
                                            </div>
                                        </div>

                                        <!-- Tipo de destino y servicio -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Tipo de Destino</label>
                                                <select id="tipoDestino" name="tipoDestino" class="form-select" required>
                                                    <option value="playa">Playa</option>
                                                    <option value="montaña">Montaña</option>
                                                    <option value="ciudad">Ciudad</option>
                                                    <option value="rural">Rural</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tipo de Servicio</label>
                                                <select id="tipoServicio" name="tipoServicio" class="form-select" required>
                                                    <option value="económico">Económico</option>
                                                    <option value="estándar">Estándar</option>
                                                    <option value="premium">Premium</option>
                                                    <option value="lujo">Lujo</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Fecha de salida y tipo de viaje -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Fecha de Salida</label>
                                                <input type="date" id="fechaSalida" name="fechaSalida" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tipo de Viaje</label>
                                                <select id="tipo" name="tipo" class="form-select" required>
                                                    <option value="aventura">Aventura</option>
                                                    <option value="relax">Relax</option>
                                                    <option value="cultural">Cultural</option>
                                                    <option value="romántico">Romántico</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Botones -->
                                        <div class="d-flex gap-3">
                                            <button type="submit" class="btn btn-primary">Guardar Producto</button>
                                            <button type="button" class="btn btn-secondary" onclick="cancelarFormulario()">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex flex-column flex-md-row gap-3 mb-4">
                                <div class="flex-grow-1 position-relative">
                                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                    <input type="text" class="form-control ps-5" placeholder="Buscar por nombre, destino o tipo..." id="searchProducts">
                                </div>
                                <button class="btn btn-outline-primary" onclick="document.getElementById('searchProducts').value=''; buscarProductos()">
                                    <i class="bi bi-arrow-clockwise"></i> Resetear
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Destino</th>
                                            <th>Precio</th>
                                            <th>Duración</th>
                                            <th>Tipo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($data['paquetes'])): ?>
                                            <?php foreach ($data['paquetes'] as $product): ?>
                                            <tr>
                                                <td>
                                                    <div class="fw-bold"><?= $product['nombre'] ?></div>
                                                    <small class="text-muted"><?= substr($product['descripcion'], 0, 60) ?>...</small>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="bi bi-geo-alt"></i>
                                                        <?= $product['destino'] ?>
                                                    </div>
                                                </td>
                                                <td class="fw-bold"><?= $product['moneda'] ?> <?= number_format($product['precio'], 2) ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="bi bi-calendar"></i>
                                                        <?= $product['duracion'] ?> días
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?= $product['tipo'] ?></span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-1">
                                                        <button class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="modal" data-bs-target="#productModal" 
                                                            onclick="loadProductForEdit('<?= $product['id'] ?>')">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <form method="post" action="eliminar_paquete.php" class="d-inline">
                                                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger action-btn">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No hay productos disponibles</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido de Pedidos -->
                <div class="tab-content <?= $currentPage === 'orders' ? 'active' : '' ?>" id="orders">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Gestión de Pedidos</h2>
                            <div class="search-container d-flex gap-3">
                                <div class="flex-grow-1 position-relative">
                                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                    <input type="text" class="form-control ps-5" placeholder="Buscar pedidos..." id="searchOrders">
                                </div>
                                <select class="form-select w-auto" id="filterStatus" onchange="filtrarPedidos()">
                                    <option value="">Todos los estados</option>
                                    <option value="pendiente">Pendientes</option>
                                    <option value="confirmada">Confirmadas</option>
                                    <option value="cancelada">Canceladas</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID Pedido</th>
                                            <th>Cliente</th>
                                            <th>Producto</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($data['orders'])): ?>
                                            <?php foreach ($data['orders'] as $order): ?>
                                            <tr>
                                                <td class="fw-bold">#ORD-<?= $order['id'] ?></td>
                                                <td>
                                                    <div class="fw-medium"><?= $order['cliente_nombre'] ?></div>
                                                    <small class="text-muted"><?= $order['cliente_email'] ?></small>
                                                </td>
                                                <td><?= $order['paquete_nombre'] ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="bi bi-calendar"></i>
                                                        <?= date('d/m/Y', strtotime($order['fecha_reserva'])) ?>
                                                    </div>
                                                </td>
                                                <td class="fw-bold">$<?= number_format($order['precio'], 2) ?></td>
                                                <td>
                                                    <span class="badge bg-<?= getStatusColor($order['estado']) ?> badge-status">
                                                        <?= ucfirst($order['estado']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <?php if ($order['estado'] === 'pendiente'): ?>
                                                        <form method="post" action="actualizar_reserva.php" class="d-inline">
                                                            <input type="hidden" name="reserva_id" value="<?= $order['id'] ?>">
                                                            <input type="hidden" name="nuevo_estado" value="confirmada">
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="fas fa-check"></i> Confirmar
                                                            </button>
                                                        </form>
                                                        <?php endif; ?>
                                                        <?php if ($order['estado'] === 'confirmada'): ?>
                                                        <form method="post" action="actualizar_reserva.php" class="d-inline">
                                                            <input type="hidden" name="reserva_id" value="<?= $order['id'] ?>">
                                                            <input type="hidden" name="nuevo_estado" value="completada">
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-truck"></i> Completar
                                                            </button>
                                                        </form>
                                                        <?php endif; ?>
                                                        <form method="post" action="cancelar_reserva.php" class="d-inline">
                                                            <input type="hidden" name="reserva_id" value="<?= $order['id'] ?>">
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-times"></i> Cancelar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No hay pedidos disponibles</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sidebar-card">
                <!-- Notificaciones -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Notificaciones</h2>
                        <span class="admin-badge"><?= count($notificaciones) ?></span>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($notificaciones)): ?>
                            <?php foreach ($notificaciones as $notificacion): ?>
                            <div class="notification">
                                <div class="notification-content">
                                    <p><?= $notificacion['mensaje'] ?></p>
                                    <small><?= date('d/m/Y H:i', strtotime($notificacion['fecha'])) ?></small>
                                </div>
                                <form method="post" action="eliminar_notificacion.php" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $notificacion['id'] ?>">
                                    <button type="submit" class="notification-close">×</button>
                                </form>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center p-3">
                                <i class="bi bi-bell fs-1 text-muted"></i>
                                <p class="mt-2">No tienes notificaciones</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Resumen Rápido -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Resumen Rápido</h2>
                    </div>
                    <div class="card-body">
                        <div class="stats-grid row g-3">
                            <div class="col-6">
                                <div class="stat-card card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title text-muted">Ventas Hoy</h5>
                                            <i class="bi bi-currency-dollar text-muted fs-4"></i>
                                        </div>
                                        <?php
                                        $query = "SELECT SUM(p.precio) AS ventas_hoy 
                                                  FROM reservas r
                                                  JOIN paquetes p ON r.paquete_id = p.id
                                                  WHERE DATE(r.fecha_reserva) = CURDATE()";
                                        $result = mysqli_query($conexion, $query);
                                        $ventasHoy = mysqli_fetch_assoc($result)['ventas_hoy'] ?? 0;
                                        ?>
                                        <h3 class="card-text fw-bold">$<?= number_format($ventasHoy, 2) ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title text-muted">Pedidos Nuevos</h5>
                                            <i class="bi bi-cart text-muted fs-4"></i>
                                        </div>
                                        <?php
                                        $query = "SELECT COUNT(*) AS pedidos_hoy 
                                                  FROM reservas 
                                                  WHERE DATE(fecha_reserva) = CURDATE()";
                                        $result = mysqli_query($conexion, $query);
                                        $pedidosHoy = mysqli_fetch_assoc($result)['pedidos_hoy'] ?? 0;
                                        ?>
                                        <h3 class="card-text fw-bold"><?= $pedidosHoy ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Productos -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalTitle">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="guardar_paquete.php" id="productForm">
                    <div class="modal-body">
                        <input type="hidden" name="action" id="productAction" value="create">
                        <input type="hidden" name="id" id="productId">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" name="nombre" id="modalNombre" placeholder="Europa Clásica 15 días" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Destino</label>
                                <input type="text" class="form-control" name="destino" id="modalDestino" placeholder="Europa" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="modalDescripcion" rows="3" placeholder="Descripción detallada del paquete de viaje..." required></textarea>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Precio (USD)</label>
                                <input type="number" class="form-control" name="precio" id="modalPrecio" placeholder="4500" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Duración (días)</label>
                                <input type="number" class="form-control" name="duracion" id="modalDuracion" placeholder="15" min="1" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tipo</label>
                                <select class="form-control" name="tipo" id="modalTipo" required>
                                    <option value="aventura">Aventura</option>
                                    <option value="relax">Relax</option>
                                    <option value="cultural">Cultural</option>
                                    <option value="romántico">Romántico</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Overlay de carga -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para cambiar entre pestañas
        function mostrarTab(tabId) {
            // Ocultar todos los contenidos de pestañas
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Desactivar todos los botones de pestañas
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Activar la pestaña seleccionada
            document.getElementById(tabId).classList.add('active');
            document.querySelector(`.tab-btn[data-tab="${tabId}"]`).classList.add('active');
            
            // Actualizar URL
            const url = new URL(window.location);
            url.searchParams.set('page', tabId);
            window.history.replaceState({}, '', url);
        }

        // Asignar eventos a los botones de pestaña al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    mostrarTab(tabId);
                });
            });

            // Verificar autenticación
            if (!localStorage.getItem('usuarioActivo')) {
                alert("No tienes permiso para esta página.");
                window.location.href = 'inicio1.php';
                return;
            }
        });

        // Función para mostrar/ocultar el formulario de productos
        function toggleFormSection() {
            const formSection = document.getElementById('formSection');
            const toggleText = document.getElementById('toggleText');
            
            if (formSection.style.display === 'none' || !formSection.style.display) {
                formSection.style.display = 'block';
                toggleText.textContent = '- Ocultar Formulario';
            } else {
                formSection.style.display = 'none';
                toggleText.textContent = '+ Agregar Nuevo Producto';
            }
        }

        // Función para cerrar sesión
        function cerrarSesion() {
            document.getElementById('loadingOverlay').style.display = 'flex';
            fetch('logout.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.removeItem('usuarioActivo');
                        window.location.href = 'login.php';
                    } else {
                        alert('Error al cerrar sesión');
                        document.getElementById('loadingOverlay').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('loadingOverlay').style.display = 'none';
                });
        }
        
        // Función para cargar un producto en el modal para edición
        function loadProductForEdit(productId) {
            document.getElementById('productModalTitle').textContent = 'Editar Producto';
            document.getElementById('productAction').value = 'update';
            document.getElementById('productId').value = productId;
            
            // Obtener datos del producto (simulado)
            // En una implementación real, se haría una petición AJAX al servidor
            const productos = <?= json_encode($data['paquetes'] ?? []) ?>;
            const producto = productos.find(p => p.id == productId);
            
            if (producto) {
                document.getElementById('modalNombre').value = producto.nombre || '';
                document.getElementById('modalDestino').value = producto.destino || '';
                document.getElementById('modalDescripcion').value = producto.descripcion || '';
                document.getElementById('modalPrecio').value = producto.precio || '';
                document.getElementById('modalDuracion').value = producto.duracion || '';
                document.getElementById('modalTipo').value = producto.tipo || 'aventura';
            }
        }
        
        // Resetear formulario cuando se abre para nuevo producto
        document.getElementById('productModal').addEventListener('show.bs.modal', function (event) {
            if (!event.relatedTarget) {
                document.getElementById('productModalTitle').textContent = 'Nuevo Producto';
                document.getElementById('productAction').value = 'create';
                document.getElementById('productId').value = '';
                document.getElementById('productForm').reset();
            }
        });
        
        // Manejo de la zona de carga de imágenes
        document.getElementById('portadaInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('imageError').style.display = 'none';
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgPreview = document.createElement('img');
                    imgPreview.src = e.target.result;
                    imgPreview.style.maxWidth = '200px';
                    imgPreview.style.marginTop = '10px';

                    // Evitar múltiples vistas previas
                    const zona = document.querySelector('.upload-zone');
                    zona.innerHTML = '';
                    zona.appendChild(imgPreview);
                };
                reader.readAsDataURL(file);
            }
        });

        function handleDragOver(e) {
            e.preventDefault();
            e.stopPropagation();
            e.target.classList.add('dragover');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            e.stopPropagation();
            e.target.classList.remove('dragover');
        }

        function handleDrop(e) {
            e.preventDefault();
            e.stopPropagation();
            e.target.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length) {
                document.getElementById('portadaInput').files = files;
                const event = new Event('change');
                document.getElementById('portadaInput').dispatchEvent(event);
            }
        }
        
        function cancelarFormulario() {
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('toggleText').textContent = '+ Agregar Nuevo Producto';
            document.querySelector('#formSection form').reset();
            document.querySelector('.upload-zone').innerHTML = `
                <div class="upload-icon">📷</div>
                <div class="upload-text">Arrastra tu imagen aquí</div>
                <div class="upload-subtext">o haz clic para seleccionar</div>
            `;
        }
        
        // Filtrar pedidos por estado
        function filtrarPedidos() {
            const estado = document.getElementById('filterStatus').value;
            const filas = document.querySelectorAll('#orders tbody tr');
            
            filas.forEach(fila => {
                const estadoFila = fila.querySelector('.badge-status').textContent.toLowerCase();
                if (!estado || estadoFila.includes(estado)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        }
        
        // Buscar productos
        function buscarProductos() {
            const termino = document.getElementById('searchProducts').value.toLowerCase();
            const filas = document.querySelectorAll('#products tbody tr');
            
            filas.forEach(fila => {
                const contenido = fila.textContent.toLowerCase();
                if (contenido.includes(termino)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        }
        
        // Configurar eventos de búsqueda
        document.getElementById('searchProducts').addEventListener('input', buscarProductos);
        document.getElementById('searchOrders').addEventListener('input', function() {
            const termino = this.value.toLowerCase();
            const filas = document.querySelectorAll('#orders tbody tr');
            
            filas.forEach(fila => {
                const contenido = fila.textContent.toLowerCase();
                if (contenido.includes(termino)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>