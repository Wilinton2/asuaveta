    <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'mailer/Exception.php';
    require 'mailer/PHPMailer.php';
    require 'mailer/SMTP.php';
    include_once 'conexion.php';
    //Registro de administrador del SIA
    if (isset($_POST['newS_docAdministr'])) {
        $nombre = $_POST['newS_nom'];
        $apellido = $_POST['newS_ape'];
        $documento = $_POST['newS_docAdministr'];
        $telefono = $_POST['newS_tel'];
        $correo = $_POST['newS_cor'];
        $direccion = $_POST['newS_dir'];
        $rol = 2;
        $estado = 1;
        $foto = "perfil_defecto_aqua123.png";
        //Consulta si el usuario ya existe en la base de datos
        $sql_existe = "SELECT id_usu FROM tbl_usuario WHERE id_usu=?";
        $consulta_existe = $pdo->prepare($sql_existe);
        $consulta_existe->execute(array($documento));
        $resultado_existe = $consulta_existe->rowCount();
        $existe_usu = $consulta_existe->fetch(PDO::FETCH_OBJ);
        if ($resultado_existe) {
            echo "<strong>El usuario ya existe</strong>";
        } else {
            $link_new_admin = "https://www.asuaveta.site/dashboard/views/crear_pass.php?NEW_ADMIN_SIA_ASUAVETA=" . base64_encode($documento);
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'atencionalcliente.asuaveta@gmail.com';
                $mail->Password = 'Asua12345';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('atencionalcliente.asuaveta@gmail.com', 'ASUAVETA'); //Remitente (ASUAVETA)
                $mail->addAddress($correo, $nombre . ' ' . $apellido);
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
                            <strong>Mensaje de: </strong>ADMINISTRACIÓN - ASUAVETA
                          </div>
                          <div class='mensaje'>
                            <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Contactos asuaveta'>
                            <div class='texto'>Hola $nombre $apellido... <br><br>La Asociación de Usuarios del Acueducto Veredal La Veta (ASUAVETA) le informa que se ha creado una cuenta para administrar el SIA (Sistema de Información web para la gestión de procesos Administrativos. Es un placer darte la bienvenida a este equipo de trabajo.<br><br>Para ingresar debes crear una contraseña haciéndo click en el siguiente enlace: <a href='$link_new_admin' target='_blank'>$link_new_admin</a><br><br>¡ÉXITOS!
                            <img width='30%' height='10%' class='img-fluid' src='https://i.ibb.co/k0jSqcY/logo.png' alt='Logo asuaveta'><br><br>
                          </div>
                          <div class='footer'>
                           !Es un placer tenerte con nosotros!
                          </div>
                        </div>
                      </div>
                    </body>
                    </html>
                  ";
                //Contenido del correo
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = "¡CUENTA ADMINISTRATIVA - ASUAVETA";
                $mail->Body = $mensaje;
                if ($mail->send()) {
                    $sql_insertar = "INSERT INTO tbl_usuario (nombre_usu, apellido_usu, id_usu, telefono_usu, correo_usu, direccion_usu, fk_rol_usu, foto_perfil_usu, fk_estado_usu)VALUES (?,?,?,?,?,?,?,?,?)";
                    $consulta_insertar = $pdo->prepare($sql_insertar);
                    $consulta_insertar->execute(array($nombre, $apellido, $documento, $telefono, $correo, $direccion, $rol, $foto, $estado));
                    echo 1;
                }
            } catch (Exception $e) {
                echo "No se ha podido registrar el usuario, por favor valida tu conexión e intenta nuevamente....<br><br>ERROR: " . $mail->ErrorInfo; //Cuando hay problemas al enviar el correo
            }
        }
    }
    //Suscripción al boletín
    if (isset($_POST['SuscripcionEmail'])) {
        $correo_sus = $_POST['SuscripcionEmail'];
        $sql_existe = "SELECT correo_bol FROM tbl_boletin WHERE correo_bol='$correo_sus'";
        $consulta_existe = $pdo->prepare($sql_existe);
        $consulta_existe->execute();
        $resultado_existe = $consulta_existe->rowCount();
        if ($resultado_existe) {
            echo "El correo <strong>".$correo_sus."</strong> ya está suscrito en nuestro boletín informativo";
        } else {
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
                $mail2->addAddress("$correo_sus", "USUARIO ASUAVETA");
                $link_susboletin = "https://www.asuaveta.site/dashboard/controllers/mailer/boletin.php?RTHNLSTSLSJDNDNDDKD=" . base64_encode($correo_sus);
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
           <strong>BOLETÍN INFORMATIVO - ASUAVETA</strong>
         </div>
         <div class='mensaje'>
           <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Contactos asuaveta'>
           <div class='texto'>Estimado usuario, reciba usted un cordial saludo...<br><br>Hemos recibido una solicitud de suscripción de tu correo electrónico ($correo_sus) a nuestro boletín informativo ASUAVETA, en caso de haber recibido este correo por error, por favor hacer caso omiso. Si deseas continuar con el proceso de suscripción haz click en el siguiente enlace....<br><a target='_blank' href='$link_susboletin'>$link_susboletin</a><br><br><strong><a href='https://www.asuaveta.site/dashboard/views/visor_documentos.php?privacidad' target='_blank'>Política de privacidad integral</a></strong></div><br><br><br>
           <img width='30%' height='10%' class='img-fluid' src='https://i.ibb.co/k0jSqcY/logo.png' alt='Logo asuaveta'>
         </div>
         <div class='footer'>
          !Es mejor estar conectados!
         </div>
       </div>
     </div>
   </body>
   </html>
 ";
                //Contenido del correo
                $mail2->isHTML(true);
                $mail2->CharSet = 'UTF-8';
                $mail2->Subject = "SOLICITUD DE SUSCRIPCIÓN AL BOLETÍN INFORMATIVO";
                $mail2->Body = $mensaje2;
                if ($mail2->send()) {
                    echo 1;
                }
            } catch (Exception $e) {
                echo "Ha ocurrido un error al procesar la solicitud, por favor valida tu conexión e intenta más tarde...";
            }
        }
    }
    //Registro de tarifas
    if (isset($_POST['addcargo'])) {
        $cargoadd = str_replace(',', '', $_POST['addcargo']);
        $metroadd = str_replace(',', '', $_POST['addprecio']);
        $sql_add = "INSERT INTO tbl_tarifa (cargo_fijo_tar, precio_mt_tar)VALUES (?,?)";
        $consulta_add = $pdo->prepare($sql_add);
        $consulta_add->execute(array($cargoadd, $metroadd));
        $itc = '$' . number_format($cargoadd);
        $itm = '$' . number_format($metroadd);
        echo "La tarifa se ha guardado exitosamente con los siguientes valores:<br><br><strong>Cargo fijo: </strong>$itc<br><strong>M3: </strong>$itm<br>¡Gracias!";
    }
    //Registro de factura
    if (isset($_POST['lectura_actual'])) {
        $lectura_anterior_fac = $_POST['lectura_anterior'];
        $lectura_actual_fac = $_POST['lectura_actual'];
        $fecha_anterior_fac = $_POST['desde'];
        $fecha_actual_fac = $_POST['hasta'];
        $cobro_extra_fac = $_POST['concepto'];
        $descuento_fac = $_POST['descuento'];
        $observacion_fac = $_POST['mensaje_fac'];
        $tarifa_fac = $_POST['tarifa_serv'];
        $cargo_fijo_fac = $_POST['cargo_fijo'];
        $precio_mt_fac = $_POST['precio_mt'];
        $fk_estado_fac = 7;
        $fk_servicio_fac = $_POST['fk_servicio_fac'];
        //Realizamos la consulta para validar si la factura ya existe
        $sql_existe = "SELECT numero_fac, fecha_actual_fac, fecha_anterior_fac FROM tbl_factura WHERE fk_servicio_fac='$fk_servicio_fac' AND fecha_actual_fac ='$fecha_actual_fac'";
        $consulta_existe = $pdo->prepare($sql_existe);
        $consulta_existe->execute();
        $resultado_existe = $consulta_existe->rowCount();
        $res_gen = $consulta_existe->fetch(PDO::FETCH_OBJ);
        setlocale(LC_ALL, "es_ES", "esp");
        if ($fk_servicio_fac == null) {
            echo 4;
        } else {
            if ($resultado_existe) {
                $periodo_mostrar = strtoupper(strftime("%B DE %Y", strtotime($res_gen->fecha_actual_fac)));
                $genfa = utf8_encode(strftime("%A %d de %B de %Y", strtotime($res_gen->fecha_actual_fac)));
                echo "La factura #$res_gen->numero_fac correspondiente al periodo de $periodo_mostrar ya fue generada el día $genfa";
            } else {
                //Insertar datos de factura en la tabla factura
                $sql_insertar = "INSERT INTO tbl_factura (lectura_anterior_fac, lectura_actual_fac, fecha_anterior_fac, fecha_actual_fac, cobro_extra_fac, descuento_fac, observacion_fac, tarifa_fac, cargo_fijo_fac, precio_mt_fac, fk_estado_fac, fk_servicio_fac) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
                $consulta_insertar = $pdo->prepare($sql_insertar);
                //Ejecutar la sentencia
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
                //echo '<img class="img-thumbnail" src="' . $codesDir . $codeFile . '" />';
                $perio = strftime("%B del año %Y", strtotime($fecha_anterior_fac));
                echo 1;
            }
        }
    }
    //Guardar publicación
    if (isset($_POST['notautor'])) {
        $titulo = $_POST['nottitulo'];
        $categoria = $_POST['notcategoria'];
        $cuerpo = $_POST['notcuerpo'];
        $autor = $_POST['notautor'];
        $archivo = $_FILES['notimagen']['name'];
        $imagen = $autor . "_" . $_FILES['notimagen']['name'];
        //Si el archivo contiene algo y es diferente de vacio
        if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['notimagen']['type'];
            $tamano = $_FILES['notimagen']['size'];
            $temp = $_FILES['notimagen']['tmp_name'];
            //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
                echo "<script>alert('Error. La extensión o el tamaño de los archivos no es correcta.<br/>
     - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.')</script>";
            } else {
                //Si la imagen es correcta en tamaño y tipo
                if (move_uploaded_file($temp, '../assets/img/posts/' . $autor . "_" . $archivo)) {
                    //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                    chmod('../assets/img/posts/' . $autor . "_" . $archivo, 0777);
                } else {
                    //Si no se ha podido subir la imagen, mostramos un mensaje de error
                    echo "<script>alert('Ocurrió algún error al subir el fichero. No pudo guardarse.')</script>";
                }
            }
        }
        $estado_publi = 6;
        $sql_post = "INSERT INTO tbl_publicacion (titulo_publi, cuerpo_publi, imagen_publi, fk_estado_publi, fk_categoria_publi, fk_autor_publi) VALUES (?,?,?,?,?,?)";
        $consulta_post = $pdo->prepare($sql_post);
        $consulta_post->execute(array($titulo, $cuerpo, $imagen, $estado_publi, $categoria, $autor));
        echo "<script>document.location.href='../views/publicaciones.php'</script>";
    }
    //Registro de comentario
    if (isset($_POST['ComCategoria']) && isset($_POST['ComCuerpo']) && isset($_POST['ComUsuario'])) {
        $estado = 9;
        $sql_comm = "INSERT INTO tbl_comentario (cuerpo_com, fk_categoria_com, fk_estado_com, fk_autor_com) VALUES (?,?,?,?)";
        $consulta_comm = $pdo->prepare($sql_comm);
        $consulta_comm->execute(array($_POST['ComCuerpo'], $_POST['ComCategoria'], $estado, $_POST['ComUsuario']));
        echo "Tu comentario ha quedado <strong>PENDIENTE DE VALIDACIÓN</strong>.<br>Muchas gracias por utilizar nuestros servicios...";
    }
    //Registro de solicitud de usuario (Se guarda un servicio y un usuario a la vez)
    if (isset($_POST['newS_ser'])) {
        $cod_serv = $_POST['newS_ser'];
        $nombre = $_POST['newS_nom'];
        $apellido = $_POST['newS_ape'];
        $documento = $_POST['newS_doc'];
        $telefono = $_POST['newS_tel'];
        $correo = $_POST['newS_cor'];
        $direccion = $_POST['newS_dir'];
        $rol = 1;
        $estado = 2;
        $foto = "perfil_defecto_aqua123.png";
        $lectura_serv = "0000";
        $fecha_serv = date('Y-m-d');
        //Consulta si el usuario ya existe en la base de datos
        $sql_existe = "SELECT id_usu FROM tbl_usuario WHERE id_usu=?";
        $consulta_existe = $pdo->prepare($sql_existe);
        $consulta_existe->execute(array($documento));
        $resultado_existe = $consulta_existe->rowCount();
        $existe_usu = $consulta_existe->fetch(PDO::FETCH_OBJ);
        //Verificar si tiene alguna solicitud iniciada
        $sqlpend = "SELECT id_serv, fk_suscriptor_serv FROM tbl_servicio WHERE fk_estado_serv=4 AND fk_suscriptor_serv =?";
        $consulta_pend = $pdo->prepare($sqlpend);
        @$consulta_pend->execute(array(@$existe_usu->id_usu));
        $existe_pend = $consulta_pend->rowCount();
        $res_pend = $consulta_pend->fetch(PDO::FETCH_OBJ);
        if ($existe_pend) {
            echo 2; //El usuario ya tiene un servicio pendiente
        } else {
            $sql_existe = "SELECT id_serv FROM tbl_servicio WHERE id_serv =?";
            $consulta_exs = $pdo->prepare($sql_existe);
            $consulta_exs->execute(array($cod_serv));
            $resultado_exs = $consulta_exs->rowCount();
            $res_serv = $consulta_exs->fetch(PDO::FETCH_OBJ);
            if ($resultado_exs) {
                echo 4; //Ya existe el servicio
            } else {
                if (!$resultado_existe) {
                    $sql_insertar = "INSERT INTO tbl_usuario (nombre_usu, apellido_usu, id_usu, telefono_usu, correo_usu, direccion_usu, fk_rol_usu, foto_perfil_usu, fk_estado_usu)VALUES (?,?,?,?,?,?,?,?,?)";
                    $consulta_insertar = $pdo->prepare($sql_insertar);
                    $consulta_insertar->execute(array($nombre, $apellido, $documento, $telefono, $correo, $direccion, $rol, $foto, $estado));
                    echo "¡Registro exitoso!<br><br>";
                }
                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'atencionalcliente.asuaveta@gmail.com';
                    $mail->Password = 'Asua12345';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->setFrom('atencionalcliente.asuaveta@gmail.com', 'ASUAVETA'); //Remitente (ASUAVETA)
                    $mail->addAddress($correo, $nombre . ' ' . $apellido);
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
                        <strong>Mensaje de: </strong>ADMINISTRACIÓN - ASUAVETA
                      </div>
                      <div class='mensaje'>
                        <img class='img-fluid' src='https://i.ibb.co/mvzTVGk/callcenter.png' alt='Contactos asuaveta'>
                        <div class='texto'>Hola $nombre $apellido, tu solicitud de contratación de servicios de acueducto con la Asociación de Usuarios del Acueducto veredal (ASUAVETA) identificada con NIT.900362372-2 ha sido iniciada satisfactoriamente. Por razones de seguridad te hemos enviado un radicado de la solictud....<br><br>Si deseas continuar con el trámite debes guardar este radicado ya que con este confirmas tu proceso de contratación. Si deseas desistir del proceso, simplemente omite esta notificación electrónica ya que pasados cinco (5) días, la solicitud sin confirmar, se cerrará automáticamente...<br><br>Si deseas continuar con el proceso, debes acercarte a nuestra oficina principal con tu documento de identidad original y el radicado que se encuentra en el pie de esta notificación. Si eres propietario del inmueble ubicado en $direccion debes llevar los documentos que te acrediten como tal. En caso de ser arrendatario debes tener una autorización del propietario debidamente firmada así como una copia de su documento. ¡Muchas gracias!<br><br><strong><small>RADICADO:</small> $cod_serv</strong></div><br><br>Para más información sobre nuestros procesos visita nuestro sitio web <a target='_blank' href='www.asuaveta.site'>www.asuaveta.site</a><br><br>
                        <img width='30%' height='10%' class='img-fluid' src='https://i.ibb.co/k0jSqcY/logo.png' alt='Logo asuaveta'>
                      </div>
                      <div class='footer'>
                       !Para nosotros es un placer servirte!
                      </div>
                    </div>
                  </div>
                </body>
                </html>
              ";
                    //Contenido del correo
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->Subject = "¡SOLICITUD DE CONTRATACIÓN RADICADA! :) - $cod_serv";
                    $mail->Body = $mensaje;
                    if ($mail->send()) {
                        $estado_serv = 4;
                        $tarifa_def = 1;
                        //Insertar datos del servicio en la bd
                        $sql_insertar = "INSERT INTO tbl_servicio (id_serv, fecha_serv, fk_estado_serv, fk_tarifa_serv, fk_suscriptor_serv) VALUES (?,?,?,?,?)";
                        $consulta_insertar = $pdo->prepare($sql_insertar);
                        $consulta_insertar->execute(array($cod_serv, $fecha_serv, $estado_serv, $tarifa_def, $documento));
                        //Se registra el usuario en el boletin informativo
                        $fecha_actual_bol = date('Y-m-d');
                        $sql_add = "INSERT INTO tbl_boletin (correo_bol, fecha_bol) VALUES (?,?)";
                        $consulta_add = $pdo->prepare($sql_add);
                        $consulta_add->execute(array($correo, $fecha_actual_bol));
                        echo "Hola <strong><small>$nombre $apellido</small></strong>, por razones de seguridad hemos enviado toda la información sobre este trámite a tu correo electrónico (<strong><small>$correo</small></strong>).<br><br><strong>¡Tu seguridad es una de nuestras prioridades!</strong>";
                    }
                } catch (Exception $e) {
                    echo 5; //Cuando hay problemas al enviar el correo
                }
            }
        }
    }
    //Reenviar correo al usuario
    if (isset($_POST['reenviarRad'])) {
        $usuR = $_POST['reenviarRad'];
        $sqlR = "SELECT id_serv, nombre_usu, apellido_usu, correo_usu, direccion_usu FROM tbl_servicio as SER
        INNER JOIN tbl_usuario AS US ON US.id_usu=SER.fk_suscriptor_serv
        WHERE SER.fk_estado_serv=4 AND SER.fk_suscriptor_serv=?";
        $consultaR = $pdo->prepare($sqlR);
        $consultaR->execute(array($usuR));
        $resultadoR = $consultaR->rowCount();
        $reenviar = $consultaR->fetch(PDO::FETCH_OBJ);
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
            $mail2->addAddress($reenviar->correo_usu, $reenviar->nombre_usu . ' ' . $reenviar->apellido_usu);
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
                        <Para class='texto'>Hola $reenviar->nombre_usu $reenviar->apellido_usu, se reenvía radicado de tu solicitud de contratación de servicios de acueducto con la Asociación de Usuarios del Acueducto veredal (ASUAVETA) para que continúes con tu proceso de contratación<br><br>Te informamos los pasos a seguir si deseas continuar el trámite...<br><br>Debes guardar el radicado ya que con este confirmas tu proceso de contratación. Si deseas desistir del proceso, simplemente omite esta notificación electrónica ya que pasados cinco (5) días, la solicitud sin confirmar, se cerrará automáticamente...<br><br>Si deseas continuar con el proceso, debes acercarte a nuestra oficina principal con tu documento de identidad original y el radicado que se encuentra en el pie de esta notificación. Si eres propietario del inmueble ubicado en $reenviar->direccion_usu debes llevar los documentos que te acrediten como tal. En caso de ser arrendatario debes tener una autorización del propietario debidamente firmada así como una copia de su documento. ¡Muchas gracias!<br><br>Para más información sobre nuestros procesos visita nuestro sitio web <a target='_blank' href='www.asuaveta.site'>www.asuaveta.site</a><br><br><br><br><strong><small>RADICADO:</small> $reenviar->id_serv</strong></div><br><br><br>
                        <img width='30%' height='10%' class='img-fluid' src='https://i.ibb.co/k0jSqcY/logo.png' alt='Logo asuaveta'>
                      </div>
                      <div class='footer'>
                       !Para nosotros es un placer servirte!
                      </div>
                    </div>
                  </div>
                </body>
                </html>
              ";
            //Contenido del correo
            $mail2->isHTML(true);
            $mail2->CharSet = 'UTF-8';
            $mail2->Subject = "CONTRATACIÓN - $reenviar->id_serv (REENVÍO)";
            $mail2->Body = $mensaje2;
            if ($mail2->send()) {
                echo "La información referente al radicado de la solicitud existente se ha reenviado correctamente a <strong>$reenviar->correo_usu</strong>.";
            }
        } catch (Exception $e) {
            echo '<br>Hubo un error al reenviar el correo, valida tu conexión a internet e intenta nuevamente...<br>';
        }
    }
