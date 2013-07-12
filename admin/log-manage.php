<?php include 'head.php' ?>
<?php include 'menu.php'?>
<?php include 'log-handler.php'?>

    <div id="content">
    <div id="content_box">
<script type="text/javascript">

</script>
<div class="admin_page_name">日志列表</div>
<div class="table_list_tool">
  <span>
  批量操作：<a  href="javascript:void(0)" onclick="apply_all('delete', 'ids')">删除</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
  </span>
 
</div>
<div class="table_list post_list">
<table colspan="0" rowspan="0" cellpadding="0" cellspacing="0" class="table_list" >
  <thead>
    <tr>
    <td style="width:30px"><input type="checkbox" name="ids" onclick="if(this.checked==true) { check_all('ids'); } else { clear_all('ids'); }" value=""/></td>
    <td style="width:12%">日期</td>
    <td class="td-title" style="width:21%">登陆日志</td>
    <td class="td-title" style="width:21%">操作日志</td>
    <td class="td-title" style="width:21%">调试日志</td>
    <td class="td-title" style="width:21%">错误日志</td>
    </tr>
  </thead>
  <tbody>
  <?php ALump::Lump('Logs_List_Admin')->to($logs); ?>
       <?php if($logs->have()){ ?>
       <?php while($log = $logs->next()){ ?>
      <tr <?php $logs->alt(' class="even"', ''); ?>>
      <td><input type="checkbox" name="ids" value="<?php echo $log->date?>"/></td>
      <td>
        <?php echo $log->date?>
      </td>
      <td class="td-list" style="height:32px;">
          <a target="_blank" href="<?php echo $log->getDownloadUrl('Login')?>"><?php echo $log->getName('Login')?></a>
      </td>
      <td class="td-list" style="height:32px;">
          <a target="_blank" href="<?php echo $log->getDownloadUrl('Action')?>"><?php echo $log->getName('Action')?></a>
      </td>
      <td class="td-list" style="height:32px;">
          <a target="_blank" href="<?php echo $log->getDownloadUrl('Log')?>"><?php echo $log->getName('Log')?></a>
      </td>
      <td class="td-list" style="height:32px;">
          <a target="_blank" href="<?php echo $log->getDownloadUrl('Err')?>"><?php echo $log->getName('Err')?></a>
      </td>
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
    <td >日期</td>
    <td class="td-title" >登陆日志</td>
    <td class="td-title" >操作日志</td>
    <td class="td-title" >调试日志</td>
    <td class="td-title" >错误日志</td>
    </tr>
  </tfoot>
</table>
</div>
<div class="table_list_tool">
<?php $logs->pageNav()?>
</div>
    </div>
  </div>
  <script type="text/javascript">

  function remove_post(postid){
  	 if (confirm("删除日志？"))
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