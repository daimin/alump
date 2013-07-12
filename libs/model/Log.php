<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Log
 *
 * @author daimin
 */
class ALump_Log {
    public $id = '';
    public $date = '';
    
    public $logs  = array("Login"=>array(), "Action"=>array(), "Log"=>array(), "Err"=>array());
    

    public static function getLogList(){
       $log_dir = opendir(LOG_PATH);    //opendir()返回一个目录句柄,失败返回false
        $logFiles = array();
        $count = 0;
        while (($file = readdir($log_dir)) !== false) {    //readdir()返回打开目录句柄中的一个条目
            if($file != '.' && $file != '..'){
                $full_file = LOG_PATH.'/'.$file;
                if(is_file($full_file)){
                    $date = substr($file, strrpos($file, '_') + 1, 8);
                    $date = date("Y-m-d", strtotime($date));
                    $type = substr($file, 0, strrpos($file, '_'));
                    if($log = self::_hasLog($logFiles, $date)){
                        $log->logs[$type]['name'] = $file.'<span class="log-filesize">('.ALump_Common::displayFileSize(abs(filesize($full_file))).')</span>';
                        $log->logs[$type]['download_url'] = ALump::$options->siteUrl("log/".$file, False);
                        
                    }else{
                        $count++;
                        $log = new ALump_Log();
                        
                        $log->logs[$type]['name'] = $file.'<span class="log-filesize">('.ALump_Common::displayFileSize(abs(filesize($full_file))).')</span>';
                        $log->date = $date;
                        $log->logs[$type]['download_url'] = ALump::$options->siteUrl("log/".$file, False);
                        $log->id = $count;
                        $logFiles[$date] = $log;
                    }
                     
                }
            }
            
        }
        krsort($logFiles);
        $logArray = new ALump_Array(count($logFiles));
        $logFiles = array_slice($logFiles, $logArray->pageNav->getStart(), ALump::$options->adminPageSize);
        foreach($logFiles as $log){
            $logArray->add($log);
        }
        return $logArray;
    }
    
    private static function _hasLog($logFiles, $date){
        
        foreach($logFiles as $key=>$log){
            if($date == $key){
                return $log;
            }
        }
        
        return False;
    }
    
    public function getName($type){
        if(isset($this->logs[$type]) && !empty($this->logs[$type])){
             return $this->logs[$type]['name'];
        }
        
        return False;
    }
    
    public function getDownloadUrl($type){
        if(isset($this->logs[$type]) && !empty($this->logs[$type])){
            return $this->logs[$type]['download_url'];
        }
        
        return False;
    }
}

?>
