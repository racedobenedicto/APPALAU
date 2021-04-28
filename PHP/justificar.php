<?php
	
header("Access-Control-Allow-Origin: *");
	if(!is_null($_GET['idUser']))
	{
		include "sql_client.php";
		$idUser=$_GET['idUser'];
		$token=$_GET['token'];
		$text=$_GET['text'];
		$dia=$_GET['dia'];
		
		if(validarUser($idUser, $token, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2, &$idAlumne))
		{
					//consulta específica
					$sql="UPDATE asistencies_incidencies SET comentari='J', justificat='1', justificacio='Justificacio APP:".$text."' WHERE idAlumne=".$idAlumne." and dia='".$dia."' and incidencia='F' and comentari='F'";
					$ret="{sql:".$sql."}";
					$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
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