<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'setting-handler.php'?>
  <div id="content">
     <?php setting_message()?>
    <div id="content_box">
<form action="" method="post">
    <input type="hidden" name="action" value="post" />
    <div class="admin_page_name">文章设置</div>
  <div class="small_form small_form2">
    <div class="field">
      <div class="label">文章日期格式</div>
      <div class="textbox">
      <input type="text" name="postDateFormat" value="<?php echo ALump::$options->postDateFormat?>">
      </div>
      <div class="info">此格式用于指定显示在文章归档中的日期默认显示格式.<br/>
在某些主题中这个格式可能不会生效, 因为主题作者可以自定义日期格式.<br/>
具体写法请参考<a target="_blank" href="http://www.php.net/manual/zh/function.date.php">PHP日期格式写法</a>.</div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">站点首页</div>
      <div class="textbox">
      <input  type="radio" id="frontPage_recent" name="frontPage" value="recent">
       <label for="site_rewrite_no">显示最新发布的文章</label><br/>
       <input  type="radio" id="frontPage_page" name="frontPage" value="page">
       <label for="site_rewrite_yes">使用
          <?php Alump::Lump('Contents_Page_List')->to($pages); ?>
          <select name="pages" id="frontPage_pages_chk" />
          <?php while($page = $pages->next()): ?>
          <option <?php if(isCurPage(ALump::$options->frontPage, $page->id)): ?> selected="selected" <?php endif; ?> value="<?php echo $page->id ?>"><?php $page->title()?></option>
          <?php endwhile; ?>
          </select>
          作为首页</label>
      </div>     
      
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">文章列表数目</div>
      <div class="textbox">
      <input  type="text" size="10" name="postsListSize" value="<?php echo ALump::$options->postsListSize?>">
      </div>
      <div class="info">此数目用于指定显示在侧边拦中的文章列表数目.</div>
    </div>
    <div class="clear"></div>
    <div class="field">
      <div class="label">每页文章数目</div>
       <div class="textbox">
     <input type="text" size="10" name="pageSize" value="<?php echo ALump::$options->pageSize?>">
      </div>
     <div class="info">此数目用于指定文章归档输出时每页显示的文章数目.</div>
    <div class="clear"></div>
  </div>
    <div class="field">
      <div class="label"></div>
      <div class="field_body"><input class="button" type="submit" name="save" value="保存设置"></div>
      <div class="info"></div>
    </div>
    <div class="clear"></div>
</form>
    </div>
  </div>
  </div>
<script type="text/javascript">
var _$ = function(id){return document.getElementById(id);};

function pagesChecked(frontPage){
    var frontPage_pages_chk = _$("frontPage_pages_chk");
    var frontPage = frontPage.split(":");
    if(frontPage.length < 2 ){
        return;
    }
    var frontPageId = frontPage[1];
    if(frontPage_pages_chk){
        var opts = frontPage_pages_chk.options;
        for(var i = 0,len = opts.length; i < len; i++){
            var opt = opts[i];
            if(opt.value == frontPageId){
                opt.checked = true;
            }
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

function frontPageChecked(){
    var frontPage = '<?php echo ALump::$options->frontPage?>';
    if(frontPage == 'recent'){
        _$("frontPage_recent").checked = true;
    }else{
        _$("frontPage_page").checked = true;
        pagesChecked(frontPage);
    }
}
window.onload = function(){
    frontPageChecked();
    handlerInfoInterval();
};
</script>

<?php include 'foot.php'?>