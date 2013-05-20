<?php
/**
 * 路由类
 * 不同的链接转发给不同的控制器进行处理
 * @author daimin
 * 主要有几种路由
 * 1 文档 http://localhost/posts/4.html
 * 2 分类 http://localhost/category/default/
 * 3 评论 http://localhost/archives/3.html#comments
 * 4 归档 http://localhost/2013/03/23/
 * 5 页面 http://localhost/start-page.html
 * 6 分页 http://localhost/page/2/
 * 7 标签 http://localhost/tag/av/
 */
class ALump_Router {
	static $_PATTERN = array (
			"posts" => array (
					'|^/\S+/index.php/archives/([a-z0-5]+).html$|',
					'|^.*/archives/([a-z0-5]+).html$|' 
			),
			"category" => array (
					'|^.*/index.php/category/([a-z0-5]+).html$|',
					'|^.*/category/([a-z0-5]+).html$|' 
			),
			"archives" => array (
					'|^.*/index.php/archives/([a-z0-5]+).html$|',
					'|^.*/archives/([a-z0-5]+).html$|' 
			),
			"uploadimg" => array (
					'|^.*/index.php/folks/upload$|',
					'|^.*/folks/upload$|' 
			),
			"page" => array (
					'|^.*/index.php/page/([a-z0-5]+).html$|',
					'|^.*/page/([a-z0-5]+).html$|' 
			),
			"index" => array (
					'|^.*/index.php$|',
					'|^.*/$|' 
			) 
	);
	public static function service() {
		$route = new ALump_Router ();
		$route->match ();
	}
	public function match() {
		$php_self = ALump::$request->server ( 'PHP_SELF' );
		
		$controller = null;
		$matches = null;

		preg_match ( '|^.*/index.php[/]?([a-zA-Z_]+)?[/]?(\w+)?('.ALump::$options->suffix.')?[/]?(\w+)?('.ALump::$options->suffix.')?$|i', $php_self, $matches );

		
		$valid_url = true;
		if(!empty($matches)){
			
			$full_url = "";
			if (isset ( $matches [0] )) {
				$full_url = $matches [0];
			}
			$type = "";
			if (isset ( $matches [1] )) {
				$type = $matches [1];
			}
			$param_val1 = "";
			$param_val2 = "";
			$suffix = ALump::$options->suffix;
			
			$count_match = count($matches);
			if($count_match > 2 && $count_match < 4){
				$param_val1 = $matches [2];
			}else if($count_match > 4){
				$param_val2 = $matches [4];
			}else{
				$suffix = $matches [$count_match - 1];
			}
			
			switch ($type) {
				case "" :
				case "page" :
					if($count_match > ALump_IndexController::$PARAMS_COUNT){
						$valid_url = false;
					}else{
						$controller = new ALump_IndexController ($type, $param_val1 );
					}
					break;
				case "folks" :
					switch ($param_val1) {
						case "upload" : // 上传组件
							include (__ROOT_DIR__ . '/libs/folks/UploadAttach.php');
							break;
					}
					break;
				default :
					$valid_url = false;
					break;
			}
		}else{
			$valid_url = false;
		}
		
		
		if (! $valid_url) {
			echo '<div style="color:red;">404,Page not found!</div>';
		}
	}
}
?>