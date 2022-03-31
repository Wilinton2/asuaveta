<?php require_once '../controllers/conexion.php'; //Todo de la tabla usuario para mostrar las opciones en el datalist
//Recepción de pagos
$sql_pago_m = "SELECT numero_fac, lectura_anterior_fac, lectura_actual_fac, fecha_actual_fac, precio_mt_fac, cargo_fijo_fac, cobro_extra_fac, descuento_fac, fk_servicio_fac, fk_suscriptor_serv, id_usu, nombre_usu, apellido_usu FROM tbl_servicio as SER
INNER JOIN tbl_factura as FAC ON FAC.fk_servicio_fac=SER.id_serv
INNER JOIN tbl_usuario as US ON US.id_usu=SER.fk_suscriptor_serv
WHERE fk_estado_fac =7 ORDER BY fecha_actual_fac ASC";
$consulta_pago_m = $pdo->prepare($sql_pago_m);
$consulta_pago_m->execute();
$resultado_pago_m = $consulta_pago_m->rowCount();
$pagos_p = $consulta_pago_m->fetchAll();
?>
<div class="container">
  <h4 class="title mt-1 text-primary text-center">RECEPCIÓN DE PAGOS DE FACTURAS</h4>
  <p class="text-center font-weight-bold">Puedes escanear el código QR de la factrura física con tu smartphone</p>
  <p class="text-center">En este espacio podrás realizar el pago manual de las facturas pendientes.<br>Puscar por nombre del cliente, cédula, número de contrato, y por el número de factura.</p>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table id="tabla_pagos" class="table table-striped table-bordered">
            <thead>
              <tr class="text-primary">
                <th class="text-center font-weight-bold"># Factura</th>
                <th class="text-center font-weight-bold">Cliente</th>
                <th class="font-weight-bold">Detalles</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pagos_p as $datos) :
                $consumo = $datos['lectura_actual_fac'] - $datos['lectura_anterior_fac'];
                $subtotal = $datos['precio_mt_fac'] * $consumo + $datos['cargo_fijo_fac'] + $datos['cobro_extra_fac'];
                $total = $subtotal - $datos['descuento_fac'];
                ['lectura_anterior_fac'];
                $subtotal = $datos['precio_mt_fac'] * $consumo + $datos['cargo_fijo_fac'] + $datos['cobro_extra_fac'];
                $total_factura = $subtotal - $datos['descuento_fac'];
              ?>
                <tr>
                  <td class="text-center text-uppercase"><?php echo $datos['numero_fac']; ?> <small style="display: none;"><?php echo "Contrato: " . $datos['fk_servicio_fac'] ?></small></td>
                  <td class="text-center"><?php echo "CC. " . $datos['fk_suscriptor_serv'] . " | " . $datos['nombre_usu'] . " " . $datos['apellido_usu']; ?></td>
                  <td>
                    <form class="d-inline" action="facturas/index.php" method="post" target="_blank">
                      <button type="submit" class="btn btn-sm btn-primary" name="factura" value="<?php echo @$datos['numero_fac'] ?>"><i class="fa fa-print"></i></button>
                    </form>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_factura<?php echo @$datos['numero_fac']; ?>"><i class="fa fa-hand-holding-usd"></i></button>
                  </td>
                </tr>
                <!-- Modal para ir al proceso de pago de factura manualmente -->
                <div class="modal fade" id="modal_factura<?php echo @$datos['numero_fac']; ?>" tabindex="-1">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-center font-weight-bold">¿Seguro que quieres pagar esta factura?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body text-left">
                        <span class="font-weight-bold">Cliente: </span><?php echo @$datos['nombre_usu'] . " " . $datos['apellido_usu'] ?><br>
                        <span class="font-weight-bold">Numero de factura: </span><?php echo @$datos['numero_fac'] ?><br><span class="font-weight-bold">Periodo: </span><span class="text-uppercase"><?php echo strftime("%B del año %Y", strtotime(@$datos['fecha_actual_fac'])) ?></span><br>
                        <span class="font-weight-bold">Fecha límite de pago: </span><?php $limite = strtotime(date(@$datos['fecha_fac']) . "+ 15 days");
                                                                                    echo date("Y-m-d", $limite); ?><br>
                        <span class="font-weight-bold">Documento: </span><?php echo @$datos['id_usu'] ?><br>
                        <span class="font-weight-bold">Contrato: </span><?php echo @$datos['fk_servicio_fac'] ?><br>
                        <span class="font-weight-bold">Fecha: </span><?php echo @$datos['fecha_actual_fac'] ?><br>
                        <span class="font-weight-bold">Valor: </span>$<?php echo number_format(@$total_factura) ?><br>
                        <div class="text-right">
                          <img width="150px" height="150px" src="facturas/codigos/<?php echo $datos['numero_fac'] ?>.png" alt="Código QR para pagar factura ASUAVETA" onerror="this.src='facturas/pagada.gif'">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">No, cancelar <i class="fa fa-times"></i></button>
                        <a class="btn btn-success" href="facturas/receive_payment.php?asua22=<?php echo base64_encode(@$datos['numero_fac']) ?>"><i class="fa fa-hand-holding-usd"></i> Si, pagar</a>
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
    $('#tabla_pagos').DataTable();
  });
</script>