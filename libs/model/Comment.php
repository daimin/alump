<?php
class ALump_Comment extends ALump_Model {
	
	
	
	function __construct($row){
		parent::__construct($row);
		$this->id = $this->get('id');
		$this->post_id = $this->get('post_id');
		$this->created = $this->get('created');
		$this->author = $this->get('author');
		$this->author_id = $this->get('author_id');
		$this->nickname = $this->get('nickname');
		$this->mail = $this->get('mail');
		$this->url = $this->get('url');
		$this->ip = $this->get('ip');
		$this->agent = $this->get('agent');
		$this->content = $this->get('content');
		$this->type = $this->get('type');
		$this->status = $this->get('status');
		$this->parent_id = $this->get('parent_id');
	}
	
  
    public $id = 0;
	public $post_id = 0;
	public $created = 0;
	public $author = 0;
	public $author_id = 0;
	public $mail = 0;
	public $url = 0;
	public $ip = 0;
	public $agent = 0;
	public $content = 0;
	public $type = 0;
	public $status = 0;
	public $parent_id = 0;
	
 	

	
	public static function getCommentsPage($postid, $commentsPageSize = False){
		$db = ALump_Db::getInstance();
		$ordersql = "`created` ".ALump::$options->commentsOrder;
		$db->select(ALump_Common::getTabName("comments"), null, array('where' => " post_id='$postid'", "order" => $ordersql));
		
		$comments = new ALump_Array();
		
		$rows = $db->fetch_array();
		
		foreach($rows as $row){
			$comments->add(new ALump_Comment($row));
		}
		return $comments;
	}
	
	public function nickName(){
		echo $this->nickname;
	}
	
	
	
	
}
?>