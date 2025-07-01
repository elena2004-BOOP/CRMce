<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "admin") {
    echo "<p style='font-family:Arial;padding:20px;color:red;'>❌ Acceso denegado. Esta sección es solo para administradores.</p>";
    exit();
}

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_SESSION["usuario"];
    $actual = $_POST["actual"];
    $nueva = $_POST["nueva"];
    $confirmar = $_POST["confirmar"];

    // Obtener la contraseña actual desde la BD
    $stmt = $conn->prepare("SELECT contraseña FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($hash_actual);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($actual, $hash_actual)) {
        $mensaje = "❌ La contraseña actual es incorrecta.";
    } elseif ($nueva !== $confirmar) {
        $mensaje = "❌ La nueva contraseña no coincide en ambos campos.";
    } else {
        $nuevoHash = password_hash($nueva, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE usuarios SET contraseña = ? WHERE usuario = ?");
        $stmt->bind_param("ss", $nuevoHash, $usuario);
        if ($stmt->execute()) {
            $mensaje = "✅ Contraseña actualizada correctamente.";
        } else {
            $mensaje = "❌ Error al actualizar la contraseña.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f7fa;
            padding: 30px;
        }

        form {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 25px 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0052A5;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 20px;
            width: 100%;
            background-color: #0052A5;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #003f87;
        }

        .mensaje {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            color: #c0392b;
        }

        .mensaje.success {
            color: green;
        }

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #0052A5;
            text-decoration: none;
        }
    </style>
</head>
<body>

<form method="POST">
    <h2>Cambiar Contraseña</h2>

    <label>Contraseña actual:</label>
    <input type="password" name="actual" required>

    <label>Nueva contraseña:</label>
    <input type="password" name="nueva" required>

    <label>Confirmar nueva contraseña:</label>
    <input type="password" name="confirmar" required>

    <button type="submit">Actualizar</button>

    <?php if ($mensaje): ?>
        <div class="mensaje <?= str_starts_with($mensaje, '✅') ? 'success' : '' ?>">
            <?= $mensaje ?>
        </div>
    <?php endif; ?>

    <a href="dashboard.php">⬅️ Regresar al dashboard</a>
</form>

</body>
</html>
