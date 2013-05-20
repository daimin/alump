<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'jqueryui-include.php'?>
<?php include 'meta-handler.php'?>

    <div id="content">
    <div id="content_box">
<div class="admin_page_name">标签管理</div>

<div class="manage_div" >
<div class="manage_div_tool">
操作：<a href="javascript:void(0)" onclick="check_all();">全选</a>，<a  href="javascript:void(0)" onclick="clear_all();">不选</a>
       &nbsp;&nbsp;&nbsp;&nbsp;选中项：<a  href="javascript:void(0)" onclick="remove_tags()">删除</a>
</div>
<div class="tag-list">
   <?php 
     ALump::Lump("Metas_Tags_Admin")->to($tags);
     ?>
     <?php $tags->parse('<span class="checkbox-span"><input type="checkbox" value="{id}" id="id_{slug}" name="{slug}"><label for="id_{slug}">{name}</label></span>')?>
</div>
</div>
<div class="form-div div-right side-right-div">
<form name="tag-form" method="post" onsubmit="return validate_addtag(this)">
<input type="hidden" value="add-tag" name="action" />
<input type="hidden" value="" name="cid" />
<table class="form-tab form-100">
<tbody>
<tr>
<td class="form-field">标签名称*：</td><td><input type="text" name="cname" /></td>
</tr>
<tr>
<td class="form-field">标签缩略名：</td><td><input type="text" name="cslug" /></td>
</tr>
<tr>
<td colspan="2" align="right"><input type="submit" name="add-cate-btn" value=" 增加标签 " /></td>
</tr>
</tbody>
</table>
</form>
</div>
    </div>
  </div>
<script type="text/javascript">
 function validate_addtag(form){
     if(form.cname.value == ""){
         alert("-- 请输入标签名称");
         return false;
     }else{
        return true;   
     }
 }


 function remove_tags(){
	 var el  = document.getElementsByTagName('input');
	 var len = el.length;
	 var ids = '';
	  
	 for(var i=0; i<len; i++) {
	    if((el[i].type=="checkbox") &&
	       el[i].checked == true &&
	       el[i].value != '') {
	      ids += encodeURIComponent(el[i].value) + ',';
	    }
	 }
	
 	 if (confirm("删除标签？"))
	  {
		  var args = {
		    	    "action":"delete",
		    	    "ids":ids
		    	    };
		    
	     $.get("",args, function (data, textStatus){	
	         window.location.reload();
		 }); 
	  }
}
</script>
<?php include 'foot.php'?>