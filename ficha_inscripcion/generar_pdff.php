<?php
require_once('tcpdf/tcpdf.php');
require '../config/db.php';

$id = $_GET['id'];
$resultado = $conn->query("SELECT * FROM ficha_inscripcion WHERE id = $id");
$datos = $resultado->fetch_assoc();

$pdf = new TCPDF();
$pdf->SetMargins(15, 5, 15); // Reducimos más el margen superior
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// ----- FECHA Y CONSULTOR + LOGO -----
$fecha = date("d \d\e M Y", strtotime($datos['fecha_inscripcion']));
$encabezado = '
<table width="100%" style="margin-bottom:0;">
    <tr>
        <td width="25%">
            <img src="imagenes/logo.png" width="80">
        </td>
        <td width="75%" align="right" style="font-size:10pt; vertical-align:top;">
            <p style="margin:0;"><strong>FECHA:</strong> ' . strtoupper($fecha) . '</p>
            <p style="margin:0;"><strong>CONSULTOR:</strong> LIC. ' . strtoupper($datos['consultor']) . '</p>
        </td>
    </tr>
</table>';

// ----- TÍTULO -----
$titulo = '
<h2 align="center" style="margin-top:5px; margin-bottom:5px;">FICHA DE INSCRIPCIÓN</h2>';

// ----- CURSO -----
$curso = '
<table cellpadding="5" width="100%" style="margin-left:20px; margin-right:20px;">
    <tr style="background-color:#D9D9D9; text-align:center;">
        <td><strong>CURSO</strong></td>
    </tr>
    <tr>
        <td>' . strtoupper($datos['curso']) . '</td>
    </tr>
</table>
<br>';

// ----- PARTICIPANTES -----
$participantes = '
<table cellpadding="5" width="100%" style="margin-left:20px; margin-right:20px;">
    <tr style="background-color:#FFFF00; text-align:center;">
        <td><strong>PARTICIPANTES</strong></td>
    </tr>
    <tr style="background-color:#00B0F0;">
        <td>' . nl2br($datos['participantes']) . '</td>
    </tr>
</table>
<br>';

// ----- DATOS DE FACTURACIÓN -----
$datos_fact = '
<h3 align="center" style="background-color:#D9D9D9; padding:6px; margin-left:20px; margin-right:20px;">DATOS DE FACTURACIÓN</h3>
<table border="1" cellpadding="5">
    <tr><td width="50%"><b>RAZÓN SOCIAL:</b></td><td>' . $datos['razon_social'] . '</td></tr>
    <tr><td><b>CALLE Y NÚMERO:</b></td><td>' . $datos['calle_numero'] . '</td></tr>
    <tr><td><b>COLONIA Y C.P.:</b></td><td>' . $datos['colonia_cp'] . '</td></tr>
    <tr><td><b>CIUDAD, ESTADO:</b></td><td>' . $datos['ciudad_estado'] . '</td></tr>
    <tr><td><b>RFC:</b></td><td>' . $datos['rfc'] . '</td></tr>
    <tr><td><b>TELÉFONO:</b></td><td>' . $datos['telefono'] . '</td></tr>
    <tr><td><b>RÉGIMEN EN QUE TRIBUTA:</b></td><td>' . $datos['regimen'] . '</td></tr>
    <tr><td><b>MÉTODO DE PAGO:</b></td><td>' . $datos['metodo_pago'] . '</td></tr>
    <tr><td><b>FORMA DE PAGO:</b></td><td>' . $datos['forma_pago'] . '</td></tr>
    <tr><td><b>USO DE CFDI:</b></td><td>' . $datos['uso_cfdi'] . '</td></tr>
    <tr><td><b>ORDEN DE COMPRA:</b></td><td>' . $datos['orden_compra'] . '</td></tr>
    <tr><td><b>CORREO:</b></td><td>' . $datos['correo'] . '</td></tr>
</table>
<br>';

// ----- COSTOS Y EVENTO -----
$costos_evento = '
<table cellpadding="6" width="100%" style="margin-left:20px; margin-right:20px;">
    <tr style="background-color:#FFFF00;">
        <td width="50%">
            <b>NÚMERO DE PARTICIPANTES:</b> ' . $datos['numero_participantes'] . '<br>
            <b>PRECIO UNITARIO:</b> $' . number_format($datos['precio_unitario'], 2) . '<br>
            <b>SUBTOTAL:</b> $' . number_format($datos['subtotal'], 2) . '<br>
            <b>IVA:</b> $' . number_format($datos['iva'], 2) . '<br>
            <b>TOTAL:</b> $' . number_format($datos['total'], 2) . '
        </td>
        <td width="50%">
            <b>CONDICIONES DE PAGO:</b> ' . $datos['condiciones_pago'] . '<br>
            <b>FECHA:</b> ' . $datos['fecha'] . '<br>
            <b>HORARIO:</b> ' . $datos['horario'] . '<br>
            <b>FACTURA:</b> ' . ($datos['factura'] ?? '-') . '
        </td>
    </tr>
</table>
<br><br>';

// ----- PIE DE PÁGINA CON IMAGEN -----
$footer = '
<div style="text-align:center; margin-top:40px; margin-left:20px; margin-right:20px;">
    <img src="imagenes/footer.png" width="500">
</div>';

// ----- UNIMOS TODO -----
$html = $encabezado . $titulo . $curso . $participantes . $datos_fact . $costos_evento . $footer;

$pdf->writeHTML($html, true, false, true, false, '');

// DESCARGA DEL ARCHIVO
$nombre_cliente = preg_replace('/[^a-zA-Z0-9]/', '_', $datos['razon_social']);
$pdf->Output("Ficha_{$nombre_cliente}.pdf", 'D');
?>
