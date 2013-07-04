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
		$datas = self::_doWithPosts($rows, $fmt);
		
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
    
    private static function _doWithPosts($rows, $fmt){
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
        
        return $datas;
    }
    
    public static function getArchiveByType($type='month'){
        $db = ALump_Db::getInstance();
		$tarTab = ALump_Common::getTabName("posts");
		$db->query("select `id`, `created` from `$tarTab` where `type`='post' order by `created` desc");
		$rows = $db->fetch_array();
        $datas = self::_doWithPosts($rows, "Y-m-d");
        $archives = array();
        if($type == "year"){
           foreach($datas as $data){
               $kyear = $data['date']['year'];
               if(isset($archives[$kyear])){
                   $archives[$kmonth] = array_merge($archives[$kyear], $data['postIds']);
               }else{
                   $archives[$kyear] = $data['postIds'];
               }
               
           }
        }
        if($type == "month"){
            foreach($datas as $data){
               $kmonth = $data['date']['year'].$data['date']['month'];
               if(isset($archives[$kmonth])){
                  
                   $archives[$kmonth] = array_merge($archives[$kmonth], $data['postIds']);
               }else{
                   $archives[$kmonth] = $data['postIds'];
               }
               
           }
        }
        
        if($type == "date"){
            foreach($datas as $data){
                $kdate = $data['date']['year'].$data['date']['month'].$data['date']['date'];
               if(isset($archives[$kdate])){
                   $archives[$kmonth] = array_merge($archives[$kdate], $data['postIds']);
               }else{
                   $archives[$kdate] = $data['postIds'];
               }
               
           }
        }
        
        
        return $archives;
       
    }
    
    public static function archiveWithPost($conts, $pageno =0 ){
        $dates = $conts[0].$conts[1].$conts[2];
       
        $archives = False;
        $dlen = strlen($dates);
        
        if($dlen >= 4 && $dlen < 6){
            $archives = ALump_Archive::getArchiveByType('year');
        }else if($dlen >= 6 && $dlen < 8){
            
            $archives = ALump_Archive::getArchiveByType('month');
        }else if($dlen == 8){
            $archives = ALump_Archive::getArchiveByType('date');
        }else{
            return new ALump_Array();
        }
        
        $fArchives = False;
        
        if(isset($archives[$dates])){
            $fArchives = $archives[$dates];
            
        }else{
            return new ALump_Array();
        }
        
        
        
        $pagecount = $start = 0;
		$count = count($fArchives);
        $pageSize = ALump::$options->pageSize;
        if(empty($pageno)){
		    $pageno = 1;
		}
        
        $posts = new ALump_Array($count);
        
		if($count > $pageSize){
			$pagecount = floor(($count + $pageSize - 1) / $pageSize);
			if($pageno > $pagecount){
				$pageno = $pagecount;
			}
		    $start =  ($pageno- 1) * $pageSize;	
		}
        
        // 如果传递了$pageno那么就设置$pageno
		if(!empty($pageno)){
			$posts->pageNav->setPageno($pageno);
		}
        
        $fArchives = array_slice($fArchives , $start, $pageSize);
        foreach($fArchives as $archId){
			$posts->add(ALump_Post::getPostById($archId));
		}
        
        return $posts;
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