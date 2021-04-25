<?php
	
header("Access-Control-Allow-Origin: *");
	if(!is_null($_GET['idUser']))
	{
		include "sql_client.php";
		if(is_null($ret))
		{
			$token=$_GET['token'];
			$idUser=$_GET['idUser'];
			if(validarUser($idUser, $token, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2, &$idAlumne))
			{
							$sql="SELECT informacions.data, tema, informacio, vist FROM informacions, alumnes, informacions_grups WHERE informacions.idInformacio=informacions_grups.idInformacio and alumnes.grup=informacions_grups.grup and informacions.actiu=1 and idAlumne=".$idAlumne." ORDER BY informacions.idInformacio DESC";
							$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
							$ret=$info['data'];
			}else
			{
				$ret['data']="Fail";
				$ret['tema']="Error, user don't exist.";
			}
		}
	}else{
		$ret['data']="Fail";
		$ret['tema']="Error, undefined user.";
	}
	echo "{\"articles\":".json_encode($ret)."}";
	
?>