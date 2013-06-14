<?php

class Alump_BaseController {
	
	public $options = null;
	
	protected $_data = null;
	protected $_type = null;
	protected $_themeForm = null;
	protected $_moduleUrl = "";
	
	protected $_remembers = array();
	
	public static $PARAMS_COUNT = 0;
	
	
	public function __construct(){
		$this->_themeForm = new ALump_ThemeForm();
		$this->options = ALump::$options;
		$this->getModuleUrl();
		$this->_setVisitUrls();
		
		Alump_Cookie::set(ALump_Common::$COOKIE_REMEMBER_KEY, serialize($this->_remembers));
	}
	
	private function _setVisitUrls(){
		$this->_remembers = unserialize(Alump_Cookie::get(ALump_Common::$COOKIE_REMEMBER_KEY));
		if($this->_remembers['lastUrls']){
			$this->_remembers['lastUrls'][count($this->_remembers['lastUrls']) % 10] = ALump::$request->server("REQUEST_URL");
		}
	}
	
	
	public function need($script){
		include ALump_Common::getTheme($script);
	}
	
	public function view($scriptName){
		include ALump_Common::getTheme($scriptName);
	}
	
	protected  function getModuleUrl($mname = False){
		$basename = get_class($this); // 传入当前对象得到类名
		
		$calss = explode("_", $basename);
		
		if(empty($mname)){
			$mname = "index";
		}
		$this->_moduleUrl = strtolower(substr($calss[1], 0, strpos($calss[1], "Controller"))).'/'.$mname.'/';
		
		
	}
		
	/**
	 * 文档标题
	 * @param unknown_type $cross
	 * @param unknown_type $p2
	 * @param unknown_type $sp
	 */
	public function archiveTitle($cross, $p2, $sp){
		//' &raquo; ', '', ' - '
		echo "";
	}
	
	public function header(){
		echo '
		<meta name="description" content="'.$this->options->description.'" />
		<meta name="keywords" content="'.$this->options->keywords.'" />
		<meta name="generator" content="'.ALump_Common::$VERSION_INFO.'" />
		<meta name="template" content="'.$this->options->theme.'" />
		<link rel="pingback" href="'.ALump_Common::url("/action/xmlrpc", $this->options->siteUrl).'" />
		<link rel="EditURI" type="application/rsd+xml" title="RSD" href="'.ALump_Common::url("/action/xmlrpc?rsd", $this->options->siteUrl).'" />
		<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="'.ALump_Common::url("/action/xmlrpc?wlw", $this->options->siteUrl).'" />
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="'.ALump_Common::url("/feed/", $this->options->siteUrl).'" />
		<link rel="alternate" type="application/rdf+xml" title="RSS 1.0" href="'.ALump_Common::url("/feed/rss/", $this->options->siteUrl).'" />
		<link rel="alternate" type="application/atom+xml" title="ATOM 1.0" href="'.ALump_Common::url("/feed/atom/", $this->options->siteUrl).'" />';
	}
	
	public function footer(){
		
		
	}
	
	public function is($whois){

		
		switch($whois){
			case "index":
				if(empty($this->_type) || $this->_type == "page"){
					return true;
				}
		}
	}
	
	public function alump($alump, $params = False){
		return ALump::Lump($alump, $params);
	}
	
	public function _getPageNavUrl($pageno){
		$pageNav = $this->_data->pageNav;
		if($pageno <= 0){
			$pageno = 1;
		}
		if($pageno > $pageNav->pagecount){
			$pageno = $pageNav->pagecount;
		}
		
		
		return ALump_Common::url('/'.$this->_moduleUrl.'/'. $pageno, $this->options->siteUrl);
	}
	
	protected  function _pageNav($prev = '&laquo;', $next = '&raquo;', $splitPage = 3, $splitWord = '...', $pageno){		
		
		$pageNav = $this->_data->pageNav;
		
		$pageNav->setPageno($pageno);
		$curPage = $pageNav->pageno;
		

		$double_splitPage = 2 * $splitPage;
		
		$prev_end = 0;
		
		$pageArr = array();
		array_push($pageArr, '<li><a class="prev" href="'.$this->_getPageNavUrl( $pageNav->pageno - 1).'">'.$prev.'</a></li>');
		if($splitPage > 0){
			if($curPage > $double_splitPage){ //开始前分割
				array_push($pageArr, '<li><a class="prev" href="'.$this->_getPageNavUrl(1).'">1</a></li>');
				array_push($pageArr, '<li>'.$splitWord.'</li>');
				$start = $curPage - $splitPage - 1;
				$start = $start > 0 ? $start : 1;
				$prev_end = $double_splitPage+1;
				for($i = $start; $i <= $prev_end; $i++){
					$pageArr[$i] = '<li><a class="prev" href="'.$this->_getPageNavUrl($i).'">'.$i.'</a></li>';
				}
					
				if($prev_end < $pageNav->pagecount){
					$end_split = $double_splitPage + 2;
					if($pageNav->pagecount >= $end_split && ($curPage + $splitPage + 2)  < $pageNav->pagecount){//开始后切割
						if($curPage > $double_splitPage){
								
							$start = $curPage + $splitPage + 1;
							$start = $start > $pageNav->pagecount?$pageNav->pagecount:$start;
							$end = $start + $splitPage;
							$end = $end > $pageNav->pagecount?$pageNav->pagecount:$end;
								
							for($i = $start; $i <= $end; $i++){
								$pageArr[$i] = '<li><a class="prev" href="'.$this->_getPageNavUrl($i).'">'.$i.'</a></li>';
							}
						}
			
						array_push($pageArr, '<li>'.$splitWord.'</li>');
						array_push($pageArr, '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav->pagecount).'">'.$pageNav->pagecount.'</a></li>');
			
					}else{
						for($i = $prev_end+1; $i <= $pageNav->pagecount; $i++){
							$pageArr[$i] = '<li><a class="prev" href="'.$this->_getPageNavUrl($i).'">'.$i.'</a></li>';
						}
					}
				}
					
			}else{ // 不前分割的情况下
				$prev_end = $pageNav->pagecount >= $splitPage ? ($splitPage + 1 + $curPage):$pageNav->pagecount;
				$prev_end = $prev_end > $pageNav->pagecount ? $pageNav->pagecount :$prev_end;
					
				for($i = 1; $i <= $prev_end; $i++){
					$pageArr[$i] = '<li><a class="prev" href="'.$this->_getPageNavUrl($i).'">'.$i.'</a></li>';
				}
					
				if($prev_end < $pageNav->pagecount){
					$end_split = $double_splitPage + 2;
					if($pageNav->pagecount >= $end_split && ($curPage + $splitPage + 2)  < $pageNav->pagecount){//开始后切割
							
						if($curPage > $double_splitPage){
								
							$start = $curPage + $splitPage + 1;
							$start = $start > $pageNav->pagecount?$pageNav->pagecount:$start;
							$end = $start + $splitPage;
							$end = $end > $pageNav->pagecount?$pageNav->pagecount:$end;
								
							for($i = $start; $i <= $end; $i++){
								$pageArr[$i] = '<li><a class="prev" href="'.$this->_getPageNavUrl($i).'">'.$i.'</a></li>';
							}
						}
			
						array_push($pageArr, '<li>'.$splitWord.'</li>');
						array_push($pageArr, '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav->pagecount).'">'.$pageNav->pagecount.'</a></li>');
			
					}else{
						for($i = $prev_end+1; $i <= $pageNav->pagecount; $i++){
							$pageArr[$i] = '<li><a class="prev" href="'.$this->_getPageNavUrl($i).'">'.$i.'</a></li>';
						}
					}
				}
			}
			
			$pageArr[$curPage] = '<li class="current"><a class="prev" href="'.$this->_getPageNavUrl($curPage).'">'.$curPage.'</a></li>';
		}
		
		
		array_push($pageArr, '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav->pageno + 1).'">'.$next.'</a></li>');
		
		
		echo '<ol class="page-navigator">';
		echo implode("", $pageArr);
		echo '</ol>';
	}
	
	public function hasLogin(){
		return ALump_Common::isLogined();
	}
	
	public function loginUser(){
		$username = ALump_Common::loginUser();	
		return ALump_User::getUserByName($username);;
	}
	

	
	
}

?>