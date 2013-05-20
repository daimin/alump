<?php
/**
 * 
 */
class ALump_Options{
	private static $instance = null;
	
	private $adminUrl = null;
	// 原始的siteUrl，没有主文件名
	private $_siteUrl = null;
	
	private function __construct(){
		$db = Alump_Db::getInstance();
		$db->select(Alump_Common::getTabName('options'), array(
				'name', 'value'
				));
		$options = $db->fetch_array();
		
		foreach($options as $op){
			
			$this->$op['name'] = $op['value'];
		}
		
		if(!isset($this->logoUrl)){
			$this->logoUrl = False;
		}
		
		$this->_initUrl();
		$this->_initCfg();
		
	}
	
	
	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new Alump_Options();
		}
		
		return self::$instance;
	}
	
	private static function _analyseSiteUrl(){
		$sname = ALump::$request->server("SCRIPT_NAME");
		$servername = ALump::$request->server("SERVER_NAME");
		$rpos = strrpos($sname, "/");
		if($rpos > 0){
			return "http://".$servername.substr($sname, 0, $rpos);
		}
		
		return "http://".$servername;
		
	}
	
	
	public static function  init(){
		$installDb = ALump_Db::getInstance();
		
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'theme',  'value' => 'default'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'timezone',  'value' => _t('28800'))); 
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'charset',  'value' => 'UTF-8'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'contentType',  'value' => 'text/html'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'gzip',  'value' => 0));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'generator',  'value' => Alump_Common::$VERSION_INFO));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'title',  'value' => 'Hello World'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'description',  'value' => 'Just So So ...'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'keywords',  'value' => 'typecho,php,blog'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'rewrite',  'value' => 0));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'frontPage',  'value' => 'recent'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsRequireMail',  'value' => 1));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsRequireURL',  'value' => 0));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsRequireModeration',  'value' => 0));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'plugins',  'value' => 'a:0:{}'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentDateFormat',  'value' => 'F jS, Y \a\t h:i a'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'defaultCategory',  'value' => 1));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'allowRegister',  'value' => 0));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'defaultAllowComment',  'value' => 1));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'defaultAllowPing',  'value' => 1));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'defaultAllowFeed',  'value' => 1));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'pageSize',  'value' => 5));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'postsListSize',  'value' => 10));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsListSize',  'value' => 10));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsHTMLTagAllowed',  'value' => NULL));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'postDateFormat',  'value' => 'Y-m-d'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'feedFullText',  'value' => 1));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'editorSize',  'value' => 350));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'autoSave',  'value' => 0));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsMaxNestingLevels',  'value' => 5));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsPostTimeout',  'value' => 24 * 3600 * 30));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsUrlNofollow',  'value' => 1));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsShowUrl',  'value' => 1));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsPageBreak',  'value' => 0));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsThreaded',  'value' => 1));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsPageSize',  'value' => 20));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsPageDisplay',  'value' => 'last'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsOrder',  'value' => 'ASC'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsCheckReferer',  'value' => 1));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsAutoClose',  'value' => 0));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsPostIntervalEnable',  'value' => 1));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsPostInterval',  'value' => 60));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsShowCommentOnly',  'value' => 0));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsAvatar',  'value' => 1));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'commentsAvatarRating',  'value' => 'G'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'routingTable',  'value' => 'a:23:{s:5:"index";a:3:{s:3:"url";s:1:"/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:2:"do";a:3:{s:3:"url";s:22:"/action/[action:alpha]";s:6:"widget";s:9:"Widget_Do";s:6:"action";s:6:"action";}s:4:"post";a:3:{s:3:"url";s:24:"/archives/[cid:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:10:"attachment";a:3:{s:3:"url";s:26:"/attachment/[cid:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:8:"category";a:3:{s:3:"url";s:17:"/category/[slug]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:3:"tag";a:3:{s:3:"url";s:12:"/tag/[slug]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:6:"author";a:3:{s:3:"url";s:22:"/author/[uid:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:6:"search";a:3:{s:3:"url";s:19:"/search/[keywords]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:10:"index_page";a:3:{s:3:"url";s:21:"/page/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:13:"category_page";a:3:{s:3:"url";s:32:"/category/[slug]/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:8:"tag_page";a:3:{s:3:"url";s:27:"/tag/[slug]/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:11:"author_page";a:3:{s:3:"url";s:37:"/author/[uid:digital]/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:11:"search_page";a:3:{s:3:"url";s:34:"/search/[keywords]/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:12:"archive_year";a:3:{s:3:"url";s:18:"/[year:digital:4]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:13:"archive_month";a:3:{s:3:"url";s:36:"/[year:digital:4]/[month:digital:2]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:11:"archive_day";a:3:{s:3:"url";s:52:"/[year:digital:4]/[month:digital:2]/[day:digital:2]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:17:"archive_year_page";a:3:{s:3:"url";s:38:"/[year:digital:4]/page/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:18:"archive_month_page";a:3:{s:3:"url";s:56:"/[year:digital:4]/[month:digital:2]/page/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:16:"archive_day_page";a:3:{s:3:"url";s:72:"/[year:digital:4]/[month:digital:2]/[day:digital:2]/page/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:12:"comment_page";a:3:{s:3:"url";s:53:"[permalink:string]/comment-page-[commentPage:digital]";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:4:"feed";a:3:{s:3:"url";s:20:"/feed[feed:string:0]";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:4:"feed";}s:8:"feedback";a:3:{s:3:"url";s:31:"[permalink:string]/[type:alpha]";s:6:"widget";s:15:"Widget_Feedback";s:6:"action";s:6:"action";}s:4:"page";a:3:{s:3:"url";s:12:"/[slug].html";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}}'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'actionTable',  'value' => 'a:0:{}'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'panelTable',  'value' => 'a:0:{}'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'attachmentTypes',  'value' => '@image@'));
		$installDb->insert(Alump_Common::getTabName('options'),array('name' => 'siteUrl',  'value' => self::_analyseSiteUrl()));
		
	}
	
	private function _adminUrl()
	{
		$this->adminUrl = ALump_Common::url(defined('__ADMIN_DIR__') ?
				__ADMIN_DIR__ : '/admin/', $this->siteUrl);
	}
	
	private function _siteUrl()
	{
		$this->__siteUrl = $this->siteUrl;
		
		if($this->rewrite){
			$this->siteUrl = ALump_Common::url(null,$this->siteUrl);
		}else{
			$this->siteUrl = ALump_Common::url("index.php",$this->siteUrl);
		}
		
	}
	
	private function _initUrl()
	{
		self::_siteUrl();
		self::_adminUrl();
	}
	
	private function _initCfg(){
		$themeKey = "theme:".$this->theme;
		
		if(isset($this->$themeKey)){
			$this->_json = new Services_JSON();
			$json_obj = $this->_json->decode($this->$themeKey);
			if(isset($json_obj->sidebarBlock)){
				$this->sidebarBlock = $json_obj->sidebarBlock;
			}
			if(isset($json_obj->logoUrl)){
				$this->logoUrl = $json_obj->logoUrl;
			}
		}
	}
	
	public function adminUrl($path){
		echo ALump_Common::url($path, $this->adminUrl);
	}
	
	/**
	 * 检查当前页面是否是admin页面
	 */
	public function isAdmin(){
		$phpself = ALump::$request->server('PHP_SELF');
		
		$urls = explode("/", $phpself);
		
		if($urls[count($urls)-2] == 'admin'){
			return true;
		}else{
			return false;
		}
	}
	
	public function set($name, $value){
		$db = ALump_Db::getInstance();
		
		$db->replace(Alump_Common::getTabName('options'),array('name' => $name,  'value' => $value));
		$this->$name = $value;
	}
	
	public function get($name){
		$db = ALump_Db::getInstance();
	
		$db->select(Alump_Common::getTabName('options'), array('value'), array('where' => "`name`='$name'"));
		$row = $db->fetch_one();
		if(!empty($row)){
			return $row['value'];
		}
	}
	
	
	
	public function siteUrl($path=""){
		echo ALump_Common::url($path, $this->siteUrl);
	}
	
	public function charset(){
		echo $this->charset;
	}
	
	public function title(){
		echo $this->title;
	}
	
	
	public function themeUrl($staticName){
		echo ALump_Common::url(__THEME_DIR__.'/'.$this->theme.'/'.$staticName, $this->__siteUrl);
	}
	
	public function loginUrl(){
		echo ALump_Common::url("login.php",$this->adminUrl);
	}
	
	public function logoUrl(){
		
	}
	
	public function feedUrl(){
		echo ALump_Common::url("/feed/", $this->siteUrl);
	}
	
	public function commentsFeedUrl(){
		echo ALump_Common::url("/feed/comments/", $this->siteUrl);
	}
	
	public function description(){
		return $this->description;
	}
	
	
	
}



?>