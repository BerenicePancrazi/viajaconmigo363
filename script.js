// Variables globales
let carrito = [];
let categoriaSeleccionada = "todos";
let monedaSeleccionada = "USD";
let tasaCambio = 1;
let historialCompras = [];
let productoEditando = null;

// Datos de ejemplo de paquetes
const paquetesEjemplo = [
  {
    id: 1,
    nombre: "París Romántico",
    categoria: "paquete",
    precio: 1200,
    duracion: "7",
    proveedor: "EuroTravel",
    descripcion: "Descubre la ciudad del amor con este increíble paquete que incluye vuelos, hotel 4 estrellas y tours guiados.",
    imagen: "https://images.unsplash.com/photo-1502602898536-47ad22581b52?w=400&h=250&fit=crop",
    tipo: "Romance"
  },
  {
    id: 2,
    nombre: "Aventura en Bali",
    categoria: "actividad",
    precio: 890,
    duracion: "10",
    proveedor: "AsiaAdventure",
    descripcion: "Vive una experiencia única en Bali con actividades de aventura, templos sagrados y playas paradisíacas.",
    imagen: "https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?w=400&h=250&fit=crop",
    tipo: "Aventura"
  },
  {
    id: 3,
    nombre: "Roma Cultural",
    categoria: "paquete",
    precio: 950,
    duracion: "5",
    proveedor: "ItalyTours",
    descripcion: "Sumérgete en la historia de Roma con visitas guiadas al Coliseo, Vaticano y los mejores museos.",
    imagen: "https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=400&h=250&fit=crop",
    tipo: "Cultural"
  },
  {
    id: 4,
    nombre: "Caribe Todo Incluido",
    categoria: "combo",
    precio: 1500,
    duracion: "14",
    proveedor: "CaribeVIP",
    descripcion: "Relájate en las mejores playas del Caribe con todo incluido: comidas, bebidas y actividades acuáticas.",
    imagen: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=250&fit=crop",
    tipo: "Playa"
  },
  {
    id: 5,
    nombre: "Hotel Boutique Madrid",
    categoria: "hospedaje",
    precio: 120,
    duracion: "1",
    proveedor: "MadridStay",
    descripcion: "Hotel boutique en el corazón de Madrid con desayuno incluido y ubicación privilegiada.",
    imagen: "https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=400&h=250&fit=crop",
    tipo: "Negocios"
  },
  {
    id: 6,
    nombre: "Auto Deportivo Miami",
    categoria: "auto",
    precio: 85,
    duracion: "1",
    proveedor: "MiamiRentals",
    descripcion: "Alquila un auto deportivo convertible y recorre Miami Beach con estilo y comodidad.",
    imagen: "https://images.unsplash.com/photo-1544636331-e26879cd4d9b?w=400&h=250&fit=crop",
    tipo: "Aventura"
  },
  {
    id: 7,
    nombre: "Familia en Disney",
    categoria: "combo",
    precio: 2200,
    duracion: "7",
    proveedor: "DisneyMagic",
    descripcion: "Paquete familiar completo para Disney World con entradas, hotel temático y plan de comidas.",
    imagen: "https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=250&fit=crop",
    tipo: "Familiar"
  },
  {
    id: 8,
    nombre: "Safari Africano",
    categoria: "actividad",
    precio: 1800,
    duracion: "12",
    proveedor: "AfricaWild",
    descripcion: "Experiencia única de safari en Kenia y Tanzania con guías expertos y lodges de lujo.",
    imagen: "https://images.unsplash.com/photo-1516426122078-c23e76319801?w=400&h=250&fit=crop",
    tipo: "Aventura"
  }
];

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
  cargarPaquetesEjemplo();
  cargarCarritoDesdeLocalStorage();
  cargarHistorialDesdeLocalStorage();
  actualizarCarrito();
  mostrarHistorial();
  configurarFiltrosEnTiempoReal();
});

// Cargar paquetes de ejemplo
function cargarPaquetesEjemplo() {
  const grid = document.getElementById('paquetesGrid');
  grid.innerHTML = '';
  
  paquetesEjemplo.forEach(paquete => {
    const card = document.createElement('div');
    card.className = 'preview-card';
    card.setAttribute('data-categoria', paquete.categoria);
    card.setAttribute('data-id', paquete.id);
    card.setAttribute('data-nombre', paquete.nombre);
    card.setAttribute('data-precio', paquete.precio);
    card.setAttribute('data-duracion', paquete.duracion);
    
    card.innerHTML = `
      <div class="preview-image">
        <img src="${paquete.imagen}" alt="${paquete.nombre}">
      </div>
      <div class="preview-content">
        <div class="preview-title">${paquete.nombre}</div>
        <div class="preview-meta">
          <span><i class="fas fa-tag"></i> ${paquete.categoria}</span>
          <span><i class="fas fa-calendar-day"></i> ${paquete.duracion} días</span>
          <span><i class="fas fa-building"></i> ${paquete.proveedor}</span>
        </div>
        <div class="preview-description">${paquete.descripcion}</div>
        <div class="preview-price">
          <div class="price-tag">$${paquete.precio.toLocaleString()}</div>
          <div class="preview-badge">Disponible</div>
        </div>
        <button class="btn btn-primary" onclick="agregarAlCarrito(${paquete.id}, '${paquete.nombre.replace(/'/g, "\\'")}', ${paquete.precio}, '${paquete.imagen}')">
          <i class="fas fa-cart-plus"></i> Añadir al Carrito
        </button>
      </div>
    `;
    
    grid.appendChild(card);
  });
  
  // Actualizar contador inicial
  const totalPaquetes = paquetesEjemplo.length;
  document.getElementById('contadorResultados').textContent = 
    `Mostrando ${totalPaquetes} servicio${totalPaquetes !== 1 ? 's' : ''}`;
}

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
      imagen: imagen,
      cantidad: 1,
      notas: ''
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
      <img src="${item.imagen}" 
           class="item-image" alt="${item.nombre}">
      <div class="item-details">
        <div class="item-title">${item.nombre}</div>
        <div class="item-price">${simbolosMoneda[monedaSeleccionada]}${precioConvertido.toFixed(2)} c/u</div>
        ${item.notas ? `<div style="font-size: 0.875rem; color: #6b7280; margin: 0.5rem 0;"><i class="fas fa-sticky-note"></i> ${item.notas}</div>` : ''}
        <div class="item-actions">
          <div class="quantity-control">
            <button class="btn-quantity" onclick="modificarCantidad(${item.id}, -1)">-</button>
            <span class="quantity">${item.cantidad}</span>
            <button class="btn-quantity" onclick="modificarCantidad(${item.id}, 1)">+</button>
          </div>
          <div>
            <button class="btn-edit" onclick="editarProducto(${item.id})">
              <i class="fas fa-edit"></i> Editar
            </button>
            <button class="btn-remove" onclick="eliminarDelCarrito(${item.id})">
              <i class="fas fa-trash"></i> Eliminar
            </button>
          </div>
        </div>
      </div>
    `;
    carritoContenido.appendChild(itemDiv);
  });
  
  // Calcular impuestos y total
  const impuestos = subtotal * 0.1;
  const tota