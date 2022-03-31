<?php 
include( '../conexion.php' );
$cedula = $_GET['e'];
$token = $_GET['t'];
$c = "SELECT clave_nueva_rec FROM tbl_recuperar_pass WHERE cedula_rec='$cedula' AND token_rec='$token' LIMIT 1 ";
$cons_contra1 = $pdo->prepare($c);
$cons_contra1->execute();
$a = $cons_contra1->fetch(PDO::FETCH_OBJ);
if(!$a){
	echo "<script>alert('Esta solicitud es antigua, intenta nuevamente...');</script>";
	echo "<script> document.location.href='../../../login.php';</script>";
	die();
}
//OBTENEMOS LA CLAVE Y ACTUALIZAMOS AL USUARIO
$clave = $a->clave_nueva_rec;
$c2 = "UPDATE tbl_usuario SET contrasena_usu=sha1('$clave') WHERE id_usu='$cedula' LIMIT 1";
$consulta_insertar = $pdo->prepare($c2);
$consulta_insertar->execute();
//ELIMINAR ESTA SOLICITUD DE RECUPERACIÓN
$c3 = "DELETE FROM tbl_recuperar_pass WHERE cedula_rec='$cedula'";
$consulta_eliminar = $pdo->prepare($c3);
$consulta_eliminar->execute();
echo "<script>alert('Su contraseña se actualizó correctamente, ya puedes iniciar sesión...');</script>";
echo "<script> document.location.href='../../../login.php';</script>";
