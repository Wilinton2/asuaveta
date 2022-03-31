<?php include_once 'nav_in.php';
include_once 'dashboard/controllers/conexion.php';
$sql_notis = "SELECT id_publi, titulo_publi, cuerpo_publi, imagen_publi, fecha_publi, fk_autor_publi, nombre_usu, apellido_usu, foto_perfil_usu, tipo_categoria FROM tbl_publicacion
INNER JOIN tbl_usuario ON id_usu=fk_autor_publi
INNER JOIN tbl_categoria ON id_categoria=fk_categoria_publi ORDER BY fecha_publi DESC LIMIT 3";
$consulta_notis = $pdo->prepare($sql_notis);
$consulta_notis->execute();
$resnotices = $consulta_notis->fetchAll();
?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-5">
        <div class="row gx-5 align-items-center justify-content-center">
            <div class="col-lg-8 col-xl-7 col-xxl-6">
                <div class="my-5 text-center text-xl-start">
                    <h1 class="display-5 fw-bolder text-white mb-2">Bienvenido al SIA</h1>
                    <p class="lead fw-normal text-white-50 mb-4">(Sistema de Información web para la gestión de procesos Administrativos).<br>El agua es la fuerza motriz de toda la naturaleza. ¡Cuidar el agua, es conservar nuestro futuro y el de nuestras familias!</p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start" id="btnnuevoservicio">
                        <a class="btn btn-success btn-lg px-4 me-sm-3" href="login.php">Iniciar sesión <i class="fab fa-sign-in-alt"></i></a>
                        <a class="btn btn-outline-light btn-lg px-4" data-bs-toggle="modal" data-bs-target="#solicitud_de_servicio">Solicitar servicio</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center">
                <div class="circulito">
                    <img class="cen" src="assets/img/circulo_inicio_azul.png" alt="">
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Features section-->
<section class="py-5" id="servicios">
    <div class="container px-5 my-5">
        <div class="row gx-5">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h2 class="fw-bolder mb-0">Conoce nuestros servicios...</h2>
            </div>
            <div class="col-lg-8">
                <div class="row gx-5 row-cols-1 row-cols-md-2">
                    <div class="col mb-5 h-100">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="far fa-hand-holding-water"></i></div>
                        <h2 class="h5">Agua potable</h2>
                        <p class="mb-0">Implementamos metodologías ágiles para el mantenimiento, saneamiento y transporte de agua desde nuestras montañas hasta tu hogar.</p>
                    </div>
                    <div class="col mb-5 h-100">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="far fa-info-circle"></i></div>
                        <h2 class="h5">Noticias</h2>
                        <p class="mb-0">Dispusimos este espacio para mantenerte informado sobre todo lo relacionado con tus servicios y otra información de interés para la comunidad.</p>
                    </div>
                    <div class="col mb-5 mb-md-0 h-100">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="far fa-users-class"></i></div>
                        <h2 class="h5">Consultas</h2>
                        <p class="mb-0">Puedes gestionar tus servicios, consultar facturas, historial financiero <strong>ASUAVETA</strong> y otras herramientas disponibles para ti al momento de asignarte una cuenta.</p>
                    </div>
                    <div class="col h-100">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="fad fa-question-circle"></i></div>
                        <h2 class="h5">Ayuda y comentarios</h2>
                        <p class="mb-0">En este espacio podrás realizar tus Peticiones, Quejas, y/o Reclamos así como darnos tu opinión sobre los servicios y observaciones generales sobre la empresa.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Modal para Registrar-->
<div class="modal fade" id="solicitud_de_servicio" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="fa fa-user-plus"></i> Solicitud de nuevo servicio...</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" onsubmit="return FormnewServicio()" id="formReg">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label style="font-size: 12px;" class="font-weight-bold col-form-label">Nombre:</label>
                                <input required onkeyup="javascript:this.value=this.value.toUpperCase();" style="font-size: 15px;" type="text" class="form-control" id="newS_nom">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label style="font-size: 12px;" class="font-weight-bold col-form-label">Apellido:</label>
                                <input required onkeyup="javascript:this.value=this.value.toUpperCase();" style="font-size: 15px;" type="text" class="form-control" id="newS_ape">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label style="font-size: 12px;" class="font-weight-bold col-form-label">Documento:</label>
                                <input style="font-size: 15px;" type="number" class="form-control" id="newS_doc" required>
                                <input type="hidden" id="newS_ser" value="<?php echo rand(1000000, 9999999) ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label style="font-size: 12px;" class="font-weight-bold col-form-label">Teléfono:</label>
                                <input required style="font-size: 15px;" type="number" class="form-control" id="newS_tel">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label style="font-size: 12px;" class="font-weight-bold col-form-label">Correo electrónico:</label>
                                <input required onkeyup="javascript:this.value=this.value.toUpperCase();" style="font-size: 15px;" type="email" class="form-control" id="newS_cor">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label style="font-size: 12px;" class="font-weight-bold col-form-label">Confirmar correo:</label>
                                <input required onkeyup="javascript:this.value=this.value.toUpperCase();" style="font-size: 15px;" type="email" class="form-control" id="newS_cor2">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label style="font-size: 12px;" class="font-weight-bold col-form-label">Dirección específica donde se instalará el servicio:</label>
                                <textarea required onkeyup="javascript:this.value=this.value.toUpperCase();" style="font-size: 15px;" type="text" class="form-control" id="newS_dir" placeholder="Describe detalladamente la ubicación del inmueble..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label style="font-size: 12px;" class="font-weight-bold col-form-label text-center"><input required type="checkbox"> Para continuar, debes leer y aceptar nuestra <a target="_blank" href="../dashboard/views/visor_documentos.php?privacidad">política de privacidad</a>, así como los <a target="_blank" href="../dashboard/views/visor_documentos.php?terminos">términos y condiciones del servicio...</a></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--FIN DEL MODAL DE REGISTRO-->



<!-- Administradores-->
<div class="py-5 bg-light">
    <div class="container px-5 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-10 col-xl-7">
                <div class="text-center">
                    <div class="fs-4 mb-4 fst-italic">"Cuando el agua no llegue a tu casa, y tengas que buscarla, ganarla y tratarla, conocerás el valor de cada gota que hoy implora su conservación".</div>
                    <div class="d-flex align-items-center justify-content-center">
                        <img class="rounded-circle me-3" src="assets/img/Desarrollador.jpg" alt="Desarrollador ASUAVETA" width="40" height="40">
                        <div class=" fw-bold ">
                            Wilinton Castaño
                            <span class="fw-bold text-primary mx-1 ">/</span> Desarrollador
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog preview section-->
<section class="py-5 ">
    <div class="container px-5 my-5 ">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 ">
                <div class="text-center ">
                    <h2 class="fw-bolder ">Noticias recientes</h2>
                    <p class="lead fw-normal text-muted mb-5 ">¡Mantente enterado de las últimas noticias que ASUAVETA tiene para ti!</p>
                </div>
            </div>
        </div>
        <div class="row gx-5 ">
            <hr>
            <?php if (!$resnotices) { ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>¡No hay publicaciones!</strong> Puedes estar atento a próximas novedades...
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <?php foreach ($resnotices as $fori) : ?>
                <div class="col-lg-4 mb-5">
                    <div class="card h-100 shadow border-0 ">
                        <img class="card-img-top " src="assets/img/posts/<?php echo $fori['imagen_publi'] ?>" onerror="this.src='assets/img/posts/default.jpg';" alt="Imagen noticia" width="600" height="350">
                        <div class="card-body p-4 ">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2 "><i class="far fa-star"></i> <?php echo $fori['tipo_categoria'] ?></div>
                            <a class="text-decoration-none link-dark stretched-link " href="post.php#id_publi<?php echo $fori['id_publi'] ?>" target="_blank">
                                <h5 class="card-title mb-3"><?php echo substr($fori['titulo_publi'], 0, 50) ?>...</h5>
                            </a>
                            <p class="card-text mb-0 text-justify"><?php echo substr($fori['cuerpo_publi'], 0, 200); ?>... <a href="post.php#id_noti<?php echo $fori['id_publi'] ?>" target="_blank">Leer más</a></p>
                        </div>
                        <div class="card-footer p-4 pt-0 bg-transparent border-top-0 ">
                            <div class="d-flex align-items-end justify-content-between ">
                                <div class="d-flex align-items-center ">
                                    <img class="rounded-circle me-3 " src="dashboard/perfiles/<?php echo $fori['foto_perfil_usu'] ?>" alt="Img autor" width="40" height="40" />
                                    <div class="small ">
                                        <div class="font-weight-bold"><?php echo $fori['nombre_usu'] . " " . $fori['apellido_usu'] ?></div>
                                        <div class="text-muted ">Fecha &middot; <?php echo $fori['fecha_publi'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>


        <!-- Call to action-->
        <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
            <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start ">
                <div class="mb-4 mb-xl-0" id="boletin">
                    <div class="fs-3 fw-bold text-white ">Boletín informativo</div>
                    <div class="text-white-50 ">Suscribase a nuestro boletín de información para obtener todas nuentras notificaciones.</div>
                </div>
                <form method="post" onsubmit="return SoliBoletin()">
                    <div class="ms-xl-4 ">
                        <div class="input-group mb-2 ">
                            <input class="form-control" type="email" placeholder="Correo electrónico..." id="BolEmail" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                            <button class="btn btn-outline-light " id="button-newsletter" type="submit">Guardar</button>
                        </div>
                        <div class="small text-white-50 ">Al continuar aceptas nuestra <a class="text-light" href="dashboard/views/visor_documentos.php?privacidad" target="_blank">Política</a> de protección de datos.</div>
                    </div>
                </form>
            </div>
        </aside>
    </div>
</section>
<script>
    //Solicitud de suscripción al boletín informativo
    function SoliBoletin() {
        var BolEmail = document.getElementById('BolEmail').value;
        $.ajax({
            url: 'dashboard/controllers/registro.php',
            type: 'post',
            data: 'SuscripcionEmail=' + BolEmail,
            beforeSend: function() {
                Swal.fire({
                    type: 'info',
                    html: '<strong>Validando información...</strong>',
                    showConfirmButton: false,
                });
            },
            success: function(respBol) {
                if (respBol == 1) {
                    Swal.fire({
                        type: 'success',
                        title: '¡Todo bien!',
                        html: "La solicitud se ha realizado exitosamente... Hemos enviado toda la información al correo <strong>" + BolEmail + "</strong>",
                    });
                } else {
                    Swal.fire({
                        type: 'warning',
                        title: '¡Error!',
                        html: respBol,
                    });
                }
            }
        });
        return false;
    }
    //Formulario de nuevo servicio
    function FormnewServicio() {
        var newS_ser = document.getElementById('newS_ser').value;
        var newS_nombre = document.getElementById('newS_nom').value;
        var newS_apellido = document.getElementById('newS_ape').value;
        var newS_documento = document.getElementById('newS_doc').value;
        var newS_telefono = document.getElementById('newS_tel').value;
        var newS_correo = document.getElementById('newS_cor').value;
        var newS_correo2 = document.getElementById('newS_cor2').value;
        var newS_direccion = document.getElementById('newS_dir').value;
        if (newS_correo == newS_correo2) {
            var todo_serv = 'newS_ser=' + newS_ser + '&newS_nom=' + newS_nombre + '&newS_ape=' + newS_apellido + '&newS_doc=' + newS_documento + '&newS_tel=' + newS_telefono + '&newS_cor=' + newS_correo + '&newS_dir=' + newS_direccion;
            $.ajax({
                url: 'dashboard/controllers/registro.php',
                type: 'post',
                data: todo_serv,
                beforeSend: function() {
                    Swal.fire({
                        type: 'info',
                        text: 'Validando información...',
                        showConfirmButton: false,
                    });
                },
                success: function(resp_serV) {
                    if (resp_serV == 4) {
                        Swal.fire({
                            type: 'error',
                            title: '¡Este servicio ya existe! ',
                            text: 'Prueba actualizar la página para generar un nuevo código de servicio',
                        });
                    } else if (resp_serV == 3) {
                        Swal.fire({
                            type: 'error',
                            title: '¡Usuario no encontrado!',
                            html: 'Para continuar, es necesario solicitar al usuario su registro en el sistema...',
                            showConfirmButton: false,
                            timer: 3000 //el tiempo que dura el mensaje en ms
                        });
                    } else if (resp_serV == 2) {
                        Swal.fire({
                            type: 'warning',
                            title: '¡Servicio rechazado!',
                            html: "Estimado(a) administrador(a), no es posible registrar esta información ya que el usuario tiene una solicitud de contratación pendiente por validar.<br><br>Si el cliente manifiesta haber perdido el número de radicado de la misma, se sugiere eliminar dicha solicitud en este botón (<button class='btn btn-danger' id='borrarSoli'>Borrar solictud</button>) para reiniciar el proceso de contratación.",
                        });

                        swal.fire({
                            type: "warning",
                            title: "¡Servicio rechazado!",
                            html: "Estimado usuario, no es posible registrar esta información ya que existe una solicitud de contratación pendiente por validar.<br><br>Si perdiste el número de radicado de la misma, se sugiere enviar un nuevo código de confirmación a tu correo.<br><strong>¿Deseas recibir un nuevo código?</strong>.",
                            showCancelButton: true,
                            confirmButtonColor: "#18CE0F",
                            confirmButtonText: "Si, enviar",
                            cancelButtonText: "No, cancelar",
                            cancelButtonColor: "#40869B",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        }).then(function(result) {
                            if (result.value) {
                                $.ajax({
                                    url: 'dashboard/controllers/registro.php',
                                    type: 'post',
                                    data: 'reenviarRad=' + newS_documento,
                                    beforeSend: function() {
                                        Swal.fire({
                                            type: 'info',
                                            html: '<strong>Reenviando correo...</strong>',
                                            showConfirmButton: false,
                                        });
                                    },
                                    success: function(respReen) {
                                        Swal.fire({
                                            type: 'success',
                                            title: '¡Listo!',
                                            html: respReen,
                                            showConfirmButton: true,
                                        })
                                    }
                                });
                            }
                        });
                    } else if (resp_serV == 5) {
                        Swal.fire({
                            type: 'error',
                            title: '¡Error!',
                            html: 'Hubo un error al registrar el servicio, valida tu conexión a internet e intenta nuevamente...',
                        });
                    } else {
                        Swal.fire({
                            type: 'success',
                            title: '¡Todo bien!',
                            html: resp_serV,
                        });
                    }
                }
            });
        } else {
            Swal.fire({
                type: 'warning',
                title: '¡Error!',
                html: 'Los correos ingresados no coinciden, por favor verifica e intenta nuevamente...',
            });
        }
        return false;
    };
</script>
<?php include_once 'footer.php' ?>