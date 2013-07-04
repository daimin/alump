<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'setting-handler.php'?>
  <div id="content">
     <?php setting_message()?>
    <div id="content_box">
<form action="" method="post">
    <input type="hidden" name="action" value="site" />
    <div class="admin_page_name">个人设置</div>
  <div class="small_form small_form2">
    
    <div class="clear"></div>
    <div class="field">
      <div class="label">关键字</div>
      <input class="textbox" type="text" name="site_keyword" value="<?php echo ALump::$options->keywords?>">
      <div class="info">请以半角逗号","分割多个关键字.</div>
    </div>
    <div class="field">
      <div class="label"></div>
      <div class="field_body"><input class="button" type="submit" name="save" value="保存设置"></div>
      <div class="info"></div>
    </div>
    <div class="clear"></div>
  </div>
</form>
    </div>
    <div id="prefile-box">
        <div class="field">
            <div class="label">昵称</div>
            <input class="textbox" type="text" name="site_name" value="<?php echo ALump::$options->title?>">
          </div>
          <div class="clear"></div>
          <div class="field">
            <div class="label">个人主页地址</div>
            <textarea rows="5" class="textbox" name="site_desc"><?php echo ALump::$options->description?></textarea>
            <div class="info">用简洁的文字没描述本站点。</div>
          </div>
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

};
</script>
<?php include 'foot.php'?>