<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "viaje_db";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($conn->connect_error) {
  die("❌ Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre     = $_POST['nombre'];
  $descripcion = $_POST['descripcion'];
  $categoria  = $_POST['categoria'];
  $moneda     = $_POST['moneda'];
  $precio     = $_POST['precio'];
  $stock      = $_POST['stock'];
  $codigo     = $_POST['codigo'];

  // Carpeta para guardar imágenes
  $carpeta = "uploads/";
  if (!is_dir($carpeta)) {
    mkdir($carpeta, 0777, true);
  }

  // Validar imagen principal (portada)
  if (!isset($_FILES['portada'])) {
    die("⚠️ No se envió ninguna imagen.");
  }

  if ($_FILES['portada']['error'] !== 0) {
    die("❌ Error al subir la imagen. Código: " . $_FILES['portada']['error']);
  }

  // Procesar imagen
  $archivo = $_FILES['portada'];
  $nombreArchivo = uniqid() . "_" . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($archivo['name']));
  $rutaDestino = $carpeta . $nombreArchivo;

  if (!is_writable($carpeta)) {
    die("❌ La carpeta 'uploads' no tiene permisos de escritura.");
  }

  if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
    die("❌ Error al guardar la imagen. Asegurate de que la carpeta exista y tenga permisos.");
  }

  // Insertar en la base de datos (usando el campo correcto: portada)
  $stmt = $conn->prepare("INSERT INTO paquetes (nombre, descripcion, categoria, moneda, precio, stock, codigo, portada) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  if (!$stmt) {
    die("❌ Error en prepare(): " . $conn->error);
  }

  $stmt->bind_param("ssssdiss", $nombre, $descripcion, $categoria, $moneda, $precio, $stock, $codigo, $rutaDestino);

  if ($stmt->execute()) {
    echo "✅ Paquete guardado correctamente.";
  } else {
    echo "❌ Error al guardar paquete: " . $stmt->error;
  }

  $stmt->close();
}

$conn->close();
?>
