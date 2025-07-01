<?php
require '../config/db.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guardar Ficha</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            text-align: center;
            padding-top: 60px;
        }
        .box {
            display: inline-block;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(37, 58, 94, 0.2);
        }
        a {
            background-color: #253a5e;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            margin-top: 15px;
            display: inline-block;
        }
        a:hover {
            background-color: #1a2d4a;
        }
    </style>
</head>
<body>
<div class="box">
<?php
if ($conn->connect_error) {
    die("<p>❌ Error de conexión: " . $conn->connect_error . "</p>");
}

$cliente_id = $_POST['cliente_id'] ?? null;
$nombre_cliente = '';

// Buscar el nombre del cliente si hay cliente_id
if ($cliente_id) {
    $stmt_cliente = $conn->prepare("SELECT nombre FROM clientes WHERE id = ?");
    $stmt_cliente->bind_param("i", $cliente_id);
    $stmt_cliente->execute();
    $stmt_cliente->bind_result($nombre_cliente);
    $stmt_cliente->fetch();
    $stmt_cliente->close();
}

// 1. Guardar en ficha_inscripcion
$sql = "INSERT INTO ficha_inscripcion (
    fecha_inscripcion, consultor, curso, participantes, razon_social, calle_numero,
    colonia_cp, ciudad_estado, rfc, telefono, regimen, metodo_pago, forma_pago, uso_cfdi,
    orden_compra, correo, numero_participantes, precio_unitario, subtotal, iva, total,
    condiciones_pago, sede, fecha, horario
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "sssssssssssssssiddddsssss",
    $_POST['fecha_inscripcion'],
    $_POST['consultor'],
    $_POST['curso'],
    $_POST['participantes'],
    $_POST['razon_social'],
    $_POST['calle_numero'],
    $_POST['colonia_cp'],
    $_POST['ciudad_estado'],
    $_POST['rfc'],
    $_POST['telefono'],
    $_POST['regimen'],
    $_POST['metodo_pago'],
    $_POST['forma_pago'],
    $_POST['uso_cfdi'],
    $_POST['orden_compra'],
    $_POST['correo'],
    $_POST['numero_participantes'],
    $_POST['precio_unitario'],
    $_POST['subtotal'],
    $_POST['iva'],
    $_POST['total'],
    $_POST['condiciones_pago'],
    $_POST['sede'],
    $_POST['fecha'],
    $_POST['horario']
);

if ($stmt->execute()) {
    echo "<h2>✅ Ficha guardada correctamente</h2>";

    // 2. Guardar también en la tabla inscripciones
    $stmt2 = $conn->prepare("INSERT INTO inscripciones (
        curso, nombre_cliente, razon_social, correo, telefono, participantes, total, fecha_registro
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt2->bind_param("ssssiids",
        $_POST['curso'],
        $nombre_cliente,
        $_POST['razon_social'],
        $_POST['correo'],
        $_POST['telefono'],
        $_POST['numero_participantes'],
        $_POST['total'],
        $_POST['fecha_inscripcion']
    );

    if ($stmt2->execute()) {
        echo "<p>📋 También se registró en Inscripciones correctamente.</p>";
    } else {
        echo "<p>⚠️ Error al guardar en inscripciones: " . $stmt2->error . "</p>";
    }

    $stmt2->close();
} else {
    echo "<h2>❌ Error al guardar ficha: " . $stmt->error . "</h2>";
}

$stmt->close();
$conn->close();
?>
<br>
<a href="formulariof.php">Registrar Otra</a>
<a href="listarf.php">Ver Registros</a>
</div>
</body>
</html>
