<?php if(!defined('__ROOT_DIR__')) exit; ?>
<?php 
$action = ALump::$request->request('action');


function getPageValue($isedit=false){
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
		$title = "未命名页面";
	}else if(empty($title) && $status == ALump_Common::$DRAFT){
		$title = "未命名草稿";
	}

	
	
	$can_comment = ALump::$request->post('can_comment');
	if(empty($can_comment)){
		$can_comment = 0;
	}
	$can_rss = ALump::$request->post('can_rss');
	if(empty($can_rss)){
		$can_rss = 0;
	}
	$loguserName = ALump_Common::loginUser();
	$author = ALump_User::getUserByName($loguserName);
	
	$page = null;
	
	if(!$isedit){
		$page = new Alump_Post(array(
				"id" => $id,
				"title" => $title,
				"content" => $content,
				"created" => $created,
				"modified" => $created,
				"status" => $status,
				"slug" => time(),
				"allow_comment" => $can_comment,
				"allow_feed" => $can_rss,
				"author_id" => $author->id,
				"type" => "page",
		));
	}else{
		$page = new Alump_Post(array(
				"id" => $id,
				"title" => $title,
				"content" => $content,
				"modified" => $modified,
				"status" => $status,
				"slug" => time(),
				"allow_comment" => $can_comment,
				"allow_feed" => $can_rss,
				"author_id" => $author->id,
				"type" => "page",
		));
	}
	
	return $page;
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


function doRedirect($post){
	ALump_Common::redirect("page-manage.php");
}

if($action == 'page_add'){

    $page = getPageValue(false);
    
	$pageid = Alump_Post::save($page);
	
	updateSlug($pageid);
    
	updateMetas($pageid);
	
    updateAttachs($pageid);
	ALump_Logger::action("add page ".$page->title);
	doRedirect($page);
	
}

if($action == "page_edit"){
	
	$page = getPageValue(true);
	
	Alump_Post::update($page);
	
	$pageid = ALump::$request->post('id');
	
	updateSlug($pageid);
    
    updateMetas($pageid);

	updateAttachs($pageid);
	ALump_Logger::action("add page ".$page->title);
	doRedirect($page);
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
            ALump_Logger::action("add page failure");
			echo ALump_Common::$FAILURE;
		}else{
            ALump_Logger::action("add page success");
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
            ALump_Logger::action("change page to draft failure");
			echo ALump_Common::$FAILURE;
		}else{
            ALump_Logger::action("change page to draft success");
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
             ALump_Logger::action("publish page failure");
			echo ALump_Common::$FAILURE;
		}else{
            ALump_Logger::action("publish page success");
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
        ALump_Logger::action("change page to another category failure");
		echo ALump_Common::$FAILURE;
	}else{
        ALump_Logger::action("change page to another category success");
		echo ALump_Common::$SUCCESS;
	}
}

}
 

function updateOrder($pageid, $orderVal){
	ALump_Logger::log("updateOrder,".$pageid.",".$orderVal);
	ALump_Post::updateOrder($pageid, $orderVal);
}

if($action == "sortOrder"){
	$pageid = ALump::$request->get("id");
	$order = ALump::$request->get("order");
    ALump_Logger::action("sort page");
	updateOrder($pageid, $order);
	exit();

}



?>
