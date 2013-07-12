<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'attach-handler.php'?>

    <div id="content">
    <div id="content_box">
<script type="text/javascript">

</script>
<div class="admin_page_name">附件管理</div>
<div class="table_list_tool">
  <span>
  批量操作：<a  href="javascript:void(0)" onclick="apply_all('delete', 'ids')">删除</a>
  </span>
  <span style="float:right">
    <input type="text" name="keyword" id="keyword" placeholder="输入搜索关键字" value="<?php echo ALump::$request->get("keyword")?>">
    <input type="submit" value="筛选" onclick="do_filter();"/>
  </span>
</div>
<div class="table_list post_list">
<table colspan="0" rowspan="0" cellpadding="0" cellspacing="0" class="table_list">
  <thead>
    <tr>
    <td style="width:30px"><input type="checkbox" name="ids" onclick="if(this.checked==true) { check_all('ids'); } else { clear_all('ids'); }" value=""/></td>
    <td style="width:55%">文件</td>
    <td class="td-title" style="width:20%">作者</td>
    <td class="td-title" style="width:20%">日期</td>
    </tr>
  </thead>
  <tbody>
  <?php ALump::Lump('Attach_List_Admin')->to($attachs); ?>
       <?php if($attachs->have()){ ?>
       <?php while($attach = $attachs->next()){ ?>
      <tr <?php $attachs->alt(' class="even"', ''); ?>>
      <td><input type="checkbox" name="ids" value="<?php echo $attach->id?>"/></td>
      <td class="td-list" style="text-align: left;font-size:10px;padding:3px 0 3px 0;vertical-align: middle;">
        <?php $attach->attachHeadImg(); ?><a class="row_name" target="_blank" href="<?php $attach->attachEditLink(); ?>"><?php echo $attach->title?></a>
        <div class="row_tool">
          <a class="link_button" href="post-edit.php?id=<?php echo $attach->id?>">编辑</a>
          <a class="link_button" href="javascript:void(0)" onclick="remove_attach('<?php echo $attach->id?>')">永久删除</a>
        </div>
      </td>
      <td class="td-list"><?php echo $attach->author()->name?></td>
      <td class="td-list"><?php echo ALump_Date::format($attach->created, "Y年m月d日 H时i分s秒")?></td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr class="even">
        <td colspan="5" class="td-list"><h4><?php echo '没有任何附件'; ?></h4></td>
    </tr>
    <?php }?>
    </tbody>
  <tfoot>
    <tr>
    <td><input type="checkbox" name="ids" onclick="if(this.checked==true) { check_all('ids'); } else { clear_all('ids'); }" value=""/></td>
    <td style="width:55%">文件</td>
    <td class="td-title" style="width:20%">作者</td>
    <td class="td-title" style="width:20%">日期</td>
    </tr>
  </tfoot>
</table>
</div>
<div class="table_list_tool">
<?php $attachs->pageNav()?>
</div>
    </div>
  </div>
  <script type="text/javascript">

  function remove_attach(postid){
  	 if (confirm("删除附件？"))
  	  {
  	    var args = {
  	    	    "action":"delete",
  	    	    "id":encodeURIComponent(postid)
  	    	    };
  	    
  	    $.post("",args, function (data, textStatus){
  		    window.location.reload();
  		});
  	  }
  }
  
 $(function(){
    $('.td-list a').imgPreview({
      containerID: 'imgPreviewWithStyles',
      imgCSS: {
          // Limit preview size:
          height: 200
      },
      // When container is shown:
      onShow: function(link){
          // Animate link:
          $(link).stop().animate({opacity:0.4});
          // Reset image:
          $('img', this).stop().css({opacity:0});
      },
      // When image has loaded:
      onLoad: function(){
          // Animate image
          $(this).animate({opacity:1}, 300);
      },
      // When container hides: 
      onHide: function(link){
          // Animate link:
          $(link).stop().animate({opacity:1});
      }
  });
 });
</script>
<?php include 'foot.php'?>