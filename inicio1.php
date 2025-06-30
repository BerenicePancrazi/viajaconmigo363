<?php
include("conexion.php");

// Traer todos los paquetes
$sql = "SELECT * FROM paquetes";
$resultado = mysqli_query($conexion, $sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ViajaConmigo</title>
  <link rel="icon" type="foto logo.png" href="foto logo.png">
  <style>


body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
  background-color: #030970; /* Cambia el color por el que quieras */
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 40px;
  background-color: #000000;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 10;
  box-sizing: border-box;
}

.logo {
  display: flex;
  align-items: center;
  height: 80px;
}

.logo img {
  height: 225%;
  width: auto;
}

.icons {
  display: flex;
  gap: 25px;
  align-items: center;
}

.icons img {
  width: 28px;
  height: 28px;
  filter: invert(1);
  cursor: pointer;
}

html, body {
  margin: 0;
  padding: 0;
}

/* 1) Reset general */
html, body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* 2) Header fijo encima de la hero */
header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 999;
  background: #302d35; /* tu color de fondo, ajusta si quieres opacidad */
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 25px;
}

.hero {
  position: relative;
  height: 100vh;
  overflow: hidden;
}

.video-background {
  position: absolute;
  top: 0; 
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 0;
  filter: contrast(1.2) brightness(1.1) saturate(1.3);
  
  
}

.hero-content {
  position: relative;
  z-index: 1;
  height: 80%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding-top: 0px; /* Ajusta si tienes header fijo */
  box-sizing: border-box;
  text-align: center;
  color: white;
  text-shadow: 0 0 10px black;
}
.hero-img {
  width: 50%;     /* probá 40%, 30% o lo que te guste */
  height: auto;
  max-width: 1000px; /* opcional: tamaño máximo */
}


/* 6) Iconos del header */
.icono {
  width: 30px;
  height: 30px;
}



.btn-descubre {
  display: inline-block;
  margin: 15px 0;
  padding: 12px 28px;
  background-color: #331353;
  color: white;
  font-weight: bold;
  text-decoration: none;
  border-radius: 5px;
  font-size: 1.1rem;
  transition: background-color 0.3s ease;
}

.btn-descubre:hover {
  background-color: #573D7F;
}

body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
  /* Degradé vertical de púrpura a azul claro */
  background: linear-gradient(to bottom, #8f6aca, #331353);
  min-height: 100vh;
}

  header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 40px;
    background: linear-gradient(to right, #8f6aca, #331353);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 10;
    box-sizing: border-box;
  }
  
  
  .logo {
    color: white;
    font-size: 1.5em;
    font-weight: bold;
  }
  
  .logo span {
    color: #291c2c;
  }
  
  .icons {
    display: flex;
    gap: 25px;
    align-items: center;
  }
  
  .icons img {
    width: 28px;
    height: 28px;
    filter: invert(1);
    cursor: pointer;
  }
  
  img.background {
    width: 100vw;
    height: 100vh;
    object-fit: cover;
    display: block;
  }

.carrusel {
  position: relative;
  max-width: 90%;
  margin: auto;
  overflow: hidden;
}

.carrusel-track-container {
  overflow: hidden;
}

.carrusel-track {
  display: flex;
  transition: transform 0.5s ease-in-out;
}

.carrusel-slide {
  min-width: 100%;
  box-sizing: border-box;
}

.carrusel-slide img {
  width: 100%;
  display: block;
}

.carrusel-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(255,255,255,0.7);
  border: none;
  font-size: 2rem;
  cursor: pointer;
  z-index: 10;
  padding: 5px 10px;
}

.carrusel-btn.prev {
  left: 10px;
}

.carrusel-btn.next {
  right: 10px;
}


.slides {
  display: flex;
  transition: transform 0.5s ease-in-out;
}

.slide {
  flex: 0 0 auto;
}

.slide img {
  display: block;
  max-width: 100%;
  height: auto;
  border-radius: 15px;
}

.prev, .next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(142, 68, 173, 0.7);
  color: white;
  border: none;
  font-size: 2rem;
  padding: 0.5rem 1rem;
  cursor: pointer;
  border-radius: 50%;
  z-index: 1;
}

.prev:hover, .next:hover {
  background-color: #732d91;
}

.prev { left: 10px; }
.next { right: 10px; }
.hero {
  position: relative;
  text-align: center;
  margin-top: 2rem;
}

footer {
  background: #4F1E5A; /* Fondo morado */
  color: white;
  padding: 3rem 0 1rem;
}

.footer-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  margin-bottom: 2rem;

  /* ✅ CENTRADO CORRECTO */
  max-width: 1200px;   /* ancho máximo */
  margin-left: auto;
  margin-right: auto;
}

.footer-column h3 {
  font-size: 1.3rem;
  margin-bottom: 1.5rem;
  position: relative;
  padding-bottom: 10px;
}

.footer-column h3::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 50px;
  height: 3px;
  background: #9AAECE;
}

.footer-column ul {
  list-style: none;
  padding: 0;
}

.footer-column ul li {
  margin-bottom: 10px;
}

.footer-column ul li a {
  color: #ccc;
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-column ul li a:hover {
  color: white;
}

.footer-column p {
  margin: 0.5rem 0;
}

.footer-column form {
  margin-top: 1rem;
}

.footer-column input[type="email"] {
  padding: 10px;
  width: 70%;
  border-radius: 4px 0 0 4px;
  border: none;
}

footer {
  background: linear-gradient(to right, #4F1E5A, #EEEE);
  color: white;
  padding: 3rem 0 1rem;
  text-align: center;
}

.copyright {
  text-align: center;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  font-size: 0.9rem;
  color: #aaa;
}

.copyright {
  text-align: center;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  font-size: 0.9rem;
  color: #aaa;
}

.copyright {
  text-align: center;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  font-size: 0.9rem;
  color: #aaa;
}


    :root {
      --primary: #573D7F;
      --primary-light: #573D7F;
      --primary-dark: #7e6d92;
      --secondary: #6b83aa;
      --dark: #333;
      --light: #186dc2;
      --gray: #6c757d;
      --success: #3c0064;
      --warning: #19345f;
      --danger: #ef4444;
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    footer {
      background: linear-gradient(to right, #8f6aca, #331353);
      color: white;
      padding: 3rem 0 1rem;
      text-align: center;
    }
    
   
    header h1 {
      margin: 0;
      font-size: 1.8rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .header-controls {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .moneda-selector {
      background: white;
      color: var(--primary);
      border: none;
      padding: 8px 15px;
      border-radius: 25px;
      font-weight: bold;
      cursor: pointer;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      transition: all 0.3s;
    }
    
    .moneda-selector:hover {
      background: #ffedd5;
    }
    
    .btn-logout {
      background: white; 
      border: none; 
      color: var(--primary); 
      padding: 10px 20px; 
      border-radius: 25px; 
      cursor: pointer; 
      font-weight: bold; 
      transition: all 0.3s ease;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .btn-logout:hover { 
      background: #8f4801; 
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    
    main { 
      padding: 25px; 
      max-width: 1400px;
      margin: 0 auto;
    }
    
    .contenido {
      display: flex;
      flex-wrap: wrap;
      gap: 25px;
    }
    
    .filtros-container {
      flex: 1;
      min-width: 300px;
      max-width: 350px;
    }
    
    .filtros-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }
    
    .filtros-header h2 {
      color: var(--primary);
      font-size: 1.5rem;
    }
    
    .btn-toggle-filtros {
      background: var(--primary);
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      display: none;
    }
    
    .filtros {
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      height: fit-content;
      position: sticky;
      top: 90px;
    }
    
    .filtro-grupo {
      margin-bottom: 25px;
      border-bottom: 1px solid #eee;
      padding-bottom: 20px;
    }
    
    .filtro-grupo:last-child {
      border-bottom: none;
    }
    
    .filtro-grupo h3 {
      font-size: 1.1rem;
      margin-bottom: 15px;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .filtro-grupo label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: var(--dark);
      font-size: 0.9rem;
    }
    
    .categoria-selector {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      margin-bottom: 15px;
    }
    
    .categoria-btn {
      background: #f8f9fa;
      border: 2px solid #e9ecef;
      border-radius: 10px;
      padding: 12px 10px;
      cursor: pointer;
      transition: all 0.3s;
      font-weight: 500;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 5px;
    }
    
    .categoria-btn:hover, .categoria-btn.active {
      background: var(--primary);
      color: white;
      border-color: var(--primary);
    }
    
    .categoria-btn i {
      font-size: 1.2rem;
    }
    
    .filtro-input {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #e0e0f0;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s;
      background: #f9f9ff;
      margin-bottom: 12px;
    }
    
    .filtro-input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
    }
    
    .filtro-select {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #e0e0f0;
      border-radius: 8px;
      font-size: 14px;
      background: #f9f9ff;
      margin-bottom: 12px;
      appearance: none;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ff6b00' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 1em;
    }
    
    .rango-precio {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    
    .rango-precio .filtro-input {
      flex: 1;
    }
    
    .servicios-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
    }
    
    .servicio-option {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .servicio-option input {
      width: 18px;
      height: 18px;
    }
    
    .btn-filtrar {
      width: 100%;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
      color: white;
      border: none;
      padding: 15px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      margin-top: 10px;
      transition: all 0.3s ease;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
    }
    
    .btn-filtrar:hover {
      background: linear-gradient(135deg, var(--primary-dark) 0%, #e6741f 100%);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
    }
    
    .btn-limpiar {
      width: 100%;
      background: var(--gray);
      color: white;
      border: none;
      padding: 12px;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
      margin-top: 10px;
      transition: all 0.3s ease;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
    }
    
    .btn-limpiar:hover {
      background: #5a6268;
    }
    
    .resultados-container {
      flex: 3;
      min-width: 350px;
    }
    
    .resultados-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding: 15px 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .contador-resultados {
      font-weight: 600;
      color: var(--dark);
      font-size: 1.1rem;
    }
    
    .controles-resultados {
      display: flex;
      gap: 15px;
      align-items: center;
    }
    
    .ordenar-select {
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background: white;
      font-weight: 500;
    }
    
    .paquetes-grid { 
      display: grid; 
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
      gap: 25px; 
    }
    
    .paquete { 
      background: white; 
      border-radius: 15px; 
      padding: 20px; 
      box-shadow: 0 5px 20px rgba(0,0,0,0.1); 
      transition: all 0.3s ease;
      border: 1px solid #f0f0f0;
      display: flex;
      flex-direction: column;
      height: 100%;
    }
    
    .paquete:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .portada-preview { 
      width: 100%; 
      height: 200px; 
      object-fit: cover; 
      border-radius: 10px; 
      margin-bottom: 15px;
    }
    
    .paquete-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 10px;
    }
    
    .paquete-titulo {
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--dark);
    }
    
    .servicio-tag {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      margin-bottom: 8px;
    }
    
    .servicio-paquete { background: #ffedd5; color: #f97316; }
    .servicio-combo { background: #dbeafe; color: #3b82f6; }
    .servicio-actividad { background: #dcfce7; color: #22c55e; }
    .servicio-hospedaje { background: #fae8ff; color: #d946ef; }
    .servicio-vuelo { background: #ffedd5; color: #f97316; }
    .servicio-auto { background: #d1fae5; color: #10b981; }
    
    .paquete-info {
      margin-bottom: 15px;
      flex-grow: 1;
    }
    
    .paquete-info p {
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.9rem;
    }
    
    .paquete-precio {
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--primary);
      margin: 10px 0;
    }
    
    .paquete-acciones {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 10px;
      margin-top: auto;
    }
    
    .btn-add-cart {
      background: var(--primary);
      color: white;
      border: none;
      padding: 12px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
      transition: all 0.3s;
    }
    
    .btn-add-cart:hover {
      background: var(--primary-dark);
    }
    
    .btn-fotos {
      background: var(--secondary);
      color: white;
      border: none;
      border-radius: 8px;
      width: 45px;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    .btn-fotos:hover {
      background: #2563eb;
    }
    
    .calificacion {
      display: flex;
      gap: 3px;
      margin-bottom: 10px;
    }
    
    .calificacion i {
      color: #ffc107;
      font-size: 0.9rem;
    }
    
    .no-resultados {
      text-align: center;
      padding: 60px 20px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      grid-column: 1 / -1;
    }
    
    .no-resultados h3 {
      color: #666;
      margin-bottom: 10px;
      font-size: 1.5rem;
    }
    
    .no-resultados p {
      color: #999;
      font-size: 1.1rem;
    }
    
    /* ================== MEJORAS PARA EL CARRITO ================== */
    .nav-tabs {
      display: flex;
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      margin: 25px 0;
      overflow: hidden;
    }
    
    .nav-tab {
      flex: 1;
      text-align: center;
      padding: 15px;
      cursor: pointer;
      transition: all 0.3s;
      border-bottom: 3px solid transparent;
    }
    
    .nav-tab.active {
      border-bottom: 3px solid var(--primary);
      color: var(--primary);
      font-weight: 600;
    }
    
    .nav-tab:hover:not(.active) {
      background: #f8f9fa;
    }
    
    .tab-content {
      display: none;
    }
    
    .tab-content.active {
      display: block;
    }
    
    /* Nuevo sistema de pasos para el carrito */
    .checkout-steps {
      display: flex;
      justify-content: space-between;
      margin-bottom: 25px;
      position: relative;
    }
    
    .checkout-steps::before {
      content: "";
      position: absolute;
      top: 20px;
      left: 0;
      width: 100%;
      height: 3px;
      background: #e0e0e0;
      z-index: 1;
    }
    
    .step {
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      z-index: 2;
      flex: 1;
    }
    
    .step-number {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #e0e0e0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      margin-bottom: 10px;
      transition: all 0.3s;
    }
    
    .step.active .step-number {
      background: var(--primary);
      color: white;
    }
    
    .step.completed .step-number {
      background: var(--success);
      color: white;
    }
    
    .step-label {
      font-size: 0.9rem;
      text-align: center;
      color: #666;
    }
    
    .step.active .step-label {
      color: var(--primary);
      font-weight: 500;
    }
    
    .step-content {
      display: none;
    }
    
    .step-content.active {
      display: block;
      animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .step-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }
    
    .step-btn {
      padding: 12px 25px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s;
      border: none;
      min-width: 150px;
      justify-content: center;
    }
    
    .btn-prev {
      background: #f1f5f9;
      color: var(--dark);
    }
    
    .btn-prev:hover {
      background: #e2e8f0;
    }
    
    .btn-next, .btn-confirm {
      background: var(--primary);
      color: white;
    }
    
    .btn-next:hover, .btn-confirm:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
    }
    
    .btn-complete {
      background: var(--success);
      color: white;
    }
    
    .btn-complete:hover {
      background: #16a34a;
    }
    
    /* Estilos para la sección de carrito */
    .cart-container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      padding: 25px;
      margin-bottom: 30px;
    }
    
    .cart-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid #eee;
    }
    
    .cart-header h2 {
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .cart-items {
      margin-bottom: 25px;
    }
    
    .cart-item {
      display: flex;
      padding: 15px;
      border-bottom: 1px solid #eee;
      transition: all 0.3s;
    }
    
    .cart-item:hover {
      background: #f9f9ff;
    }
    
    .item-image {
      width: 100px;
      height: 100px;
      border-radius: 10px;
      object-fit: cover;
      margin-right: 20px;
    }
    
    .item-details {
      flex: 1;
    }
    
    .item-title {
      font-weight: 600;
      margin-bottom: 5px;
      font-size: 1.1rem;
    }
    
    .item-price {
      color: var(--primary);
      font-weight: 600;
      margin-bottom: 10px;
    }
    
    .item-actions {
      display: flex;
      gap: 15px;
    }
    
    .quantity-control {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .btn-quantity {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      border: 1px solid #ddd;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .btn-quantity:hover {
      background: var(--primary);
      color: white;
      border-color: var(--primary);
    }
    
    .quantity {
      min-width: 30px;
      text-align: center;
    }
    
    .btn-remove {
      background: var(--danger);
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 5px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .btn-remove:hover {
      background: #dc2626;
    }
    
    .cart-summary {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px;
    }
    
    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }
    
    .summary-total {
      font-weight: 700;
      font-size: 1.2rem;
      border-top: 2px solid #eee;
      padding-top: 15px;
      margin-top: 10px;
      color: var(--primary);
    }
    
    .cart-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 25px;
    }
    
    .btn {
      padding: 12px 25px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s;
      border: none;
    }
    
    .btn-continue {
      background: #f1f5f9;
      color: var(--dark);
    }
    
    .btn-continue:hover {
      background: #e2e8f0;
    }
    
    .btn-checkout {
      background: var(--success);
      color: white;
    }
    
    .btn-checkout:hover {
      background: #16a34a;
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
    }
    
    /* Estilos para las secciones del proceso de compra */
    .checkout-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
    }
    
    .checkout-form {
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      padding: 30px;
    }
    
    .form-section {
      margin-bottom: 30px;
    }
    
    .form-section h3 {
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #f1f5f9;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 20px;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: #555;
    }
    
    .form-control {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s;
    }
    
    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
    }
    
    .form-full {
      grid-column: 1 / -1;
    }
    
    .payment-methods {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 15px;
      margin-top: 15px;
    }
    
    .payment-method {
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      padding: 15px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .payment-method.selected {
      border-color: var(--primary);
      background: #fffaf5;
    }
    
    .payment-method i {
      font-size: 2rem;
      margin-bottom: 10px;
      color: #555;
    }
    
    .payment-method.selected i {
      color: var(--primary);
    }
    
    .payment-method span {
      font-weight: 500;
    }
    
    .checkout-summary {
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      padding: 30px;
      align-self: start;
      position: sticky;
      top: 100px;
    }
    
    .summary-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid #eee;
    }
    
    .summary-header h3 {
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .summary-items {
      max-height: 300px;
      overflow-y: auto;
      padding-right: 10px;
      margin-bottom: 20px;
    }
    
    .summary-item {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid #f1f5f9;
    }
    
    .summary-price {
      font-weight: 600;
    }
    
    .summary-totals {
      padding-top: 15px;
      margin-top: 15px;
      border-top: 2px solid #eee;
    }
    
    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }
    
    .final-total {
      font-weight: 700;
      font-size: 1.3rem;
      color: var(--primary);
    }
    
    .btn-complete {
      background: var(--primary);
      color: white;
      width: 100%;
      padding: 15px;
      font-size: 1.1rem;
      margin-top: 20px;
    }
    
    .btn-complete:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
    }
    
    .history-container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      padding: 25px;
    }
    
    .history-filters {
      display: flex;
      gap: 15px;
      margin-bottom: 25px;
      flex-wrap: wrap;
    }
    
    .history-filter {
      background: #f1f5f9;
      border: none;
      padding: 10px 20px;
      border-radius: 20px;
      cursor: pointer;
    }
    
    .history-filter.active {
      background: var(--primary);
      color: white;
    }
    
    .history-item {
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      transition: all 0.3s;
    }
    
    .history-item:hover {
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .history-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px solid #f1f5f9;
    }
    
    .history-id {
      font-weight: 600;
      color: var(--primary);
    }
    
    .history-date {
      color: #64748b;
    }
    
    .history-status {
      background: #dcfce7;
      color: #166534;
      padding: 5px 15px;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 500;
    }
    
    .history-items {
      margin-bottom: 15px;
    }
    
    .history-item-row {
      display: flex;
      justify-content: space-between;
      padding: 8px 0;
    }
    
    .history-total {
      font-weight: 700;
      color: var(--primary);
      font-size: 1.1rem;
      padding-top: 15px;
      border-top: 1px solid #f1f5f9;
      margin-top: 10px;
    }
    
    .filtro-avanzado-toggle {
      background: none;
      border: none;
      color: var(--primary);
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 5px;
      padding: 5px 0;
      margin-bottom: 15px;
    }
    
    .filtros-avanzados {
      display: none;
      padding-top: 15px;
      border-top: 1px solid #eee;
      margin-top: 15px;
    }
    
    .filtros-avanzados.visible {
      display: block;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
      .categoria-selector {
        grid-template-columns: repeat(3, 1fr);
      }
      
      .checkout-container {
        grid-template-columns: 1fr;
      }
      
      .checkout-summary {
        position: static;
      }
    }
    
    @media (max-width: 768px) {
      .contenido {
        flex-direction: column;
      }
      
      .filtros-container {
        max-width: 100%;
      }
      
      .filtros {
        position: static;
      }
      
      .btn-toggle-filtros {
        display: block;
      }
      
      .filtros {
        display: none;
      }
      
      .filtros.visible {
        display: block;
      }
      
      .servicios-grid {
        grid-template-columns: 1fr;
      }
      
      .resultados-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
      }
      
      .controles-resultados {
        width: 100%;
        justify-content: space-between;
      }
      
      .form-row {
        grid-template-columns: 1fr;
      }
      
      .payment-methods {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .nav-tabs {
        flex-wrap: wrap;
      }
      
      .nav-tab {
        flex: 0 0 33.333%;
      }

      .step-label {
        font-size: 0.8rem;
      }
    }
    
    @media (max-width: 576px) {
      .categoria-selector {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .paquetes-grid {
        grid-template-columns: 1fr;
      }
      
      .header-controls {
        flex-direction: column;
        align-items: flex-end;
      }
      
      header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }
      
      .payment-methods {
        grid-template-columns: 1fr;
      }
      
      .nav-tab {
        flex: 0 0 50%;
      }

      .step-actions {
        flex-direction: column;
        gap: 10px;
      }

      .step-btn {
        width: 100%;
      }
    }
    .contenedor-paquetes {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
  padding: 30px;
}
.card img {
  width: 100%;
  height: 140px; /* más chico */
  object-fit: cover;
} 
.contenedor-paquetes {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  padding: 40px;
}

.card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 6px 16px rgba(0,0,0,0.1);
  overflow: hidden;
  transition: all 0.3s ease-in-out;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 20px rgba(0,0,0,0.15);
}

.card img {
  width: 100%;
  height: 160px;
  object-fit: cover;
}

.card h2 {
  font-size: 18px;
  margin: 16px;
}

.etiquetas .tag {
  background: #e0e0e0;
  border-radius: 10px;
  padding: 4px 10px;
  margin: 0 5px 5px 0;
  font-size: 12px;
}

.descripcion {
  padding: 0 16px 16px;
  font-size: 14px;
}

.precio-disponible {
  display: flex;
  justify-content: space-between;
  padding: 0 16px 16px;
}

.precio {
  color: #007bff;
  font-weight: bold;
}

.disponible {
  background: #28a745;
  color: white;
  padding: 4px 8px;
  border-radius: 8px;
  font-size: 12px;
}

.btn-carrito {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px;
  width: 100%;
  font-weight: bold;
  border-bottom-left-radius: 16px;
  border-bottom-right-radius: 16px;
  cursor: pointer;
  transition: background 0.3s;
}

.btn-carrito:hover {
  background-color: #0056b3;
}

  </style>
  
</head>
<body>
  <header>
    <div class="logo">
      <img src="logo.png" alt="Logo de ViajaConmigo" />
    </div>
    <div class="icons" >
      <a href="https://www.instagram.com/viajaconmigoc/" target="_blank">
        <img src="Insta2-Photoroom.png" alt="Instagram" class="icono" />
      </a>
      <a href="https://wa.me/5493515194695" target="_blank">
        <img src="HD Round Black & White WhatsApp Wa Whats App Logo Icon PNG-Photoroom.png" alt="WhatsApp" class="icono" />
      </a>
      <a href="https://www.facebook.com/viajaconmigoc" target="_blank">
        <img src="Marco De Aire De Alta Gama Dorado Negro PNG ,dibujos Modelo, Capacitación, Inglés PNG Imagen para Descarga Gratuita _ Pngtree-Photoroom.png" alt="Facebook" class="icono" />
      </a>
    </div>
  </header>
  <section class="hero">
  <div class="hero-content">
    <img src="frace1.png" alt="Descubre el mundo con nosotros" class="hero-img" />
    <a href="destinos.php" class="btn-descubre">Ver Destinos</a>
  </div>

  <video autoplay loop muted playsinline class="video-background">
    <source src="video.mp4" type="video/mp4">
    Tu navegador no soporta el video.
  </video>
</section>

<main class="contenedor-paquetes" style="margin-top: 100px;">
  <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
    <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
      <div class="card">
        <img src="http://localhost/viaje2606/viaje/<?php echo htmlspecialchars($fila['portada']); ?>" alt="<?php echo htmlspecialchars($fila['nombre']); ?>">
        <h2><?php echo htmlspecialchars($fila['nombre']) . " (" . htmlspecialchars($fila['duracion']) . ")"; ?></h2>
        <div class="etiquetas">
          <span class="tag"><i class="fas fa-globe"></i> <?php echo htmlspecialchars($fila['categoria']); ?></span>
          <span class="tag"><i class="fas fa-calendar-day"></i> días</span>
          <span class="tag"><i class="fas fa-building"></i> <?php echo htmlspecialchars($fila['proveedor']); ?></span>
        </div>
        <p class="descripcion"><?php echo htmlspecialchars($fila['descripcion']); ?></p>
        <div class="precio-disponible">
          <span class="precio">$<?php echo number_format($fila['precio'], 2); ?></span>
          <span class="disponible">Disponible</span>
        </div>
        <button class="btn-carrito" onclick="window.location.href='destinos.php'"><i class="fas fa-cart-plus"></i> Añadir al Carrito</button>

      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No hay paquetes disponibles.</p>
  <?php endif; ?>
</main>
    <h2>Tu viaje soñado</h2>
  </div>
  
</section>
  <footer>
  <div class="container">
  <div class="footer-content">
  <footer>
  <div class="footer-content">
    <!-- Columna 1 -->
    <div class="footer-column">
      <h3> ViajaConmigo ✈️</h3>
      <p>✨ No importa a dónde vayas, lo importante es compartir cada aventura y cada sonrisa… eso es viajar de verdad. Eso es ViajaConmigo.✨</p>
    </div>

    <!-- Columna 2 -->
    <div class="footer-column">
      <h3>🧳 Servicios</h3>
      <ul>
        <li><a href="#">📅 Reservas Online</a></li>
        <li><a href="#">🤝 Asistencia al Viajero</a></li>
        <li><a href="#">✈️ Viajes</a></li>
        <li><a href="#">🛫 Vuelos</a></li>
        <li><a href="#">🏨 Hospedajes</a></li>
        <li><a href="#">🚗 Alquiler de Autos</a></li>
      
      </ul>
    </div>

    <!-- Columna 3 -->
    <div class="footer-column">
      <h3>📧 Promociones</h3>
      <p>💌 Inscribete para ofertas exclusivas</p>
      <form>
        <input type="email" placeholder="✉️ Tu correo electrónico" />
        <button type="submit">✅ OK</button>
      </form>
    </div>

    <!-- Columna 4 -->
    <div class="footer-column">
      <h3>💳 Métodos de Pago</h3>
      <p>✔️ Aceptamos:</p>
      <ul>
        <li>💵 Tarjeta de Debito</li>
        <li>💳 Tarjetas de Crédito</li>
        <li>🏦 Transferencias Bancarias</li>
        <li>🌐 PayPal</li>
      </ul>
    </div>
  </div>

  <div class="copyright">
    <p>© 2025 ViajaConmigo Todos los derechos reservados. | Diseñado con ❤️ para viajeros </p>
  </div>
</footer>


    </div>
  </footer>
  <script>
  const slidesContainer = document.querySelector('.slides');
  const prevBtn = document.querySelector('.prev');
  const nextBtn = document.querySelector('.next');
  const slides = document.querySelectorAll('.slide');
  let currentSlide = 0;

  function showSlide(index) {
    if (index < 0) {
      currentSlide = slides.length - 1;
    } else if (index >= slides.length) {
      currentSlide = 0;
    } else {
      currentSlide = index;
    }
    const offset = slides[currentSlide].offsetLeft;
    slidesContainer.style.transform = `translateX(-${offset}px)`;
  }

  prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));
  nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));
  setInterval(() => showSlide(currentSlide + 1), 5000);
</script>

</body>
</html>

 