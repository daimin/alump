<?php
class ALump_Post extends ALump_Model {
	public $id = null;
	public $title = "";
	public $slug = "";
	public $created = 0;
	public $modified = 0;
	public $content = 0;
	public $order = 0;
	public $author_id = 0;
	public $type = "post";
	public $status = 1;
	public $password = "";
	public $view_count = 0;
	public $comment_count = 0;
	public $allow_comment = 1;
	public $allow_feed = 1;
	public $parent_id = 0;
	
	
	private $_author = null;
	private $_category = null;
	private $_tags = null;
	
	
	function __construct($row){
		parent::__construct($row);
		$this->id = $this->get('id');
		$this->title = $this->get('title');
		$this->slug = $this->get('slug');
		$this->created = $this->get('created');
		$this->modified = $this->get('modified');
		$this->content = $this->get('content');
		$this->order = $this->get('order');
		$this->author_id = $this->get('author_id');
		$this->type = $this->get('type');
		$this->status = $this->get('status');
		$this->password = $this->get('password');
		$this->view_count = $this->get('view_count');
		$this->comment_count = $this->get('comment_count');
		$this->allow_comment = $this->get('allow_comment');
		$this->allow_feed = $this->get('allow_feed');
		$this->parent_id = $this->get('parent_id');
	}
	
	/**
	 * 置顶，修改其Order就是了
	 * 将ORDER小于该POST的order都+1，大于的不变，然后将该POST放到第一个
	 **/
	public static function postOnTop($postid){
		$db = ALump_Db::getInstance();
		$tartab = ALump_Common::getTabName("posts");
		$db->select($tartab,
				array(
				  "order,id"
				),
				array(
				  "where" => "`type`='post'",
				  "order" => "`order` asc"
				));
		$posts = $db->fetch_array();
		foreach($posts as $post){
			if($post['id'] == $postid){
				$db->update($tartab, array("order"=>"0"),array("where"=>"`id`='$postid'"));
				break;
			}else{
				$sql = "update `$tartab` set `order`=`order`+1 where `id`='".$post['id']."'";
				$db->query($sql);
			}
		}
	}
	
	public static function save($post){
		$db = ALump_Db::getInstance();
		
		$db->insert(ALump_Common::getTabName("posts"), $post->toArray(array("id")));
		
		return $db->insert_id();
	}
	
	
	public static function update($post){
		$db = ALump_Db::getInstance();
		$db->update(ALump_Common::getTabName("posts"), $post->toArray(array("id")), "`id`='$post->id'");
	}
	/**
	 * 更新缩略名
	 * @param unknown_type $postid
	 * @param unknown_type $slug
	 */
	public static function updateSlug($postid, $slug){
		$db = ALump_Db::getInstance();
		if(empty($slug)){
			$slug = $postid;
		}else{
			$count = $db->count(ALump_Common::getTabName("posts"),null,array("where"=>"slug='$slug'"));
			
			if($count > 0){
				$slug = $slug.'-'.$count;
			}
		}
		
		$db->update(ALump_Common::getTabName("posts"),array("slug"=>$slug), "`id`='$postid'");
		
	}
	
	/**
	 * 更新附件
	*/
	public static function updateAttachs($parentId, $attachs){
		if(empty($attachs)){
			return;
		}
		$db = ALump_Db::getInstance();
		$attachs = explode("|", $attachs);
		foreach($attachs as $attach){
			if(!empty($attach)){
				$db->update(ALump_Common::getTabName("posts"), array("parent_id"=>$parentId), "`slug`='$attach'");
			}
			
		}
		
	}
	
	public static function removeById($postid){
		$res = ALump_Relation::removeByPostId($postid);
		if(!$res){
			return $res;
		}
		$db = ALump_Db::getInstance();
		return $db->remove(ALump_Common::getTabName("posts"), "`id`='$postid'");
		
	}
	/**
	 * 更新到草稿箱
	 * @param unknown_type $postid
	 */
	public static function updateStatus($postid, $status){
		$db = ALump_Db::getInstance();
		return $db->update(ALump_Common::getTabName("posts"), array('status'=>$status), "`id`='$postid'");
	}
	/**
	 * 后台管理POST
	 * @param unknown_type $status
	 * @return ALump_Array
	 */
	public static function getPostsAdmin($status = 1, $pageno=0){
		$db = ALump_Db::getInstance();
		
		$keyword = ALump::$request->get("keyword");
		$where = "`type`='post' and `status`='".$status."' ";
		if(!empty($keyword)){
			$where .= " and `title` like '%$keyword%'";
		}
		$category = ALump::$request->get("category");
		if(!empty($category)){
			// 先选择改分类下的所有的POST
			$category = ALump_Meta::getMetaBySlug($category);
			$rels = ALump_Relation::getPostsByMeta($category->id);
			
			if(!empty($rels)){
				$resids = array();
				foreach($rels->items() as $rel){
					array_push($resids, $rel->post_id);
				} 
				if(!empty($resids)){
					$rels = '('.implode(",", $resids).')';
					$where .= " and `id` in $rels";
				}

			}

		}
		
		$count = $db->count(ALump_Common::getTabName("posts"),null,array("where"=>$where));
		$posts = new ALump_Array($count);
		// 如果传递了$pageno那么就设置$pageno
		if(!empty($pageno)){
			$posts->pageNav->setPageno($pageno);
		}
		// 设置分页的链接参数
		$posts->setPageNavParams("&keyword=".ALump::$request->get("keyword")."&category=".ALump::$request->get("category"));
		
		$db->select(ALump_Common::getTabName("posts"), null, array(
				  "where" => $where,
				  "order" => "`created` desc",
				  "limit" => $posts->pageNav->limitSql()));
		$rows = $db->fetch_array();
		
		foreach($rows as $row){
			$posts->add(new ALump_Post($row));
		}
	
		return $posts;
	}
	
	/**
	 * 获得最近发表的文章
	 */
	public static function getRecentPosts($pageno, $postsListSize = null){
		$posts = null;
		if(empty($postsListSize)){
			$posts = self::getPostsAdmin(ALump_Common::$PUBLISH, $pageno);
		}else{
			$posts = self::getPostsList($postsListSize);
		}
		
		
		return $posts;
	}
	
	
	public static function getPostsList($postsListSize){
		$db = ALump_Db::getInstance();
	
		$db->select(ALump_Common::getTabName("posts"), null, array(
				  "where" => "`type`='post' and  `status`='".ALump_Common::$PUBLISH."'",
				  "order" => "`created` desc",
				  "limit" => "0,$postsListSize"));
		$rows = $db->fetch_array();
		
		$posts = new ALump_Array();
		
		foreach($rows as $row){
			$post = new ALump_Post($row);
			$post->getPermalink();
			$posts->add($post);
		}
		
		return $posts;
	}
	
	/**
	 * 后台管理页面
	 * @param unknown_type $status
	 */
	public static function getPagesAdmin(){
		$db = ALump_Db::getInstance();
		
		$keyword = ALump::$request->get("keyword");
		$where = "`type`='page'";
		if(!empty($keyword)){
			$where .= " and `title` like '%$keyword%'";
		}
		
		$count = $db->count(ALump_Common::getTabName("posts"),null,array("where"=>$where));
		$pages = new ALump_Array($count);
		
		
		$db->select(ALump_Common::getTabName("posts"), null, array(
				"where" => $where,
				"order" => "`order` asc"));
		$rows = $db->fetch_array();
		
		foreach($rows as $row){
			$pages->add(new ALump_Post($row));
		}
		
		return $pages;
	}
	
	public static function getPages(){
		$db = ALump_Db::getInstance();
		$db->select(ALump_Common::getTabName("posts"), null, array(
				"where" => "`type`='page'",
				"order" => "`order` asc"));
		$pages = new ALump_Array();
		$rows = $db->fetch_array();
		foreach($rows as $row){
			$pages->add(new ALump_Post($row));
		}
		
		return $pages;
		
	}
	
	/**
	 * 根据ID得到POST
	 * @param unknown_type $id
	 */
	public static function getPostById($id){
		$db = ALump_Db::getInstance();
		$db->select(ALump_Common::getTabName("posts"), null, array(
				"where" => "`id`='$id'"));
		$row = $db->fetch_one();
		
		return new ALump_Post($row);
	}
	
	/**
	 * 当前POST的作者信息
	 */
	public function author(){
		if($this->_author == null){
			$this->_author = ALump_User::getUserById($this->author_id);
		}
		return $this->_author;
	}
	
	/**
	 * 当前POST的类别信息
	 */
	public function category(){
		if($this->_category == null){
			$this->_category = ALump_Meta::getMetasByPostId($this->id);
            
			if(!empty($this->_category) && $this->_category->size() > 0){
				$this->_category = $this->_category->get(0);
			}
		}
		return $this->_category;
	}

	/**
	 * 当前POST的标签信息
	 * @return NULL
	 */
	public function tags(){
		if($this->_tags == null){
			$this->_tags = ALump_Meta::getMetasByPostId($this->id, "tag");
		}
		return $this->_tags;
	}
	
	/**
	 * 当前POST的标签信息
	 * @return NULL
	 */
	public function tagNames(){
		return ALump_Meta::composeTags($this->tags());
	}
	
	public function allowComment($tag){
		if($this->allow_comment){
			echo $tag;
		}
		
		return $this->allow_comment;
	}
	
	public function allowFeed($tag){
		if($this->allow_feed){
			echo $tag;
		}
	
		return $this->allow_feed;
	}
	
	public function noAdvance($tag){
		if(empty($this->password)){
			echo $tag;
		}
		
		return empty($this->password);
	}
	
	/**
	 * 更新排序
	 * @param  $metaid
	 * @param  $orderVal
	 */
	public static function updateOrder($postid, $orderVal){
		$db = ALump_Db::getInstance();
		// 整理order
		$pages = self::getPagesAdmin();
		for($i = 0, $len = $pages->size(); $i < $len; $i++ ){
			$mustOrder = $i + 1;
			$page = $pages->get($i);
	
			if($mustOrder != $page->order){
				$db->update(ALump_Common::getTabName("posts"), array("order"=>$mustOrder), "`id`='$page->id'");
			}
				
		}
		// 排序
		if(empty($orderVal)){
			$orderVal = intval(self::getMaxOrder()) + 1;
			$db->update(ALump_Common::getTabName("posts"), array("order"=>$orderVal), "`id`='$postid'");
		}else{
			$tarPost = self::getPostById($postid);
				
			$db->select(ALump_Common::getTabName("posts"), array("id, `order`"),
					array("where"=>"`type`='page' and `order`<='$orderVal' and `order`>'$tarPost->order'",
							"order"=>"`order` asc"));
			$rows = $db->fetch_array();
			// 更新当前行
			$curRows = $rows[count($rows) - 1];
			$db->update(ALump_Common::getTabName("posts"), array("order"=>$curRows['order']), "`id`='$postid'");
			$inIds = array();
			foreach($rows as $row){
				array_push($inIds, $row['id']);
			}
			$inIds = implode(",", $inIds);
			if(!empty($inIds)){
				// 更新被替换行
				$tarTab = ALump_Common::getTabName("posts");
				$db->query("update $tarTab set `order`=`order`-1 where `id` in (".$inIds.")");
			}
				
		}
	
	}
	
	/**
	 * 获得最大的排序号
	 * @return number|unknown
	 */
	public static function getMaxOrder(){
		$db = ALump_Db::getInstance();
		$tabName = ALump_Common::getTabName("post");
		$sql = "select max(`order`) as morder from $tabName where `type`='page'";
		$db->query($sql);
		$row = $db->fetch_one();
		if(empty($row)){
			return 0;
		}
	
		return $row['morder'];
	}
	
	public function onDraft($with){
		if($this->status == ALump_Common::$DRAFT){
			echo $with;
		}
	}
	/*
	 *  // 变量输出函数 
	 */
	public function title(){
		echo $this->title;
	}
	
	public function slug(){
		echo $this->slug;
	}
	
	public function permalink(){
		$this->permalink = ALump::$options->siteUrl($this->slug).ALump::$options->suffix;
		echo $this->permalink;
	}
	
	public function getPermalink(){
		$this->permalink = ALump::$options->siteUrl($this->slug).ALump::$options->suffix;
		return $this->permalink;
	}
	
	/*
	 * // 变量输出函数 结束
	 */
	
	public function __get($property){
		switch($property){
			case 'title':	
		    case 'content':
			case 'slug':
			case 'password':
				return ALump_Common::deEscape($this->$property);
		}
		
		return $this->$property;
	}
	
	
	
}

?>