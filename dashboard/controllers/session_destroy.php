<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
    <script type="text/javascript" src="../assets/js/jquery.min.js"></script>
    <title>Sesión caducada</title>
</head>

<body>
    <?php
    session_start();
    session_destroy();
    ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                type: 'info',
                title: '!Sesión cerrada!',
                html: '<strong>En este momento no hay ninguna sesión activa :)</strong><br><br>En unos segundos serás redireccionado...',
                showConfirmButton: false,
            });
            setTimeout(function() {
                window.location.href = "../../login.php";
            }, 1500);
        });
    </script>
    <script src="../assets/js/sweetalert2.all.min.js"></script>
</body>
</html>