/**
 * 
 */

        
         function comment_teacher(id){
        	var content=$('.xheditor').val();
           if(id==""){
             	 alert('投票失败，稍后再试');            	 
              }
            else if(content==""){
         		apprise('嘿，投票的理由还没有填哦！。');
         	}else{
         	 $.post(SITE_URL+"Forum/do_vote_teacher",{id:id,content:content},function(txt){	
         		if(txt==1){
      				apprise('嘿，亲，评论的内容不能超过一千字哦！');
      			 }
    			else  if(txt==2){
       				apprise('投票成功！');
         			 window.location.reload();
      			 } else{
       				apprise('参数错误!,投票失败！请稍后再试！');
       			 }
         	 });
          }           
}
         
         
         
         
         function dele_t(id){
      	   apprise('所有投票评论也会一便删除，确定删除？', {'confirm':true},function(r){		
  				if(r){		
  					$.post(SITE_URL+"Forum/dele_teacher",{teacher_id:id},function(txt){		
  						if(txt==1){
  						
  						apprise('删除成功!');
  						   window.location.href=SITE_URL+"Forum/rank_teacher/_first/4/_se/1";
  						}else{
  							apprise('删除失败!，稍后再试!');
  						}
  											
  					});
  				}	
  			})
         }
         
         
         function deleted_teacher_comment(comment_id){
      	   apprise('确定要删除这条评论？', {'confirm':true},function(r){		
  				if(r){		
  					$.post(SITE_URL+"Forum/deleted_teacher_comment",{comment_id:comment_id},function(txt){			
  						$("#t_list_"+comment_id).slideUp(200);
  						});
  				}	
  			});
         }