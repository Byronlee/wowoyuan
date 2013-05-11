/**
 * 
 */
  function onload_init(){
	  init();
      initComment();
      initAddComment()
  }
  
     function init(){		
		var Interval;
		$("#content_publish").blur(function(){
			clearInterval(Interval);
			checkInputLength(this,140);
		}).focus(function(){
			//微博字数监控
			clearInterval(Interval);
		    Interval = setInterval(function(){
		    	checkInputLength('#content_publish',140);
			},100);
		});
		checkInputLength('#content_publish',140);		
}

//检查字数输入
function checkInputLength(obj,num){
	    var len=$(obj).val().length;
	    var wordNumObj = $('.wordNum');

		if(len==0){
			wordNumObj.css('color','').html('你还可以输入<strong id="strconunt">'+ (num-len) + '</strong>字');
		}else if( len > num ){
			wordNumObj.css('color','red').html('已超出<strong id="strconunt">'+ (len-num) +'</strong>字');
		}else if( len <= num ){
			wordNumObj.css('color','').html('你还可以输入<strong id="strconunt">'+ (num-len) + '</strong>字');
		}
	}

//发布前的检测
   function before_publish(content){	
		if( content == '' ){       		
			return 1;
		}
		else if(content.length>140){		 
	         return 2;
		}
		else{			
			return 3;								
		}
	}
function do_publish(){
	var content=$("#content_publish").val();
	var t=before_publish(content);
	if( t==3 ){	
		$.post(SITE_URL+"ShanCun/republic",{content:content},function(txt){
			if(txt==4){
			  $.post(SITE_URL+"ShanCun/publish",{content:content},function(txt){
					 $(".feed_list").prepend(txt);
					    var clear=$('#miniblog_publish');
					    clearForm(clear);
					 });
				
			}else{
				var w=apprise('亲，不能发布重复内容哦！');
				 var t=setTimeout("$('.appriseOverlay').remove();$('.appriseOuter').remove();",5000);
			}		 
		 });
		 }else if(t==1){
			var w=apprise('输入点东西在发布吧！');
			 var t=setTimeout("$('.appriseOverlay').remove();$('.appriseOuter').remove();",5000);
	 }else{
		 var len=($('#content_publish').val().length)-140;
		 apprise('嘿，你已经超出'+len+'个字了！');
	 }	
}
function clearForm(obj){      //obj为form表单  
    $(obj).find(':input').each(  
        function(){  
            switch(this.type){  
                case 'passsword':  
                case 'select-multiple':  
                case 'select-one':  
                case 'text':  
                case 'textarea':  
                    $(this).val('');  
                    break;  
                case 'checkbox':  
                case 'radio':  
                    this.checked = false;  
            }  
        }     
    );  
    var wordNumObj = $('.wordNum');
    	wordNumObj.css('color','').html('你还可以输入<strong id="strconunt">'+ 140 + '</strong>字');
}


function initComment(){
		 // 评论切换
		  $("a[rel='comment']").live('click',function(){
		      var id = $(this).attr('minid');
		      var $comment_list = $("#comment_list_"+id);
			if( $comment_list.html() == '' ){
				  $comment_list.html('<div class="feed_quote feed_wb" style="text-align:center"><img src="/Public/images/button/icon_waiting.gif" width="15"></div>');
				  $.post( SITE_URL+"ShanCun/loadcomment",{id:id},function(txt){					 
				$comment_list.html( txt ) ;
			});
			  }else{
				  $comment_list.html('');
			 }
		  });
		  
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
				apprise('输入点东西再评论吧！');
			}
			
			else if((_comment_content.length)>140){
				apprise('嘿，你输入太多东西了!')
			}		
			else {		
				comment_list.find("input[type='button']").val( '评论中...').attr('disabled','true');
				$.post(SITE_URL+"ShanCun/addComment",{comment_content:_comment_content,flash_id:flash_id,host_id:host_id,reply_comment_id:reply_comment_id},function(txt){								
						
					comment_list.find("#allComment").prepend(txt);	
					comment_list.find("input[type='button']").val( '确定');
					comment_list.find("input[type='button']").removeAttr('disabled') ;														
					comment_list.find('.reply_comment_id').val('');		
					$.post(SITE_URL+"ShanCun/comment_count",{flash_id:flash_id},function(txt){											
						$("a[rel='comment'][minid='"+flash_id+"']").html( "评论("+txt+")&nbsp;&nbsp;" );
						textarea.val('').focus();	
					});						
				});
			}				
		});
}


function deleted(flash_id){
	apprise('确定删除？', {'confirm':true},function(r){		
		if(r){		
		$.post(SITE_URL+"ShanCun/deleted",{flash_id:flash_id},function(txt){
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
		$.post(SITE_URL+"ShanCun/deletedcomment",{comment_id:comment_id,flash_id:flash_id},function(txt){	
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
	$.post(SITE_URL+"ShanCun/loadExpression",{flag:text},function(txt){
		$("#publish_type_"+text+"_before").append(txt);
	});
	
}