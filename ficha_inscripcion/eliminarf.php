<?php
require '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM ficha_inscripcion WHERE id = $id");
}
header("Location: listarf.php");
?>
