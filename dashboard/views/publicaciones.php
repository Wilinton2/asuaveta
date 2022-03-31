<?php include_once 'nav.php';
$sql_notis = "SELECT id_publi, titulo_publi, fk_categoria_publi, cuerpo_publi, imagen_publi, fecha_publi, fk_estado_publi, fk_categoria_publi, fk_autor_publi, nombre_usu, apellido_usu, foto_perfil_usu, tipo_categoria, tipo_estado FROM tbl_publicacion
INNER JOIN tbl_usuario ON id_usu=fk_autor_publi
INNER JOIN tbl_categoria ON id_categoria=fk_categoria_publi
INNER JOIN tbl_estado ON id_estado=fk_estado_publi
ORDER BY fk_estado_publi ASC";
$consulta_notis = $pdo->prepare($sql_notis);
$consulta_notis->execute();
$resnotices = $consulta_notis->fetchAll();
$sql_com = "SELECT id_com, cuerpo_com, fecha_com, tipo_estado, fk_autor_com, nombre_usu, apellido_usu, foto_perfil_usu, tipo_categoria FROM tbl_comentario AS COM
INNER JOIN tbl_usuario AS US on US.id_usu=COM.fk_autor_com
INNER JOIN tbl_categoria AS CAT ON CAT.id_categoria=COM.fk_categoria_com
INNER JOIN tbl_estado AS EST ON EST.id_estado=COM.fk_estado_com
WHERE fk_estado_com=9
ORDER BY fecha_com DESC";
$consulta_com = $pdo->prepare($sql_com);
$consulta_com->execute();
$cantidad_com = $consulta_com->rowCount();
$comentarios = $consulta_com->fetchAll();
?>
<div class="panel-header">
    <div class="header text-center">
        <h3 class="title">Publicaciones</h3>
        <p class="text-muted">Crea las noticias y publicaciones para la comunidad de usuarios, aplica para novedades de todo tipo con relación a la empresa.</p>
        <button class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#new_post"><i class="fas fa-plus"></i> PUBLICAR NOTICIA</button>
        <button class="btn btn-success font-weight-bold" data-toggle="modal" data-target="#validcomm"><i class="fas fa-comment-check"></i> VALIDAR COMENTARIOS</button>
        <button class="btn btn-info font-weight-bold" data-toggle="modal" data-target="#modalBoletin" data-whatever="@mdo">BOLETÍN INFORMATIVO <i class="fas fa-megaphone"></i></button>
    </div>
</div>
<!--Modal para el boletín informativo-->
<div class="modal fade" id="modalBoletin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="fa fa-comment-alt-medical"></i> Nuevo Mensaje</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" onsubmit="return EnviarBoletin()">
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Asunto:</label>
                        <input type="text" class="form-control" placeholder="Título principal..." id="BolAs" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Mensaje:</label>
                        <textarea class="form-control" placeholder="Cuerpo del correo..." id="BolMens" required></textarea>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Enviar mensaje</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="new_post" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title font-weight-bold"><i class="fa fa-plus"></i> NUEVA PUBLICACIÓN</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="../controllers/registro.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="form-group">
                                <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-user-shield"></i> AUTOR:</label>
                                <p class="font-weight-bold"><?php echo $user->nombre_usu . " " . $user->apellido_usu ?></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-user-edit"></i> Titulo:</label>
                                <textarea class="form-control" name="nottitulo" rows="1" maxlength="150" placeholder="Escribe un título..." required></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-star"></i> Categoría:</label>
                                <select class="form-control" name="notcategoria" required>
                                    <option value="">Seleccione una opción...</option>
                                    <option value="1">NOTICIA</option>
                                    <option value="2">OFERTA</option>
                                    <option value="3">IMPORTANTE</option>
                                    <option value="4">INFORMACIÓN</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="form-group">
                                <input type="file" accept=".jpg, .png, .jpeg" name="notimagen">
                                <i class="fa fa-image"> Seleccione una imagen... </i> <i class="fa fa-upload"></i>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-edit"></i> Cuerpo:</label>
                                <textarea class="form-control" name="notcuerpo" rows="5" placeholder="Escribe el contenido de la publicación..." maxlength="12000" required></textarea>
                                <input type="hidden" name="notautor" value="<?php echo $user->id_usu ?>">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Fin del modal -->
<div class="modal fade" id="validcomm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title font-weight-bold"><i class="fa fa-comments"></i> REVISAR COMENTARIOS</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if (!$comentarios) { ?>
                    <div class="alert bg-primary alert-dismissible fade show" role="alert">
                        <strong>No hay comentarios pendientes</strong> <i class="fa fa-check"></i>
                    </div>
                <?php } ?>
                <?php foreach ($comentarios as $comm) : ?>
                    <div class="mb-0" id="IdComment<?php echo $comm['id_com'] ?>" style="display: flex;">
                        <div class="flex-shrink-0"><img class="rounded-circle" src="../perfiles/<?php echo $comm['foto_perfil_usu'] ?>" alt="Comentario ASUAVETA" width="30" height="30">
                        </div>
                        <div class="ms-3">
                            <div style="word-wrap: break-word;" class="ml-3 font-weight-bold"><i class="fa fa-star"></i> <?php echo $comm['tipo_categoria'] ?>
                                <?php echo "<br>" . $comm['nombre_usu'] . " " . $comm['apellido_usu']
                                ?>
                                <p><small class="text-muted"><i class="fa fa-exclamation-triangle text-warning"></i> <?php echo $comm['tipo_estado'] ?> | <?php echo $comm['fecha_com'] ?></small></p>
                            </div>
                            <div class="d-flex mt-0 mb-0">
                                <div class="pl-4 pr-2 mb-0">
                                    <?php echo nl2br($comm['cuerpo_com']) ?>
                                    <div class="mt-1 text-left mb-0">
                                        <form method="post" style="display: inline;" onsubmit="return aprobarCom(<?php echo $comm['id_com'] ?>)">
                                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Aprobar</button>
                                        </form>
                                        <form method="post" style="display: inline;" onsubmit="return elimCom(<?php echo $comm['id_com'] ?>)">
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Borrar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php endforeach ?>
                <div class="text-center">
                    <span class="font-italic">¡Juntos construimos una comunicación regida por el respeto y la integridad!</span>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Fin del modal -->
<div class="mt-4 container">
    <p class="text-center font-weight-bold">Puedes realizar la búsqueda con el código de la publicación...</p>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table id="tabla_publicaciones" class="table table-striped table-bordered">
                        <thead>
                            <tr class="text-primary">
                                <th class="font-weight-bold">CÓD.</th>
                                <th class="text-center font-weight-bold">CATEGORÍA</th>
                                <th class="text-center font-weight-bold">AUTOR</th>
                                <th class="text-center font-weight-bold">INFO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resnotices as $datos) :
                            ?>
                                <tr>
                                    <td class="font-weight-bold"><?php echo $datos['id_publi']; ?> | <span class="badge badge-pill badge-light"><?php echo $datos['tipo_estado']; ?></span></td>
                                    <td id="id_public<?php echo $datos['id_publi'] ?>" class="text-left font-weight-bold"><img class="img-circle" src="../../assets/img/posts/<?php echo $datos['imagen_publi'] ?>" onerror="this.src='../../assets/img/posts/default.jpg';" width="50" height="50" alt="Noticia ASUAVETA"> <?php echo $datos['tipo_categoria']; ?></td>
                                    <td class="text-center"><?php echo $datos['nombre_usu'] . " " . $datos['apellido_usu']; ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_publi<?php echo @$datos['id_publi']; ?>"><i class="fa fa-info-circle"></i></button>
                                    </td>
                                </tr>
                                <!--Modal para Gestionar publicación-->
                                <div class="modal fade" id="modal_publi<?php echo @$datos['id_publi']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title font-weight-bold"><i class="fa fa-edit"></i> PULICACIÓN #<?php echo $datos['id_publi'] ?></h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="../controllers/editar.php" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-star"></i> Categoría:</label>
                                                                <select class="form-control" name="notcategoria1" required>
                                                                    <option value="<?php echo $datos['fk_categoria_publi'] ?>" selected><?php echo $datos['tipo_categoria'] ?></option>
                                                                    <option value="1">NOTICIA</option>
                                                                    <option value="2">OFERTA</option>
                                                                    <option value="3">IMPORTANTE</option>
                                                                    <option value="4">INFORMACIÓN</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-star"></i> Estado</label>
                                                                <select class="form-control" name="notestado1" required>
                                                                    <option value="<?php echo $datos['fk_estado_publi'] ?>" selected><?php echo $datos['tipo_estado'] ?></option>
                                                                    <option value="6">PÚBLICO</option>
                                                                    <option value="5">ELIMINADO(A)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 text-center">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-user-edit"></i> Titulo:</label>
                                                                <textarea class="form-control" name="nottitulo1" rows="3" maxlength="150" placeholder="Escribe un título..." required><?php echo $datos['titulo_publi'] ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 text-center">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-edit"></i> Cuerpo:</label>
                                                                <textarea class="form-control" name="notcuerpo1" rows="3" placeholder="Escribe el contenido de la publicación..." maxlength="12000" required><?php echo $datos['cuerpo_publi'] ?></textarea>
                                                                <input type="hidden" name="not_idpubli1" value="<?php echo $datos['id_publi'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Guardar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //Tabla de recepción de pagos
    $(document).ready(function() {
        $('#tabla_publicaciones').DataTable({
            order: false
        });

    });
</script>
<script>
    function aprobarCom(idComment) {
        var IdComentario = idComment;
        var datosComentario = 'IdComentario=' + IdComentario;
        $.ajax({
            url: '../controllers/editar.php',
            type: 'post',
            data: datosComentario,
            success: function(respComentario) {
                Swal.fire({
                    type: 'success',
                    title: '¡Bien!',
                    html: respComentario,
                });
                $("#IdComment" + idComment).css("display", "none");
            }
        });
        return false;
    }
    //Eliminar comentario
    function elimCom(idComment) {
        var IdComentario = idComment;
        var datosComentario = 'IdComentario=' + IdComentario;
        $.ajax({
            url: '../controllers/eliminar.php',
            type: 'post',
            data: datosComentario,
            success: function(respComentario) {
                Swal.fire({
                    type: 'success',
                    title: '¡Bien!',
                    html: respComentario,
                });
                $("#IdComment" + idComment).css("display", "none");
            }
        });
        return false;
    }
    //Nueva publicación para el boletín informaivo
    function EnviarBoletin() {
        var Asunto = document.getElementById('BolAs').value;
        var Mensaje = document.getElementById('BolMens').value;
        var datosBoletin = 'BolAs=' + Asunto + '&BolMens=' + Mensaje;
        $.ajax({
            url: '../controllers/mailer/boletin.php',
            type: 'post',
            data: datosBoletin,
            beforeSend: function() {
                Swal.fire({
                    type: 'success',
                    html: '<strong>Enviando mensajes...</strong>',
                    showConfirmButton: false,
                });
            },
            success: function(respBoletin) {
                    Swal.fire({
                        type: 'info',
                        title: 'INFORMACIÓN:',
                        html: "<strong>"+respBoletin+"</strong>",
                    });
            }
        });
        return false;
    }
</script>
<?php include_once 'footer.php'; ?>