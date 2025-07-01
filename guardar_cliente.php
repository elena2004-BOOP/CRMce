<?php
session_start();
include("config/db.php");

// Validar sesión activa y que sea admin
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}


$id = $_POST['id'];
$nombre = trim($_POST['nombre']);
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$empresa = $_POST['empresa'];
$puesto = $_POST['puesto'];
$area = $_POST['area'];
$genero = $_POST['genero'];
$estatus_color = $_POST['estatus_color'];
$comentarios = $_POST['comentarios'];
$proxima_llamada = $_POST['proxima_llamada'];

// Detección automática por la última letra del primer nombre
if ($genero === 'N' || $genero === '') {
    $primer_nombre = strtolower(explode(' ', $nombre)[0]);
    $ultima_letra = substr($primer_nombre, -1);

    if ($ultima_letra === 'a') {
        $genero = 'M';
    } elseif ($ultima_letra === 'o') {
        $genero = 'H';
    } else {
        $genero = 'N';
    }
}

if ($id) {
    // Actualizar cliente existente
    $stmt = $conn->prepare("UPDATE clientes SET nombre=?, telefono=?, correo=?, direccion=?, empresa=?, puesto=?, area=?, genero=?, estatus_color=?, comentarios=?, proxima_llamada=? WHERE id=?");
    $stmt->bind_param("sssssssssssi", $nombre, $telefono, $correo, $direccion, $empresa, $puesto, $area, $genero, $estatus_color, $comentarios, $proxima_llamada, $id);
} else {
    // Insertar nuevo cliente
    $stmt = $conn->prepare("INSERT INTO clientes (nombre, telefono, correo, direccion, empresa, puesto, area, genero, estatus_color, comentarios, proxima_llamada, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssssssss", $nombre, $telefono, $correo, $direccion, $empresa, $puesto, $area, $genero, $estatus_color, $comentarios, $proxima_llamada);
}

if ($stmt->execute()) {
    header("Location: clientes.php");
    exit();
} else {
    echo "❌ Error al guardar el cliente.";
}
?>
