\<?php
session_start();
require 'config/db.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// 1. Consultar clientes
$result = $conn->query("SELECT * FROM clientes");

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Clientes");

// 2. Encabezados
$headers = ['ID', 'Nombre', 'Teléfono', 'Correo', 'Dirección', 'Empresa', 'Puesto', 'Área', 'Color', 'Descripción', 'Comentarios', 'Próxima Llamada', 'Fecha Registro'];

foreach ($headers as $i => $col) {
    $colLetra = chr(65 + $i);
    $sheet->setCellValue($colLetra . '1', $col);
}

// 3. Contenido
$fila = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue("A$fila", $row['id']);
    $sheet->setCellValue("B$fila", $row['nombre']);
    $sheet->setCellValue("C$fila", $row['telefono']);
    $sheet->setCellValue("D$fila", $row['correo']);
    $sheet->setCellValue("E$fila", $row['direccion']);
    $sheet->setCellValue("F$fila", $row['empresa']);
    $sheet->setCellValue("G$fila", $row['puesto']);
    $sheet->setCellValue("H$fila", $row['area']);
    $sheet->setCellValue("I$fila", $row['estatus_color']);
    $sheet->setCellValue("J$fila", $row['estatus_texto']);
    $sheet->setCellValue("K$fila", $row['comentarios']);
    $sheet->setCellValue("L$fila", $row['proxima_llamada']);
    $sheet->setCellValue("M$fila", $row['fecha_registro']);
    $fila++;
}

// 4. Guardar archivo en carpeta 'backups'
$nombreArchivo = "clientes_crm_" . date("Ymd_His") . ".xlsx";
$ruta = "backups/" . $nombreArchivo;

if (!is_dir("backups")) {
    mkdir("backups", 0777, true);
}

$writer = new Xlsx($spreadsheet);
$writer->save($ruta);

// 5. Guardar en base de datos (tabla documentos_excel)
$usuario = $_SESSION['usuario'] ?? 'desconocido';
$fecha = date("Y-m-d H:i:s");

$stmt = $conn->prepare("INSERT INTO documentos_excel (nombre_archivo, ruta, usuario, fecha_subida) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombreArchivo, $ruta, $usuario, $fecha);
$stmt->execute();
$stmt->close();

// 6. Descargar al usuario
if (ob_get_contents()) ob_end_clean();

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
header('Cache-Control: max-age=0');
readfile($ruta);
exit;
