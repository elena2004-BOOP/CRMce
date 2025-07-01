<?php
session_start();
include("config/db.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION["usuario"];
$rol = $_SESSION["rol"];

// Solo admin puede marcar como contactado
if (isset($_GET['contactado'])) {
    $id = intval($_GET['contactado']);
    $conn->query("UPDATE clientes SET estatus_color = '#808080' WHERE id = $id"); // Cambia a gris
    header("Location: llamadas_urgentes.php");
    exit();
}


// Buscar clientes urgentes (color rojo - caliente)
$buscar = isset($_GET['buscar']) ? $conn->real_escape_string($_GET['buscar']) : '';
$sql = "SELECT * FROM clientes WHERE estatus_color = '#FF0000'";

if ($buscar) {
    $sql .= " AND (nombre LIKE '%$buscar%' OR telefono LIKE '%$buscar%' OR correo LIKE '%$buscar%')";
}
$sql .= " ORDER BY proxima_llamada ASC";

$resultado = $conn->query($sql);
$totalUrgentes = $resultado->num_rows;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Llamadas Urgentes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(2, 44, 86);
            color: white;
            padding: 20px 20px 20px 100px;
            margin: 0;
        }

        .logo {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 60px;
            z-index: 1000;
        }

        h2 {
            margin-top: 0;
        }

        .boton {
            padding: 8px 15px;
            background: #4DA8DA;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            display: inline-block;
        }

        .boton:hover {
            background-color: #3B91C2;
        }

        .acciones a {
            margin-right: 8px;
            text-decoration: none;
            color: #4DA8DA;
        }

        .acciones a:hover {
            text-decoration: underline;
        }

        form.buscar-form {
            margin: 20px 0;
        }

        input[type="text"] {
            padding: 8px;
            width: 280px;
            border-radius: 4px;
            border: none;
            font-size: 16px;
        }

        button.buscar-btn {
            padding: 8px 15px;
            background-color: #4DA8DA;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button.buscar-btn:hover {
            background-color: #3B91C2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
            color: #000;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #4DA8DA;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .contador {
            margin: 10px 0 5px;
            font-weight: bold;
            color: #FFD700;
        }
    </style>
</head>
<body>

<img src="img/consultoria.png.jpg" alt="Logo" class="logo">

<h2>☎️ Llamadas Urgentes</h2>

<a class="boton" href="dashboard.php">⬅️ Regresar al Dashboard</a>
<a class="boton" href="clientes.php">📋 Ver Todos los Clientes</a>

<!-- Buscador -->
<form method="get" action="llamadas_urgentes.php" class="buscar-form">
    <input type="text" name="buscar" placeholder="Buscar por nombre, teléfono o correo" value="<?= htmlspecialchars($buscar) ?>">
    <button type="submit" class="buscar-btn">Buscar</button>
    <?php if($buscar): ?>
        <a href="llamadas_urgentes.php" style="margin-left:10px; color:#fff; text-decoration:underline;">Limpiar búsqueda</a>
    <?php endif; ?>
</form>

<!-- Conteo -->
<div class="contador">🔴 Total de llamadas urgentes: <?= $totalUrgentes ?></div>

<!-- Tabla -->
<table>
    <tr>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Empresa</th>
        <th>Próxima Llamada</th>
        <th>Comentarios</th>
        <th>Acciones</th>
    </tr>
    <?php while ($cliente = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($cliente['nombre']) ?></td>
            <td><?= htmlspecialchars($cliente['telefono']) ?></td>
            <td><?= htmlspecialchars($cliente['correo']) ?></td>
            <td><?= htmlspecialchars($cliente['empresa']) ?></td>
            <td><?= $cliente['proxima_llamada'] ? date("d/m/Y H:i", strtotime($cliente['proxima_llamada'])) : '—' ?></td>
            <td><?= nl2br(htmlspecialchars($cliente['comentarios'])) ?></td>
           <td class="acciones">
              <a href="form_cliente.php?id=<?= $cliente['id'] ?>">Editar</a>
             <a href="?contactado=<?= $cliente['id'] ?>" onclick="return confirm('¿Marcar como contactado?')">✅ Contactado</a>
             <?php if ($rol === "admin"): ?>
                 <a href="eliminar_cliente.php?id=<?= $cliente['id'] ?>" onclick="return confirm('¿Eliminar este cliente urgente?')">🗑️ Eliminar</a>
          <?php endif; ?>
          </td>


        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
