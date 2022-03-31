<?php
//Implementación de librerías phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
enviarEmail();
function enviarEmail()
{
  if ($_POST['nombre_callcenter'] != null && $_POST['correo_callcenter'] != null && $_POST['telefono_callcenter'] != null && $_POST['mensaje_callcenter']) {
    //Generamos el número de caso de manera aleatoria
    $DesdeLetra = "A";
    $HastaLetra = "Z";
    $DesdeNumero = 1;
    $HastaNumero = 10000000;
    $letra1 = chr(rand(ord($DesdeLetra), ord($HastaLetra)));
    $letra2 = chr(rand(ord($DesdeLetra), ord($HastaLetra)));
    $letra3 = chr(rand(ord($DesdeLetra), ord($HastaLetra)));
    $numero = rand($DesdeNumero, $HastaNumero);
    $caso = $letra1 . $letra2 . $numero . $letra3;
    //Capturar fecha actual
    $fech = date("l, d  F Y");
    $fecha = $fech . "<br>Hora: " . date("H:i a");
    //mandar correo
    $nombre = $_POST['nombre_callcenter'];
    $correo = $_POST['correo_callcenter'];
    $telefono = $_POST['telefono_callcenter'];
    $mensaje = nl2br($_POST['mensaje_callcenter']);
    $archivos = $_FILES['archivo_callcenter'];
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
      $mail->setFrom('atencionalcliente.asuaveta@gmail.com', $nombre); //Remitente (ASUAVETA)
      $mail->addAddress('atencionalcliente.asuaveta@gmail.com', 'Agente ASUAVETA'); //Destinatario
      $mensaje = "
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
                  .menusu{
                    color: #18CE0F;
                  }
                  
              </style>
                </head>
                <body>
                  <div class='container'>
                    <div class='bg-dark'>
                      <div class='alert alert-primary'>
                        <strong>Mensaje de: </strong> $nombre
                      </div>
                
                      <div class='mensaje'>
                      <!-- Las imagenes se encuentran alojadas en: https://aqua-vital.imgbb.com/ -->
                        <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Fondo río calderas'>
                
                        <div class='texto'>Estimado administrador del SIA - ASUAVETA, reciba usted un cordial saludo... El siguiente mensaje ha sido 
                        enviado desde la plataforma sección de PQRS, recuerda atenderla oportunamente durante el tiempo estipulado. 
                        El mensaje es el siguiente:<br><br><span class='menusu'>$mensaje</span><br><br>Número de PQRS: $caso<br>Fecha de recepción: $fecha<br><br>Si existen archivos adjuntos 
                        por el usuario estos los puedes encontrar en el pie de este correo, por favor verificar. Que tengas un excelente día :)
                        </div>
                        <img width='30%' height='10%' class='img-fluid' src='https://i.ibb.co/k0jSqcY/logo.png' alt='Fondo río calderas'>
                      </div>
                      
                      <div class='footer'>
                        Puedes llamarl@ al número: <span>$telefono</span> o escribirle al correo: <span>$correo</span>
                      </div>
                    </div>
                  </div>
                </body>
                </html>
              ";
      //Contenido del correo
      $mail->isHTML(true);
      $mail->CharSet = 'UTF-8';
      $mail->Subject = 'PQRS - ' . $caso;
      $mail->Body = $mensaje;
      @$archivos = $_FILES['archivo_callcenter'];
      /* $nombre_archivos = null; */
      @$ruta_archivos = $archivos['tmp_name'];
      if (@$archivos['name'][0] != null) {
        @$nombre_archivos = $archivos['name'];
        $i = 0;
        foreach (@$ruta_archivos as $rutas_archivos) {
          @$mail->AddAttachment(@$rutas_archivos, @$nombre_archivos[@$i]);
          $i++;
        }
      }
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
        $mail2->setFrom('atencionalcliente.asuaveta@gmail.com', 'Atención al cliente ASUAVETA'); //Remitente (ASUAVETA)
        $mail2->addAddress($correo, 'Usuario ASUAVETA'); //Destinatario
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
        <strong>Mensaje de: </strong> Equipo de atención al cliente ASUAVETA
      </div>

      <div class='mensaje'>
      <!-- Las imagenes se encuentran alojadas en: https://aqua-vital.imgbb.com/ -->
        <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Fondo río calderas'>

        <div class='texto'>Estimado usuario <strong>($nombre)...<br></strong><strong style='color: #0E1E32'>La empresa de servicios públicos de acueducto
         ASUAVETA te informa que hemos recibido tu PQRS $caso de manera exitosa la cual será atendida en el menor tiempo posible, cualquier duda sobre la 
         información contenida en esta notificación electrónica, favor comunicarse con nosotros por medio de nuestros canales de contacto que puedes 
         encontrar en nuestra plataforma web ASUAVETA</strong><br><br>Fecha de recepción: $fecha<br><br>Este correo ha sido generado por un sistema automático, favor no responder al 
         mismo, si recibiste este correo por error, por favor hacer caso omiso y eliminarlo permanentemente, cualquier duda e inquietud lo puedes 
         consultar en nuestra página oficial <a href='https://www.asuaveta.site' target='_blank'>https://www.asuaveta.site</a></div>
        <img width='30%' height='10%' class='img-fluid' src='https://i.ibb.co/k0jSqcY/logo.png' alt='Imagen ASUAVETA'>
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
        $mail2->Subject = 'PQRS RECIBIDA - ' . $caso;
        $mail2->Body = $mensaje_auto;
        if ($mail2->send()) {
          echo "<script> document.location.href='../../../soporte.php?dhddbufgffudghfuihfuihfhfdifuihfiofhiofdhfdiohofdihfiohfihfiofhfiohfiohfdohfiohfiohfiohfdiohfiohfiohfuihfiohvfihvuiofhvouifvhufvhfvhfvfifhvfhfvihfiofjijfijfiojfiojf1';</script>";
        } else {
          echo "<script> document.location.href='../../../soporte.php?dhddbufgffudghfuihfuihfhfdifuihfiofhiofdhfdiohofdihfiohfihfiofhfiohfiohfdohfiohfiohfiohfdiohfiohfiohfuihfiohvfihvuiofhvouifvhufvhfvhfvfifhvfhfvihfiofjijfijfiojfiojf2';</script>";
        }
      }
    } catch (Exception $e) {
      echo "<script> document.location.href='../../../soporte.php?dhddbufgffudghfuihfuihfhfdifuihfiofhiofdhfdiohofdihfiohfihfiofhfiohfiohfdohfiohfiohfiohfdiohfiohfiohfuihfiohvfihvuiofhvouifvhufvhfvhfvfifhvfhfvihfiofjijfijfiojfiojf2';</script>";
    }
  } else {
    echo "<script> document.location.href='../../../soporte.php?dhddbufgffudghfuihfuihfhfdifuihfiofhiofdhfdiohofdihfiohfihfiofhfiohfiohfdohfiohfiohfiohfdiohfiohfiohfuihfiohvfihvuiofhvouifvhufvhfvhfvfifhvfhfvihfiofjijfijfiojfiojf2';</script>";
    return false;
  }
}
