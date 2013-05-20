<?php
class ALump_Date {
	public static function getNow($fmt="Y-m-d H:i:s"){
		return date($fmt);
	}
	
	public static function toTimestamp($dateStr, $fmt="Y-m-d H:i:s"){
		if(empty($dateStr)){
			return 0;
		}
		return strtotime($dateStr);
		
	}
	
	public static function format($time=0, $fmt="Y-m-d H:i:s"){
		return date($fmt, $time);
	}
}

?>