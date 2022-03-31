<?php
include_once 'nav_in.php';
include_once 'dashboard/controllers/conexion.php';
$sql_notis = "SELECT id_publi, titulo_publi, tipo_categoria, cuerpo_publi, imagen_publi, fecha_publi, fk_autor_publi, nombre_usu, apellido_usu, foto_perfil_usu FROM tbl_publicacion
INNER JOIN tbl_usuario ON id_usu=fk_autor_publi
INNER JOIN tbl_categoria ON id_categoria=fk_categoria_publi
WHERE fk_estado_publi=6
ORDER BY fecha_publi DESC";
$consulta_notis = $pdo->prepare($sql_notis);
$consulta_notis->execute();
$resnotices = $consulta_notis->fetchAll();
?>
        <section class="py-5">
            <div class="container px-5">
                <h1 class="fw-bolder fs-5 mb-4">ASUAVETA</h1>
                <?php if (!$resnotices) { ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>¡No hay publicaciones!</strong> Puedes estar atento a próximas novedades...
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <div class="card border-0 shadow rounded-3 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row gx-0">
                            <div class="col-lg-6 col-xl-5 py-lg-5">
                                <div class="p-4 p-md-5">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">Noticias y novedades <i class="fa fa-star"></i></div>
                                    <div class="h2 fw-bolder">Infórmate con nuestro noticiero web...</div>
                                    <p>En este espacio, podrás mantenerte actualizado sobre la información de interés para los usuarios del acueducto y comunidad en general.</p>
                                    <a class="stretched-link text-decoration-none" href="#contenido_news">
                                        Empezar
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-7">
                                <div class="bg-featured-blog" style="background-image: url('assets/img/news.jpg')"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Page Content-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5" id="contenido_news">
                    <?php foreach ($resnotices as $resnoti) : ?>
                        <div class="col-lg-3" id="id_publi<?php echo $resnoti['id_publi'] ?>">
                            <div class="d-flex align-items-center mt-lg-5 mb-4">
                                <img class="img-fluid rounded-circle" width="50" height="50" src="dashboard/perfiles/<?php echo $resnoti['foto_perfil_usu'] ?>" alt="Autor" />
                                <div class="ms-3">
                                    <div class="fw-bold"><?php echo $resnoti['nombre_usu'] ?></div>
                                    <div class="text-muted">Administrador(a)</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <article>
                                <header class="mb-4">
                                    <!-- Post title-->
                                    <h1 class="fw-bolder mb-1"><?php echo $resnoti['titulo_publi'] ?></h1>
                                    <!-- Post meta content-->
                                    <div class="text-muted fst-italic mb-2">Fecha de publicación: <?php echo $resnoti['fecha_publi'] ?></div>
                                    <a class="badge bg-primary text-decoration-none link-light"><i class="far fa-star"></i> <?php echo $resnoti['tipo_categoria'] ?></a>
                                </header>
                                <!-- Preview image figure-->
                                <figure class="mb-4"><img class="img-fluid rounded" width="900" height="400" src="assets/img/posts/<?php echo $resnoti['imagen_publi'] ?>" onerror="this.src='assets/img/posts/default.jpg';" alt="Noticia ASUAVETA"></figure>
                                <!-- Post content-->
                                <section class="mb-5">
                                    <p style="word-wrap: break-word;" class="fs-5 mb-4 text-sm-justify"><?php echo nl2br($resnoti['cuerpo_publi']) ?></p>
                                </section>
                            </article>
                            <hr>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </section>
    </main>
    <?php include_once 'footer.php' ?>