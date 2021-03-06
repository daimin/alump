<?php

class ALump_CategoryController extends Alump_BaseController {
		
	public static $PARAMS_COUNT = 4;
	
	
	function __construct(){
		parent::__construct();
	}
	
	function index($category=False, $pageno = False){
		$this->_pageno = $pageno;
		$meta= ALump_Meta::getMetaBySlug($category);
		
		$this->_data = ALump_Post::getPostsByMeta($meta, $pageno);
		$this->setArchiveTitle(array($meta->name));
		$this->getModuleUrl('index/'. $category, '');
		$this->view("index.php");
	}
       
	
	public function next(){
		$this->_curPost = $this->_data->next();
		if(empty($this->_curPost)) return false;
		return true;
	}
	
	public function permalink(){
		$this->_curPost->permalink();
	}
	
	public function title(){
		$this->_curPost->title();
	}
	
	public function author(){
		$author = $this->_curPost->author();
		if(!empty($author)){
			echo $author->name;
		}
		
	}
	
	public function date($fmt){
		echo ALump_Date::format($this->_curPost->created, $fmt);
	}
	
	public function category(){
		$category = $this->_curPost->category();
		if(!empty($category)){
			$permalink = $category->getPermalink();
			echo '<a href="'.$permalink.'">'.$category->name.'</a>';
		}
	}
	
	public function commentsNum($no, $hasOne, $moreFmt){
		$comment_count = $this->_curPost->comment_count;
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
	
	public function content($Prompt=""){
		echo ALump_Common::deEscape($this->_curPost->content);
	}
	
	public function excerpt($excerpt, $Prompt){
		$excStr = ALump_Common::deEscape($this->_curPost->content);
		$dom = str_get_html($excStr);
		if(!empty($dom)){
			echo ALump_Common::subStr($dom->root->text(), 0, $excerpt, $Prompt);
		}
		
	}
	
	public function pageNav($prev = '&laquo;', $next = '&raquo;', $splitPage = 3, $splitWord = '...'){
		parent::_pageNav($prev, $next, $splitPage, $splitWord, $this->_pageno);
	}
}

?>