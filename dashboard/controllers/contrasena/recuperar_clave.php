<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mailer/Exception.php';
require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
enviarEmail();
function enviarEmail()
{
    $mail = new PHPMailer;
    include('../conexion.php');
    $documentorec = $_POST['documento_recuperar'];
    $sql_contra1  = "SELECT correo_usu, id_usu, nombre_usu FROM tbl_usuario WHERE id_usu='$documentorec' LIMIT 1";
    $cons_contra1 = $pdo->prepare($sql_contra1);
    $cons_contra1->execute();
    $a = $cons_contra1->fetch(PDO::FETCH_OBJ);
    if (!$a) {
        echo "No se ha encontrado ninguna cuenta con el documento <strong>$documentorec<br>Valida la información e intenta nuevamente...</strong>";
    } else {
        @$cedula = $a->id_usu;
        @$email = $a->correo_usu;
        //Configurar el servidor
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'atencionalcliente.asuaveta@gmail.com';
        $mail->Password = 'Asua12345';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        //Configuración de los correos 
        $mail->setFrom('atencionalcliente.asuaveta@gmail.com', 'CUENTAS - ASUAVETA'); //Remitente (Ceiba)
        $mail->addAddress($email, 'USUARIO ASUAVETA'); //Destinatario
        //generar una clave aleatoria y el token
        $token = md5($a->id_usu . time() . rand(1000, 9999));
        $clave_nueva = rand(10000000, 99999999);
        $link = "http://localhost/asuaveta/dashboard/controllers/contrasena/recuperar_clave_confirmar.php?e=$cedula&t=$token";
        $mensaje = "<!DOCTYPE html>
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
            <strong>Mensaje de: </strong>ADMINISTRACIÓN - ASUAVETA
          </div>
          <div class='mensaje'>
            <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Contactos asuaveta'>
            <div class='texto'><p style='color:white'>HOLA $a->nombre_usu...</p>
            <p style='color:white'>Nuestro sistema ha generado una nueva contraseña para ti: <code style='background: lightyellow; color: darkred; padding: 1px 2px;'>$clave_nueva</code></p>
            <p style='color:white'>Para iniciar sesión, debes hacer <a href='$link'>click en este vínculo</a> o pegar el siguiente link en la URL de tu navegador:</p><br><br>
            <div style='text-align:center;'>
                <code style='background: black; color: #E1EBF2; padding: 4px;'>$link</code><br><br><br>
            </div>
            <p style='color:white'>Si no haz realizado esta solicitud, por favor ignora este mensaje...</p></div><br><br><br>
            <img width='30%' height='10%' class='img-fluid' src='https://i.ibb.co/k0jSqcY/logo.png' alt='Logo asuaveta'>
          </div>
          <div class='footer'>
           !Ha sido un placer servirte!
          </div>
        </div>
      </div>
    </body>
    </html>";
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'RECUPERA TU CONTRASEÑA';
        $mail->Body = $mensaje;
        if (!$mail->send()) {
            echo "Hubo un error al procesar la solicitud, valida tu conexión e intenta nuevamente...";
        } else {
            $c2 = "INSERT INTO tbl_recuperar_pass SET cedula_rec='$cedula', token_rec='$token', fecha_rec=NOW(), clave_nueva_rec='$clave_nueva' ON DUPLICATE KEY UPDATE token_rec='$token', fecha_rec=NOW(), clave_nueva_rec='$clave_nueva'";
            $consulta_insertar = $pdo->prepare($c2);
            //Ejecutar la sentencia
            $consulta_insertar->execute();
            echo 1;
        }
    }
}
