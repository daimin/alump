<?php
include 'conf.php';
/*
if (!@include 'conf.php') {

	file_exists('./install.php') ? header('Location: install.php') : print('Missing Config File');
	exit;
}
*/

ALump_Router::service();
?>
