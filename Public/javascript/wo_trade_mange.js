/**
 * 
 */

$(document).ready(function(){	
	
	//这是管理员身份 可以强制删除窝窝园内任何一件宝贝
	$('.down').live('click',function(){
		var parent  = $(this).parent();
		 var goods_id= parent.find(".goods_id").val();	
		 apprise('确定要强制下架该宝贝？', {'confirm':true},function(r){		
				if(r){		
					$.post(SITE_URL+"Trade/force_down",{goods_id:goods_id},function(txt){			
						parent.html("管理员<br /><input type=\"button\" value=\"下架成功!\"  class=\"succ_down\" />");			
						});
				}	
			});	
     });
	
	      //这是当前登录用户删除他上架的任意一件没有 交易成功的宝贝
	$('.I_down').live('click',function(){
		var parent  = $(this).parent().parent();
		 var goods_id= parent.find(".goods_id").val();
		 apprise('确定下架该宝贝？', {'confirm':true},function(r){		
				if(r){		
					$.post(SITE_URL+"Trade/force_down",{goods_id:goods_id},function(txt){			
						parent.html("<input type=\"button\" value=\"下架成功!\"  class=\"succ_down\" />");			
						});
				}	
			});	
     });   
	$('.sure_trade').live('click',function(){	
		        var parent  = $(this).parent().parent();
  			    var goods_id= parent.find(".goods_id").val();
		apprise('确定交易成功？', {'confirm':true},function(r){		
			if(r){					
				$.post(SITE_URL+"Trade/sure_trade",{goods_id:goods_id},function(txt){	
					parent.parent().find('.sure_trade_su').html("<input type=\"button\" value=\"交易成功!\"  class=\"succ issa\" />");	
					parent.parent().find('.mt').html("(新)主人");
					parent.html("");					
				});
			}	
		});			
     });
	 
	
	$('.cancel_trade').live('click',function(){	
            var parent  = $(this).parent().parent();
		    var goods_id= parent.find(".goods_id").val();
               apprise('确定取消此项交易？',{'confirm':true},function(r){		
	            if(r){					
		             $.post(SITE_URL+"Trade/cancel_trade",{goods_id:goods_id},function(txt){	
			          parent.parent().find('.sure_trade_su').html("<input type=\"button\" value=\"未交易\"  class=\"statu issa\" />");	
			         parent.parent().find('.canl_t').addClass("canl");
			          parent.html("");	
		             });
		       }
	         });	
         });
	
	
	
	$('.change_info').live('click',function(){	
        var parent  = $(this).parent().parent();
	    var goods_id= parent.find(".goods_id").val();
	    var d_= parent.find(".d_").val();
           apprise('确定修改此宝贝的详细资料？',{'confirm':true},function(r){		          
            		  window.location.href=SITE_URL+"Trade/shelve/_t/"+goods_id+"/x_/"+d_;
           });
         });	
  });