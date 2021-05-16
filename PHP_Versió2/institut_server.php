<?php
	
header("Access-Control-Allow-Origin: *");
require "rpc_router.php";

//Funcions generades per el rpc
function updateUser($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	$direccio=$parametres[2];
	$municipi=$parametres[3];
	$codi_postal=$parametres[4];
	$user=$parametres[5];
	$telf=$parametres[6];
	$email=$parametres[7];
	$n=0;
	$n2=0;
	if($user!=-1)
	{
		$actualiza="user='".$user."'";
		$n=1;
	}
	if($telf!=-1)
	{
		if($n==0)
		{
			$actualiza="mobil='".$telf."'";
			$n=1;
		}else{
			$actualiza=$actualiza.", mobil='".$telf."'";	
		}
	}
	if($email!=-1)
	{
		if($n==0)
		{
			$actualiza="mail='".$email."'";
			$n=1;
		}else{
			$actualiza=$actualiza.", mail='".$email."'";	
		}
	}    
	if($direccio!=-1)
	{
		$actualiza2="direccio='".$direccio."'";
		$n2=1;
	}
	if($municipi!=-1)
	{
		if($n2==0)
		{
			$actualiza2="municipi='".$municipi."'";
			$n2=1;
		}else{
			$actualiza2=$actualiza2.", municipi='".$municipi."'";	
		}
	}
	if($codi_postal!=-1)
	{
		if($n2==0)
		{
			$actualiza2="codi_postal='".$codi_postal."'";
			$n2=1;
		}else{
			$actualiza2=$actualiza2.", codi_postal='".$codi_postal."'";	
		}
	}
	if(validarUser($mysqli, $idUser, $token, &$idAlumne))
	{
		if($n==1)
		{
			$sql="UPDATE users SET ".$actualiza." WHERE idUser=".$idUser;
			accessBBDD($mysqli, $sql);
		}
		if($n2==1)
		{
			$sql="UPDATE alumnes SET ".$actualiza2." WHERE idAlumne=".$idAlumne;
			accessBBDD($mysqli, $sql);
		}
	}
	return json_encode($ret);
}

function chats($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	if(validarUser($mysqli, $idUser, $token, &$idAlumne))
	{
		$sql="SELECT classe as materia FROM curriculum WHERE idAlumne=".$idAlumne." ORDER BY classe";
		$ret=accessBBDD($mysqli, $sql);
		$n=0;
		foreach($ret as $row)
		{
			$mat=$row['materia'];
			$sql="SELECT count(msg_chat.idChat) as nMsg FROM msg_chat, msg_chats_vist WHERE idAlumne=".$idAlumne." and materia='".$mat."' and msg_chat.idChat=msg_chats_vist.idChat and msg_chats_vist.idUser=".$idUser." and vist=0";
			$ret2=accessBBDD($mysqli, $sql);
			$dades[$n]['materia']=$mat;
			$dades[$n]['nMsg']=$ret2[0]['nMsg'];
			$n++;
		}
	}
	return json_encode($dades);
}

function sendMSG($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	$materia=$parametres[2];
	$msg=$parametres[3];
	$msg=str_replace('"','\"',$msg);
	$msg=str_replace("'","\'",$msg);
	$hora=hora_string();
	$data=fecha_string();
	if(validarUser($mysqli, $idUser, $token, &$idAlumne))
	{
		$sql="SELECT count(idChat) as id FROM msg_chat";
			$info=accessBBDD($mysqli, $sql);
			$id=$info[0]['id']+100000001;			
			$idChat=$idAlumne."_".$id;
			$sql="INSERT INTO `msg_chat`(`idChat`, `idAlumne`, `materia`, `idUser`, `data`, `hora`, `msj`) VALUES ('".$idChat."', ".$idAlumne.", '".$materia."', ".$idUser.", '".$data."', '".$hora."', '".$msg."')";
			accessBBDD($mysqli, $sql);
			$sql="SELECT idUser FROM users WHERE tipus='families' and idTipus=".$idAlumne." and idUser<>".$idUser;
			$info=accessBBDD($mysqli, $sql);
			foreach($info as $row)
			{
				$sql="INSERT INTO msg_chats_vist(idChat, idUser, vist) VALUES ('".$idChat."', ".$row['idUser'].", 0)";
				accessBBDD($mysqli, $sql);
			}
			$sql="INSERT INTO msg_chats_vist(idChat, idUser, vist) VALUES ('".$idChat."', ".$idUser.", 0)";
			accessBBDD($mysqli, $sql);
			//Generar push a telefono
			generar_push($mysqli, $idAlumne, $materia, $idUser);
		}
	return json_encode($ret);
}

function readMSG($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	$assignatura=$parametres[2];
	$tipus=$parametres[3];
	if(validarUser($mysqli, $idUser, $token, &$idAlumne))
	{
		//Mira numero de usuarios
		$sql="SELECT users.idUser FROM msg_chat, users WHERE idAlumne=".$idAlumne." and users.idUser=msg_chat.idUser and materia='".$assignatura."' GROUP BY users.idUser";
		$ret=accessBBDD($mysqli, $sql);
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
		$ret=accessBBDD($mysqli, $sql);
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
			accessBBDD($mysqli, $sql2);
		}
		$ret=$dades;
	}
	return json_encode($ret);
}

function documentation($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	if(validarUser($mysqli, $idUser, $token, &$idAlumne))
		{
			$sql="SELECT data, tema, nomProfessor, data_limit FROM professors, documentacio WHERE idAlumne=".$idAlumne." and professors.idProfessor=documentacio.idProfessor";
			$ret2=accessBBDD($mysqli, $sql);
			$n=0;
			foreach($ret2 as $row)
			{

				$dades[$n]['data']=$row['data'];
				$dades[$n]['tema']=$row['tema'];
				$dades[$n]['msg']="Nova documentació a lliurar en el correu de tutoria";
				$dades[$n]['professor']=$row['nomProfessor'];
				$dades[$n]['venciment']=$row['data_limit'];
				$n++;
			}
		}
		return json_encode($dades);
}

function expedient($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	if(validarUser($mysqli, $idUser, $token, &$idAlumne))
	{
		$sql="SELECT dia as data, hora, comentari FROM asistencies_incidencies, dates WHERE idAlumne=".$idAlumne." and dia=dates.data and incidencia='F' ORDER BY idData";
		$ret2=accessBBDD($mysqli, $sql);
		$n=0;
		$data[$n]=$ret2[$n]['data'];
		foreach($ret2 as $row){
			$absencies[$row['data']]["H".$row['hora']]=$row['comentari'];
			if($data[$n]!=$row['data']){
				$n++;
				$data[$n]=$row['data'];
			}
		}
		for($i=0;$i<=$n;$i++){
			$ret3[$i]['data']=$data[$i];
			for($j=1;$j<7;$j++){
				if($absencies[$data[$i]]["H".$j]!=null){
					$ret3[$i]["H".$j]=$absencies[$data[$i]]["H1"];
				}else{
					$ret3[$i]["H".$j]=' ';
				}
			}
		}
		$sql="SELECT dia as data, nomProfessor as profesor, text as tipificacio, comentari as detall FROM asistencies_incidencies, dates, asistencies_codi, professors WHERE idAlumne=".$idAlumne." and dia=dates.data and asistencies_incidencies.incidencia='O' and asistencies_incidencies.codi=asistencies_codi.idCodi and professors.idProfessor=asistencies_incidencies.idProfessor ORDER BY idData DESC";
		$observacions=accessBBDD($mysqli, $sql);
		$sql="SELECT dia as data, nomProfessor as profesor, text as tipificacio, comentari as detall FROM asistencies_incidencies, dates, asistencies_codi, professors WHERE idAlumne=".$idAlumne." and dia=dates.data and asistencies_incidencies.incidencia='A' and asistencies_incidencies.codi=asistencies_codi.idCodi and professors.idProfessor=asistencies_incidencies.idProfessor ORDER BY idData DESC";
		$incidencies=accessBBDD($mysqli, $sql);
	}
	return "{\"absencies\":".json_encode($ret3).",\"observaciones\":".json_encode($observacions).", \"incidencias\":".json_encode($incidencies)."}";		
}

function info($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	if(validarUser($mysqli, $idUser, $token, &$idAlumne))
	{
		$sql="SELECT idAlumne, informacions.data, tema, informacio, vist FROM informacions, alumnes, informacions_grups WHERE idAlumne=".$idAlumne.
				" and informacions.idInformacio=informacions_grups.idInformacio and alumnes.grup=informacions_grups.grup and informacions.actiu=1 ORDER BY informacions.idInformacio DESC";
		$ret=accessBBDD($mysqli, $sql);
	}
	return "{\"articles\":".json_encode($ret)."}";
}

function justificar($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	$text=$parametres[2];
	$dia=$parametres[3];
	if(validarUser($mysqli, $idUser, $token, &$idAlumne))
	{
		$sql="UPDATE asistencies_incidencies SET comentari='J', justificat='1', justificacio='Justificacio APP:".$text."' WHERE idAlumne=".$idAlumne." and dia='".$dia."' and incidencia='F' and comentari='F'";
		accessBBDD($mysqli, $sql);
	}
}

function login($mysqli, $parametres){
	$user=$parametres[0];
	$pass=$parametres[1];
	$oneSignal=$parametres[2];
	$sql="SELECT idUser, tipus as perfil, idTipus, pass FROM users WHERE user='".$user."' and pass=SHA('".$pass."') and bloquejat=0";
	$ret=accessBBDD($mysqli, $sql);
	if(!is_null($ret)){
		$ret[0]['token']=sha1($user.$ret[0]['pass'].$ret[0]['idUser'].$ret[0]['idTipus']);
		$ret[0]['ok']=true;
	}
	if(!is_null($oneSignal))
	{
		$sql="UPDATE users SET oneSignal='".$oneSignal."' WHERE idUser=".$ret[0]['idUser'];
		accessBBDD($mysqli, $sql);
	}
	return json_encode($ret[0]);
}
	
function perfil($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	if (validarUser($mysqli, $idUser, $token, &$idAlumne)){
		
		$sql="SELECT nomAlumne, alumnes.grup, nomProfessor as tutorGrup, pare as tutor1, mare as tutor2, alumnes.direccio, municipi, codi_postal FROM alumnes, professors, horaris WHERE professors.idProfessor=horaris.idProfessor and classe='TUT' and horaris.grup=alumnes.grup and idAlumne=".$idAlumne;
		$ret=accessBBDD($mysqli, $sql);
		$ret3="\"nomAlumne\":\"".$ret[0]['nomAlumne']."\", \"grup\":\"".$ret[0]['grup']."\", \"tutorGrup\":\"".$ret[0]['tutorGrup']."\", \"tutor1\":\"".$ret[0]['tutor1']."\", \"tutor2\":\"".$ret[0]['tutor2']."\", \"municipi\":\"".$ret[0]['municipi']."\", \"codi_postal\":\"".$ret[0]['codi_postal']."\", \"direccio\":\"".$ret[0]['direccio']."\"";
		$sql="SELECT responsable as nomUsuari, user as usuari, mail as email, mobil as tlf FROM users WHERE tipus='families' and idTipus=".$idAlumne;
		$ret2=accessBBDD($mysqli, $sql);
		$dire='./imagenes/fotos/';
		$n=$ret[0]['nomAlumne'];
		$n=str_replace(" ",",",$n);
		$exploded = explode(",",$n);
		$name2=$exploded[0].$exploded[1].$exploded[2].$exploded[3].$idAlumne; 
		$ret4="http://appalau.institutelpalau.com/imagenes/fotos/".$idAlumne.'_'.$name2.".jpg";	
		return "{".$ret3.", \"usuaris\":".json_encode($ret2).", \"foto\":\"".$ret4."\"}";
	}
}
function users($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	$sql="SELECT responsable as nomUsuari, user as usuari, mobil as tlf, mail as email  FROM users WHERE idUser=$idUser";
	if (validarUser($mysqli, $idUser, $token, &$idAlumne)) return json_encode(accessBBDD($mysqli, $sql));
}



//Funcions auxiliars
function accessBBDD($mysqli, $sql){
	$result = $mysqli->query($sql);
	if($result->num_rows>0){
		while($row = $result->fetch_assoc())
		{
			$return[] = $row;
		}
	}else{
		$return = null;
	}
	return $return;
}

function validarUser($mysqli, $idUser, $token,  $idAlumne)
{
	$sql="SELECT idUser, idTipus, user, pass FROM users WHERE idUser=".$idUser;
	$info=accessBBDD($mysqli, $sql);
	if(!is_null($info))
	{
		$ret=($token==sha1($info[0]['user'].$info[0]['pass'].$info[0]['idUser'].$info[0]['idTipus']))?true:false;
		$idAlumne=$info[0]['idTipus'];
	}else{
		$ret=false;
	}		
	return $ret;
}

function hora_string(){
	$ahora=getdate();
	$hora=$ahora['hours'];
	$min=$ahora['minutes'];
	$sec=$ahora['seconds'];
	if($hora<10) $hora='0'.$hora;
	if($min<10) $min='0'.$min;
	if($sec<10) $sec='0'.$sec;
	$hora= $hora.":".$min.":".$sec;
	return $hora;
}

function fecha_string(){
	$ahora=getdate();
	$dia=$ahora['mday'];
	$mes=$ahora['mon'];
	$ano=$ahora['year'];
	if($mes<10) $mes="0".$mes;
	if($dia<10) $dia="0".$dia;
	$data=$dia."/".$mes."/".$ano;
	return $data;	
}

function generar_push($mysqli, $idAlumne, $materia, $idUser)
{
	$sql="SELECT oneSignal FROM users WHERE tipus='families' and idTipus=".$idAlumne." and idUser<>".$idUser;
	$info=accessBBDD($mysqli, $sql);
	$n=0;
	foreach($info as $row)
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
        'app_id' => "9b3566eb-03b3-4fbc-8212-c1f889bf7d26XXX",
        'include_player_ids' => $users,
        'contents' => $content,
        'headings' => $tittle
    );
	$fields = json_encode($fields);
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic NDA2NTA5NDQtYWYzZC00ZTJhLWIwNGYtN2EwNDM5ZDdhNmIwXXX'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);

}
?>
