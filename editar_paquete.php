<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    echo "ID de paquete no proporcionado.";
    exit; 
}

$id = (int)$_GET['id'];

// Obtener datos del paquete actual
$sql = "SELECT * FROM paquetes WHERE id = $id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows == 0) {
    echo "Paquete no encontrado.";
    exit;
}

$paquete = $resultado->fetch_assoc();

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conexion->real_escape_string($_POST["nombre"]);
    $descripcion = $conexion->real_escape_string($_POST["descripcion"]);
    $moneda = $conexion->real_escape_string($_POST["moneda"]);
    $precio = (float)$_POST["precio"];
    $destino = $conexion->real_escape_string($_POST["destino"]);
    $tipoDestino = $conexion->real_escape_string($_POST["tipoDestino"]);
    $tipo = $conexion->real_escape_string($_POST["tipo"]);
    $duracion = (int)$_POST["duracion"];
    $fechaSalida = $_POST["fechaSalida"];
    $tipoServicio = $conexion->real_escape_string($_POST["tipoServicio"]);
    $proveedor = $conexion->real_escape_string($_POST["proveedor"]);
    $calificacion = (float)$_POST["calificacion"];
    $ubicacion = $conexion->real_escape_string($_POST["ubicacion"]);
    $servicios_incluidos = $conexion->real_escape_string($_POST["servicios_incluidos"]);

    // Manejar imagen portada
    $nuevaPortada = $paquete['portada'];
    if (isset($_FILES["portada"]) && $_FILES["portada"]["error"] == 0) {
        $archivo = basename($_FILES["portada"]["name"]);
        $ruta_destino = "imagenes/" . time() . "_" . $archivo;
        if (move_uploaded_file($_FILES["portada"]["tmp_name"], $ruta_destino)) {
            if (!empty($paquete['portada']) && file_exists($paquete['portada'])) {
                unlink($paquete['portada']);
            }
            $nuevaPortada = $ruta_destino;
        }
    }

    // Manejar imagen adicional
    $nuevaImagen = $paquete['imagen'];
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreTemp = $_FILES['imagen']['tmp_name'];
        $nombreFinal = 'uploads/' . time() . "_" . basename($_FILES['imagen']['name']);
        if (move_uploaded_file($nombreTemp, $nombreFinal)) {
            if (!empty($paquete['imagen']) && file_exists($paquete['imagen'])) {
                unlink($paquete['imagen']);
            }
            $nuevaImagen = $nombreFinal;
        }
    }

    $sql_actualizar = "UPDATE paquetes SET 
        nombre = '$nombre',
        descripcion = '$descripcion',
        moneda = '$moneda',
        precio = $precio,
        portada = '$nuevaPortada',
        destino = '$destino',
        tipoDestino = '$tipoDestino',
        tipo = '$tipo',
        duracion = $duracion,
        fechaSalida = " . ($fechaSalida ? "'$fechaSalida'" : "NULL") . ",
        tipoServicio = '$tipoServicio',
        proveedor = '$proveedor',
        calificacion = $calificacion,
        imagen = '$nuevaImagen',
        ubicacion = '$ubicacion',
        servicios_incluidos = '$servicios_incluidos'
        WHERE id = $id";

    if ($conexion->query($sql_actualizar) === TRUE) {
        header("Location: jefe_ventas.php");
        exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Editar Paquete</title>
<style>
  * {
    margin: 0; padding: 0; box-sizing: border-box;
  }
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    color: #2d3748;
    padding: 40px 20px;
  }
  .container {
    max-width: 700px;
    margin: 0 auto;
    background: rgba(255,255,255,0.95);
    border-radius: 15px;
    padding: 30px 40px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
  }
  h2 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 30px;
    text-align: center;
    color: #2d3748;
  }
  form label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #2d3748;
    font-size: 14px;
  }
  form input[type="text"],
  form input[type="number"],
  form input[type="date"],
  form textarea {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    margin-bottom: 20px;
    transition: border-color 0.3s ease;
    resize: vertical;
  }
  form input[type="text"]:focus,
  form input[type="number"]:focus,
  form input[type="date"]:focus,
  form textarea:focus {
    outline: none;
    border-color: #ff6b00;
    box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.15);
  }
  form input[type="file"] {
    margin-bottom: 25px;
  }
  img {
    max-width: 150px;
    border-radius: 8px;
    margin-bottom: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  button {
    background: linear-gradient(45deg, #ff6b00, #ff8533);
    color: white;
    padding: 14px 0;
    width: 100%;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  button:hover {
    box-shadow: 0 8px 25px rgba(255, 107, 0, 0.4);
    transform: translateY(-2px);
  }

  /* Responsive */
  @media (max-width: 600px) {
    .container {
      padding: 20px;
    }
    h2 {
      font-size: 22px;
    }
  }
</style>
</head>
<body>
  <div class="container">
    <h2>Editar Paquete</h2>
    <form action="editar_paquete.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data" novalidate>
      
      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($paquete['nombre']) ?>" required>

      <label for="descripcion">Descripción:</label>
      <textarea id="descripcion" name="descripcion" rows="4"><?= htmlspecialchars($paquete['descripcion']) ?></textarea>

      <label for="moneda">Moneda:</label>
      <input type="text" id="moneda" name="moneda" value="<?= htmlspecialchars($paquete['moneda']) ?>">

      <label for="precio">Precio:</label>
      <input type="number" step="0.01" id="precio" name="precio" value="<?= $paquete['precio'] ?>" required>

      <label for="destino">Destino:</label>
      <input type="text" id="destino" name="destino" value="<?= htmlspecialchars($paquete['destino']) ?>">

      <label for="tipoDestino">Tipo Destino:</label>
      <input type="text" id="tipoDestino" name="tipoDestino" value="<?= htmlspecialchars($paquete['tipoDestino']) ?>">

      <label for="tipo">Tipo:</label>
      <input type="text" id="tipo" name="tipo" value="<?= htmlspecialchars($paquete['tipo']) ?>">

      <label for="duracion">Duración (días):</label>
      <input type="number" id="duracion" name="duracion" value="<?= $paquete['duracion'] ?>">

      <label for="fechaSalida">Fecha de Salida:</label>
      <input type="date" id="fechaSalida" name="fechaSalida" value="<?= $paquete['fechaSalida'] ?>">

      <label for="tipoServicio">Tipo de Servicio:</label>
      <input type="text" id="tipoServicio" name="tipoServicio" value="<?= htmlspecialchars($paquete['tipoServicio']) ?>">

      <label for="proveedor">Proveedor:</label>
      <input type="text" id="proveedor" name="proveedor" value="<?= htmlspecialchars($paquete['proveedor']) ?>">

      <label for="calificacion">Calificación:</label>
      <input type="number" step="0.1" min="0" max="5" id="calificacion" name="calificacion" value="<?= $paquete['calificacion'] ?? '4.5' ?>">

      <label for="ubicacion">Ubicación:</label>
      <input type="text" id="ubicacion" name="ubicacion" value="<?= htmlspecialchars($paquete['ubicacion']) ?>">

      <label for="servicios_incluidos">Servicios Incluidos:</label>
      <textarea id="servicios_incluidos" name="servicios_incluidos" rows="4"><?= htmlspecialchars($paquete['servicios_incluidos']) ?></textarea>

      <label>Imagen Portada Actual:</label><br>
      <?php if ($paquete['portada']): ?>
        <img src="<?= htmlspecialchars($paquete['portada']) ?>" alt="Portada"><br>
      <?php else: ?>
        <em>No hay imagen portada.</em><br>
      <?php endif; ?>
      <label for="portada">Cambiar Imagen Portada (opcional):</label>
      <input type="file" id="portada" name="portada" accept="image/*">

      <label>Imagen Adicional Actual:</label><br>
      <?php if ($paquete['imagen']): ?>
        <img src="<?= htmlspecialchars($paquete['imagen']) ?>" alt="Imagen adicional"><br>
      <?php else: ?>
        <em>No hay imagen adicional.</em><br>
      <?php endif; ?>
      <label for="imagen">Cambiar Imagen Adicional (opcional):</label>
      <input type="file" id="imagen" name="imagen" accept="image/*">

      <button type="submit">Guardar cambios</button>
    </form>
  </div>
</body>
</html>
