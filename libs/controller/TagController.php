<?php

class ALump_TagController extends Alump_CategoryController {
		
	public static $PARAMS_COUNT = 4;
	
	
	function __construct(){
		parent::__construct();
	}
	
	function index($tag=False, $pageno = False){
		$this->_pageno = $pageno;
		$meta= ALump_Meta::getMetaBySlug($tag);
		$this->_data = ALump_Post::getPostsByMeta($meta, $pageno);
		$this->setArchiveTitle(array($meta->name));
		$this->getModuleUrl('index/'. $tag, '');
		$this->view("index.php");
	}
       
	
	
}

?>