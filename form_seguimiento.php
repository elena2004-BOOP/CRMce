<?php
session_start();
include("config/db.php");

// Obtener clientes para el select
$clientes = $conn->query("SELECT id, nombre FROM clientes ORDER BY nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Seguimiento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            padding: 40px;
        }
        form {
            background: white;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        select, textarea, input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 25px;
            width: 100%;
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 15px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>
<body>

<h2>Agregar Seguimiento</h2>

<form action="guardar_seguimiento.php" method="POST">
    <label for="cliente_id">Cliente:</label>
    <select name="cliente_id" required>
        <option value="">-- Selecciona --</option>
        <?php while ($c = $clientes->fetch_assoc()): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
        <?php endwhile; ?>
    </select>

    <label for="nota">Nota del seguimiento:</label>
    <textarea name="nota" required rows="4"></textarea>

    <label for="estado">Estado:</label>
    <select name="estado" required>
        <option value="respondió">Respondió</option>
        <option value="no respondió">No respondió</option>
    </select>

    <label for="prioridad">Prioridad:</label>
    <select name="prioridad" required>
        <option value="urgente">Urgente</option>
        <option value="importante">Importante</option>
    </select>

    <button type="submit">Guardar Seguimiento</button>
</form>

</body>
</html>
