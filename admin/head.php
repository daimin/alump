<?php 
if(!defined("__ROOT_DIR__")){
    include 'inc.php';
}
?>
<!DOCTYPE html>
<!-- saved from url=(0034)http://localhost/mc-admin/post.php -->
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="UTF-8">
  <title><?php echo ALump_Admin::menu().' - '?><?php echo ALump_Common::$CMS_NAME?> | <?php echo ALump_Common::$VERSION_INFO?></title>
  <link style="text/css" rel="stylesheet" href="styles/style.css">
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="js/alump_admin.js"></script>
</head>
<body>
  <div id="main">
  <div id="top">
    <h3 id="top_title"><a href="<?php echo ALump::$options->siteUrl?>"><?php echo ALump_Common::$CMS_NAME?> 
            <span><?php echo ALump_Common::$VERSION_INFO?></span></a>
        </h3>
      <div class="title-right"><span>欢迎，<a href="profile.php">admin</a></span><span>|</span><span><a href="<?php ALump::$options->logoutUrl()?>">退出</a></span></div>
    <div class="clear"></div>
  </div>
  
