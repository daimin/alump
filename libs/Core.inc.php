<?php

date_default_timezone_set('Asia/Shanghai');


include __ROOT_DIR__.'/libs/ALump.php';
include __ROOT_DIR__.'/libs/Array.php';
include __ROOT_DIR__.'/libs/JSON.php';
include __ROOT_DIR__.'/libs/simple_html_dom.php';
include __ROOT_DIR__.'/libs/Logger.php';
include __ROOT_DIR__.'/libs/Common.php';
include __ROOT_DIR__.'/libs/Date.php';
include __ROOT_DIR__.'/libs/passwordhash.php';
include __ROOT_DIR__.'/libs/Cookie.php';
include __ROOT_DIR__.'/libs/Db.php';
include __ROOT_DIR__.'/libs/Options.php';
include __ROOT_DIR__.'/libs/Request.php';

if(defined('__ADMIN_DIR__')){
	include __ROOT_DIR__.'/libs/Admin.php';
}
include __ROOT_DIR__.'/libs/Router.php';




?>