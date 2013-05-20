<!DOCTYPE html>
<!-- saved from url=(0034)http://localhost/mc-admin/conf.php -->
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="UTF-8">
  <title>MiniCMS</title>
  <link style="text/css" rel="stylesheet" href="http://localhost/mc-admin/style.css">
</head>
<body>
  <div id="menu">
    <h3 id="menu_title"><a href="http://localhost/">我的网站</a></h3>
    <ul>
      <li><a href="http://localhost/mc-admin/post.php">文章</a></li>
      <li><a href="http://localhost/mc-admin/page.php">页面</a></li>
      <li class="current"><a href="./setting_files/setting.php">设置</a></li>
    </ul>
    <div class="clear"></div>
  </div>
  <div id="content">
    <div id="content_box">
<form action="./setting_files/setting.php" method="post">
    <div class="admin_page_name">站点设置</div>
  <div class="small_form small_form2">
    <div class="field">
      <div class="label">网站标题</div>
      <input class="textbox" type="text" name="site_name" value="我的网站">
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">网站描述</div>
      <input class="textbox" type="text" name="site_desc" value="有一个MiniCMS网站">
      <div class="info">用简洁的文字没描述本站点。</div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">网站地址</div>
      <input class="textbox" type="text" name="site_link" value="">
      <div class="info"></div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">站长昵称</div>
      <input class="textbox" type="text" name="user_nick" value="某人">
      <div class="info"></div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">后台帐号</div>
      <input class="textbox" type="text" name="user_name" value="admin">
      <div class="info"></div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">后台密码</div>
      <input class="textbox" type="password" name="user_pass">
      <div class="info"></div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">确认密码</div>
      <input class="textbox" type="password">
      <div class="info"></div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">评论代码</div>
      <textarea rows="5" class="textbox" name="comment_code"></textarea>
      <div class="info">第三方评论服务所提供的评论代码，例如：<a href="http://disqus.com/" target="_blank">Disqus</a>、<a href="http://open.weibo.com/widget/comments.php" target="_blank">新浪微博评论箱</a> 等。设置此选项后，MiniCMS就拥有了评论功能。</div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label"></div>
      <div class="field_body"><input class="button" type="submit" name="save" value="保存设置"></div>
      <div class="info"></div>
    </div>
    <div class="clear"></div>
  </div>
</form>
    </div>
  </div>
  <div id="footer"><div id="footer_box">感谢使用 <a href="http://localhost/mc-admin/conf.php#">MiniCMS</a> 进行创作<span>1.0 版本</span></div></div>


</body></html>