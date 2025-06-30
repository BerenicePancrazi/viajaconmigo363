<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cliente - Viaja Conmigo</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
  font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #8F6ACA 0%, #8F6ACA 100%);
  min-height: 100vh;
}

    header {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      padding: 1rem 2rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header h1 {
      color: #331353;
      font-size: 1.8rem;
      font-weight: 700;
    }

    .header-controls {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .nav-tabs {
      display: flex;
      background: rgba(255, 255, 255, 0.9);
      margin: 2rem;
      border-radius: 12px;
      padding: 0.5rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .nav-tab {
      flex: 1;
      padding: 1rem 2rem;
      text-align: center;
      cursor: pointer;
      border-radius: 8px;
      transition: all 0.3s ease;
      font-weight: 500;
    }

    .nav-tab.active {
      background: #331353;
      color: white;
      box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .nav-tab:hover:not(.active) {
      background: rgba(79, 70, 229, 0.1);
    }

    .tab-content {
      display: none;
      padding: 2rem;
    }

    .tab-content.active {
      display: block;
    }

    /* Filtros mejorados */
    .filtros-container {
      background: white;
      border-radius: 16px;
      padding: 2rem;
      margin-bottom: 2rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .filtros-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .filtro-grupo {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .filtro-grupo label {
      font-weight: 600;
      color: #374151;
      font-size: 0.9rem;
    }

    .filtro-input, .filtro-select {
      padding: 0.75rem;
      border: 2px solid #e5e7eb;
      border-radius: 8px;
      font-size: 0.9rem;
      transition: border-color 0.3s ease;
    }

    .filtro-input:focus, .filtro-select:focus {
      outline: none;
      border-color: #331353;
    }

    .categoria-selector {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .categoria-btn {
      padding: 1rem 2rem;
      border: 2px solid #e5e7eb;
      border-radius: 20px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 0.8rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .categoria-btn.active {
      border-color: #331353;
      background: #331353;
      color: white;
    }

    .categoria-btn:hover:not(.active) {
      border-color: #331353;
      background: rgba(79, 70, 229, 0.1);
    }

    /* Ordenamiento */
    .ordenamiento-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: white;
      padding: 1rem 2rem;
      border-radius: 12px;
      margin-bottom: 2rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .resultados-info {
      color: #6b7280;
      font-weight: 500;
    }

    .ordenar-select {
      padding: 0.5rem 1rem;
      border: 2px solid #e5e7eb;
      border-radius: 8px;
      background: white;
      cursor: pointer;
    }

    /* Grid de paquetes */
    .paquetes-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 2rem;
      padding: 2rem 0;
    }

    .preview-card {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
      transition: all 0.3s ease;
      position: relative;
    }

    .preview-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .preview-image {
      position: relative;
      height: 200px;
      overflow: hidden;
    }

    .preview-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .preview-card:hover .preview-image img {
      transform: scale(1.1);
    }

    .preview-content {
      padding: 1.5rem;
    }

    .preview-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: #1f2937;
      margin-bottom: 0.5rem;
    }

    .preview-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      margin-bottom: 1rem;
    }

    .preview-meta span {
      background: #f3f4f6;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.8rem;
      color: #6b7280;
    }

    .preview-description {
      color: #6b7280;
      font-size: 0.9rem;
      line-height: 1.5;
      margin-bottom: 1rem;
    }

    .preview-price {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }

    .price-tag {
      font-size: 1.5rem;
      font-weight: 700;
      color: #8F6ACA;
    }

    .preview-badge {
      background: #10b981;
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.8rem;
    }

    .btn {
      width: 100%;
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .btn-primary {
      background: linear-gradient(135deg, #331353, #7c3aed);
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }

    /* Carrito de compras */
    .cart-container {
      max-width: 1200px;
      margin: 0 auto;
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
      overflow: hidden;
    }

    .cart-header {
      background: linear-gradient(135deg, #331353, #7c3aed);
      color: white;
      padding: 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .cart-header h2 {
      font-size: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .cart-items {
      padding: 2rem;
    }

    .cart-item {
      display: flex;
      gap: 1rem;
      padding: 1rem;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      margin-bottom: 1rem;
      transition: all 0.3s ease;
    }

    .cart-item:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .item-image {
      width: 80px;
      height: 80px;
      border-radius: 8px;
      object-fit: cover;
    }

    .item-details {
      flex: 1;
    }

    .item-title {
      font-weight: 600;
      color: #1f2937;
      margin-bottom: 0.5rem;
    }

    .item-price {
      color: #331353;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .item-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .quantity-control {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      background: #f3f4f6;
      border-radius: 8px;
      padding: 0.25rem;
    }

    .btn-quantity {
      width: 30px;
      height: 30px;
      border: none;
      background: white;
      border-radius: 4px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
    }

    .btn-quantity:hover {
      background: #331353;
      color: white;
    }

    .quantity {
      font-weight: 600;
      min-width: 30px;
      text-align: center;
    }

    .btn-remove {
      background: #ef4444;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      cursor: pointer;
      font-size: 0.8rem;
      transition: all 0.3s ease;
    }

    .btn-remove:hover {
      background: #dc2626;
    }

    .cart-summary {
      background: #f9fafb;
      padding: 2rem;
      border-top: 1px solid #e5e7eb;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.5rem;
      padding: 0.5rem 0;
    }

    .summary-total {
      border-top: 2px solid #331353;
      font-weight: 700;
      font-size: 1.2rem;
      color: #331353;
    }

    .cart-actions {
      display: flex;
      gap: 1rem;
      padding: 2rem;
    }

    .btn-continue {
      background: #6b7280;
      color: white;
      flex: 1;
    }

    .btn-checkout {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      flex: 2;
    }

    .empty-cart {
      text-align: center;
      padding: 4rem 2rem;
      color: #6b7280;
    }

    .empty-cart i {
      font-size: 4rem;
      margin-bottom: 1rem;
      opacity: 0.5;
    }

    /* Formulario de checkout */
    .checkout-form {
      background: white;
      border-radius: 16px;
      padding: 2rem;
      margin-bottom: 2rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .form-section {
      margin-bottom: 2rem;
    }

    .form-section h3 {
      color: #1f2937;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .form-group label {
      font-weight: 600;
      color: #374151;
    }

    .form-control {
      padding: 0.75rem;
      border: 2px solid #e5e7eb;
      border-radius: 8px;
      font-size: 0.9rem;
      transition: border-color 0.3s ease;
    }

    .form-control:focus {
      outline: none;
      border-color: #331353;
    }

    .payment-methods {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .payment-method {
      flex: 1;
      padding: 1rem;
      border: 2px solid #e5e7eb;
      border-radius: 8px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .payment-method.selected {
      border-color: #331353;
      background: rgba(79, 70, 229, 0.1);
    }

    .payment-method i {
      font-size: 2rem;
      margin-bottom: 0.5rem;
      color: #331353;
    }

    /* Comprobante de compra */
    .comprobante {
      background: white;
      border-radius: 16px;
      padding: 2rem;
      margin: 2rem auto;
      max-width: 600px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .comprobante-header {
      text-align: center;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid #e5e7eb;
    }

    .comprobante-number {
      color: #331353;
      font-weight: 700;
      font-size: 1.2rem;
    }

    .comprobante-fecha {
      color: #6b7280;
      margin-top: 0.5rem;
    }

    .comprobante-section {
      margin-bottom: 1.5rem;
    }

    .comprobante-section h4 {
      color: #1f2937;
      margin-bottom: 0.5rem;
      font-size: 1rem;
    }

    .comprobante-item {
      display: flex;
      justify-content: space-between;
      padding: 0.5rem 0;
      border-bottom: 1px solid #f3f4f6;
    }

    .comprobante-total {
      border-top: 2px solid #331353;
      padding-top: 1rem;
      margin-top: 1rem;
      font-weight: 700;
      font-size: 1.2rem;
      color: #331353;
    }

    /* Historial de compras */
    .history-container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .history-item {
      background: white;
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 1rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .history-item:hover {
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    }

    .history-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }

    .history-number {
      font-weight: 700;
      color: #331353;
    }

    .history-date {
      color: #6b7280;
      font-size: 0.9rem;
    }

    .history-status {
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }

    .status-completado {
      background: #d1fae5;
      color: #065f46;
    }

    .status-pendiente {
      background: #fef3c7;
      color: #92400e;
    }

    .history-items {
      margin-bottom: 1rem;
    }

    .history-total {
      text-align: right;
      font-weight: 700;
      color: #331353;
      font-size: 1.1rem;
    }

    .btn-logout {
      background: #ef4444;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      cursor: pointer;
    }

    .moneda-selector {
      padding: 0.5rem;
      border: 1px solid #e5e7eb;
      border-radius: 6px;
    }

    #nombreUsuario {
      color: #331353;
      font-weight: 600;
    }

    @media (max-width: 768px) {
      .nav-tabs {
        flex-direction: column;
        margin: 1rem;
      }

      .paquetes-grid {
        grid-template-columns: 1fr;
        padding: 1rem;
      }

      .cart-actions {
        flex-direction: column;
      }

      .form-row {
        grid-template-columns: 1fr;
      }

      header {
        padding: 1rem;
        flex-direction: column;
        gap: 1rem;
      }

      .filtros-grid {
        grid-template-columns: 1fr;
      }

      .ordenamiento-container {
        flex-direction: column;
        gap: 1rem;
      }
    }

    /* Animaciones */
    .preview-card {
      animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Toast notification styles */
    .toast {
      position: fixed;
      top: 20px;
      right: 20px;
      background: #10b981;
      color: white;
      padding: 1rem 1.5rem;
      border-radius: 8px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      z-index: 10000;
      transform: translateX(400px);
      transition: transform 0.3s ease;
    }

    .toast.show {
      transform: translateX(0);
    }

    .toast.error {
      background: #ef4444;
    }
  </style>
</head>
<body>
  <header> 
    <h1><i class="fas fa-suitcase-rolling"></i> Viaja Conmigo</h1>
    <div class="header-controls">
      <span id="nombreUsuario">Bienvenido, Cliente</span>
      <select id="selectorMoneda" class="moneda-selector">
        <option value="USD">USD $</option>
        <option value="EUR">EUR €</option>
        <option value="MXN">MXN $</option>
        <option value="COP">COP $</option>
      </select>
      <button id="btnLogout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
    </div>
  </header>

  <main>
    <div class="nav-tabs">
      <div class="nav-tab active" data-tab="explorar">Explorar Servicios</div>
      <div class="nav-tab" data-tab="cart">Carrito de Compras (<span id="cart-count">0</span>)</div>
      <div class="nav-tab" data-tab="checkout">Proceso de Compra</div>
      <div class="nav-tab" data-tab="history">Historial de Compras</div>
    </div>
    
    <!-- Explorar Servicios -->
    <div id="explorar" class="tab-content active">
      <div class="contenido">
        <!-- Filtros Avanzados -->
        <div class="filtros-container">
          <div class="filtros-header">
            <h2><i class="fas fa-filter"></i> Filtros de Búsqueda</h2>
          </div>
          
          <div class="filtros-grid">
            <div class="filtro-grupo">
              <label><i class="fas fa-layer-group"></i> Tipo de Servicio</label>
              <div class="categoria-selector">
                <div class="categoria-btn active" data-categoria="todos">
                  <i class="fas fa-globe"></i>
                  <span>Todos</span>
                </div>
                <div class="categoria-btn" data-categoria="paquete">
                  <i class="fas fa-suitcase"></i>
                  <span>Paquetes</span>
                </div>
                <div class="categoria-btn" data-categoria="actividad">
                  <i class="fas fa-hiking"></i>
                  <span>Actividades</span>
                </div>
                <div class="categoria-btn" data-categoria="hospedaje">
                  <i class="fas fa-hotel"></i>
                  <span>Hospedajes</span>
                </div>
                <div class="categoria-btn" data-categoria="auto">
                  <i class="fas fa-car"></i>
                  <span>Alquiler</span>
                </div>
              </div>
            </div>
            
            <div class="filtro-grupo">
              <label><i class="fas fa-search"></i> Buscar Destino</label>
              <input type="text" id="filtroDestino" class="filtro-input" placeholder="Ej: París, Bali, Roma...">
            </div>
            
            <div class="filtro-grupo">
              <label><i class="fas fa-money-bill-wave"></i> Precio Mínimo</label>
              <input type="number" id="filtroPrecioMin" class="filtro-input" placeholder="$0" min="0">
            </div>
            
            <div class="filtro-grupo">
              <label><i class="fas fa-money-bill-wave"></i> Precio Máximo</label>
              <input type="number" id="filtroPrecioMax" class="filtro-input" placeholder="Sin límite" min="0">
            </div>
            
            <div class="filtro-grupo">
              <label><i class="fas fa-calendar-day"></i> Duración Mínima</label>
              <input type="number" id="filtroDuracionMin" class="filtro-input" placeholder="Días" min="1">
            </div>
          </div>
          
          <div style="display: flex; gap: 1rem; margin-top: 1rem;">
            <button class="btn btn-primary" id="btnFiltrar" style="flex: 1;">
              <i class="fas fa-filter"></i> Aplicar Filtros
            </button>
            <button class="btn" id="btnLimpiar" style="flex: 1; background: #6b7280; color: white;">
              <i class="fas fa-broom"></i> Limpiar Filtros
            </button>
          </div>
        </div>

        <!-- Ordenamiento -->
        <div class="ordenamiento-container">
          <div class="resultados-info" id="contadorResultados">
            Mostrando todos los servicios
          </div>
          <div>
            <label>Ordenar por: </label>
            <select class="ordenar-select" id="ordenarSelect">
              <option value="nombre">Nombre (A-Z)</option>
              <option value="nombre-desc">Nombre (Z-A)</option>
              <option value="precio-asc">Precio: Menor a Mayor</option>
              <option value="precio-desc">Precio: Mayor a Menor</option>
              <option value="duracion-asc">Duración: Corto a Largo</option>
              <option value="duracion-desc">Duración: Largo a Corto</option>
            </select>
          </div>
        </div>

        <!-- Grid de Paquetes -->
        <div class="paquetes-grid">
          <?php
          $sql = "SELECT * FROM paquetes";
          $result = $conexion->query($sql);

          if ($result && $result->num_rows > 0) {
              while($fila = $result->fetch_assoc()) {
                  echo "<div class='preview-card' data-categoria='" . htmlspecialchars($fila['categoria']) . "' data-id='" . $fila['id'] . "' data-nombre='" . htmlspecialchars($fila['nombre']) . "' data-precio='" . $fila['precio'] . "' data-duracion='" . htmlspecialchars($fila['duracion']) . "'>";

                  // Imagen principal del paquete
                  echo "<div class='preview-image'>";
                  /*if (!empty($fila['imagen'])) {
                      echo "<img src='imagen/" . htmlspecialchars($fila['imagen']) . "' alt='" . htmlspecialchars($fila['nombre']) . "'>";
                  } else {
                      echo "<img src='https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=400&h=250&fit=crop' alt='" . htmlspecialchars($fila['nombre']) . "'>";
                  }*/
                if (!empty($fila['portada'])) {
                   echo "<img src='http://localhost/viaje2606/viaje/" . htmlspecialchars($fila['portada']) . "' alt='" . htmlspecialchars($fila['nombre']) . "'>";
                } 

                  echo "</div>";

                  echo "<div class='preview-content'>";
                  echo "<div class='preview-title'>" . htmlspecialchars($fila['nombre']) . "</div>";

                  echo "<div class='preview-meta'>";
                  echo "<span><i class='fas fa-tag'></i> " . htmlspecialchars($fila['categoria']) . "</span>";
                  echo "<span><i class='fas fa-calendar-day'></i> " . htmlspecialchars($fila['duracion']) . " días</span>";
                  echo "<span><i class='fas fa-building'></i> " . htmlspecialchars($fila['proveedor']) . "</span>";
                  echo "</div>";

                  echo "<div class='preview-description'>" . htmlspecialchars($fila['descripcion']) . "</div>";

                  echo "<div class='preview-price'>";
                  echo "<div class='price-tag'>$" . number_format($fila['precio'], 2) . "</div>";
                  echo "<div class='preview-badge'>Disponible</div>";
                  echo "</div>";
                 echo "<button class='btn' onclick='agregarAlCarrito(" . $fila['id'] . ")'><i class='fas fa-cart-plus'></i> Añadir al Carrito</button>";



                  echo "</div></div>";
              }
          } else {
              echo "<p>No hay paquetes disponibles.</p>";
          }
          $conexion->close();
          ?>
        </div>
      </div>
    </div>
    
    <!-- Carrito de Compras -->
    <div id="cart" class="tab-content">
      <div class="cart-container">
        <div class="cart-header">
          <h2><i class="fas fa-shopping-cart"></i> Tu Carrito</h2>
          <span id="cart-items-count">0 servicios seleccionados</span>
        </div>
        
        <div class="cart-items" id="carritoContenido">
          <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h3>Tu carrito está vacío</h3>
            <p>Explora nuestros servicios y añade los que más te gusten</p>
          </div>
        </div>
        
        <div class="cart-summary" id="cartSummary" style="display: none;">
          <div class="summary-row">
            <span>Subtotal:</span>
            <span id="cart-subtotal">$0.00</span>
          </div>
          <div class="summary-row">
            <span>Impuestos (10%):</span>
            <span id="cart-taxes">$0.00</span>
          </div>
          <div class="summary-row summary-total">
            <span>Total:</span>
            <span id="cart-total">$0.00</span>
          </div>
        </div>
        
        <div class="cart-actions" id="cartActions" style="display: none;">
          <button class="btn btn-continue" onclick="cambiarPestana('explorar')">
            <i class="fas fa-arrow-left"></i> Seguir Explorando
          </button>
          <button class="btn btn-checkout" onclick="cambiarPestana('checkout')">
            <i class="fas fa-credit-card"></i> Proceder al Pago
          </button>
        </div>
      </div>
    </div>
    
    <!-- Proceso de Compra -->
    <div id="checkout" class="tab-content">
      <div class="cart-container">
        <div class="cart-header">
          <h2><i class="fas fa-credit-card"></i> Finalizar Compra</h2>
        </div>
        
        <div class="checkout-form">
          <div class="form-section">
            <h3><i class="fas fa-user"></i> Información Personal</h3>
            <div class="form-row">
              <div class="form-group">
                <label>Nombre *</label>
                <input type="text" class="form-control" id="nombre" placeholder="Nombre" required>
              </div>
              <div class="form-group">
                <label>Segundo Nombre</label>
                <input type="text" class="form-control" id="segundoNombre" placeholder="Segundo nombre">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Apellido *</label>
                <input type="text" class="form-control" id="apellido" placeholder="Apellido" required>
              </div>
              <div class="form-group">
                <label>DNI/Cédula *</label>
                <input type="text" class="form-control" id="dni" placeholder="Número de identificación" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Email *</label>
                <input type="email" class="form-control" id="email" placeholder="correo@email.com" required>
              </div>
              <div class="form-group">
                <label>Teléfono *</label>
                <input type="tel" class="form-control" id="telefono" placeholder="+1 234 567 890" required>
              </div>
            </div>
          </div>
          
          <div class="form-section">
            <h3><i class="fas fa-map-marker-alt"></i> Dirección</h3>
            <div class="form-row">
              <div class="form-group" style="grid-column: 1 / -1;">
                <label>Dirección Completa *</label>
                <input type="text" class="form-control" id="direccion" placeholder="Calle, número, apartamento" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Ciudad *</label>
                <input type="text" class="form-control" id="ciudad" placeholder="Ciudad" required>
              </div>
              <div class="form-group">
                <label>Código Postal *</label>
                <input type="text" class="form-control" id="codigoPostal" placeholder="Código postal" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>País *</label>
                <select class="form-control" id="pais" required>
                  <option value="">Seleccionar país</option>
                  <option value="España">España</option>
                  <option value="México">México</option>
                  <option value="Argentina">Argentina</option>
                  <option value="Colombia">Colombia</option>
                  <option value="Estados Unidos">Estados Unidos</option>
                  <option value="Chile">Chile</option>
                  <option value="Perú">Perú</option>
                </select>
              </div>
              <div class="form-group">
                <label>Estado/Región</label>
                <input type="text" class="form-control" id="estado" placeholder="Estado o región">
              </div>
            </div>
          </div>
          
          <div class="form-section">
            <h3><i class="fas fa-credit-card"></i> Método de Pago</h3>
            <div class="payment-methods">
              <div class="payment-method selected" data-method="credit">
                <i class="fab fa-cc-visa"></i>
                <div>Tarjeta de Crédito</div>
              </div>
              <div class="payment-method" data-method="debit">
                <i class="fab fa-cc-mastercard"></i>
                <div>Tarjeta de Débito</div>
              </div>
              <div class="payment-method" data-method="paypal">
                <i class="fab fa-paypal"></i>
                <div>PayPal</div>
              </div>
              <div class="payment-method" data-method="transfer">
                <i class="fas fa-university"></i>
                <div>Transferencia</div>
              </div>
            </div>
            
            <div id="credit-form">
              <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                  <label>Nombre en la Tarjeta *</label>
                  <input type="text" class="form-control" id="nombreTarjeta" placeholder="Nombre como aparece en la tarjeta" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                  <label>Número de Tarjeta *</label>
                  <input type="text" class="form-control" id="numeroTarjeta" placeholder="1234 5678 9012 3456" maxlength="19" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label>Fecha de Expiración *</label>
                  <input type="text" class="form-control" id="fechaExpiracion" placeholder="MM/AA" maxlength="5" required>
                </div>
                <div class="form-group">
                  <label>CVV *</label>
                  <input type="text" class="form-control" id="cvv" placeholder="123" maxlength="4" required>
                </div>
              </div>
            </div>
          </div>
          
          <div class="form-section">
            <h3>Resumen de tu pedido</h3>
            <div id="checkout-items"></div>
            
            <div class="cart-summary">
              <div class="summary-row">
                <span>Subtotal:</span>
                <span id="checkout-subtotal">$0.00</span>
              </div>
              <div class="summary-row">
                <span>Impuestos (10%):</span>
                <span id="checkout-taxes">$0.00</span>
              </div>
              <div class="summary-row summary-total">
                <span>Total a pagar:</span>
                <span id="checkout-total">$0.00</span>
              </div>
            </div>
          </div>
          
          <div class="cart-actions">
            <button class="btn btn-continue" onclick="cambiarPestana('cart')">
              <i class="fas fa-arrow-left"></i> Volver al Carrito
            </button>
            <button class="btn btn-checkout" onclick="procesarPago()">
              <i class="fas fa-check"></i> Confirmar Compra
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Historial de Compras -->
    <div id="history" class="tab-content">
      <div class="history-container">
        <div class="cart-header">
          <h2><i class="fas fa-history"></i> Historial de Compras</h2>
        </div>
        
        <div id="history-content">
          <!-- El historial se cargará dinámicamente -->
        </div>
      </div>
    </div>

    <!-- Modal de Comprobante -->
    <div id="comprobanteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
      <div class="comprobante">
        <div class="comprobante-header">
          <h2><i class="fas fa-check-circle" style="color: #10b981;"></i> ¡Compra Exitosa! 
         </h2>
 
          <div class="comprobante-number">Comprobante #<span id="numeroComprobante"></span></div>
         
          <div class="comprobante-fecha" id="fechaComprobante"></div>
        </div>
        
        <div class="comprobante-section">
          <h4>Información del Cliente</h4>
          <div id="datosCliente"></div>
        </div>
        
        <div class="comprobante-section">
          <h4>Servicios Comprados</h4>
          <div id="serviciosComprados"></div>
        </div>
        
        <div class="comprobante-section">
          <h4>Detalles de Pago</h4>
          <div id="detallesPago"></div>
        </div>
        
        <div class="comprobante-total">
          <div style="display: flex; justify-content: space-between;">
            <span>Total Pagado:</span>
            <span id="totalPagado"></span>
          </div>
        </div>
        
        <div style="text-align: center; margin-top: 2rem;">
          <button class="btn btn-primary" onclick="cerrarComprobante()" style="margin-right: 1rem;">
            <i class="fas fa-times"></i> Cerrar
          </button>
          <button class="btn" onclick="imprimirComprobante()" style="background: #6b7280; color: white;">
            <i class="fas fa-print"></i> Imprimir
          </button>
        </div>
      </div>
    </div>

  </main>

  <script>
    // Variables globales
    let carrito = [];
    let categoriaSeleccionada = "todos";
    let monedaSeleccionada = "USD";
    let tasaCambio = 1;
    let historialCompras = [];

    // Tasas de cambio
    const tasasCambio = {
      USD: 1,
      EUR: 0.93,
      MXN: 16.80,
      COP: 3900
    };

    // Símbolos de moneda
    const simbolosMoneda = {
      USD: "$",
      EUR: "€",
      MXN: "$",
      COP: "$"
    };

    // Inicializar la aplicación
    document.addEventListener('DOMContentLoaded', () => {
      configurarEventListeners();
      cargarCarritoDesdeLocalStorage();
      cargarHistorialDesdeLocalStorage();
      actualizarCarrito();
      mostrarHistorial();
      configurarFiltrosEnTiempoReal();
    });

    // Configurar event listeners
    function configurarEventListeners() {
      // Cambio de moneda
      document.getElementById('selectorMoneda').addEventListener('change', cambiarMoneda);
      
      // Cerrar sesión
      document.getElementById('btnLogout').addEventListener('click', cerrarSesion);
      
      // Filtros
      document.getElementById('btnFiltrar').addEventListener('click', aplicarFiltros);
      document.getElementById('btnLimpiar').addEventListener('click', limpiarFiltros);
      
      // Ordenamiento
      document.getElementById('ordenarSelect').addEventListener('change', ordenarPaquetes);
      
      // Eventos para categorías
      document.querySelectorAll('.categoria-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          cambiarCategoria(btn.dataset.categoria);
        });
      });
      
      // Eventos para pestañas
      document.querySelectorAll('.nav-tab').forEach(tab => {
        tab.addEventListener('click', () => {
          cambiarPestana(tab.dataset.tab);
        });
      });
      
      // Eventos para métodos de pago
      document.querySelectorAll('.payment-method').forEach(method => {
        method.addEventListener('click', () => {
          document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
          method.classList.add('selected');
        });
      });
      
      // Formatear número de tarjeta
      const numeroTarjeta = document.getElementById('numeroTarjeta');
      if (numeroTarjeta) {
        numeroTarjeta.addEventListener('input', formatearNumeroTarjeta);
      }
      
      // Formatear fecha de expiración
      const fechaExpiracion = document.getElementById('fechaExpiracion');
      if (fechaExpiracion) {
        fechaExpiracion.addEventListener('input', formatearFechaExpiracion);
      }
    }

    // Configurar filtros en tiempo real
    function configurarFiltrosEnTiempoReal() {
      const filtroDestino = document.getElementById('filtroDestino');
      if (filtroDestino) {
        filtroDestino.addEventListener('input', () => {
          setTimeout(aplicarFiltros, 300);
        });
      }
      
      const filtroTipo = document.getElementById('filtroTipo');
      if (filtroTipo) {
        filtroTipo.addEventListener('change', aplicarFiltros);
      }
      
      const filtroPrecioMin = document.getElementById('filtroPrecioMin');
      if (filtroPrecioMin) {
        filtroPrecioMin.addEventListener('input', () => {
          setTimeout(aplicarFiltros, 500);
        });
      }
      
      const filtroPrecioMax = document.getElementById('filtroPrecioMax');
      if (filtroPrecioMax) {
        filtroPrecioMax.addEventListener('input', () => {
          setTimeout(aplicarFiltros, 500);
        });
      }
    }

    // Función principal para agregar al carrito
    function agregarAlCarrito(id, nombre, precio, imagen) {
      console.log('Agregando al carrito:', {id, nombre, precio, imagen});
      
      // Verificar si el producto ya existe en el carrito
      const existente = carrito.find(item => item.id === id);
      
      if (existente) {
        existente.cantidad++;
        mostrarToast(`Cantidad actualizada: ${nombre}`);
      } else {
        carrito.push({
          id: id,
          nombre: nombre,
          precio: precio,
          imagen: imagen || 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=80&h=80&fit=crop',
          cantidad: 1
        });
        mostrarToast(`¡${nombre} añadido al carrito!`);
      }
      
      actualizarCarrito();
      guardarCarritoEnLocalStorage();
    }

    // Actualizar vista del carrito
    function actualizarCarrito() {
      const carritoContenido = document.getElementById('carritoContenido');
      const cartSummary = document.getElementById('cartSummary');
      const cartActions = document.getElementById('cartActions');
      const cartCount = document.getElementById('cart-count');
      const cartItemsCount = document.getElementById('cart-items-count');
      
      // Actualizar contador en la pestaña
      const totalItems = carrito.reduce((sum, item) => sum + item.cantidad, 0);
      cartCount.textContent = totalItems;
      cartItemsCount.textContent = `${totalItems} servicio${totalItems !== 1 ? 's' : ''} seleccionado${totalItems !== 1 ? 's' : ''}`;
      
      if (carrito.length === 0) {
        carritoContenido.innerHTML = `
          <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h3>Tu carrito está vacío</h3>
            <p>Explora nuestros servicios y añade los que más te gusten</p>
          </div>
        `;
        cartSummary.style.display = 'none';
        cartActions.style.display = 'none';
        return;
      }
      
      // Mostrar elementos del carrito
      carritoContenido.innerHTML = '';
      let subtotal = 0;
      
      carrito.forEach(item => {
        const precioConvertido = item.precio * tasaCambio;
        const itemTotal = precioConvertido * item.cantidad;
        subtotal += itemTotal;
        
        const itemDiv = document.createElement('div');
        itemDiv.className = 'cart-item';
        itemDiv.innerHTML = `
          <img src="${item.imagen.includes('imagen/') ? item.imagen : 'imagen/' + item.imagen}" 
               class="item-image" alt="${item.nombre}" 
               onerror="this.src='https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=80&h=80&fit=crop'">
          <div class="item-details">
            <div class="item-title">${item.nombre}</div>
            <div class="item-price">${simbolosMoneda[monedaSeleccionada]}${precioConvertido.toFixed(2)} c/u</div>
            <div class="item-actions">
              <div class="quantity-control">
                <button class="btn-quantity" onclick="modificarCantidad(${item.id}, -1)">-</button>
                <span class="quantity">${item.cantidad}</span>
                <button class="btn-quantity" onclick="modificarCantidad(${item.id}, 1)">+</button>
              </div>
              <button class="btn-remove" onclick="eliminarDelCarrito(${item.id})">
                <i class="fas fa-trash"></i> Eliminar
              </button>
            </div>
          </div>
        `;
        carritoContenido.appendChild(itemDiv);
      });
      
      // Calcular impuestos y total
      const impuestos = subtotal * 0.1;
      const total = subtotal + impuestos;
      
      // Actualizar resumen
      document.getElementById('cart-subtotal').textContent = `${simbolosMoneda[monedaSeleccionada]}${subtotal.toFixed(2)}`;
      document.getElementById('cart-taxes').textContent = `${simbolosMoneda[monedaSeleccionada]}${impuestos.toFixed(2)}`;
      document.getElementById('cart-total').textContent = `${simbolosMoneda[monedaSeleccionada]}${total.toFixed(2)}`;
      
      // Actualizar checkout
      actualizarCheckout();
      
      // Mostrar resumen y acciones
      cartSummary.style.display = 'block';
      cartActions.style.display = 'flex';
    }

    // Modificar cantidad en carrito
    function modificarCantidad(idPaquete, cambio) {
      const item = carrito.find(item => item.id === idPaquete);
      if (item) {
        item.cantidad += cambio;
        if (item.cantidad < 1) {
          eliminarDelCarrito(idPaquete);
          return;
        }
        actualizarCarrito();
        guardarCarritoEnLocalStorage();
      }
    }

    // Eliminar del carrito
    function eliminarDelCarrito(idPaquete) {
      const index = carrito.findIndex(item => item.id === idPaquete);
      if (index !== -1) {
        const item = carrito[index];
        carrito.splice(index, 1);
        mostrarToast(`${item.nombre} eliminado del carrito`);
        actualizarCarrito();
        guardarCarritoEnLocalStorage();
      }
    }

    // Actualizar vista de checkout
    function actualizarCheckout() {
      const checkoutItems = document.getElementById('checkout-items');
      const checkoutSubtotal = document.getElementById('checkout-subtotal');
      const checkoutTaxes = document.getElementById('checkout-taxes');
      const checkoutTotal = document.getElementById('checkout-total');
      
      if (!checkoutItems) return;
      
      if (carrito.length === 0) {
        checkoutItems.innerHTML = '<p>No hay productos en el carrito</p>';
        if (checkoutSubtotal) checkoutSubtotal.textContent = `${simbolosMoneda[monedaSeleccionada]}0.00`;
        if (checkoutTaxes) checkoutTaxes.textContent = `${simbolosMoneda[monedaSeleccionada]}0.00`;
        if (checkoutTotal) checkoutTotal.textContent = `${simbolosMoneda[monedaSeleccionada]}0.00`;
        return;
      }
      
      checkoutItems.innerHTML = '';
      let subtotal = 0;
      
      carrito.forEach(item => {
        const precioConvertido = item.precio * tasaCambio;
        const itemTotal = precioConvertido * item.cantidad;
        subtotal += itemTotal;
        
        const itemDiv = document.createElement('div');
        itemDiv.className = 'cart-item';
        itemDiv.innerHTML = `
          <img src="${item.imagen.includes('imagen/') ? item.imagen : 'imagen/' + item.imagen}" 
               class="item-image" alt="${item.nombre}"
               onerror="this.src='https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=80&h=80&fit=crop'">
          <div class="item-details">
            <div class="item-title">${item.nombre}</div>
            <div class="item-price">${simbolosMoneda[monedaSeleccionada]}${precioConvertido.toFixed(2)} x ${item.cantidad} = ${simbolosMoneda[monedaSeleccionada]}${itemTotal.toFixed(2)}</div>
          </div>
        `;
        checkoutItems.appendChild(itemDiv);
      });
      
      const impuestos = subtotal * 0.1;
      const total = subtotal + impuestos;
      
      if (checkoutSubtotal) checkoutSubtotal.textContent = `${simbolosMoneda[monedaSeleccionada]}${subtotal.toFixed(2)}`;
      if (checkoutTaxes) checkoutTaxes.textContent = `${simbolosMoneda[monedaSeleccionada]}${impuestos.toFixed(2)}`;
      if (checkoutTotal) checkoutTotal.textContent = `${simbolosMoneda[monedaSeleccionada]}${total.toFixed(2)}`;
    }

    // Aplicar filtros
    function aplicarFiltros() {
      const destino = document.getElementById('filtroDestino').value.toLowerCase();
      const tipo = document.getElementById('filtroTipo').value;
      const precioMin = parseFloat(document.getElementById('filtroPrecioMin').value) || 0;
      const precioMax = parseFloat(document.getElementById('filtroPrecioMax').value) || Infinity;
      const duracionMin = parseInt(document.getElementById('filtroDuracionMin').value) || 0;
      
      const paquetes = document.querySelectorAll('.preview-card');
      let visibles = 0;
      
      paquetes.forEach(paquete => {
        const nombre = paquete.dataset.nombre.toLowerCase();
        const categoria = paquete.dataset.categoria;
        const precio = parseFloat(paquete.dataset.precio);
        const duracion = parseInt(paquete.dataset.duracion) || 0;
        
        let mostrar = true;
        
        // Filtro por categoría
        if (categoriaSeleccionada !== "todos" && categoria !== categoriaSeleccionada) {
          mostrar = false;
        }
        
        // Filtro por destino
        if (destino && !nombre.includes(destino)) {
          mostrar = false;
        }
        
        // Filtro por precio
        if (precio < precioMin || precio > precioMax) {
          mostrar = false;
        }
        
        // Filtro por duración
        if (duracion < duracionMin) {
          mostrar = false;
        }
        
        if (mostrar) {
          paquete.style.display = 'block';
          visibles++;
        } else {
          paquete.style.display = 'none';
        }
      });
      
      // Actualizar contador
      document.getElementById('contadorResultados').textContent = 
        `Mostrando ${visibles} servicio${visibles !== 1 ? 's' : ''}`;
    }

    // Limpiar filtros
    function limpiarFiltros() {
      document.getElementById('filtroDestino').value = '';
      document.getElementById('filtroTipo').value = '';
      document.getElementById('filtroPrecioMin').value = '';
      document.getElementById('filtroPrecioMax').value = '';
      document.getElementById('filtroDuracionMin').value = '';
      
      // Restablecer categoría
      document.querySelectorAll('.categoria-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      document.querySelector('.categoria-btn[data-categoria="todos"]').classList.add('active');
      categoriaSeleccionada = "todos";
      
      // Mostrar todos los paquetes
      document.querySelectorAll('.preview-card').forEach(paquete => {
        paquete.style.display = 'block';
      });
      
      // Actualizar contador
      const totalPaquetes = document.querySelectorAll('.preview-card').length;
      document.getElementById('contadorResultados').textContent = 
        `Mostrando ${totalPaquetes} servicio${totalPaquetes !== 1 ? 's' : ''}`;
    }

    // Ordenar paquetes
    function ordenarPaquetes() {
      const criterio = document.getElementById('ordenarSelect').value;
      const grid = document.querySelector('.paquetes-grid');
      const paquetes = Array.from(grid.children);
      
      paquetes.sort((a, b) => {
        switch(criterio) {
          case 'nombre':
            return a.dataset.nombre.localeCompare(b.dataset.nombre);
          case 'nombre-desc':
            return b.dataset.nombre.localeCompare(a.dataset.nombre);
          case 'precio-asc':
            return parseFloat(a.dataset.precio) - parseFloat(b.dataset.precio);
          case 'precio-desc':
            return parseFloat(b.dataset.precio) - parseFloat(a.dataset.precio);
          case 'duracion-asc':
            return parseInt(a.dataset.duracion) - parseInt(b.dataset.duracion);
          case 'duracion-desc':
            return parseInt(b.dataset.duracion) - parseInt(a.dataset.duracion);
          default:
            return 0;
        }
      });
      
      // Reordenar elementos en el DOM
      paquetes.forEach(paquete => grid.appendChild(paquete));
    }

    // Cambiar categoría
    function cambiarCategoria(categoria) {
      categoriaSeleccionada = categoria;
      document.querySelectorAll('.categoria-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      document.querySelector(`.categoria-btn[data-categoria="${categoria}"]`).classList.add('active');
      aplicarFiltros();
    }

    // Cambiar moneda
    function cambiarMoneda() {
      monedaSeleccionada = document.getElementById('selectorMoneda').value;
      tasaCambio = tasasCambio[monedaSeleccionada] || 1;
      actualizarCarrito();
    }

    // Cambiar pestañas
    function cambiarPestana(pestanaId) {
      // Remover clase activa
      document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
      
      // Añadir clase activa
      document.querySelector(`.nav-tab[data-tab="${pestanaId}"]`).classList.add('active');
      document.getElementById(pestanaId).classList.add('active');
      
      // Actualizar carrito si es necesario
      if (pestanaId === 'cart' || pestanaId === 'checkout') {
        actualizarCarrito();
      }
      
      if (pestanaId === 'history') {
        mostrarHistorial();
      }
    }

    // Procesar pago
    function procesarPago() {
      if (carrito.length === 0) {
        mostrarToast('El carrito está vacío', 'error');
        return;
      }
      
      // Validar campos requeridos
      const camposRequeridos = [
        'nombre', 'apellido', 'dni', 'email', 'telefono',
        'direccion', 'ciudad', 'codigoPostal', 'pais',
        'nombreTarjeta', 'numeroTarjeta', 'fechaExpiracion', 'cvv'
      ];
      
      for (let campo of camposRequeridos) {
        const elemento = document.getElementById(campo);
        if (!elemento || !elemento.value.trim()) {
          mostrarToast(`Por favor completa el campo: ${campo}`, 'error');
          elemento?.focus();
          return;
        }
      }
      
      // Calcular totales
      const subtotal = carrito.reduce((sum, item) => sum + (item.precio * item.cantidad * tasaCambio), 0);
      const impuestos = subtotal * 0.1;
      const total = subtotal + impuestos;
      
      // Crear comprobante
      const comprobante = {
        numero: generateUniqueId(),
        fecha: new Date().toLocaleDateString(),
        cliente: {
          nombre: document.getElementById('nombre').value,
          segundoNombre: document.getElementById('segundoNombre').value,
          apellido: document.getElementById('apellido').value,
          dni: document.getElementById('dni').value,
          email: document.getElementById('email').value,
          telefono: document.getElementById('telefono').value,
          direccion: document.getElementById('direccion').value,
          ciudad: document.getElementById('ciudad').value,
          codigoPostal: document.getElementById('codigoPostal').value,
          pais: document.getElementById('pais').value
        },
        servicios: [...carrito],
        metodoPago: document.querySelector('.payment-method.selected').textContent.trim(),
        subtotal: subtotal,
        impuestos: impuestos,
        total: total,
        moneda: monedaSeleccionada
      };
      
      // Agregar al historial
      historialCompras.unshift(comprobante);
      guardarHistorialEnLocalStorage();
      
      // Mostrar comprobante
      mostrarComprobante(comprobante);
      
      // Limpiar carrito
      carrito = [];
      actualizarCarrito();
      guardarCarritoEnLocalStorage();
      
      mostrarToast('Estimado/a cliente, Su compra ha sido exitosa y se ha registrado correctamente en nuestro sistema. Por favor, revise su bandeja de entrada de Gmail (o el correo que haya registrado) para encontrar el comprobante y más detalles. Muchas gracias por confiar en nosotros.Saludos cordiales,Viaja conmigo ');
    }

    // Mostrar comprobante
    function mostrarComprobante(comprobante) {
      document.getElementById('numeroComprobante').textContent = comprobante.numero;
      document.getElementById('fechaComprobante').textContent = comprobante.fecha;
      
      // Datos del cliente
      const datosCliente = document.getElementById('datosCliente');
      datosCliente.innerHTML = `
        <p><strong>Nombre:</strong> ${comprobante.cliente.nombre} ${comprobante.cliente.segundoNombre} ${comprobante.cliente.apellido}</p>
        <p><strong>DNI:</strong> ${comprobante.cliente.dni}</p>
        <p><strong>Email:</strong> ${comprobante.cliente.email}</p>
        <p><strong>Teléfono:</strong> ${comprobante.cliente.telefono}</p>
        <p><strong>Dirección:</strong> ${comprobante.cliente.direccion}, ${comprobante.cliente.ciudad}, ${comprobante.cliente.pais}</p>
      `;
      
      // Servicios comprados
      const serviciosComprados = document.getElementById('serviciosComprados');
      serviciosComprados.innerHTML = '';
      comprobante.servicios.forEach(servicio => {
        const div = document.createElement('div');
        div.className = 'comprobante-item';
        div.innerHTML = `
          <span>${servicio.nombre} x ${servicio.cantidad}</span>
          <span>${simbolosMoneda[comprobante.moneda]}${(servicio.precio * servicio.cantidad * tasaCambio).toFixed(2)}</span>
        `;
        serviciosComprados.appendChild(div);
      });
      
      // Detalles de pago
      document.getElementById('detallesPago').innerHTML = `
        <p><strong>Método de pago:</strong> ${comprobante.metodoPago}</p>
        <div class="comprobante-item">
          <span>Subtotal:</span>
          <span>${simbolosMoneda[comprobante.moneda]}${comprobante.subtotal.toFixed(2)}</span>
        </div>
        <div class="comprobante-item">
          <span>Impuestos:</span>
          <span>${simbolosMoneda[comprobante.moneda]}${comprobante.impuestos.toFixed(2)}</span>
        </div>
      `;
      
      document.getElementById('totalPagado').textContent = `${simbolosMoneda[comprobante.moneda]}${comprobante.total.toFixed(2)}`;
      
      // Mostrar modal
      const modal = document.getElementById('comprobanteModal');
      modal.style.display = 'flex';
    }

    // Cerrar comprobante
    function cerrarComprobante() {
      document.getElementById('comprobanteModal').style.display = 'none';
      cambiarPestana('explorar');
    }

    // Imprimir comprobante
    function imprimirComprobante() {
      window.print();
    }

    // Mostrar historial
    function mostrarHistorial() {
      const historyContent = document.getElementById('history-content');
      
      if (historialCompras.length === 0) {
        historyContent.innerHTML = `
          <div style="text-align: center; padding: 4rem 2rem; color: #6b7280;">
            <i class="fas fa-receipt" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
            <h3>No tienes compras anteriores</h3>
            <p>Cuando realices tu primera compra, aparecerá aquí</p>
          </div>
        `;
        return;
      }
      
      historyContent.innerHTML = '';
      
      historialCompras.forEach(compra => {
        const historyItem = document.createElement('div');
        historyItem.className = 'history-item';
        historyItem.innerHTML = `
          <div class="history-header">
            <div class="history-number">Compra #${compra.numero}</div>
            <div class="history-date">${compra.fecha}</div>
            <div class="history-status status-completado">Completado</div>
          </div>
          <div class="history-items">
            ${compra.servicios.map(servicio => 
              `<div>${servicio.nombre} x ${servicio.cantidad}</div>`
            ).join('')}
          </div>
          <div class="history-total">
            Total: ${simbolosMoneda[compra.moneda]}${compra.total.toFixed(2)}
          </div>
        `;
        historyContent.appendChild(historyItem);
      });
    }

    // Formatear número de tarjeta
    function formatearNumeroTarjeta(e) {
      let valor = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
      let formateado = valor.match(/.{1,4}/g)?.join(' ') || valor;
      if (formateado.length > 19) formateado = formateado.substr(0, 19);
      e.target.value = formateado;
    }

    // Formatear fecha de expiración
    function formatearFechaExpiracion(e) {
      let valor = e.target.value.replace(/\D/g, '');
      if (valor.length >= 2) {
        valor = valor.substring(0, 2) + '/' + valor.substring(2, 4);
      }
      e.target.value = valor;
    }

    // Mostrar notificación toast
    function mostrarToast(mensaje, tipo = 'success') {
      const toast = document.createElement('div');
      toast.className = `toast ${tipo}`;
      toast.innerHTML = `
        <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        ${mensaje}
      `;
      
      document.body.appendChild(toast);
      
      setTimeout(() => {
        toast.classList.add('show');
      }, 100);
      
      setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
          if (document.body.contains(toast)) {
            document.body.removeChild(toast);
          }
        }, 300);
      }, 3000);
    }

    // Generar ID único
    function generateUniqueId() {
      return Date.now().toString(36) + Math.random().toString(36).substr(2);
    }

    // Guardar carrito en localStorage
    function guardarCarritoEnLocalStorage() {
      localStorage.setItem('carrito_viaja_conmigo', JSON.stringify(carrito));
    }

    // Cargar carrito desde localStorage
    function cargarCarritoDesdeLocalStorage() {
      const carritoGuardado = localStorage.getItem('carrito_viaja_conmigo');
      if (carritoGuardado) {
        carrito = JSON.parse(carritoGuardado);
      }
    }

    // Guardar historial en localStorage
    function guardarHistorialEnLocalStorage() {
      localStorage.setItem('historial_viaja_conmigo', JSON.stringify(historialCompras));
    }

    // Cargar historial desde localStorage
    function cargarHistorialDesdeLocalStorage() {
      const historialGuardado = localStorage.getItem('historial_viaja_conmigo');
      if (historialGuardado) {
        historialCompras = JSON.parse(historialGuardado);
      }
    }

    // Cerrar sesión
    function cerrarSesion() {
      if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
        localStorage.removeItem('carrito_viaja_conmigo');
        localStorage.removeItem('historial_viaja_conmigo');
        window.location.href = 'inicio1.php';
      }
    }

    // Hacer funciones globales
    window.agregarAlCarrito = agregarAlCarrito;
    window.modificarCantidad = modificarCantidad;
    window.eliminarDelCarrito = eliminarDelCarrito;
    window.cambiarPestana = cambiarPestana;
    window.procesarPago = procesarPago;
    window.cerrarComprobante = cerrarComprobante;
    window.imprimirComprobante = imprimirComprobante;
  </script>
</body>
</html>