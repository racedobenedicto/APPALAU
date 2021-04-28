<?php
	
header("Access-Control-Allow-Origin: *");
	if(!is_null($_GET['idUser']))
	{
		include "sql_client.php";
		$token=$_GET['token'];
		$idUser=$_GET['idUser'];
		if(validarUser($idUser, $token, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2, &$idAlumne))
		{
			$sql="SELECT classe as materia FROM curriculum WHERE idAlumne=".$idAlumne." ORDER BY classe";
			$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
			$ret=$info['data'];
			$n=0;
			foreach($ret as $row)
			{
				$mat=$row['materia'];
				$sql="SELECT count(msg_chat.idChat) as nMsg FROM msg_chat, msg_chats_vist WHERE idAlumne=".$idAlumne." and materia='".$mat."' and msg_chat.idChat=msg_chats_vist.idChat and msg_chats_vist.idUser=".$idUser." and vist=0";
				$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
				$ret2=$info['data'];
				$dades[$n]['materia']=$mat;
				$dades[$n]['nMsg']=$ret2[0]['nMsg'];
				$n++;
			}
			$ret=$dades;
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