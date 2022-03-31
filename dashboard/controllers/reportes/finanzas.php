<?php
include_once '../conexion.php';
//Consultar los datos de los servicios
$sql = "SELECT fk_servicio_fac, fk_suscriptor_serv, cobro_extra_fac, fecha_serv, nombre_usu, apellido_usu FROM tbl_factura AS FAC
INNER JOIN tbl_servicio AS SERV ON SERV.id_serv=FAC.fk_servicio_fac
INNER JOIN tbl_usuario AS USU ON USU.id_usu=SERV.fk_suscriptor_serv
WHERE fk_estado_fac=8 AND tarifa_fac=0";
$consulta_sql = $pdo->prepare($sql);
$consulta_sql->execute();
$cantid = $consulta_sql->rowCount();
$resultado_sql = $consulta_sql->fetchAll();
$total_servicios = 0;
foreach ($resultado_sql as $totserv) {
    $total_servicios = $total_servicios + $totserv['cobro_extra_fac'];
}
//Consultar finanzas de facturas
$sql_fac = "SELECT numero_fac, fk_servicio_fac, fk_suscriptor_serv, precio_mt_fac, lectura_anterior_fac, lectura_actual_fac, cargo_fijo_fac, cobro_extra_fac, descuento_fac, fecha_anterior_fac, fecha_actual_fac FROM tbl_factura AS FAC
INNER JOIN tbl_servicio AS SERV ON SERV.id_serv=FAC.fk_servicio_fac
WHERE fk_estado_fac=8 AND tarifa_fac != 0";
$consulta_fac = $pdo->prepare($sql_fac);
$consulta_fac->execute();
$resultado_fac = $consulta_fac->fetchAll();
$total_facturas = 0;
foreach ($resultado_fac as $tot) {
    $consumo = $tot['lectura_actual_fac'] - $tot['lectura_anterior_fac'];
    $subtotal = $tot['precio_mt_fac'] * $consumo + $tot['cargo_fijo_fac'] + $tot['cobro_extra_fac'];
    $total = $subtotal - $tot['descuento_fac'];

    $total_facturas = $total_facturas + $total;
}
$total_derecho_y_facturas = $total_facturas + $total_servicios;
//Datos del gerente
$sql_gerente = "SELECT id_usu, nombre_usu, apellido_usu FROM tbl_usuario
WHERE fk_rol_usu =3";
$cons_gerente = $pdo->prepare($sql_gerente);
$cons_gerente->execute();
$gerente = $cons_gerente->fetch(PDO::FETCH_OBJ);
include "fpdf.php";
$pdf = new FPDF($orientation = 'P', $unit = 'mm');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 20);
$textypos = 5;
$pdf->setY(12);
$pdf->setX(10);
// Agregamos los datos de la empresa
$pdf->Image('../../../assets/img/logo.png', 10, 8, 70);
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(30);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "FINANZAS");
$pdf->SetFont('Arial', '', 9);
$pdf->setY(35);
$pdf->setX(10);
$pdf->Cell(5, $textypos, utf8_decode("ADMINISTRACIÓN ASUAVETA"));
$pdf->setY(40);
$pdf->setX(10);
$pdf->Cell(5, $textypos, utf8_decode("Vereda la Veta"));
$pdf->setY(45);
$pdf->setX(10);
$pdf->Cell(5, $textypos, utf8_decode("NIT. 900362372-2"));
$pdf->setY(50);
$pdf->setX(10);
$pdf->Cell(5, $textypos, utf8_decode("atencionalcliente.asuaveta@gmail.com"));

// Agregamos los datos del cliente  
$pdf->setY(35);
$pdf->setX(90);
$pdf->Image('../../../assets/img/finanza.jpg', 85, 30, 50);

// Agregamos los datos del cliente
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(30);
$pdf->setX(180);
$pdf->Cell(5, $textypos, "FECHA");
$pdf->SetFont('Arial', '', 9);
$pdf->setY(35);
$pdf->setX(180);
$pdf->Cell(5, $textypos, date('d/m/Y'), 0, 1, 'L');
$pdf->Cell(5, $textypos, "");
$pdf->setY(50);
$pdf->setX(135);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 5, 'REPORTE FINANCIERO', 0, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(190, 5, utf8_decode('El SIA (Sistema de Información web para la gestión de procesos Administrativos) de la Asociación de Usuarios del Acueducto Veredal (ASUAVETA) reporta los recursos monetarios correspondientes a facturas y derechos de contratación almacenados hasta la fecha ' . strftime("%d de %B del %Y") . ' y hora ' . date("h:i a") . ', dichos recursos se especifican a continuación:'), 0, 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Ln(3);
$pdf->SetTextColor(24, 206, 15);
$pdf->Cell(5, $textypos, utf8_decode("DERECHOS DE CONTRATACIÓN DE SERVICIOS:"));
$pdf->SetTextColor(0, 0, 0);
$pdf->setY(83);
$pdf->setX(135);
$pdf->Ln(6);
$pdf->Cell(20, 7, utf8_decode('CONTRATO'), 1, 0, 'C', 0);
$pdf->Cell(80, 7, utf8_decode('CLIENTE'), 1, 0, 'C', 0);
$pdf->Cell(20, 7, utf8_decode('FECHA'), 1, 0, 'C', 0);
$pdf->Cell(25, 7, utf8_decode('VALOR'), 1, 1, 'C', 0);
$pdf->SetFont('Arial', '', 9);
foreach ($resultado_sql as $row) {
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(20, 6, utf8_decode($row['fk_servicio_fac']), 1, 0, 'C', 0);
    $pdf->Cell(80, 6, utf8_decode($row['nombre_usu'] . ' ' . $row['apellido_usu']), 1, 0, 'C', 0);
    $pdf->Cell(20, 6, utf8_decode($row['fecha_serv']), 1, 0, 'C', 0);
    $pdf->Cell(25, 6, number_format($row['cobro_extra_fac']), 1, 1, 'C', 0);
}
$pdf->Cell(100, 6, '', 0, 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(64, 134, 155);
$pdf->Cell(20, 6, 'TOTAL: ', 1, 0, 'C', 0);
$pdf->Cell(25, 6, '$' . number_format($total_servicios), 1, 0, 'C', 0);
$pdf->Ln(12);
$pdf->SetTextColor(24, 206, 15);
$pdf->Cell(35, 6, 'FACTURAS PAGADAS', 0, 0, 'C', 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 7, utf8_decode('# FACTURA'), 1, 0, 'C', 0);
$pdf->Cell(18, 7, utf8_decode('SERVICIO'), 1, 0, 'C', 0);
$pdf->Cell(18, 7, utf8_decode('PERIODO'), 1, 0, 'C', 0);
$pdf->Cell(18, 7, utf8_decode('CLIENTE'), 1, 0, 'C', 0);
$pdf->Cell(11, 7, utf8_decode('DÍAS'), 1, 0, 'C', 0);
$pdf->Cell(10, 7, utf8_decode('MTS'), 1, 0, 'C', 0);
$pdf->Cell(20, 7, utf8_decode('VALOR MT'), 1, 0, 'C', 0);
$pdf->Cell(25, 7, utf8_decode('VALOR'), 1, 1, 'C', 0);
$pdf->SetFont('Arial', '', 9);
foreach ($resultado_fac as $fac) {
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(25, 6, utf8_decode($fac['numero_fac']), 1, 0, 'C', 0);
    $pdf->Cell(18, 6, utf8_decode($fac['fk_servicio_fac']), 1, 0, 'C', 0);
    $pdf->Cell(18, 6, substr($fac['fecha_anterior_fac'], 0, -3), 1, 0, 'C', 0);
    $pdf->Cell(18, 6, utf8_decode($fac['fk_suscriptor_serv']), 1, 0, 'C', 0);
    $date1 = new DateTime($fac['fecha_actual_fac']);
    $date2 = new DateTime($fac['fecha_anterior_fac']);
    $diff = $date1->diff($date2);
    //Valor de la factura
    $consumo = $fac['lectura_actual_fac'] - $fac['lectura_anterior_fac'];
    $subtotal = $fac['precio_mt_fac'] * $consumo + $fac['cargo_fijo_fac'] + $fac['cobro_extra_fac'];
    $total = $subtotal - $fac['descuento_fac'];
    $pdf->Cell(11, 6, utf8_decode($diff->days), 1, 0, 'C', 0);
    $pdf->Cell(10, 6, number_format($consumo), 1, 0, 'C', 0);
    $pdf->Cell(20, 6, number_format($fac['precio_mt_fac']), 1, 0, 'C', 0);
    $pdf->Cell(25, 6, number_format($total), 1, 1, 'C', 0);
}
$pdf->Cell(100, 6, '', 0, 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(64, 134, 155);
$pdf->Cell(20, 6, 'TOTAL: ', 1, 0, 'C', 0);
$pdf->Cell(25, 6, '$' . number_format($total_facturas), 1, 0, 'C', 0);
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(154, 152, 70);
$pdf->Cell(145, $textypos, "TOTAL GLOBAL: $" . number_format($total_derecho_y_facturas) . " COP", 1, 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(20);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, utf8_decode('PARA CONSTATAR FIRMA:'), 0, 0, 'C');
$pdf->Ln(12);
$pdf->Cell(0, 10, '____________________________________', 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, utf8_decode("$gerente->nombre_usu $gerente->apellido_usu"), 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(0, 10, "$gerente->id_usu", 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(0, 10, '(Gerente)', 0, 0, 'C');
$pdf->Output();
