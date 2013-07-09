<?php if(!defined('__ROOT_DIR__')) exit; ?>

<div id="menu">
<table width="99%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody><tr>
    <td style="padding-left:3px;padding-top:0px" valign="top">
	<!-- Item 1 Strat -->
      <dl class="bitem">
        <dt onclick="showHide('items1_1')"><b>文章</b></dt>
        <dd  class="sitem" id="items1_1">
          <ul class="sitemu">
            <li>
              <div class="items">
                <div class="fllct"><i class="icon-pencil"></i><a href="post-add.php" ><?php echo ALump_Admin::menu('post-add.php')?></a></div>
              </div>
            </li>
            <li>
              <div class="items">
                <div class="fllct"><i class="icon-list-alt"></i><a href="post-publish.php" ><?php echo ALump_Admin::menu('post-publish.php')?></a></div>
              </div>
               </li>
               <li>
              <div class="items">
                <div class="fllct"><i class="icon-folder-close"></i><a href="post-draft.php" ><?php echo ALump_Admin::menu('post-draft.php')?></a></div>
              </div>
               </li>  
          </ul>
        </dd>
      </dl>
     
      <!-- Item 1 Strat -->
      <dl class="bitem">
        <dt onclick="showHide('items1_2')"><b>页面</b></dt>
        <dd style="display:block" class="sitem" id="items1_2">
          <ul class="sitemu">
            <li>
              <div class="items">
                <div class="fllct"><i class="icon-edit"></i><a href="page-add.php" ><?php echo ALump_Admin::menu('page-add.php')?></a></div>
              </div>
            </li>
            <li>
              <div class="items">
                <div class="fllct"><i class="icon-tasks"></i><a href="page-manage.php" ><?php echo ALump_Admin::menu('page-manage.php')?></a></div>
              </div>
               </li>
               
          </ul>
        </dd>
      </dl>
      
       <!-- Item 1 Strat -->
      <dl class="bitem">
        <dt onclick="showHide('items1_3')"><b>管理</b></dt>
        <dd style="display:block" class="sitem" id="items1_3">
          <ul class="sitemu">
              <li>
              <div class="items">
                <div class="fllct"><i class="icon-tag"></i><a href="tags-manage.php" ><?php echo ALump_Admin::menu('tags-manage.php')?></a></div>
              </div>
               </li> 
             <li>
              <div class="items">
                <div class="fllct"><i class="icon-tags"></i><a href="category-manage.php" ><?php echo ALump_Admin::menu('category-manage.php')?></a></div>
              </div>
               </li>    
              <li>
              <div class="items">
                <div class="fllct"><i class="icon-comment"></i><a href="post-recycle.php" >评论</a></div>
              </div>
              </li> 
              <li>
              <div class="items">
                <div class="fllct"><i class="icon-hand-up"></i><a href="setting.php" >链接</a></div>
              </div>
            </li>
              <li>
              <div class="items">
                <div class="fllct"><i class="icon-picture"></i><a href="setting.php" >附件</a></div>
              </div>
            </li>
          </ul>
        </dd>
      </dl>
        <dl class="bitem">
        <dt onclick="showHide('items1_4')"><b>设置</b></dt>
        <dd style="display:block" class="sitem" id="items1_4">
          <ul class="sitemu">
 <li>
              <div class="items">
                <div class="fllct"><i class="icon-user"></i><a href="profile.php" >个人设置</a></div>
              </div>
            </li>
            <li>
              <div class="items">
                <div class="fllct"><i class="icon-wrench"></i><a href="site-setting.php" >站点设置</a></div>
              </div>
            </li>
            <li>
              <div class="items">
                <div class="fllct"><i class="icon-text-height"></i><a href="post-setting.php" >文章设置</a></div>
              </div>
            </li>
            <li>
              <div class="items">
                <div class="fllct"><i class="icon-retweet"></i><a href="comment-setting.php" >评论设置</a></div>
              </div>
            </li>
            </li>
          </ul>
        </dd>
      </dl>  
       <dl class="bitem">
        <dt onclick="showHide('items1_5')"><b>外观管理</b></dt>
        <dd style="display:block" class="sitem" id="items1_5">
          <ul class="sitemu">
              <li>
              <div class="items">
                <div class="fllct"><i class="icon-eye-open"></i><a href="post-recycle.php" >主题</a></div>
              </div>
              </li>  
              <li>
              <div class="items">
                <div class="fllct"><i class="icon-leaf"></i><a href="setting.php" >插件</a></div>
              </div>
            </li>
          </ul>
        </dd>
      </dl>
       <dl class="bitem">
        <dt onclick="showHide('items1_5')"><b>日志</b></dt>
        <dd style="display:block" class="sitem" id="items1_5">
          <ul class="sitemu">
              <li>
              <div class="items">
                <div class="fllct"><i class="icon-share-alt"></i><a href="post-recycle.php" >登陆日志</a></div>
              </div>
              </li>  
              <li>
              <div class="items">
                <div class="fllct"><i class="icon-asterisk"></i><a href="setting.php" >操作日志</a></div>
              </div>
            </li>
          </ul>
        </dd>
      </dl>
	  </td>
  </tr>
</tbody></table>
</div>