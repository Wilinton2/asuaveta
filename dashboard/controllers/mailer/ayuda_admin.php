<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
enviarEmail();
function enviarEmail()
{
  require_once '../conexion.php';
  //Selección de datos del administrador
  $id_admin = $_POST['id_admin'];
  $id_usuario = $_POST['id_usuario'];
  $mensaje_usuario = nl2br($_POST['mensaje_usuario']);
  $sql_select_admin = "SELECT id_usu, nombre_usu, apellido_usu, correo_usu FROM tbl_usuario 
WHERE id_usu=?";
  $consulta_select_admin = $pdo->prepare($sql_select_admin);
  $consulta_select_admin->execute(array($id_admin));
  $admin = $consulta_select_admin->fetch(PDO::FETCH_OBJ);
  //Selección de datos del usuario
  $sql_select_usuario = "SELECT id_usu, nombre_usu, apellido_usu, correo_usu, telefono_usu FROM tbl_usuario 
WHERE id_usu=?";
  $consulta_select_usuario = $pdo->prepare($sql_select_usuario);
  $consulta_select_usuario->execute(array($id_usuario));
  $usuario = $consulta_select_usuario->fetch(PDO::FETCH_OBJ);
  //Radicado
  $DesdeLetra = "A";
  $HastaLetra = "Z";
  $DesdeNumero = 1;
  $HastaNumero = 100000;
  $letra1 = chr(rand(ord($DesdeLetra), ord($HastaLetra)));
  $letra2 = chr(rand(ord($DesdeLetra), ord($HastaLetra)));
  $letra3 = chr(rand(ord($DesdeLetra), ord($HastaLetra)));
  $numero = rand($DesdeNumero, $HastaNumero);
  $radicado = $letra1 . $letra2 . $letra3 . $numero;
  if (isset($_POST)) {
    //mandar correo
    $mensajito = "Estimado(a) administrador(a) $admin->nombre_usu $admin->apellido_usu, reciba usted un cordial saludo...<br><br>El Sistema de Información Web para la gestión de procesos Administrativos (SIA) le informa que el usuario $usuario->nombre_usu $usuario->apellido_usu, se ha comunicado contigo desde el panel de contacto directo (Ayuda web).<br><br>El registro de la comunicación se ha realizado con la siguiente información:<br><br>USUARIO: $usuario->nombre_usu $usuario->apellido_usu<br>CÉDULA: $usuario->id_usu<br>CORREO: $usuario->correo_usu<br>TELÉFONO: $usuario->telefono_usu <br>RADICADO: $radicado<br>MENSAJE:<br><strong style='color: green'>$mensaje_usuario</strong><br><br>Recuerda atender oportunamente esta solicitud. Muchas gracias por contribuir a un mejor futuro :)";
    $mail = new PHPMailer(true);
    try {
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
      $mail->setFrom($usuario->correo_usu, $usuario->nombre_usu . ' ' . $usuario->apellido_usu); //Remitente (ASUAVETA)
      $mail->addAddress($admin->correo_usu, $admin->nombre_usu); //Destinatario
      $mensaje = "
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
                        <strong>Mensaje de: </strong>$usuario->nombre_usu
                      </div>
                
                      <div class='mensaje'>
                      <!-- Las imagenes se encuentran alojadas en: https://aqua-vital.imgbb.com/ -->
                        <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Fondo río calderas'>
                
                        <div class='texto'>$mensajito</div>
                        <img width='30%' height='10%' class='img-fluid' src='https://i.ibb.co/k0jSqcY/logo.png' alt='Imagen asua veta'>
                      </div>
                      
                      <div class='footer'>
                       Responde al correo: $usuario->correo_usu
                      </div>
                    </div>
                  </div>
                </body>
                </html>
              ";
      //Contenido del correo
      $mail->isHTML(true);
      $mail->CharSet = 'UTF-8';
      $mail->Subject = 'CONTACTO DIRECTO - '. $radicado;
      $mail->Body = $mensaje;
      if ($mail->send()) {
        $mail2 = new PHPMailer(true);
        //Configurar el servidor
        $mail2->SMTPDebug = 0;
        $mail2->isSMTP();
        $mail2->Host = 'smtp.gmail.com';
        $mail2->SMTPAuth = true;
        $mail2->Username = 'atencionalcliente.asuaveta@gmail.com';
        $mail2->Password = 'Asua12345';
        $mail2->SMTPSecure = 'tls';
        $mail2->Port = 587;
        //Configuración de los correos 
        $mail2->setFrom('atencionalcliente.asuaveta@gmail.com', 'RECEPCIÓN - ASUAVETA'); //Remitente (ASUAVETA)
        $mail2->addAddress($usuario->correo_usu, $usuario->nombre_usu." ".$usuario->apellido_usu); //Destinatario
        $reaccion="Estimado(a) cliente $usuario->nombre_usu $usuario->apellido_usu, reciba usted un cordial saludo...<br><br>El Sistema de Información Web para la gestión de procesos Administrativos (SIA) le informa que el administrador $admin->nombre_usu $admin->apellido_usu, ha recibido satisfactoriamente tu solicitud. Se recomienda estar atento a tu dirección de correo electrónico registrada ya que por este medio es que el asesor se comunicará contigo lo más pronto posible. Ten en cuenta que según sea el caso, es posible que se comunique contigo a tu número de contacto registrado en el sistema ($usuario->telefono_usu)<br><br>El registro de la comunicación se ha realizado con la siguiente información:<br><br>USUARIO: $usuario->nombre_usu $usuario->apellido_usu<br>CÉDULA: $usuario->id_usu<br>CORREO: $usuario->correo_usu<br>TELÉFONO: $usuario->telefono_usu<br>RADICADO: $radicado<br>MENSAJE:<br><strong style='color: green'>$mensaje_usuario</strong><br><br>Muchas gracias por hacer uso de nuestros canales virtuales de atención.";
        $mensaje_auto = "
<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>Mensaje</title>

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
      font-weight:bold;
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
        <strong>Mensaje de: </strong> RECEPCIÓN - ASUAVETA
      </div>

      <div class='mensaje'>
      <!-- Las imagenes se encuentran alojadas en: https://aqua-vital.imgbb.com/ -->
        <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Imagen Asua veta'>

        <div class='texto'>$reaccion</div>
        <img width='30%' height='10%' class='img-fluid' src='https://i.ibb.co/k0jSqcY/logo.png' alt='Fondo río calderas'>
      </div>
      
      <div class='footer'>
        ¡Es un placer servirte!
      </div>
    </div>
  </div>
</body>
</html>
";
        $mail2->isHTML(true);
        $mail2->CharSet = 'UTF-8';
        $mail2->Subject = 'SOLICITUD RECIBIDA - ' . $radicado;
        $mail2->Body = $mensaje_auto;


        if ($mail->send() && $mail2->send()) {
          echo 1;
        }else {
          $mail->ErrorInfo;
        }

      }
    } catch (Exception $e) {
      echo "<script>alert('Hubo un error al enviar el mensaje y/o activar la cuenta');</script>";
      echo 'Hubo un error al enviar el mensaje: ', $mail->ErrorInfo;
    }
  } else {
    return;
  }
}
