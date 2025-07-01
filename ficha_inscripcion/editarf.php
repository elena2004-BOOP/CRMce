<?php
require '../config/db.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $resultado = $conn->query("SELECT * FROM ficha_inscripcion WHERE id = $id");
    $datos = $resultado->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("UPDATE ficha_inscripcion SET curso=?, razon_social=?, correo=?, total=? WHERE id=?");
    $stmt->bind_param("sssdi", $_POST['curso'], $_POST['razon_social'], $_POST['correo'], $_POST['total'], $_POST['id']);
    $stmt->execute();
    echo "<script>alert('Ficha actualizada'); location.href='listarf.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Ficha</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            padding: 40px;
        }
        form {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(37, 58, 94, 0.2);
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input[type="text"], input[type="email"], input[type="number"] {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }
        input[type="submit"] {
            margin-top: 20px;
            background: #253a5e;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
<h1>Editar Ficha</h1>
<form method="POST">
    <input type="hidden" name="id" value="<?= $datos['id'] ?>">
    <label>Curso: <input type="text" name="curso" value="<?= $datos['curso'] ?>"></label>
    <label>Razón Social: <input type="text" name="razon_social" value="<?= $datos['razon_social'] ?>"></label>
    <label>Correo: <input type="email" name="correo" value="<?= $datos['correo'] ?>"></label>
    <label>Total: <input type="number" step="0.01" name="total" value="<?= $datos['total'] ?>"></label>
    <input type="submit" value="Guardar Cambios">
</form>
</body>
</html>
