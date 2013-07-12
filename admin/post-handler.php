<?php if(!defined('__ROOT_DIR__')) exit; ?>
<?php 
$action = ALump::$request->request('action');


function getPostValue($isedit=false){
	$title = ALump_Common::escape(ALump::$request->post('title'));
	$id = ALump::$request->post('id');
	
	
	$content = ALump_Common::escape(ALump::$request->post('content'));
	
	
	$created = ALump_Common::escape(ALump::$request->post('created'));
	if(empty($created)){
		$created = ALump_Date::getNow();
	}
	$created = ALump_Date::toTimestamp($created);
	
	$modified = ALump_Common::escape(ALump::$request->post('modified'));
	if(empty($modified)){
		$modified = ALump_Date::getNow();
	}
	$modified = ALump_Date::toTimestamp($modified);
	
	
	$drafted = ALump::$request->post('drafted');
	$status = ALump_Common::$DRAFT;
	if(empty($drafted)){
		$status = ALump_Common::$PUBLISH;
	}
	
	if(empty($title) && $status == ALump_Common::$PUBLISH){
		$title = "未命名文档";
	}else if(empty($title) && $status == ALump_Common::$DRAFT){
		$title = "未命名草稿";
	}
	
	/*高级设置*/
	$password = ALump_Common::escape(ALump::$request->post('password'));
	if(!empty($password)){
		$em_hasher = PasswordHash::getInstance();
		$password = $em_hasher->HashPassword($password);
	}
	
	
	$can_comment = ALump::$request->post('can_comment');
	$can_rss = ALump::$request->post('can_rss');
	$loguserName = ALump_Common::loginUser();
	$author = ALump_User::getUserByName($loguserName);
	
	$post = null;
	
	if(!$isedit){
		$post = new Alump_Post(array(
				"id" => $id,
				"title" => $title,
				"content" => $content,
				"created" => $created,
				"modified" => $created,
				"status" => $status,
				"password" => $password,
				"slug" => time(),
				"allow_comment" => $can_comment,
				"allow_feed" => $can_rss,
				"author_id" => $author->id,
		));
	}else{
		$post = new Alump_Post(array(
				"id" => $id,
				"title" => $title,
				"content" => $content,
				"modified" => $modified,
				"status" => $status,
				"password" => $password,
				"slug" => time(),
				"allow_comment" => $can_comment,
				"allow_feed" => $can_rss,
				"author_id" => $author->id,
		));
	}

	
	return $post;
}


function updateMetas($postid){
	if(!empty($postid)){
		$category = ALump::$request->post('category');
		$tags = ALump::$request->post('tags');
		
		// 保存类别
		$categoryObj = ALump_Meta::getMetaBySlug($category);
	    ALump_Relation::removeByPostId($postid);
		Alump_Relation::save(new ALump_Relation(array(
            "post_id"=>$postid,
            "meta_id"=>$categoryObj->id,
		)));
		
		// 保存TAG
		$tagids = Alump_Meta::splitTag($tags);

		if(!empty($tagids)){
			foreach($tagids as $tagid){
				Alump_Relation::save(new ALump_Relation(array(
				"post_id"=>$postid,
				"meta_id"=>$tagid,
				)));
			}
		}
	
	
	}
}

function updateSlug($postid){
	$slug = ALump_Common::escape(ALump::$request->post('slug'));
	
	ALump_Post::updateSlug($postid, $slug);
}

function updateAttachs($postid){
	$attachs = ALump::$request->post('attachs');
	ALump_Post::updateAttachs($postid, $attachs);
}

function putOnTop($postid){
	$post_on_top = ALump::$request->post('post_on_top');
	
	if(!empty($post_on_top)){
		Alump_Post::postOnTop($postid);
	}
}

function doRedirect($post){
	if($post->status){
		ALump_Common::redirect("post-publish.php");
		//header("Location:post-publish.php");
	}else{
		ALump_Common::redirect("post-draft.php");
		//header("Location:post-draft.php");
	}
}

if($action == 'post_add'){

    $post = getPostValue();
    
	$postid = Alump_Post::save($post);
	
	updateSlug($postid);
	
	updateMetas($postid);
	
	updateAttachs($postid);
	
	ALump_Logger::action("add post ".$post->title);
	doRedirect($post);
	
}

if($action == "post_edit"){
	
	$post = getPostValue(true);
	
	Alump_Post::update($post);
	
	$postid = ALump::$request->post('id');
	
	updateSlug($postid);
	
	updateMetas($postid);
	
	updateAttachs($postid);
    ALump_Logger::action("edit post ".$post->title);
	doRedirect($post);
}

if($action == 'delete'){
	if(!ALump_Common::isLogined()){
		echo ALump_Common::$NOPERMISSION;
		exit();
	}else{
		//ids=77,76,75,
		$postids = ALump::$request->get("ids");
		
		
		$postids = explode(",", $postids);
		
		$res = ALump_Common::$FAILURE;
		
		if(!empty($postids)){
			foreach($postids as $postid){
				if(!empty($postid)){
					$res = ALump_Post::removeById($postid);
				}
				
			}
			
		}
		
		if(!$res){
            ALump_Logger::action("delete post failure");
			echo ALump_Common::$FAILURE;
		}else{
            ALump_Logger::action("delete post success");
			echo ALump_Common::$SUCCESS;
		}
	}
}

if($action == "todraft"){
	if(!ALump_Common::isLogined()){
		echo ALump_Common::$NOPERMISSION;
		exit();
	}else{
		//ids=77,76,75,
		$postids = ALump::$request->get("ids");
	
	
		$postids = explode(",", $postids);
	
		$res = ALump_Common::$FAILURE;
	
		if(!empty($postids)){
			foreach($postids as $postid){
				if(!empty($postid)){
					$res = ALump_Post::updateStatus($postid, ALump_Common::$DRAFT);
				}
				
			}
				
		}
	
		if(!$res){
            ALump_Logger::action("change post to draft failure");
			echo ALump_Common::$FAILURE;
		}else{
            ALump_Logger::action("change post to draft success");
			echo ALump_Common::$SUCCESS;
		}
	}
}

if($action == "topublish"){
	if(!ALump_Common::isLogined()){
		echo ALump_Common::$NOPERMISSION;
		exit();
	}else{
		//ids=77,76,75,
		$postids = ALump::$request->get("ids");
				
		$postids = explode(",", $postids);

		$res = ALump_Common::$FAILURE;

		if(!empty($postids)){
			foreach($postids as $postid){
				if(!empty($postid)){
					$res = ALump_Post::updateStatus($postid, ALump_Common::$PUBLISH);
				}
				
			}

		}

		if(!$res){
            ALump_Logger::action("publish post failure");
			echo ALump_Common::$FAILURE;
		}else{
            ALump_Logger::action("publish post success");
			echo ALump_Common::$SUCCESS;
		}
	}
}

if($action == "tocategory"){
   if(!ALump_Common::isLogined()){
	echo ALump_Common::$NOPERMISSION;
	exit();
}else{
	//ids=77,76,75,
	$postids = ALump::$request->get("ids");
	$category = ALump::$request->get("category");
	
	if(empty($category)){
		return;
	}

	$postids = explode(",", $postids);

	$res = ALump_Common::$FAILURE;

	if(!empty($postids)){
		foreach($postids as $postid){
			if(!empty($postid)){
				$categoryObj = ALump_Meta::getMetaBySlug($category);
			
				Alump_Relation::updatePostMeta($postid, $categoryObj->id);
			}

		}

	}

	if(!$res){
         ALump_Logger::action("change post to another category failure");
		echo ALump_Common::$FAILURE;
	}else{
        ALump_Logger::action("change post to another category success");
		echo ALump_Common::$SUCCESS;
	}
}

}



?>
