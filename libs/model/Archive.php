<?php
/**
 * 文章归档
 * @author daimin
 *
 */
class ALump_Archive extends ALump_Model {
	public $year = 0;
	public $month = "";
	public $date = "";
	public $name = "";
	public $postIds = array();
	public $count = 0;
	public $type = "month";
	

	function __construct(){
	}
	
	public static function getArchive($fmt,  $type='month', $postsListSize = False){
		$db = ALump_Db::getInstance();
		$tarTab = ALump_Common::getTabName("posts");
		$db->query("select `id`, `created` from `$tarTab` where `type`='post' order by `created` desc");
		$rows = $db->fetch_array();
		$datas = array();
		
		foreach($rows as $row){

			$dname = ALump_Date::format($row['created'], $fmt);
			
			if(isset($datas[$dname])){
				array_push($datas[$dname]['postIds'], $row['id']);
				$datas[$dname]["date"] = array(
						"year" => ALump_Date::format($row['created'], "Y"),
						"month" => ALump_Date::format($row['created'], "m"),
						"date" => ALump_Date::format($row['created'], "d"));
			}else{
				$datas[$dname]["postIds"] = array($row['id']);
				$datas[$dname]["date"] = array(
						"year" => ALump_Date::format($row['created'], "Y"),
						"month" => ALump_Date::format($row['created'], "m"),
						"date" => ALump_Date::format($row['created'], "d"));
			}
			
			
		}
		
		$count = 0;
		$archives = new ALump_Array();
		foreach($datas as $key=>$val){
			if($postsListSize != False && $count >= $postsListSize){
				break;
			}
			$arch = new ALump_Archive();
			$arch->year  = $val['date']["year"];
			$arch->month = $val['date']["month"];
			$arch->date  = $val['date']["date"];
			$arch->name = $key;
			$arch->type = $type;
			$arch->postIds = $val['postIds'];
			$archives->add($arch);
			$count++;
		}
		
		return $archives;
		
	}
	
	public function permalink(){
		if($this->type == 'month'){
			$this->permalink = ALump::$options->siteUrl('/archive/'.$this->year.'/'.$this->month.'/');
		}else if($this->type == "year"){
			$this->permalink = ALump::$options->siteUrl('/archive/'.$this->year.'/');
		}else{
			$this->permalink = ALump::$options->siteUrl('/archive/'.$this->year.'/'.$this->month.'/'.$this->date.'/');
		}
		
		echo $this->permalink;
	}
	
	
}

?>