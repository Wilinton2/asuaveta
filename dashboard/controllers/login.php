<?php
include_once 'conexion.php';
if (@$_POST['contrasena_usu']) {
    //Captura de información
    $id = $_POST['id_usu'];
    $contrasena = sha1($_POST['contrasena_usu']);
    $sql_inicio = "SELECT id_usu, nombre_usu, apellido_usu, fk_rol_usu, fk_estado_usu FROM tbl_usuario WHERE id_usu =? AND contrasena_usu=?";
    $consulta = $pdo->prepare($sql_inicio);
    $consulta->execute(array($id, $contrasena));
    $resultado = $consulta->rowCount();
    $prueba = $consulta->fetch(PDO::FETCH_OBJ);
    //Ingreso al sistema
    if ($resultado == 1) {
        $estado = $prueba->fk_estado_usu;
        if ($estado == 1) {
            session_start();
            $_SESSION['id_usu'] = $prueba->id_usu;
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo "No encontramos ninguna cuenta con los datos ingresados, por favor verifica e intenta nuevamente...";
    }
}
