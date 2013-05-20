<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'jqueryui-include.php'?>
<?php include 'meta-handler.php'?>

    <div id="content">
    <div id="content_box">
<div class="admin_page_name">分类管理&nbsp;<span class="narrator">拖拽表格行进行排序</span></div>
<div class="table_list_tool">
</div>
<div class="table_list post_list" >
<table colspan="0" rowspan="0" cellpadding="0" cellspacing="0" class="table_list" id="category-list-tab">
  <thead>
    <tr>
    <td style="width:55%;padding-left: 12px;">名称</td>
    <td class="td-title" style="width:10%">缩略名</td>
    <td class="td-title" style="width:10%">文章数</td>
    <td class="td-title" style="width:10%">删除</td>
    </tr>
  </thead>
  <tbody>
  <?php ALump::Lump('Metas_Category_Admin')->to($categorys); ?>
       <?php if($categorys->have()){ ?>
       <?php while($category = $categorys->next()){ ?>
      <tr <?php $categorys->alt(' class="even"', ''); ?> id="cate_<?php echo $category->id?>" >
      <td style="padding-left: 12px;">
        <a class="row_name" href="?cateid=<?php echo $category->id?>" ><?php echo $category->name?></a>
      </td>
      <td style="text-align:center;"><?php echo $category->slug?></td>
      <td style="text-align:center;"><?php echo $category->count?></td>
      <td style="text-align:center;"><i class="icon-remove" style="cursor: pointer;" onclick="remove_category('<?php echo $category->id?>')"></i></td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr class="even">
        <td colspan="4"><h4><?php echo '没有任何分类'; ?></h4></td>
    </tr>
    <?php }?>
    </tbody>
  <tfoot>
    <tr>
    <td style="width:55%;padding-left: 12px;">名称</td>
    <td class="td-title" style="width:10%">缩略名</td>
    <td class="td-title" style="width:10%">文章数</td>
    <td class="td-title" style="width:10%">删除</td>
    </tr>
  </tfoot>
</table>
</div>
<div class="sep"></div>
<div class="form-div">
 <?php ALump::Lump('Meta_Edit_Category')->to($edit_category); ?>
<form name="cate-form" method="post" onsubmit="return validate_addcate(this)">
<input type="hidden" value="<?php $edit_category->alt("add-category", "update-category")?>" name="action" />
<input type="hidden" value="<?php echo $edit_category->id?>" name="cid" />
<table class="form-tab">
<tbody>
<tr>
<td class="form-field">分类名称*：</td><td><input type="text" name="cname" value="<?php echo $edit_category->name?>" /></td>
</tr>
<tr>
<td class="form-field">分类缩略名：</td><td><input type="text" name="cslug" value="<?php echo $edit_category->slug?>" /></td>
</tr>
<tr>
<td class="form-field">分类描述：</td>
<td><textarea name="description" cols="40" rows="4"><?php echo $edit_category->description?></textarea></td>
</tr>
<tr>
<td colspan="2" align="right"><input type="submit" name="add-cate-btn" value="<?php $edit_category->alt(" 增加分类  ","  编辑分类  ")?>" /></td>
</tr>
</tbody>
</table>
</form>
</div>
    </div>
  </div>
<script src="js/tablednd.js"></script>
<script type="text/javascript">
 function validate_addcate(form){
     if(form.cname.value == ""){
         alert("-- 请输入分类名称");
         return false;
     }else{
        return true;   
     }
 }

 $(function(){
	 var table = document.getElementById('category-list-tab');
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
		    function getCatas(cateId){
		    	return cateId.split("_");
		    }
		    var srcCatas = getCatas(row.id);
		   
		    var args = {
		    	    "action":"sortOrder",
		    	    "order":order,
		    	    "id":srcCatas[1]
		    	    };
		    $.get("",args, function (data, textStatus){
			     //window.location.reload();
			});		    
		};
	 });

 function remove_category(cateid){
 	 if (confirm("删除分类？"))
	  {
	    var args = {
	    	    "action":"delete",
	    	    "id":encodeURIComponent(cateid)
	    	    };
	    
	    $.get("",args, function (data, textStatus){
		    window.location.reload();
		});
	  }
}

 </script>
<?php include 'foot.php'?>