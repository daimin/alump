<?php


class ALump_Relation extends ALump_Model{
	public $post_id = 0;
	public $meta_id = 0;
	
	function __construct($row){
		parent::__construct($row);
		$this->post_id = $this->get('post_id');
		$this->meta_id = $this->get('meta_id');
	}
	
	public static function save($rel){
		$db = ALump_Db::getInstance();
		
		$db->replace(ALump_Common::getTabName("relation"), $rel->toArray());
		
	}
	
	public static function getPostsByMeta($mid, $order=""){
		$db = ALump_Db::getInstance();
		$conditions = array("where" => "`meta_id`='$mid'");
		if(!empty($order)){
			$conditions['order'] = $order;	
		}
		$db->select(ALump_Common::getTabName("relation"),array("post_id"), $conditions);
		$rows = $db->fetch_array();
		$rels = new ALump_Array();
		foreach($rows as $row){
		    $rels->add(new ALump_Relation($row));
		}
		
		return $rels;
	}
	
	public static function getMetasByPost($postid){
        $db = ALump_Db::getInstance();
		$db->select(ALump_Common::getTabName("relation"),array("meta_id"), array("where" => "`post_id`='$postid'"));
		$rows = $db->fetch_array();
		$rels = new ALump_Array();
		foreach($rows as $row){
			$rels->add(new ALump_Relation($row));
		}
		
		return $rels;
	}
	
	public static function removeByPostId($postid){
		$db = ALump_Db::getInstance();
		return $db->remove(ALump_Common::getTabName("relation"),"post_id='$postid'");
		
	}
	
	public static function removeByMetaId($metaid){
		$db = ALump_Db::getInstance();
		return $db->remove(ALump_Common::getTabName("relation"),"meta_id='$metaid'");
	
	}
	
	public static function updatePostMeta($postid, $metaid){
		$db = ALump_Db::getInstance();
		$db->update(ALump_Common::getTabName("relation"), array("meta_id"=>$metaid), "post_id='$postid'");
        
	}
	
	public static function getCountPostByMeta($meta, $status=1){
		$posts = self::getPostsByMeta($meta);
		$count = 0;
		foreach($posts->items() as $rel){
		    $post = ALump_Post::getPostById($rel->post_id);
			if($post->status == $status){
				$count++;
			}
		}
		
		return $count;
	}
}

?>