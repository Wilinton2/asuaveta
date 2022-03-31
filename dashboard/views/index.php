<?php
include_once '../controllers/conexion.php';
session_start();
@$id = $_SESSION['id_usu'];
if (!isset($id) || $id == null) {
    echo "<script>document.location.href='../controllers/session_destroy.php'</script>";
} else {
    //Distribución según privilegio
    $sql = "SELECT nombre_usu, fk_rol_usu FROM tbl_usuario
WHERE id_usu =?";
    $consulta = $pdo->prepare($sql);
    $consulta->execute(array($id));
    $resultado = $consulta->rowCount();
    $privi = $consulta->fetch(PDO::FETCH_OBJ);
    @$rol = $privi->fk_rol_usu;
    if ($rol == 1) {
        echo "<script>document.location.href='inicio.php'</script>";
    } elseif ($rol == 2) {
        echo "<script>document.location.href='admin.php'</script>";
    }elseif ($rol == 3) {
        echo "<script>document.location.href='admin.php'</script>";
    }
}
