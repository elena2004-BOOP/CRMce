<?php
session_start();
include("config/db.php");

if (!isset($_GET['id'])) {
    header("Location: seguimientos.php");
    exit();
}

$id = intval($_GET['id']);

// Verifica que el seguimiento exista antes de eliminar
$stmt = $conn->prepare("SELECT id FROM seguimientos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();

    // Elimina el seguimiento
    $delete = $conn->prepare("DELETE FROM seguimientos WHERE id = ?");
    $delete->bind_param("i", $id);
    $delete->execute();
    $delete->close();

    $_SESSION['mensaje'] = "✅ Seguimiento eliminado correctamente.";
} else {
    $_SESSION['mensaje'] = "❌ Seguimiento no encontrado.";
}

$conn->close();
header("Location: seguimientos.php");
exit();
?>
