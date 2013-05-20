<?php
if (!defined('__ADMIN_DIR__')) {
    define('__ADMIN_DIR__', dirname(__FILE__));
}

/** 载入配置文件 */
include __ADMIN_DIR__ . '/../conf.php';


/*
 * if (@!include __DIR__ . '/../conf.php') {
	file_exists(__DIR__ . '/../install.php') ? header('Location: ../install.php') : print('Missing Config File');
	exit;
}
 */



$sname = Alump::$request->server('SCRIPT_NAME');

if(strpos($sname, 'login.php') === False && !Alump_Common::isLogined()){
	header('Location: login.php');
}

?>