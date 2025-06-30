<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Panel Jefe de Ventas - Viaja Conmigo</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body { 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #8f6aca 0%, #331353 100%);
      min-height: 100vh;
      color: #2d3748;
    }

    .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 20px;
    }

    header { 
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
      background: linear-gradient(45deg, #ff6b00, #ff8533);
      color: white;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .btn {
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
      text-align: center;
    }

    .btn-primary {
      background: linear-gradient(45deg, #ff6b00, #ff8533);
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(255, 107, 0, 0.3);
    }

    .btn-secondary {
      background: #e2e8f0;
      color: #4a5568;
    }

    .btn-secondary:hover {
      background: #cbd5e0;
    }

    .btn-success {
      background: linear-gradient(45deg, #38a169, #48bb78);
      color: white;
    }

    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(56, 161, 105, 0.3);
    }

    .btn-info {
      background: linear-gradient(45deg, #331353, #8f6aca);
      color: white;
    }

    .btn-info:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(66, 153, 225, 0.3);
    }

    .btn-danger {
      background: linear-gradient(45deg, #e53e3e, #c53030);
      color: white;
    }

    .btn-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(229, 62, 62, 0.3);
    }

    .dashboard-grid {
      display: grid;
      grid-template-columns: 1fr 400px;
      gap: 30px;
      margin-bottom: 30px;
    }

    .main-content {
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .sidebar {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid #e2e8f0;
    }

    .card-title {
      font-size: 22px;
      font-weight: 700;
      color: #2d3748;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 15px;
      margin-bottom: 20px;
    }

    .stat-card {
      background: linear-gradient(45deg, #331353, #8f6aca);
      color: white;
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(66, 153, 225, 0.3);
    }

    .stat-number {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 5px;
    }

    .stat-label {
      font-size: 12px;
      opacity: 0.9;
      text-transform: uppercase;
    }

    /* Formulario mejorado */
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

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 350px;
      gap: 30px;
      margin-top: 20px;
    }

    .form-fields {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .form-label {
      font-weight: 600;
      color: #2d3748;
      font-size: 14px;
    }

    .form-input, .form-select, .form-textarea {
      padding: 12px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      font-size: 14px;
      transition: border-color 0.3s ease;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
      outline: none;
      border-color: #8f6aca;
      box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
    }

    .form-textarea {
      resize: vertical;
      min-height: 100px;
    }

    .price-group {
      display: grid;
      grid-template-columns: 100px 1fr;
      gap: 10px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }

    /* Vista previa del paquete */
    .package-preview {
      position: sticky;
      top: 20px;
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

    .preview-image {
      width: 100%;
      height: 200px;
      background: #f7fafc;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #a0aec0;
      font-size: 14px;
      position: relative;
      overflow: hidden;
    }

    .preview-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .preview-content {
      padding: 20px;
    }

    .preview-title {
      font-size: 18px;
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 8px;
    }

    .preview-description {
      color: #718096;
      font-size: 14px;
      line-height: 1.5;
      margin-bottom: 15px;
    }

    .preview-meta {
      display: flex;
      gap: 15px;
      margin-bottom: 10px;
      font-size: 13px;
    }

    .preview-meta span {
      background: #f7fafc;
      padding: 4px 8px;
      border-radius: 6px;
    }

    .preview-price {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .price-tag {
      background: linear-gradient(45deg, #ff6b00, #ff8533);
      color: white;
      padding: 8px 12px;
      border-radius: 6px;
      font-weight: 700;
      font-size: 16px;
    }

    .preview-badge {
      background: #e6fffa;
      color: #319795;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 600;
    }

    /* Upload zone mejorada */
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
      border-color: #ff6b00;
      background: #fef5e7;
    }

    .upload-zone.dragover {
      border-color: #ff6b00;
      background: #fef5e7;
      transform: scale(1.02);
    }

    .upload-icon {
      font-size: 48px;
      color: #a0aec0;
      margin-bottom: 15px;
    }

    .upload-text {
      color: #4a5568;
      font-weight: 600;
      margin-bottom: 5px;
    }

    .upload-subtext {
      color: #a0aec0;
      font-size: 12px;
    }

    /* Lista de paquetes mejorada */
    .packages-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
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

    .package-image {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .package-info {
      padding: 15px;
    }

    .package-name {
      font-size: 16px;
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 8px;
    }

    .package-description {
      color: #718096;
      font-size: 13px;
      line-height: 1.4;
      margin-bottom: 12px;
    }

    .package-meta {
      display: flex;
      gap: 10px;
      margin-bottom: 12px;
      font-size: 12px;
    }

    .package-meta span {
      background: #f7fafc;
      padding: 4px 8px;
      border-radius: 6px;
    }

    .package-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .package-price {
      font-weight: 700;
      color: #8f6aca;
      font-size: 16px;
    }

    .package-actions {
      display: flex;
      gap: 8px;
    }

    .btn-small {
      padding: 6px 12px;
      font-size: 12px;
      border-radius: 6px;
    }

    /* Notificaciones mejoradas */
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

    .notification-content h4 {
      margin-bottom: 5px;
      font-size: 16px;
    }

    .notification-content p {
      font-size: 13px;
      opacity: 0.9;
    }

    .notification-close {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: white;
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 12px;
    }

    /* Tab navigation */
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
      background: linear-gradient(45deg, #8f6aca, #8f6aca);
      color: white;
    }

    .tab-btn:hover:not(.active) {
      background: #cbd5e0;
    }

    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }: none;
    }

    .tab-content.active {
      display: block;
    }

    /* Table styles */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
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
    }

    .data-table tr:hover td {
      background: #f7fafc;
    }

    .status-badge {
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    .status-pending {
      background: #fefcbf;
      color: #975a16;
    }

    .status-delivered {
      background: #c6f6d5;
      color: #276749;
    }

    .status-cancelled {
      background: #fed7d7;
      color: #c53030;
    }

    /* Search and filter */
    .search-container {
      display: flex;
      gap: 15px;
      margin-bottom: 20px;
    }

    .search-box {
      flex: 1;
      padding: 12px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      font-size: 14px;
    }

    .filter-select {
      padding: 12px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      font-size: 14px;
      background: white;
    }

    /* Feedback de carga */
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
      border-top: 5px solid #8f6aca;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .dashboard-grid {
        grid-template-columns: 1fr;
      }
      
      .form-grid {
        grid-template-columns: 1fr;
      }
      
      .packages-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      }
    }

    @media (max-width: 768px) {
      .container {
        padding: 15px;
      }
      
      header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
      }
      
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .form-row {
        grid-template-columns: 1fr;
      }
    }
    /* Table styles */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
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
    }

    .data-table tr:hover td {
      background: #f7fafc;
    }

    .status-badge {
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    .status-pending {
      background: #fefcbf;
      color: #975a16;
    }

    .status-delivered {
      background: #c6f6d5;
      color: #276749;
    }

    .status-cancelled {
      background: #fed7d7;
      color: #c53030;
    }

    /* Search and filter */
    .search-container {
      display: flex;
      gap: 15px;
      margin-bottom: 20px;
    }

    .search-box {
      flex: 1;
      padding: 12px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      font-size: 14px;
    }

    .filter-select {
      padding: 12px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      font-size: 14px;
      background: white;
    }

    /* Feedback de carga */
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
      border-top: 5px solid #8f6aca;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .dashboard-grid {
        grid-template-columns: 1fr;
      }
      
      .form-grid {
        grid-template-columns: 1fr;
      }
      
      .packages-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      }
    }

    @media (max-width: 768px) {
      .container {
        padding: 15px;
      }
      
      header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
      }
      
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .form-row {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <header>
      <div class="header-title">
        <h1>Panel Jefe de Ventas</h1>
        <span class="admin-badge">Viaja Conmigo</span>
      </div>
      <div>
        <span style="margin-right: 15px; font-weight: 600;"><i class="fas fa-user"></i> Carlos Rodríguez</span>
        <button class="btn btn-secondary" onclick="cerrarSesion()"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
      </div>
    </header>

    <div class="dashboard-grid">
      <div class="main-content">
        <!-- Pestañas de navegación -->
        <div class="tabs">
          <button class="tab-btn active" data-tab="dashboard">Dashboard</button>

          <button class="tab-btn" data-tab="productos">Productos</button>
          
          <a href="ver_reservas.php"><button class="tab-btn" >Ver Reservas</button></a>

          <a href="ver_clientes.php"><button class="tab-btn">Ver Clientes</button></a>

          <a href="eliminar_paquete.php"><button class="tab-btn">Borrar paquetes </button></a>

          <a href="pedidos_pendientes.php"><button class="tab-btn">Pedidos pendientes</button></a>

        </div>

        <!-- Contenido de Dashboard -->
        <div class="tab-content active" id="dashboard">
          <div class="card">
            <div class="card-header">
              <h2 class="card-title">Resumen de Ventas</h2>
              <div>
                <button class="btn btn-info"><i class="fas fa-download"></i> Exportar Reporte</button>
              </div>
            </div>
            <div class="stats-grid">
              <div class="stat-card">
                <div class="stat-number" id="totalPaquetes">24</div>
                <div class="stat-label">Paquetes Activos</div>
              </div>
              <div class="stat-card">
                <div class="stat-number" id="totalVentas">18</div>
                <div class="stat-label">Ventas Pendientes</div>
              </div>
              <div class="stat-card">
                <div class="stat-number" id="ingresosMes">$42,580</div>
                <div class="stat-label">Ingresos del Mes</div>
              </div>
              <div class="stat-card">
                <div class="stat-number" id="clientesActivos">56</div>
                <div class="stat-label">Clientes Activos</div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h2 class="card-title">Últimos Pedidos</h2>
              <button class="btn btn-primary" onclick="mostrarTab('pedidos')">Ver Todos</button>
            </div>
            <table class="data-table">
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
                <tr>
                  <td>#ORD-00125</td>
                  <td>María González</td>
                  <td>París Premium</td>
                  <td>15/06/2025</td>
                  <td>$1,250</td>
                  <td><span class="status-badge status-pending">Pendiente</span></td>
                  <td>
                    <button class="btn btn-success btn-small"><i class="fas fa-check"></i> Entregar</button>
                    <button class="btn btn-danger btn-small"><i class="fas fa-times"></i> Anular</button>
                  </td>
                </tr>
                <tr>
                  <td>#ORD-00124</td>
                  <td>Roberto Sánchez</td>
                  <td>New York Express</td>
                  <td>14/06/2025</td>
                  <td>$980</td>
                  <td><span class="status-badge status-delivered">Entregado</span></td>
                  <td>
                    <button class="btn btn-info btn-small"><i class="fas fa-file-invoice"></i> Factura</button>
                  </td>
                </tr>
                <tr>
                  <td>#ORD-00123</td>
                  <td>Laura Martínez</td>
                  <td>Roma Clásica</td>
                  <td>14/06/2025</td>
                  <td>$1,120</td>
                  <td><span class="status-badge status-pending">Pendiente</span></td>
                  <td>
                    <button class="btn btn-success btn-small"><i class="fas fa-check"></i> Entregar</button>
                    <button class="btn btn-danger btn-small"><i class="fas fa-times"></i> Anular</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Contenido de Productos -->
        <div class="tab-content" id="productos">
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
                <div class="form-fields">
  <form action="guardar_paquete.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
            <label class="form-label">Tipo de Servicio</label>
            <select id="tipoServicio" class="form-select" onchange="mostrarCamposPorTipo()">
              <option value="paquete">Paquete</option>
              <option value="vuelo">Vuelo</option>
              <option value="hospedaje">Hospedaje</option>
              <option value="alquiler">Alquiler</option>
              
            </select>
          </div>

    <!-- Imagen -->
    <div class="form-group">
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
    <!-- CAMPOS DE PAQUETE -->
<div class="campos-servicio" id="campos-paquete">
  <!-- aquí va tu formulario original -->
  <!-- Nombre, Código, Descripción, Imagen, etc. -->
</div>

<!-- CAMPOS DE VUELO -->
<div class="campos-servicio" id="campos-vuelo" style="display: none;">
  <div class="form-group">
    <label class="form-label">Aerolínea</label>
    <input type="text" class="form-input" name="aerolinea" placeholder="Ej: Aerolíneas Argentinas">
  </div>
  <div class="form-group">
    <label class="form-label">Número de Vuelo</label>
    <input type="text" class="form-input" name="numeroVuelo" placeholder="Ej: AR1234">
  </div>
</div>

<!-- CAMPOS DE HOSPEDAJE -->
<div class="campos-servicio" id="campos-hospedaje" style="display: none;">
  <div class="form-group">
    <label class="form-label">Nombre del Hotel</label>
    <input type="text" class="form-input" name="nombreHotel" placeholder="Ej: Hotel Sol">
  </div>
  <div class="form-group">
    <label class="form-label">Estrellas</label>
    <select class="form-select" name="estrellas">
      <option value="1">⭐</option>
      <option value="2">⭐⭐</option>
      <option value="3">⭐⭐⭐</option>
      <option value="4">⭐⭐⭐⭐</option>
      <option value="5">⭐⭐⭐⭐⭐</option>
    </select>
  </div>
</div>

<!-- CAMPOS DE ALQUILER -->
<div class="campos-servicio" id="campos-alquiler" style="display: none;">
  <div class="form-group">
    <label class="form-label">Tipo de Vehículo</label>
    <input type="text" class="form-input" name="tipoVehiculo" placeholder="Ej: Auto, Camioneta">
  </div>
  <div class="form-group">
    <label class="form-label">Compañía de Alquiler</label>
    <input type="text" class="form-input" name="empresaAlquiler" placeholder="Ej: Rentacar">
  </div>
</div>

    <!-- Código y Categoría -->
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Código de Producto</label>
        <input type="text" id="codigoProducto" name="codigo" class="form-input" placeholder="Ej: VIAJE-PARIS-001" onkeyup="updatePreview()" />
      </div>
      <div class="form-group">
        <label class="form-label">Categoría</label>
        <select id="categoria" name="categoria" class="form-select" onchange="updatePreview()">
          <option value="internacional">Internacional</option>
          <option value="nacional">Nacional</option>
        
        </select>
      </div>
    </div>

    <!-- Nombre -->
    <div class="form-group">
      <label class="form-label">Nombre del Producto</label>
      <input type="text" id="nombre" name="nombre" class="form-input" placeholder="Ej: Paquete a París" />
    </div>

    <!-- Descripción -->
    <div class="form-group">
      <label class="form-label">Descripción</label>
      <textarea id="descripcionPaquete" name="descripcion" class="form-textarea" placeholder="Describe los detalles del paquete..." onkeyup="updatePreview()"></textarea>
    </div>

    <!-- Precio y Moneda -->
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Precio Unitario</label>
        <div class="price-group">
          <select id="moneda" name="moneda" class="form-select" onchange="updatePreview()">
            <option value="USD">USD</option>
            <option value="ARS">ARS</option>
            <option value="EUR">EUR</option>
          </select>
          <input type="number" id="precio" name="precio" class="form-input" placeholder="0.00" onkeyup="updatePreview()" />
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Stock Disponible</label>
        <input type="number" id="stock" name="stock" class="form-input" placeholder="Ej: 10" onkeyup="updatePreview()" />
      </div>
    </div>

    <!-- Fotos adicionales -->
    <div class="form-group">
      <label class="form-label">Fotos Adicionales</label>
      <input type="file" name="fotosAdicionales[]" class="form-input" multiple accept="image/*" />
    </div>

    <!-- Botones -->
    <div style="display: flex; gap: 15px;">
      <button type="submit" class="btn btn-primary">Guardar Producto</button>
      <button type="button" class="btn btn-secondary" onclick="cancelarFormulario()">Cancelar</button>
    </div>
  </form>
</div>  <!-- Cierra .form-fields -->


        <!-- Contenido de Pedidos -->
        <div class="tab-content" id="pedidos">
          <div class="card">
            <div class="card-header">
              <h2 class="card-title">Gestión de Pedidos</h2>
              <div class="search-container">
                <input type="text" class="search-box" placeholder="Buscar pedidos..." id="searchOrders">
                <select class="filter-select" id="filterStatus">
                  <option value="">Todos los estados</option>
                  <option value="pendiente">Pendientes</option>
                  <option value="entregado">Entregados</option>
                  <option value="anulado">Anulados</option>
                </select>
              </div>
            </div>
            <div id="pedidos" class="tab-content active">
            <div class="card">
                <div class="card-header">
                <h2 class="card-title">Últimos Pedidos</h2>
                <button class="btn btn-primary" onclick="consultarPedidosDesdePHP()">Actualizar</button>

                </div>
                <table class="data-table">
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
                <tbody id="tablaPedidosPendientes"></tbody>
                </table>
            </div>
            </div>
          </div>
        </div>

        <!-- Contenido de Estado de Cuenta -->
        <div class="tab-content" id="cuenta">
          <div class="card">
            <div class="card-header">
              <h2 class="card-title">Estado de Cuenta</h2>
              <div class="search-container">
                <input type="text" class="search-box" placeholder="Buscar cliente..." id="searchClient">
                <select class="filter-select" id="filterInvoice">
                  <option value="">Todas las facturas</option>
                  <option value="pendiente">Pendientes</option>
                  <option value="pagada">Pagadas</option>
                  <option value="vencida">Vencidas</option>
                </select>
              </div>
            </div>
            <table class="data-table">
              <thead>
                <tr>
                  <th>ID Factura</th>
                  <th>Cliente</th>
                  <th>Fecha Emisión</th>
                  <th>Fecha Vencimiento</th>
                  <th>Monto</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>#INV-2025-125</td>
                  <td>María González</td>
                  <td>15/06/2025</td>
                  <td>30/06/2025</td>
                  <td>$1,250</td>
                  <td><span class="status-badge status-pending">Pendiente</span></td>
                  <td>
                    <button class="btn btn-info btn-small"><i class="fas fa-file-invoice"></i> Ver</button>
                    <button class="btn btn-success btn-small"><i class="fas fa-check"></i> Marcar Pagada</button>
                  </td>
                </tr>
                <tr>
                  <td>#INV-2025-124</td>
                  <td>Roberto Sánchez</td>
                  <td>14/06/2025</td>
                  <td>29/06/2025</td>
                  <td>$980</td>
                  <td><span class="status-badge status-delivered">Pagada</span></td>
                  <td>
                    <button class="btn btn-info btn-small"><i class="fas fa-file-invoice"></i> Ver</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="sidebar">
        <!-- Ventas Pendientes -->
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Ventas Pendientes</h2>
            <span class="admin-badge">5</span>
          </div>
          <div id="ventasPendientesContainer">
            <!-- Notificaciones dinámicas -->
          </div>
        </div>

        <!-- Resumen Rápido -->
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Resumen Rápido</h2>
          </div>
          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-number">$12,450</div>
              <div class="stat-label">Ventas Hoy</div>
            </div>
            <div class="stat-card">
              <div class="stat-number">8</div>
              <div class="stat-label">Pedidos Nuevos</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal para ver fotos -->
  <div class="modal" id="modalFotos" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); justify-content: center; align-items: center;">
    <div style="background: white; padding: 20px; border-radius: 15px; max-width: 90%; max-height: 90%; position: relative;">
      <button style="position: absolute; top: 10px; right: 15px; background: #e53e3e; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer;" onclick="cerrarModal()">×</button>
      <div id="carouselFotos" style="display: flex; overflow-x: auto; gap: 10px; padding: 20px 0;">
        <!-- Las fotos se cargarán aquí -->
      </div>
    </div>
  </div>

  <!-- Overlay de carga -->
  <div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
  </div>

  <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-firestore.js"></script>
<script>
  const firebaseConfig = {
    apiKey: "YOUR_API_KEY",
    authDomain: "YOUR_PROJECT_ID.firebaseapp.com",
    projectId: "YOUR_PROJECT_ID",
    storageBucket: "YOUR_PROJECT_ID.appspot.com",
    messagingSenderId: "YOUR_SENDER_ID",
    appId: "YOUR_APP_ID"
  };

  const app = firebase.initializeApp(firebaseConfig);
  const db = firebase.firestore();
</script>
</script>
  <script>
    let modoEdicion = false;
  let idEdicion = null;

  function guardarProductoFirestore(producto) {
    if (modoEdicion && idEdicion) {
      db.collection('paquetes').doc(idEdicion).update(producto).then(() => {
        modoEdicion = false;
        idEdicion = null;
        listarProductosFirestore();
      });
    } else {
      db.collection('paquetes').add(producto).then(() => listarProductosFirestore());
    }
  }

  function listarProductosFirestore() {
    db.collection('paquetes').get().then((snapshot) => {
      const contenedor = document.getElementById('listaProductos');
      contenedor.innerHTML = '';
      if (snapshot.empty) {
        contenedor.innerHTML = `<tr><td colspan='5' style='text-align:center;'><img src='/mnt/data/A_digital_vector_graphic_displays_a_centered_messa.png' alt='No se encontraron imágenes' style='max-width:200px;margin:auto;' /></td></tr>`;
        return;
      }
      snapshot.forEach((doc) => {
        const p = doc.data();
        const fila = document.createElement('tr');
        fila.innerHTML = `
          <td>${p.codigo}</td>
          <td>${p.nombre}</td>
          <td>${p.precio} ${p.moneda}</td>
          <td>${p.stock}</td>
          <td>
            <button class='btn btn-warning btn-small' onclick="editarProductoFirestore('${doc.id}', ${JSON.stringify(p).replace(/"/g, '&quot;')})">Editar</button>
            <button class='btn btn-danger btn-small' onclick="eliminarProductoFirestore('${doc.id}')">Eliminar</button>
          </td>`;
        contenedor.appendChild(fila);
      });
    });
  }

  function eliminarProductoFirestore(id) {
    db.collection('paquetes').doc(id).delete().then(() => listarProductosFirestore());
  }

  function editarProductoFirestore(id, producto) {
    document.getElementById('codigoProducto').value = producto.codigo;
    document.getElementById('categoria').value = producto.categoria;
    document.getElementById('nombre').value = producto.nombre;
    document.getElementById('descripcionPaquete').value = producto.descripcion;
    document.getElementById('moneda').value = producto.moneda;
    document.getElementById('precio').value = producto.precio;
    document.getElementById('stock').value = producto.stock;
    modoEdicion = true;
    idEdicion = id;
    toggleFormSection();
  }

  function consultarPedidosPendientes() {
    db.collection('pedidos').where('estado', '==', 'pendiente').onSnapshot((snapshot) => {
      const contenedor = document.getElementById('tablaPedidosPendientes');
      contenedor.innerHTML = '';
      snapshot.forEach(doc => {
        const d = doc.data();
        const fila = document.createElement('tr');
        fila.innerHTML = `
          <td>${doc.id}</td>
          <td>${d.cliente}</td>
          <td>${d.producto}</td>
          <td>${d.fecha}</td>
          <td>${d.total}</td>
          <td>${d.estado}</td>
          <td>
            <button onclick="entregarPedido('${doc.id}')">Entregar</button>
            <button onclick="anularPedido('${doc.id}')">Anular</button>
          </td>`;
        contenedor.appendChild(fila);
      });
    });
  }

  function entregarPedido(id) {
    db.collection('pedidos').doc(id).get().then(doc => {
      const data = doc.data();
      db.collection('historial').add(data).then(() => {
        db.collection('pedidos').doc(id).delete();
      });
    });
  }

  function anularPedido(id) {
    db.collection('pedidos').doc(id).update({ estado: 'anulado' });
  }

  function verEstadoCuentaPorFecha() {
    db.collection('facturas').orderBy('fecha').get().then(snapshot => {
      const contenedor = document.getElementById('estadoCuentaFecha');
      contenedor.innerHTML = '';
      snapshot.forEach(doc => {
        const f = doc.data();
        const fila = document.createElement('tr');
        fila.innerHTML = `
          <td>${f.cliente}</td>
          <td>${f.fecha}</td>
          <td>${f.monto}</td>
          <td>${f.estado}</td>`;
        contenedor.appendChild(fila);
      });
    });
  }

  function verEstadoCuentaPorCliente() {
    db.collection('facturas').orderBy('cliente').get().then(snapshot => {
      const contenedor = document.getElementById('estadoCuentaCliente');
      contenedor.innerHTML = '';
      snapshot.forEach(doc => {
        const f = doc.data();
        const fila = document.createElement('tr');
        fila.innerHTML = `
          <td>${f.cliente}</td>
          <td>${f.fecha}</td>
          <td>${f.monto}</td>
          <td>${f.estado}</td>`;
        contenedor.appendChild(fila);
      });
    });
  }
  fetch('consultar_pedidos.php')
  .then(res => res.json())
  .then(data => {
    const tabla = document.getElementById('tablaPedidosPendientes');
    tabla.innerHTML = '';
    data.forEach(p => {
      tabla.innerHTML += `
        <tr>
          <td>#ORD-${p.id}</td>
          <td>${p.cliente}</td>
          <td>${p.paquete}</td>
          <td>${p.fecha_reserva}</td>
          <td>$${p.precio}</td>
          <td>${p.estado}</td>
          <td>
            <button onclick="entregarPedido(${p.id})">✔ Entregar</button>
            <button onclick="anularPedido(${p.id})">✘ Anular</button>
          </td>
        </tr>`;
    });
  });


  document.addEventListener('DOMContentLoaded', () => {
    listarProductosFirestore();
    consultarPedidosPendientes();
    verEstadoCuentaPorFecha();
    verEstadoCuentaPorCliente();

    document.querySelector('form').addEventListener('submit', function (e) {
      e.preventDefault();
      const producto = {
        codigo: document.getElementById('codigoProducto').value,
        categoria: document.getElementById('categoria').value,
        nombre: document.getElementById('nombre').value,
        descripcion: document.getElementById('descripcionPaquete').value,
        moneda: document.getElementById('moneda').value,
        precio: document.getElementById('precio').value,
        stock: document.getElementById('stock').value
      };
      guardarProductoFirestore(producto);
      this.reset();
      toggleFormSection();
    });
  });
    


  function guardarProductoEnLocalStorage(producto) {
    const productos = JSON.parse(localStorage.getItem('productos')) || [];
    productos.push(producto);
    localStorage.setItem('productos', JSON.stringify(productos));
    listarProductos();
  }

  function listarProductos() {
    const productos = JSON.parse(localStorage.getItem('productos')) || [];
    const contenedor = document.getElementById('listaProductos');
    contenedor.innerHTML = '';
    if (productos.length === 0) {
      contenedor.innerHTML = `<tr><td colspan="5" style="text-align:center;"><img src='/mnt/data/A_digital_vector_graphic_displays_a_centered_messa.png' alt='No se encontraron imágenes' style='max-width:200px;margin:auto;' /></td></tr>`;
      return;
    }
    productos.forEach((p, i) => {
      const fila = document.createElement('tr');
      fila.innerHTML = `
        <td>${p.codigo}</td>
        <td>${p.nombre}</td>
        <td>${p.precio} ${p.moneda}</td>
        <td>${p.stock}</td>
        <td>
          <button class="btn btn-warning btn-small" onclick="editarProducto(${i})">Editar</button>
          <button class="btn btn-danger btn-small" onclick="eliminarProducto(${i})">Eliminar</button>
        </td>`;
      contenedor.appendChild(fila);
    });
  }

  function eliminarProducto(index) {
    let productos = JSON.parse(localStorage.getItem('productos')) || [];
    productos.splice(index, 1);
    localStorage.setItem('productos', JSON.stringify(productos));
    listarProductos();
  }

  function editarProducto(index) {
    const productos = JSON.parse(localStorage.getItem('productos')) || [];
    const p = productos[index];
    document.getElementById('codigoProducto').value = p.codigo;
    document.getElementById('categoria').value = p.categoria;
    document.getElementById('nombre').value = p.nombre;
    document.getElementById('descripcionPaquete').value = p.descripcion;
    document.getElementById('moneda').value = p.moneda;
    document.getElementById('precio').value = p.precio;
    document.getElementById('stock').value = p.stock;
    eliminarProducto(index);
    toggleFormSection();
  }

  document.addEventListener('DOMContentLoaded', () => {
    listarProductos();
    document.querySelector('form').addEventListener('submit', function (e) {
      e.preventDefault();
      const producto = {
        codigo: document.getElementById('codigoProducto').value,
        categoria: document.getElementById('categoria').value,
        nombre: document.getElementById('nombre').value,
        descripcion: document.getElementById('descripcionPaquete').value,
        moneda: document.getElementById('moneda').value,
        precio: document.getElementById('precio').value,
        stock: document.getElementById('stock').value
      };
      guardarProductoEnLocalStorage(producto);
      this.reset();
      toggleFormSection();
    });
  });


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
  }

  // Asignar eventos a los botones de pestaña al cargar la página
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.tab-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const tabId = this.getAttribute('data-tab');
        mostrarTab(tabId);
      });
    });

    // Verificar autenticación y rol
    const usuario = JSON.parse(localStorage.getItem('usuarioActivo'));
    if (!usuario || usuario.rol !== 'jefe') {
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
    // Aquí iría la lógica para cerrar sesión
    localStorage.removeItem('usuarioActivo');
    window.location.href = 'login.php';
  }

  function consultarPedidosDesdePHP() {
  fetch('consultar_pedidos.php')
    .then(response => response.json())
    .then(pedidos => {
      const tabla = document.getElementById('tablaPedidosPendientes');
      tabla.innerHTML = '';

      if (pedidos.length === 0) {
        tabla.innerHTML = `<tr><td colspan="7" style="text-align:center;">No hay pedidos disponibles.</td></tr>`;
        return;
      }

      pedidos.forEach(p => {
        const fila = document.createElement('tr');
        const badge = p.estado === 'confirmada' ? 'status-delivered' : 
                      p.estado === 'cancelada' ? 'status-cancelled' : 
                      'status-pending';

        fila.innerHTML = `
          <td>#ORD-${p.id}</td>
          <td>${p.cliente}</td>
          <td>${p.paquete}</td>
          <td>${new Date(p.fecha_reserva).toLocaleDateString()}</td>
          <td>$${p.precio}</td>
          <td><span class="status-badge ${badge}">${p.estado}</span></td>
          <td>
            ${p.estado === 'pendiente' ? `
              <button onclick="entregarPedido(${p.id})" class="btn btn-success btn-small">✔ Entregar</button>
              <button onclick="anularPedido(${p.id})" class="btn btn-danger btn-small">✘ Anular</button>
            ` : `<button class="btn btn-info btn-small">📄 Factura</button>`}
          </td>
        `;
        tabla.appendChild(fila);
      });
    })
    .catch(error => {
      console.error('Error al cargar pedidos:', error);
    });
}
document.addEventListener('DOMContentLoaded', () => {
  consultarPedidosDesdePHP();
});

function entregarPedido(id) {
  fetch('actualizar_pedido.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: id, estado: 'entregado' })
  })
  .then(res => res.json())
  .then(() => consultarPedidosDesdePHP());
}

function anularPedido(id) {
  fetch('actualizar_pedido.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: id, estado: 'anulado' })
  })
  .then(res => res.json())
  .then(() => consultarPedidosDesdePHP());
}


</script>
<!-- Antes del cierre de </body> -->
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
<script src="firebase-config.js"></script>
<script src="panel-jefe.js"></script>
</body>
</html>
