<?php
// Genera acceso a la base de datos
include("../sql_config.php");
$mysqli = new mysqli($ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
if(!$mysqli->connect_errno){
	$mysqli->set_charset('utf8');
}else{
	$return=array('state' => "BBDD");
}
//Lee el método
$methode=$_GET['methode'];
//Lee lista de argumentos --> deserializa los argumentos
$parametres=explode("&",$_SERVER['argv'][0]);
$nParametres=0;
foreach($parametres as $parametre){
	if($nParametres!=0){
		$pAux=explode("=",$parametre);
		$nom[$nParametres-1]=$pAux[0];
		$valor[$nParametres-1]=$pAux[1];
	}
	$nParametres++;
}
//ejecuta el método con los argumentos correspondientes, enviado en forma de array ordenados según url
$return= $methode($mysqli,$valor);
//Control de errores y resultado
echo $return;
?>
