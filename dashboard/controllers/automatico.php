<?php
include_once 'conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/Exception.php';
require 'mailer/PHPMailer.php';
require 'mailer/SMTP.php';
//Suspender servicio automáticamente si supera la fecha límite de la segunda factura ***************
$sql_sus = "SELECT correo_usu, nombre_usu, apellido_usu, direccion_usu, id_serv, fk_suscriptor_serv, MAX(fecha_actual_fac) AS fechmax, COUNT(A.fk_estado_fac) AS repite FROM tbl_factura A
INNER JOIN tbl_servicio B ON B.id_serv=A.fk_servicio_fac
INNER JOIN tbl_usuario AS USU ON USU.id_usu=B.fk_suscriptor_serv
WHERE fk_estado_fac =7 AND fk_estado_serv=1 GROUP BY B.id_serv";
$consulta_sus = $pdo->prepare($sql_sus);
$consulta_sus->execute();
$cantidad_fac = $consulta_sus->rowCount();
$mora = $consulta_sus->fetchAll();
foreach ($mora as $susp) :
    $susp['repite'];
    if ($susp['repite'] == 2) {
        $factura2 = $susp['fechmax'];
        $cal_lim = strtotime(date($factura2) . "+ 15 days");
        $limit_fech = date("Y-m-d", $cal_lim);
        if (date('Y-m-d') > date($limit_fech)) {
            //Suspender el servicio
            $editar_serv = "UPDATE tbl_servicio SET fk_estado_serv=3 WHERE id_serv=?";
            $base_editar = $pdo->prepare($editar_serv);
            $base_editar->execute(array($susp['id_serv']));
            //Enviar correo al usuario informando la suspensión
            $servcorr = $susp['id_serv'];
            $nom_sev_corr = $susp['nombre_usu'] . " " . $susp['apellido_usu'];
            $dir_serv_corr = $susp['direccion_usu'];
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
                $mail2->addAddress($susp['correo_usu'], $nom_sev_corr);
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
                           <strong>Mensaje de: </strong>ADMINISTRACIÓN - ASUAVETA
                         </div>
                         <div class='mensaje'>
                           <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Contactos asuaveta'>
                           <div class='texto'>Reciba usted un cordial saludo...<br><br>Estimado(a) <strong>$nom_sev_corr</strong>, la Asociación de Usuarios del acueducto veredal (ASUAVETA) le informa que su servicio de acueducto <strong>#$servcorr</strong> ubicado en la dirección <strong>$dir_serv_corr</strong>, tiene una orden de suspensión vigente ya que la fecha límite de cancelación de tu última factura fue el pasado <strong>$limit_fech</strong>. Te invitamos a realizar los pagos pendientes para evitar la suspensión física del servicio y continuar disfrutando del mismo.<br><br>Recuerda que puedes hacer uso de nuestra página web <a href='https://www.asuaveta.site' target='_blank'>www.asuaveta.site</a> donde podrás consultar y/o descargar tu factura, revisar el estado de tus servicios y cuentas pendientes, radicar Peticiones, Quejas, Reclamos (PQR), y mantenerte informado sobre todas las noticias que <strong>ASUAVETA</strong> tiene para ti. ¿Qué esperas?</div><br><br><br>
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
                //Contenido del correo
                $mail2->isHTML(true);
                $mail2->CharSet = 'UTF-8';
                $mail2->Subject = "¡SERVICIO #$servcorr SUSPENDIDO!";
                $mail2->Body = $mensaje2;
                if ($mail2->send()) {
                    //Éxito
                }
            } catch (Exception $e) {
                //Error de envío
            }
        }
    }
endforeach;
//Calcular tiempo de caducidad de una solitud de servicios ****************
$CnS = "SELECT id_serv, fecha_serv, correo_usu, nombre_usu, apellido_usu, direccion_usu, fk_suscriptor_serv, direccion_usu, fecha_registro_usu, telefono_usu FROM tbl_servicio 
INNER JOIN tbl_usuario ON id_usu=fk_suscriptor_serv
WHERE fk_estado_serv=4";
$CnS_consulta = $pdo->prepare($CnS);
$CnS_consulta->execute();
$datosexpira = $CnS_consulta->fetchAll();
foreach ($datosexpira as $elim) {
    $actual = date('Y-m-d');
    $anterior = $elim['fecha_serv'];
    $rad = $elim['id_serv'];
    $elim_correo = $elim['correo_usu'];
    $elim_nombre = $elim['nombre_usu'] . ' ' . $elim['apellido_usu'];
    $elim_dir = $elim['direccion_usu'];
    $docUsu = $elim['fk_suscriptor_serv'];
    $mod_date = strtotime(date($anterior) . "+ 5 days");
    $fecha_limite = date("Y-m-d", $mod_date);
    if ($actual > $fecha_limite) {
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
            $mail2->addAddress($elim_correo, $elim_nombre);
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
                       <strong>Mensaje de: </strong>ADMINISTRACIÓN - ASUAVETA
                     </div>
                     <div class='mensaje'>
                       <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Contactos asuaveta'>
                       <div class='texto'>Cordial saludo...<br><br>Estimado usuario <strong>$elim_nombre</strong>, la Asociación de Usuarios del acueducto veredal (ASUAVETA) le informa que la solicitud de contratación de prestación de servicio de acueducto <strong>#$rad</strong> realizada el día <strong>$anterior</strong> para el inmueble ubicado en <strong>$elim_dir</strong>, ha caducado por falta de confirmación ya que han pasado cinco (5) días desde que se realizó. Si deseas continuar con el trámite, puedes radicar una nueva solicitud en cualquier momento...<br><br>Consulta esta y otra información en <a href='https://www.asuaveta.site' target='_blank'>www.asuaveta.site</a>.</div><br><br><br>
                       <img width='30%' height='10%' class='img-fluid' src='https://i.ibb.co/k0jSqcY/logo.png' alt='Logo asuaveta'>
                     </div>
                     <div class='footer'>
                      !Ha sido un placer servirte!
                     </div>
                   </div>
                 </div>
               </body>
               </html>
             ";
            //Contenido del correo
            $mail2->isHTML(true);
            $mail2->CharSet = 'UTF-8';
            $mail2->Subject = "¡SOLICITUD #$rad CADUCADA!";
            $mail2->Body = $mensaje2;
            if ($mail2->send()) {
                //Eliminar servicio
                $sql_eliminarCnS = "DELETE FROM tbl_servicio WHERE id_serv =?";
                $cons_elim = $pdo->prepare($sql_eliminarCnS);
                $cons_elim->execute(array($rad));
                //Eliminar usuario
                $sql_elimUs = "DELETE FROM tbl_usuario WHERE id_usu =?";
                $cons_elimUs = $pdo->prepare($sql_elimUs);
                $cons_elimUs->execute(array($docUsu));
            }
        } catch (Exception $e) {
            //Error de envío
        }
    }
}
