<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
    <link rel="stylesheet" href="../../assets/css/sweetalert2.min.css">
    <script type="text/javascript" src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/sweetalert2.all.min.js"></script>
    <title>BOLETÍN INFORMATIVO</title>
</head>

<body>
    <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'Exception.php';
    require 'PHPMailer.php';
    require 'SMTP.php';
    require_once '../conexion.php';
    //Inserción del correo a la base de datos
    if (isset($_GET['RTHNLSTSLSJDNDNDDKD']) && $_GET['RTHNLSTSLSJDNDNDDKD'] != null) {
        $nuevo_correo = base64_decode($_GET['RTHNLSTSLSJDNDNDDKD']);
        $sql_existe = "SELECT correo_bol FROM tbl_boletin WHERE correo_bol='$nuevo_correo'";
        $consulta_existe = $pdo->prepare($sql_existe);
        $consulta_existe->execute();
        $resultado_existe = $consulta_existe->rowCount();
        if ($resultado_existe) {
            echo "<script>alert('Esta solicitud de suscripción es antigua y no se encuentra habilitada')</script>";
            echo "<script>window.close()</script>";
        } else {
            $fecha_actual_bol = date('Y-m-d');
            $sql_add = "INSERT INTO tbl_boletin (correo_bol, fecha_bol) VALUES (?,?)";
            $consulta_add = $pdo->prepare($sql_add);
            $consulta_add->execute(array($nuevo_correo, $fecha_actual_bol));
    ?>
            <script>
                <?php
                echo "var Corr ='$nuevo_correo';";
                ?>
                Swal.fire({
                    type: 'success',
                    title: '!Suscripción exitosa!',
                    html: "Tu correo (<strong>" + Corr + "</strong>) ha quedado inscrito a nuestro boletín informativo ASUAVETA...",
                    showConfirmButton: false,
                });
                setTimeout(function() {
                    window.location.href = "../../../index.php#boletin";
                }, 4000);
            </script>
    <?php
        }
    }
    //Envío de correos del boletín
    if (isset($_POST['BolAs']) && $_POST['BolAs'] != null && $_POST['BolMens'] != null) {
        $sql_bol = "SELECT correo_bol FROM tbl_boletin";
        $consulta_bol = $pdo->prepare($sql_bol);
        $consulta_bol->execute();
        $resultado_boletin = $consulta_bol->fetchAll();
        if (!$resultado_boletin) {
            echo "<strong>¡No hay ningún usuario suscrito en el boletín informativo!</strong>";
        } else {
            foreach ($resultado_boletin as $datosBol) {
                $BolAsunto = $_POST['BolAs'];
                $BolMensaje = nl2br($_POST['BolMens']);
                $CorreoBol = $datosBol['correo_bol'];
                $link_CancelarBol = "https://www.asuaveta.site/dashboard/controllers/eliminar.php?CANCELAR_SUSCRIPCIONMDDJDNJDNDJDHBDHDBDGFSUJMKDLDDLMDKDNIDN=" . base64_encode($CorreoBol);
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
                    $mail2->addAddress($CorreoBol, "USUARIO ASUAVETA");
                    $mensaje2 = "<!DOCTYPE html>
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
               <strong>BOLETÍN INFORMATIVO - ASUAVETA</strong>
             </div>
             <div class='mensaje'>
               <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Contactos asuaveta'>
               <div class='texto'>$BolMensaje<br><br>Para más información visita nuestro sitio web <a target='_blank' href='https://www.asuaveta.site/'>https://www.asuaveta.site</a>.<br><br><strong>NOTA:</strong><br>Has recibido este mensaje porque te encuentras suscrito a nuestro boletín de información. Si deseas cancelar esta suscripción y dejar de recibir nuestras notificaciones electrónicas del boletín por favor haz click en el siguiente enlace...<br><br><strong><a href='$link_CancelarBol' target='_blank'>$link_CancelarBol</a></strong></div><br><br><br>
               <img width='30%' height='10%' class='img-fluid' src='https://i.ibb.co/k0jSqcY/logo.png' alt='Logo asuaveta'>
             </div>
             <div class='footer'>
              !Juntos por un mejor futuro!
             </div>
           </div>
         </div>
       </body>
       </html>";
                    //Contenido del correo
                    $mail2->isHTML(true);
                    $mail2->CharSet = 'UTF-8';
                    $mail2->Subject = $BolAsunto;
                    $mail2->Body = $mensaje2;
                    if ($mail2->send()) {
                        echo $CorreoBol." <i class='fas fa-check-circle text-success'></i><br>";
                    }
                } catch (Exception $e) {
                    echo "Ha ocurrido un error, por favor valida tu conexión e intenta nuevamente...<br>";
                }
            }
        }
    }
    ?>
</body>

</html>