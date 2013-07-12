<?php if(!defined('__ROOT_DIR__')) exit; ?>
<?php 

$action = ALump::$request->request('action');


function getCategoryValue(){
	$name = ALump_Common::escape(ALump::$request->post('cname'));
	$id = ALump::$request->post('cid');
	
	$slug = ALump_Common::escape(ALump::$request->post('cslug'));
	
	$description = ALump_Common::escape(ALump::$request->post('description'));
	
	if(empty($slug)){
		$slug = $name;
	}
	
	$category = new Alump_Meta(array(
			"id" => $id,
			"name" => $name,
			"slug" => $slug,
			"description" => $description,
			"type" => "category"
	));
	
	return $category;
}

function getTagValue(){
	$name = ALump_Common::escape(ALump::$request->post('cname'));
	$id = ALump::$request->post('cid');

	$slug = ALump_Common::escape(ALump::$request->post('cslug'));


	if(empty($slug)){
		$slug = $name;
	}

	$tag = new Alump_Meta(array(
			"id" => $id,
			"name" => $name,
			"slug" => $slug,
			"type" => "tag"
	));

	return $tag;
}



function updateSlug($postid){
	$slug = ALump_Common::escape(ALump::$request->post('slug'));
	
	ALump_Post::updateSlug($postid, $slug);
}

function updateOrder($metaid, $orderVal){
	ALump_Meta::updateOrder($metaid, $orderVal);
}


function doRedirect($category){
	if($category->type == "category"){
		ALump_Common::redirect("category-manage.php");
	}else{
		ALump_Common::redirect("tags-manage.php");
	}
}

if($action == 'add-category'){

    $category = getCategoryValue();
    
	$cateid = ALump_Meta::save($category);
	
	updateOrder($cateid, null);
	ALump_Logger::action("add-category");
	doRedirect($category);
	
}

if($action == "update-category"){
	$category = getCategoryValue();
	
	$cateid = ALump_Meta::update($category);
    ALump_Logger::action("update-category");
	doRedirect($category);	
}

if($action == 'add-tag'){

	$tag = getTagValue();

	$tagid = ALump_Meta::save($tag);

	updateOrder($tagid, null);
    ALump_Logger::action("add-tag");
	doRedirect($tag);

}


if($action == 'delete'){
	if(!ALump_Common::isLogined()){
		echo ALump_Common::$NOPERMISSION;
		exit();
	}else{
		$metaid = ALump::$request->get("id");
		$mateids = ALump::$request->get("ids");
		
		$res = ALump_Common::$FAILURE;
		
		if(!empty($metaid)){
			$res = ALump_Meta::removeById($metaid);	
		}
		
		if(!empty($mateids)){
			$mateids = explode(",", $mateids);
			foreach($mateids as $metaid){
				if(!empty($metaid)){
					$res = ALump_Meta::removeById($metaid);
				}
				
			}
		}
		
		if(!$res){
            ALump_Logger::action("delete tag failure");
			echo ALump_Common::$FAILURE;
		}else{
            ALump_Logger::action("delete tag success");
			echo ALump_Common::$SUCCESS;
		}
	}
	exit();
}

if($action == "sortOrder"){
    
	$mateid = ALump::$request->get("id");
	$order = ALump::$request->get("order");
    ALump_Logger::action("sortOrder of categorys");
	updateOrder($mateid, $order);
	exit();
}



?>
