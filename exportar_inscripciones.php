<?php
require 'vendor/autoload.php';
require 'config/db.php';
session_start();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Consultar registros
$sql = "SELECT * FROM inscripciones ORDER BY fecha_registro DESC";
$resultado = $conn->query($sql);

// Crear Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Clientes Inscritos');

// Encabezados
$sheet->fromArray([
    'Curso',
    'Nombre del Cliente',
    'Razón Social',
    'Participantes',
    'Correo',
    'Teléfono',
    'Total',
    'Fecha Registro'
], null, 'A1');

// Contenido
$fila = 2;
while ($row = $resultado->fetch_assoc()) {
    $sheet->setCellValue("A{$fila}", $row['curso']);
    $sheet->setCellValue("B{$fila}", $row['nombre_cliente']);
    $sheet->setCellValue("C{$fila}", $row['razon_social']);
    $sheet->setCellValue("D{$fila}", $row['participantes']);
    $sheet->setCellValue("E{$fila}", $row['correo']);
    $sheet->setCellValue("F{$fila}", $row['telefono']);
    $sheet->setCellValue("G{$fila}", $row['total']);
    $sheet->setCellValue("H{$fila}", date("d/m/Y H:i", strtotime($row['fecha_registro'])));
    $fila++;
}

// Guardar archivo en /documentos/
$fecha = date("Y-m-d_H-i-s");
$nombreArchivo = "inscripciones_" . $fecha . ".xlsx";
$ruta = __DIR__ . "/documentos/" . $nombreArchivo;
$rutaRelativa = "documentos/" . $nombreArchivo;

$writer = new Xlsx($spreadsheet);
$writer->save($ruta);

// Registrar en la base de datos
$usuario = $_SESSION['usuario'] ?? 'desconocido';
$stmt = $conn->prepare("INSERT INTO documentos_excel (nombre_archivo, ruta, usuario, fecha_subida) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sss", $nombreArchivo, $rutaRelativa, $usuario);
$stmt->execute();
$stmt->close();

// Descargar
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
header('Cache-Control: max-age=0');
readfile($ruta);
exit;
?>
