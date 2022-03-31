<?php include_once 'nav_in.php';
session_start();
@$id = $_SESSION['id_usu'];
include_once 'dashboard/controllers/conexion.php';
$sql_com = "SELECT tipo_categoria, cuerpo_com, fecha_com, fk_autor_com, nombre_usu, apellido_usu, foto_perfil_usu, tipo_estado FROM tbl_comentario AS COM
INNER JOIN tbl_usuario AS US on US.id_usu=COM.fk_autor_com
INNER JOIN tbl_categoria AS CAT ON CAT.id_categoria=COM.fk_categoria_com
INNER JOIN tbl_estado AS EST ON EST.id_estado=COM.fk_estado_com
WHERE fk_estado_com=6
ORDER BY fecha_com DESC";
$consulta_com = $pdo->prepare($sql_com);
$consulta_com->execute();
$cantidad_com = $consulta_com->rowCount();
$comentarios = $consulta_com->fetchAll();
?>
<!-- Page Content-->
<section class="py-1" id="preguntas">
    <div class="container px-5 my-5">
        <div class="text-center mb-5">
            <h1 class="fw-bolder">Preguntas frecuentes</h1>
            <p class="lead fw-normal text-muted mb-0">¿Cómo podemos ayudarle?</p>
        </div>
        <div class="row gx-5">
            <div class="col-xl-8">
                <!-- FAQ Accordion 1-->
                <h2 class="fw-bolder mb-3">Cuenta &amp; servicios</h2>
                <div class="accordion mb-5" id="accordionExample">
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingOne"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">¿Cuál es la ubicación de la sede principal de la empresa?</button></h3>
                        <div class="accordion-collapse collapse" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>Oficina corporativa</strong> ubicada en la vía principal de la vereda La Veta a 50m del
                                <code>CENTRO EDUCATIVO RURAL LA VETA</code> ¡Visítanos para tener el gusto de atenderle!
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingTwo"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">¿Dónde puedo expresar mis inquietudes y reclamos?</button></h3>
                        <div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                !Para nosotros es muy importante atender tus solicitudes! Puedes hacerlo en nuestra oficina principal o desde <strong>nuestra página web <a href="https://www.asuaveta.site/soporte.php">www.asuaveta.site</a></strong>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingThree"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">¿Qué debo hacer si no me llega la factura a tiempo?</button></h3>
                        <div class="accordion-collapse collapse" id="collapseThree" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Comunicarse a la Línea <a href="tel:3128998259">(57) 3128998259</a> para verificar que la factura ha sido expedida y luego puede dirigirse a solicitar el duplicado en cualquier punto de atención o por Internet. Una vez esté dispobible la puede descargar e imprimir.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="heading4"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">Tengo un inmueble desocupado y me siguen cobrando el servicio de agua pese a no haber consumo. ¿Qué debo hacer?</button></h3>
                        <div class="accordion-collapse collapse" id="collapse4" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Si el predio está desocupado, el Acueducto está obligado a facturar los cargos fijos de acuerdo con lo establecido en la Ley 142. Sin embargo, existe la posibilidad de solicitar la suspensión temporal del servicio mientras el predio esté desocupado con el fin de no generar los cargos fijos.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="heading5"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">¿Cuál es la planta de tratamiento de agua potable?</button></h3>
                        <div class="accordion-collapse collapse" id="collapse5" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>Planta de potabilización ASUAVETA</strong> Ubicada en el cerro LA MESA diagonal a la escuela rural LA VETA.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="heading6"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">¿Cómo adquiero el servicio de acueducto?</button></h3>
                        <div class="accordion-collapse collapse" id="collapse6" aria-labelledby="heading6" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>Nuevo contrato</strong>. Para este proceso debes radicar tu solicitud por medio de nuestra página web <a href="https://www.asuaveta.site" target="_blank"><i class="fa fa-external-link text-dark"></i></a>. En caso de no contar con los medios para hacerlo te puedes acercar a <a href="#" class="text-dark" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">nuestra oficina principal</a> donde uno de nuestros funcionarios te ayudará con el proceso de contratación...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card border-0 bg-light mt-xl-5">
                    <div class="card-body p-4 py-lg-5">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <div class="h6 fw-bolder">¿Tienes más preguntas?</div>
                                <p class="text-muted mb-4">
                                    ¡Contáctenos!
                                    <br />
                                    <small><a href="mailto:atencionalcliente.asuaveta@gmail.com">atencionalcliente.asuaveta@gmail.com</a></small>
                                </p>
                                <div class="h6 fw-bolder">Participa</div>
                                <a class="fs-5 px-2 link-dark" href="#foro_info"><i class="fa fa-question-circle"></i></a>
                                <a class="fs-5 px-2 link-dark" href="https://wa.me/573128998259?text=¡Hola equipo ASUAVETA!, vengo desde el SIA (Sistema de Información Web para la gestión de procesos Administrativos" target="_blank"><i class="fab fa-whatsapp"></i></a>
                                <a href="soporte.php" class="fs-5 px-2 link-dark"><i class="fa fa-user-headset"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container py-3 mb-5" id="foro_info">
    <section>
        <div class="card bg-light">
            <h2 class="fw-bolder mb-0 text-center">Publicaciones del foro</h2>
            <div class="card-body">
                <?php if (isset($id)) { ?>
                    <form id="formularioComm" class="mb-4" method="POST" onsubmit="return NewComment()">
                        <select class="form-control mb-1" required id="ComCategoria">
                            <option value="">Seleccione una categoría...</option>
                            <option value="5">COMENTARIO</option>
                            <option value="6">PREGUNTA</option>
                            <option value="7">OTRO(A)</option>
                        </select>
                        <textarea class="form-control" rows="3" placeholder="¡Unete al foro de comentarios, dudas e inquitudes!" maxlength="500" id="ComCuerpo" required></textarea>
                        <div class="text-center">
                            <input type="hidden" value="<?php echo $id ?>" id="ComUsuario">
                            <button type="submit" class="my-2 btn btn-success text-center"><i class="fa fa-paper-plane"></i> Publicar</button>
                        </div>
                    </form>
                <?php } else { ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>¡No has iniciado sesión!</strong> Si quieres publicar en el foro debes iniciar sesión... <a href="login.php" class="mx-3 btn btn-success btn-sm">Iniciar</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <?php foreach ($comentarios as $comm) : ?>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0"><img class="rounded-circle" src="assets/img/logbv.png" alt="Comentario ASUAVETA" width="50" height="50"></div>
                        <div class="ms-3">
                            <div style="word-wrap: break-word;" class="fw-bold">
                                <i class="fa fa-star"></i> <?php echo $comm['tipo_categoria'] ?>
                                <p><small class="text-muted"><?php echo $comm['fecha_com'] ?></small></p>
                            </div><?php echo nl2br($comm['cuerpo_com']) ?><div class="d-flex mt-2">
                                <div class="flex-shrink-0"><img class="rounded-circle" src="dashboard/perfiles/<?php echo $comm['foto_perfil_usu'] ?>" alt="Foto perfil ASUAVETA" width="40" height="40"></div>
                                <div class="ms-3">
                                    <div class="fw-bold"><?php echo $comm['nombre_usu'] . " " . $comm['apellido_usu'] ?></div>
                                    Publicación <?php echo $comm['tipo_estado'] ?> <i class="fa fa-badge-check text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php endforeach ?>
            </div>
        </div>
    </section>
</div>
<script>
    function NewComment() {
        var ComCategoria = document.getElementById('ComCategoria').value;
        var ComCuerpo = document.getElementById('ComCuerpo').value;
        var ComUsuario = document.getElementById('ComUsuario').value;
        var datosCom = 'ComCategoria=' + ComCategoria + '&ComCuerpo=' + ComCuerpo + '&ComUsuario=' + ComUsuario;
        $.ajax({
            url: 'dashboard/controllers/registro.php',
            type: 'post',
            data: datosCom,
            success: function(respCom) {
                Swal.fire({
                    type: 'success',
                    title: '¡Bien!',
                    html: respCom,
                });
            }
        });
        document.getElementById("formularioComm").reset();
        return false;
    }
</script>
</main>

<?php include_once 'footer.php' ?>