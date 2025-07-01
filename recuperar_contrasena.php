<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f7fa;
            padding: 40px;
        }
        form {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: #0052A5;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 25px;
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
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<form method="POST" action="enviar_correo.php">
    <h2>Recuperar contraseña</h2>

    <label for="correo">Correo asociado a tu cuenta:</label>
    <input type="email" name="correo" required>

    <button type="submit">Enviar enlace</button>
    
</form>
<div style="text-align: center; margin-top: 30px;">
    <a href="login.php" style="
        background-color: #253a5e;
        color: white;
        padding: 10px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        font-family: 'Segoe UI', sans-serif;
        transition: background 0.3s;">
        ⬅️ Volver al Login
    </a>
</div>


</body>
</html>
