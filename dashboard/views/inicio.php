<?php
require_once 'nav_usu.php';
setlocale(LC_ALL, "es_CO", "es_ES", "esp");
//NOVEDADES
//Selección de los datos de facturas pendientes
$sql = "SELECT * FROM tbl_servicio as SER
INNER JOIN tbl_factura as FAC ON FAC.fk_servicio_fac=SER.id_serv
INNER JOIN tbl_usuario as US ON US.id_usu=SER.fk_suscriptor_serv
WHERE id_usu=? AND fk_estado_fac =7";
$consulta_fac = $pdo->prepare($sql);
$consulta_fac->execute(array($id));
$total_pend = $consulta_fac->rowCount();
$facturas = $consulta_fac->fetchAll();
//Selección de datos de administradores
$sql_select_admin = "SELECT id_usu, nombre_usu, apellido_usu, correo_usu FROM tbl_usuario 
WHERE fk_rol_usu=2 AND fk_estado_usu=1";
$consulta_select_admin = $pdo->prepare($sql_select_admin);
$consulta_select_admin->execute();
$admin_select = $consulta_select_admin->fetchAll();
//Gráfica de metros consumidos mensualmente (general)
$sql = "SELECT SUM(lectura_anterior_fac) AS lecant, SUM(lectura_actual_fac) AS lecact, monthname(fecha_anterior_fac) as 'Mes' FROM tbl_factura as FA WHERE year(fecha_anterior_fac)=YEAR(CURDATE()) GROUP BY month(fecha_anterior_fac)";
$consulta = $pdo->prepare($sql);
$consulta->execute();
$grafico = $consulta->fetchAll();
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
//Gráfico de consumo personal
$id_per = $_SESSION['id_usu'];
$otro ="SELECT SUM(lectura_anterior_fac) AS lecant, SUM(lectura_actual_fac) AS lecact, monthname(fecha_anterior_fac) as 'Mes' FROM tbl_factura as FA WHERE year(fecha_anterior_fac)=YEAR(CURDATE()) GROUP BY month(fecha_anterior_fac)";
$sql_per = "SELECT SUM(lectura_anterior_fac) AS lecanterior, SUM(lectura_actual_fac) AS lecactual, monthname(fecha_actual_fac) as 'Mes_per' FROM tbl_factura as FA INNER JOIN tbl_servicio as SER ON SER.id_serv=FA.fk_servicio_fac WHERE SER.fk_suscriptor_serv=? GROUP BY month(fecha_actual_fac)";
$consulta_per = $pdo->prepare($sql_per);
$consulta_per->execute(array($id_per));
$grafico_per = $consulta_per->fetchAll();
$label_per = "";
$datosdos = "";
foreach ($grafico_per as $datos_per) {
    $total_cons = $datos_per['lecactual'] - $datos_per['lecanterior']; 
    $label_per .=  "'" . strftime("%B", strtotime($datos_per['Mes_per'])) . "'" . ', ';
    $datosdos .= $total_cons . ', ';
}
$label_per = rtrim($label_per, ", ");
$datosdos = rtrim($datosdos, ", ");
//Gráfico de tarifas
$sql_tar = "SELECT id_tar, cargo_fijo_tar, precio_mt_tar FROM tbl_tarifa";
$consulta_tar = $pdo->prepare($sql_tar);
$consulta_tar->execute();
$tarifas = $consulta_tar->fetchAll();
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
?>
<link rel="stylesheet" href="../assets/demo/demo.css">
<script>
    //Gráfico de consumo general
    let label = [<?php echo strtoupper($label); ?>];
    let datos = [<?php echo $datos; ?>];
    //Gráfico de consumo personal
    let label_per = [<?php echo strtoupper($label_per); ?>];
    let datos_per = [<?php echo $datosdos; ?>];
    //Gráfico de tarifas
    let label_tar = [<?php echo $data_foot; ?>];
    let datos_tar = [<?php echo $top_tar; ?>];
    let metro = [<?php echo $metro_precio; ?>];
</script>
<script src="../assets/demo/demo.js"></script>
<script src="../assets/demo/jswil.js"></script>
<link rel="stylesheet" href="../assets/demo/demo.css">
<div class="panel-header" style="text-align:center; height:9rem; margin-top: -15px;">
    <h4 style="display: inline;" class="text-white font-weight-bold">REPORTE GENERAL DE CONSUMOS <?php echo date('Y') ?></h4>
</div>
<div class="panel-header panel-header-lg" style="margin-top: -5px;">
    <canvas id="bigDashboardChart"></canvas>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Año <?php echo date('Y') ?></h5>
                    <h4 class="card-title font-weight-bold">Tus consumos</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                            <i class="far fa-chart-line"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="lineChartExample"></canvas>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="far fa-calendar-alt"></i><?php echo strftime("%d de %B del %Y"); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Según nivel socieconómico</h5>
                    <h4 class="card-title font-weight-bold">Tarifas generales</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                            <i class="far fa-search-dollar"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="grafica" height="125px"></canvas>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="far fa-chart-bar"></i> ¡Equidad y compromiso!
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card  card-tasks">
                <div class="card-header ">
                    <h5 class="card-category">Novedades del sistema y servicios generales</h5>
                    <h4 class="card-title font-weight-bold">Novedades</h4>
                </div>
                <div class="card-body ">
                    <div class="table-full-width table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <i style="font-size: large;" class="text-primary fa fa-bells"></i>
                                        </div>
                                    </td>
                                    <td class="font-italic text-justify"><strong>¿Ya actualizaste tus datos en nuestro sistema?</strong> ¡Mantenernos conectados es importante! te invitamos a realizarlo desde tu perfil.</td>
                                    <td class="td-actions text-right">
                                        <button type="button" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral">
                                            <i style="font-size: large;" class="text-success fas fa-user-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php if ($total_pend > 0) { ?>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <i style="font-size: large;" class="text-primary fa fa-bells"></i>
                                            </div>
                                        </td>
                                        <td class="text-justify font-italic">¡Hola <?php echo $user->nombre_usu ?>! tienes <strong><?php echo $total_pend ?> FACTURA(S)</strong> por pagar. Puedes ampliar esta información en el panel de consultas de factura.</td>
                                        <td class="td-actions text-right">
                                            <a href="facturas.php" type="button" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral">
                                                <i style="font-size: large;" class="text-warning fas fa-calendar-exclamation"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <i style="font-size: large;" class="text-primary fa fa-bells"></i>
                                            </div>
                                        </td>
                                        <td class="text-justify font-italic"><strong>¡Felicidades <?php echo $user->nombre_usu ?>!</strong>, no tienes facturas por pagar. Gracias por mantener tus sevicios al día, es un gusto tenerte con nosotros.</td>
                                        <td class="td-actions text-right">
                                            <button type="button" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral">
                                                <i style="font-size: large;" class="text-info fal fa-smile-beam"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php  } ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <i style="font-size: large;" class="text-primary fa fa-bells"></i>
                                        </div>
                                    </td>
                                    <td class="text-justify font-italic"><strong>Información de interés:</strong> Si en algún momento deseas retirar tus servicios debes diligenciar nuestro formulario de retiro, después de firmado se realiza la solicitud por este medio.</td>
                                    <td class="td-actions text-right">
                                        <button type="button" class="btn btn-success btn-round btn-icon btn-icon-mini btn-neutral">
                                            <i style="font-size: large;" class="text-danger fal fa-file-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="now-ui-icons loader_refresh spin"></i> Mostrando notificaciones generales...

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-category">¿Necesitas ayuda?</h5>
                    <h4 class="card-title font-weight-bold"><i class="fas fa-headset"></i> Contacto directo</h4>
                </div>
                <div class="card-body">
                    <form onsubmit="return solicitud_admin()" method="post" id="formDirectContact">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="font-weight-bold col-form-label text-success"><i style="font-size: large;" class="fas fa-user-headset"></i> Agente:</label>
                                    <select class="form-control" id="id_admin" required>
                                        <option selected value="">Seleccione un agente...</option>
                                        <?php foreach ($admin_select as $option) { ?>
                                            <option value="<?php echo $option['id_usu'] ?>"><?php echo $option['nombre_usu'] . " " . $option['apellido_usu'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="font-weight-bold col-form-label text-primary"><i style="font-size: large;" class="fas fa-comment-lines"></i> Mensaje:</label>
                                    <textarea class="form-control" rows="4" placeholder="Escribe aquí tu mensaje..." id="mensaje_usuario" required></textarea>
                                    <input type="hidden" value="<?php echo $user->id_usu ?>" id="id_usuario">
                                </div>
                                <div class="text-center">
                                    <input class="form-check-label" type="checkbox" required>
                                    <span class="font-weight-bold"> He leído y aceptado la <a class="text-dark" target="_blank" href="visor_documentos.php?privacidad"><u>política de tratamiento de datos</u></a></span>

                                </div>

                                <div class="col-lg-12 text-center">
                                    <button id="enviarSoli" type="submit" class="btn btn-primary text-center">Enviar <i class="fas fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>




</div>
<script>
    function solicitud_admin() {
        $('#enviarSoli').prop('disabled', true);
        var id_usuario = document.getElementById('id_usuario').value;
        var id_admin = document.getElementById('id_admin').value;
        var mensaje_usuario = document.getElementById('mensaje_usuario').value;
        var todo_sms = 'id_usuario=' + id_usuario + '&id_admin=' + id_admin + '&mensaje_usuario=' + mensaje_usuario;
        $.ajax({
            url: '../controllers/mailer/ayuda_admin.php',
            type: 'post',
            data: todo_sms,
            beforeSend: function() {
                Swal.fire({
                    type: 'info',
                    html: 'Enviando mensaje...',
                    showConfirmButton: false,
                });
            },
            success: function(resp) {
                if (resp == 1) {
                    Swal.fire({
                        //error
                        type: 'success',
                        title: '¡Perfecto!',
                        text: 'El mensaje ha sido enviado exisosamente, pronto serás contactado por el agente...',
                    });
                } else {
                    Swal.fire({
                        //error
                        type: 'error',
                        title: '¡Error en el envío!',
                        text: 'Ha ocurrido un problema con el envío del mensaje, estamos trabajando en ello. Por favor intenta nuevamente más tarde...',
                        showConfirmButton: false,
                        timer: 2000 //el tiempo que dura el mensaje en ms
                    });
                }
                document.getElementById('formDirectContact').reset();
                $('#enviarSoli').prop('disabled', false);
            }
        });
        return false;
    }
//Gráfica de consumo personal
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