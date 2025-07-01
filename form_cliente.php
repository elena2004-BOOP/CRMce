<?php
session_start();
include("config/db.php");

// Validar sesión activa y rol de administrador
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}


$cliente = [
    'id' => '',
    'nombre' => '',
    'telefono' => '',
    'correo' => '',
    'direccion' => '',
    'empresa' => '',
    'puesto' => '',
    'area' => '',
    'genero' => '',
    'estatus_color' => '',
    'comentarios' => '',
    'proxima_llamada' => ''
];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM clientes WHERE id=$id";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows == 1) {
        $cliente = $resultado->fetch_assoc();
    }
}

$proxima_llamada_formatted = '';
if (!empty($cliente['proxima_llamada']) && $cliente['proxima_llamada'] != '0000-00-00 00:00:00') {
    $proxima_llamada_formatted = date('Y-m-d\TH:i', strtotime($cliente['proxima_llamada']));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $cliente['id'] ? 'Editar' : 'Agregar' ?> Cliente</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0052A5;
            margin: 0;
            padding: 40px 20px;
            color: #fff;
            display: flex;
            justify-content: center;
        }

        .form-container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 82, 165, 0.4);
            width: 100%;
            max-width: 600px;
            color: #333;
        }

        h1 {
            color: #0052A5;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 28px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #003d7a;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="datetime-local"],
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1.8px solid #d1d9e6;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
            resize: vertical;
            color: #333;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #0052A5;
            box-shadow: 0 0 5px rgba(0, 82, 165, 0.5);
        }

        textarea {
            min-height: 80px;
        }

        button {
            background-color: #0052A5;
            color: white;
            border: none;
            padding: 14px 0;
            width: 100%;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.25s ease;
        }

        button:hover {
            background-color: #003d7a;
        }
    </style>

    <script>
        function detectarGenero() {
            const nombre = document.getElementById('nombre').value.trim().toLowerCase();
            const generoSelect = document.getElementById('genero');

            if (!nombre) return;

            const primerNombre = nombre.split(" ")[0];
            const ultimaLetra = primerNombre.slice(-1);

            if (ultimaLetra === 'a') {
                generoSelect.value = 'M';
            } else if (ultimaLetra === 'o') {
                generoSelect.value = 'H';
            } else {
                generoSelect.value = 'N';
            }
        }
    </script>
</head>
<body>
<div class="form-container">
    <h1><?= $cliente['id'] ? 'Editar' : 'Agregar' ?> Cliente</h1>
    <form method="POST" action="guardar_cliente.php">
        <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required onblur="detectarGenero()" value="<?= htmlspecialchars($cliente['nombre']) ?>">

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required value="<?= htmlspecialchars($cliente['telefono']) ?>">

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required value="<?= htmlspecialchars($cliente['correo']) ?>">

        <label for="direccion">Dirección:</label>
        <textarea id="direccion" name="direccion" required><?= htmlspecialchars($cliente['direccion']) ?></textarea>

        <label for="empresa">Empresa:</label>
        <input type="text" id="empresa" name="empresa" value="<?= htmlspecialchars($cliente['empresa']) ?>">

        <label for="puesto">Puesto:</label>
        <input type="text" id="puesto" name="puesto" value="<?= htmlspecialchars($cliente['puesto']) ?>">

        <label for="area">Área:</label>
        <input type="text" id="area" name="area" value="<?= htmlspecialchars($cliente['area']) ?>">

        <label for="genero">Género:</label>
        <select id="genero" name="genero" required>
            <option value="H" <?= $cliente['genero'] === 'H' ? 'selected' : '' ?>>Hombre</option>
            <option value="M" <?= $cliente['genero'] === 'M' ? 'selected' : '' ?>>Mujer</option>
            <option value="N" <?= $cliente['genero'] === 'N' || $cliente['genero'] === '' ? 'selected' : '' ?>>No especificado</option>
        </select>

        <label for="estatus_color">Prioridad (Color):</label>
        <select id="estatus_color" name="estatus_color" required>
            <option value="">Selecciona un color</option>
            <option value="#FFA500" <?= $cliente['estatus_color'] == '#FFA500' ? 'selected' : '' ?>>🟧 Naranja (Seguimiento)</option>
            <option value="#FF0000" <?= $cliente['estatus_color'] == '#FF0000' ? 'selected' : '' ?>>🔴 Rojo (Caliente)</option>
            <option value="#0000FF" <?= $cliente['estatus_color'] == '#0000FF' ? 'selected' : '' ?>>🔵 Azul (Nos llaman o no compró)</option>
            <option value="#FFFF00" <?= $cliente['estatus_color'] == '#FFFF00' ? 'selected' : '' ?>>🟨 Amarillo (Vendido)</option>
            <option value="#800080" <?= $cliente['estatus_color'] == '#800080' ? 'selected' : '' ?>>🟪 Morado (No estaba)</option>
        </select>

        <label for="comentarios">Comentarios:</label>
        <textarea id="comentarios" name="comentarios"><?= htmlspecialchars($cliente['comentarios']) ?></textarea>

        <label for="proxima_llamada">Próxima llamada:</label>
        <input type="datetime-local" id="proxima_llamada" name="proxima_llamada" value="<?= $proxima_llamada_formatted ?>">

        <button type="submit">Guardar</button>
    </form>
</div>
</body>
</html>
