<?php
include_once '../controllers/conexion.php';
session_start();
@$id = $_SESSION['id_usu'];
//Selección de los datos de la sesión
$sql_session = "SELECT id_usu, nombre_usu, apellido_usu, direccion_usu, correo_usu, telefono_usu, foto_perfil_usu, fk_rol_usu, tipo_rol FROM tbl_usuario as US
INNER JOIN tbl_rol as RO ON RO.id_rol=US.fk_rol_usu
WHERE id_usu =?";
$consulta_session = $pdo->prepare($sql_session);
$consulta_session->execute(array($id));
$user = $consulta_session->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        PERFIL | <?php echo @$user->nombre_usu ?>
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
                    <li class="active">
                        <a href="index.php">
                            <i class="fa fa-home"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#editar_perfil">
                            <i class="fas fa-lock"></i>
                            <p>Cambiar contraseña</p>
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
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">
                                    <i style="font-size: large;" class="far fa-home"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block"> INICIO</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#editar_perfil">
                                    <i style="font-size: large;" class="far fa-lock"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block"> CAMBIAR CLAVE</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="perfil.php">
                                    <i style="font-size: large;" class="far fa-user"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">MI CUENTA</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="modal" data-target="#cerrarSesion">
                                    <i style="font-size: large;" class="fal fa-sign-out-alt"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">CERRAR SESIÓN</span>
                                    </p>
                                </a>
                            </li>
                            <!--Fin del modal cerrar sesión -->
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
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

















            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-muted mb-4">Estimado usuario, en este espacio podrás visualizar tus datos de perfil así como editar tu información de contacto y contraseña de acceso a tu cuenta...</p>
                                <div class="card-header">
                                    <h5 class="title">Visualiza tus datos de perfil</h5>
                                </div>
                                <form action="../controllers/editar.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-4 pr-1">
                                            <div class="form-group">
                                                <label>Cédula</label>
                                                <input type="text" class="form-control" disabled value="<?php echo $user->id_usu ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-5 pl-1">
                                            <div class="form-group">
                                                <label>Correo electrónico</label>
                                                <input type="email" class="form-control" value="<?php echo $user->correo_usu ?>" name="EditContCorreo">
                                            </div>
                                        </div>
                                        <div class="col-md-3 px-1">
                                            <div class="form-group">
                                                <label>Teléfono</label>
                                                <input type="text" class="form-control" value="<?php echo $user->telefono_usu ?>" name="EditContTel">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label>Nombre (s)</label>
                                                <input type="text" disabled class="form-control" value="<?php echo $user->nombre_usu ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-1">
                                            <div class="form-group">
                                                <label>Apellido</label>
                                                <input type="text" disabled class="form-control" value="<?php echo $user->apellido_usu ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Dirección</label>
                                                <textarea class="form-control" rows="2" disabled><?php echo $user->direccion_usu ?></textarea>
                                                <input type="hidden" name="EditContUsu" value="<?php echo $user->id_usu ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-edit">Actualizar datos</i></button>
                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editar_perfil"><i class="fa fa-lock-alt"></i> Cambiar clave</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="image">
                                <img src="../assets/img/portada_defecto.png" alt="Foto de portada ASUAVETA">
                            </div>
                            <div class="card-body">
                                <div class="author">
                                    <img class="avatar border-gray" src="../perfiles/<?php echo @$user->foto_perfil_usu ?>" alt="Foto de perfil ASUAVETA">
                                    <h5 class="title text-secondary"><?php echo @$user->nombre_usu . " " . @$user->apellido_usu ?></h5>
                                    <p class="description">
                                        <?php echo @$user->tipo_estado ?>
                                    </p>
                                </div>
                                <p class="text-center description">
                                    <span class="text-success font-weight-bold"><?php echo @$user->tipo_rol ?></span>
                                </p>
                            </div>
                            <hr>
                            <div class="button-container">
                                <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg btn-info">
                                    <i class="fa fa-star"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Modal para editar información de perfil-->
            <div class="modal fade" id="editar_perfil" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa fa-lock-alt"></i> Cambia tu contraseña</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="../controllers/editar.php" method="POST">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Contraseña actual:</label>
                                            <input type="password" placeholder="Clave de acceso actual..." class="form-control" name="contravieja" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Nueva contraseña:</label>
                                            <input required type="password" placeholder="Nueva contraseña..." class="form-control" name="contrasena_confirm1">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Confirmar contraseña:</label>
                                            <input required type="password" class="form-control" placeholder="Repite la nueva contraseña..." name="contrasena_confirm2">
                                            <input type="hidden" name="usuario" value="<?php echo @$user->id_usu ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                <button name="btn_perfil" type="submit" class="btn btn-info">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php require_once 'footer.php'; ?>