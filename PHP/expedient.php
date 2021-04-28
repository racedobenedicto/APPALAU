<?php
	
header("Access-Control-Allow-Origin: *");
	if(!is_null($_GET['idUser']))
	{
		include "sql_client.php";
			$token=$_GET['token'];
			$idUser=$_GET['idUser'];

			if(validarUser($idUser, $token, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2, &$idAlumne))
			{
							//Absències
							$sql="SELECT dia as data, hora, comentari FROM asistencies_incidencies, dates WHERE idAlumne=".$idAlumne." and dia=dates.data and incidencia='F' ORDER BY idData";
							$info=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
							$ret2=$info['data'];
							$n=0;
							$data[$n]=$ret2[$n]['data'];
							foreach($ret2 as $row)
							{
								$absencies[$row['data']]["H".$row['hora']]=$row['comentari'];
								if($data[$n]!=$row['data'])
								{
									$n++;
									$data[$n]=$row['data'];
								}
							}
							for($i=0;$i<=$n;$i++)
							{
								$ret3[$i]['data']=$data[$i];
								if($absencies[$data[$i]]["H1"]!=null){
									$ret3[$i]['H1']=$absencies[$data[$i]]["H1"];
								}else{
									$ret3[$i]['H1']=' ';
								}
								if($absencies[$data[$i]]["H2"]!=null){
									$ret3[$i]['H2']=$absencies[$data[$i]]["H2"];
								}else{
									$ret3[$i]['H2']=' ';
								}
								if($absencies[$data[$i]]["H3"]!=null){
									$ret3[$i]['H3']=$absencies[$data[$i]]["H3"];
								}else{
									$ret3[$i]['H3']=' ';
								}
								if($absencies[$data[$i]]["H4"]!=null){
									$ret3[$i]['H4']=$absencies[$data[$i]]["H4"];
								}else{
									$ret3[$i]['H4']=' ';
								}
								if($absencies[$data[$i]]["H5"]!=null){
									$ret3[$i]['H5']=$absencies[$data[$i]]["H5"];
								}else{
									$ret3[$i]['H5']=' ';
								}
								if($absencies[$data[$i]]["H6"]!=null){
									$ret3[$i]['H6']=$absencies[$data[$i]]["H6"];
								}else{
									$ret3[$i]['H6']=' ';
								}
							}
							$sql="SELECT dia as data, nomProfessor as profesor, text as tipificacio, comentari as detall FROM asistencies_incidencies, dates, asistencies_codi, professors WHERE idAlumne=".$idAlumne." and dia=dates.data and asistencies_incidencies.incidencia='O' and asistencies_incidencies.codi=asistencies_codi.idCodi and professors.idProfessor=asistencies_incidencies.idProfessor ORDER BY idData DESC";
							$info2=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
							$observacions=$info2['data'];
							$sql="SELECT dia as data, nomProfessor as profesor, text as tipificacio, comentari as detall FROM asistencies_incidencies, dates, asistencies_codi, professors WHERE idAlumne=".$idAlumne." and dia=dates.data and asistencies_incidencies.incidencia='A' and asistencies_incidencies.codi=asistencies_codi.idCodi and professors.idProfessor=asistencies_incidencies.idProfessor ORDER BY idData DESC";
							$info2=enviar_consulta($sql, $ip_server_v2, $server_user_v2, $pass_v2, $bbdd_v2);
							$incidencies=$info2['data'];
			}else
			{
				$ret['data']="Fail";
				$ret['tema']="Error, user blocked.";
				$ret['sql']=$sql;
			}
	}else{
		$ret['data']="Fail";
		$ret['tema']="Error, undefined user.";
		$ret['sql']=$sql;
	}
	echo "{\"absencies\":".json_encode($ret3).",\"observaciones\":".json_encode($observacions).", \"incidencias\":".json_encode($incidencies)."}";
	
?>