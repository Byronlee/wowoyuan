/**
 * 用于闪存中@功能,回复,发布
 */


function initComment(id){
		 // 评论切换
		      var $comment_list = $("#comment_list_"+id);
			if( $comment_list.html() == '' ){
				 
				  $comment_list.html('<div class="feed_quote feed_wb" style="text-align:center"><img src="/Public/images/button/icon_waiting.gif" width="15"></div>');
				  $.post(SITE_URL+"Shancun/loadcomment",{id:id},function(txt){					 
				$comment_list.html( txt ) ;
			});
			  }else{
				  $comment_list.html('');
			 }
	
		  
	}
function initAddComment(){    
	   $("#bu").live('click',function(){		  
	    var comment_list = $(this).parents('.every');
	      var flash_id          = comment_list.attr('minid');
	      var host_id          = comment_list.attr('rel');   //该条闪存的主人
		  var textarea     = comment_list.find('textarea');
		  var reply_comment_id=comment_list.find('.reply_comment_id').val();
		 var _comment_content =textarea.val();
			if( _comment_content==''){
				apprise('输入点东西吧！');
			}
			
			else if((_comment_content.length)>140){
				apprise('嘿，你输入太多东西了!')
			}		
			else {		
				comment_list.find("input[type='button']").val( '评论中...').attr('disabled','true');
				$.post(SITE_URL+"Shancun/addComment",{comment_content:_comment_content,flash_id:flash_id,host_id:host_id,reply_comment_id:reply_comment_id},function(txt){								
					
					comment_list.find("#allComment").prepend(txt);	
					$.post(SITE_URL+"Shancun/comment_count",{flash_id:flash_id},function(txt){											
						$("a[rel='comment'][minid='"+flash_id+"']").html( "评论("+txt+")&nbsp;&nbsp;" );
						textarea.val('').focus();	
					});				
					comment_list.find("input[type='button']").val( '确定');
					comment_list.find("input[type='button']").removeAttr('disabled') ;														
					comment_list.find('.reply_comment_id').val('');		
										
				});
			}				
		});
}


function deleted(flash_id){
	apprise('确定删除？', {'confirm':true},function(r){		
		if(r){		
		$.post(SITE_URL+"Shancun/deleted",{flash_id:flash_id},function(txt){
			if(txt==1){
				$("#list_"+flash_id).hide(500);
			}
			else{
				apprise('删除失败，请稍后再试！');
			}
		});
		}	
	});	
}


   //删除评论
function deletedcomment(comment_id,flash_id){
	apprise('确定删除？', {'confirm':true},function(r){		
		if(r){		
		$.post(SITE_URL+"Shancun/deletedcomment",{comment_id:comment_id,flash_id:flash_id},function(txt){	
			txt = eval('('+txt+')');
			if(txt[0].status=='ok'){
				$("#list_"+comment_id).slideUp();
				$("a[rel='comment'][minid='"+flash_id+"']").html( "评论("+txt[0].count+")&nbsp;&nbsp;" );
			}else{
				apprise('删除失败，请稍后再试！');
			}	
		});
		}	
	});	
}

   
//回复
function reply( name, flash_id ,comment_id){	
	var o="#comment_"+flash_id+"_publish";
	$(o).val( '回复@'+name+':' ).focus();	
	$("#replay_"+flash_id).val(comment_id);
	
	var textArea = document.getElementById("comment_"+flash_id+"_publish");
	var strlength = textArea.value.length;
	 if (textArea.selectionStart || (textArea.selectionStart == '0')) { // Mozilla/Netscape…
        textArea.selectionStart = strlength;
        textArea.selectionEnd = strlength;
    }
	
	
}



//插入类似QQ表情
function face_insert(titleName,text)
{
   
	var content = $("#"+text+"_publish").val();
	$("#"+text+"_publish").val(function(){
		return content+"["+titleName+"]";
	});
	$("#publish_type_"+text+"_before").find("#face_list").remove();
    
}
function close_div(text){
	$("#publish_type_"+text+"_before").find("#face_list").remove();
}
function show_div(text){
	$.post(SITE_URL+"Shancun/loadExpression",{flag:text},function(txt){
		$("#publish_type_"+text+"_before").append(txt);
	});
	
}

function commentOpen(name,id)
{        

	var o="#comment_"+id+"_publish";		
	$(o).val( '回复@'+name+':').focus();
	var textArea = document.getElementById("comment_"+id+"_publish");
	var strlength = textArea.value.length;
	 if (textArea.selectionStart || (textArea.selectionStart == '0')) { // Mozilla/Netscape…
        textArea.selectionStart = strlength;
        textArea.selectionEnd = strlength;
    }	
		$('#comment_list_'+id).toggle(500);	
}
function AddComment(comment_id){    
	   
	   
    var comment_list = $('.addcomment_'+comment_id);
    var flash_id         = comment_list.attr('minid');   //flash_id
    var comment_id          = comment_list.attr('rel');   //comment_id
    var comment_user_id          = comment_list.attr('rell');   //comment_user_id
	  var textarea     = comment_list.find('.text');
	 var _comment_content =textarea.val();
	 if( _comment_content==''){
			apprise('你还没有发布任何评论的内容哦！')
			return false;
		}else	if(flash_id == ''||comment_id==''){
	    	  alert('评论失败！稍后再试');
	 		     return false;
	 		     }	
		else {		
			comment_list.find("input[type='button']").val( '评论中...').attr('disabled','true');
			$.post(SITE_URL+"Shancun/comment_publish",{comment_content:_comment_content,flash_id:flash_id,comment_id:comment_id,comment_user_id:comment_user_id},function(txt){			
				if(txt=='1'){
					apprise('评论成功！');
					textarea.val('')
					$('#comment_list_'+comment_id).hide();
				}else if(txt=='3'){
					apprise('亲发布的评论不能超过140字哦！');
					
				}else{
					 alert('评论失败！稍后再试');
				}
			});
		}
	
}