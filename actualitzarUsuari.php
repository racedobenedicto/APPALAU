<?php
	
header("Access-Control-Allow-Origin: *");
	if(!is_null($_GET['idUser']))
	{
		include "sql_client.php";
		$token=$_GET['token'];
		$direccio=$_GET['direccio'];
		$municipi=$_GET['municipi'];
		$codi_postal=$_GET['codi_postal'];
		$user=$_GET['usuari'];
		$telf=$_GET['tlf'];
		$email=$_GET['email'];
		$idUser=$_GET['idUser'];
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
		if(validarUser($idUser, $token, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2, &$idAlumne))
		{
					if($n==1)
					{
						$sql="UPDATE users SET ".$actualiza." WHERE idUser=".$idUser;
						$ret="{sql:".$sql."}";
						$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
					}
					if($n2==1)
					{
						$sql="UPDATE alumnes SET ".$actualiza2." WHERE idAlumne=".$idAlumne;
						$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
					}

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