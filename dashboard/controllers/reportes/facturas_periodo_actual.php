<?php
include_once("fpdf.php");
include_once '../conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mailer/Exception.php';
require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
$mes_actual = date('m');
$anio_actual = date('Y');
$sql = "SELECT id_usu, nombre_usu, apellido_usu, direccion_usu, numero_fac, cobro_extra_fac, tarifa_fac, fk_servicio_fac, fecha_actual_fac, fecha_anterior_fac, lectura_anterior_fac, lectura_actual_fac, precio_mt_fac, descuento_fac, cobro_extra_fac, cargo_fijo_fac, observacion_fac, correo_usu FROM tbl_usuario AS US
INNER JOIN tbl_servicio AS SERV ON SERV.fk_suscriptor_serv=US.id_usu
INNER JOIN tbl_factura AS FAC ON FAC.fk_servicio_fac=SERV.id_serv
WHERE MONTH(fecha_actual_fac)=$mes_actual AND YEAR(fecha_actual_fac)=$anio_actual AND tarifa_fac !=0";
$consulta_sql = $pdo->prepare($sql);
$consulta_sql->execute();
$resultado_fa = $consulta_sql->fetchAll();
$pdf = new FPDF();
$fecha_name = date('Y-m-d');
$periodo_general = strtoupper(strftime("%B de %Y", strtotime(@$fecha_name)));
$pdf->SetTitle(utf8_decode("FACTURACIÓN $fecha_name ASUAVETA"));
$pdf->SetAuthor('ASUAVETA');
$pdf->addPage('P');
$pdf->SetLineWidth(0);
$pdf->SetDrawColor(0, 80, 180);
$pdf->SetFillColor(200, 220, 255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 6, utf8_decode("FACTURACIÓN ASUAVETA $periodo_general..."), 1, 0, 'C');
$pdf->addPage('P');
foreach ($resultado_fa as $invoice) {
  $periodo = strftime("%B de %Y", strtotime(@$invoice['fecha_anterior_fac']));
  //Fecha de generación de la factura
  $fecha_generacion = strftime("%A %d de %B de %Y", strtotime($invoice['fecha_actual_fac']));
  //Fecha límite de pago
  $date = date(@$invoice['fecha_actual_fac']);
  $mod_date = strtotime($date . "+ 15 days");
  $fecha_limite2 = date("d-M-Y", $mod_date);
  $fecha_limite = strftime("%A %d de %B de %Y", strtotime(@$fecha_limite2));
  //Diferencia entre fechas (Días de consumo)
  $desde_php = new DateTime($invoice['fecha_anterior_fac']);
  $hasta_php = new DateTime($invoice['fecha_actual_fac']);
  $dias_con = $desde_php->diff($hasta_php);
  $dias_consumo = $dias_con->days;
  //Valor de la factura
  $consumo = $invoice['lectura_actual_fac'] - $invoice['lectura_anterior_fac'];
  $subtotal = $invoice['precio_mt_fac'] * $consumo + $invoice['cargo_fijo_fac'];
  $total_factura = $subtotal - $invoice['descuento_fac'] + $invoice['cobro_extra_fac'];
  $img = "../../../assets/img/logo.png";
  $pdf->SetFont('Arial', 'B', 20);
  $textypos = 5;
  $pdf->setY(12);
  $pdf->Image('../../../assets/img/logo.png', 10, 6, 80);
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->SetTextColor(64, 134, 155);
  $pdf->setY(8);
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
  $pdf->Cell(48, $textypos, utf8_decode("Página web: https://www.asuaveta.site"), 0, 1);
  $pdf->SetFont("Arial", "B", 9);
  $pdf->Cell(200, 20, "FACTURA DE SERVICIO DE ACUEDUCTO", 0, 1, "C");
  $pdf->Cell(140, 8, utf8_decode("Suscriptor: " . $invoice['nombre_usu'] . " " . $invoice['apellido_usu']), 0, 0, "L");
  $pdf->Cell(48, 8, "# FACTURA: " . $invoice['numero_fac'], 1, 1, "L");
  $pdf->Cell(140, 8, utf8_decode("Documento: " . $invoice['id_usu']), 0, 0, "L");
  $pdf->Cell(48, 8, "CONTRATO: " . $invoice['fk_servicio_fac'], 1, 1, "L");
  $pdf->Cell(140, 8, utf8_decode("Días de consumo: " . $dias_consumo), 0, 0, "L");
  $pdf->Cell(48, 8, "TARIFA No : " . $invoice['tarifa_fac'], 1, 1, "L");
  $pdf->Cell(65, 8, utf8_decode("Fecha de generación:"), 0, 0, "L");
  $pdf->SetFont("Arial", "I", 8);
  $pdf->Cell(65, 8, strtoupper(utf8_decode($fecha_generacion)), 0, 1, "L");
  $pdf->SetFont("Arial", "B", 9);
  $pdf->Cell(65, 8, utf8_decode("Fecha límite de pago:"), 0, 0, "L");
  $pdf->SetFont("Arial", "BI", 8);
  $pdf->Cell(65, 8, strtoupper(utf8_decode($fecha_limite)), 0, 1, "L");
  $pdf->SetFont("Arial", "B", 9);
  $pdf->Cell(40, 8, utf8_decode("Dirección del inmueble:"), 0, 0, "L");
  $pdf->SetFont("Arial", "I", 8);
  $pdf->MultiCell(148, 8, utf8_decode(strtolower($invoice['direccion_usu'])), '', 'J', 0);
  $pdf->SetFont("Arial", "B", 9);
  $pdf->Cell(32, 10, "PERIODO", 1, 0, "C");
  $pdf->Cell(18, 10, "DESDE", 1, 0, "C");
  $pdf->Cell(18, 10, 'HASTA', 1, 0, 'C', 0);
  $pdf->Cell(22, 10, utf8_decode('DÍAS CONS.'), 1, 0, 'C', 0);
  $pdf->Cell(23, 10, "L. ANTERIOR", 1, 0, "C");
  $pdf->Cell(21, 10, "L. ACTUAL", 1, 0, "C");
  $pdf->Cell(12, 10, "M3(S)", 1, 0, "C");
  $pdf->Cell(20, 10, "PRECIO M3", 1, 0, "C");
  $pdf->Cell(22, 10, "CARGO FIJO", 1, 1, "C");
  $pdf->SetFont("Arial", "B", 8);
  $pdf->Cell(32, 10, strtoupper($periodo), 1, 0, "C");
  $pdf->Cell(18, 10, $invoice['fecha_anterior_fac'], 1, 0, "C");
  $pdf->Cell(18, 10, $invoice['fecha_actual_fac'], 1, 0, "C");
  $pdf->Cell(22, 10, $dias_consumo, 1, 0, "C");
  $pdf->Cell(23, 10, $invoice['lectura_anterior_fac'], 1, 0, "C");
  $pdf->Cell(21, 10, $invoice['lectura_actual_fac'], 1, 0, "C");
  $pdf->Cell(12, 10, $consumo, 1, 0, "C");
  $pdf->Cell(20, 10, "$" . number_format($invoice['precio_mt_fac']), 1, 0, "C");
  $pdf->Cell(22, 10, "$" . number_format($invoice['cargo_fijo_fac']), 1, 1, "C");
  $pdf->Cell(155, 8, utf8_decode("SUBTOTAL: "), 0, 0, "R");
  $pdf->Cell(33, 8, "$" . number_format($subtotal), 1, 1, "C");
  $pdf->Cell(155, 8, utf8_decode("OTROS CONCEPTOS: "), 0, 0, "R");
  $pdf->Cell(33, 8, "$" . number_format($invoice['cobro_extra_fac']), 1, 1, "C");
  $pdf->Cell(155, 8, utf8_decode("DESCUENTOS: "), 0, 0, "R");
  $pdf->Cell(33, 8, "$" . number_format($invoice['descuento_fac']), 1, 1, "C");
  $pdf->Cell(155, 8, utf8_decode("TOTAL: "), 0, 0, "R");
  $pdf->Cell(33, 8, "$" . number_format($total_factura), 1, 1, "C");
  $pdf->Ln(-30);
  $pdf->SetFont("Arial", "B", 8);
  $numero_facimg = 32;
  $imgqr = "../../views/facturas/codigos/$numero_facimg.png";
  $pdf->Cell(50, 50, $pdf->Image($imgqr, $pdf->GetX(50), $pdf->GetY(10), 50.8), 1, 1, 'R', false);
  $pdf->SetFont("Arial", "B", 9);
  $pdf->Ln(3);
  $pdf->Cell(30, 8, utf8_decode("Observaciones:"), 0, 0, "L");
  $pdf->SetFont("Arial", "I", 8);
  $pdf->MultiCell(158, 8, utf8_decode(strtolower(nl2br($invoice['observacion_fac']))), '', 'J', 0);
  $pdf->SetFont("Arial", "BI", 9);
  $pdf->Cell(155, 8, utf8_decode("¡Es un placer servirte!"), 0, 0, "R");
  $pdf->addPage('P');
}
$pdf->SetTextColor(192, 192, 192);
$pdf->SetFont("Arial", "BI", 52);
$pdf->MultiCell(190, 190, utf8_decode('PÁGINA EN BLANCO'), '', 'J', 0);
$pdf->Output();
//Enviar al correo
$mail2 = new PHPMailer(true);
try {
  //Configurar el servidor
  $mail2->SMTPDebug = 0;
  $mail2->isSMTP();
  $mail2->Host = 'smtp.gmail.com';
  $mail2->SMTPAuth = true;
  $mail2->Username = 'atencionalcliente.asuaveta@gmail.com';
  $mail2->Password = 'Asua12345';
  $mail2->SMTPSecure = 'tls';
  $mail2->Port = 587;
  $mail2->setFrom('atencionalcliente.asuaveta@gmail.com', 'ASUAVETA'); //Remitente (ASUAVETA)
  $mail2->addAddress("atencionalcliente.asuaveta@gmail.com", "ADMINISTRACIÓN ASUAVETA");
  $mensaje2 = "
         <!DOCTYPE html>
         <html lang='es'>
         <head>
           <meta charset='UTF-8'>
           <meta name='viewport' content='width=device-width, initial-scale=1.0'>
           <title>NOTIFICACIÓN ASUAVETA</title>
         
           <style>
           * {
               margin: 0;
               padding: 0;
               box-sizing: border-box;
           }
   
           .container {
               max-width: 1000px;
               width: 90%;
               margin: 0 auto;
               color: white;
           }
   
           .bg-dark {
               background: #40869B;
               margin-top: 40px;
               padding: 20px 0;
           }
   
           .alert {
               font-size: 1.5em;
               position: relative;
               padding: .75rem 1.25rem;
               margin-bottom: 2rem;
               border: 1px solid transparent;
               border-radius: .25rem;
           }
   
           .alert-primary {
               color: white;
               background-color: #1A385B;
               border-color: #40869B;
           }
   
           .img-fluid {
               display: block;
               margin: auto;
           }
   
           .p {
               color: white;
           }
   
           .mensaje {
               width: 90%;
               font-size: 15px;
               margin: 0 auto 40px;
               color: white;
               text-align: justify;
           }
  
           .texto {
               margin-top: 20px;
               color: white;
           }
   
           .footer {
               width: 100%;
               background: #1A385B;
               text-align: center;
               color: white;
               padding: 10px;
               font-size: 14px;
           }
       </style>
         </head>
         <body>
           <div class='container'>
             <div class='bg-dark'>
               <div class='alert alert-primary'>
                 <strong>Mensaje de: </strong>FACTURACIÓN - ASUAVETA
               </div>
               <div class='mensaje'>
                 <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Contactos asuaveta'>
                 <div class='texto'>Cordial saludo...<br><br>Estimados administradores, a continuación nos permitimos enviar la facturación de $periodo_general<br><br></div><br><br><br>
                 <img width='30%' height='10%' class='img-fluid' src='https://i.ibb.co/k0jSqcY/logo.png' alt='Logo asuaveta'>
               </div>
               <div class='footer'>
                !Juntos por un mejor futuro!
               </div>
             </div>
           </div>
         </body>
         </html>
       ";
  $doc = $pdf->Output('S');
  $mail2->AddStringAttachment($doc, "Facturacion_$periodo_general.pdf", 'base64', 'application/pdf');
  //Contenido del correo
  $mail2->isHTML(true);
  $mail2->CharSet = 'UTF-8';
  $mail2->Subject = "FACTURACIÓN $periodo_general - ASUAVETA";
  $mail2->Body = $mensaje2;
  if ($mail2->send()) {
    //Éxito
  }
} catch (Exception $e) {
  //Error de envío
}
