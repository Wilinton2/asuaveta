<?php include_once 'nav.php';
//Consulta general del usuario logueado
$sql_log = "SELECT * FROM tbl_usuario as USU
INNER JOIN tbl_servicio as SER ON USU.id_usu=SER.fk_suscriptor_serv
INNER JOIN tbl_rol as ROL ON ROL.id_rol=USU.fk_rol_usu
INNER JOIN tbl_tarifa as TAR ON TAR.id_tar=SER.fk_tarifa_serv
INNER JOIN tbl_estado as EST ON EST.id_estado=SER.fk_estado_serv WHERE fk_estado_serv !=4";
$consulta_log = $pdo->prepare($sql_log);
$consulta_log->execute();
$tokens = $consulta_log->rowCount();
$resultado_log = $consulta_log->fetchAll();
//Tarifas select
//Gráfico de tarifas
$sql_tar = "SELECT id_tar, cargo_fijo_tar, precio_mt_tar FROM tbl_tarifa ORDER BY id_tar ASC";
$consulta_tar = $pdo->prepare($sql_tar);
$consulta_tar->execute();
$cantidad_tar = $consulta_tar->rowCount();
$tarifas = $consulta_tar->fetchAll();
?>
<div class="panel-header">
    <div class="header text-center">
        <h3 class="title">Servicios y tarifas</h3>
        <p class="text-muted">Gestiona los servicios contratados y tarifas de cada uno de ellos...</p>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-11 mt-3" style="margin: 0 auto;">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Revisión detallada de servicios y tarifas</h5>
                    <h4 class="card-title font-weight-bold">Servicios Contratados</h4>
                </div>
                <div class="card-body">
                    <div class="p-2">
                        <p><label class="font-weight-bold">Tienes <?php echo $tokens ?> contrato(s) con nosotros...</label></p>
                        <div class="table-responsive">
                            <table class="table" id="tabla_servicios_admin">
                                <thead class="font-weight-bold text-primary">
                                    <th class="font-weight-bold text-center">
                                        Servicio
                                    </th>
                                    <th class="font-weight-bold text-center">
                                        Estado
                                    </th>
                                    <th class="font-weight-bold text-center">
                                        Fecha
                                    </th>
                                    <th class="font-weight-bold text-center">
                                        Detalles
                                    </th>
                                </thead>
                                <tbody>
                                    <?php foreach ($resultado_log as $serTar) { ?>
                                        <tr>
                                            <td class="font-weight-bold text-center">
                                                <?php echo @$serTar['id_serv'] ?>
                                            </td>
                                            <td class="text-uppercase text-center">
                                                <span class="badge badge-warning d-inline"><?php echo $serTar['tipo_estado'] ?></span>
                                            </td>
                                            <td class="font-italic text-center">
                                                <?php echo @$serTar['fecha_serv']; ?>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#servicio<?php echo $serTar['id_serv'] ?>"><i class="far fa-info-circle"></i></button>
                                            </td>
                                        </tr>
                                        <!--Modal detalles de servicios y tarifas-->
                                        <div class="modal fade" id="servicio<?php echo $serTar['id_serv'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title font-weight-bold"><i class="fa fa-water"></i> DETALLES DEL SERVICIO</h3>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-briefcase"></i> SERVICIO:</label>
                                                                    <p class="font-weight-bold"><?php echo $serTar['id_serv'] ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8 text-center">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-download"></i> DESCARGAR COPIA DEL CONTRATO:</label>
                                                                  <a class="m-4" href="../controllers/reportes/contratos/contrato.php?servicio=<?php echo $serTar['id_serv'] ?>" target="_blank"><i class="fa fa-download text-dark" style="font-size: large;"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-user-check"></i> Titular:</label>
                                                                    <p class="font-weight-bold"><?php echo $serTar['nombre_usu'] . " " . $serTar['apellido_usu'] ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-id-card"></i> Documento:</label>
                                                                    <p class="font-weight-bold"><?php echo $serTar['fk_suscriptor_serv'] ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-map-marker-smile"></i> Dirección del inmueble:</label>
                                                                    <p><small class="font-weight-bold"><?php echo $serTar['direccion_usu'] ?></small></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fad fa-gem"></i> Estado:</label>
                                                                    <p class="font-weight-bold"><?php echo $serTar['tipo_estado'] ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 text-center">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-success"><i class="fas fa-balance-scale"></i> TARIFA:</label>
                                                                    <p class="font-weight-bold"><?php echo $serTar['fk_tarifa_serv'] ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-success"><i class="fas fa-badge-dollar"></i> Precio metro cúbico:</label>
                                                                    <p class="font-weight-bold">$<?php echo number_format($serTar['precio_mt_tar']) ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-success"><i class="fas fa-badge-dollar"></i> Cargo fijo:</label>
                                                                    <p class="font-weight-bold">$<?php echo number_format($serTar['cargo_fijo_tar']) ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group text-center">
                                                                    <form onsubmit="return formEditTarifa(<?php echo $serTar['id_tar'] ?>)" method="post">
                                                                        <label>Edita la tarifa actual...</label>
                                                                        <select class="form-control" id="TarEdit<?php echo $serTar['id_tar'] ?>" required>
                                                                            <option value="<?php echo $serTar['id_tar'] ?>" selected><?php echo $serTar['id_tar'] ?> | Cargo fijo: $<?php echo number_format($serTar['cargo_fijo_tar']) . " | M3: $" . number_format(@$nivel['precio_mt_tar']) ?> (Actual)</option>
                                                                            <?php foreach ($tarifas as $nivel) { ?>
                                                                                <option value="<?php echo @$nivel['id_tar'] ?>"><?php echo $nivel['id_tar'] ?> | Cargo fijo: $<?php echo number_format($nivel['cargo_fijo_tar']) . " | M3: $" . number_format(@$nivel['precio_mt_tar']) ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <input type="hidden" id="ServEdit<?php echo $serTar['id_tar'] ?>" value="<?php echo $serTar['id_serv'] ?>">
                                                                        <button type="submit" class="btn btn-success">Actualizar tarifa</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Fin del modal de detalles de servicios y tarifas-->
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="far fa-hand-point-up"></i> Tus servicios a un click
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //Tabla de recepción de pagos
    $(document).ready(function() {
        $('#tabla_servicios_admin').DataTable();
    });
    //Función de edición de tarifa de servicio
    function formEditTarifa(IDT) {
        var Tarifa = document.getElementById('TarEdit'+IDT).value;
        var Servicio = document.getElementById('ServEdit'+IDT).value;
        var datosSol = 'TarifaServicioEdit=' + Tarifa + '&IdServicioEditar=' + Servicio;
        $.ajax({
            url: '../controllers/editar.php',
            type: 'post',
            data: datosSol,
            beforeSend: function() {
                Swal.fire({
                    type: 'info',
                    text: 'Validando información...',
                    showConfirmButton: false,
                });
            },
            success: function(resp_Sol) {
                if (resp_Sol == 5) {
                    Swal.fire({
                        type: 'success',
                        title: '¡Tarifa actualizada!',
                        html: 'La tarifa para el servicio ' + Servicio + ' se ha actualizado correctamente...',
                    });
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'ERROR',
                        html: resp_Sol,
                    });
                }
            }
        });
        return false;
    };
</script>
<?php include_once 'footer.php' ?>