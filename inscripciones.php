<?php
session_start();
include("config/db.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION["usuario"];
$rol = $_SESSION["rol"];

// Obtener todos los registros
$sql = "SELECT * FROM inscripciones ORDER BY fecha_registro DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes Inscritos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px 20px 20px 100px;
            margin: 0;
            background-color: rgb(2, 44, 86);
            color: #fff;
        }

        .logo {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 60px;
            height: auto;
            z-index: 1000;
        }

        h2 {
            margin-top: 0;
        }

        .boton {
            padding: 10px 20px;
            background-color: #4DA8DA;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-right: 10px;
            display: inline-block;
        }

        .boton:hover {
            background-color: #3B91C2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        .acciones a {
            margin-right: 5px;
            text-decoration: none;
            color: #e74c3c;
        }

        .acciones a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <img src="img/consultoria.png.jpg" alt="Logo" class="logo">
    <h2>Clientes Inscritos</h2>

    <a href="dashboard.php" class="boton">⬅️ Regresar al Dashboard</a>

    <?php if ($rol === "admin"): ?>
        <a href="exportar_inscripciones.php" class="boton">📥 Descargar Excel</a>
    <?php endif; ?>

    <br><br>

    <table>
        <tr>
            <th>Curso</th>
            <th>Nombre del Cliente</th>
            <th>Razón Social</th>
            <th>Participantes</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Total</th>
            <th>Fecha Registro</th>
            <th>Acciones</th>
        </tr>
        <?php while ($inscrito = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($inscrito['curso']) ?></td>
            <td><?= htmlspecialchars($inscrito['nombre_cliente']) ?></td>
            <td><?= htmlspecialchars($inscrito['razon_social']) ?></td>
            <td><?= htmlspecialchars($inscrito['participantes']) ?></td>
            <td><?= htmlspecialchars($inscrito['correo']) ?></td>
            <td><?= htmlspecialchars($inscrito['telefono']) ?></td>
            <td>$<?= number_format($inscrito['total'], 2) ?></td>
            <td><?= date("d/m/Y H:i", strtotime($inscrito['fecha_registro'])) ?></td>
           <td class="acciones">
           <?php if ($rol === "admin"): ?>
              <a href="eliminar_inscrito.php?id=<?= $inscrito['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este registro?');">Eliminar</a>
          <?php else: ?>
              <span style="color: gray;">Sin permisos</span>
          <?php endif; ?>
</td>


        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
