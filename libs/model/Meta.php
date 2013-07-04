<?php
/**
 * 和内容相关的数据
 * 包括标签和分类
 * @author daimin
 *
 */
class ALump_Meta extends ALump_Model {
	public $id = 0;
	public $name = "";
	public $slug = "";
	public $type = "tag";
	public $description = "";
	public $order = 0;
	
	function __construct($row){
		parent::__construct($row);
		$this->id = $this->get('id');
		$this->name = $this->get('name');
		$this->slug = $this->get('slug');
		$this->type = $this->get('type');
		$this->description = $this->get('description');
		$this->order = $this->get('order');
	}
	
	public static function splitTag($tagstr){
		if(empty($tagstr)){
			return False;
		}
		
		$tagId = array();
		
		$tags = explode(",", $tagstr);
		
		foreach($tags as $tag){
            $tag_id = False;
            $oldTag = self::getMetaByName($tag);
            
            if(!$oldTag){
                $tag_id = $oldTag->id;
            }else{
                $tag = new Alump_Meta(array(
					"name" => $tag,
					"slug" => $tag,
					"type" => "tag",
					));
            
                $tag_id = self::save($tag);
                // 更新slug，如果Tag的名称和slug一样的话
                if($tag->name == $tag->slug){
                    $tag->slug = $tag_id;
                    $tag->id = $tag_id;
                    self::update($tag);
                }
            }
			
            if(!empty($tag_id)){
                array_push($tagId, $tag_id);
            }
			
		}
		
		return $tagId;
	}
	
	public static function composeTags($tags){
        
		if(empty($tags)){
			return "";
		}
		$tagNames = array();
        
		foreach($tags->items() as $tag){
			array_push($tagNames, $tag->name);
		}
		
		return implode(",", $tagNames);
		
	}
	

	
	public static function getMetaById($cid){
		$db = ALump_Db::getInstance();
		$db->select(ALump_Common::getTabName("metas"), null, array("where"=>"`id`='$cid'"));
		return new ALump_Meta($db->fetch_one());
		
	}
	
	public static function getMetaByName($name, $type="tag"){
		$db = ALump_Db::getInstance();
		$db->select(ALump_Common::getTabName("metas"), null, array("where"=>"`type`='$type' and `name`='$name'"));
		$res = $db->fetch_one();
		if(empty($res)) return False;
		return new ALump_Meta($res);
	
	}
	
	public static function getMetaBySlug($slug){
		$db = ALump_Db::getInstance();
		$db->select(ALump_Common::getTabName("metas"), null, array("where"=>"`slug`='$slug'"));
		return new ALump_Meta($db->fetch_one());
	
	}
	
	/**
	 * 获取所有的分类
	 * @return ALump_Array
	 */
	public static function getCategorys($postsListSize = False, $status= 1){
		$db = ALump_Db::getInstance();
		if(empty($postsListSize)){
			$db->select(ALump_Common::getTabName("metas"), null, array("where"=>"`type`='category'","order"=>"`order` asc"));
		}else{
            $tarTabMeta = ALump_Common::getTabName("metas");
            $tarTabRel = ALump_Common::getTabName("relation");
			$db->query("SELECT a.id, a.name,a.slug,b.pcount FROM (SELECT id, `name`,`slug` FROM `$tarTabMeta` WHERE `type`='category') 
                       AS  a LEFT JOIN (SELECT COUNT(post_id) AS pcount,meta_id FROM `$tarTabRel` GROUP BY meta_id )b ON b.meta_id = a.id ORDER BY b.pcount DESC");
		}
		
		
		$rows = $db->fetch_array();
		$categorys = new ALump_Array();
		
		foreach($rows as $row){
			$cate = new ALump_Meta($row);
			if($status == ALump_Common::$PUBLISH){
		        $cate->count = ALump_Relation::getCountPostByMeta($cate->id);
		    }
			$categorys->add($cate);
		}
	
		return $categorys;
	
	}
	
	
	/**
	 * 获得所有的标签
	 */
	public static function getTags(){
		$db = ALump_Db::getInstance();
		$db->select(ALump_Common::getTabName("metas"), null, array("where"=>"`type`='tag'","order"=>"`order` asc"));
		$rows = $db->fetch_array();
		$tags = new ALump_Array();
		
		foreach($rows as $row){
			$tags->add(new ALump_Meta($row));
		}
		
		return $tags;
	}
	
	public static function removeById($metaid){
		$res = ALump_Relation::removeByMetaId($metaid);
		if(!$res){
			return $res;
		}
		$db = ALump_Db::getInstance();
		return $db->remove(ALump_Common::getTabName("metas"), "`id`='$metaid'");
	
	}
	
	
	public static function save($meta){
		$db = ALump_Db::getInstance();
		$ometa = self::getMetaByName($meta->name, $meta->type);
		if(!$ometa){
			$db->insert(ALump_Common::getTabName("metas"), $meta->toArray(array("id")));
			return $db->insert_id();
		}else{
			return $ometa->id;
		}
	}
	
	public static function update($meta){
		$db = ALump_Db::getInstance();
		$db->update(ALump_Common::getTabName("metas"), $meta->toArray(array("id")), "`id`='$meta->id'");
	}
	
	public static function getMetaByOrder($order){
	    $db = ALump_Db::getInstance();
		$db->select(ALump_Common::getTabName("metas"), null, array("where"=>"`order`='$order'"));
		return new ALump_Meta($db->fetch_one());
	}
	
	/**
	 * 更新排序
	 * @param  $metaid
	 * @param  $orderVal
	 */
	public static function updateOrder($metaid, $orderVal){
		$db = ALump_Db::getInstance();
		// 整理order
		$cates = self::getCategorys();
		for($i = 0, $len = $cates->size(); $i < $len; $i++ ){
			$mustOrder = $i + 1;
			$cate = $cates->get($i);

			if($mustOrder != $cate->order){
				$db->update(ALump_Common::getTabName("metas"), array("order"=>$mustOrder), "`id`='$cate->id'");
			}
			// 附带更新下count
			if($cate->count < 0){
				$count = $db->count(ALump_Common::getTabName("relation"),"post_id",array("where"=>"meta_id='$cate->id'"));
				$db->update(ALump_Common::getTabName("metas"), array("count" => $count),"`id`='$cate->id'");
			}
			
		}
		// 排序
		if(empty($orderVal)){
			$orderVal = intval(self::getMaxOrder()) + 1; 
			$db->update(ALump_Common::getTabName("metas"), array("order"=>$orderVal), "`id`='$metaid'");
		}else{
			$tarMeta = self::getMetaById($metaid);
			
			$db->select(ALump_Common::getTabName("metas"), array("id, `order`"),
					array("where"=>"`type`='category' and `order`<='$orderVal' and `order`>'$tarMeta->order'",
							"order"=>"`order` asc"));
			$rows = $db->fetch_array();
			// 更新当前行
			$curRows = $rows[count($rows) - 1];
			$db->update(ALump_Common::getTabName("metas"), array("order"=>$curRows['order']), "`id`='$metaid'");
			$inIds = array();
			foreach($rows as $row){
				array_push($inIds, $row['id']);
			}
			$inIds = implode(",", $inIds);
			if(!empty($inIds)){
				// 更新被替换行
				$tarTab = ALump_Common::getTabName("metas");
				$db->query("update $tarTab set `order`=`order`-1 where `id` in (".$inIds.")");
			}
			
		}

	}
	/**
	 * 更新meta下的文章数
	 * @param unknown_type $metaId
	 */
    /*
	public static function updateCount($metaId){
		$db = ALump_Db::getInstance();
		if(empty($metaId)){
			$count = $db->count(ALump_Common::getTabName("relation"),"post_id",array("where"=>"meta_id='$metaId'"));
			$db->update(ALump_Common::getTabName("metas"), array("count" => $count),"`id`='$metaId'");
		}else{
			//$db->update(ALump_Common::getTabName("metas"), array("count" => "`count`+1"),"`id`='$metaId'");
			$tarTab = ALump_Common::getTabName("metas");
			$db->query("update $tarTab set `count`=`count`+1 where `id`='$metaId'");
		}
	}*/
	
	/**
	 * 获得最大的排序号
	 * @return number|unknown
	 */
	public static function getMaxOrder(){
		$db = ALump_Db::getInstance();
		$tabName = ALump_Common::getTabName("metas");
		$sql = "select max(`order`) as morder from $tabName where `type`='category'";
		$db->query($sql);
		$row = $db->fetch_one();
		if(empty($row)){
			return 0;
		}
		
		return $row['morder'];
	}
	
	
	
	public static function getMetasByPostId($postId, $type="category"){
		if(empty($postId)){
			return False;
		}
		$rels = ALump_Relation::getMetasByPost($postId);
		
		if(empty($rels)){
			return False;
		}
		
		$insql = array();
		foreach($rels->items() as $rel){
			array_push($insql, $rel->meta_id);
		}
	
		if(!empty($insql)){
			$insql = '('.implode(",", $insql).')';
		}else{
            return False;
        }
		
		$db = ALump_Db::getInstance();
		$db->select(ALump_Common::getTabName("metas"), null, array("where"=>"`type`='$type' and `id` in $insql"));
		$rows = $db->fetch_array();
		
		if($rows){
			$categorys = new ALump_Array();
			foreach($rows as $row){
				$categorys->add(new ALump_Meta($row));
			}
			
			return $categorys;
		}else{
			return False;
		}
		
	}
	
	public function alt($if, $else){
		if(empty($this->name)){
			echo $if;
		}else{
			echo $else;
		}
	}
	
	public function permalink(){
		echo $this->getPermalink();
	}
	
	public function getPermalink(){
		if($this->type == "category"){
			$this->permalink = ALump::$options->siteUrl("/category/".$this->slug, False).'/';
		}else if($this->type == "tag"){
			$this->permalink = ALump::$options->siteUrl("/tag/".$this->slug, False).'/';
		}
		
		return $this->permalink;
	}
	
}

?>