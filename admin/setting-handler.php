<?php if(!defined('__ROOT_DIR__')) exit; ?>
<?php 

$handlerMessage = '';
$cpasswordErr = '';
$cprofileErr = '';


function setting_message(){
    global $handlerMessage;
    if(!empty($handlerMessage)){
        echo '<div id="setting-hander-info" class="setting-hander-info">'.$handlerMessage.'</div>';
    }
    
}


function cpasswordError(){
    global $cpasswordErr;
     if(!empty($cpasswordErr)){
        echo '<div class="setting-hander-info error">'.$cpasswordErr.'</div>';
    }
}

function cprofileError(){
   global $cprofileErr;
     if(!empty($cprofileErr)){
        echo '<div class="setting-hander-info error">'.$cprofileErr.'</div>';
    } 
}


function getLoginUser(){
    return ALump_User::getUserByName(ALump_Common::loginUser());
}

function trimSiteUrl($siteUrl){
    $pos = strrpos($siteUrl, 'index.php');
    if($pos === False){
        return $siteUrl;
    }else{
        return substr($siteUrl, 0, strrpos($siteUrl, 'index.php'));
    }
    
}

function isCurPage($frontPage, $thisPageId){
    $res = explode(":", $frontPage);
    if(empty($res) && count($res) < 2) return False;
    if($res[1] == $thisPageId) return True;
}

function printBrief($loginUser){
    echo '目前有 <span class="font-focus">'.ALump_Post::getPostCount().'</span> 篇 Blog，并有 <span class="font-focus">'.
            ALump_Comment::getCommentCount().'</span> 条关于你的评论在已设定的 <span class="font-focus">'.
            ALump_Meta::getCategorys()->size().'</span> 个分类中.<br/>最后登录: <span class="font-focus">'.
            ALump_Date::format($loginUser->visited, "F j, Y, g:i a").'</span>';
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
    
    $siteUrl = ALump::$request->post('siteUrl');
    
    ALump::$options->set("siteUrl", $siteUrl);
    
    $loginUseGD = ALump::$request->post('loginUseGD');
    ALump::$options->set("loginUseGD", $loginUseGD);
    
    $thumbImgSize = ALump::$request->post('thumbImgSize');
    $thumbImgSize = intval($thumbImgSize);
    ALump::$options->set("thumbImgSize", $thumbImgSize);
    
    $cropImgSize = ALump::$request->post('cropImgSize');
    $cropImgSize = intval($cropImgSize);
    ALump::$options->set("cropImgSize", $cropImgSize);

    $handlerMessage = "设置成功";
    //$attachmentTypes = ALump_Common::escape(ALump::$request->post('attachmentTypes'));
    //$otherAttachment = ALump_Common::escape(ALump::$request->post('otherAttachment'));
    ALump_Logger::action("site setting");
    
}else if($action == "change-password"){
    ALump_Logger::action("change password");
    $old_password = ALump_Common::escape(ALump::$request->post('old_password'));
    if(empty($old_password)){
        $cpasswordErr = "旧密码不能为空";
    }else{
            $new_password = ALump_Common::escape(ALump::$request->post('new_password'));
            if(empty($new_password)){
                 $cpasswordErr = "新密码不能为空";
            }else{
                $re_password = ALump_Common::escape(ALump::$request->post('re_password'));
                if(empty($re_password)){
                     $cpasswordErr = "重复密码不能为空";
                }else{
                    if($new_password != $re_password){
                        $cpasswordErr = "两次输入的密码不一致";
                    }else{
                        // 验证旧密码
                        $user = ALump_User::getUserByName(ALump_Common::loginUser());
                        if(empty($user)){
                            header("Location:".ALump::$options->siteUrl());
                        }else{
                            $em_hasher = PasswordHash::getInstance();
                            if(!$em_hasher->CheckPassword($old_password, $user->password)){
                                $cpasswordErr = "请输入正确的旧密码";
                            }else{
                                $new_password = $em_hasher->HashPassword($new_password);
                                if(ALump_User::updateUserPassword($user->id, $new_password)){
                                    $handlerMessage = "用户密码修改成功";   
                                    ALump_Logger::action("change password success");
                                }
                            }
                        }
                    }
                }
                
                
            }

    }
   
}else if($action == "update-profile"){
    $nickname = ALump_Common::escape(ALump::$request->post('nickname'));
    $url = ALump_Common::escape(ALump::$request->post('url'));
    $mail = ALump_Common::escape(ALump::$request->post('mail'));
    if(empty($mail)){
        $cprofileErr = '必须填写电子邮箱';
    }else{
        $user = ALump_User::getUserByName(ALump_Common::loginUser());
        if(empty($nickname)){
            $user->nickname = $user->name;
        }else{
            $user->nickname = $nickname;
        }
        
        $user->url = $url;
        $user->mail = $mail;
        ALump_User::update($user);
    }
    ALump_Logger::action("update profile setting");
}else if($action == "post"){
    $postDateFormat = ALump_Common::escape(ALump::$request->post('postDateFormat'));
    
    if(!empty($postDateFormat)){
        ALump::$options->set("postDateFormat", $postDateFormat);
    }else{
        ALump::$options->set("postDateFormat", '');
    }
    
    $postsListSize = ALump_Common::escape(ALump::$request->post('postsListSize'));
    
    if(!empty($postsListSize)){
        $postsListSize = intval($postsListSize);
        if(is_int($postsListSize)){
            ALump::$options->set("postsListSize", $postsListSize);
        }
        
    }else{
        ALump::$options->set("postsListSize", 0);
    }
    
    $pageSize = ALump_Common::escape(ALump::$request->post('pageSize'));

    if(!empty($pageSize)){
        $pageSize = intval($pageSize);
        if(is_int($pageSize)){
            ALump::$options->set("pageSize", $pageSize);
        }
        
    }
    
    $frontPage = ALump_Common::escape(ALump::$request->post('frontPage'));
   
    if($frontPage == 'recent'){
        ALump::$options->set("frontPage", $frontPage);
    }else{
        $frontPage = ALump_Common::escape(ALump::$request->post('pages'));
        ALump::$options->set("frontPage", 'page:'.$frontPage);
    }
    
    $adminPageSize = ALump_Common::escape(ALump::$request->post('adminPageSize'));
    $adminPageSize = intval($adminPageSize);
    ALump::$options->set("adminPageSize", $adminPageSize);
    
    
    $handlerMessage = "设置成功";   
    ALump_Logger::action("update post setting");
}else if ($action == 'comment') {
    $commentDateFormat = ALump_Common::escape(ALump::$request->post('commentDateFormat'));
    ALump::$options->set("commentDateFormat", $commentDateFormat);
    
    $commentsListSize = ALump_Common::escape(ALump::$request->post('commentsListSize'));
    $commentsListSize = intval($commentsListSize);
    ALump::$options->set("commentsListSize", $commentsListSize);
    
    $commentsPageBreak = ALump_Common::escape(ALump::$request->post('commentsPageBreak'));
    ALump::$options->set("commentsPageBreak", $commentsPageBreak);
    
    $commentsPageSize = ALump_Common::escape(ALump::$request->post('commentsPageSize'));
    $commentsPageSize = intval($commentsPageSize);
    ALump::$options->set("commentsPageSize", $commentsPageSize);
    
    $commentsPageDisplay = ALump_Common::escape(ALump::$request->post('commentsPageDisplay'));
    ALump::$options->set("commentsPageDisplay", $commentsPageDisplay);
    
    $commentsAvatar = ALump_Common::escape(ALump::$request->post('commentsAvatar'));
    ALump::$options->set("commentsAvatar", $commentsAvatar);
    
    $commentsAvatarRating = ALump_Common::escape(ALump::$request->post('commentsAvatarRating'));
    ALump::$options->set("commentsAvatarRating", $commentsAvatarRating);
    
    $commentsReply = ALump_Common::escape(ALump::$request->post('commentsReply'));
    ALump::$options->set("commentsReply", $commentsReply);
    
    $commentsMaxNestingLevels = ALump_Common::escape(ALump::$request->post('commentsMaxNestingLevels'));
    $commentsMaxNestingLevels = intval($commentsMaxNestingLevels);
    ALump::$options->set("commentsMaxNestingLevels", $commentsMaxNestingLevels);
    
    $commentsOrder = ALump_Common::escape(ALump::$request->post('commentsOrder'));
    ALump::$options->set("commentsOrder", $commentsOrder);
    
    $commentsRequireModeration = ALump_Common::escape(ALump::$request->post('commentsRequireModeration'));
    ALump::$options->set("commentsRequireModeration", $commentsRequireModeration);
    
    $commentsRequireMail = ALump_Common::escape(ALump::$request->post('commentsRequireMail'));
    ALump::$options->set("commentsRequireMail", $commentsRequireMail);
    
    $commentsRequireURL = ALump_Common::escape(ALump::$request->post('commentsRequireURL'));
    ALump::$options->set("commentsRequireURL", $commentsRequireURL);
    
    $commentsAutoClose = ALump_Common::escape(ALump::$request->post('commentsAutoClose'));
    ALump::$options->set("commentsAutoClose", $commentsAutoClose);
    
    $commentsPostTimeout = ALump_Common::escape(ALump::$request->post('commentsPostTimeout'));
    $commentsPostTimeout = intval($commentsPostTimeout);
    ALump::$options->set("commentsPostTimeout", $commentsPostTimeout);
    
    $commentsPostIntervalEnable = ALump_Common::escape(ALump::$request->post('commentsPostIntervalEnable'));
    ALump::$options->set("commentsPostIntervalEnable", $commentsPostIntervalEnable);
    
    $commentsPostInterval = ALump_Common::escape(ALump::$request->post('commentsPostInterval'));
    $commentsPostInterval = doubleval($commentsPostInterval);
    $commentsPostInterval = $commentsPostInterval * 60;
    ALump::$options->set("commentsPostInterval", $commentsPostInterval);
    
    $commentsHTMLTagAllowed = ALump_Common::escape(ALump::$request->post('commentsHTMLTagAllowed'));
    ALump::$options->set("commentsHTMLTagAllowed", $commentsHTMLTagAllowed);
    
    $commentsIPDisallowed = ALump_Common::escape(ALump::$request->post('commentsIPDisallowed'));
    ALump::$options->set("commentsIPDisallowed", $commentsIPDisallowed);
    
    $handlerMessage = "设置成功";   
    ALump_Logger::action("update comment setting");
}




?>
