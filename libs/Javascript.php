<?php
class ALump_Javascript {
	public static function replyCommentJS($type, $id){
		echo <<<EOT
		<script type="text/javascript">
		//<![CDATA[
		var ALumpComment = {
			dom : function (id) {
				return document.getElementById(id);
			},
		
			create : function (tag, attr) {
				var el = document.createElement(tag);
		
				for (var key in attr) {
					el.setAttribute(key, attr[key]);
				}
		
				return el;
			},
		
			reply : function (cid, coid) {
				var comment = this.dom(cid), parent = comment.parentNode,
				response = this.dom('respond-$type-$id'), input = this.dom('comment-parent'),
				form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
				textarea = response.getElementsByTagName('textarea')[0];
		
				if (null == input) {
					input = this.create('input', {
						'type' : 'hidden',
						'name' : 'parent',
						'id'   : 'comment-parent'
					});
		
						form.appendChild(input);
				}
	
				input.setAttribute('value', coid);
		
				if (null == this.dom('comment-form-place-holder')) {
					var holder = this.create('div', {
						'id' : 'comment-form-place-holder'
					});
		
						response.parentNode.insertBefore(holder, response);
				}
		
				comment.appendChild(response);
				this.dom('cancel-comment-reply-link').style.display = '';
		
				if (null != textarea && 'text' == textarea.name) {
					textarea.focus();
				}
		
				return false;
			},
		
			cancelReply : function () {
				var response = this.dom('respond-$type-$id'),
				holder = this.dom('comment-form-place-holder'), input = this.dom('comment-parent');
		
				if (null != input) {
					input.parentNode.removeChild(input);
				}
		
				if (null == holder) {
					return true;
				}
		
				this.dom('cancel-comment-reply-link').style.display = 'none';
				holder.parentNode.insertBefore(response, holder);
				return false;
			}
		}
		//]]>
		</script>
EOT;
	}
	
	public static function toPrev(){
		echo <<<EOT
		<script type="text/javascript">
		//<![CDATA[
				window.location = history.go(-1);
		//]]>
		</script>
EOT;
	}
	

	
	public static function showMaskDiv($msg, $tarurl){
		$siteDir = ALump::$options->siteDir();
		echo <<<EOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="all" href="$siteDir/folks/blackbox/css/blackbox.css" />
<script type="text/javascript" src="$siteDir/folks/jquery"></script>
<script type="text/javascript" src="$siteDir/folks/blackbox/js/jquery.blackbox.min.js"></script>
</head>
<body>
<script type="text/javascript">
		//<![CDATA[
	//$(function(){
	    var box = new BlackBox();
		box.alert("$msg", function () {
           window.location = "$tarurl";
	    }, {
	        title: '警告',
	        value: '关闭'
	    });
	//});
	
		//]]>
		</script>
</body>
</html>
EOT;
	}

}

?>