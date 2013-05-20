<?php
/** 定义根目录 */
define('__ROOT_DIR__', dirname(__FILE__));

/** 定义插件目录(相对路径) */
define('__PLUGIN_DIR__', '/content/plugins');

/** 定义模板目录(相对路径) */
define('__THEME_DIR__', '/content/themes');


/** 数据表前缀  **/
define('__TAB_PREFIX__', 'alump_');

include __ROOT_DIR__.'/libs/core.inc.php';
ALump_Common::init(array (
		'host' => 'localhost',
		'user' => 'root',
		'password' => 'daimin',
		'port' => '3306',
		'database' => 'alump',
));
Alump_Options::init();
ALump_Model::init();
?>