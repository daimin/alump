<?php
/**
 * 管理专用
 * @author daimin
 *
 */
class ALump_Admin {
	
	public static $admin_menus = array(
			"post-add.php"     => "撰写文章",
			"post-edit.php"     => "编辑文章",
			"post-publish.php" => "已发布",
			"post-draft.php"   => "草稿箱",
			"tags-manage.php"  => "标签",
			"category-manage.php"  => "分类",
			"page-add.php"  => "创建新页面",
			"page-edit.php"  => "编辑页面",
			"page-manage.php"  => "管理页面",
            "profile.php"  => "个人设置",
            "site-setting.php"  => "站点设置",
	);
	/**
	 * 后台页面专用的页面大小
	 */
	public static $PAGE_SIZE = 10;
	
	public static function menu($fname=null){
		if(empty($fname)){
			$php_self = ALump::$request->server('PHP_SELF');
			$fname = substr($php_self, strripos($php_self, "/") + 1);
		}
		if(empty($fname)){
			return "";
		}else{
			if(isset(self::$admin_menus[$fname])){
				return self::$admin_menus[$fname];
			}else{
				return "";
			}
		}
    }
}

?>