<?php if(!defined('__ROOT_DIR__')) exit; ?>
<?php 
$action = ALump::$request->request('action');

if($action == 'delete'){
    $id = ALump::$request->request('id');
    $ids = ALump::$request->request('ids');
    if(!empty($ids)){
        $ids = explode(',', $ids);
    }else{
        $ids = array($id);
    }
    
    foreach($ids as $id){
        if(empty($id)) continue;
        $attach = ALump_Post::getPostById($id);
   
        if(!empty($attach) && !empty($attach->id)){
            $json = new Services_JSON();
            $content = $json->decode($attach->content);
            if(!empty($content) && !empty($content->path)){
                ALump_Common::delFile(__ROOT_DIR__.$content->path);
            }
            
            ALump_Post::removeById($id);
        }
    }
 
    
}

?>
