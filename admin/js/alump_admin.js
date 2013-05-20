function check_all(name)
{
  var el  = document.getElementsByTagName('input');
  var len = el.length;
  
  var isEqual = false;
  
  if(!name){
	  isEqual = true;
  }
  
  for(var i=0; i<len; i++) {
    if((el[i].type=="checkbox") ) {
    	if(isEqual == false){
    		if(el[i].name==name){
    			isEqual = true;
    		}
    	}
    	if(isEqual){
    		el[i].checked = true;
    	}
      
    }
  }
}

function clear_all(name)
{
  var el  = document.getElementsByTagName('input');
  var len = el.length;
  var isEqual = false;
  
  if(!name){
	  isEqual = true;
  }
  for(var i=0; i<len; i++) {
	    if((el[i].type=="checkbox") ) {
	    	if(isEqual == false){
	    		if(el[i].name==name){
	    			isEqual = true;
	    		}
	    	}
	    	if(isEqual){
	    		el[i].checked = false;
	    	}
	      
	    }
  }
}


function apply_all(op, name)
{
  var el  = document.getElementsByTagName('input');
  var len = el.length;
  var ids = '';
  
  for(var i=0; i<len; i++) {
    if((el[i].type=="checkbox") &&
       (el[i].name==name) &&
       el[i].checked == true &&
       el[i].value != '') {
      ids += encodeURIComponent(el[i].value) + ',';
    }
  }
  
  if (ids != ''){
	  var do_action = true;
	  if(op == "delete"){
		  do_action = false;
		  if(confirm("确认删除所选项?")){
			  do_action = true;
		  }
	  }
	  else if(op == "todraft"){
		  do_action = true;
	  }else if(op == "topublish"){
		  do_action = true;
	  }
	 
	  if(do_action == true){
		  var args = {
		    	    "action":op,
		    	    "ids":ids
		    	    };
		    $.get("",args, function (data, textStatus){	
		    	window.location.reload();
			}); 
	  }

  }
}

function do_filter(status)
{ 
    location.href = '?keyword=' + $("#keyword").val() + '&category=' + $("#category").val();
}

function goto_page(e)
{
  var evt = e || window.event;
  var eventSrc = evt.target||evt.srcElement;

  if ((e.keyCode || e.which) == 13) {
    location.href = '?state=publish&date=&tag=&page=' + eventSrc.value;
  }
}

var __$ = function(oid){ return document.getElementById(oid);}

function showHide(menu_id){
	var menu_id = __$(menu_id);
	if(menu_id.style.display == 'none'){
		menu_id.style.display = "";
	}else{
		menu_id.style.display = "none";
	}
	
}

function open_advance_setting(){
	var advande = __$("advande-setting-div");
	if(advande.style.display == 'none'){
		advande.style.display = "";
	}else{
		advande.style.display = "none";
	}
}


/**
 * 得到文件URL中的文件名
 * @param fileUrl
 * @returns
 */
function getFileNameFromUrl(fileUrl){
	var sindx = fileUrl.lastIndexOf('/');
	if(sindx == -1){
		return "";
	}
	
	return fileUrl.substring(sindx+1);
}
/**
 * 转到其它分类
 * @param cateid
 * @param name
 */
function post_to_category(cateid, name){
	var el  = document.getElementsByTagName('input');
	  var len = el.length;
	  var ids = '';
	  
	  for(var i=0; i<len; i++) {
	    if((el[i].type=="checkbox") &&
	       (el[i].name==name) &&
	       el[i].checked == true &&
	       el[i].value != '') {
	      ids += encodeURIComponent(el[i].value) + ',';
	    }
	  }
	  
	 
	  var cate = $("#"+cateid).val();
	  
	  if(cate == ""){
		  return;
	  }
	  if (ids != ''){
		  var args = {
		    	    "action":"tocategory",
		    	    "ids":ids,
		    	    "category":cate
		    	    };
		  
		    $.get("",args, function (data, textStatus){	
		    	window.location.reload();
			}); 
	  }
}



