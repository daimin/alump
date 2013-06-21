<?php

class Alump_BaseController {
	
	public $options = null;
	
	protected $_data = null;
	
	protected $_themeForm = null;
	protected $_moduleUrl = "";
	
	protected $_comment_no = 0;
	protected $_pageno = 1;
	
	private $_pagePrifix = '';
	
	protected $_remembers = array();
	
	public static $PARAMS_COUNT = 0;
	
	protected $_curPost  = null;
	
	
	public function __construct(){
		$this->_themeForm = new ALump_ThemeForm();
		$this->options = ALump::$options;
		$this->getModuleUrl();
		$this->_setVisitUrls();
		
		Alump_Cookie::set(ALump_Common::$COOKIE_REMEMBER_KEY, serialize($this->_remembers));
	}
	
	private function _setVisitUrls(){
		$this->_remembers = unserialize(Alump_Cookie::get(ALump_Common::$COOKIE_REMEMBER_KEY));
		
		if(empty($this->_remembers)){
			$this->_remembers = array();
		}
		if(isset($this->_remembers['lastUrls'])){
			$urllen = count($this->_remembers['lastUrls']);
			if($urllen >= 10){
				for($i = 0 ; $i <= $urllen-10; $i++){
					array_shift($this->_remembers['lastUrls']);
				}
				array_push($this->_remembers['lastUrls'], ALump::$request->server("REQUEST_URI"));
			}else{
				array_push($this->_remembers['lastUrls'], ALump::$request->server("REQUEST_URI"));
			}
			
		}else{
			$this->_remembers['lastUrls'] = array(ALump::$request->server("REQUEST_URI"));
		}
		
	}
	
	public function remember($field){
		if(isset($this->_remembers[$field])){
			echo $this->_remembers[$field];
		}
	}
	
	
	private function _rememberComment($comment){
		$this->_remembers = unserialize(Alump_Cookie::get(ALump_Common::$COOKIE_REMEMBER_KEY));
		
		if(empty($this->_remembers)){
			$this->_remembers = array();
		}

		$keys = array_keys ( $comment );
		ALump_Logger::log($keys);
		foreach($keys as $key){
			$this->_remembers[$key] = $comment[$key];
		}
		
		Alump_Cookie::set(ALump_Common::$COOKIE_REMEMBER_KEY, serialize($this->_remembers));
		
	}
	
	protected function getLastUrl(){
		if(empty($this->_remembers)){
			return ALump_Common::url("/", $this->options->siteUrl);
		}else{
			$lenUrl = count($this->_remembers['lastUrls']);
			if($lenUrl > 1){
				$lastUrl = $this->_remembers['lastUrls'][$lenUrl - 2];
			}else if($lenUrl == 1 ){
				$lastUrl = $this->_remembers['lastUrls'][0];
			}else{
				$lastUrl = ALump_Common::url("/", $this->options->siteUrl);
			}
			
			if(empty($lastUrl)){
				return ALump_Common::url("/", $this->options->siteUrl);
			}else{
				return ALump_Common::url($this->options->pathUrl($lastUrl), $this->options->siteUrl);
			}
		}
		
	}
	
	protected function doComment($post_id){
		
		$author = ALump_Common::removeXSS(ALump::$request->post("author"));
		$mail = ALump_Common::removeXSS(ALump::$request->post("mail"));
		
		$url = ALump_Common::removeXSS(ALump::$request->post("url"));
		$parent = ALump::$request->post("parent");
		if(empty($parent)){
			$parent = 0;
		}
		
		$author_id = 0;
		$nickname = "";
		$created = time();
		$ip = ALump_Common::getClientIp();
		$agent = ALump::$request->server('HTTP_USER_AGENT');
		$content = ALump_Common::removeXSS(ALump::$request->post("text"));
		$type = "comment";
		$status = 1;
		
		if(empty($author)){ //没有填写作者，就取当前用户
			$userName = ALump_Common::loginUser();
			if(!empty($userName)){
				$logUser = ALump_User::getUserByName(ALump_Common::loginUser());
				if(!empty($logUser)){
					$author = $logUser->name;
					$mail = $logUser->mail;
					$url = $logUser->url;
					$author_id = $logUser->id;
					$nickname = $logUser->nickname;
				}
			}
			 
		}else{
			$nickname = $author;
		}
		
		if(empty($author) || empty($mail) || empty($url)){
			return;
		}
		
		$commentArr = array(
				"content" => $content,
				"text" => $content,
				"author" => $author,
				"post_id" => $post_id,
				"author_id" => $author_id,
				"mail" => ALump_Common::removeXSS($mail),
				"url" => ALump_Common::removeXSS($url),
				"created" => $created,
				"ip" => $ip,
				'agent' => $agent,
				'type' => $type,
				'status' => $status,
				'parent_id' => $parent
		);
		
		$comment = new ALump_Comment($commentArr);
		
		$this->_rememberComment($commentArr);
		
		ALump_Comment::save($comment);
		$this->_toCommentsUrl();
	}
	
	private function _toCommentsUrl(){
		$commentUrl = ALump_Common::url('/'.$this->_moduleUrl."#comments", $this->options->siteUrl);
		header("location:$commentUrl");
	}
	
	
	public function need($script){
		include ALump_Common::getTheme($script);
	}
	
	
	
	public function view($scriptName){
		include ALump_Common::getTheme($scriptName);
	}
	
	protected  function getModuleUrl($mname = False, $pagePrifix = ""){
		$basename = get_class($this); // 传入当前对象得到类名
		
		$calss = explode("_", $basename);
		
		if(empty($mname)){
			$mname = "index";
		}
		
		$this->_pagePrifix = $pagePrifix;
		
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
		
		if(strpos($this->_moduleUrl,'page/') !== False || strpos($this->_moduleUrl,'post/') !== False){
			ALump_Javascript::replyCommentJS($this->_curPost->type, $this->_curPost->id);
		}
	}
	
	public function footer(){
		
		
	}
	
	public function respondId($echod = True){
		$resid =  'respond-'.$this->_curPost->type.'-'.$this->_curPost->id;
		if($echod){
			echo $resid;
		}
		
		return $resid;
	}
	
	public function is($whois, $slug=""){
		
		switch($whois){
			case "index":
				if(strpos($this->_moduleUrl, 'index') !== False){
					return true;
				}
				break;
			case 'page':
				if(strpos($this->_moduleUrl, $slug.$this->options->suffix) !== False){
					return true;
				}
				break;
		}
	}
	
	public function alump($alump, $params = False){
		return ALump::Lump($alump, $params);
	}
	
	
	public function cancelReply(){
		echo '<div class="cancel-comment-reply">
		     <a id="cancel-comment-reply-link" href="'.$this->_moduleUrl.'#'.$this->respondId(False).'" rel="nofollow" style="display:none" onclick="return ALumpComment.cancelReply();">取消回复</a>
		     </div>';
	
	}
	
	public function _getPageNavUrl($pageNav, $pageno, $isComment){
		if($pageno <= 0){
			$pageno = 1;
		}
		if($pageno > $pageNav->pagecount){
			$pageno = $pageNav->pagecount;
		}
		
		$urlTail = '';
		if($isComment){
			$urlTail = "#comments";
		}
		
		return ALump_Common::url('/'.$this->_moduleUrl.'/'.$this->_pagePrifix . $pageno.$urlTail, $this->options->siteUrl);
	}
	
	protected  function _pageNav($prev = '&laquo;', $next = '&raquo;', $splitPage = 3, $splitWord = '...', $pageno){		
		
		$pageNav = $this->_data->pageNav;
		
		$pageNav->setPageno($pageno);
		$this->_iPageNav($prev, $next, $splitPage,$splitWord,$pageno,$pageNav );
	}
	
	private function _iPageNav($prev = '&laquo;', $next = '&raquo;', $splitPage = 3, $splitWord = '...', $pageno, $pageNav, $isComment = False){
		$curPage = $pageno;
		
		$curPage = $curPage > 0 ? $curPage:1;
		
		$double_splitPage = 2 * $splitPage;
		
		$prev_end = 0;
		
		$pageArr = array();
		if($curPage > 1){
			array_push($pageArr, '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav, $pageNav->pageno - 1, $isComment).'">'.$prev.'</a></li>');
		}
		
		if($splitPage > 0){
			if($curPage > $double_splitPage){ //开始前分割
				array_push($pageArr, '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav, 1, $isComment).'">1</a></li>');
				array_push($pageArr, '<li>'.$splitWord.'</li>');
				$start = $curPage - $splitPage - 1;
				$start = $start > 0 ? $start : 1;
				$prev_end = $double_splitPage+1;
				for($i = $start; $i <= $prev_end; $i++){
					$pageArr[$i] = '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav, $i, $isComment).'">'.$i.'</a></li>';
				}
					
				if($prev_end < $pageNav->pagecount){
					$end_split = $double_splitPage + 2;
					if($pageNav->pagecount >= $end_split && ($curPage + $splitPage + 2)  < $pageNav->pagecount){//开始后切割
						if($curPage > $double_splitPage){
		
							$start = $curPage + $splitPage + 1;
							$start = $start > $pageNav->pagecount?$pageNav->pagecount:$start;
							$start = $start > 0 ? $start : 1;
							$end = $start + $splitPage;
							$end = $end > $pageNav->pagecount?$pageNav->pagecount:$end;
		
							for($i = $start; $i <= $end; $i++){
								$pageArr[$i] = '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav, $i, $isComment).'">'.$i.'</a></li>';
							}
						}
							
						array_push($pageArr, '<li>'.$splitWord.'</li>');
						array_push($pageArr, '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav, $pageNav->pagecount, $isComment).'">'.$pageNav->pagecount.'</a></li>');
							
					}else{
						for($i = $prev_end+1; $i <= $pageNav->pagecount; $i++){
							$pageArr[$i] = '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav, $i, $isComment).'">'.$i.'</a></li>';
						}
					}
				}
					
			}else{ // 不前分割的情况下
			
				$prev_end = $pageNav->pagecount >= $splitPage ? ($splitPage + 1 + $curPage):$pageNav->pagecount;
				$prev_end = $prev_end > $pageNav->pagecount ? $pageNav->pagecount :$prev_end;
			
				for($i = 1; $i <= $prev_end; $i++){
					$pageArr[$i] = '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav, $i, $isComment).'">'.$i.'</a></li>';
				}
				
				if($prev_end < $pageNav->pagecount){
					$end_split = $double_splitPage + 2;
					if($pageNav->pagecount >= $end_split && ($curPage + $splitPage + 2)  < $pageNav->pagecount){//开始后切割
							
						if($curPage > $double_splitPage){
		
							$start = $curPage + $splitPage + 1;
							$start = $start > $pageNav->pagecount?$pageNav->pagecount:$start;
							$start = $start > 0 ? $start : 1;
							$end = $start + $splitPage;
							$end = $end > $pageNav->pagecount?$pageNav->pagecount:$end;
		
							for($i = $start; $i <= $end; $i++){
								$pageArr[$i] = '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav, $i, $isComment).'">'.$i.'</a></li>';
							}
						}
							
						array_push($pageArr, '<li>'.$splitWord.'</li>');
						array_push($pageArr, '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav,$pageNav->pagecount, $isComment).'">'.$pageNav->pagecount.'</a></li>');
							
					}else{
						for($i = $prev_end+1; $i <= $pageNav->pagecount; $i++){
							$pageArr[$i] = '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav,$i, $isComment).'">'.$i.'</a></li>';
						}
					}
				}
			}
				
			$pageArr[$curPage] = '<li class="current"><a class="prev" href="'.$this->_getPageNavUrl($pageNav,$curPage, $isComment).'">'.$curPage.'</a></li>';
		}
		
		if($curPage < $pageNav->pagecount){
			array_push($pageArr, '<li><a class="prev" href="'.$this->_getPageNavUrl($pageNav,$pageNav->pageno + 1, $isComment).'">'.$next.'</a></li>');
		}
		
		
		
		echo '<ol class="page-navigator">';
		echo implode("", $pageArr);
		echo '</ol>';
	}
	
	public function _commentPageNav($comments, $prev = '&laquo;', $next = '&raquo;', $splitPage = 3, $splitWord = '...', $pageno){
	    $moduleUrl = ALump_Common::url('/'.$this->_moduleUrl, $this->options->siteUrl);
	   
	    $comments->setModuleUrl($moduleUrl);
		$pageNav = $comments->pageNav;
		$this->_iPageNav($prev,$next,$splitPage,$splitWord, $pageno,$pageNav, True);
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