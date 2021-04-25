<?php
class sql_server{
	static private $mysqli=null;
	static private $info=array
	(
		'num_rows' => null,
		'fields' => null,
		'data' => null,
		'state' => null
	);
	static private $connection_info = array();
	
	function __construct($host, $user, $pass, $db)
	{
			self::$connection_info = array('host' => $host, 'user' => $user, 'pass' => $pass, 'db' => $db);
	}
	
	function __destruct()
	{
			if(is_resource(self::$mysqli)) mysql_close(self::$mysqli);
	}
		
	public function query()
	{
			return self::$info['query'];
	}
		
	public function num_rows()
	{
		return self::$info['num_rows'];
	}
		
	public function fields()
	{
		return self::$info['fields'];
	}

	static private function set($field, $value)
	{
			self::$info[$field] = $value;
	}
		
	static private function connection(){
		if(!is_resource(self::$mysqli) || empty(self::$mysqli)){
			$mysqli = new mysqli(self::$connection_info['host'], self::$connection_info['user'], self::$connection_info['pass'], self::$connection_info['db']);
			if(!$mysqli->connect_errno){
				self::$mysqli = $mysqli;
				$mysqli->set_charset('utf8');
			}else{
				self::$info['state']="BBDD";
				throw new Exception('');
			}
		}
		return self::$mysqli;
	}	
	
	public function executeQuery($sql, $return = 0)
	{
			try{
				$mysqli = self::connection();
			}catch (Exception $e)
			{
				throw new Exception('');
			}
			$result = $mysqli->query($sql);
			if($result->num_rows>0){
				self::set('num_rows', $result->num_rows);
				self::set('state','success');
				$return=1;
			}
			if($return==1)
			{				
				if(preg_match('/LIMIT 1/', $sql)){
					$data = $result->fetch_assoc();
					$info_campo = $result->fetch_fields();
					$nfield=0;
					foreach ($info_campo as $valor)
					{
						$field[$nfield]=$valor->name;
						$nfield++;
					}	
					$result->free();
					self::set('fields', $field);
					self::set('data', $data);
					return self::$info;
				}else{
					$data = array();
					$info_campo = $result->fetch_fields();
					$nfield=0;
					foreach ($info_campo as $valor)
					{
						$field[$nfield]=$valor->name;
						$nfield++;
					}					
					while($row = $result->fetch_assoc())
					{
						$data[] = $row;
					}
					$result->free();
					self::set('fields', $field);
					self::set('data', $data);
					return self::$info;
				}
			}else{
				self::$info['state']="SQL";
				return self::$info;
			}
			return self::$info;		
	}
}
?>