<?php
class ALump {
	public static $options = null;
	public static $request = null;
	
	private $funcName = "";
	
	private function __construct($name){
		$this->funcName = self::toFunctionName($name);
	}
	
	public static function  Lump($name){
		return new ALump($name);
	}
	
	private static function toFunctionName($lumpName){
		return implode("", explode("_", $lumpName));
	}
	
	public function to(&$attr){
		$fname = $this->funcName;
		return $attr = $this->$fname();
	}
	/**
	 * 获得分类列表
	 */
	public function MetasCategoryList(){
		return ALump_Meta::getCategorys();
	}
	/**
	 * 获得已发布文章列表
	 * @return ALump_Array
	 */
	public function ContentsPostPublishAdmin(){
		return ALump_Post::getPostsAdmin(ALump_Common::$PUBLISH);
	}
	/**
	 * 获得草稿状态的文章列表
	 * @return ALump_Array
	 */
	public function ContentsPostDraftAdmin(){
		return ALump_Post::getPostsAdmin(ALump_Common::$DRAFT);
	}
	/**
	 * 获得已发布的页面列表
	 */
	public function ContentsPageAdmin(){
		return ALump_Post::getPagesAdmin();
	}
	
	public function ContentsPageList(){
		return ALump_Post::getPages();
	}
	/**
	 * 获得编辑文章
	 */
	public function ContentPostEditAdmin(){
		return ALump_Post::getPostById(ALump::$request->get('id'));
	}
	/**
	 * 获得分类列表
	 * @return ALump_Array
	 */
	public function MetasCategoryAdmin(){
		return ALump_Meta::getCategorys();
	}
	/**
	 * 获得标签列表
	 * @return ALump_Array
	 */
	public function MetasTagsAdmin(){
		return ALump_Meta::getTags();
	}
	/**
	 * 获得编辑的分类
	 * @return ALump_Meta
	 */
	public function MetaEditCategory(){
		
		return ALump_Meta::getMetaById(ALump::$request->get('cateid'));
	}
	
	/**
	 * 取得POST列表，列表元素个数根据postsListSize配置
	 * @return Ambigous <NULL, ALump_Array>
	 */
	public function ContentsPostRecent(){
		return ALump_Post::getRecentPosts(null, ALump::$options->postsListSize);
	}
	
	
	
}

?>