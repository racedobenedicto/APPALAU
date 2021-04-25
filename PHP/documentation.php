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
			$sql="SELECT data, tema, nomProfessor, data_limit FROM professors, documentacio WHERE idAlumne=".$idAlumne." and professors.idProfessor=documentacio.idProfessor";
			$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
			$ret=$info['data'];
			$n=0;
			foreach($ret as $row)
			{

				$dades[$n]['data']=$row['data'];
				$dades[$n]['tema']=$row['tema'];
				$dades[$n]['msg']="Nova documentació a lliurar en el correu de tutoria";
				$dades[$n]['professor']=$row['nomProfessor'];
				$dades[$n]['venciment']=$row['data_limit'];
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