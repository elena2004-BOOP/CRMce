<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    echo "<p style='font-family:Arial;color:red;padding:20px;'>⛔ Acceso denegado. Solo el administrador puede ver esta sección.</p>";
    exit();
}

// Eliminar documento si se solicita
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $res = $conn->query("SELECT ruta FROM documentos_excel WHERE id = $id");
    if ($res && $res->num_rows > 0) {
        $fila = $res->fetch_assoc();
        $ruta = $fila['ruta'];

        // Eliminar archivo físico
        if (file_exists($ruta)) {
            unlink($ruta);
        }

        // Eliminar de la base
        $conn->query("DELETE FROM documentos_excel WHERE id = $id");
        header("Location: ver_documentos.php?mensaje=eliminado");
        exit();
    }
}

// Obtener documentos
$resultado = $conn->query("SELECT * FROM documentos_excel ORDER BY fecha_subida DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Documentos Excel</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            padding: 30px;
            color: #253a5e;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #253a5e;
            color: white;
        }
        a.button-link {
            background: #253a5e;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
        }
        a.button-link:hover {
            background-color: #1a2d4a;
        }
        .acciones a {
            margin: 0 5px;
        }
        .mensaje {
            color: green;
            padding: 10px;
            margin-bottom: 20px;
            background: #e6ffe6;
            border: 1px solid #b2ffb2;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<h1>📂 Historial de Documentos Excel</h1>
<a href="dashboard.php" class="button-link">⬅️ Volver al Dashboard</a>
<a href="descargar.php" class="button-link">⬇️ Generar Nuevo Excel</a>

<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'eliminado'): ?>
    <div class="mensaje">🗑️ Archivo eliminado correctamente.</div>
<?php endif; ?>

<table>
    <tr>
        <th>Nombre del Archivo</th>
        <th>Usuario</th>
        <th>Fecha de Descarga</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['nombre_archivo']) ?></td>
            <td><?= htmlspecialchars($row['usuario']) ?></td>
            <td><?= $row['fecha_subida'] ?></td>
            <td class="acciones">
                <?php if (file_exists($row['ruta'])): ?>
                    <a href="<?= $row['ruta'] ?>" download>📥 Descargar</a>
                <?php else: ?>
                    <span style="color:red;">Archivo no encontrado</span>
                <?php endif; ?>
                <a href="ver_documentos.php?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este archivo?')">🗑️ Eliminar</a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
