<?php
include("config/db.php");

// Usuarios a encriptar
$usuarios = [
    'Olivia Gallardo' => '1234',
    'sustituto' => '4567'
];

foreach ($usuarios as $usuario => $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET contraseña = '$hash' WHERE usuario = '$usuario'";
    if ($conn->query($sql) === TRUE) {
        echo "Contraseña de $usuario actualizada correctamente.<br>";
    } else {
        echo "Error actualizando a $usuario: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
