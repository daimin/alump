<?php
/**
 * 管理专用
 * @author daimin
 *
 */
class ALump_Admin {
	/**
     *
     * 配置后台管理的<head><title>显示
     */
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
            "post-setting.php"  => "文章设置",
            "comment-setting.php" => '评论设置',
            "log-manage.php"   => '日志管理',
            "comment-manage.php" => '评论管理',
            "attach-manage.php"  => '附件管理',
            "index.php" => '欢迎使用一坨',
	);

	
	public static function menu($fname=null){
		if(empty($fname)){
			$php_self = ALump::$request->server('PHP_SELF');
			$fname = substr($php_self, strripos($php_self, "/") + 1);
		}
		if(empty($fname)){
			return "Welcome to a lump.";
		}else{
			if(isset(self::$admin_menus[$fname])){
				return self::$admin_menus[$fname];
			}else{
				return "Welcome to a lump.";
			}
		}
    }
}

?>