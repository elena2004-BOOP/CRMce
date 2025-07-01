<?php
session_start();
include("config/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $correo = trim($_POST["correo"]);
    $contraseña = $_POST["contraseña"];
    $confirmar = $_POST["confirmar"];

    // Validación básica
    if ($contraseña !== $confirmar) {
        $error = "Las contraseñas no coinciden.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "Correo electrónico inválido.";
    } else {
        // Verificar si el usuario ya existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Ese usuario ya está registrado.";
        } else {
            // Insertar nuevo usuario con rol 'usuario'
            $hash = password_hash($contraseña, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO usuarios (usuario, correo, contraseña, rol) VALUES (?, ?, ?, 'usuario')");
            $insert->bind_param("sss", $usuario, $correo, $hash);

            if ($insert->execute()) {
                $_SESSION["usuario"] = $usuario;
                $_SESSION["rol"] = "usuario";
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Error al registrar. Intenta nuevamente.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
        body {
            background: #f0f2f5;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .registro {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 15px;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007BFF;
        }
    </style>
</head>
<body>
<div class="registro">
    <h2>Registro</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>

        <label>Correo electrónico:</label>
        <input type="email" name="correo" required>

        <label>Contraseña:</label>
        <input type="password" name="contraseña" required>

        <label>Confirmar Contraseña:</label>
        <input type="password" name="confirmar" required>

        <button type="submit">Crear Cuenta</button>
    </form>
    <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
</div>
</body>
</html>
