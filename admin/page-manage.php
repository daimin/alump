<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'page-handler.php'?>

    <div id="content">
    <div id="content_box">
<script type="text/javascript">

</script>
<div class="admin_page_name">管理页面<a class="link_button" href="page-add.php">创建页面</a>&nbsp;<span class="narrator">拖拽表格行进行排序</span></div>
<div class="table_list_tool">
  <span>
  批量操作：<a  href="javascript:void(0)" onclick="apply_all('delete', 'ids')">删除</a>，
  <a  href="javascript:void(0)" onclick="apply_all('todraft', 'ids')">转为草稿</a>，
  <a  href="javascript:void(0)" onclick="apply_all('topublish', 'ids')">发布</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
  </span>
  <span style="float:right">
    <input type="text" name="keyword" id="keyword" placeholder="输入搜索关键字" value="<?php echo ALump::$request->get("keyword")?>">
    <input type="submit" value="筛选" onclick="do_filter();"/>
  </span>
</div>
<div class="table_list post_list">
<table colspan="0" rowspan="0" cellpadding="0" cellspacing="0" class="table_list" id="page-list-tab">
  <thead>
    <tr>
    <td style="width:30px"><input type="checkbox" name="ids" onclick="if(this.checked==true) { check_all('ids'); } else { clear_all('ids'); }" value=""/></td>
    <td style="width:60%">标题</td>
    <td class="td-title" style="width:10%">作者</td>
    <td class="td-title" style="width:10%">日期</td>
    <td class="td-title" style="width:8%">查看</td>
    <td class="td-title" style="width:8%">评论</td>
    </tr>
  </thead>
  <tbody>
  <?php ALump::Lump('Contents_Page_Admin')->to($posts); ?>
       <?php if($posts->have()){ ?>
       <?php while($post = $posts->next()){ ?>
      <tr <?php $posts->alt(' class="even"', ''); ?> id="page_<?php echo $post->id?>">
      <td><input type="checkbox" name="ids" value="<?php echo $post->id?>"/></td>
      <td>
        <a class="row_name" href="page-edit.php?id=<?php echo $post->id?>"><?php echo $post->title?><?php $post->onDraft('<span class="markup">草稿</span>')?></a>
      </td>
      <td class="td-list"><?php echo $post->author()->name?></td>
      <td class="td-list"><?php echo ALump_Date::format($post->created, "Y-m-d")?></td>
      <td class="td-list"><?php echo $post->view_count?></td>
      <td class="td-list"><?php echo $post->comment_count?></td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr class="even">
        <td colspan="6" class="td-list"><h4><?php echo '没有任何页面'; ?></h4></td>
    </tr>
    <?php }?>
    </tbody>
  <tfoot>
    <tr>
    <td><input type="checkbox" name="ids" onclick="if(this.checked==true) { check_all('ids'); } else { clear_all('ids'); }" value=""/></td>
    <td>标题</td>
    <td class="td-title">作者</td>
    <td class="td-title">日期</td>
    <td class="td-title">查看</td>
    <td class="td-title">评论</td>
    </tr>
  </tfoot>
</table>
</div>
    </div>
  </div>
  <script src="js/tablednd.js"></script>
  <script type="text/javascript">

  $(function(){
		 var table = document.getElementById('page-list-tab');
		 var tableDnD = new TableDnD();
		 tableDnD.init(table);
		 tableDnD.onDrop = function(table, row) {
			    var rows = this.table.tBodies[0].rows;
			    var order = 0;
			    for (var i=1; i<=rows.length; i++) {
				    if(row.id == rows[i-1].id){
				    	order = i;
					}
				    if(i%2==0){
			    	   $(rows[i-1]).addClass("even");
				    }else{
				       $(rows[i-1]).removeClass("even");
				    }
			    }
			    function getPages(cateId){
			    	return cateId.split("_");
			    }
			    var srcPages = getPages(row.id);
			   
			    var args = {
			    	    "action":"sortOrder",
			    	    "order":order,
			    	    "id":srcPages[1]
			    	    };
			    $.get("",args, function (data, textStatus){
				     //window.location.reload();
				});		    
			};
		 });

	 
  function remove_post(postid){
  	 if (confirm("删除页面？"))
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