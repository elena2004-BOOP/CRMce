<?php
require 'config/db.php';

$token = $_GET['token'] ?? '';
$correo = '';
$valido = false;

// Verificar token válido y no expirado
if ($token) {
    $stmt = $conn->prepare("SELECT correo FROM recuperaciones WHERE token = ? AND expira > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($correo);
    if ($stmt->fetch()) {
        $valido = true;
    }
    $stmt->close();
}

// Procesar nuevo password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nueva'])) {
    $correo = $_POST['correo'];
    $nueva = $_POST['nueva'];
    $confirmar = $_POST['confirmar'];

    if ($nueva !== $confirmar) {
        $mensaje = "❌ Las contraseñas no coinciden.";
    } else {
        $nuevoHash = password_hash($nueva, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE usuarios SET contraseña = ? WHERE correo = ?");
        $stmt->bind_param("ss", $nuevoHash, $correo);
        if ($stmt->execute()) {
            // Eliminar token
            $stmtDel = $conn->prepare("DELETE FROM recuperaciones WHERE correo = ?");
            $stmtDel->bind_param("s", $correo);
            $stmtDel->execute();
            $stmtDel->close();

            echo "<p style='color:green;font-family:sans-serif;'>✅ Contraseña actualizada. <a href='login.php'>Inicia sesión</a></p>";
        } else {
            echo "<p style='color:red;'>❌ Error al actualizar la contraseña.</p>";
        }
        $stmt->close();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
    <style>
        body {
            background-color: #f7f9fc;
            font-family: 'Segoe UI', sans-serif;
            padding: 40px;
            display: flex;
            justify-content: center;
        }
        form {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #1e40af;
        }
        .mensaje {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<?php if ($valido): ?>
    <form method="POST">
        <h2>Restablecer Contraseña</h2>
        <input type="hidden" name="correo" value="<?= htmlspecialchars($correo) ?>">
        <label>Nueva contraseña:</label>
        <input type="password" name="nueva" required>

        <label>Confirmar nueva contraseña:</label>
        <input type="password" name="confirmar" required>

        <button type="submit">Restablecer</button>
        <?php if (!empty($mensaje)) echo "<div class='mensaje'>$mensaje</div>"; ?>
    </form>
<?php else: ?>
    <p style="color:red;font-family:sans-serif;">❌ El enlace ha expirado o es inválido.</p>
<?php endif; ?>
</body>
</html>
