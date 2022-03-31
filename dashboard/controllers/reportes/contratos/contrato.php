<?php
include_once '../../conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../mailer/Exception.php';
require '../../mailer/PHPMailer.php';
require '../../mailer/SMTP.php';
$sql_contrato = "SELECT id_serv, id_usu, nombre_usu, apellido_usu, direccion_usu, correo_usu, fecha_registro_usu, fecha_serv, telefono_usu, fk_estado_serv FROM tbl_usuario AS US 
INNER JOIN tbl_servicio AS SER ON SER.fk_suscriptor_serv=US.id_usu
WHERE id_serv =?";
$cons_contrato = $pdo->prepare($sql_contrato);
$cons_contrato->execute(array(@$_GET['servicio']));
$cliente = $cons_contrato->fetch(PDO::FETCH_OBJ);
//Datos del gerente
$sql_gerente = "SELECT id_usu, nombre_usu, apellido_usu FROM tbl_usuario
WHERE fk_rol_usu =3";
$cons_gerente = $pdo->prepare($sql_gerente);
$cons_gerente->execute();
$gerente = $cons_gerente->fetch(PDO::FETCH_OBJ);
include "../fpdf.php";
$pdf = new FPDF($orientation = 'P', $unit = 'mm');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 20);
$textypos = 5;
$pdf->setY(12);
$pdf->Image('../../../../assets/img/logo.png', 10, 6, 80);
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
$pdf->SetTextColor(24, 206, 15);
$pdf->SetFont('Arial', 'IB', 10);
$pdf->Cell(190, 5, utf8_decode('CONTRATO DE PRESTACIÓN DE SERVICIOS DE ACUEDUCTO'), 0, 1, 'C');
$pdf->SetTextColor(0, 0, 0);
@$pdf->MultiCell(190, 6, utf8_decode("Este contrato se celebra entre la Asociación de Usuarios del Acueducto Veredal ASUAVETA quién para sus efectos se entiende como tal la sociedad por acciones que opera bajo la modalidad de ESAL de acuerdo con las leyes colombianas, con domicilio principal en la vereda la Veta del municipio de Cocorná Antioquia, Colombia por una parte y por la otra el 'SUSCRIPTOR' o 'USUARIO' quien con la compra del servico de acueducto que presta la EMPRESA acepta y se acoge a todas las dispocisiones del presente contrato.\n\nEntre los suscritos a saber, $gerente->nombre_usu $gerente->apellido_usu mayor de edad y vecino de la vereda la Veta, identificado con la cédula de ciudadanía No. $gerente->id_usu obrando en calidad de Gerente y Representante Legal de ASUAVETA; por una parte, y $cliente->nombre_usu $cliente->apellido_usu, mayor de edad y vecino de esta localidad identificado con la cédula de ciudadanía No. $cliente->id_usu, se ha celebrado el siguiente contrato de prestación del servicio público domiciliario de acueducto otorgando el número de conexión $cliente->id_serv al inmueble ubicado en $cliente->direccion_usu, el cual se rige por lo dispuesto en las siguientes cláusulas:\n\n"), 'LRT', 'J', 0);
$pdf->SetTextColor(29, 29, 29);
$pdf->SetFont('Arial', 'I', 10);
$txt = utf8_decode(file_get_contents('contrato.txt'));
@$title = "CONTRATO_$cliente->id_serv - $cliente->id_usu";
$pdf->SetTitle($title);
$pdf->SetAuthor('ASUAVETA');
$pdf->MultiCell(190, 6, $txt, 'LRB', 'J', 0);
$pdf->Ln();
$pdf->SetFont('Arial', 'BI', 10);
$fecha_actual = date('d') . " de " . date('M') . " del año " . date('Y');
$pdf->Cell(5, $textypos, utf8_decode("Cocorná, $fecha_actual."));
$pdf->Ln(15);
$pdf->setX(10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(80, 5, '____________________________________', 0, 0, 'C');
$pdf->Ln(5);
$pdf->setX(10);
$pdf->Cell(80, 5, utf8_decode("$gerente->nombre_usu $gerente->apellido_usu"), 0, 0, 'C');
$pdf->Ln(4);
$pdf->setX(10);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(80, 5, "$gerente->id_usu", 0, 0, 'C');
$pdf->Ln(4);
$pdf->setX(10);
$pdf->Cell(80, 5, 'Gerente', 0, 0, 'C');
$pdf->Ln(-13);
$pdf->setX(120);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(80, 5, '____________________________________', 0, 0, 'C');
$pdf->Ln(5);
$pdf->setX(120);
@$pdf->Cell(80, 5, utf8_decode("$cliente->nombre_usu $cliente->apellido_usu"), 0, 0, 'C');
$pdf->Ln(4);
$pdf->setX(120);
$pdf->SetFont('Arial', '', 10);
@$pdf->Cell(80, 5, "CC. $cliente->id_usu", 0, 0, 'C');
$pdf->Ln(4);
$pdf->setX(120);
$pdf->Cell(80, 5, 'Suscriptor(a)', 0, 0, 'C');
$pdf->Output();
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
    $mail2->addAddress("$cliente->correo_usu", "$cliente->nombre_usu $cliente->apellido_usu");
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
               <strong>Mensaje de: </strong>CONTRATACIÓN - ASUAVETA
             </div>
             <div class='mensaje'>
               <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Contactos asuaveta'>
               <div class='texto'>Hola $cliente->nombre_usu $cliente->apellido_usu...<br><br>La Asociación de Usuarios del Acueducto veredal <strong>ASUAVETA</strong> le informa que se ha realizado una consulta al contrato de prestación de servicios uniformes celebrado entre el mismo Acueducto y el usuario  $cliente->nombre_usu $cliente->apellido_usu. Así mismo se da por hecho que esta información puede ser de tu interés...<br><br>Para una mayor acertividad en la comunicación, adjuntamos en esta notificación electrónica un documento en formato PDF que actúa en calidad de copia del mismo contrato.<br><br>Para más información visita nuestro sitio web <a target='_blank' href='https://www.asuaveta.site'>https://www.asuaveta.site</a>.<br><br>***SE ADJUNTA COPIA DEL CONTRATO**</div><br><br><br>
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
    $mail2->AddStringAttachment($doc, "Contrato_$cliente->id_serv.pdf", 'base64', 'application/pdf');
    //Contenido del correo
    $mail2->isHTML(true);
    $mail2->CharSet = 'UTF-8';
    $mail2->Subject = "COPIA DEL CONTRATO #$cliente->id_serv";
    $mail2->Body = $mensaje2;
    if ($mail2->send()) {
        //éxito
    }
} catch (Exception $e) {
    //Error de envío
}
