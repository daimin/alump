<?php if(!defined('__ROOT_DIR__')) exit; ?>
<?php 
$action = ALump::$request->request('action');

if($action == "delete"){
   $dates =  ALump::$request->get("ids");
   $dates = explode(",", $dates);
  
   $prefixs = array("Login", "Err", "Log", "Action");
   foreach($dates as $d){
       if(empty($d)) continue;
       $logDate = date("Ymd", strtotime($d));
       foreach($prefixs as $prefix){
           $logFile = LOG_PATH.$prefix.'_'.$logDate.'.log';
           
           ALump_Common::delFile($logFile);
       }
   }
   
   ALump_Logger::action("delete log file");
}


?>
