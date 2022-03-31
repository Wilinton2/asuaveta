<?php
//Validamos si la sesión existe y los privilegios del usuario...
include_once 'conexion.php';
session_start();
$id = $_SESSION['id_usu'];
$sql = "SELECT id_usu, nombre_usu, apellido_usu, fk_rol_usu FROM tbl_usuario WHERE id_usu=?";
$consulta = $pdo->prepare($sql);
$consulta->execute(array($id));
$prueba = $consulta->fetch(PDO::FETCH_OBJ);
if (!isset($id)) { 
    echo "<script>alert('¡Debes iniciar sesión!');</script>";
    echo "<script>javascript:history.back();</script>";  
}else if($prueba->fk_rol_usu !=2 && $prueba->fk_rol_usu !=3){
    echo "<script>alert('Hola $prueba->nombre_usu, nuestro Sistema de Información Web para la gestión de procesos Administrativos (SIA) le informa que el acceso a esta parte del sistema es exclusivo para administradores del mismo.');</script>";
    echo "<script>javascript:history.back();</script>";  
}else{
$nombreBD="bd_asuaveta";
// file header stuff
$output = "-- ESTA ES UNA COPIA DE LA BASE DE DATOS ASUAVETA REALIDADA POR:\n-- $prueba->nombre_usu $prueba->apellido_usu\n-- CC. $prueba->id_usu\n-- (ADMINISTRADOR DEL SIA)\n--\n";
$output .= "-- HASTA LA FECHA: " . date("r", time()) . "\n";
$output .= "-- NOMBRE DEL HOST: $host\n";
$output .= "-- Versión de PHP: " . phpversion() . "\n\n";
$output .= "SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n\n";
$output .= "--\n-- NOMBRE DE LA BASE DE DATOS: `$nombreBD`\n--\n";
// get all table names in db and stuff them into an array
$tables = array();
$stmt = $pdo->query("SHOW TABLES");
while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
    $tables[] = $row[0];
}
// process each table in the db
foreach ($tables as $table) {
    $fields = "";
    $sep2 = "";
    $output .= "\n-- " . str_repeat("-", 60) . "\n\n";
    $output .= "--\n-- ESTRUCTURA PARA LA TABLA: `$table`\n--\n\n";
    // get table create info
    $stmt = $pdo->query("SHOW CREATE TABLE $table");
    $row = $stmt->fetch(PDO::FETCH_NUM);
    $output .= $row[1] . ";\n\n";
    // get table data
    $output .= "--\n-- INSERTANDO DATOS A LA TABLA: `$table`\n--\n\n";
    $stmt = $pdo->query("SELECT * FROM $table");
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        // runs once per table - create the INSERT INTO clause
        if ($fields == "") {
            $fields = "INSERT INTO `$table` (";
            $sep = "";
            // grab each field name
            foreach ($row as $col => $val) {
                $fields .= $sep . "`$col`";
                $sep = ", ";
            }
            $fields .= ") VALUES";
            $output .= $fields . "\n";
        }
        // grab table data
        $sep = "";
        $output .= $sep2 . "(";
        foreach ($row as $col => $val) {
            // add slashes to field content
            $val = addslashes($val);
            // replace stuff that needs replacing
            $search = array("\'", "\n", "\r");
            $replace = array("''", "\\n", "\\r");
            $val = str_replace($search, $replace, $val);
            $output .= $sep . "'$val'";
            $sep = ", ";
        }
        // terminate row data
        $output .= ")";
        $sep2 = ",\n";
    }
    // terminate insert data
    $output .= ";\n";
}


// output file to browser
$fecha=date("d-m-Y");
$hora=date("h-ia");
header('Content-Description: File Transfer');
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . 'Copia_'.$nombreBD. '_'. $fecha.'_'. $hora.'.sql');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . strlen($output));
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
header('Pragma: public');
echo $output;
}//Fin de la condición de validación de privilegios
?>
