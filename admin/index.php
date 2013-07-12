<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'setting-handler.php'?>
 <div id="content">
     <div id="content_box">
     <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr> 
	<td> <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
	<tbody><tr>
	  <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF" class="tableoutline">
        <tbody><tr bgcolor="#F3F3F3">
          <td height="20" colspan="2" class="tbhead"><strong>快捷方式</strong></td>
        </tr>
        <tr>
          <td width="50%" colspan="2"><a href="post-add.php">添加文章</a> | <a href="post-publish.php">已发布文章</a> |  <a href="comment-manage.php">评论管理</a> | <a href="list-add.php">添加链接</a> | <a href="theme-setting.php">设置主题</a></td>
        </tr>
      </tbody></table>
	  <table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF" class="tableoutline">
	<tbody><tr bgcolor="#F3F3F3"> 
	<td height="20" colspan="2" class="tbhead"><strong>系统信息</strong></td>
	</tr>
	<tr> 
	<td width="50%">服务器软件: Apache/2.2.16 (Win32) mod_wsgi/3.3 Python/2.6.5 PHP/5.3.3 	</td>
	<td width="50%">服务器系统: <?php echo  php_uname('s')  ?></td>
	</tr>
	<tr> 
	<td width="50%">PHP 版本: <?php echo PHP_VERSION ?> </td>
    <td width="50%">MySQL 版本: <?php echo ALump_Db::getInstance()->getConn()->server_info  ?></td>
	</tr>
	<tr> 
	<td width="50%">register_globals: <?php 
     if(ALump_Common::isRegisterglobalsOn()) echo '<span class="warn">开启</span>'; else echo '关闭';
     ?></td>
	<td width="50%">文件上传: <?php
     if(ALump_Common::fileCanUpload()) echo '可以'; else echo '<span class="warn">不可以</span>';
     ?> </td>
	</tr>
    <tr> 
	<td width="50%">GD 图片库: <?php 
     if(ALump_Common::isGDEnabled()) echo '可用'; else echo '<span class="warn">不可用</span>';
     ?></td>
	
	</tr>
	<tr> 
	<td>服务器地址: <?php echo $_SERVER['SERVER_ADDR'] ?></td>
	<td width="50%">服务器时区: <?php echo date_default_timezone_get() ?> </td>
	</tr>
	</tbody></table>
	<table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF">
	<tbody><tr bgcolor="#F3F3F3"> 
	<td height="20" colspan="2" class="tbhead"><strong>程序信息</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF"> 
	<td><p>程序开发: tony/vagasnail</p></td>
	<td>版本: <?php echo ALump::$options->generator ?></td>
	</tr>
	<tr bgcolor="#FFFFFF"> 
	<td>E-mail:<a href="mailto:vagasnail@gmail.com">vagasnail@gmail.com</a></td>
	<td width="50%">官方站点: <a href="http://www.blogjava.net/vagasnail" target="_blank">http://www.blogjava.net/vagasnail</a></td>
	</tr>
	</tbody></table>
	<table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF">
	<tbody><tr bgcolor="#F3F3F3"> 
	<td height="20" colspan="2" class="tbhead"><strong>统计信息</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF"> 
        <td>日志数量: <?php echo ALump_Post::getPostCount() ?></td>
        <td>评论数量: <?php echo ALump_Comment::getCommentCount() ?></td>
	</tr>
	<tr bgcolor="#FFFFFF"> 
        <td width="50%">分类数量: <?php echo ALump_Meta::getCategorys()->size() ?></td>
        <td width="50%">标签数量: <?php echo ALump_Meta::getTags()->size() ?></td>
	</tr>
	<tr bgcolor="#FFFFFF"> 
        <td width="50%">附件大小: <?php echo ALump_Common::getAttachmentSize() ?></td>
        <td width="50%">数据库大小: <?php echo ALump_Common::displayFileSize(ALump_Db::getInstance()->getDbSize()) ?></td>
	</tr>
	</tbody></table></td>
	</tr>
	</tbody></table></td>
	</tr>
	</tbody></table>
     </div>
  </div>
<?php include 'foot.php'?>

