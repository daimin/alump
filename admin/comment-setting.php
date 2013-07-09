<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'setting-handler.php'?>
  <div id="content">
     <?php setting_message()?>
    <div id="content_box">
<form action="" method="post">
    <input type="hidden" name="action" value="comment" />
    <div class="admin_page_name">站点设置</div>
  <div class="small_form small_form2">
 <div class="field">
      <div class="label">评论日期格式</div>
      <div class="textbox">
      <input type="text" name="commentDateFormat" value="<?php echo ALump::$options->commentDateFormat?>">
      </div>
      <div class="info">这是一个默认的格式,当你在模板中调用显示评论日期方法时, 如果没有指定日期格式, 将按照此格式输出.<br/>
具体写法请参考<a target="_blank" href="http://www.php.net/manual/zh/function.date.php">PHP日期格式写法</a>.</div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">评论列表数目</div>
      <div class="textbox">
      <input  type="text" size="5" name="commentsListSize" value="<?php echo ALump::$options->commentsListSize?>">
      </div>
      <div class="info">此数目用于指定显示在侧边拦中的评论列表数目.</div>
    </div>    
    <div class="clear"></div>
    <div class="field">
      <div class="label">评论显示</div>
      <div class="textbox">
      <div class="multiline">
      <input type="checkbox" id="commentsPageBreak" name="commentsPageBreak" value="1">
      <label for="commentsPageBreak">启用分页, 并且每页显示
          <input type="text" size="2" name="commentsPageSize" value="<?php echo ALump::$options->commentsPageSize ?>" />
          篇评论, 在列出时将
          <select name="commentsPageDisplay">
              <option value="first">第一页</option>
              <option value="last">最后一页</option>
          </select>
          作为默认显示</label>
      </div>
      <div class="multiline">
      <input type="checkbox" id="commentsAvatar" name="commentsPageBreak" value="1">
      <label for="commentsPageBreak">启用<a target="_blank" href="http://cn.gravatar.com/">Gravatar</a>头像服务, 最高显示评级为
          <select id="commentsShow-commentsAvatarRating" name="commentsAvatarRating">
            <option value="G" selected="true">G - 普通</option>
            <option value="PG">PG - 13岁以上</option>
            <option value="R">R - 17岁以上成人</option>
            <option value="X">X - 限制级</option></select>
      </label>
      </div>
      <div class="multiline">
      <input type="checkbox" id="commentsReply" name="commentsReply" value="1">
      <label for="commentsReply">启用评论回复，以  
          <input type="text" size="2" name="commentsMaxNestingLevels" value="<?php echo ALump::$options->commentsMaxNestingLevels ?>" />
         层作为每个评论最多的回复层数</br>
         将<select id="commentsShow-commentsOrder" name="commentsOrder">
            <option value="DESC">较新的</option>
            <option value="ASC" selected="true">较旧的</option></select>
         的评论显示在前面
      </label>
      </div>

      </div>
    </div>
    <div class="clear"></div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">评论提交</div>
      <div class="textbox">
      <div class="multiline">
      <input type="checkbox" id="commentsRequireModeration" name="commentsRequireModeration" value="1">
      <label for="commentsRequireModeration">所有评论必须经过审核</label>
      </div>
      <div class="multiline">
      <input type="checkbox" id="commentsRequireMail" name="commentsRequireMail" value="1">
      <label for="commentsRequireMail">必须填写邮箱</label>
      </div>
      <div class="multiline">
      <input type="checkbox" id="commentsRequireURL" name="commentsRequireURL" value="1">
      <label for="commentsRequireURL">必须填写网址</label>
      </div>
      <div class="multiline">
      <input type="checkbox" id="commentsAutoClose" name="commentsAutoClose" value="1">
      <label for="commentsRequireURL">在文章发布<input type="text" size="2" name="commentsPostTimeout">天以后自动关闭评论</label>
      </div>
      <div class="multiline">
      <input type="checkbox" id="commentsPostIntervalEnable" name="commentsPostIntervalEnable" value="1">
      <label for="commentsPostIntervalEnable">同一IP发布评论的时间间隔限制为<input type="text" size="2" name="commentsPostInterval">分钟</label>
      </div>
      </div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">允许使用的HTML标签</div>
      <textarea name="commentsHTMLTagAllowed" rows="4" class="textbox"></textarea>
      <div class="info">默认的用户评论不允许填写任何的HTML标签, 你可以在这里填写允许使用的HTML标签.</div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">IP过滤</div>
      <textarea name="commentsIPDisallowed" rows="4" class="textbox"></textarea>
      <div class="info">禁止拥有此IP的用户发表留言/评论。每行一个。<br/>
      例如：<br/>192.168.211.11<br/>192.168.211.*<br/>192.168.*</div>
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