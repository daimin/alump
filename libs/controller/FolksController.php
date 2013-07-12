<?php

class ALump_FolksController extends Alump_BaseController {
	
	
	public static $PARAMS_COUNT = 4;
	
	
	function __construct(){
		parent::__construct();
		
	}
	
	public function blackbox($type, $fname){
		header("Content-Type:".ALump_Common::getContentType($fname));
		echo file_get_contents(__ROOT_DIR__.'/libs/folks/blackbox/'.$type.'/'.$fname);
	}
	
	public function jquery(){
		header("Content-Type:".ALump_Common::getContentType("jquery.js"));
		echo file_get_contents(__ROOT_DIR__.'/libs/folks/libs/jquery.js');
	}
    
    public function upload($_file_save_dir=False){
        if(empty($_file_save_dir)){
            if(isset($_GET['dir'])){
                $_file_save_dir = $_GET['dir'];
            }
            
        }
        include __ROOT_DIR__ . '/libs/folks/UploadAttach.php';
    }
    
    public function fileManager(){
        if(empty($_file_save_dir)){
            if(isset($_GET['dir'])){
                $_file_save_dir = $_GET['dir'];
            }
            
        }
        include __ROOT_DIR__ . '/libs/folks/FileManager.php';
    }
}

?>