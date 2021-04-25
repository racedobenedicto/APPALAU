<?php
	
header("Access-Control-Allow-Origin: *");
	if(!is_null($_GET['idUser']))
	{
		include "sql_client.php";
		$idUser=$_GET['idUser'];
		$token=$_GET['token'];
		$materia=$_GET['assignatura'];
		$msg=$_GET['msg'];
		$msg=str_replace('"','\"',$msg);
		$msg=str_replace("'","\'",$msg);
		//Hora
		$ahora=getdate();
		$hora=$ahora['hours'];
		$min=$ahora['minutes'];
		$sec=$ahora['seconds'];
		if($hora<10) $hora='0'.$hora;
		if($min<10) $min='0'.$min;
		if($sec<10) $sec='0'.$sec;
		$hora= $hora.":".$min.":".$sec;
		//Fecha
		$dia=$ahora['mday'];
		$mes=$ahora['mon'];
		$ano=$ahora['year'];
		if($mes<10) $mes="0".$mes;
		if($dia<10) $dia="0".$dia;
		$data=$dia."/".$mes."/".$ano;
		if(validarUser($idUser, $token, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2, &$idAlumne))
		{
			$sql="SELECT count(idChat) as id FROM msg_chat";
			$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
			$id=$info['data'][0]['id']+1;
			//print_r($info);
			$idChat=$idAlumne."_".$id;
			//echo $idChat;
			$sql="INSERT INTO `msg_chat`(`idChat`, `idAlumne`, `materia`, `idUser`, `data`, `hora`, `msj`) VALUES ('".$idChat."', ".$idAlumne.", '".$materia."', ".$idUser.", '".$data."', '".$hora."', '".$msg."')";
			$ret="{sql:".$sql."}";
			$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
			$sql="SELECT idUser FROM users WHERE tipus='families' and idTipus=".$idAlumne." and idUser<>".$idUser;
			$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
			foreach($info['data'] as $row)
			{
				$sql="INSERT INTO msg_chats_vist(idChat, idUser, vist) VALUES ('".$idChat."', ".$row['idUser'].", 0)";
				$info2=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
			}
			$sql="INSERT INTO msg_chats_vist(idChat, idUser, vist) VALUES ('".$idChat."', ".$idUser.", 0)";
				$info2=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
			//Generar push a telefono
			generar_push($idAlumne, $materia, $idUser, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
		}else
		{
			$ret['data']="Fail";
			$ret['tema']="Error, user blocked.";
		}
	}else{
		$ret['data']="Fail";
		$ret['tema']="Error, undefined user.";
	}
	echo json_encode($ret);
	
?>