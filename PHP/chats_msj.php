<?php
	
header("Access-Control-Allow-Origin: *");
	if(!is_null($_GET['idUser']))
	{
		include "sql_client.php";
		$token=$_GET['token'];
		$idUser=$_GET['idUser'];
		$assignatura=$_GET['assignatura'];
		$tipus=$_GET['tipus'];
		if(validarUser($idUser, $token, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2, &$idAlumne))
		{
			//Mira numero de usuarios
			$sql="SELECT users.idUser FROM msg_chat, users WHERE idAlumne=".$idAlumne." and users.idUser=msg_chat.idUser and materia='".$assignatura."' GROUP BY users.idUser";
			$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
			$ret=$info['data'];
			$n=1;
			foreach($ret as $row)
			{
				if($row['idUser']!=$idUser)
				{
					$users[$row['idUser']]=$n;
					$n++;
				}else{
					$users[$row['idUser']]=0;
				}
			}
			//consulta específica
			if($tipus=="tots") $sql="SELECT idChat, materia, users.idUser, users.responsable as nomUser, data, hora, msj FROM msg_chat, users WHERE idAlumne=".$idAlumne." and users.idUser=msg_chat.idUser and materia='".$assignatura."'";
			if($tipus=="noLlegits") $sql="SELECT msg_chat.idChat, materia, users.idUser, users.responsable as nomUser, data, hora, msj FROM msg_chat, users, msg_chats_vist WHERE idAlumne=".$idAlumne." and users.idUser=msg_chat.idUser and materia='".$assignatura."' and msg_chat.idChat=msg_chats_vist.idChat and msg_chats_vist.idUser=".$idUser." and msg_chats_vist.vist=0";
			$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
			$ret=$info['data'];
			$n=0;
			foreach($ret as $row)
			{
				$dades[$n]['materia']=$row['materia'];
				$dades[$n]['idUser']=$row['idUser'];
				$dades[$n]['nomUser']=$row['nomUser'];
				$dades[$n]['data']=$row['data'];
				$dades[$n]['hora']=$row['hora'];
				$dades[$n]['msj']=$row['msj'];
				$dades[$n]['vist']=$row['vist'];
				$dades[$n]['color']=$users[$row['idUser']];
				$n++;
				$sql2="UPDATE msg_chats_vist SET vist=1 WHERE idChat='".$row['idChat']."' and idUser=".$idUser." and vist=0";
				enviar_consulta($sql2, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
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