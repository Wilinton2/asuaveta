<?php
//Conexion a la base de datos
include_once '../controllers/conexion.php';
@$contrato = $_POST['contrato'];
//Consulta para datos del servicio y tarifa
$sql_ser = "SELECT id_serv, fk_tarifa_serv, fk_suscriptor_serv, numero_fac, lectura_anterior_fac, lectura_actual_fac, fecha_anterior_fac, precio_mt_fac, cargo_fijo_fac, cobro_extra_fac, descuento_fac, id_usu, nombre_usu, apellido_usu, direccion_usu, telefono_usu, correo_usu FROM tbl_servicio as SER
INNER JOIN tbl_factura as FAC ON FAC.fk_servicio_fac=SER.id_serv
INNER JOIN tbl_usuario as US ON US.id_usu=SER.fk_suscriptor_serv WHERE id_serv=? AND fk_estado_fac=7";
$consulta_ser = $pdo->prepare($sql_ser);
$consulta_ser->execute(array($contrato));
$resultado_ser = $consulta_ser->rowCount();
$servicio = $consulta_ser->fetchAll();
$total = 0;
foreach ($servicio as $tot) {
    $consumo = $tot['lectura_actual_fac'] - $tot['lectura_anterior_fac'];
    $subtotal = $tot['precio_mt_fac'] * $consumo + $tot['cargo_fijo_fac'] + $tot['cobro_extra_fac'];
    $total_fac = $subtotal - $tot['descuento_fac'];
    $total = $total + $total_fac;
}
setlocale(LC_ALL, 'es_CO', 'es.UTF-8');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" lang="es">
    <title>ORDEN DE SUSPENSIÓN_<?php echo @$servicio[0]['id_serv'] ?></title>
    <link rel="stylesheet" href="facturas/factura.css" media="all" />
    <link rel="shortcut icon" href="facturas/favicon.png" type="image/x-icon">
    <!-- Latest compiled and minified CSS -->
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img width="300px" src="../../assets/img/logo.png">
        </div>
        <div id="company">
            <h3 class="name"><strong>NIT.900362372-2</strong></h3>
            <div>Vereda La Veta - Cocorná Antioquia, Colombia</div>
            <div><a href="mailto:atencionalcliente.asuaveta@gmail.com">atencionalcliente.asuaveta@gmail.com</a></div>
            <div><a href="www.asuaveta.site">www.asuaveta.site</a></div>
        </div>
        </div>
    </header>
    <main>
        <h1 class="text-center">ORDEN DE SUSPENSIÓN</h1>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">SUSCRIPTOR:</div>
                <h2 class="name"><?php echo @$servicio[0]['nombre_usu'] . " " . @$servicio[0]['apellido_usu'] ?></h2>
                <div class="address">CC. <?php echo @$servicio[0]['id_usu'] ?><br></div>
                <div style="max-width:620px; word-wrap: break-word;" class="date">Contacto: <?php echo @$servicio[0]['telefono_usu'] . " / " . @$servicio[0]['correo_usu'] ?><br>Dirección del inmueble: <?php echo @$servicio[0]['direccion_usu'] ?></div>
            </div>
            <div id="invoice">
                <h1>CONTRATO: <?php echo @$contrato ?></h1>
                <div class="date">Tarifa actual: <strong><?php echo @$servicio[0]['fk_tarifa_serv'] ?></strong></div>
                <div class="date">Cuentas vencidas: <strong><?php echo @$resultado_ser ?></strong></div>
                <div class="date">Total a pagar: <strong>$<?php echo number_format($total) ?></strong></div>
            </div>
        </div>
        <div id="thanks">Estimado usuario:</div>
        <div id="notices">En la fecha funcionarios autorizados por la empresa de servicios públicos ASUAVETA (Asociación de Usuarios del Acueducto Veredal LA VETA) y según lo dispuesto por la ley 142 de 1994 de los servicios públicos domiciliarios y al contrato de condiciones uniformes, se ha ordenado la suspensión del servicio de acueducto.</div><br>
        <div>
            <p>Para la reconexión de sus servicios cancele su factura en nuestro punto de pago autorizado. LA RECONEXIÓN SE CUMPLIRÁ EN LOS DOS DÍAS HÁBILES SIGUIENTES DE EFECTUADO EL PAGO.<br><br>Cualquier inconveniente con la reconexión de sus servicios sirvase de informarlo en nuestros canales de información y atención al cliente desde nuestro sitio web <a target="_blank" href="https://www.asuaveta.site">www.asuaveta.site</a> en la sección de contacto sin ningún costo.</p>
        </div>
        <h2 class="text-center">CUENTAS PENDIENTES:</h2>
        <div id="notices" style="text-transform:uppercase">
            <?php foreach ($servicio as $key) { 
    $consumo1 = $key['lectura_actual_fac'] - $key['lectura_anterior_fac'];
    $subtotal1 = $key['precio_mt_fac'] * $consumo1 + $key['cargo_fijo_fac'] + $key['cobro_extra_fac'];
    $total_fac1 = $subtotal1 - $key['descuento_fac'];
                ?>
                <li>
                    <?php echo strftime("%B de %Y", strtotime(@$key['fecha_anterior_fac'])) . " con un valor de: $" . number_format($total_fac1); ?>
                </li>
            <?php } ?>
        </div>
        <p>Para un total de <strong>$<?php echo number_format($total) ?></strong></p>
        <h2 class="text-center">CÓDIGOS QR DE LAS FACTURAS:</h2>
        <div style="width: 565px;">
            <?php foreach ($servicio as $periodos) { ?>
                <h5 style="margin-left:62px; display: inline;text-transform:uppercase">|<?php echo strftime("%B de %Y", strtotime(@$periodos['fecha_anterior_fac'])) ?>|</h5>
            <?php } ?>
        </div>
        <?php foreach ($servicio as $imgqr) { ?>
            <img style="display: inline;" src="facturas/codigos/<?php echo @$imgqr['numero_fac'] ?>.png" width="180px" height="150px" onerror="this.src='facturas/pagada.gif';" alt="Código QR pago de factura ASUAVETA">
        <?php } ?>
    </main>
    <div>
        Fecha de impresión de la orden: <?php echo date('d/m/Y h:ia') ?><br>
        Firma del funcionario que atendió la orden de suspensión: ____________________________________
    </div>
    <footer>
        Visita nuestro sitio web <a target="_blank" href="https://www.asuaveta.site">www.asuaveta.site</a>
    </footer>
</body>

</html>
<script>
    //print();
</script>