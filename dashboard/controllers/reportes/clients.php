<?php
session_start();
include_once '../conexion.php';
$id = $_SESSION['id_usu'];
$sql_log = "SELECT id_usu, nombre_usu, apellido_usu, fk_rol_usu FROM tbl_usuario WHERE id_usu =?";
$consulta_log = $pdo->prepare($sql_log);
$consulta_log->execute(array($id));
$resultado_log = $consulta_log->fetch(PDO::FETCH_OBJ);
//Consultar todos los datos de los clientes
$sql = "SELECT id_usu, nombre_usu, apellido_usu, correo_usu, telefono_usu, fecha_registro_usu, fk_rol_usu FROM tbl_usuario WHERE fk_rol_usu=1";
$consulta_sql = $pdo->prepare($sql);
$consulta_sql->execute();
$resultado_sql = $consulta_sql->fetchAll();
//Datos del gerente
$sql_gerente = "SELECT id_usu, nombre_usu, apellido_usu FROM tbl_usuario
WHERE fk_rol_usu =3";
$cons_gerente = $pdo->prepare($sql_gerente);
$cons_gerente->execute();
$gerente = $cons_gerente->fetch(PDO::FETCH_OBJ);
if (!isset($id) || $resultado_log->fk_rol_usu != 2 && $resultado_log->fk_rol_usu != 3) {
    echo "<script> document.location.href='../404.php';</script>";
}
$num_reporte = rand(10000000000, 90000000000);
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
    $pdf->Cell(5, $textypos, "REPORTE SIA #".$num_reporte);
    $pdf->SetFont('Arial', '', 9);
    $pdf->setY(35);
    $pdf->setX(10);
    $pdf->Cell(5, $textypos, utf8_decode("Administración ASUAVETA"));
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
    $pdf->Image('../../../assets/img/user_client.jpg', 98, 40, 14);

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
    $pdf->Cell(190, 5, 'REPORTE DE CLIENTES', 0, 0, 'C');
    $pdf->Ln(6);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(190, 5, 'Los suscriptores registrados en nuestro sistema ASUAVETA hasta la fecha '.strftime("%d de %B del %Y").' son:', 0, 0, 'C');
    /// Apartir de aqui empezamos con la tabla de usuarios
    $pdf->setY(60);
    $pdf->setX(135);
    $pdf->Ln(12);
    // Agregamos los datos del cliente
    /////////////////////////////
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 7, utf8_decode('CC'), 1, 0, 'C', 0);
    $pdf->Cell(85, 7, utf8_decode('NOMBRE'), 1, 0, 'C', 0);
    $pdf->Cell(60, 7, utf8_decode('CORREO'), 1, 0, 'C', 0);
    $pdf->Cell(30, 7, utf8_decode('CELULAR'), 1, 1, 'C', 0);
    $pdf->SetFont('Arial', '', 9);
   foreach ($resultado_sql as $row) {
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 6, utf8_decode($row['id_usu']), 1, 0, 'C', 0);
            $pdf->Cell(85, 6, utf8_decode($row['nombre_usu'].' '.$row['apellido_usu']), 1, 0, 'C', 0);
            $pdf->Cell(60, 6, utf8_decode($row['correo_usu']), 1, 0, 'C', 0);
            $pdf->Cell(30, 6, utf8_decode($row['telefono_usu']), 1, 1, 'C', 0);
    }
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(5, $textypos, "ESTE CERTIFICADO HA SIDO EXPEDIDO POR:");
    $pdf->Ln(7);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Ln();
    $pdf->Cell(5, $textypos, utf8_decode("$resultado_log->nombre_usu $resultado_log->apellido_usu"));
    $pdf->Ln();
    $pdf->Cell(5, $textypos, utf8_decode("CC. $resultado_log->id_usu"));
    $pdf->Ln();
    $pdf->Cell(5, $textypos, utf8_decode("(Admin SIA)"), 'C');
    $pdf->Ln(5);
    $pdf->Cell(5, $textypos, utf8_decode("________________________________________________________________________________________________"), 'C');
    $pdf->Ln(6);
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
?>
