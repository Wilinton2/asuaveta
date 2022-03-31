<?php
//Conexion a la base de datos
include_once '../../controllers/conexion.php';
session_start();
@$id = $_SESSION['id_usu'];
//Selección de los datos de la sesión
$sql = "SELECT * FROM tbl_usuario as US
INNER JOIN tbl_rol as RO ON RO.id_rol=US.fk_rol_usu
WHERE id_usu =?";
$consulta = $pdo->prepare($sql);
$consulta->execute(array($id));
$resultado = $consulta->rowCount();
$admin = $consulta->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Sweet Alert -->
    <link rel="stylesheet" href="../../assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="../../assets/css/now-ui-dashboard.css">
    <!--    Plugin sweet Alert 2  -->
    <script src="../../assets/js/sweetalert2.all.min.js"></script>
    <title>PROCESO DE PAGO</title>
</head>

<body>
    <div class="container">
        <h5>Recepción de pagos...</h5>
    </div>
    <?php
    if (!isset($admin->id_usu)) { ?>
        <script>
            Swal.fire({
                type: 'error',
                title: '!No has iniciado sesión!',
                html: 'Estimado usuario, no hemos reconocido tu identidad, por favor inicia sesión e intenta nuevamente.<br>En un momento serás redireccionado...',
                showConfirmButton: false,
            });
            setTimeout(function() {
                window.location.href = "../../../index.php";
            }, 6000);
        </script>
    <?php } elseif ($admin->fk_rol_usu != 2 && $admin->fk_rol_usu != 3) { ?>
        <script>
            <?php
            echo "var usu ='$admin->nombre_usu';";
            ?>
            Swal.fire({
                type: 'error',
                title: '!No tienes permisos para acceder!',
                html: 'Hola ' + usu + ', te informamos que este sitio del sistema es restringido, si deseas cancelar tu factura debes dirigirte a uno de nuestros puntos de pago, muchas gracias.<br><br>En un momento serás redireccionado...',
                showConfirmButton: false,
            });
            setTimeout(function() {
                window.location.href = "../../../index.php";
            }, 6000);
        </script>
    <?php  } elseif ($admin->fk_estado_usu == 2) { ?>
        <script>
            <?php
            echo "var usu ='$admin->nombre_usu';";
            ?>
            Swal.fire({
                type: 'warning',
                title: '!Tu estado es inactivo!',
                html: 'Hola ' + usu + ', es un gusto tenerte con nosotros, te informamos que debido a que tu estado en nuestro sistema es INACTIVO, no podrás realizar procesos de pago. Si deseas cancelar una factura, por favor dirígete a uno de nuestros puntos de pago.<br><br>En un momento serás redireccionado...',
                showConfirmButton: false,
            });
            setTimeout(function() {
                window.location.href = "../../../index.php";
            }, 6000);
        </script>
        <?php } elseif (isset($admin->id_usu) && $admin->fk_estado_usu == 1 && ($admin->fk_rol_usu == 2 || $admin->fk_rol_usu == 3)) {
        $factura = utf8_encode(base64_decode($_GET['asua22']));
        $sqlfac = "SELECT fk_servicio_fac FROM tbl_factura WHERE numero_fac = ?";
        $ln = $pdo->prepare($sqlfac);
        $ln->execute(array($factura));
        $datos_fact = $ln->fetch(PDO::FETCH_OBJ);
        $servicio = $datos_fact->fk_servicio_fac;
        $sql = "SELECT * FROM tbl_servicio as SER
INNER JOIN tbl_factura as FAC ON FAC.fk_servicio_fac=SER.id_serv
INNER JOIN tbl_usuario as US ON US.id_usu=SER.fk_suscriptor_serv
WHERE numero_fac=? AND id_serv=?";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($factura, $servicio));
        $resultado = $consulta->rowCount();
        $pago = $consulta->fetch(PDO::FETCH_OBJ);
        $fecha_pago = date('d/m/Y');
        //Periodo y valores de la factura
        $periodo = strtoupper(strftime("%B de %Y", strtotime(@$pago->fecha_actual_fac)));
        $consumo = $pago->lectura_actual_fac - $pago->lectura_anterior_fac;
        $subtotal = $pago->precio_mt_fac * $consumo + $pago->cargo_fijo_fac;
        $total_factura = number_format($subtotal - $pago->descuento_fac + $pago->cobro_extra_fac);
        if ($pago->fk_estado_fac == 8) {
        ?>
            <script>
                <?php
                echo "var informacion ='El valor <strong>$$total_factura</strong> de la factura <strong>#$pago->numero_fac</strong> correspondiente al periodo de <strong>$periodo</strong> del contrato <strong>$pago->fk_servicio_fac</strong> a nombre de <strong>$pago->nombre_usu $pago->apellido_usu</strong>...<br><br><strong>¡YA FUE CANCELADA!</strong>';";
                ?>
                Swal.fire({
                    type: 'warning',
                    title: '!Error en el pago!',
                    html: informacion,
                    showConfirmButton: true,
                }).then(function(result) {
                    if (result.value) {
                        window.close();
                    }
                });
            </script>
        <?php  } elseif ($pago->fk_estado_fac == 7) {
            $pagado = 8;
            $editar_estado = "UPDATE tbl_factura SET fk_estado_fac=? WHERE numero_fac=? AND fk_servicio_fac=?";
            $base_editar = $pdo->prepare($editar_estado);
            $base_editar->execute(array($pagado, $pago->numero_fac, $pago->fk_servicio_fac));
            //Eliminar la imagen del codigo QR de la factura pagada
            @unlink('codigos/' . @$pago->numero_fac . '.png');
        ?>
            <script>
                <?php
                echo "var usu ='$admin->nombre_usu';";
                echo "var info ='Fecha: $fecha_pago<br><br><strong>DATOS DE LA FACTURA:</strong><br>Número de factura: $pago->numero_fac<br>Periodo facturado: $periodo<br>Contrato: $pago->fk_servicio_fac<br>Valor: $$total_factura<br><br><strong>DATOS DEL CLIENTE:</strong><br> $pago->nombre_usu $pago->apellido_usu<br>Documento: $pago->id_usu<br>Celular: $pago->telefono_usu<br><br><strong>Responsable del pago:</strong><br>$admin->nombre_usu $admin->apellido_usu<br>CC. $admin->id_usu';";
                ?>
                Swal.fire({
                    type: 'success',
                    title: '!Pago exitoso!',
                    html: info,
                    showConfirmButton: true,
                }).then(function(result) {
                    if (result.value) {
                        window.history.back();
                    }
                });
            </script>
    <?php
        }
    }
    ?>
</body>

</html>