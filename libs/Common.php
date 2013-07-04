<?php

function __autoload($className) {
	$phpFileName = substr($className,6).'.php';
	if (file_exists(__ROOT_DIR__ . '/libs/model/' . $phpFileName)) {
		require(__ROOT_DIR__ . '/libs/model/' .$phpFileName);
	} elseif (file_exists(__ROOT_DIR__ . '/libs/controller/' . $phpFileName)) {
		require(__ROOT_DIR__ . '/libs/controller/' . $phpFileName);
	}
}



/**
 * 全局函数
 * @param unknown_type $str
 * @return unknown
 */
function _t($str){
	return $str;
}

function _r($str){
	return $str;
}
function _e($str){
	echo $str;
}

function isNotEmpty($val){
    if(!empty($val)){
        return True;
    }

    return False;
}



class ALump_Common{
	
    
    
	public static $VERSION_INFO = "ALump 0.0.1";
	public static $CMS_NAME = "这一坨";
	
	public static $COOKIE_SECRET = 'y2hjJj2IxGcIbvJMQY0';
	
	public static $COOKIE_AUTH_NAME = 'ALUMP_USER_COOKIE';
	public static $COOKIE_REMEMBER_KEY = 'ALUMP_REMEMBER_COOKIE';
	/*AJAX返回值*/
	public static $SUCCESS = 1;
	public static $FAILURE = 0;
	public static $NOPERMISSION = 2;
	
	/*POST状态*/
	public static $PUBLISH = 1;
	public static $DRAFT = 0;
	
	
	public static function init($dbCfg){
		 Alump_Db::init($dbCfg);
         ALump::$options = Alump_Options::getInstance();
         ALump::$request = Alump_Request::getInstance();
         
	}

	
	public static function getTabName($tab){
		return __TAB_PREFIX__.$tab;
	}
	
	public static function isLogined(){
		$user = Alump_Cookie::get(self::$COOKIE_AUTH_NAME);
		if(empty($user)){
			return false;
		}
		return true;
	}
	
	public static function loginUser(){
		$user = Alump_Cookie::get(self::$COOKIE_AUTH_NAME);
		if(empty($user)){
			return False;
		}
		return $user;
	}
	

	
	
	/**
	 * 将路径转化为链接
	 *
	 * @access public
	 * @param string $path 路径
	 * @param string $prefix 前缀
	 * @return string
	 */
	public static function url($path, $prefix)
	{
		$path = (0 === strpos($path, './')) ? substr($path, 2) : $path;
		return rtrim($prefix, '/') . '/' . str_replace('//', '/', ltrim($path, '/'));
	}
	
	public static function realUrl($rurl){
		$surls = explode("/", $rurl);
		$newUrls = array();
		foreach($surls as $suburl){
			if($suburl == '.'){
				// 当前不要
				continue;
			}else if($suburl == '..'){
				// 当前不要，还要减掉下一级
				array_pop ($newUrls);
				continue;
			}
			array_push($newUrls, $suburl);
		}
		 
		return implode("/", $newUrls);
	}
	
	public static function redirect($tarurl){
		echo '<script type="text/javascript">window.location = "'.$tarurl.'";</script>';
	}
	
	/**
	 * 对象转化成数组
	 * @param unknown_type $object
	 * @return multitype:NULL
	 */
	public static function objectToArray($object, $filteArr=array())
	{
		$reflect = new ReflectionClass($object);
		$pros = $reflect->getDefaultProperties();
		$e = array();
		foreach($pros as $k=>$v)
		{
			if(in_array($k, $filteArr) || strpos($k, "_") === 0){
				continue;
			}
			if(	is_object($object->$k))
			{
				$e[$k]= self::objectToArray($object->$k);
			}
			else {
				$e[$k]=$object->$k;
			}
		}
		return $e;
	}
	
	/**
	 * 解密
	 * @param unknown_type $encryptedText
	 * @return string
	 */
    public static function decrypt($encryptedText)
	{
		$key = self::$COOKIE_SECRET;
		$decryptText = "";
		$cryptText = base64_decode($encryptedText);
		if(function_exists('mcrypt_get_iv_size')){
			$ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
			$iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
			$decryptText = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $cryptText, MCRYPT_MODE_ECB, $iv);
		}else{
			$decryptText = $cryptText;
		}
		
		return trim($decryptText);
	}

	/**
	 * 加密
	 *
	 * @param string $plainText
	 * @return string
	 */
	public static function encrypt($plainText)
	{
		$key = self::$COOKIE_SECRET;
		$encryptText = "";
		if(function_exists('mcrypt_get_iv_size')){
			$ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
			$iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
			$encryptText = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plainText, MCRYPT_MODE_ECB, $iv);
		}else{
			$encryptText = $plainText;
		}

		return trim(base64_encode($encryptText));
	}
	
	/**
	 * 处理XSS跨站攻击的过滤函数
	 *
	 * @author kallahar@kallahar.com
	 * @link http://kallahar.com/smallprojects/php_xss_filter_function.php
	 * @access public
	 * @param string $val 需要处理的字符串
	 * @return string
	 */
	public static function removeXSS($val)
	{
		
		// remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
		// this prevents some character re-spacing such as <java\0script>
		// note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
		$val = preg_replace('/([\x00-\x08]|[\x0b-\x0c]|[\x0e-\x19])/', '', $val);
	
		// straight replacements, the user should never need these since they're normal characters
		// this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
		$search = 'abcdefghijklmnopqrstuvwxyz';
		$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$search .= '1234567890!@#$%^&*()';
		$search .= '~`";:?+/={}[]-_|\'\\';
	
		for ($i = 0; $i < strlen($search); $i++) {
			// ;? matches the ;, which is optional
			// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
	
			// &#x0040 @ search for the hex values
			$val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
			// &#00064 @ 0{0,7} matches '0' zero to seven times
			$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
		}
	
		// now the only remaining whitespace attacks are \t, \n, and \r
		$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
		$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
		$ra = array_merge($ra1, $ra2);
	
		$found = true; // keep replacing as long as the previous round replaced something
		while ($found == true) {
			$val_before = $val;
			for ($i = 0; $i < sizeof($ra); $i++) {
				$pattern = '/';
				for ($j = 0; $j < strlen($ra[$i]); $j++) {
					if ($j > 0) {
						$pattern .= '(';
						$pattern .= '(&#[xX]0{0,8}([9ab]);)';
						$pattern .= '|';
						$pattern .= '|(&#0{0,8}([9|10|13]);)';
						$pattern .= ')*';
					}
					$pattern .= $ra[$i][$j];
				}
				$pattern .= '/i';
				$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
				$val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
	
				if ($val_before == $val) {
					// no replacements were made, so exit the loop
					$found = false;
				}
			}
		}
	
		return $val;
	}
	
	public static function escape($val){
		return htmlspecialchars($val, ENT_QUOTES);
	}
	
	public static function deEscape($val){
		
		return htmlspecialchars_decode($val, ENT_QUOTES);
	}
	/**
	 * 取得主题地址
	 * @param unknown_type $script
	 * @return string
	 */
	public static function getTheme($script){
		return __ROOT_DIR__.__THEME_DIR__.'/'.ALump::$options->theme.'/'.$script;
	}

	/**
	 * 宽字符串截字函数
	 *
	 * @access public
	 * @param string $str 需要截取的字符串
	 * @param integer $start 开始截取的位置
	 * @param integer $length 需要截取的长度
	 * @param string $trim 截取后的截断标示符
	 * @return string
	 */
	public static function subStr($str, $start, $length, $trim = "...")
	{
		$charset = ALump::$options->charset;
		if (function_exists('mb_get_info')) {
			$iLength = mb_strlen($str, $charset);
			$str = mb_substr($str, $start, $length, $charset);
			return ($length < $iLength - $start) ? $str . $trim : $str;
		} else {
			preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $str, $info);
			$str = join("", array_slice($info[0], $start, $length));
			return ($length < (sizeof($info[0]) - $start)) ? $str . $trim : $str;
		}
	}
	
	/**
	 * 获取宽字符串长度函数
	 *
	 * @access public
	 * @param string $str 需要获取长度的字符串
	 * @return integer
	 */
	public static function strLen($str)
	{
		if (function_exists('mb_get_info')) {
			return mb_strlen($str, ALump::$options->charset);
		} else {
			preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $str, $info);
			return sizeof($info[0]);
		}
	}
	/**
	 * 获取客户端IP地址
	 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
	 * @return mixed
	 */
	public static function getClientIp($type=0){
		$type       =  $type ? 1 : 0;
		static $ip  =   NULL;
		if ($ip !== NULL) return $ip[$type];
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$pos    =   array_search('unknown',$arr);
			if(false !== $pos) unset($arr[$pos]);
			$ip     =   trim($arr[0]);
		}elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip     =   $_SERVER['HTTP_CLIENT_IP'];
		}elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$ip     =   $_SERVER['REMOTE_ADDR'];
		}
		// IP地址合法验证
		$long = sprintf("%u",ip2long($ip));
		$ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
		return $ip[$type];		
	}
	
	public static function  showGravatar($email, $size=32, $default="", $rating=""){
		return 'http://www.gravatar.com/avatar.php?gravatar_id='.md5($email).'&default='.$default.'&size='.$size.'&rating='.ALump::$options->commentsAvatarRating;
	
	}
	
	public static function splitFilePath($filepath){
		$lastPP = strrpos($filepath, '.');
		$lastSP = strrpos($filepath, '/');
		$fext = $fname = $fpath = '';
		if($lastPP !== False){
			$fext = substr($filepath, $lastPP);
		}
		if($lastPP !== False && $lastSP !== False){
			$fname = substr($filepath,$lastSP + 1, substr($filepath, $lastPP));
		}
		if($lastPP === False && $lastSP !== False){
			$fname = substr($filepath,$lastSP + 1);
		}
		if($lastPP !== False && $lastSP === False){
			$fname = substr($filepath, 0, $lastPP);
		}
		
		if($lastSP !== False){
			$fpath = substr($filepath, 0, $lastSP);
		}else{
			$fpath = $filepath;
			
		}
		
		return array($fpath, $fname, $fext);
		
	}
	
	public static function multiexplode ($delimiters,$string) {
	
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return  $launch;
	}
	
	public static function getContentType($filename){
		$ppos = strrpos($filename, ".");
		if($ppos === False){
			return;
		}
		
		$fext = substr($filename,$ppos );
		
		switch($fext){
			case '.jpe':
				return 'image/jpeg';
			case '.jpeg':
				return 'image/jpeg';
			case '.jpg':
				return 'application/x-jpg';
			case '.png':
				return '.application/x-png';
			case '.js':
			    return 'application/x-javascript';
			case '.css':
				return 'text/css';
			default:
				return 'text/plain';
			    	 
		}
	}


	
	public static function javascript($script){
		header("Content-type:text/html");
	   	echo <<<EOT
	   	<html>
<script type="text/javascript">
$script;
</script>
	   	</html>
EOT;
	}

	
	/**
	 * 显示系统信息
	 *
	 * @param string $msg 信息
	 * @param string $url 返回地址
	 * @param boolean $isAutoGo 是否自动返回 true false
	 */
	public static function  error($exception,$url='javascript:location.go(-1);') {
		ALump_Logger::err($exception);
		echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
EOT;
		echo <<<EOT
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息</title>
<style type="text/css">
<!--
body {
	background-color:#F7F7F7;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	font-size: 12px;
	color: #666666;
	width:90%;
	margin:60px auto 0px;
	border-radius: 10px;
	padding:30px 10px;
	list-style:none;
	border:#DFDFDF 1px solid;
}
.main p {
	line-height: 18px;
	margin: 5px 20px;
}
-->
</style>
</head>
<body>
<div class="main">
<p>$exception</p>
EOT;
	if(!empty($url))	{
	   echo '<p><a href="'.$url.'">&laquo;点击返回</a></p>';
	}
echo <<<EOT
</div>
</body>
</html>
EOT;
		exit;
	}
    
   
    public static function trimArray($arr){
        if(is_array($arr)){
            return array_filter($arr, 'isNotEmpty');
        }else{
            return $arr;
        }
        
    }
}
?>