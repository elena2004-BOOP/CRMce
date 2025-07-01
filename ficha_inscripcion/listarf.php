<?php
require '../config/db.php';
$resultado = $conn->query("SELECT * FROM ficha_inscripcion ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Fichas</title>
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
            box-shadow: 0 0 10px rgba(37, 58, 94, 0.2);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
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
            margin: 5px 0;
        }
        a.button-link:hover {
            background-color: #1a2d4a;
        }
        .acciones a {
            margin-right: 8px;
            color: #253a5e;
            text-decoration: none;
        }
        .acciones a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Listado de Fichas de Inscripción</h1>

<a href="formulariof.php" class="button-link">Registrar Nueva Ficha</a>

<table>
    <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Consultor</th>
        <th>Curso</th>
        <th>Razón Social</th>
        <th>Total</th>
        <th>Acciones</th>
    </tr>
    <?php while ($fila = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= htmlspecialchars($fila['fecha_inscripcion']) ?></td>
            <td><?= htmlspecialchars($fila['consultor']) ?></td>
            <td><?= htmlspecialchars($fila['curso']) ?></td>
            <td><?= htmlspecialchars($fila['razon_social']) ?></td>
            <td>$<?= number_format($fila['total'], 2) ?></td>
            <td class="acciones">
                <a href="editarf.php?id=<?= $fila['id'] ?>">✏️ Editar</a>
                <a href="generar_pdff.php?id=<?= $fila['id'] ?>" target="_blank">📄 PDF</a>
                <a href="eliminarf.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Seguro que quieres eliminar esta ficha?')">🗑️ Eliminar</a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
