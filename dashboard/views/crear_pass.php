<?php //Validamos si la sesión existe y los privilegios del usuario...
include_once '../controllers/conexion.php';
//Selección de los datos del usuario a registrar
@$serPass = base64_decode($_GET['NU']);
$sql_pass = "SELECT fk_suscriptor_serv, nombre_usu, apellido_usu FROM tbl_usuario as US
INNER JOIN tbl_servicio as SER ON SER.fk_suscriptor_serv=US.id_usu
WHERE id_serv =?";
$cons_pass = $pdo->prepare($sql_pass);
$cons_pass->execute(array($serPass));
$datospass = $cons_pass->fetch(PDO::FETCH_OBJ);
//Asignar contraseña administrador
@$docAdmin = base64_decode($_GET['NEW_ADMIN_SIA_ASUAVETA']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        CREAR CUENTA
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
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
                        <a class="navbar-brand" href="perfil.php"><?php echo @$prueba->nombre_usu . " " . @$prueba->apellido_usu ?></a>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="panel-header">
                <div class="header text-center">
                    <h2 class="title">Crear contraseña segura</h2>
                    <p class="text-muted">¡Estás muy cerca de iniciar esta gran aventura!. Por favor crea una clave de acceso personal :)</p>
                </div>
            </div>
            <br>
            <div class="col-md-8 text-center" style="margin: 0 auto;">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-category">BIENVENIDO(A), <?php echo @$datospass->nombre_usu . " " . @$datospass->apellido_usu ?>...</h5>
                        <h4 class="card-title"> Crea tu cuenta</h4>
                    </div>
                    <div class="card-body text-center">
                        <?php if (!$datospass && !@$_GET['NEW_ADMIN_SIA_ASUAVETA']) { ?>
                            <p class="text-muted text-danger font-weight-bold">Puedes estar accediendo de forma incorrecta. Si el problema persiste puedes ponerte en contacto con nosotros...</p>
                        <?php } if($datospass != null){ ?>
                            <form method="post" onsubmit="return formNewPass()">
                                <div class="row">
                                    <div class="col-md-5 mb-3" style="margin: 0 auto;">
                                        <label class="font-weight-bold text-uppercase">Nueva contraseña:</label>
                                        <input type="password" class="form-control is-valid" id="Pass1" maxlength="15" placeholder="Asigna una contraseña..." required></input>
                                    </div>
                                    <div class="col-md-5 mb-3" style="margin: 0 auto;">
                                        <label class="font-weight-bold text-uppercase">Repetir contraseña:</label>
                                        <input type="password" class="form-control is-valid" id="Pass2" maxlength="15" placeholder="Escribir nuevamente..." required></input>
                                        <input type="hidden" id="DocPass" value="<?php echo @$datospass->fk_suscriptor_serv ?>">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success"><i style="font-size: large;" class="far fa-plane"> Verificar</i></button>
                            </form>
                        <?php }
                        if (isset($_GET['NEW_ADMIN_SIA_ASUAVETA'])) { ?>
                            <form method="post" onsubmit="return formNewPass()">
                                <div class="row">
                                    <div class="col-md-5 mb-3" style="margin: 0 auto;">
                                        <label class="font-weight-bold text-uppercase">Nueva contraseña:</label>
                                        <input type="password" class="form-control is-valid" id="Pass1" maxlength="15" placeholder="Asigna una contraseña..." required></input>
                                    </div>
                                    <div class="col-md-5 mb-3" style="margin: 0 auto;">
                                        <label class="font-weight-bold text-uppercase">Repetir contraseña:</label>
                                        <input type="password" class="form-control is-valid" id="Pass2" maxlength="15" placeholder="Escribir nuevamente..." required></input>
                                        <input type="hidden" id="DocPass" value="<?php echo @$docAdmin ?>">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><i style="font-size: large;" class="far fa-plane"> Verificar</i></button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <script>
                function formNewPass() {
                    var pass1 = document.getElementById("Pass1").value;
                    var pass2 = document.getElementById("Pass2").value;
                    var docpass = document.getElementById("DocPass").value;
                    var passes = 'Pass1=' + pass1 + '&Pass2=' + pass2 + '&DocPass=' + docpass;
                    if (pass1 == pass2) {
                        $.ajax({
                            url: '../controllers/editar.php',
                            type: 'post',
                            data: passes,
                            beforeSend: function() {
                                Swal.fire({
                                    type: 'info',
                                    title: 'Validando...',
                                    showConfirmButton: false,
                                });
                            },
                            success: function(respPass) {
                                if (respPass == 1) {
                                    Swal.fire({
                                        type: 'success',
                                        title: '¡Perfecto!',
                                        html: 'Tu cuenta se ha creado de manera exitosa, en un momento serás redireccionado...',
                                        showConfirmButton: true,
                                    });
                                    setTimeout(function() {
                                        window.location.href = "index.php";
                                    }, 5000);
                                } else {
                                    Swal.fire({
                                        type: 'error',
                                        title: '¡Error!',
                                        html: respPass,
                                        showConfirmButton: true,
                                    });
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            type: 'warning',
                            title: '¡Las contraseñas no coinciden!',
                            html: 'Por favor verifica e intenta nuevamente...',
                            showConfirmButton: true,
                        });
                    }
                    return false;
                };
            </script>


            <?php
            require_once 'footer.php';
            ?>