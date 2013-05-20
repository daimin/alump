<?php

/**
 * 所有Model的父类，你不能实例化该对象
 * @author daimin
 *
 */
abstract class ALump_Model {
   public $data = null;
   
   public function __construct($row){
   	  $this->data = $row;
   }
   
   public function get($name){
   	  if(!empty($this->data)){
   	  	   if(isset($this->data[$name])){
   	  	   	  $val = $this->data[$name];
   	  	   	  unset($this->data[$name]) ;
   	  	   	  return $val;
   	  	   }else if (isset($this->$name)){
   	          return $this->$name;
   	       }
   	  }else if (isset($this->$name)){
   	      return $this->$name;
   	  }
   	  
   	  return null;
   }
   
   public function toArray($filteArr=array()){
   	  array_push($filteArr, "data");
   	  return ALump_Common::objectToArray($this, $filteArr);
   }
   
   public static function init(){
   	/*插入默认的分类*/
   	$db = ALump_Db::getInstance();
   	$tartab = ALump_Common::getTabName("metas");
   	$db->query("insert into `$tartab`(`name`,`type`,`slug`,`description`) values('默认分类','category','default','只是一个默认分类')");
   	$insertId = $db->insert_id();
   	
   	$db->query("update `$tartab` set `order`='$insertId' where `id`='$insertId'");
   }
   // 取得好看的链接
   public function getPermalink(){
   	 
   }
}

?>