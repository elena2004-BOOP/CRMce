<?php
session_start();

// Verifica que el usuario sea administrador
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== 'admin') {
    echo "<p style='font-family:Arial;padding:20px;color:red;'>⛔ Acceso denegado. Esta sección es exclusiva para administradores.</p>";
    exit();
}

include("config/db.php");

date_default_timezone_set('America/Mexico_City');
$fecha = date("Y-m-d_H-i-s");
$nombreArchivo = "backup_$fecha.sql";

// Directorio para respaldos
$backupDir = __DIR__ . "/backups/";
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// Configuración de MySQL
$host = "localhost";
$usuario = "root";
$contrasena = ""; // Cámbiala si tienes contraseña
$baseDatos = "crm";

// Ruta a mysqldump
$mysqldumpPath = "C:\\xampp\\mysql\\bin\\mysqldump.exe"; // Verifica esta ruta en tu PC

// Construir comando
$comando = "\"$mysqldumpPath\" -h $host -u $usuario";
if ($contrasena !== "") {
    $comando .= " -p$contrasena";
}
$comando .= " $baseDatos > " . escapeshellarg($backupDir . $nombreArchivo);

// Ejecutar
$salida = null;
$codigo = 0;
exec($comando, $salida, $codigo);

// Resultado
if ($codigo === 0) {
    echo "<p style='font-family:Arial;padding:20px;color:green;'>✅ Respaldo generado con éxito: <a href='backups/$nombreArchivo' download>$nombreArchivo</a></p>";
} else {
    echo "<p style='font-family:Arial;padding:20px;color:red;'>❌ Error al generar el respaldo. Código de error: $codigo</p>";
}
?>
