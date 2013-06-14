<?php

class ALump_ActionController extends Alump_BaseController {
	
	private $_curPost = null;
	
	public static $PARAMS_COUNT = 4;
	
	
	function __construct(){
		parent::__construct();
		
	}
	
	public function logout(){
		Alump_Cookie::delete(ALump_Common::$COOKIE_AUTH_NAME);
		header("Location: ".$this->_remembers['lastUrls'][count($this->_remembers) - 2]);
		//ALump_Common::javascript("window.location=history.go(1)");
	}
}

?>