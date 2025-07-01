<?php
session_start();
include("config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    // Buscamos al usuario por nombre
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $user = $resultado->fetch_assoc();

        // Verificamos si la contraseña ingresada coincide con el hash
        if (password_verify($contraseña, $user["contraseña"])) {
            $_SESSION["usuario"] = $user["usuario"];
            $_SESSION["rol"] = $user["rol"];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | CRM Olivia</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('img/consultoria.png.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background-color: #FFFFFF;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #1F3B4D;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container img {
            max-width: 150px;
            height: auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #D9D9D9;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn {
            width: 100%;
            background-color: #4DA8DA;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #3B91C2;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .extra-links {
            text-align: center;
            margin-top: 15px;
        }

        .extra-links a {
            display: block;
            color: #4DA8DA;
            margin: 5px 0;
            text-decoration: none;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="img/consultoria.png.jpg" alt="Logo Consultoría Olivia">
        </div>
        <h2>Iniciar sesión</h2>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" name="contraseña" required>
            </div>
            <button type="submit" class="btn">Entrar</button>
        </form>

        <div class="extra-links">
            <a href="registro.php">¿No tienes cuenta? Regístrate</a>
            <a href="recuperar_contrasena.php">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</body>
</html>
