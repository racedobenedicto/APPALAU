<?php
	
header("Access-Control-Allow-Origin: *");
require "rpc_router.php";

//Funcions generades per el rpc
function expedient($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	if(validarUser($mysqli, $idUser, $token))
	{
		$sql="SELECT dia as data, hora, comentari FROM asistencies_incidencies, dates, users WHERE idAlumne=idTipus and tipus='families' and dia=dates.data and incidencia='F' ORDER BY idData";
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
	if(validarUser($mysqli, $idUser, $token))
	{
		$sql="SELECT idAlumne, informacions.data, tema, informacio, vist FROM informacions, alumnes, informacions_grups, users WHERE idTipus=idAlumne and tipus='families'".
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
	if(validarUser($mysqli, $idUser, $token))
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
	$ret[0]['token']=sha1($user.$ret[0]['pass'].$ret[0]['idUser'].$ret[0]['idTipus']);
	if(!is_null($oneSignal))
	{
		$sql="UPDATE users SET oneSignal='".$oneSignal."' WHERE idUser=".$ret[0]['idUser'];
		accessBBDD($mysqli, $sql);
	}
	return json_encode($ret);
}
	
function perfil($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	if (validarUser($mysqli, $idUser, $token)){
		
		$sql="SELECT idAlumne, nomAlumne, alumnes.grup, nomProfessor as tutorGrup, pare as tutor1, mare as tutor2, alumnes.direccio, municipi, codi_postal FROM alumnes, professors, horaris, users WHERE idAlumne=idTipus and tipus='families' and professors.idProfessor=horaris.idProfessor and classe='TUT' and horaris.grup=alumnes.grup and idUser=".$idUser;
		$ret=accessBBDD($mysqli, $sql);
		$idAlumne=$ret[0]['idAlumne'];
		$ret3="\"nomAlumne\":\"".$ret[0]['nomAlumne']."\", \"grup\":\"".$ret[0]['grup']."\", \"tutorGrup\":\"".$ret[0]['tutorGrup']."\", \"tutor1\":\"".$ret[0]['tutor1']."\", \"tutor2\":\"".$ret[0]['tutor2']."\", \"municipi\":\"".$ret[0]['municipi']."\", \"codi_postal\":\"".$ret[0]['codi_postal']."\", \"direccio\":\"".$ret[0]['direccio']."\"";
		$sql="SELECT responsable as nomUsuari, user as usuari, mail as email, mobil as tlf FROM users WHERE tipus='families' and idTipus=".$idAlumne;
		$ret2=accessBBDD($mysqli, $sql);
		$dire='./imagenes/fotos/';
		$n=$ret[0]['nomAlumne'];
		$n=str_replace(" ",",",$n);
		$exploded = explode(",",$n);
		$name2=$exploded[0].$exploded[1].$exploded[2].$exploded[3].$ret[0]['idAlumne']; 
		$ret4="http://appalau.institutelpalau.com/imagenes/fotos/".$idAlumne.'_'.$name2.".jpg";	
		return "{".$ret3.", \"usuaris\":".json_encode($ret2).", \"foto\":\"".$ret4."\"}";
	}
}
function users($mysqli, $parametres){
	$idUser=$parametres[0];
	$token=$parametres[1];
	$sql="SELECT responsable as nomUsuari, user as usuari, mobil as tlf, mail as email  FROM users WHERE idUser=$idUser";
	if (validarUser($mysqli, $idUser, $token)) return json_encode(accessBBDD($mysqli, $sql));
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

function validarUser($mysqli, $idUser, $token)
{
	$sql="SELECT idUser, idTipus, user, pass FROM users WHERE idUser=".$idUser;
	$info=accessBBDD($mysqli, $sql);
	if(!is_null($info))
	{
		$ret=($token==sha1($info[0]['user'].$info[0]['pass'].$info[0]['idUser'].$info[0]['idTipus']))?true:false;
	}else{
		$ret=false;
	}		
	return $ret;
}
?>
