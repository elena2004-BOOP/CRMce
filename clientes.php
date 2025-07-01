<?php
session_start();
include("config/db.php");

// Proteger acceso si no hay sesión iniciada
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

$rol = $_SESSION["rol"]; // admin o user

$buscar = isset($_GET['buscar']) ? $conn->real_escape_string($_GET['buscar']) : '';

if ($buscar) {
    $sql = "SELECT * FROM clientes WHERE nombre LIKE '%$buscar%' OR telefono LIKE '%$buscar%' OR correo LIKE '%$buscar%' ORDER BY fecha_registro DESC";
} else {
    $sql = "SELECT * FROM clientes ORDER BY fecha_registro DESC";
}

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
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
        h2 { margin-top: 0; }
        form.buscar-form { margin-bottom: 15px; }
        input[type="text"] {
            padding: 8px;
            width: 300px;
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
        button.buscar-btn:hover { background-color: #3B91C2; }
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
        tr:nth-child(even) { background-color: #f9f9f9; }
        a.boton {
            padding: 8px 15px;
            background: #4DA8DA;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            display: inline-block;
        }
        a.boton:hover { background: #3B91C2; }
        a.boton.regresar { background-color: #6c757d; }
        a.boton.regresar:hover { background-color: #5a6268; }
        .acciones a {
            margin-right: 5px;
            text-decoration: none;
            color: #4DA8DA;
        }
        .acciones a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<img src="img/consultoria.png.jpg" alt="Logo" class="logo">
<h2>Clientes</h2>

<form method="get" action="clientes.php" class="buscar-form">
    <input type="text" name="buscar" placeholder="Buscar clientes por nombre, teléfono o correo" value="<?= htmlspecialchars($buscar) ?>">
    <button type="submit" class="buscar-btn">Buscar</button>
    <?php if($buscar): ?>
        <a href="clientes.php" style="margin-left:10px; color:#fff; text-decoration:underline;">Limpiar búsqueda</a>
    <?php endif; ?>
</form>

<a class="boton regresar" href="dashboard.php">⬅️ Regresar al Dashboard</a>
<a class="boton" href="form_cliente.php">Agregar Cliente</a>

<br><br>

<table>
    <tr>
        <th>Género</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Dirección</th>
        <th>Empresa</th>
        <th>Puesto</th>
        <th>Área</th>
        <th>Color</th>
        <th>Comentarios</th>
        <th>Próxima Llamada</th>
        <th>Fecha Registro</th>
        <th>Datos Fiscales</th>
        <th>Acciones</th>
    </tr>
    <?php while ($cliente = $resultado->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($cliente['genero']) ?></td>
        <td><?= htmlspecialchars($cliente['nombre']) ?></td>
        <td><?= htmlspecialchars($cliente['telefono']) ?></td>
        <td><?= htmlspecialchars($cliente['correo']) ?></td>
        <td><?= htmlspecialchars($cliente['direccion']) ?></td>
        <td><?= htmlspecialchars($cliente['empresa']) ?></td>
        <td><?= htmlspecialchars($cliente['puesto']) ?></td>
        <td><?= htmlspecialchars($cliente['area']) ?></td>
        <td>
            <span style="display:inline-block; width:15px; height:15px; background-color:<?= htmlspecialchars($cliente['estatus_color']) ?>; border:1px solid #999;"></span>
        </td>
        <td><?= nl2br(htmlspecialchars($cliente['comentarios'])) ?></td>
        <td><?= $cliente['proxima_llamada'] ? date("d/m/Y H:i", strtotime($cliente['proxima_llamada'])) : '—' ?></td>
        <td><?= date("d/m/Y", strtotime($cliente['fecha_registro'])) ?></td>
        <td>
            <a href="datos_fiscales.php?id=<?= $cliente['id'] ?>" class="boton">📄 Llenar</a>
        </td>
        <td class="acciones">
            <a href="form_cliente.php?id=<?= $cliente['id'] ?>">Editar</a>
            <?php if ($rol === 'admin'): ?>
                <a href="eliminar_cliente.php?id=<?= $cliente['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este cliente?');">Eliminar</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
