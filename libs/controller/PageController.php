<?php

class ALump_PageController extends Alump_BaseController {
	
	private $_curPage = null;
	
	public static $PARAMS_COUNT = 4;
	
	
	function __construct(){
		parent::__construct();
		
	}
	
	public  function p($slug){
		
		$this->_curPage = ALump_Post::getPageBySlug($slug);
		$this->view("page.php");
	}
	
	
	public function permalink(){
		$this->_curPage->permalink();
		
	}
	
	public function title(){
		$this->_curPage->title();
	}
	
	public function author(){
		$author = $this->_curPage->author();
		if(!empty($author)){
			echo $author->name;
		}
		
	}
	
	public function date($fmt){
		echo ALump_Date::format($this->_curPage->created, $fmt);
	}
	
	
	
	public function commentsNum($no, $hasOne, $moreFmt){
		$comment_count = $this->_curPage->comment_count;
		if(empty($comment_count)){
			echo $no;
		}else{
			if($comment_count == 1){
				echo $hasOne;
			}else{
				echo sprintf($moreFmt, $comment_count);
			}
		}
		
	}
	
	public function comments(){
		return ALump::Lump("Comments_Page", "pageid=".$this->_curPage->id);
	
	}
	
	public function content($Prompt=""){
		echo ALump_Common::deEscape($this->_curPage->content);
	}
	
	public function excerpt($excerpt, $Prompt){
		$excStr = ALump_Common::deEscape($this->_curPage->content);
		$dom = str_get_html($excStr);
		if(!empty($dom)){
			echo ALump_Common::subStr($dom->root->text(), 0, $excerpt, $Prompt);
		}
		
	}
	
	public function allow($power){
		$attr = "allow_".$power;
	    return $this->_curPage->$attr;
	}
	
	public function respondId(){
		echo $this->_curPage->id;
		return $this->_curPage->id;
	}
	
	public function cancelReply(){
		echo '<a id="cancel-comment-reply-link" href="http://localhost/typecho/archives/47.html#respond-post-47" rel="nofollow" style="" onclick="return TypechoComment.cancelReply();">取消回复</a>';
	}
	
	public function commentUrl(){
		echo ALump_Common::url("/comment", $this->_curPage->getPermalink());
	}

}

?>