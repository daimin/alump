<?php

class ALump_ArchiveController extends Alump_CategoryController {
	
    private $_pageNoMark = "page-";
	
	function __construct(){
	    parent::__construct();
	}
	
	function index($p1=False, $p2 = False, $p3 = False, $p4 = False){
            if(empty($p1) && empty($p2) && empty($p3)){
                $this->say404();
            }
            $action_url = "";
           // 检测一下当前为何种类别
            $year = $month = $date = "";
            $pageno = 0;
            if(empty($p1)){
                $this->say404();
            }else{
                $p = $this->_isArchivePage($p1);
                if(!empty($p)){
                    $pageno = $p;
                }else{
                    $year = $p1;
                    $action_url .= $year;
                }
                
            }
            
            if(!empty($p2)){
                $p = $this->_isArchivePage($p2);
                if(!empty($p)){
                    $pageno = $p;
                }else{
                    $month = $p2;
                    $action_url .= '/'.$month;
                }
            }
            
            if(!empty($p3)){
                $p = $this->_isArchivePage($p3);
                if(!empty($p)){
                    $pageno = $p;
                }else{
                    $date = $p3;
                    $action_url .= '/'.$date;
                }
                
            }
            
            $p = $this->_isArchivePage($p4);
            if(!empty($p)){
                $pageno = $p;
            }

                  
            $this->_data = ALump_Archive::archiveWithPost(array($year, $month, $date),$pageno);
            $this->_pageno = $pageno;
            $this->setArchiveTitle(array($year, $month, $date));
            
            $this->setPagenoMark($this->_pageNoMark);
            $this->getModuleUrl('index/'.$action_url, '');
            
            $this->view("index.php");
	}
    
    /**
     * 判断是否是分页参数
     * @param type $p
     * @return boolean
     */
    private function _isArchivePage($p){
        if(strpos($p, $this->_pageNoMark) === 0){
            return substr($p, strlen($this->_pageNoMark));
        }
        
        return False;
    }
    
    
       
	
}

?>