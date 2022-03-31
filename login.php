<?php
session_start();
@$id = $_SESSION['id_usu'];
if (isset($id)) {
    echo "<script>document.location.href='dashboard/views/index.php'</script>";
}
require_once 'nav_in.php'; ?>
<link rel="stylesheet" href="css/login.css">
<!--INICIAR SESIÓN-->
<div class="container mt-4">
    <hr>
    <h1 class="separador">Iniciar Sesión <i class="ti-arrow-top-right"></i></h1>
    <p class="text-muted text-center">Inicia sesión para utilizar los servicios que tenemos para ti. !Anímate!</p>
    <div class="cajap" style="background-image: url('../img/inicio/fondo_login.jpg');">
        <div class="row text-center login-page" style="margin: 0 auto;">
            <div class="col-md-12 login-form">
                <form onsubmit="return login()" method="post">
                    <div class="row">
                        <div class="col-md-12 login-form-header">
                            <p class="login-form-font-header">ASUA<span> VETA</span>
                            <p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 login-from-row">
                            <input name="id_usu" type="text" id="id_usu" placeholder="Documento..." required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 login-from-row">
                            <input name="contrasena_usu" id="contrasena_usu" type="password" placeholder="Contraseña..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 login-from-row">
                            <button type="submit" class="button button-primary">Entrar</button><br>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal_recuperar_pass" data-bs-whatever="@mdo">¿Olvidaste tu contraseña?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Modal para Recuperar contraseña-->
<div class="modal fade" id="modal_recuperar_pass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-lock-open-alt"></i> Recuperar contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" onsubmit="return recup_pass()">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="fw-bold text-success"><i class="fa fa-user-edit"></i> Documento de identidad:</label>
                            <input name="id_usu" type="text" id="email_pass" placeholder="Cédula..." required />
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="button button-primary">Validar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--Fin de modal de recuperas contraseña-->
<script>
    function login() {
        var cedula = document.getElementById('id_usu').value;
        var contrasena = document.getElementById('contrasena_usu').value;
        var todo = 'id_usu=' + cedula + '&contrasena_usu=' + contrasena;
        $.ajax({
            url: 'dashboard/controllers/login.php',
            type: 'post',
            data: todo,
            success: function(resp) {
                $('#respuesta').html(resp);
                if (resp == 1) {
                    Swal.fire({
                        type: 'success',
                        html: '<strong>¡BIENVENIDO(A)!</strong>',
                    });
                    document.location.href = 'dashboard/views/index.php';
                } else if (resp == 2) {
                    Swal.fire({
                        type: 'warning',
                        html: '<strong>¡Hola! te informamos que tu cuenta se encuentra en estado <strong>INACTIVO</strong> si crees que se trate de un error por favor comunícate con nosotros...<br><br>¡Muchas gracias!</strong>',
                    });
                } else {
                    Swal.fire({
                        type: 'error',
                        html: resp,
                    });
                }
            }
        });
        return false;
    }

    function recup_pass() {
        var correo_recup = document.getElementById('email_pass').value;
        var datospass = 'documento_recuperar=' + correo_recup;
        $.ajax({
            url: 'dashboard/controllers/contrasena/recuperar_clave.php',
            type: 'post',
            data: datospass,
            beforeSend: function() {
                Swal.fire({
                    type: 'info',
                    html: 'Validando información...',
                })
            },
            success: function(resp) {
                if (resp == 1) {
                    Swal.fire({
                        type: 'success',
                        title: '¡Muy bien!',
                        html: 'Para confirmar la solicitud debes revisar el mensaje que hemos enviado a tu correo electrónico....',
                    });
                } else {
                    Swal.fire({
                        type: 'error',
                        title: '¡Error!',
                        html: resp,
                    });
                }
            }
        });
        return false;
    }
</script>
<?php require_once 'footer.php' ?>