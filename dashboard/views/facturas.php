<?php
include_once 'nav_usu.php';
//Selección de los datos de facturas pendientes
$sql = "SELECT * FROM tbl_servicio as SER
INNER JOIN tbl_factura as FAC ON FAC.fk_servicio_fac=SER.id_serv
INNER JOIN tbl_usuario as US ON US.id_usu=SER.fk_suscriptor_serv 
WHERE id_usu=? AND fk_estado_fac =7";
$consulta_fac = $pdo->prepare($sql);
$consulta_fac->execute(array($id));
$total_pend = $consulta_fac->rowCount();
$facturas = $consulta_fac->fetchAll();
//Historial de facturación...
$sql_hist = "SELECT * FROM tbl_servicio as SER
INNER JOIN tbl_factura as FAC ON FAC.fk_servicio_fac=SER.id_serv
INNER JOIN tbl_usuario as US ON US.id_usu=SER.fk_suscriptor_serv
INNER JOIN tbl_estado as EST ON EST.id_estado=FAC.fk_estado_fac 
WHERE id_usu=? ORDER BY fk_servicio_fac DESC";
$consulta_hist = $pdo->prepare($sql_hist);
$consulta_hist->execute(array($id));
$resultado_hist = $consulta_hist->rowCount();
$historial = $consulta_hist->fetchAll();
?>
<div class="panel-header">
    <div class="header text-center">
        <h3 class="title">Área de facturación</h3>
        <p class="text-muted">Realiza tus consultas referentes a facturas</p>
    </div>
</div>
<!--Facturas-->
<div class="container">
    <div class="card text-center bg-default">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item" id="btnpendientes">
                    <a onclick="vacio()" type="button" class="nav-link active">Facturas pendientes</a>
                </li>
                <li class="nav-item" id="btnhistorial">
                    <a type="button" class="nav-link active">Historial financiero</a>
                </li>
            </ul>
        </div>
        <!--Comienza contenido de facturas pendientes-->
        <div class="m-4 card-body" id="pendientes">
            <?php if ($facturas == null) { ?>
                <div class="text-center">
                    <p class="font-italic">Recuerda que puedes consultar tu historial de facturación <button class="btn btn-primary btn-sm" id="btnhistorial_dos">Aquí <i class="fa fa-arrow-right"></i></button></p>
                </div>
                <script>
                    function vacio() {
                        Swal.fire({
                            type: 'success',
                            title: '¡No tienes facturas pendientes!',
                            text: '¡Muchas gracias por utilizar nuestros canales virtuales de información!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                </script>
            <?php   } else { ?>
                <h5 class="card-title">Facturas sin pagar</h5>
                <p class="card-text">En este espacio podrás visualizar tus facturas pendientes por pagar</p>
            <?php } ?>
            <?php foreach ($facturas as $endos) :
                $mod_date = strtotime(date(@$endos['fecha_actual_fac']) . "+ 15 days");
                $fecha_limite = date("d-M-Y", $mod_date);
                $consumo = $endos['lectura_actual_fac'] - $endos['lectura_anterior_fac'];
                $subtotal = $endos['precio_mt_fac'] * $consumo + $endos['cargo_fijo_fac'] + $endos['cobro_extra_fac'];
                $total_fac = $subtotal - $endos['descuento_fac'];
            ?>
                <div class="card col-md-3 mb-3 m-1">
                    <div class="invoice-ribbon">
                        <div class="ribbon-inner">PENDIENTE</div>
                    </div>
                    <div class="card-header text-primary font-weight-bold">
                        <?php echo @$endos['fk_servicio_fac'] ?>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-uppercase font-weight-bold"><?php echo strftime("%B de %Y", strtotime(@$endos['fecha_anterior_fac'])); ?></h4>
                        <p class="card-text">$<?php echo number_format($total_fac); ?></p>
                        <form action="facturas/index.php" method="post" target="_blank">
                            <button type="submit" class="btn btn-primary" name="factura" value="<?php echo @$endos['numero_fac'] ?>"><i class="fa fa-print"></i> Descargar</button>
                        </form>
                    </div>
                    <div class="card-footer text-muted">
                        <small>Desde el día <?php echo utf8_encode(strftime("%A %d de %B de %Y", strtotime(@$fecha_limite))); ?></small>
                    </div>
                </div>
            <?php endforeach ?>

        </div>

        <div id="historial" style="display: none;">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title font-weight-bold"> Historial de facturación</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="font-weight-bold text-primary">
                                    <th class="font-weight-bold">
                                        Número
                                    </th>
                                    <th class="font-weight-bold">
                                        Periodo
                                    </th>
                                    <th class="font-weight-bold">
                                        Servicio
                                    </th>
                                    <th class="font-weight-bold text-right">
                                        Valor
                                    </th>
                                </thead>
                                <tbody>
                                    <?php foreach (@$historial as $item) : 
                                                        $consumo = $item['lectura_actual_fac'] - $item['lectura_anterior_fac'];
                                                        $subtotal = $item['precio_mt_fac'] * $consumo + $item['cargo_fijo_fac'] + $item['cobro_extra_fac'];
                                                        $total_fac = $subtotal - $item['descuento_fac'];
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo @$item['numero_fac']; ?>
                                                    <span class="badge badge-info">¡<?php echo $item['tipo_estado'] ?>!</span>
                                            </td>
                                            <td class="text-uppercase">
                                                <?php echo strftime("%B del año %Y", strtotime(@$item['fecha_anterior_fac'])); ?>
                                            </td>
                                            <td>
                                                <?php echo @$item['fk_servicio_fac']; ?>
                                            </td>
                                            <td class="text-right font-weight-bold">
                                                $<?php echo number_format(@$total_fac); ?>
                                                <form action="facturas/index.php" method="post" target="_blank">
                                                    <button type="submit" class="btn btn-sm btn-success" name="factura" value="<?php echo @$item['numero_fac'] ?>"><i class="fa fa-print"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <small class="text-muted">¡Es un placer servirte!</small>
        </div>
    </div>
</div>
<script>
    //Mostrar historial financiero
    $('#btnhistorial').click(function() {
        $("#pendientes").css("display", "none");
        $("#historial").css("display", "block");
    });
    $('#btnhistorial_dos').click(function() {
        $("#pendientes").css("display", "none");
        $("#historial").css("display", "block");
    });
    //Mostrar facturas pendientes
    $('#btnpendientes').click(function() {
        $("#historial").css("display", "none");
        $("#pendientes").css("display", "block");
    });
</script>

<?php
include_once 'footer.php';
?>