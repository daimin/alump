<?php

class ALump_SearchController extends ALump_CategoryController {
		
	public static $PARAMS_COUNT = 4;
	
	
	function __construct(){
		parent::__construct();
	}
	
	function index($keyword = False, $pageno = False){
		$this->_pageno = $pageno;
        if(empty($keyword)){
            $keyword = ALump::$request->request("s");
        }else{
            $keyword = urldecode($keyword);
        }
		
		$this->_data = ALump_Post::getPostByKeyword($keyword, $pageno);
        
		$this->setArchiveTitle(array($keyword));
        
		$this->getModuleUrl('index/'. $keyword, '');
		$this->view("index.php");
	}
       
	
	
}

?>