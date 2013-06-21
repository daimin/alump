<?php
class ALump_Array {
	
	/*
	 * 内部数据一个Array
	 */
	private $data = null;
	
	public $pageNav = null;
	
	/*
	 * 模块的URL
	 */
	private $_moduleUrl = "";
	
	
	
	
	/*
	 * 该类数据未分页的总条数
	 * @param $type 数组的类型
	 * @param  $itemcount
	 */
	public function __construct( $itemcount=0){
		$this->data = array();
		$this->pageNav = new ALump_PageNav($itemcount);
	}
	/*
	 * 内部计数器
	 */
	private $_index = 0;
	
	/*
	 * 添加元素的数组尾部
	 */
	public function add($item){
		array_push($this->data, $item);
	}
	/*
	 * 获取指定索引的元素
	 */
	public function  get($index){
		if(isset($this->data[$index])){
			return $this->data[$index];
		}
		
		return False;
	}
	/*
	 * 返回数组的大小
	 */
	public function size(){
		return count($this->data);
	}
	
	
	/*
	 * 返回内部的数组数据
	 */
	public function items(){
		return $this->data;
	}
	/*
	 * 当前数组是否有元素
	 */
	public function have(){
		return !empty($this->data);
	}
	/*
	 * 下一个元素
	 */
	public function next(){
		$res = False;
		if(isset($this->data[$this->_index])){
			
			$res = $this->data[$this->_index];
		}
		$this->_index += 1;
		return $res;
	}
	
	public function index(){
		echo $this->_index;
		return $this->_index;
	}
	/*
	 * 轮换返回值，根据数组的当前序号
	 */
	public function alt($even, $add){
		if($this->_index % 2 == 0){
			echo $even;
			return $even;
		}
		echo $add;
		return $add;
	}
	/*
	 * 设置分页的链接参数
	 */
	public function setPageNavParams($params){
		$this->pageNav->params = $params;
	}
	/**
	 * 设置模块的URL
	 */
	public  function setModuleUrl($moduleUrl){
		$this->_moduleUrl = $moduleUrl;
	}
	/*
	 * 返回分页数据
	 */
	public function pageNav(){
		
		echo '<span class="pager" style="float:right;">共 '.$this->pageNav->itemcount.' 项&nbsp;&nbsp;
		<a class="link_button" href="?1=1'.$this->pageNav->params.'&page=1">&laquo;</a>
		<a class="link_button" href="?1=1'.$this->pageNav->params.'&page='.($this->pageNav->pageno - 1).'">&lsaquo;</a>
		第 <input type="text" value="'.$this->pageNav->pageno.'" id="page_input_2" class="page_input"/> 页,共 '.$this->pageNav->pagecount.' 页
				<a class="link_button" href="?1=1'.$this->pageNav->params.'&page='.($this->pageNav->pageno + 1).'">&rsaquo;</a>
				<a class="link_button" href="?1=1'.$this->pageNav->params.'&page='.($this->pageNav->pagecount).'">&raquo;</a>
  </span>';
	}
	
	private function _listChildComments($commentId){
		$ress = array();
		$childComments = ALump_Comment::getChildComments($commentId);
		
		if($childComments->have()){
			array_push($ress, '<div class="comment-children">');
			array_push($ress, '<ol class="comment-list">');
			
			while($comment = $childComments->next()){
				
				array_push($ress, '<li id="comment-'.$comment->id.'" class="comment-body comment-child comment-level-odd comment-odd comment-by-author">');
				array_push($ress, '<div class="comment-author">');
				array_push($ress, '<img class="avatar" src="'.ALump_Common::showGravatar($comment->mail).'" alt="'.$comment->author.'" width="32" height="32">');
				array_push($ress, '<cite class="fn"><a href="'.$comment->url.'" rel="external nofollow">'.$comment->author.'</a></cite>');
				array_push($ress, '</div>');
				array_push($ress, '<div class="comment-meta">');
				array_push($ress, '<a href="'.$this->_moduleUrl.'comment-page-'.$this->pageNav->pageno.'#comment-'.$comment->id.'">'.ALump_date::format($comment->created, Alump::$options->commentDateFormat).'</a>');
				array_push($ress, '</div>');
				array_push($ress, '<p>'.$comment->content.'</p>');
				array_push($ress, $this->_listChildComments($comment->id));
				array_push($ress, '<div class="comment-reply">');
				array_push($ress, '<a href="'.$this->_moduleUrl.'comment-page-'.$this->pageNav->pageno.'?replyTo='.$comment->id.'#respond-'.$comment->type.'-'.$comment->post_id.'" rel="nofollow" onclick="return ALumpComment.reply(\'comment-'.$comment->id.'\', '.$comment->id.');">回复</a>');
				array_push($ress, '</div>');
				array_push($ress, '</li>');
			}
			
			array_push($ress, '</li>');
			array_push($ress, '</ol>');
			array_push($ress, '</div>');
			
			return implode("", $ress);
		}
		
	}
	
	public function listComments(){
	
		$ress = array();
		array_push($ress, '<ol class="comment-list">');

		
		foreach($this->data as $comment){
			
			array_push($ress, '<li id="comment-'.$comment->id.'" class="comment-body comment-parent comment-odd">');
			array_push($ress, '<div class="comment-author">');
			array_push($ress, '<img class="avatar" src="'.ALump_Common::showGravatar($comment->mail).'" alt="'.$comment->author.'" width="32" height="32">');
			array_push($ress, '<cite class="fn"><a href="'.$comment->url.'" rel="external nofollow">'.$comment->author.'</a></cite>');
			array_push($ress, '</div>');
			array_push($ress, '<div class="comment-meta">');
			array_push($ress, '<a href="'.$this->_moduleUrl.'comment-page-'.$this->pageNav->pageno.'#comment-'.$comment->id.'">'.ALump_date::format($comment->created, Alump::$options->commentDateFormat).'</a>');
			array_push($ress, '</div>');
			array_push($ress, '<p>'.$comment->content.'</p>');
			array_push($ress, $this->_listChildComments($comment->id));
			array_push($ress, '<div class="comment-reply">');
			array_push($ress, '<a href="'.$this->_moduleUrl.'comment-page-'.$this->pageNav->pageno.'?replyTo='.$comment->id.'#respond-'.$comment->type.'-'.$comment->post_id.'" rel="nofollow" onclick="return ALumpComment.reply(\'comment-'.$comment->id.'\', '.$comment->id.');">回复</a>');
			array_push($ress, '</div>');
			array_push($ress, '</li>');
		}
		array_push($ress, '</ol>');
		
		echo implode("", $ress);
	}
	

}

?>