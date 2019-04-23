<?php
header("Conect-Type: text/html; charset=UTF-8");
session_start();

if(isset($_GET["s"]) and $_GET["s"]==1){
	
	session_unset();
	session_destroy();
	header("Location: index.php");
}
function fechaDMA($fecha){
	
	$meses = array ("NULL","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
	$temp = explode("-",$fecha);
	$mes = abs($temp[1]);
	$regresar = "$temp[2]-$meses[$mes]-$temp[0]";
	return $regresar;
} 

$servidor = "mysql.hostinger.mx";
$nombreBD = "u262095322_pets";
$usuario = "u262095322_leonz";
$cont = "CursoWeb3";

$conexion = mysqli_connect($servidor, $usuario,$cont, $nombreBD);
mysqli_set_charset($conexion, "utf8");
if (mysqli_connect_errno($conexion)){
	
	die ("Error en la conexion".mysqli_connect_error());
}
	?>
