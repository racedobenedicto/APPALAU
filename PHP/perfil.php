<?php
header("Access-Control-Allow-Origin: *");
	if(!is_null($_GET['idUser']))
	{
		include "sql_client.php";
			$token=$_GET['token'];
			$idUser=$_GET['idUser'];

			if(validarUser($idUser, $token, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2, &$idAlumne))
			{
				//Usuario correcto se define la consulta
							$sql="SELECT nomAlumne, alumnes.grup, nomProfessor as tutorGrup, pare as tutor1, mare as tutor2, alumnes.direccio, municipi, codi_postal FROM alumnes, professors, horaris WHERE idAlumne=".$idAlumne." and professors.idProfessor=horaris.idProfessor and classe='TUT' and horaris.grup=alumnes.grup";
							$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
							$ret=$info['data'];
							
							$ret3="\"nomAlumne\":\"".$ret[0]['nomAlumne']."\", \"grup\":\"".$ret[0]['grup']."\", \"tutorGrup\":\"".$ret[0]['tutorGrup']."\", \"tutor1\":\"".$ret[0]['tutor1']."\", \"tutor2\":\"".$ret[0]['tutor2']."\", \"municipi\":\"".$ret[0]['municipi']."\", \"codi_postal\":\"".$ret[0]['codi_postal']."\", \"direccio\":\"".$ret[0]['direccio']."\"";
							$sql="SELECT responsable as nomUsuari, user as usuari, mail as email, mobil as tlf FROM users WHERE tipus='families' and idTipus=".$idAlumne;
							$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
							$ret2=$info['data'];
							
							$dire='./imagenes/fotos/';
							$tam=30;
							$n=$ret[0]['nomAlumne'];
							$n=str_replace(" ",",",$n);
							$exploded = explode(",",$n);
							$name2=$exploded[0].$exploded[1].$exploded[2].$exploded[3].$idAlumne; 
							$ret4="http://appalau.institutelpalau.com/imagenes/fotos/".$idAlumne.'_'.$name2.".jpg";
			}else
			{
				$ret['data']="Fail";
				$ret['tema']="Error, user blocked.";
			}
	}else{
		$ret['data']="Fail";
		$ret['tema']="Error, undefined user.";
	}
	echo "{".$ret3.", \"usuaris\":".json_encode($ret2).", \"foto\":\"".$ret4."\"}";
	
?>