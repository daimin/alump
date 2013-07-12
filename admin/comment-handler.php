<?php if(!defined('__ROOT_DIR__')) exit; ?>
<?php 
$action = ALump::$request->request('action');


function is_current_class($status){
    $get_status = ALump::$request->get('s');
    if(empty($get_status) && $status == 'adopt'){
        echo ' class="current" ';
    }else{
        if($get_status == $status){
            echo ' class="current" ';
        }
    }
    
}

function to_current_url($url = False){
    $queryStr = ALump::$request->server('QUERY_STRING');
    if(empty($queryStr)){
        if(!empty($url)){
            echo '?'.$url;
        }
    }else{
        if(!empty($url)){
            echo '?'.ALump::$request->server('QUERY_STRING').'&'.$url;
        }else{
            return '?'.ALump::$request->server('QUERY_STRING');
        }
    }
}

function renderCommentTool($comment){
    $status = $comment->status;
    if($status == ALump_Common::$ADOPT){
        echo '<a class="link_button"  href="javascript:void(0)" onclick="changeCommentStatus(\''.$comment->id.'\',\''.ALump_Common::$AUDIT.'\')">驳回</a>'.
             '<a class="link_button" href="javascript:void(0)" onclick="changeCommentStatus(\''.$comment->id.'\',\''.ALump_Common::$TRASH. '\')">垃圾</a>'.
             '<a class="link_button" href="javascript:void(0)" onclick="editComment(\''.$comment->id.'\')" >编辑</a>'.
             '<a class="link_button" href="javascript:void(0)" onclick="removeComment(\''.$comment->id.'\')" >删除</a>';
    }else if($status == ALump_Common::$AUDIT){
        echo '<a class="link_button"  href="javascript:void(0)" onclick="changeCommentStatus(\''.$comment->id.'\',\''.ALump_Common::$ADOPT.'\')">通过</a>'.
             '<a class="link_button" href="javascript:void(0)" onclick="changeCommentStatus(\''.$comment->id.'\',\''.ALump_Common::$TRASH. '\')">垃圾</a>'.
             '<a class="link_button" href="javascript:void(0)" onclick="editComment(\''.$comment->id.'\')" >编辑</a>'.
             '<a class="link_button" href="javascript:void(0)" onclick="removeComment(\''.$comment->id.'\')" >删除</a>';
    }else{
        echo '<a class="link_button"  href="javascript:void(0)" onclick="changeCommentStatus(\''.$comment->id.'\',\''.ALump_Common::$ADOPT.'\')">通过</a>'.
             '<a class="link_button" href="javascript:void(0)" onclick="editComment(\''.$comment->id.'\')" >编辑</a>'.
             '<a class="link_button" href="javascript:void(0)" onclick="removeComment(\''.$comment->id.'\')" >删除</a>';
    }
}
function getCommentCountByStatus($status){
    echo ALump_Comment::getCommentCountByStatus($status);
}


if($action == "changeStatus"){
    $ids = ALump::$request->post('ids');
    if(!empty($ids)){
        $ids = explode(",", $ids);
    }else{
        $id = ALump::$request->post('id');
        $ids = array($id);
    }
   
   ALump_logger::log($ids);
    $status = ALump::$request->post('status');
    foreach($ids as $id){
         ALump_Comment::changeStatus($id, $status);
    }
   
    exit();
}else if($action == "remove"){
     $ids = ALump::$request->post('ids');
    if(!empty($ids)){
        $ids = explode(",", $ids);
    }else{
        $id = ALump::$request->post('id');
        $ids = array($id);
    }
   foreach($ids as $id){
       ALump_Comment::remove($id);
   } 
   exit();
}else if($action == "getComment"){
    $id = ALump::$request->post('id');
    $comment = ALump_Comment::getCommentById($id);
    // 因为是获取后，在编辑框中显示的是，所以要替换换行符
    $comment->content = str_replace(array('<br/>','<br>'), "\n", $comment->content);
    $json = new Services_JSON();
    echo $json->encode($comment);
    exit();
}else if($action == "update"){
    $id = ALump_Common::decodeURIComponent(ALump::$request->post('id'));
    $mail = ALump_Common::decodeURIComponent(ALump::$request->post('mail'));
    $author = ALump_Common::decodeURIComponent(ALump::$request->post('author'));
    $url = ALump_Common::decodeURIComponent(ALump::$request->post('url'));
    $content = ALump_Common::decodeURIComponent(ALump::$request->post('content'));
    
    $comment = ALump_Comment::getCommentById($id);
    $comment->author = ALump_Common::decodeURIComponent($author);
    $comment->mail = ALump_Common::decodeURIComponent($mail);
    $comment->url = ALump_Common::decodeURIComponent($url);
    $comment->content = ALump_Common::escape($content);
   
    ALump_Comment::update($comment);
    exit();
}


?>
