<?php include 'inc.php';?>
<?php include 'comment-handler.php'?>
<?php include 'head.php' ?>
<?php include 'menu.php'?>
    <div id="content">
    <div id="content_box">
<script type="text/javascript">

</script>
<div class="admin_page_name">评论管理</div>
<div class="admin_tab">
    <div><a href="?s=adopt" <?php is_current_class('adopt') ?>>通过 ( <?php getCommentCountByStatus(ALump_Common::$ADOPT) ?> )</a></div>
    <div>|</div><div><a href="?s=audit" <?php is_current_class('audit') ?>>待审核 ( <?php getCommentCountByStatus(ALump_Common::$AUDIT) ?> )</a></div>
    <div>|</div><div><a href="?s=trash" <?php is_current_class('trash') ?>>垃圾评论 ( <?php getCommentCountByStatus(ALump_Common::$TRASH) ?> )</a></div></div>
<div class="table_list_tool" style="float:left;width:100%;">
  <span>
  批量操作：<a  href="javascript:void(0)" onclick="apply_all('adopt', 'ids')">通过</a>，
  <a  href="javascript:void(0)" onclick="apply_all('audit', 'ids')">待审核</a>，
  <a  href="javascript:void(0)" onclick="apply_all('trash', 'ids')">标记为垃圾</a>，
  <a  href="javascript:void(0)" onclick="apply_all('delete', 'ids')">删除</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
    
  </span>
  <span style="float:right">
    <input type="text" name="k" id="k" placeholder="输入搜索关键字" value="<?php echo ALump::$request->get("k")?>">
    <input type="submit" value="筛选" onclick="search_comment();"/>
  </span>
</div>
<div class="table_list post_list">
<table colspan="0" rowspan="0" cellpadding="0" cellspacing="0" class="table_list">
  <thead>
    <tr>
    <td style="width:30px"><input type="checkbox" name="ids" onclick="if(this.checked==true) { check_all('ids'); } else { clear_all('ids'); }" value=""/></td>
    </tr>
  </thead>
  <tbody>
  <?php ALump::Lump('Comments_List_Admin')->to($comments); ?>
       <?php if($comments->have()){ ?>
       <?php while($comment = $comments->next()){ ?>
      <tr <?php $comments->alt(' class="even"', ''); ?>>
      <td class="td-list" id="co_td_<?php echo $comment->id ?>" style="text-align: left;font-size:10px;padding:6px 0 6px 0;">
          <div id="td_list_content_<?php echo $comment->id ?>">
          <div style="margin-bottom: 6px;">
              <input type="checkbox" name="ids" value="<?php echo $comment->id?>"/>
              <span><a href="<?php to_current_url('k='.$comment->author(True)) ?>"><?php $comment->author(False)?></a></span>，
              <span><a href="mailto:<?php echo $comment->mail?>"><?php echo $comment->mail?></a>，</span>
              <span><a href="<?php to_current_url('k='.$comment->ip) ?>"><?php echo $comment->ip?></a></span>
              <img src="<?php echo ALump_Common::showGravatar($comment->mail ,40) ?>" style="margin-right:6px;float:right"/>
          </div>
           
          <div style="float:left;line-height:20px;padding-left: 12px;"><?php echo $comment->content ?></div>
          <div class="row_tool" style="margin-bottom: 6px;clear: left;padding-left:24px;float:left;" >
          <?php renderCommentTool($comment) ?>
          
        </div>
          <div style="float:right;margin-right:12px;margin-top:12px;">评论于 <?php echo ALump_Date::format($comment->created) ?></div>
     <div>
</td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr class="even">
        <td colspan="5" class="td-list"><h4><?php echo '没有任何页面'; ?></h4></td>
    </tr>
    <?php }?>
    </tbody>
  <tfoot>
    <tr>
    <td><input type="checkbox" name="ids" onclick="if(this.checked==true) { check_all('ids'); } else { clear_all('ids'); }" value=""/></td>
    </tr>
  </tfoot>
</table>
</div>
<div class="table_list_tool">
<?php $comments->pageNav()?>
</div>
    </div>
  </div>
  <script type="text/javascript">

  function remove_post(postid){
  	 if (confirm("删除文章？"))
  	  {
  	    var args = {
  	    	    "action":"delete",
  	    	    "ids":encodeURIComponent(postid)
  	    	    };
  	    
  	    $.get("",args, function (data, textStatus){
  		    window.location.reload();
  		});
  	  }
  }
  
  function search_comment(){
      location.href = '<?php echo to_current_url()?>&k=' + $("#k").val();
  }
  
  function changeCommentStatus(id, status){
      var args = {
  	    	    "action":"changeStatus",
  	    	    "id":encodeURIComponent(id),
                "status":status
  	    	    };
      $.post("",args, function (data, textStatus){
  		    window.location.reload();
  		});
  }
  
  function removeComment(id){
      if(window.confirm("确认删除该条评论？")){
           var args = {
  	    	    "action":"remove",
  	    	    "id":encodeURIComponent(id)
  	    	    };
            $.post("",args, function (data, textStatus){
                  window.location.reload();
            });
      }
      
  }
  
  function editComment(id){
      var args = {
  	    	    "action":"getComment",
  	    	    "id":encodeURIComponent(id),
                "status":status
  	    	    };
      $.post("",args, function (data, textStatus){
            var comment = eval("("+data+")");
  		    var edit_html = ' <div id="comment_form_' + id + '" class="comment-form"><br/>\n\
                       <div>\n\
                       <label for="author-' + id + '">姓名: </label>\n\
                       <input type="text" class="text" name="author" id="author-' + id + '" value="' + comment['author'] + '">\n\
                       <label for="mail">电子邮件: </label>\n\
                       <input type="text" class="text" name="mail" id="mail-' + id + '" value="' + comment['mail'] + '">\n\
                       <label for="url">个人主页: </label>\n\
                      <input type="text" class="text" name="url" id="url-' + id + '" value="' + comment['url'] + '">\n\
                      </div><br/>\n\
                      <textarea name="content" rows="6" id="content-' + id + '">' + comment['content'] + '</textarea>\n\
                     <p><button style="float:left;" id="cancel-' + id + '" onclick="cancelEditComment(\'' + id + '\')"> &nbsp;取消&nbsp; </button>\n\
                        <button style="float:right;background:#2789B5;color:#fff;"  id="submit-' + id + '" onclick="submitEditComment(\'' + id + '\')"> &nbsp;保存评论&nbsp; </button>\n\
                     </p></div>';
            $("#td_list_content_" + id).hide();
            $("#co_td_" + id).append(edit_html);
     });
     
   }
   
   function cancelEditComment(id){
       $("#comment_form_" + id).remove();
       $("#td_list_content_" + id).fadeIn(500);
   }
   
   function submitEditComment(id){
       var args = {
  	    	    "action":"update",
  	    	    "id":encodeURIComponent(id),
                "author":encodeURIComponent($("#author-" + id).val()),
                "mail":encodeURIComponent($("#mail-" + id).val()),
                "url":encodeURIComponent($("#url-" + id).val()),
                "content":encodeURIComponent($("#content-" + id).val())
  	   };
       $.post("",args, function (data, textStatus){
           window.location.reload();
       });
   }
</script>
<?php include 'foot.php'?>