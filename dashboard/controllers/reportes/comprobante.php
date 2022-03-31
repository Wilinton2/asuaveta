<?php
include_once '../conexion.php';
@$factura_get = $_POST['num_factura'];
//Consultar finanzas de facturas
$sql_fac = "SELECT numero_fac, fk_suscriptor_serv, fk_servicio_fac, nombre_usu, apellido_usu, fecha_anterior_fac, fecha_actual_fac, lectura_anterior_fac, lectura_actual_fac, cargo_fijo_fac, precio_mt_fac, cobro_extra_fac, descuento_fac,tipo_estado FROM tbl_factura AS FAC
INNER JOIN tbl_servicio AS SERV ON SERV.id_serv=FAC.fk_servicio_fac
INNER JOIN tbl_usuario AS USU ON USU.id_usu=SERV.fk_suscriptor_serv
INNER JOIN tbl_estado AS EST ON EST.id_estado=FAC.fk_estado_fac
WHERE numero_fac=?";
$consulta_fac = $pdo->prepare($sql_fac);
$consulta_fac->execute(array($factura_get));
$existe = $consulta_fac->rowCount();
$datosf = $consulta_fac->fetch(PDO::FETCH_OBJ);
if ($existe == 1) {
    $mod_date = strtotime(date($datosf->fecha_actual_fac) . "+ 15 days");
    $fecha_pago = date("Y-m-d", $mod_date);
    include "fpdf.php";
    $pdf = new FPDF($orientation = 'P', $unit = 'mm', 'letter');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 20);
    $textypos = 5;
    $pdf->setY(12);
    $pdf->Image('../../../assets/img/logo.png', 10, 6, 80);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(64, 134, 155);
    $pdf->setY(7);
    $pdf->setX(102);
    $pdf->Cell(100, $textypos, utf8_decode('ASOCIACIÓN DE USUARIOS DEL ACUEDUCTO VEREDAL'), 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->setX(102);
    $pdf->Cell(100, $textypos, utf8_decode("VEREDA LA VETA - COCORNÁ ANTIOQUIA"), 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->setX(102);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(100, $textypos, utf8_decode("NIT.900362372-2"), 0, 0, 'C');
    $pdf->Ln(1);
    $pdf->SetTextColor(29, 29, 29);
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->setX(19);
    $pdf->Cell(70, $textypos, utf8_decode("Correo: atencionalcliente.asuaveta@gmail.com"), 0, 0);
    $pdf->Ln(4);
    $link = $pdf->AddLink();
    $pdf->setX(31);
    $pdf->Cell(48, $textypos, utf8_decode("Página web: https://www.asuaveta.site"), 0, 0);
    //Inicia cuerpo del contrato
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(24, 206, 15);
    $pdf->Cell(190, 5, utf8_decode('COMPROBANTE DE PAGO'), 0, 1, 'C');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'BI', 10);
    @$pdf->MultiCell(190, 6, utf8_decode("\nEl servicio #$datosf->fk_servicio_fac a nombre de $datosf->nombre_usu $datosf->apellido_usu identificado(a) con CC.$datosf->fk_suscriptor_serv tiene una factura con la siguiente información:\n\n"), 'LRT', 'J', 0);
    $pdf->SetFont('Arial', 'IB', 10);
    $pdf->SetTextColor(64, 134, 155);
    $pdf->Cell(30, 7, utf8_decode('# FACTURA'), 1, 0, 'C', 0);
    $pdf->Cell(47, 7, utf8_decode('PERIODO'), 1, 0, 'C', 0);
    $pdf->Cell(27, 7, utf8_decode('FECHA LÍMITE'), 1, 0, 'C', 0);
    $pdf->Cell(46, 7, utf8_decode('VALOR'), 1, 0, 'C', 0);
    $pdf->Cell(40, 7, utf8_decode('ESTADO'), 1, 1, 'C', 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, 6, utf8_decode($datosf->numero_fac), 1, 0, 'C', 0);
    $pdf->Cell(47, 6, strtoupper(strftime("%B de %Y", strtotime(substr($datosf->fecha_anterior_fac, 0, -3)))), 1, 0, 'C', 0);
    $pdf->Cell(27, 6, utf8_decode($fecha_pago), 1, 0, 'C', 0);
    //Valor de la factura
    $consumo = $datosf->lectura_actual_fac - $datosf->lectura_anterior_fac;
    $subtotal = $datosf->precio_mt_fac * $consumo + $datosf->cargo_fijo_fac + $datosf->cobro_extra_fac;
    $total = $subtotal - $datosf->descuento_fac;
    $pdf->SetFont('Arial', 'BI', 9);
    $pdf->Cell(46, 6, "$".number_format($total), 1, 0, 'C', 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(40, 6, $datosf->tipo_estado, 1, 1, 'C', 0);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Cell(0, 10, utf8_decode('Este documento ha sido generado por un sistema automático y es válido sin firma y sello'), 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->SetTextColor(64, 134, 155);
    $pdf->Cell(0, 10, utf8_decode("https://www.asuaveta.site"), 0, 0, 'C');
    $pdf->Output();
} else {
    echo "<script>alert('La factura $factura_get ¡NO EXISTE!')</script>";
    echo "<script>window.close()</script>";
}
