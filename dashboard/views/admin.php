<?php
require_once 'nav.php';
setlocale(LC_ALL, "es_CO", "es_ES", "esp");
//Gráfico de tarifas
$sql_tar = "SELECT id_tar, cargo_fijo_tar, precio_mt_tar FROM tbl_tarifa ORDER BY id_tar ASC";
$consulta_tar = $pdo->prepare($sql_tar);
$consulta_tar->execute();
$cantidad_tar = $consulta_tar->rowCount();
$tarifas = $consulta_tar->fetchAll();
//Servicios suspendidos
$sql_susp = "SELECT fk_suscriptor_serv, id_serv, nombre_usu, apellido_usu FROM tbl_servicio as SER
INNER JOIN tbl_usuario as US ON US.id_usu=SER.fk_suscriptor_serv WHERE fk_estado_serv=3";
$consulta_susp = $pdo->prepare($sql_susp);
$consulta_susp->execute();
$resultado_susp = $consulta_susp->rowCount();
$ser_susp = $consulta_susp->fetchAll();
//Editar contrato de prestación de servicios uniformes
if ($fp = fopen("../controllers/reportes/contratos/contrato.txt", "r")) {
  $data = fread($fp, filesize("../controllers/reportes/contratos/contrato.txt"));
  fclose($fp);
}
//Gráficos
$head_tar = "";
$data_tar = "";
$precio_mt = "";
foreach ($tarifas as $tarifa) {
  setlocale(LC_TIME, "es_CO");
  $head_tar .= $tarifa['cargo_fijo_tar'] . ', ';
  $data_tar .= $tarifa['id_tar'] . ', ';
  $precio_mt .= $tarifa['precio_mt_tar'] . ', ';
}
$top_tar = rtrim($head_tar, ", ");
$data_foot = rtrim($data_tar, ", ");
$metro_precio = rtrim($precio_mt, ", ");
//Gráfico de consumo general
$sql = "SELECT SUM(lectura_anterior_fac) AS lecant, SUM(lectura_actual_fac) AS lecact, monthname(fecha_anterior_fac) as 'Mes' FROM tbl_factura as FA WHERE year(fecha_anterior_fac)=YEAR(CURDATE()) GROUP BY month(fecha_anterior_fac)";
$consulta = $pdo->prepare($sql);
$consulta->execute();
$grafico = $consulta->fetchAll();

//Gráfica de metros consumidos mensualmente (general)
$label = "";
$datos = "";
foreach ($grafico as $datossql) {
  $lanterior = $datossql['lecant'];
  $lactual = $datossql['lecact'];
  $toatalconsumo = $lactual - $lanterior;
  $label .=  "'" . strftime("%B", strtotime($datossql['Mes'])) . "'" . ', ';
  $datos .= $toatalconsumo . ', ';
}
$label = rtrim($label, ", ");
$datos = rtrim($datos, ", ");
?>
<link rel="stylesheet" href="../assets/demo/demo.css">
<script>
  //Gráfico de consumo general
  let label = [<?php echo strtoupper($label); ?>];
  let datos = [<?php echo $datos; ?>];
  //Gráfico de tarifas
  let label_tar = [<?php echo $data_foot; ?>];
  let datos_tar = [<?php echo $top_tar; ?>];
  let metro = [<?php echo $metro_precio; ?>];
</script>
<script src="../assets/demo/demo.js"></script>
<script src="../assets/demo/jswil.js"></script>
<link rel="stylesheet" href="../assets/demo/demo.css">
<div class="panel-header panel-header-lg" style="margin-top: -5px;">
  <canvas id="bigDashboardChart"></canvas>
</div>
<div class="content">
  <div class="row">
    <div class="col-lg-4">
      <div class="card card-chart">
        <div class="card-header">
          <h5 class="card-category">Administra los precios y tarifas</h5>
          <h4 class="card-title font-weight-bold">Tarifas</h4>
          <div class="dropdown">
            <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="modal" data-target="#modal_tarifas_editar">
              <i class="far fa-money-bill-alt"></i>
            </button>
            <div class="modal fade" id="modal_tarifas_editar" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><i class="far fa-badge-dollar"></i> ADMINISTRACIÓN DE PLANES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <table class="table" id="tblAdd">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold text-primary">ID</th>
                          <th class="font-weight-bold text-primary">CARGO FIJO</th>
                          <th class="font-weight-bold text-primary">PRECIO M3</th>
                          <th class="text-right font-weight-bold text-primary">ACCIÓN</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($tarifas as $opTar) :
                          if ($opTar['id_tar'] == 1) { ?>
                            <form method="post" onsubmit="return editTarifa('<?php echo $opTar['id_tar'] ?>')">
                              <tr>
                                <td class="text-center font-weight-bold text-warning"><?php echo $opTar['id_tar'] ?></td>
                                <td><input class="form-control" type="text" value="0" onkeyup="this.value=Numeros(this.value)" id="cargo<?php echo $opTar['id_tar'] ?>" placeholder="Cargo fijo..." required disabled></td>
                                <td><input class="form-control" type="text" value="<?php echo number_format($opTar['precio_mt_tar']) ?>" onkeyup="this.value=Numeros(this.value)" id="precio<?php echo $opTar['id_tar'] ?>" placeholder="Precio m3..." required></td>
                                <input type="hidden" id="id_de_tarifa_editar<?php echo $opTar['id_tar'] ?>" value="<?php echo $opTar['id_tar'] ?>">
                                <td class="td-actions text-right">
                                  <button type="submit" rel="tooltip" title="Editar esta tarifa" class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i> M3</button>
                                </td>
                              </tr>
                            </form>
                          <?php } else { ?>
                            <form method="post" onsubmit="return editTarifa('<?php echo $opTar['id_tar'] ?>')">
                              <tr>
                                <td class="text-center font-weight-bold text-warning"><?php echo $opTar['id_tar'] ?></td>
                                <td><input class="form-control" type="text" value="<?php echo number_format($opTar['cargo_fijo_tar']) ?>" onkeyup="this.value=Numeros(this.value)" id="cargo<?php echo $opTar['id_tar'] ?>" placeholder="Cargo fijo..." required></td>
                                <td><input class="form-control" type="text" value="<?php echo number_format($opTar['precio_mt_tar']) ?>" onkeyup="this.value=Numeros(this.value)" id="precio<?php echo $opTar['id_tar'] ?>" placeholder="Precio m3..." required></td>
                                <input type="hidden" id="id_de_tarifa_editar<?php echo $opTar['id_tar'] ?>" value="<?php echo $opTar['id_tar'] ?>">
                                <td class="td-actions text-right">
                                  <button type="submit" rel="tooltip" title="Editar esta tarifa" class="btn btn-info btn-simple btn-icon btn-sm">
                                    <i class="fas fa-pencil-alt"></i>
                                  </button>
                                  <button type="button" rel="tooltip" title="Eliminar esta tarifa" class="btn btn-danger btn-sm btn-round btn-icon" onclick="eliminarTarifa(<?php echo $opTar['id_tar'] ?>)">
                                    <i class="far fa-trash-alt"></i>
                                  </button>
                                </td>
                              </tr>
                            </form>
                          <?php } ?>
                        <?php endforeach ?>
                        <form method="post" id="formAddReset" onsubmit="return enviarAddform()">
                          <tr style="display: none;" id="form_addtar">
                            <td class="text-center font-weight-bold text-warning" id="addtarifa">*</td>
                            <td><input class="form-control" placeholder="Cargo fijo..." type="text" onkeyup="this.value=Numeros(this.value)" id="addcargo" required></td>
                            <td><input class="form-control" placeholder="Precio m3..." type="text" onkeyup="this.value=Numeros(this.value)" id="addprecio" required></td>
                            <input type="hidden" id="addidtar" value="<?php echo $cantidad_tar ?>">
                            <td class="td-actions text-right">
                              <button type="submit" rel="tooltip" title="Guardar tarifa" class="btn btn-success btn-simple btn-icon btn-sm">
                                <i style="font-size: large;" class="fas fa-save"></i>
                              </button>
                              <button type="button" rel="tooltip" title="Cancelar y cerrar" class="btn btn-primary btn-simple btn-icon btn-sm" onclick="quitarAdd()">
                                <i style="font-size: large;" class="fas fa-times"></i>
                              </button>
                            </td>
                          </tr>
                        </form>
                      </tbody>
                    </table>
                    <?php if ($cantidad_tar < 10) { ?>
                      <div class="mt-2 text-center">
                        <button id="btnAdd" type="button" rel="tooltip" title="Añadir tarifa" class="btn btn-success btn-icon btn-sm" onclick="return mostrarAdd()">
                          <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    <?php } ?>
                    <div class="card-footer text-center">
                      <div class="stats">
                        <i class="far fa-money-check-edit-alt"></i> Asigna y/o administra hasta 10 tarifas...
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Fin modal-->
          </div>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <canvas id="grafica"></canvas>
          </div>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="far fa-chart-bar"></i> ¡Equidad y compromiso!
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card card-chart">
        <div class="card-header">
          <h5 class="card-category">Reportes y constancias del SIA</h5>
          <h4 class="card-title font-weight-bold">Certificados</h4>
          <div class="dropdown">
            <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
              <i class="far fa-print-search"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item font-weight-bold" href="../controllers/reportes/clients.php" target="_blank"><i class="far fa-users"></i> Clientes</a>
              <a class="dropdown-item font-weight-bold" href="../controllers/reportes/admins.php" target="_blank"><i class="far fa-user-lock"></i> Administradores</a>
              <a class="dropdown-item font-weight-bold" href="../controllers/reportes/finanzas.php" target="_blank"><i class="far fa-balance-scale"></i> Finanzas</a>
              <a class="dropdown-item font-weight-bold" href="#" data-toggle="modal" data-target="#comprobantePago"><i class="far fa-sack-dollar"></i> Comprobante de pago</a>
              <a class="dropdown-item text-primary font-weight-bold" onclick="copiabd()" href="#"><i class="far fa-database"></i> Copia de seguridad BD</a>
            </div>
          </div>
        </div>
        <!-- Modal para generar comprobante de pago-->
        <div class="modal fade" id="comprobantePago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h6 class="modal-title font-weight-bold"><i class="fad fa-search-dollar"></i> DATOS PARA EL COMPROBANTE:</h6>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="pl-2 pr-2 text-center text-muted">Para generar tu comprobante de pago, es necesario ingresar el número de factura que ha sido cancelada, en caso de no tenerlo, puedes consultarlo en el historial de pagos de usuario...</p>
                <form method="post" action="../controllers/reportes/comprobante.php" target="_blank">
                  <div class="row">
                    <div class="col-md-8 mb-3 text-center" style="margin: 0 auto;">
                      <label class="font-weight-bold text-uppercase">NÚMERO DE FACTURA:</label>
                      <input type="number" name="num_factura" class="form-control is-valid" required>
                    </div>
                  </div>
              </div>
              <div class="text-center">
                <button class="btn btn-success" type="submit"><i class="far fa-print"> </i> Generar</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-body">
          <ul class="list-group text-justify">
            Aquí puedes generar reportes en diferentes formatos, dichos reportes se realizan con la información actual a la fecha tales como reporte de clientes y administradores registrados, reporte de facturas, consumos, recursos monetarios de la empresa, gastos, ingresos, reporte de la base de datos (Copia de seguridad), etc.
          </ul>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="far fa-info-circle"></i> Transparencia de información
          </div>
        </div>
      </div>
    </div>



    <div class="col-lg-4 col-md-6">
      <div class="card card-chart">
        <div class="card-header">
          <h5 class="card-category">Contrato para nuevo servicio</h5>
          <h4 class="card-title font-weight-bold">Nuevo servicio</h4>
          <div class="dropdown">
            <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="modal" data-target="#editarcontrato">
              <i class="far fa-file-signature"></i>
            </button>
          </div>
        </div>
        <!--Modal editar contrato-->
        <div class="modal fade" id="editarcontrato" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <form method="post" onsubmit="return editContrato()">
                <fieldset>
                  <legend class="text-center font-weight-bold text-primary">Contrato de prestación de servicios uniformes</legend>
                  <div class="m-2 form-group">
                    <p class="pl-5 pr-5 font-weight-bold text-muted text-center">Estimado administrador, aquí puedes realizar modificaciones a las cláusulas del contrato según sea pertinente para la empresa y el cliente..</p>
                    <textarea class="form-control" id="newdata" rows="18"><?php echo $data ?></textarea><br>
                  </div>
                  <div class="text-center">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="far fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="far fa-spinner"></i> Actualizar contrato</button>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
        <!--Fin del modal editar contrato-->
        <div class="card-body">
          <div class="chart-area p-1">
            <div class="text-center">
              <form method="post" id="formRad">
                <div class="col-md-12 mb-3">
                  <label class="font-weight-bold text-uppercase">CÉDULA DEL CLIENTE</label>
                  <input type="number" class="form-control" placeholder="Solo números..." id="DocSol" max="100000000000000" required>
                </div>
                <div class="col-md-12 mb-3">
                  <label class="font-weight-bold text-uppercase">TARIFA:</label>
                  <select class="form-control" id="TarSol" required>
                    <option value="">Según nivel socioeconómico...</option>
                    <?php foreach ($tarifas as $nivel) { ?>
                      <option value="<?php echo @$nivel['id_tar'] ?>"><?php echo $nivel['id_tar'] ?> | Cargo fijo: $<?php echo number_format($nivel['cargo_fijo_tar']) . " | M3: $" . number_format(@$nivel['precio_mt_tar']) ?></option>
                    <?php } ?>
                  </select>
                </div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#validar_radicado"><i class="far fa-handshake"></i> Ingresar radicado</button>
                <div class="modal fade" id="validar_radicado" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title font-weight-bold"><i class="far fa-file-contract"></i> CREAR CONTRATO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body text-center">
                        <div class="col-md-12 mb-3">
                          <label class="font-weight-bold text-uppercase">NÚMERO DE RADICADO:</label>
                          <input class="form-control is-valid" id="RadSol" maxlength="7" minlength="7" placeholder="Radicado de la solicitud..." required></input>
                        </div>
                        <div class="card-footer text-center">
                          <div class="stats">
                            <button type="submit" class="btn btn-success"><i style="font-size: large;" class="far fa-award"></i> Validar</button>
                          </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Fin del modal -->
    </form>
  </div>
</div>
</div>
<div class="card-footer">
  <div class="stats">
    <i class="far fa-file-contract"></i> ¡Compromiso mútuo!
  </div>
</div>
</div>
</div>
<!--Fin row-->
</div>
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-category">Imprimir órdenes de suspensión...</h5>
        <h4 class="card-title font-weight-bold"><i class="text-primary fas fa-cut"></i> Servicios Suspendidos</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <?php if (!$ser_susp) { ?>
            <br><br>
            <p class="text-primary font-weight-bold text-center">¡Todo bien, no hay servicios con orden de suspensión vigente!</p>
            <br><br><br><br>
          <?php } else { ?>
            <table class="table">
              <thead class="font-weight-bold text-primary">
                <th class="font-weight-bold">
                  Servicio
                </th>
                <th class="font-weight-bold">
                  Cliente
                </th>
                <th class="font-weight-bold">
                  CC
                </th>
                <th class="font-weight-bold text-right">
                  Suspensión
                </th>
              </thead>
              <tbody>
                <?php foreach (@$ser_susp as $item) : ?>
                  <tr>
                    <td>
                      <?php echo @$item['id_servicio'] ?>
                      <span class="badge badge-warning d-inline"><i class="fal fa-exclamation-triangle"></i> ¡SUSPENDIDO! </span>
                    </td>
                    <td class="text-uppercase">
                      <?php echo @$item['nombre_usu'] . " " . @$item['apellido_usu']; ?>
                    </td>
                    <td>
                      <?php echo @$item['fk_suscriptor_serv']; ?>
                    </td>
                    <td class="text-right">
                      <form action="suspension.php" method="post" target="_blank">
                        <button type="submit" class="btn btn-sm btn-success" name="contrato" value="<?php echo @$item['id_serv'] ?>"><i class="far fa-print"> Imprimir orden</i></button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <!--Finaliza tabla -->
  <div class="col-md-4">
    <div class="card  card-tasks">
      <div class="card-header ">
        <h5 class="card-category"><i class="fas fa-headset"></i> Contartar usuarios (Opcional)</h5>
        <h4 class="card-title font-weight-bold"><i class="fad fa-folder-open"></i> Ver solicitudes</h4>
        <p class="text-muted">Contacta a los usuarios que han solicitado adquirir el servicio</p>
      </div>
      <div class="card-body ">
        <div class="table-full-width table-responsive">
          <?php if (!$datosexpira) { ?>
            <p class="text-primary font-weight-bold text-center">¡No hay solicitudes pendientes!</p>
          <?php } ?>
          <table class="table">
            <tbody>
              <?php foreach ($datosexpira as $llamadit) { ?>
                <tr>
                  <td>
                    <div class="form-check">
                      <i style="font-size: large;" class="text-primary fa fa-bells"></i>
                    </div>
                  </td>
                  <td class="font-italic text-justify">
                    <strong>DETALLES <i class="fas fa-arrow-alt-right"></i></strong>
                  </td>
                  <td class="td-actions text-right">
                    <button type="button" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral" data-toggle="modal" data-target="#llamar_usu_soli<?php echo $llamadit['fk_suscriptor_serv'] ?>">
                      <i style="font-size: large;" class="text-success fas fa-phone-plus"></i>
                    </button>
                  </td>
                </tr>
                <div class="modal fade" id="llamar_usu_soli<?php echo $llamadit['fk_suscriptor_serv'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title font-weight-bold"><i class="far fa-info-circle"></i> INF. PARA LA LLAMADA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-lg-12 text-center">
                            <div class="form-group">
                              <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-user-check"></i> Usuario:</label>
                              <p class="font-weight-bold"><?php echo $llamadit['nombre_usu'] . " " . $llamadit['apellido_usu'] ?></p>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-calendar-edit"></i> Fecha de solicitud:</label>
                              <p class="font-weight-bold"><?php echo strftime('%d de %B de %Y', strtotime($llamadit['fecha_serv'])); ?></p>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="font-weight-bold col-form-label text-primary"><i class="far fa-envelope"></i> Correo electrónico:</label>
                              <p class="font-weight-bold"><?php echo $llamadit['correo_usu'] ?></p>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="font-weight-bold col-form-label text-primary"><i class="fad fa-gem"></i> Estado:</label>
                              <p class="font-weight-bold">EN TRÁMITE</p>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-mobile-alt"></i> Celular:</label>
                              <p class="font-weight-bold"><?php echo $llamadit['telefono_usu'] ?></p>
                            </div>
                          </div>
                        </div>
                        <div class="card-footer text-center">
                          <div class="stats">
                            ¡Es mejor estar conectados! <i style="font-size: large;" class="far fa-phone-office"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--Fin del modal -->
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
        <hr>
        <div class="stats">
          <i class="fal fa-alarm-exclamation"></i> Disponibles por máximo 5 días
        </div>
      </div>
    </div>
  </div>
  <!--Fin de la tabla-->
</div>
</div>
<script>
  function Numeros(string) { //Solo numeros
    var out = '';
    var filtro = '1234567890'; //Caracteres validos
    for (var i = 0; i < string.length; i++)
      if (filtro.indexOf(string.charAt(i)) != -1)
        out += string.charAt(i);
    //Retornar valor filtrado
    return out;
  }
  //Mostrar formulario Agregar Tarifa
  function mostrarAdd() {
    $("#form_addtar").css("display", "table-row");
    $("#btnAdd").css("display", "none");
  }
  //Ocultra formulario agregar fila
  function quitarAdd() {
    $("#form_addtar").css("display", "none");
    $("#btnAdd").css("display", "table-row");
  }
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


  function editTarifa(idtar) {
    var tar_jav = document.getElementById('id_de_tarifa_editar' + idtar).value;
    var cargo_jav = document.getElementById('cargo' + idtar).value;
    var metro_jav = document.getElementById('precio' + idtar).value;
    var todo_tar_jav = 'id_de_tarifa_editar=' + tar_jav + '&cargo=' + cargo_jav + '&precio=' + metro_jav;
    $.ajax({
      url: '../controllers/editar.php',
      type: 'post',
      data: todo_tar_jav,
      beforeSend: function() {
        Swal.fire({
          type: 'info',
          title: 'Editando...',
          showConfirmButton: false,
        });
      },
      success: function(respuTar) {
        if (respuTar == 23) {
          Swal.fire({
            type: 'error',
            title: '¡Error!',
            html: "La tarifa 1 (Especial) no puede tener un cargo fijo mayor o menor a 0",
            showConfirmButton: true,
          });
        } else {
          Swal.fire({
            type: 'success',
            title: '¡Perfecto!',
            html: respuTar,
            showConfirmButton: true,
          });
        }
      }
    });
    return false;
  }
  //Modificar contrato
  function editContrato() {
    var newContenido = document.getElementById('newdata').value;
    var todo_cont = 'newdata=' + newContenido;
    $.ajax({
      url: '../controllers/editar.php',
      type: 'post',
      data: todo_cont,
      beforeSend: function() {
        Swal.fire({
          type: 'info',
          title: 'Actualizando...',
          showConfirmButton: false,
        });
      },
      success: function(respContrato) {
        if (respContrato == 54) {
          Swal.fire({
            type: 'success',
            title: '¡Perfecto!',
            html: 'El contrato ha sido actualizado correctamente...',
            showConfirmButton: true,
          });
        }
      }
    });
    return false;
  }
  //Agregar tarifas
  function enviarAddform() {
    var tar_add = document.getElementById('addidtar').value;
    var cargo_add = document.getElementById('addcargo').value;
    var metro_add = document.getElementById('addprecio').value;
    var todo_add = 'addcargo=' + cargo_add + '&addprecio=' + metro_add;
    $.ajax({
      url: '../controllers/registro.php',
      type: 'post',
      data: todo_add,
      beforeSend: function() {
        Swal.fire({
          type: 'info',
          title: 'Guardando...',
          showConfirmButton: false,
        });
      },
      success: function(respAdd) {
        Swal.fire({
          type: 'success',
          title: '¡Perfecto!',
          html: respAdd,
          showConfirmButton: true,
        }).then(function(result) {
          if (result.value) {
            location.reload();
          }
        });
      }
    });
    $("#form_addtar").css("display", "none");
    $("#btnAdd").css("display", "table-row");
    document.getElementById('formAddReset').reset();
    return false;
  }

  function eliminarTarifa(idEliminar) {
    var tarifaF = idEliminar;
    swal.fire({
      title: "¿Seguro que quieres eliminar esta tarifa?",
      text: "La tarifa " + tarifaF + " se eliminará permanentemente. Esta acción no se podrá deshacer.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#FF0000",
      confirmButtonText: "SI, eliminar",
      cancelButtonText: "No, cancelar",
      cancelButtonColor: "#40869B",
      closeOnConfirm: false,
      closeOnCancel: false
    }).then(function(result) {
      if (result.value) {
        $.ajax({
          url: '../controllers/eliminar.php',
          type: 'post',
          data: 'tarifaEliminar=' + tarifaF,
          beforeSend: function() {
            Swal.fire({
              type: 'info',
              title: 'Eliminando...',
              showConfirmButton: false,
            });
          },
          success: function(respAdd) {
            if (respAdd == 1) {
              Swal.fire({
                type: 'success',
                title: '¡Tarifa eliminada!',
                html: 'La tarifa <strong>' + tarifaF + '</strong> se ha eliminado exitosamente.',
                showConfirmButton: true,
              }).then(function(result) {
                if (result.value) {
                  location.reload();
                }
              });
            } else {
              Swal.fire({
                type: 'error',
                title: 'ADVERTENCIA:',
                html: 'La tarifa que intentas eliminar (<strong>' + tarifaF + '</strong>) tiene servicios asignados, por ende, es necesario que realices la modificación pertienente a los servicios que se les atribuya esta tarifa.',
                showConfirmButton: true,
              })
            }
          }
        });
      }
    });
  }

  //Confirmar contrato
  $('#formRad').submit(function() {
    var RadSol = document.getElementById('RadSol').value;
    var docSol = document.getElementById('DocSol').value;
    var TarSol = document.getElementById('TarSol').value;
    var datosSol = 'RadSol=' + RadSol + '&docSol=' + docSol + '&TarSol=' + TarSol;
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
            title: '¡Contratación exitosa!',
            html: 'A partir de este momento se finaliza el proceso de contratación, y se activa el servicio con el <strong>ID ' + RadSol + '</strong>.<br><br><small>En unos segundos serás redireccionado al contrato...</small>',
          });
          setTimeout(function() {
            window.open('../controllers/reportes/contratos/contrato.php?servicio=' + RadSol, '_blank');
          }, 4000);
        } else {
          Swal.fire({
            type: 'info',
            title: 'INFORMACIÓN:',
            html: resp_Sol,
          });
        }
      }
    });
    return false;
  });
  $('#borrarSoli').click(function() {
    Swal.fire({
      type: 'success',
      title: '¡Todo bien!',
      html: 'resp_serV',
    });
    return false;
  });
  //Gráfica de tarifas
  $(document).ready(function() {
    //Gráfico tarifas
    const $grafica = document.querySelector("#grafica");
    const etiquetas = label_tar
    const mostrar = {
      label: "Cargo fijo ",
      data: datos_tar,
      backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
      borderColor: '#18CE0F', // Color del borde
      borderWidth: 1, // Ancho del borde
    };
    const mostrarDos = {
      label: "Precio m3 ",
      data: metro,
      backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
      borderColor: '#2CA8FF', // Color del borde
      borderWidth: 1, // Ancho del borde
    };
    new Chart($grafica, {
      type: 'bar', // Tipo de gráfica
      data: {
        labels: etiquetas,
        datasets: [
          mostrar, mostrarDos,
        ]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }],
        },
      }
    });
  });
</script>
<?php require_once 'footer.php'
?>