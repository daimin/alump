<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'setting-handler.php'?>
  <div id="content">
     <?php setting_message()?>
    <div id="content_box">
<form action="" method="post">
    <input type="hidden" name="action" value="site" />
    <div class="admin_page_name">站点设置</div>
  <div class="small_form small_form2">
    <div class="field">
      <div class="label">网站标题</div>
      <input class="textbox" type="text" name="site_name" value="<?php echo ALump::$options->title?>">
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">网站描述</div>
      <textarea rows="5" class="textbox" name="site_desc"><?php echo ALump::$options->description?></textarea>
      <div class="info">用简洁的文字没描述本站点。</div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">关键字</div>
      <input class="textbox" type="text" name="site_keyword" value="<?php echo ALump::$options->keywords?>">
      <div class="info">请以半角逗号","分割多个关键字.</div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">网站URL地址</div>
      <input class="textbox" type="text" name="siteUrl" value="<?php echo trimSiteUrl(ALump::$options->siteUrl)?>">
      <div class="info">例如:http://www.phpblog.cn</div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">时区</div>
     <select class="textbox" name="timezone" id="timezone-0-5">
        <option value="0">
        格林威治(子午线)标准时间 (GMT)</option>
        <option value="3600">
        中欧标准时间 阿姆斯特丹,荷兰,法国 (GMT +1)</option>
        <option value="7200">
        东欧标准时间 布加勒斯特,塞浦路斯,希腊 (GMT +2)</option>
        <option value="10800">
        莫斯科时间 伊拉克,埃塞俄比亚,马达加斯加 (GMT +3)</option>
        <option value="14400">
        第比利斯时间 阿曼,毛里塔尼亚,留尼汪岛 (GMT +4)</option>
        <option value="18000">
        新德里时间 巴基斯坦,马尔代夫 (GMT +5)</option>
        <option value="21600">
        科伦坡时间 孟加拉 (GMT +6)</option>
        <option value="25200">
        曼谷雅加达 柬埔寨,苏门答腊,老挝 (GMT +7)</option>
        <option value="28800">
        北京时间 香港,新加坡,越南 (GMT +8)</option>
        <option value="32400">
        东京平壤时间 西伊里安,摩鹿加群岛 (GMT +9)</option>
        <option value="36000">
        悉尼关岛时间 塔斯马尼亚岛,新几内亚 (GMT +10)</option>
        <option value="39600">
        所罗门群岛 库页岛 (GMT +11)</option>
        <option value="43200">
        惠灵顿时间 新西兰,斐济群岛 (GMT +12)</option>
        <option value="-3600">
        佛德尔群岛 亚速尔群岛,葡属几内亚 (GMT -1)</option>
        <option value="-7200">
        大西洋中部时间 格陵兰 (GMT -2)</option>
        <option value="-10800">
        布宜诺斯艾利斯 乌拉圭,法属圭亚那 (GMT -3)</option>
        <option value="-14400">
        智利巴西 委内瑞拉,玻利维亚 (GMT -4)</option>
        <option value="-18000">
        纽约渥太华 古巴,哥伦比亚,牙买加 (GMT -5)</option>
        <option value="-21600">
        墨西哥城时间 洪都拉斯,危地马拉,哥斯达黎加 (GMT -6)</option>
        <option value="-25200">
        美国丹佛时间 (GMT -7)</option>
        <option value="-28800">
        美国旧金山时间 (GMT -8)</option>
        <option value="-32400">
        阿拉斯加时间 (GMT -9)</option>
        <option value="-36000">
        夏威夷群岛 (GMT -10)</option>
        <option value="-39600">
        东萨摩亚群岛 (GMT -11)</option>
        <option value="-43200">
        艾尼威托克岛 (GMT -12)</option>
        </select>
      <div class="info"></div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">允许上传的文件类型</div>
      <div class="textbox">
      <div class="multiline">
      <input type="checkbox" id="@image@attachment" name="attachmentTypes[]" value="@image@">
      <label for="@image@attachment">图片文件 gif jpg png tiff bmp</label>
      </div>
       <div class="multiline">
      <input  type="checkbox" id="@media@attachment" name="attachmentTypes[]" value="@media@">
      <label for="@media@attachment">多媒体文件 mp3 wmv wma rmvb rm avi flv</label>
      </div>
       <div class="multiline">
      <input  type="checkbox" id="@doc@attachment" name="attachmentTypes[]" value="@doc@">
      <label for="@doc@attachment">常用档案文件 txt doc docx xls xlsx ppt pptx zip rar pdf</label>
      </div>
      <div class="multiline">
      <input  type="checkbox" id="other@attachment" name="attachmentTypes[]" value="@others@">
      <label for="other@attachment">其他格式 <input type="text" size="20" id="otherAttachment" name="otherAttachment"></label>
      <div class="info" style="width:100%">用逗号 "," 将后缀名隔开, 例如: cpp,h,mak</div>
      </div>
      </div>
    </div>
    <div class="clear"></div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">是否使用地址重写功能</div>
      <div class="textbox">
      <input  type="radio" id="site_rewrite_no" name="site_rewrite" value="0">
       <label for="site_rewrite_no">不启用</label>
       <input  type="radio" id="site_rewrite_yes" name="site_rewrite" value="1">
      <label for="site_rewrite_yes">启用</label>
      </div>
      <div class="info">地址重写即rewrite功能是某些服务器软件提供的优化内部连接的功能.<br/>
打开此功能可以让你的链接看上去完全是静态地址.</div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">独立页面后缀名</div>
      <div class="textbox">
      <input  type="radio" id="suffix_0" name="site_suffix" value="">
       <label for="site_rewrite_no">无</label>
       <input  type="radio" id="suffix_html" name="site_suffix" value=".html">
       <label for="site_rewrite_no">html</label>
       <input  type="radio" id="suffix_htm" name="site_suffix" value=".htm">
       <label for="site_rewrite_no">htm</label>
       <input  type="radio" id="suffix_php" name="site_suffix" value=".php">
       <label for="site_rewrite_no">php</label>
       <input  type="radio" id="suffix_jsp" name="site_suffix" value=".jsp">
       <label for="site_rewrite_no">jsp</label>
       <input  type="radio" id="suffix_aspx" name="site_suffix" value=".aspx">
       <label for="site_rewrite_no">aspx</label>
      </div>
      <div class="info">给独立页面设置一种文件后缀名, 使得它看起来像其它语言开发的一样.</div>
    </div>
     <div class="field">
      <div class="label">登陆时是否使用验证码</div>
      <div class="textbox">
      <input  type="radio" id="loginUseGD_yes" name="loginUseGD" value="1">
       <label for="loginUseGD_yes">是</label>
       <input  type="radio" id="loginUseGD_no" name="loginUseGD" value="0">
      <label for="loginUseGD_no">否</label>
      </div>
      <div class="info">    
只有在服务器支持GD时才可以开启.</div>
    </div>
    <div class="clear"></div>
	<div class="field">
      <div class="label">图像大小</div>
      <div class="textbox">
      缩略图大小 <input type="text" size="4" name="thumbImgSize" value="<?php  echo ALump::$options->thumbImgSize ?>">
      &nbsp;&nbsp;&nbsp;&nbsp;
      裁剪图大小 <input type="text" size="4" name="cropImgSize" value="<?php  echo ALump::$options->cropImgSize ?>">
      </div>
      <div class="info">    
只有在服务器支持GD时才可以开启.<br/>裁剪图表示合乎页面显示的图像.</div>
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
<script type="text/javascript">
var _$ = function(id){return document.getElementById(id);};

function attachmentTypesChecked(){
    var attachmentTypes = '<?php echo ALump::$options->attachmentTypes?>';
    attachmentTypes = attachmentTypes.split(",");
    //@image@,@media@,@doc@,cpp,java
    if(attachmentTypes && attachmentTypes.length > 0){
        var elseat = [];
         for(var i = 0, len = attachmentTypes.length;i < len; i++){
             var at = attachmentTypes[i];
             if(at == '@image@'){
                 _$("@image@attachment").checked = true;
             }else if(at == '@media@'){
                 _$("@media@attachment").checked = true;
             }else if(at == '@doc@'){
                 _$("@doc@attachment").checked = true;
             }else{
                   elseat[elseat.length] =   at;
             }
         }
         
         if(elseat.length > 0){
               _$("other@attachment").checked = true;
               _$("otherAttachment").value = elseat.join(",");
         }
    }
}

function timezoneSelected(){
    var timezoneBoxs = _$("timezone-0-5");
    var options = timezoneBoxs.options;
    var curTimezone = '<?php echo ALump::$options->timezone?>';
    for(var i = 0, len = options.length; i < len;i++){
        if(options[i].value == curTimezone){
            options[i].selected = true;
            break;
        }
    }
}

function handlerInfoInterval(){
    var settingHanderInfo = document.getElementById("setting-hander-info");
    if(settingHanderInfo){
        window.setInterval(function(){
            settingHanderInfo.parentNode.removeChild(settingHanderInfo);
            
        }, "4000");
    }
}

function rewriteChecked(){
    var rewrite = '<?php echo ALump::$options->rewrite?>';
    if(rewrite == 0){
        _$("site_rewrite_no").checked = true;
    }else{
        _$("site_rewrite_yes").checked = true;
    }
}

function loginUseDBChecked(){
    var loginUseGD = '<?php echo ALump::$options->loginUseGD?>';
    if(loginUseGD == 0){
        _$("loginUseGD_no").checked = true;
    }else{
        _$("loginUseGD_yes").checked = true;
    }
}

function suffixChecked(){
    var suffix = '<?php echo ALump::$options->suffix?>';
    if(suffix == '.html'){
        _$("suffix_html").checked = true;
    }else if(suffix == '.htm'){
        _$("suffix_htm").checked = true;
    }else if(suffix == '.php'){
        _$("suffix_php").checked = true;
    }else if(suffix == '.aspx'){
        _$("suffix_aspx").checked = true;
    }else if(suffix == '.jsp'){
        _$("suffix_jsp").checked = true;
    }else{
        _$("suffix_0").checked = true;
    }
}
window.onload = function(){
    timezoneSelected();
    attachmentTypesChecked();
    handlerInfoInterval();
    rewriteChecked();
    suffixChecked();
    loginUseDBChecked();

};
</script>
<?php include 'foot.php'?>