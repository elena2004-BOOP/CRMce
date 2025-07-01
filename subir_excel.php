<?php
session_start();
include("config/db.php");

if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "admin") {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    $nombreOriginal = basename($_FILES['archivo']['name']);
    $nombreTemporal = $_FILES['archivo']['tmp_name'];

    $carpetaDestino = __DIR__ . '/documentos/';
    $url_base = 'documentos/';

    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0775, true);
    }

    $nombreUnico = date("YmdHis") . "_" . preg_replace("/[^a-zA-Z0-9_.-]/", "", $nombreOriginal);
    $rutaDestino = $carpetaDestino . $nombreUnico;
    $rutaRelativa = $url_base . $nombreUnico;

    if (move_uploaded_file($nombreTemporal, $rutaDestino)) {
        $usuarioActual = $_SESSION['usuario'] ?? 'desconocido';
        $stmt = $conn->prepare("INSERT INTO archivos_subidos (nombre_archivo, ruta, usuario) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombreOriginal, $rutaRelativa, $usuarioActual);
        $stmt->execute();
        $stmt->close();
        $mensaje = "✅ Archivo subido correctamente.";
    } else {
        $mensaje = "❌ Error al subir el archivo.";
    }
}

// Eliminar archivo
if (isset($_GET['eliminar'])) {
    $idEliminar = intval($_GET['eliminar']);

    $stmt = $conn->prepare("SELECT ruta FROM archivos_subidos WHERE id = ?");
    $stmt->bind_param("i", $idEliminar);
    $stmt->execute();
    $stmt->bind_result($rutaArchivo);
    $stmt->fetch();
    $stmt->close();

    if (!empty($rutaArchivo)) {
        $rutaCompleta = __DIR__ . '/' . $rutaArchivo;
        if (file_exists($rutaCompleta)) {
            unlink($rutaCompleta);
        }

        $delete = $conn->prepare("DELETE FROM archivos_subidos WHERE id = ?");
        $delete->bind_param("i", $idEliminar);
        $delete->execute();
        $delete->close();

        $mensaje = "✅ Archivo eliminado correctamente.";
    } else {
        $mensaje = "⚠️ No se encontró la ruta del archivo.";
    }
}

$archivos = $conn->query("SELECT * FROM archivos_subidos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Archivos Excel</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #dcefff, #f0f8ff);
            padding: 50px;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #2563eb;
            margin-bottom: 40px;
        }
        form {
            background: white;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }
        input[type="file"] {
            margin-bottom: 20px;
            width: 100%;
        }
        button {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #1d4ed8;
        }
        .mensaje {
            text-align: center;
            font-weight: bold;
            color: green;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            max-width: 900px;
            margin: 30px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 12px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #2563eb;
            color: white;
            text-align: left;
        }
        td a.btn {
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-ver {
            background-color: #4DA8DA;
            color: white;
        }
        .btn-ver:hover {
            background-color: #3B91C2;
        }
        .btn-eliminar {
            background-color: #e74c3c;
            color: white;
        }
        .btn-eliminar:hover {
            background-color: #c0392b;
        }


        .container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 20px;
  background: linear-gradient(135deg, #6dd5ed, #2193b0);
  border-radius: 15px;
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

.folder {
  position: relative;
  animation: float 2.5s infinite ease-in-out;
  transition: transform 0.3s ease;
}

.folder:hover {
  transform: scale(1.05);
}

.folder .top {
  background: linear-gradient(135deg, #ff9a56, #ff6f56);
  width: 80px;
  height: 20px;
  border-radius: 12px 12px 0 0;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  position: relative;
  z-index: 2;
}

.folder .bottom {
  background: linear-gradient(135deg, #ffe563, #ffc663);
  width: 120px;
  height: 80px;
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
  border-radius: 0 10px 10px 10px;
  position: relative;
  top: -10px;
}

.custom-file-upload {
  font-size: 1.1em;
  color: #ffffff;
  text-align: center;
  margin-top: 20px;
  padding: 15px 25px;
  background: rgba(255, 255, 255, 0.2);
  border: none;
  border-radius: 10px;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: background 0.3s ease;
  display: inline-block;
  width: 220px;
}

.custom-file-upload:hover {
  background: rgba(255, 255, 255, 0.4);
}

.custom-file-upload input[type="file"] {
  display: none;
}

@keyframes float {
  0% {
    transform: translateY(0px);
  }

  50% {
    transform: translateY(-20px);
  }

  100% {
    transform: translateY(0px);
  }
}

    </style>
</head>
<body>

<h2>📁 Subir y Gestionar Archivos Excel</h2>

<?php if (!empty($mensaje)) echo "<div class='mensaje'>$mensaje</div>"; ?>

<form method="POST" enctype="multipart/form-data">
    <label for="archivo">Selecciona archivo Excel:</label>

<div class="container">
  <div class="folder">
    <div class="top"></div>
    <div class="bottom"></div>
  </div>
  <label class="custom-file-upload">
    <input class="title" type="file" name="archivo" id="archivo" accept=".xlsx,.xls" required />
    Choose a file
  </label>

</div>

<br>

    <button type="submit">📤 Subir Archivo</button>



</form>

<?php if ($archivos->num_rows > 0): ?>
    <table>
        <tr>
            <th>Nombre del Archivo</th>
            <th>Subido por</th>
            <th>Ver</th>
            <th>Eliminar</th>
        </tr>
        <?php while ($fila = $archivos->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($fila['nombre_archivo']) ?></td>
            <td><?= htmlspecialchars($fila['usuario']) ?></td>
            <td><a class="btn btn-ver" href="<?= htmlspecialchars($fila['ruta']) ?>" target="_blank">Ver</a></td>
            <td><a class="btn btn-eliminar" href="?eliminar=<?= $fila['id'] ?>" onclick="return confirm('¿Eliminar este archivo?')">Eliminar</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p style="text-align:center; font-size: 18px; margin-top: 40px;">No hay archivos subidos aún.</p>
<?php endif; ?>
<div style="text-align:center; margin-top: 40px;">
    <a href="dashboard.php" style="
        background-color: #253a5e;
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: bold;
        display: inline-block;
    ">⬅️ Volver al Dashboard</a>
</div>


</body>
</html>
