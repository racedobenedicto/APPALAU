<?php
include "sql_server.php";
include "sql_config.php";

function generar_push($idAlumne, $materia, $idUser, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2)
{
	$sql="SELECT oneSignal FROM users WHERE tipus='families' and idTipus=".$idAlumne." and idUser<>".$idUser;
	$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
	$n=0;
	foreach($info['data'] as $row)
	{
		$users[$n]=$row['oneSignal'];
		$n++;
	}
	$content      = array(
        "en" => 'Dispossa d\'un nou missatge a l\'aplicació APPALAU referent a l\'alumne '.$idAlumne.' al chat de la matèria '.$materia
    );
	$tittle = array(
		"en" => 'Nou missatge a APPALAU'
	);
	$fields = array(
        'app_id' => "9b3566eb-03b3-4fbc-8212-c1f889bf7d26",
        'include_player_ids' => $users,
        'contents' => $content,
        'headings' => $tittle
    );
	$fields = json_encode($fields);
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic NDA2NTA5NDQtYWYzZC00ZTJhLWIwNGYtN2EwNDM5ZDdhNmIw'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);

}

function validarUser($idUser, $token, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2, $idAlumne)
{
	if(!is_null($idUser))
	{
		try{
			$mysql = new sql_server($ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
			$return = 0;
			$sql="SELECT idUser, idTipus, user, pass FROM users WHERE idUser=".$idUser;
			$info=$mysql->executeQuery($sql, &$return );
			if($return==1)
			{
				$ret=($token==sha1($info['data'][0]['user'].$info['data'][0]['pass'].$info['data'][0]['idUser'].$info['data'][0]['idTipus']))?true:false;
				$idAlumne=$info['data'][0]['idTipus'];
			}else{
				$ret=false;
			}		
		} catch (Exception $e) {
			$ret=false;
			return $ret;
		}
	}else{
		$ret=false;
	}	
	return $ret;
}

function enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2)
{
	try{
		$mysql = new sql_server($ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
		$return = 0;
		$info=$mysql->executeQuery($sql, &$return );
			if($return==1)
			{
				$ret=$info;
			}else{
				$ret['state']="Fail";
				if($info['state']=="SQL") $ret['message']="Error, No data send.";
				if($info['state']=="BBDD") $ret['message']="Error, could not connect.";
			}		
	} catch (Exception $e) {
		$ret['state']="Fail";
		$ret['message']="Error, could not connect.";
		return $ret;
	}
	
	return $ret;
}

?>