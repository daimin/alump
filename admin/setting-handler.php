<?php if(!defined('__ROOT_DIR__')) exit; ?>
<?php 

$handlerMessage = '';

function setting_message(){
    global $handlerMessage;
    if(!empty($handlerMessage)){
        echo '<div id="setting-hander-info" class="setting-hander-info">'.$handlerMessage.'</div>';
    }
    
}

$action = ALump::$request->request('action');

if($action == 'site'){

    $site_name = ALump_Common::escape(ALump::$request->post('site_name'));
    
    if(!empty($site_name)){
        ALump::$options->set("title", $site_name);
    }
    $site_desc = ALump_Common::escape(ALump::$request->post('site_desc'));
    if(!empty($site_desc)){
        ALump::$options->set("description", $site_desc);
    }
    $site_keyword = ALump_Common::escape(ALump::$request->post('site_keyword'));
    if(!empty($site_keyword)){
        ALump::$options->set("keywords", $site_keyword);
    }
    $timezone = ALump::$request->post('timezone');
    if(!empty($timezone)){
        ALump::$options->set("timezone", $timezone);
    }else{
        ALump::$options->set("timezone", 0);
    }
    
    $attachmentTypes = ALump::$request->post('attachmentTypes');
    $otherAttachment = ALump::$request->post('otherAttachment');
    if($res = array_search("@others@", $attachmentTypes)){
        unset($attachmentTypes[$res]);
        if(!empty($otherAttachment)){
            $attachmentTypes = array_merge($attachmentTypes, explode(",", $otherAttachment));
        }
    }
    if(!empty($attachmentTypes)){
        ALump::$options->set("attachmentTypes", implode(",", $attachmentTypes));
    }
    
    
    $site_rewrite = ALump::$request->post('site_rewrite');
    ALump::$options->set("rewrite", $site_rewrite);
    
    $site_suffix = ALump::$request->post('site_suffix');
    ALump::$options->set("suffix", $site_suffix);

    $handlerMessage = "设置成功";
    //$attachmentTypes = ALump_Common::escape(ALump::$request->post('attachmentTypes'));
    //$otherAttachment = ALump_Common::escape(ALump::$request->post('otherAttachment'));
    
    
}




?>
