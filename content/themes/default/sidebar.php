
    <div class="grid_4" id="sidebar">

        <?php if (empty($this->options->sidebarBlock) || in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
	    <div class="widget">
			<h3><?php _e('最新文章'); ?></h3>
            <ul>
                <?php 
                $this->alump('Contents_Post_Recent')->to($posts);
                ?> 
                <?php while($post = $posts->next()):?>
                <li><a href="<?php $post->permalink()?>"><?php echo $post->title?></a></li>
                <?php endwhile?>
            </ul>
	    </div>
        <?php endif; ?>


        <?php if (empty($this->options->sidebarBlock) || in_array('ShowCategory', $this->options->sidebarBlock)): ?>
        <div class="widget">
			<h3><?php _e('分类'); ?></h3>
            <ul>
                <?php $this->alump('Metas_Category_List')->to($categorys);?>
               
                <?php while($category = $categorys->next()):?>
                <li><a href="<?php $category->permalink()?>"><?php echo $category->name?></a> <?php echo $category->count?></li>
                <?php endwhile?>
            </ul>
		</div>
        <?php endif; ?>

        <?php if (empty($this->options->sidebarBlock) || in_array('ShowArchive', $this->options->sidebarBlock)): ?>
        <div class="widget">
			<h3><?php _e('归档'); ?></h3>
            <ul>
                <?php $this->alump('Contents_Post_Date', 'type=month&format=F Y')->to($archives) ?>
                <?php while($archive = $archives->next()):?>
                <li><a href="<?php $archive->permalink()?>"><?php echo $archive->name ?></a></li>
                <?php endwhile?>
                
            </ul>
		</div>
        <?php endif; ?>

        <?php if (empty($this->options->sidebarBlock) || in_array('ShowOther', $this->options->sidebarBlock)): ?>
		<div class="widget">
			<h3><?php _e('其它'); ?></h3>
            <ul>
                <?php if($this->hasLogin()): ?>
					<li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入后台'); ?> (<?php $this->loginUser()->nickName(); ?>)</a></li>
                    <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
                <?php else: ?>
                    <li class="last"><a href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a></li>
                <?php endif; ?>
                <li><a href="http://validator.w3.org/check/referer">Valid XHTML</a></li>
                <li><a href="http://xiaolan.tk/">XiaoLan</a></li>
            </ul>
		</div>
        <?php endif; ?>

    </div><!-- end #sidebar -->
