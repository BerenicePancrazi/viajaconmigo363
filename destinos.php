<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login / Registro</title>
  <style>
   * {
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
  margin: 0;
  background: linear-gradient(to bottom, #8F6ACA, #331353);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.form-container {
  width: 100%;
  max-width: 400px;
  background: #FFFFFF;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  margin-top: 20px;
  text-align: center;
}

.input-group {
  position: relative;
  margin-bottom: 15px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 10px 40px 10px 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.eye-icon {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  user-select: none;
}

button {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  background: #8F6ACA;
  color: white;
  border: none;
  font-weight: bold;
  cursor: pointer;
}

button:hover {
  background: #331353;
}

a {
  color: #8F6ACA;
  cursor: pointer;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}
  </style>
</head>

<body>

  <!-- Login -->
  <div class="form-container" id="login">
    <h2>Iniciar Sesión</h2>
    <form onsubmit="redirigir(event)">
      <input type="email" placeholder="Correo electrónico" required />
      <div class="input-group">
        <input type="password" placeholder="Contraseña" id="login-password" required />
        <span class="eye-icon" onclick="togglePassword('login-password')">👁️</span>
      </div>
      <button type="submit">Entrar</button>
    </form>
    <p>¿No tienes una cuenta? <a onclick="mostrarRegistro()">Regístrate aquí</a></p>
  </div>

  <!-- Registro -->
  <div class="form-container" id="registro" style="display:none;">
    <h2>Registro</h2>
    <form onsubmit="registrar(event)">
      <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" required>
      <input type="email" name="email" id="email" placeholder="Correo electrónico" required>
      <div class="input-group">
        <input type="password" name="password" id="password" placeholder="Contraseña (mínimo 6 caracteres)" required>
        <span class="eye-icon" onclick="togglePassword('password')">👁️</span>
      </div>
      <div class="input-group">
        <input type="password" name="confirmar" id="confirmar" placeholder="Confirmar contraseña" required>
        <span class="eye-icon" onclick="togglePassword('confirmar')">👁️</span>
      </div>
      <button type="submit">Registrarse</button>
    </form>
  </div>

  <script>
    function mostrarRegistro() {
      document.getElementById('login').style.display = 'none';
      document.getElementById('registro').style.display = 'block';
    }

    function mostrarLogin() {
      document.getElementById('login').style.display = 'block';
      document.getElementById('registro').style.display = 'none';
    }

    function togglePassword(id) {
      const input = document.getElementById(id);
      input.type = input.type === 'password' ? 'text' : 'password';
    }

    function registrar(e) {
      e.preventDefault();
      const nombre = document.getElementById('nombre').value.trim();
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value;
      const confirmar = document.getElementById('confirmar').value;

      if(password !== confirmar) {
        alert("Las contraseñas no coinciden.");
        return;
      }

      let usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];

      if(usuarios.some(u => u.email === email)) {
        alert("Este correo ya está registrado.");
        return;
      }

      usuarios.push({ nombre, email, password, rol: 'cliente' });
      localStorage.setItem('usuarios', JSON.stringify(usuarios));

      alert("¡Registro exitoso! Ahora puedes iniciar sesión.");
      mostrarLogin();
    }

    function redirigir(e) {
      e.preventDefault();
      const email = document.querySelector('#login input[type="email"]').value.trim();
      const password = document.getElementById('login-password').value;

      const jefe = { email: "viajaconmigo@gmail.com", password: "jefe123", rol: "jefe" };

      if(email === jefe.email && password === jefe.password) {
        localStorage.setItem('usuarioActivo', JSON.stringify(jefe));
        window.location.href = 'jefe_venta_firebase.php';
        return;
      }

      const usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
      const usuario = usuarios.find(u => u.email === email && u.password === password);

      if(usuario) {
        localStorage.setItem('usuarioActivo', JSON.stringify(usuario));
        window.location.href = 'cliente_firebase.php';
      } else {
        alert("Correo o contraseña incorrectos.");
      }
    }
  </script>
</body>
</html>
