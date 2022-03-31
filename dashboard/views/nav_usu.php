<?php //Validamos si la sesión existe y los privilegios del usuario...
include_once '../controllers/conexion.php';
include_once '../controllers/automatico.php';
session_start();
@$id = $_SESSION['id_usu'];
//Selección de los datos de la sesión
$sql_session = "SELECT id_usu, nombre_usu, apellido_usu, direccion_usu, correo_usu, telefono_usu, foto_perfil_usu, fk_rol_usu FROM tbl_usuario as US
INNER JOIN tbl_rol as RO ON RO.id_rol=US.fk_rol_usu
WHERE id_usu =?";
$consulta_session = $pdo->prepare($sql_session);
$consulta_session->execute(array($id));
$user = $consulta_session->fetch(PDO::FETCH_OBJ);
if (!isset($id)|| $id == null) {
    echo "<script>window.location.href ='../controllers/session_destroy.php'</script>";
} else {
    if ($user->fk_rol_usu != 1) {
        echo "<script>alert('¡No tienes permisos para acceder a esta parte del sistema!')</script>";
        echo "<script>document.location.href='javascript:history.back()';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        ASUAVETA
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--Sweet Alert -->
    <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- CSS Files -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />
    <script type="text/javascript" src="../assets/js/jquery.min.js"></script>

    <!-- Tablas de datos -->
    <script src="../assets/js/datatable/jquery-3.5.1.js"></script>
    <script src="../assets/js/datatable/jquery.dataTables.min.js"></script>
    <script src="../assets/js/datatable/dataTables.bootstrap5.min.js"></script>
</head>

<body id="cuerpo">
    <div class="wrapper">

        <div class="sidebar" data-color="blue">
            <div class="logo">
                <a href="index.php" class="simple-text logo-normal text-center">
                    ASUAVETA
                </a>
            </div>
            <div class="sidebar-wrapper" id="sidebar-wrapper">
                <ul class="nav">
                    <li class="active ">
                        <a href="index.php">
                            <i class="fa fa-home"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                    <li>
                        <a href="../../soporte.php" target="_blank">
                            <i class="fal fa-user-headset"></i>
                            <p>PQR</p>
                        </a>
                    </li>
                    <li>
                        <a href="facturas.php">
                            <i class="fal fa-file-invoice"></i>
                            <p>FACTURACIÓN</p>
                        </a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#comprobantePago">
                            <i class="fal fa-sack-dollar"></i>
                            <p>COMPROBANTE DE PAGO</p>
                        </a>
                    </li>
                    <li>
                        <a href="servicios.php">
                            <i class="far fa-briefcase"></i>
                            <p>Mis servicios</p>
                        </a>
                    </li>
                    <li class="active-pro">
                        <a data-toggle="modal" data-target="#cerrarSesion">
                            <i class="fad fa-sign-out-alt"></i>
                            <p>Cerrar Sesión</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel" id="main-panel">
            <!-- Navbar -->
            <nav style="background-color: #224E82;" class="navbar navbar-expand-lg navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" href="perfil.php"><?php echo @$user->nombre_usu . " " . @$user->apellido_usu ?></a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <form>
                            <div class="input-group no-border">
                                <input type="text" value="" class="form-control" placeholder="Buscar...">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="far fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">
                                    <i style="font-size: large;" class="far fa-home"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">INICIO</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i style="font-size: large;" class="fal fa-globe-americas"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">Opciones</span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="../../soporte.php" target="_blank"><i style="font-size: large;" class="fal fa-user-headset"></i> PQR</a>
                                    <a class="dropdown-item" href="facturas.php"><i style="font-size: large;" class="fal fa-file-invoice"></i> Facturación</a>
                                    <a class="dropdown-item" href="servicios.php"><i style="font-size: large;" class="fal fa-briefcase"></i> Mis servicios</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#comprobantePago"><i style="font-size: large;" class="fal fa-sack-dollar"></i> Comprobante de pago</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="perfil.php">
                                    <i style="font-size: large;" class="far fa-user"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">Mi cuenta</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="modal" data-target="#cerrarSesion">
                                    <i style="font-size: large;" class="fal fa-sign-out-alt"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">Cerrar sesión</span>
                                    </p>
                                </a>
                            </li>
                            <!--Fin del modal cerrar sesión -->
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
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
            <!-- Modal para cerrar sesión-->
            <div class="modal fade" id="cerrarSesion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title font-weight-bold" id="exampleModalLabel">¿Seguro que quieres cerrar sesión?</h6>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Al continuar, finalizará tu sesión actualmente activa. Ten en cuenta de que si tienes cambios sin guardar, se perderán permanentemente...
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="button" data-dismiss="modal"><i class="fa fa-times"> </i> Cancelar</button>
                            <a class="btn btn-success" href="../controllers/session_destroy.php"><i class="fa fa-power-off"> </i> Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>