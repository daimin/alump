<?php

include ALump_Common::getTheme("functions.php");
/**
 * 主题配置Form
 * @author daimin
 *
 */
class ALump_ThemeForm {
	private $_json = null;
	private $_options = null;
	private $_themekey = null;
	
	
	function __construct(){
		$this->_json = new Services_JSON();
		$this->_options = ALump::$options;
		$this->_themekey = "theme:".$this->_options->theme;
		
		themeConfig($this);
	}
	
	public function addInput($name, $value, $title, $description){
		if(!empty($value)){
			$themeCfg = $this->_options->get($this->_themekey);
			$json_arr = null;
			if(!empty($themeCfg)){
				$json_arr = $this->_json->decode($themeCfg);
				$json_arr->$name = $value;
			}else{
				$json_arr = array($name=>$value);
			}
			
			$json_val = $this->_json->encode($json_arr);
			
			$this->_options->set($this->_themekey, $json_val);
		}

	}
	
	public function addCheckBox($dataArr){
		
		if(!empty($dataArr)){
			$themeCfg = $this->_options->get($this->_themekey);
			
			$json_arr = null;
			if(!empty($themeCfg)){
				$json_arr = $this->_json->decode($themeCfg);
				
				$json_arr ->$dataArr[0] = $dataArr[2];
			}else{
				$json_arr = array($dataArr[0]=>$dataArr[2]);
			}
			$json_val = $this->_json->encode($json_arr);
			$this->_options->set($this->_themekey, $json_val);
		}
	}
	
	
	
	
}

?>