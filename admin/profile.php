<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'setting-handler.php'?>
 <div id="content">
      <?php setting_message()?>
    <div id="content_box">
<div class="admin_page_name">个人设置</div>

<div class="manage_div" >
<div class="setting-list">
   <div class="brief">
       <?php $logUser = getLoginUser(); ?>
       <div class="profile-name"><span><?php echo $logUser->nickname ?></span> (<?php echo $logUser->name ?>) </div>
       <div class="profile-info">
          <div class="profile-info-text"> <?php printBrief($logUser) ?></div>
          <div class="profile-info-img"><img src="<?php echo ALump_Common::showGravatar($logUser->mail, 48) ?>" /></div>
       </div>
   </div>
   <div class="cpassword">
       <div class="head">修改密码</div>
       <?php cpasswordError() ?>
       <form name="p-form" method="post">
        <input type="hidden" value="change-password" name="action" />
       <table class="form-tab form-100">
        <tbody>
        <tr>
        <td class="form-field"><span class="label">旧密码：</span></td><td>
            <input type="text" name="old_password" />
            <div class="narrator">用户登录时使用的密码.</div>
            <div class="clear"></div>
        </td>
        </tr>
        <tr>
        <td class="form-field"><span class="label">新密码：</span></td><td>
            <input type="text" name="new_password" />
            <div class="narrator">用户指定自己的新密码.<br/>建议使用特殊字符与字母的混编样式,以增加系统安全性.</div>
            <div class="clear"></div>
        </td>
        </tr>
        <tr>
        <td class="form-field"><span class="label">密码确认：</span></td><td>
            <input type="text" name="re_password" />
            <div class="narrator">请确认你的密码, 与上面输入的密码保持一致.</div>
            <div class="clear"></div>
        </td>
        </tr>
        <tr>
        <td colspan="2" align="right"><input type="submit" name="add-cate-btn" value=" 修改密码 " /></td>
        </tr>
        </tbody>
        </table>
       </form>
   </div>
</div>
</div>
<div class="form-div div-right side-right-div">
<form name="p-form" method="post">
<input type="hidden" value="update-profile" name="action" />
<input type="hidden" value="" name="cid" />
<table class="form-tab form-100 tab-background">
<tbody>
<tr>
<td class="form-field"><div class="label">昵称：</div><input type="text"  size="28" name="nickname" value="<?php echo $logUser->nickname ?>"/>
    <div class="narrator">用户昵称可以与用户名不同, 用于前台显示.如果你将此项留空,将默认使用用户名.</div></td>
</tr>
<tr>
<td class="form-field"><div class="label">个人主页地址：</div><input type="text"  size="28" name="url"  value="<?php echo $logUser->url ?>"/>
    <div class="narrator">此用户的个人主页地址, 请用http://开头.</div></td>
</tr>
<tr>
<td class="form-field"><div class="label">电子邮箱地址*：</div><input type="text"  size="28" name="mail"  value="<?php echo $logUser->mail ?>"/>
    <div class="narrator">电子邮箱地址将作为此用户的主要联系方式.
请不要与系统中现有的电子邮箱地址重复.</div>
<?php cprofileError() ?>
</td>
</tr>
<tr>
<td colspan="2" align="right"><input type="submit" name="add-cate-btn" value=" 更新档案 " /></td>
</tr>
</tbody>
</table>
</form>
</div>
    </div>
  </div>
<script type="text/javascript">
 function handlerInfoInterval(){
    var settingHanderInfos = $(".setting-hander-info");
    settingHanderInfos.each(function(){
        (function(obj){
            window.setInterval(function(){
                $(obj).remove();
            }, "4000");
            
        })(this);
       
    });
}

$(function(){
    handlerInfoInterval();
});
</script>
<?php include 'foot.php'?>