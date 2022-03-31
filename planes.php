<?php include_once 'nav_in.php';
include_once 'dashboard/controllers/conexion.php';
$sql_tar = "SELECT id_tar, cargo_fijo_tar, precio_mt_tar FROM tbl_tarifa ORDER BY id_tar ASC";
$consulta_tar = $pdo->prepare($sql_tar);
$consulta_tar->execute();
$cantidad_tar = $consulta_tar->rowCount();
$tarifas = $consulta_tar->fetchAll();
?>
<!-- Pricing section-->
<section class="bg-light py-1">
    <div class="container px-5 my-5">
        <div class="text-center mb-1">
            <h1 class="fw-bolder">Paga a medida que creces</h1>
            <p class="lead fw-normal text-muted mb-0">Con nuestros planes de precios sin complicaciones</p>
        </div>
        <div class="row gx-5 justify-content-center">
            <?php foreach ($tarifas as $tari) : 
                if ($tari['id_tar'] == 1) { ?>
            <div class="col-lg-6 col-xl-4 mt-4">
                <div class="card mb-5 mb-xl-0">
                    <div class="card-body p-5">
                        <div class="small text-uppercase fw-bold">
                            <i class="bi bi-star-fill text-warning"></i> ESPECIAL
                        </div>
                        <div class="mb-3">
                            <span class="display-5 fw-bold">$<?php echo number_format($tari['cargo_fijo_tar']) ?></span>
                            <span class="text-muted">/COP</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">
                                <i class="bi bi-check text-primary"></i>
                                <strong>Tarifa <?php echo $tari['id_tar'] ?></strong>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check text-primary"></i> Consumo: <strong>$<?php echo number_format($tari['precio_mt_tar']) ?> x m3</strong>
                            </li>
                            <li class="text-muted">
                                <i class="bi bi-x"></i> No tiene cargo fijo
                            </li>
                        </ul>
                        <div class="d-grid"><a class="btn btn-primary" href="index.php#btnnuevoservicio">Aplicar</a></div>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
                <div class="col-lg-6 col-xl-4 mt-4">
                <div class="card mb-5 mb-xl-0">
                    <div class="card-body p-5">
                    <div class="small text-uppercase fw-bold text-muted">General</div>
                        <div class="mb-3">
                            <span class="display-5 fw-bold">$<?php echo number_format($tari['cargo_fijo_tar']) ?></span>
                            <span class="text-muted">/COP</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">
                                <i class="bi bi-check text-primary"></i>
                                <strong>Tarifa <?php echo $tari['id_tar'] ?></strong>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check text-primary"></i> Consumo: <strong>$<?php echo number_format($tari['precio_mt_tar']) ?> x m3</strong>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check text-primary"></i> Cargo fijo: <strong>$<?php echo number_format($tari['cargo_fijo_tar']) ?></strong>/mes
                            </li>
                        </ul>
                        <div class="d-grid"><a class="btn btn-outline-primary disabled" href="index.php#btnnuevoservicio">Aplicar</a></div>
                    </div>
                </div>
            </div>
<?php } endforeach ?>
        </div>
    </div>
</section>
</main>
<!-- Footer-->
<?php include_once 'footer.php' ?>