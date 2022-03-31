<?php 
setlocale(LC_ALL, 'es_CO', 'es.UTF-8');
// parámetro de conexion a base de datos

$host = "mysql:host=localhost;dbname=bd_asuaveta";
$usuario= "root";
$contrasena= "";

try {
	//conexion exitosa
	$pdo = NEW pdo($host,$usuario,$contrasena);
	echo "";
 } catch (pdoException $e) {
// error conexion
	echo "Error en la conexión a base de datos :/".$e->getMessage(). "<br/>";
	die();
}
?>