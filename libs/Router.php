<?php
/**
 * 路由类
 * 不同的链接转发给不同的控制器进行处理
 * @author daimin
 * 主要有几种路由
 */
class ALump_Router {
	
	public static function service() {
		$route = new ALump_Router ();
		$route->route();
	}
	
	private function  _getUrlSlug($url){
		$pos = strrpos($url, ALump::$options->suffix);
		if(empty($pos)){
			return $url;
		}else{
			return substr($url,0, $pos);
		}
	}
	
	public function route(){
		$APP_PATH = str_replace($_SERVER['DOCUMENT_ROOT'], '', __FILE__);
		$SE_STRING = str_replace($APP_PATH, '', $_SERVER['REQUEST_URI']);    //计算出index.php后面的字段 index.php/controller/methon/id/3
		$siteDir = ALump::$options->siteDir();
		if($siteDir != "/"){
			$SE_STRING = substr($SE_STRING, strlen($siteDir));
		}

		if(!ALump::$options->rewrite){
			$SE_STRING = substr($SE_STRING, strlen("/index.php"));
		}
		$SE_STRING = trim($SE_STRING,'/');

		//echo $SE_STRING.'<br>';
		//这里需要对$SE_STRING进行过滤处理。
		$ary_url = array(
				'controller' => 'Index',
				'method' => 'index',
				'pramers' => array()
		);
		//var_dump($ary_url);
		$ary_se = explode('/', $SE_STRING);
		$se_count = count($ary_se);
		
		
		//路由控制
		if($se_count == 1 && $ary_se[0] != '' ){
			$ary_url['controller'] = $ary_se[0];
		
		}else if($se_count>1){//计算后面的参数，key-value
			$ary_url['controller'] = $ary_se[0];
			$ary_url['method'] = $ary_se[1];
			
			for($i = 2;$i < $se_count;$i++){
				$ary_kv_hash = array($this->_getUrlSlug(strtolower($ary_se[$i])));
				
				$ary_url['pramers'] = array_merge($ary_url['pramers'], $ary_kv_hash);
			}
		}
		
		
		$module_name = $ary_url['controller'];
		$module_name = ucfirst($module_name);
		$module_file = __ROOT_DIR__.'/libs/controller/'.$module_name.'Controller.php';
		
		$method_name = $ary_url['method'];
		if(file_exists($module_file)){
			$this->_callModule($module_name,$method_name,$ary_url );
		}
		else
		{
			ALump_Common::error('模块文件不存在');
			die();
		}
	}
	
	private function _callModule($module_name, $method_name, $ary_url){
		$module_name = "ALump_".$module_name.'Controller';
		if(!class_exists($module_name)){
			ALump_Common::error('类'.$module_name.'不存在');
			die();
		}
		$obj_module = new $module_name();    //实例化模块m

		if(!method_exists($obj_module, $method_name)){
			ALump_Common::error('方法不存在');
			die();
		}else{
			if(is_callable(array($obj_module, $method_name))){    //该方法是否能被调用
				//var_dump($ary_url[pramers]);
				//$pramers = implode(",", $ary_url['pramers']);
// 				if(function_exists("call_user_func_array")){
// 					echo "call_user_func_array";
// 				}
				$get_return = False;
				$obj = new $obj_module;
				if(empty($ary_url['pramers'])){
					$get_return = call_user_func_array(array($obj, $method_name), array());
					//$get_return = $obj_module->$method_name();    //执行a方法,并把key-value参数的数组传过去
				}else{
				    //$get_return = $obj_module->$method_name($ary_url['pramers']);    //执行a方法,并把key-value参数的数组传过去
				    foreach($ary_url['pramers'] as $key=>$v){
				    	 $ps = ALump_Common::multiexplode(array('#','?'), $v);
				    	 if(!empty($ps)){
				    	 	$ary_url['pramers'][$key] = $ps[0];
				    	 }
				    	 
				    }
				    $get_return = call_user_func_array(array($obj, $method_name), $ary_url['pramers']);
				}
				
				if(!is_null($get_return)){ //返回值不为空
					var_dump($get_return);
				}
		
			}else{
				ALump_Common::error('该方法不能被调用');
				die();
			}
		
		}
	}
	
	
}
?>