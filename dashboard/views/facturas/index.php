<?php
//Conexion a la base de datos
include_once '../../controllers/conexion.php';
//Consulta para datos del servicio y tarifa
@$factura = $_POST['factura'];
$sql_ser = "SELECT * FROM tbl_servicio as SER
INNER JOIN tbl_factura as FAC ON FAC.fk_servicio_fac=SER.id_serv
INNER JOIN tbl_tarifa as TAR ON TAR.id_tar=SER.fk_tarifa_serv
INNER JOIN tbl_usuario as US ON US.id_usu=SER.fk_suscriptor_serv WHERE numero_fac =?";
$consulta_ser = $pdo->prepare($sql_ser);
$consulta_ser->execute(array($factura));
$resultado_ser = $consulta_ser->rowCount();
$servicio = $consulta_ser->fetch(PDO::FETCH_OBJ);
setlocale(LC_ALL, 'es_CO', 'es.UTF-8');
$periodo = strftime("%B de %Y", strtotime(@$servicio->fecha_anterior_fac));
$periodotitle = strftime("%B_de_%Y", strtotime(@$servicio->fecha_actual_fac));
//Generar la fecha límite de pago
$date = date(@$servicio->fecha_actual_fac);
$mod_date = strtotime($date . "+ 15 days");
$fecha_limite2 = date("d-M-Y", $mod_date);
$fecha_limite = strftime("%A %d de %B de %Y", strtotime(@$fecha_limite2));
$fecha_generacion = strftime("%A %d de %B de %Y", strtotime(@$servicio->fecha_actual_fac));
if (!$resultado_ser) {
    echo "<script>window.close();</script>";
}
//Valor de la factura
$consumo = $servicio->lectura_actual_fac - $servicio->lectura_anterior_fac;
$subtotal = $servicio->precio_mt_fac * $consumo + $servicio->cargo_fijo_fac;
$total_factura = $subtotal - $servicio->descuento_fac + $servicio->cobro_extra_fac;
//Diferencia entre fechas (Días de consumo)
$desde_php = new DateTime($servicio->fecha_anterior_fac);
$hasta_php = new DateTime($servicio->fecha_actual_fac);
$dias_con = $desde_php->diff($hasta_php);
$dias_consumo = $dias_con->days;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" lang="es">
    <title>FACTURA DE SERVICIOS ASUAVETA</title>
    <link rel="stylesheet" href="factura.css" media="all" />
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="../../../assets/img/logo.png">
        </div>
        <div id="company">
            <h3 class="name"><strong>NIT.900362372-2</strong></h3>
            <div>Vda. La Veta, Cocorná, Ant.</div>
            <div>(604) 519-0421</div>
            <div><a href="mailto:atencionalcliente.asuaveta@gmail.com">atencionalcliente.asuaveta@gmail.com</a></div>
        </div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">FACTURA PARA:</div>
                <h2 class="name"><?php echo @$servicio->nombre_usu . " " . @$servicio->apellido_usu ?></h2>
                <div class="address">CC. <?php echo @$servicio->id_usu ?><br><?php echo @$servicio->direccion_usu ?><br>Tarifa del servicio: <?php echo @$servicio->fk_tarifa_serv ?></div>
            </div>
            <div id="invoice">
                <h1>FACTURA: <?php echo @$servicio->numero_fac ?></h1>
                <div class="date">Contrato: <?php echo @$servicio->id_serv ?><br>Fecha de la factura: <?php echo $fecha_generacion; ?></div>
                <div class="date">Fecha límite de pago: <?php echo $fecha_limite ?></div>
            </div>
        </div>
        <table border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="no">PERIODO</th>
                    <th class="desc">DESDE</th>
                    <th class="unit">HASTA</th>
                    <th class="qty">DÍAS CONS.</th>
                    <th class="unit">PRECIO M3</th>
                    <th class="qty">M3(S)</th>
                    <th class="total">CARGO FIJO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="no"><small><?php echo @$periodo ?></small></td>
                    <td class="desc">
                        <h3><?php echo @$servicio->fecha_anterior_fac ?></h3>
                    </td>
                    <td class="unit"><?php echo @$servicio->fecha_actual_fac ?></td>
                    <td class="qty"><?php echo @$dias_consumo ?></td>
                    <td class="unit">$<?php echo number_format(@$servicio->precio_mt_fac) ?></td>
                    <td class="qty"><?php echo @$consumo ?></td>
                    <td class="total">$<?php echo number_format(@$servicio->cargo_fijo_fac) ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="2"><strong>SUBTOTAL:</strong></td>
                    <td>$<?php echo number_format(@$subtotal) ?></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="2"><strong>OTROS CONCEPTOS:</strong></td>
                    <td>$<?php echo number_format(@$servicio->cobro_extra_fac) ?></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="2"><strong>DESCUENTOS:</strong></td>
                    <td>$<?php echo number_format(@$servicio->descuento_fac) ?></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="2">TOTAL:</td>
                    <td>$<?php echo number_format(@$total_factura) ?></td>
                </tr>
            </tfoot>
        </table>
        <div style="margin-top: -160px; width: 180px">
        <img src="codigos/<?php echo $servicio->numero_fac ?>.png" width="180px" height="150px" onerror="this.src='pagada.gif';">
        </div>
        <div id="thanks">¡Muchas gracias!</div>
        <div id="notices">
            <div>MENSAJE DE INTERÉS:</div>
            <div class="notice"><?php echo @$servicio->observacion_fac ?></div>
        </div>
    </main>
    <footer>
        Visita nuestro sitio web <a target="_blank" href="https://www.asuaveta.site">www.asuaveta.site</a>
    </footer>
</body>

</html>
<script>
    print();
</script>