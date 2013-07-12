<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'jqueryui-include.php'?>
<?php include 'post-handler.php'?>

  <div id="content">
    <div id="content_box">
<form action="" name="post-form" id="post-form" method="post" >
<div id="message" class="updated" style="display: none;">
</div>
  <input type="hidden" name="action" value="post_add">
  <table >
  <tbody>
  <tr>
  <td colspan="2">
    <div class="admin_page_name">
  撰写文章  </div>
  </td>
  </tr>
  <tr>
  <td colspan="2">
    <input name="title" type="text" size="110" placeholder="在此输入标题"  style="color:#888;height:24px;" >
  </td>
   </tr>
    <tr>
  <td colspan="2">
    <textarea id="post-content" name="content" cols="110" rows="25" ></textarea>
  </td>
  </tr>
   <tr>
  <td colspan="2">
    <input name="tags" type="text" size="110" placeholder="在此输入标签，多个标签用英语逗号(,)分隔" style="color:#888;" >
    </td>
  </tr>
   <tr>
  <td >
     <span class="form-field">选择分类：<select name="category"  ><?php 
     ALump::Lump("Metas_Category_List_Admin")->to($categorys);
     ?>
     <?php while($category = $categorys->next()):?>
     <option value="<?php echo $category->slug?>" <?php $category->selected("slug", "category")?>><?php echo $category->name ?></option>
     <?php endwhile?>
     </select></span> 
     </td>
     <td>
     <span class="form-field"> 时间：<input type="text" name="created" id="created" value="<?php echo Alump_Date::getNow()?>" />&nbsp;&nbsp;<span class="narrator">请选择一个发布日期</span></span> 
      </td>
  </tr>
     <tr>
  <td colspan="2" valign="top">
 <div id="advande-setting" onclick="open_advance_setting()">高级选项<i class="icon-chevron-down"></i></div>
    <div id="advande-setting-div"  style="display: none;">
<!--     <div>引用通告<span class="narrator">( 每一行一个引用地址, 用回车隔开 )</span><br/><textarea name="trackback" cols="110" rows="4"></textarea></div> -->
    <table>
    <tbody>
    <tr>
    <td nowrap="nowrap">
        <span class="form-field">密码：<input type="password" name="password"  /><br/>
        <span class="narrator">为这篇日志分配一个密码, 访问者需要输入密码才能阅读到日志的内容</span></span>
        </td>
        <td>
        <span class="form-field">缩略名：<input type="text" name="slug" /><br/>
        <span class="narrator">为这篇日志自定义链接地址, 有利于搜索引擎收录</span></span>
         </td>
         </tr>
         <tr>
        <td colspan="3" >
           <span class="form-field"> 
           <input type="checkbox" name="can_comment" id="can_comment" value="1"  checked="checked" />
           <label for="can_comment">允许评论</label>
           <input type="checkbox" name="can_rss" id="can_rss" value="1"  checked="checked" />
           <label for="can_rss">允许在聚合中出现</label>
             
           </span>
         
    </td>
        <td>
    </tr>
    </tbody>
    </table>
  </div>

          </td>
  </tr>
       <tr>
  <td colspan="2">
  <div style="text-align:right;margin-right: 30px;">
    <input type="hidden" name="id" value="">
    <input type="hidden" name="attachs" id="attachs" value="">
    <input type="hidden" name="drafted" id="drafted" value="1" />
    <input type="button" class="button" name="draft" value="保存草稿" onclick="dosumbit(0)" style="font-style: italic;margin-right: 30px;">
    <input type="submit" class="button" name="save" value="发布文章 »" onclick="dosumbit(1)" style="font-weight: bold;">
  </div>
            </td>
  </tr>
  </tbody>
  </table>
</form>
    </div>
  </div>
  <link rel="stylesheet" href="kindeditor/themes/default/default.css" />
	<script type="text/javascript" charset="utf-8" src="kindeditor/kindeditor-min.js"></script>
	<script type="text/javascript" charset="utf-8" src="kindeditor/lang/zh_CN.js"></script>
	<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('#post-content', {
					uploadJson : '<?php 
					ALump::$options->siteUrl("folks/upload")?>',
					fileManagerJson:'<?php 
					ALump::$options->siteUrl("folks/fileManager/")?>',
					allowFileManager : true,
					afterUpload : function(data) { 
						var fname = getFileNameFromUrl(data);
						$("#attachs").val($("#attachs").val() + fname + "|");
				    } 
				});
			});

			$(function() {
				$( "#created" ).datetimepicker({dateFormat:"yy-mm-dd",timeFormat:"HH:mm:ss"});
			});

			function dosumbit(action){
				if(action == 1){ //发布
					$("#drafted").val(0);
					
				}else{
					$("#drafted").val(1);
				}
				$("#post-content").val(editor.html());
				$("#post-form").get(0).submit();
				return true;
			}


		</script>
  
<?php include 'foot.php'?>