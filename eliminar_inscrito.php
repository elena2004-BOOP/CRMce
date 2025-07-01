<?php
include("config/db.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM inscripciones WHERE id = $id");
}

header("Location: inscripciones.php");
exit;
?>
