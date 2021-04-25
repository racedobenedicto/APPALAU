<?php
	
header("Access-Control-Allow-Origin: *");
include "sql_client.php";
	$user=$_GET['user'];
	$pass=$_GET['password'];
	$oneSignal=$_GET['oneSignal'];
	$sql="SELECT idUser, tipus, idTipus, pass FROM users WHERE user='".$user."' and pass=SHA('".$pass."') and bloquejat=0";
	$ret=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
	if($ret['state']=='success')
	{
		$info=$ret['data'];
		$resp['ok']=true;
		$resp['idUser']=$info[0]['idUser'];
		$resp['perfil']=$info[0]['tipus'];
		$resp['token']=sha1($user.$info[0]['pass'].$info[0]['idUser'].$info[0]['idTipus']);
		if(!is_null($oneSignal))
		{
			$sql="UPDATE users SET oneSignal='".$oneSignal."' WHERE idUser=".$info[0]['idUser'];
			$ret=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
		}
	}else{
		$resp['success']="false";
	}
	echo json_encode($resp);
	
?>