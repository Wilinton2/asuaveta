<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/Exception.php';
require 'mailer/PHPMailer.php';
require 'mailer/SMTP.php';
include_once 'conexion.php';
if (isset($_POST['btn_perfil'])) {
    $contravieja = sha1($_POST['contravieja']);
    $contrasena_confirm1 = sha1($_POST['contrasena_confirm1']);
    $contrasena_confirm2 = sha1($_POST['contrasena_confirm2']);
    $persona = $_POST['usuario'];
    $sql_contra1  = "SELECT contrasena_usu FROM tbl_usuario WHERE id_usu=? AND contrasena_usu=?";
    $cons_contra1 = $pdo->prepare($sql_contra1);
    $cons_contra1->execute(array($persona, $contravieja));
    $contraexiste  = $cons_contra1->rowCount();
    $contradato  = $cons_contra1->fetch(PDO::FETCH_OBJ);
    if (@$contradato->contrasena_usu == $contravieja) {
        if (@$contrasena_confirm1 == $contrasena_confirm2) {
            $base_editar_perfil = "UPDATE tbl_usuario SET contrasena_usu=? WHERE id_usu=?";
            $base_editar = $pdo->prepare($base_editar_perfil);
            $base_editar->execute(array($contrasena_confirm2, $persona));
            echo "<script>alert('¡Se cambió la contraseña!');</script>";
            echo "<script>document.location.href='../views/perfil.php';</script>";
        } else {
            //En caso de que la  contraseña dos no sea conforme a la primera
            echo "<script>alert('Las contraseñas ingresadas no coinciden');</script>";
            echo "<script>document.location.href='javascript:history.back()';</script>";
        }
    } else {
        echo "<script>alert('¡Contraseña incorecta!');</script>";
        echo "<script>document.location.href='javascript:history.back()';</script>";
    }
}
if (isset($_POST['EditContCorreo'])) {
    $correoE = $_POST['EditContCorreo'];
    $telefonoE = $_POST['EditContTel'];
    $usuE = $_POST['EditContUsu'];
    $base_editar_perfil = "UPDATE tbl_usuario SET correo_usu=?, telefono_usu=? WHERE id_usu=?";
    $base_editar = $pdo->prepare($base_editar_perfil);
    $base_editar->execute(array($correoE, $telefonoE, $usuE));
    echo "<script>alert('La información se ha guardado exitosamente, ¡Gracias por mantenerte actualizado!');</script>";
    echo "<script>document.location.href='../views/perfil.php';</script>";
}




if (isset($_POST['CogUsNombre'])) {
    $nombre = $_POST['CogUsNombre'];
    $apellido = $_POST['CogUsApellido'];
    $documento = $_POST['CogUsDocumento'];
    $telefono_uno = $_POST['CogUsTelefono'];
    $correo = $_POST['CogUsCorreo'];
    $direccion = $_POST['CogUsDireccion'];
    $estado = $_POST['CogUsEstado'];
    $usuario = $_POST['CogUsIdUsu'];
    //Aquí va todo el proceso SQL para editar los datos
    $editar_usuario = "UPDATE tbl_usuario SET nombre_usu=?, apellido_usu=?, id_usu=?, telefono_usu=?, correo_usu=?, direccion_usu=?, fk_estado_usu=? WHERE id_usu=?";
    $base_editar = $pdo->prepare($editar_usuario);
    $base_editar->execute(array($nombre, $apellido, $documento, $telefono_uno, $correo, $direccion, $estado, $usuario));
    echo 1;
}
//Editar publicación y estado
if (isset($_POST['not_idpubli1'])) {
    $titulo_publi = $_POST['nottitulo1'];
    $cuerpo_publi = $_POST['notcuerpo1'];
    $fk_estado_publi = $_POST['notestado1'];
    $fk_categoria_publi = $_POST['notcategoria1'];
    $id_publi = $_POST['not_idpubli1'];
    $editar_tar = "UPDATE tbl_publicacion SET titulo_publi=?, cuerpo_publi=?, fk_estado_publi=?, fk_categoria_publi=? WHERE id_publi=?";
    $base_tarif = $pdo->prepare($editar_tar);
    $base_tarif->execute(array($titulo_publi, $cuerpo_publi, $fk_estado_publi, $fk_categoria_publi, $id_publi));
    echo "<script>document.location.href='../views/publicaciones.php#id_public$id_publi';</script>";
}
//Aprobar comentario
if (@$_POST['IdComentario'] != null) {
    $estado_aprobado = 6;
    $editar_tar = "UPDATE tbl_comentario SET fk_estado_com=? WHERE id_com=?";
    $base_tarif = $pdo->prepare($editar_tar);
    $base_tarif->execute(array($estado_aprobado, $_POST['IdComentario']));
    echo "El comentario ha sido aprobado y publicado exitosamente...";
}
//Editar tarifa
if (isset($_POST['id_de_tarifa_editar'])) {
    $idtar = $_POST['id_de_tarifa_editar'];
    $cargo = str_replace(',', '', $_POST['cargo']);
    $metro = str_replace(',', '', $_POST['precio']);
    if ($idtar == 1 && $cargo != 0) {
        echo 23;
    } else {
        $editar_tar = "UPDATE tbl_tarifa SET cargo_fijo_tar=?, precio_mt_tar=? WHERE id_tar=?";
        $base_tarif = $pdo->prepare($editar_tar);
        $base_tarif->execute(array($cargo, $metro, $idtar));
        if ($base_tarif) {
            $itc = '$' . number_format($cargo);
            $itm = '$' . number_format($metro);
            echo "La tarifa <strong>$idtar</strong> se ha actualizado correctamente con los siguientes valores:<br><br><strong>Cargo fijo: </strong>$itc<br><strong>M3: </strong>$itm<br>¡Gracias!";
        }
    }
}
//Editar la tarifa de un servicio específico
if (isset($_POST['TarifaServicioEdit']) && $_POST['IdServicioEditar']) {
    $TarIfa = $_POST['TarifaServicioEdit'];
    $SerVicio = $_POST['IdServicioEditar'];
    $editar_tar2 = "UPDATE tbl_servicio SET fk_tarifa_serv=? WHERE id_serv=?";
    $base_tarif2 = $pdo->prepare($editar_tar2);
    $base_tarif2->execute(array($TarIfa, $SerVicio));
    echo 5;
}
//Editar el contenido del texto plano del contrato
if (isset($_POST["newdata"])) {
    $newdata = $_POST['newdata'];
    if (@$fp = fopen("reportes/contratos/contrato.txt", "w")) {
        fwrite($fp, stripslashes($newdata));
        fclose($fp);
        echo 54;
    }
}
if (isset($_POST['DocPass'])) {
    $Pass1 = sha1($_POST['Pass1']);
    $Pass2 = sha1($_POST['Pass2']);
    $DocPass = $_POST['DocPass'];
    if ($Pass1 == $Pass2 && $DocPass != null) {
        $sql_contra  = "SELECT id_usu, contrasena_usu FROM tbl_usuario WHERE id_usu=? AND contrasena_usu IS NULL";
        $cons_contra = $pdo->prepare($sql_contra);
        $cons_contra->execute(array($DocPass));
        $datoscontra  = $cons_contra->fetch(PDO::FETCH_OBJ);
        if (@$datoscontra->id_usu == $DocPass && $datoscontra->contrasena_usu == null) {
            $editar_contr = "UPDATE tbl_usuario SET contrasena_usu=? WHERE id_usu=?";
            $base_contr = $pdo->prepare($editar_contr);
            $base_contr->execute(array($Pass2, $DocPass));
            //Crearle la SESSION
            session_start();
            $_SESSION['id_usu'] = $DocPass;
            echo 1;
        } else {
            echo "<strong>Lo sentimos...</strong><br>Debido a que ya se asignó una contraseña a esta cuenta, no es posible guardar la información. Si olvidaste tu contraseña dirígete a nuestra opción de recuperar contraseña...";
        }
    } else {
        echo "Puedes estar accediendo de forma incorrecta. Si el problema persiste puedes ponerte en contacto con nosotros...<br><br><strong>¡Muchas gracias!</strong>";
    }
}
if (isset($_POST['RadSol'])) {
    $radicado = $_POST['RadSol'];
    $cliente = $_POST['docSol'];
    $tarifa = $_POST['TarSol'];
    $sql_existe = "SELECT id_serv, fecha_serv, fk_estado_serv, fk_tarifa_serv, fk_suscriptor_serv, nombre_usu, apellido_usu, correo_usu, id_usu, telefono_usu, direccion_usu, fecha_registro_usu, id_tar, cargo_fijo_tar, precio_mt_tar FROM tbl_servicio
    INNER JOIN tbl_usuario ON id_usu=fk_suscriptor_serv
    INNER JOIN tbl_tarifa ON id_tar=fk_tarifa_serv
    WHERE id_serv =? AND fk_estado_serv=4";
    $consulta_existe = $pdo->prepare($sql_existe);
    $consulta_existe->execute(array($radicado));
    $existe = $consulta_existe->rowCount();
    $exdatos = $consulta_existe->fetch(PDO::FETCH_OBJ);
    if (!$existe) {
        echo "Estimado administrador del <strong>SIA</strong>, te informamos que el rádicado <strong>$radicado</strong> no tiene ningún proceso de contratación vigente.<br><br><strong>Por favor verifica e intenta nuevamente...</strong>";
    } elseif ($exdatos->fk_suscriptor_serv == $cliente) {
        //Se activa el servicio
        $link_crear = "https://www.asuaveta.site/dashboard/views/crear_pass.php?NU=" . base64_encode($exdatos->id_serv);
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
            $mail2->addAddress("$exdatos->correo_usu", "$exdatos->nombre_usu $exdatos->apellido_usu");
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
               <div class='texto'>Hola $exdatos->nombre_usu $exdatos->apellido_usu...<br><br>La Asociación de Usuarios del Acueducto veredal <strong>ASUAVETA</strong> te da la bienvenida a su comunidad. Te informamos que después de haber pasado satisfactoriamente por el proceso de validación, tu solicitud de contratación #<strong>$exdatos->id_serv</strong> se ha concluído de manera exitosa. Tu registro se ha realizado con la siguiente información:<br><br><strong>FECHA DE REGISTRO: </strong> $exdatos->fecha_registro_usu<br><br><strong>NOMBRE DEL TITULAR: </strong> $exdatos->nombre_usu $exdatos->apellido_usu<br><br><strong>DOCUMENTO: </strong> $exdatos->id_usu<br><br><strong>CELULAR: </strong> $exdatos->telefono_usu<br><br><strong>CORREO: </strong> $exdatos->correo_usu<br><br><strong>DIRECCIÓN DEL INMUEBLE: </strong> $exdatos->direccion_usu<br><br><strong>TIPO DE USUARIO: </strong> SUSCRIPTOR<br><br><strong>CÓDIGO DEL SERVICIO / #CONTRATO: </strong> $exdatos->id_serv<br><br><strong>ESTADO DEL SERVICIO: </strong> ACTIVO<br><br><strong>FECHA DE APROBACIÓN DEL SERVICIO: </strong> $exdatos->fecha_serv<br><br><strong><br><br>Queremos que tengas en cuenta que los días de consumo no van a afectar el valor de tu factura, puesto que únicamente se cobrará el valor de los metros consumidos cuando se te instale el servicio.<br><br><strong>¡INFORMACIÓN IMPORTANTE!</strong><br><br>Hemos habilitado un conjunto de servicios web a tu disposición donde podrás realizar trámites ante la empresa, realizar consultas sobre tus facturas, servicios, tarifa asignada y otras funciones que nos ayudarán a mentenernos conectados sin salir de casa, solo debes iniciar sesión en el siguiente enlace <a target='_blank' href='$link_crear'>Crear clave segura</a>.<br><br>Consulta esta y otra información en <a href='www.asuaveta.site' target='_blank'>www.asuaveta.site</a>.</div><br><br><br>
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
            $mail2->Subject = "¡CONTRATACIÓN #$exdatos->id_serv EXITOSA!";
            $mail2->Body = $mensaje2;
            if ($mail2->send()) {
                $fchactual = date('Y-m-d');
                //Activar servicio
                $editsol = "UPDATE tbl_servicio SET fecha_serv=?, fk_estado_serv=1, fk_tarifa_serv=$tarifa WHERE id_serv=?";
                $basesol = $pdo->prepare($editsol);
                $basesol->execute(array($fchactual, $radicado));
                //Activar cuenta
                $docActivar = $exdatos->id_usu;
                $activar_cuenta = "UPDATE tbl_usuario SET fk_estado_usu=1 WHERE id_usu=$docActivar";
                $base_activar = $pdo->prepare($activar_cuenta);
                $base_activar->execute();
                //Se genera la factura de compra de derecho del servicio
                $lectura_anterior_fac = "0000";
                $lectura_actual_fac = "0000";
                $fecha_anterior_fac = date('Y-m-d');
                $fecha_actual_fac = date('Y-m-d');
                $cobro_extra_fac = 980000;
                $descuento_fac = 0;
                $observacion_fac = "Esta es la factura de venta del derecho de acueducto público de la empresa ASUAVETA";
                $tarifa_fac = 0;
                $cargo_fijo_fac = 0;
                $precio_mt_fac = 0;
                $fk_estado_fac = 7;
                $fk_servicio_fac = $radicado;
                //Insertar datos de factura en la tabla factura
                $sql_insertar = "INSERT INTO tbl_factura (lectura_anterior_fac, lectura_actual_fac, fecha_anterior_fac, fecha_actual_fac, cobro_extra_fac, descuento_fac, observacion_fac, tarifa_fac, cargo_fijo_fac, precio_mt_fac, fk_estado_fac, fk_servicio_fac) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
                $consulta_insertar = $pdo->prepare($sql_insertar);
                $consulta_insertar->execute(array($lectura_anterior_fac, $lectura_actual_fac, $fecha_anterior_fac, $fecha_actual_fac, $cobro_extra_fac, $descuento_fac, $observacion_fac, $tarifa_fac, $cargo_fijo_fac, $precio_mt_fac, $fk_estado_fac, $fk_servicio_fac));
                //Generar código QR de la factua
                $sqlqr = "SELECT numero_fac FROM tbl_factura ORDER BY numero_fac DESC";
                $ln = $pdo->prepare($sqlqr);
                $ln->execute();
                $ultima = $ln->fetch(PDO::FETCH_OBJ);
                $nameimg = $ultima->numero_fac;
                //Link para ir al pago (Se almacena en el QR code)
                @$link_pago = 'https://www.asuaveta.site/dashboard/views/facturas/receive_payment.php?asua22=' . base64_encode($nameimg);
                include('phpqrcode/qrlib.php');
                $codesDir = "../views/facturas/codigos/";
                $codeFile = $nameimg . '.png';
                $calidad = "H";
                $tamaño = 4;
                QRcode::png(@$link_pago, @$codesDir . @$codeFile, $calidad, $tamaño);
                $perio = strftime("%B del año %Y", strtotime($fecha_anterior_fac));
                echo 5;
            }
        } catch (Exception $e) {
            echo "Ha ocurrido un error al activar el servicio, valida tu conexión e intenta nuevamente...";
        }
    } else {
        echo "La solicitud <strong>$radicado</strong> no pertenece al usuario con el documento <strong>$cliente</strong>.<br><br>Por favor verifica e intenta nuevamente...";
    }
}
