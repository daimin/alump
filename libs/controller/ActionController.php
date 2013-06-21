<?php

class ALump_ActionController extends Alump_BaseController {
	
	
	public static $PARAMS_COUNT = 4;
	
	
	function __construct(){
		parent::__construct();
		
	}
	
	public function logout(){
		Alump_Cookie::delete(ALump_Common::$COOKIE_AUTH_NAME);
		header("Location: ".$this->getLastUrl());
	
		//ALump_Common::javascript("window.location=history.go(1)");
	}
}

?>