<?php
session_start();
include("config/db.php");

// Verificar sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

$rol = $_SESSION["rol"];

$sql = "SELECT s.id, s.nota, s.fecha, s.estado, s.prioridad, c.nombre AS nombre_cliente 
        FROM seguimientos s
        JOIN clientes c ON s.cliente_id = c.id
        ORDER BY s.fecha DESC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seguimientos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7fa;
            padding: 40px 80px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .boton-agregar,
        .boton-dashboard {
            display: block;
            width: fit-content;
            margin: 0 auto 20px auto;
            padding: 10px 20px;
            background-color: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 6px;
            text-align: center;
        }

        .boton-agregar:hover,
        .boton-dashboard:hover {
            background-color: #1e40af;
        }

        table {
            width: 100%;
            background: #fff;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background: #2563eb;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .urgente {
            color: red;
            font-weight: bold;
        }
        .importante {
            color: orange;
            font-weight: bold;
        }
        .boton {
            padding: 6px 12px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }
        .boton:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <h2>📝 Seguimientos a Clientes</h2>

    <!-- Botón para regresar al dashboard -->
    <a href="dashboard.php" class="boton-dashboard">⬅️ Volver al Dashboard</a>

    <!-- Botón para agregar seguimiento solo si el usuario es admin -->
    <?php if ($rol === "admin"): ?>
        <a href="form_seguimiento.php" class="boton-agregar">➕ Agregar Seguimiento</a>
    <?php endif; ?>

    <table>
        <tr>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Nota</th>
            <th>Estado</th>
            <th>Prioridad</th>
            <?php if ($rol === "admin"): ?>
                <th>Acciones</th>
            <?php endif; ?>
        </tr>
        <?php while($row = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nombre_cliente']) ?></td>
                <td><?= date("d/m/Y H:i", strtotime($row['fecha'])) ?></td>
                <td><?= nl2br(htmlspecialchars($row['nota'])) ?></td>
                <td><?= htmlspecialchars($row['estado']) ?></td>
                <td class="<?= strtolower($row['prioridad']) ?>">
                    <?= ucfirst(htmlspecialchars($row['prioridad'])) ?>
                </td>
                <?php if ($rol === "admin"): ?>
                    <td>
                        <a href="eliminar_seguimiento.php?id=<?= $row['id'] ?>" class="boton" onclick="return confirm('¿Eliminar este seguimiento?')">Eliminar</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
