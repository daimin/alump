<?php
class ALump_PageNav {
	
	public $pageno = 0;
	public $pagecount = 0;
	public $pagesize = 0;
	public $itemcount = 0;
	
	public $startCount = 0;
	
	public $params = "";
	
	public function __construct($itemcount, $pagesize = False){
		if(ALump::$options->isAdmin()){
			$this->pagesize = ALump::$options->adminPageSize;
		}else{
			$this->pagesize = ALump::$options->pageSize;
		}
		
		if(!empty($pagesize)){
			$this->pagesize = $pagesize;
		}

		$this->itemcount = $itemcount;
		
		$this->pagecount = floor(($this->itemcount + $this->pagesize - 1) / $this->pagesize);
		$this->setPageno(ALump::$request->get("page"));
		
	}
	
	public function getStart(){
		if($this->pageno <= 0){
			$this->pageno = 1;
		}
		return $this->startCount = ($this->pageno - 1) * $this->pagesize; // 分页开始
	}
	
	public function limitSql(){
		return $this->getStart().','.$this->pagesize;
	}
	
	public function setPageno($pageno = 1){
		$this->pageno = $pageno;
		if(empty($this->pageno)){
			$this->pageno = 1;
		}
		
		if($this->pageno <= 0){
			$this->pageno = 1;
		}
		
		if($this->pageno > $this->pagecount){
			$this->pageno = $this->pagecount;
		}
	}
}

?>