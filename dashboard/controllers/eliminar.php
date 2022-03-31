<?php
include_once 'conexion.php';
if (isset($_POST['tarifaEliminar'])) {
    $idtarElim = $_POST['tarifaEliminar'];
    $sql_eliminar_tar = "DELETE FROM tarifa WHERE id_tar =?";
    $consulta_eliminar = $pdo->prepare($sql_eliminar_tar);
    $consulta_eliminar->execute(array($idtarElim));
    echo 1;
}
//Eliminar comentario
if (@$_POST['IdComentario'] != null) {
    $sql_eliminar_com = "DELETE FROM tbl_comentario WHERE id_com =?";
    $consulta_eliminar_com = $pdo->prepare($sql_eliminar_com);
    $consulta_eliminar_com->execute(array($_POST['IdComentario']));
    echo "¡El comentario ha sido eliminado!";
}
if (isset($_GET['CANCELAR_SUSCRIPCIONMDDJDNJDNDJDHBDHDBDGFSUJMKDLDDLMDKDNIDN'])) {
    $susini = $_GET['CANCELAR_SUSCRIPCIONMDDJDNJDNDJDHBDHDBDGFSUJMKDLDDLMDKDNIDN'];
?>
    <script>
        if (confirm("¿Seguro que quieres cancelar tu suscripción a nuestro boletín informativo?")) {
            window.location.href = "eliminar.php?CONFIRM_CANCEL_SUSCRIP=" + <?php echo "'$susini'" ?>;
        } else {
            window.location.href='../../index.php#boletin';
        }
    </script>
<?php
}
if (isset($_GET['CONFIRM_CANCEL_SUSCRIP']) && $_GET['CONFIRM_CANCEL_SUSCRIP'] != null) {
    $suscripcion = base64_decode($_GET['CONFIRM_CANCEL_SUSCRIP']);
    $sql_eliminar_bol = "DELETE FROM tbl_boletin WHERE correo_bol =?";
    $consulta_eliminar_bol = $pdo->prepare($sql_eliminar_bol);
    $consulta_eliminar_bol->execute(array($suscripcion));
    echo "<script>alert('Se ha cancelado tu suscripción al boletín informativo')</script>";
    echo "<script>window.location.href='../../index.php#boletin';</script>";
}
