<?php
	
header("Access-Control-Allow-Origin: *");
	if(!is_null($_GET['idUser']))
	{
		include "sql_client.php";
		$token=$_GET['token'];
		$idUser=$_GET['idUser'];
		if(validarUser($idUser, $token, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2, &$idAlumne))
		{
					//consulta específica
					$sql="SELECT responsable as nomUsuari, user as usuari, mobil as tlf, mail as email  FROM users WHERE idUser=$idUser";
					$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
					$ret=$info['data'];
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