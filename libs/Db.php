<?php
/**
    * 数据库操作类
    * @author daimin
    *
    */
class ALump_Db {
	private $mysqli = null;
	private $result = null;
	private static $db_cfg = null;
	private static $instance = null;
	private function __construct() {
		$this->mysqli = new mysqli ( Alump_Db::$db_cfg ['host'], Alump_Db::$db_cfg ['user'], 
				                     Alump_Db::$db_cfg ['password'], Alump_Db::$db_cfg ['database'],
				                     Alump_Db::$db_cfg ['port'] );
		
		/* check connection */
		if (mysqli_connect_errno ()) {
			printf ( "Connect failed: %s\n", mysqli_connect_error () );
			return null;
		}
		$this->mysqli->set_charset ( "utf8" );
	}
	
	public static function getInstance() {
		if (Alump_Db::$instance == null) {
			Alump_Db::$instance = new Alump_Db ();
		}
		return Alump_Db::$instance;
	}
	
	public static function init($db_cfg) {
		Alump_Db::$db_cfg = $db_cfg;
	}
	
	public function query($sql) {
		//Alump_Logger::log($sql);
		$this->result = $this->mysqli->query ( $sql );
		if (! $this->result) {
			Alump_Common::error ( "Mysql执行错误: $sql <br/>" . $this->mysqli->error );
		}
		return $this->result;
	}
	
	public function num_rows(){
		if(empty($this->result)) return False;
		return $this->result->num_rows;
	}
	
	public function fetch_array($type=MYSQL_ASSOC){
		if(empty($this->result)) return False;
		$rows = array();
		while ( $row = $this->result->fetch_array($type) ) {
			array_push($rows, $row);
		}
		return $rows;
	}
	
	public function fetch_one($type=MYSQL_ASSOC){
		if(empty($this->result)) return False;
		return $this->result->fetch_array ( $type );
	}
	
	
	public function select($tab,$params=null, $constraints=null){
		 if(empty($tab)){
		 	 return False;
		 }
		 if(empty($params)){
		 	$params = " * ";
		 }else{
		 	$params = implode ( ",", $params );
		 }
		 

		 $sql = "select $params from $tab";
		 if(isset($constraints['where'])){
		 	$sql .= " where ".$constraints['where'];
		 }
		 
		 if(isset($constraints['group'])){
		 	$sql .= " group by  ".$constraints['group'];
		 }
		 
		 if(isset($constraints['order'])){
		 	$sql .= " order by ".$constraints['order'];
		 }
		 
		 if(isset($constraints['limit'])){
		 	$sql .= " limit ".$constraints['limit'];
		 }
		 

		 return $this->query($sql);
		 
	}
	
	public function count($tab,$param=null, $constraints=null){
		if(empty($tab)){
			return False;
		}
		if(empty($param)){
			$param = " count(*)  as acount ";
		}else{
			$param = " count(`$param`) as acount ";
		}
			
	
		$sql = "select $param from $tab";
		if(isset($constraints['where'])){
			$sql .= " where ".$constraints['where'];
		}
			
		if(isset($constraints['group'])){
			$sql .= " group by  ".$constraints['group'];
		}
			
		if(isset($constraints['order'])){
			$sql .= " order by ".$constraints['order'];
		}
			
		if(isset($constraints['limit'])){
			$sql .= " limit ".$constraints['limit'];
		}
			
	
		$this->query($sql);
	    $row = $this->fetch_one();
	    if(!empty($row)){
	    	return $row['acount'];
	    }else{
	    	return 0;
	    }
			
	}
	
	
	public function insert($tab, $params) {
		if (empty ( $tab ) || empty ( $params )) {
			return False;
		}
	
		$keys = array_keys ( $params );
		$values = array_values ( $params );
		$keys = implode ( "`,`", $keys );
		$values = implode ( "','", $values );
		
		$sql = "insert into `$tab`(`$keys`) values('$values')";

		return $this->query($sql);
	}
	
	public function replace($tab, $params){
		if (empty ( $tab ) || empty ( $params )) {
			return False;
		}
		
		$keys = array_keys ( $params );
		$values = array_values ( $params );
		$keys = implode ( "`,`", $keys );
		$values = implode ( "','", $values );
		
		$sql = "replace into `$tab`(`$keys`) values('$values')";
		
		return $this->query($sql);
	}
	
	
	public function update($tab, $params, $where) {
		if (empty ( $tab ) || empty ( $params )) {
			return False;
		}
		$set_fields = array();
		foreach($params as $key=>$val){
			array_push($set_fields, "`$key` = '$val'");
		}
		$set_fields = implode ( ",", $set_fields );
		
		$sql = "update `$tab` set $set_fields where $where";
		
		return $this->query($sql);
	}
	
	public function remove($tab, $where){
		if (empty ( $tab ) ) {
			return False;
		}
		
		$sql = "delete from  `$tab` where $where";
		return $this->query($sql);
	}
	
	public function insert_id() {
		return $this->mysqli->insert_id;
	}
	
	public function close() {
		$this->mysqli->close ();
	}
	
	public function affected_rows(){
		return $this->mysqli->affected_rows;
	}
    
    public function getConn(){
        return $this->mysqli;
    }
    
    public function getDbSize(){
        $this->query("show table status from ".Alump_Db::$db_cfg ['database']);
        $rows = $this->fetch_array();
        $size = 0;
        foreach($rows as $row){
            $size += $row['Data_length'];
        }
        
        return $size;
    }
}
?>