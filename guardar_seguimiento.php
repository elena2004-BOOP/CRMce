<?php
session_start();
include("config/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cliente_id = $_POST['cliente_id'];
    $nota = trim($_POST['nota']);
    $estado = $_POST['estado'];
    $prioridad = $_POST['prioridad'];

    // Validación básica
    if (!empty($cliente_id) && !empty($nota) && !empty($estado) && !empty($prioridad)) {
        $stmt = $conn->prepare("INSERT INTO seguimientos (cliente_id, nota, fecha, estado, prioridad) VALUES (?, ?, NOW(), ?, ?)");
        $stmt->bind_param("isss", $cliente_id, $nota, $estado, $prioridad);

        if ($stmt->execute()) {
            header("Location: seguimientos.php?exito=1");
            exit();
        } else {
            echo "❌ Error al guardar seguimiento.";
        }
        $stmt->close();
    } else {
        echo "❗ Todos los campos son obligatorios.";
    }
} else {
    echo "Acceso no permitido.";
}
?>
