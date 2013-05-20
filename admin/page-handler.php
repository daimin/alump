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
	$can_rss = ALump::$request->post('can_rss');
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

    $page = getPageValue();
    
	$pageid = Alump_Post::save($page);
	
	updateSlug($pageid);
	
	updateAttachs($pageid);
	
	doRedirect($page);
	
}

if($action == "page_edit"){
	
	$page = getPageValue(true);
	
	Alump_Post::update($page);
	
	$pageid = ALump::$request->post('id');
	
	updateSlug($pageid);

	updateAttachs($pageid);
	
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
			echo ALump_Common::$FAILURE;
		}else{
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
			echo ALump_Common::$FAILURE;
		}else{
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
			echo ALump_Common::$FAILURE;
		}else{
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
		echo ALump_Common::$FAILURE;
	}else{
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
	updateOrder($pageid, $order);
	exit();

}



?>
