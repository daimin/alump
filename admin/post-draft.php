<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'post-handler.php'?>

    <div id="content">
    <div id="content_box">
<script type="text/javascript">

</script>
<div class="admin_page_name">文章草稿箱<a class="link_button" href="post-add.php">撰写文章</a></div>
<div class="table_list_tool">
  <span>
    批量操作：<a  href="javascript:void(0)" onclick="apply_all('delete', 'ids')">删除</a>，<a  href="javascript:void(0)" onclick="apply_all('topublish', 'ids')">发布</a>
    </span>
  <span style="float:right;">
    <input type="text" name="keyword" id="keyword" placeholder="输入搜索关键字" value="<?php echo ALump::$request->get("keyword")?>">
    <select id="category" name="category"  ><option value="">所有分类</option>
    <?php 
     ALump::Lump("Metas_Category_List")->to($categorys);
     ?>
     <?php while($category = $categorys->next()):?>
     <option value="<?php echo $category->slug?>" <?php $category->selected("slug", "category")?>><?php echo $category->name ?></option>
     <?php endwhile?>
     </select>
    <input type="submit" value="筛选" onclick="do_filter();"/>
  </span>
</div>
<div class="table_list post_list">
<table colspan="0" rowspan="0" cellpadding="0" cellspacing="0" class="table_list">
  <thead>
    <tr>
    <td style="width:30px"><input type="checkbox" name="ids" onclick="if(this.checked==true) { check_all('ids'); } else { clear_all('ids'); }" value=""/></td>
    <td style="width:65%">标题</td>
    <td class="td-title" style="width:10%">作者</td>
    <td class="td-title" style="width:10%">分类</td>
    <td class="td-title" style="width:10%">日期</td>
    </tr>
  </thead>
  <tbody>
  <?php ALump::Lump('Contents_Post_Draft_Admin')->to($posts); ?>
       <?php if($posts->have()){ ?>
       <?php while($post = $posts->next()){ ?>
      <tr <?php $posts->alt(' class="even"', ''); ?>>
      <td><input type="checkbox" name="ids" value="<?php echo $post->id?>"/></td>
      <td>
        <a class="row_name" href="post-edit.php?id=<?php echo $post->id?>"><?php echo $post->title?></a>
        <div class="row_tool">
          <a class="link_button" href="post-edit.php?id=<?php echo $post->id?>">编辑</a>
                    <a class="link_button" href="javascript:void(0)" onclick="remove_post('<?php echo $post->id?>')">删除</a>
        </div>
      </td>
      <td class="td-list"><?php echo $post->author()->name?></td>
      <td class="td-list"><?php echo $post->category()->name?></td>
      <td class="td-list"><?php echo ALump_Date::format($post->created, "Y-m-d")?></td>
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
    <td>标题</td>
    <td class="td-title">作者</td>
    <td class="td-title">分类</td>
    <td class="td-title">日期</td>
    </tr>
  </tfoot>
</table>
</div>
<div class="table_list_tool">
<?php $posts->pageNav()?>
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
</script>
<?php include 'foot.php'?>