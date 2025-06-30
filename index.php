<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Viaja Conmigo - Agencia de Viajes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
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
                <div class="categoria-btn" data-categoria="combo">
                  <i class="fas fa-gift"></i>
                  <span>Combos</span>
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
              <label><i class="fas fa-route"></i> Tipo de Viaje</label>
              <select id="filtroTipo" class="filtro-select">
                <option value="">Todos los tipos</option>
                <option value="Aventura">Aventura</option>
                <option value="Playa">Playa</option>
                <option value="Cultural">Cultural</option>
                <option value="Romance">Romántico</option>
                <option value="Familiar">Familiar</option>
                <option value="Negocios">Negocios</option>
              </select>
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
                  if (!empty($fila['imagen'])) {
                      echo "<img src='imagen/" . htmlspecialchars($fila['imagen']) . "' alt='" . htmlspecialchars($fila['nombre']) . "'>";
                  } else {
                      echo "<img src='https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=400&h=250&fit=crop' alt='" . htmlspecialchars($fila['nombre']) . "'>";
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

                  echo "<button class='btn btn-primary' onclick='agregarAlCarrito(" 
                       . $fila['id'] . ", \"" . addslashes($fila['nombre']) . "\", " 
                       . $fila['precio'] . ", \"" . addslashes($fila['imagen']) . "\")'>";
                  echo "<i class='fas fa-cart-plus'></i> Añadir al Carrito";
                  echo "</button>";

                  echo "</div></div>";
              }
          } else {
              echo "<p>No hay paquetes disponibles.</p>";
          }
          $conexion->close();
          ?>

        <!-- Grid de Paquetes -->
        <div class="paquetes-grid" id="paquetesGrid">
          <!-- Los paquetes se cargarán dinámicamente -->
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
    <div id="comprobanteModal" class="modal">
      <div class="comprobante">
        <div class="comprobante-header">
          <h2><i class="fas fa-check-circle" style="color: #10b981;"></i> ¡Compra Exitosa!</h2>
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

    <!-- Modal de Edición de Producto -->
    <div id="editModal" class="modal">
      <div class="edit-modal-content">
        <div class="edit-modal-header">
          <h3><i class="fas fa-edit"></i> Editar Producto</h3>
          <button class="close-btn" onclick="cerrarModalEdicion()">&times;</button>
        </div>
        <div class="edit-modal-body">
          <div class="form-group">
            <label>Cantidad:</label>
            <div class="quantity-control-large">
              <button class="btn-quantity" onclick="cambiarCantidadModal(-1)">-</button>
              <input type="number" id="cantidadModal" min="1" value="1">
              <button class="btn-quantity" onclick="cambiarCantidadModal(1)">+</button>
            </div>
          </div>
          <div class="form-group">
            <label>Notas especiales:</label>
            <textarea id="notasModal" placeholder="Agregar notas especiales para este servicio..."></textarea>
          </div>
        </div>
        <div class="edit-modal-footer">
          <button class="btn btn-continue" onclick="cerrarModalEdicion()">Cancelar</button>
          <button class="btn btn-primary" onclick="guardarEdicion()">Guardar Cambios</button>
        </div>
      </div>
    </div>

  </main>

  <script src="script.js"></script>
</body>
</html>
