 /*显示隐藏回复*/


            function commentOpen(id)
            {           	
            	$('.rcomment_'+id).toggle(500);
            }   
            function checkcomment()
            {
    	      var content = $("#wt_comment_publish").find('textarea[name=comment_content]').val();
    	      var weitie_id = $(".weitie_id").val();   //有问题
    	      if(content == ''){
    	    	  apprise('嘿，亲，评论的内容还没有填哦！');
    		     return false;
    		     }
    	      else{
            		$.post(SITE_URL+"Forum/do_wt_comment_publish",{content:content,weitie_id:weitie_id},function(txt){       	
            			 if(txt==1){
              				apprise('嘿，亲，评论的内容不能超过一千字哦！');
              			 }
            			else  if(txt==2){
               				apprise('评论成功！');
                 			 window.location.reload();
              			 } else{
               				apprise('参数错误!,评论发布失败！请稍后再试！');
               			 }
            			 });
    	       }	
          }
           
           function recomment(comment_id){

        	 var content = $('#recom_'+comment_id).val();
     	     var weitie_id = $(".weitie_id").val();
     	        
     	       if(content ==''){
     	    	  apprise('嘿，亲，评论的内容还没有填哦！');
     		     return false;
     		     }
     	       else if(weitie_id == ''){
     	    	  alert('参数错误！提交失败！');
     		     return false;
     		     } else{
             		 $.post(SITE_URL+"Forum/do_wt_comment_publish",{content:content,comment_id:comment_id,weitie_id:weitie_id},function(txt){       	            			
             			 if(txt==1){
               				apprise('嘿，亲，评论的内容不能超过一千字哦！');
               			 }
             			else  if(txt==2){
                				apprise('评论成功！');
                  			 window.location.reload();
               			 } else{
                				apprise('参数错误!,评论发布失败！请稍后再试！');
                			 }
             		 });
     	      }
              }
           
           
           
           function deletedcomment(comment_id){
        	   apprise('确定要删除这条评论？', {'confirm':true},function(r){		
    				if(r){		
    					 var weitie_id = $(".weitie_id").val();
    					$.post(SITE_URL+"Forum/deletedcomment",{comment_id:comment_id,weitie_id:weitie_id},function(txt){			
    						$("#list_"+comment_id).slideUp(200);
    						});
    				}	
    			});
           }
           function deletedweitie(id){
        	   apprise('所有评论也会一便删除，确定删除？', {'confirm':true},function(r){		
    				if(r){		
    					$.post(SITE_URL+"Forum/deletedweitie",{weitie_id:id},function(txt){		
    						   window.location.href=SITE_URL+"Forum/wt_me/t_y_p/my";
    						});
    				}	
    			})
           }
           function re_xiugai(id){

        	   apprise('确定要修改此篇微贴？', {'confirm':true},function(r){		
    				if(r){		   					
    				var x_id = $("#x_id").val();   					
    				window.location.href=SITE_URL+"Forum/wt_publish/_t_y/"+id+"/x_id/"+x_id;
    				}	
    			})
           }
         function put(id){
        	   $.post(SITE_URL+"Forum/put",{weitie_id:id},function(txt){	
        		     if(txt==2){
        		    	 apprise('推荐成功了，更多人会看到的哦！');
        		    	 $('.j_h').parent().html('<input type="button"" class="j_h" value="推荐成功！" title="推荐为精华，为更多人看到这篇微贴" onclick="put({$every[0][\'weitie_id\']})"/>');
        		     }
        		     if(txt==1){
        		    	 apprise('嘿，不能重复推荐哦！');
        		     }if(txt==3){
        		    	 apprise('推荐失败！，稍后再试！');
        		     }
    				});

           }