<?php
class ForumModel extends Model{
	
	
	

	
	
	//获得index 页面的微贴列表
	
	function getwt_list($list,$since,$row){
				
		if($list=='fans_all'){			
			$user_op=A('Trade')->getlogined_id();
			$return=D()->query("select * from wo_weitie left join(wo_user_follow) on (wo_user_follow.fid= wo_weitie.user_id)   WHERE wo_user_follow.uid=$user_op ORDER BY wo_weitie.weitie_id DESC LIMIT $since,$row");   	     	     		      
			return $return;
		}
		else {
			   $return=D()->query("SELECT weitie_id,user_id,title,count_comment,is_photo,read_times,ctime FROM wo_weitie  ORDER BY weitie_id DESC LIMIT $since,$row");   	     	     		      
	           return $return;	
		}	
	}
	
	
	
	

    function  home_new_comment(){    //获得 home页面的 全区最新评论
    	
    $return=D()->query("select * from wo_weitie_comment   left join(wo_weitie) on (wo_weitie_comment.weitie_id= wo_weitie.weitie_id)  GROUP BY wo_weitie_comment.weitie_id  ORDER BY wo_weitie_comment.comment_id DESC LIMIT 18");   	     	     		      
	   return $return;	
    }
	    



	
	//获得分类页面的微贴列表
	
	function get_wt_class_list($_first,$_se,$since,$row){
	
	                  $return=D()->query("SELECT weitie_id,user_id,title,count_comment,is_photo,read_times,ctime FROM wo_weitie WHERE forum_class_first=$_first AND forum_class_second=$_se ORDER BY weitie_id DESC LIMIT $since,$row");   	     	     		      
	                  return $return;				
	}
	
	
	
    //获得我的的微贴列表
	
	function get_wt_me_list($id,$since,$row){
	
	                  $return=D()->query("SELECT weitie_id,user_id,title,count_comment,is_photo,read_times,ctime, last_comment_user_id,last_comment_is_read FROM wo_weitie WHERE user_id=$id ORDER BY weitie_id DESC LIMIT $since,$row");   	     	     		      
	                  return $return;				
	}
	
	
  //获得我参与评论微贴列表
	
	function get_pt_me_list($since,$row){
		
		 $user_op=A('Trade')->getlogined_id();  //两个表联合查询  哈哈哈哈
		 
	//	 SELECT * FROM wo_weitie_comment AS A left JOIN wo_weitie AS B ON A.weitie_id = B.weitie_id goup by a.coment_id;
		 
	                  $return=D()->query("select * from wo_weitie   left join(wo_weitie_comment) on (wo_weitie_comment.weitie_id= wo_weitie.weitie_id)   WHERE wo_weitie_comment.user_id=$user_op AND wo_weitie.user_id!=$user_op GROUP BY wo_weitie_comment.weitie_id  ORDER BY wo_weitie_comment.comment_id DESC LIMIT $since,$row");   	     	     		      

	                  
	                  return $return;				
	}
	
	
	
	
	
	  //获得我收到评论微贴列表
	
	function 	get_comment_me_list($since,$row){
		
		 $user_op=A('Trade')->getlogined_id();  //两个表联合查询  哈哈哈哈
		     //这是一个好的注释 不要删除
	       //	 SELECT * FROM wo_weitie_comment AS A left JOIN wo_weitie AS B ON A.weitie_id = B.weitie_id goup by a.coment_id;
		 
	                  $return=D()->query("select * from wo_weitie left join(wo_weitie_comment) on (wo_weitie.weitie_id=wo_weitie_comment.weitie_id ) WHERE (wo_weitie_comment.recomment_id_user_id=$user_op)OR( wo_weitie_comment.weitie_user_id=$user_op AND wo_weitie_comment.recomment_id=0) GROUP BY wo_weitie_comment.weitie_id  ORDER BY wo_weitie_comment.comment_id DESC LIMIT $since,$row");   	     	     		                                                         
	                  return $return;				
	}
	
	
	

	function getAll_teacher($p,$since,$row){
		$return=D()->query("SELECT * FROM wo_teacher ORDER BY put DESC LIMIT $since,$row");
		  foreach ($return as $k =>$value){	
             $t=$return[$k]['teacher_id'];
		  	$last_comment=D()->query("SELECT * FROM wo_teacher_comment WHERE teacher_id = $t ORDER BY comment_id DESC LIMIT 1");		         
		  	$return[$k]['last_comment']=$last_comment[0]['content'];
		  	if($p>=2){
		  		 $return[$k]['p_m_times']=($p-1)*33;
		  	}else {
		  		$return[$k]['p_m_times']=0;
		  	}
		  	
         }      		      
		      return $return;
	
		
	}
	
	
	
	

	
	function do_vote_teacher($id,$content){
		
		 $user_op=A('Trade')->getlogined_id(); 
	      $data=array(
			'teacher_id'=>$id,
			'content'=>$content,
	        'user_id'=>$user_op,
	        'ctime'=> time()        
			);
			$return=M('teacher_comment')->data($data)->add();
			
			D()->execute('UPDATE wo_teacher SET put = put +1 WHERE teacher_id = '.$id);
		    return $return;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	    //获得每一条微贴的详细信息
	function getEvery_wt($id){
		
		   $return=D()->query("SELECT * FROM wo_weitie WHERE weitie_id = $id");  
	       foreach ($return as $k =>$value){		        
		         $return[$k]['opreate']=$this->sure_weitie_opreate($return[$k]['user_id'],$return[$k]['weitie_id']); 
                 $return[$k]['class']=$this->sure_weitie_class($return[$k]['forum_class_first'],$return[$k]['forum_class_second']);
              }      		      
		      return $return;
	}
	
	
	
	
	
	function teacher_Info($id){     //获得每一位老师的信息
		$return=D()->query("SELECT * FROM wo_teacher WHERE teacher_id = $id");
		foreach ($return as $k =>$value){		       
		         $return[$k]['opereate']=$this->sure_teacher_opreate($id);                      
              }                   
		return $return;
	}
	
	function sure_teacher_opreate($teacher_id){        //只有管理员才可以删除每一位老师
		$user_op=A('Trade')->getlogined_id();		    
	    $is_admin=M('user')->where('user_id='.$user_op)->field('isAdmin')->find();
	    if ($is_admin['isAdmin']==1){
		      	  return "<a href=\"javascript:void(0);\"  class=\"dele_t\" onclick=\"dele_t(".$teacher_id.")\" >删除</a>";
		}else {
			return "";
		}
	}
	
	
	function get_teacher_comment_List($p,$id,$since,$row){       //获得每一位老师的评论
		$return=D()->query("SELECT * FROM wo_teacher_comment WHERE teacher_id = $id ORDER BY comment_id DESC LIMIT $since,$row");    
	   
		foreach ($return as $k =>$value){		       
		         $return[$k]['opreate']=$this->sure_teacher_comment_opreate($return[$k]['user_id']);                      
			if($p>=2){
		  		 $return[$k]['p_m_times']=($p-1)*12;
		  	}else {
		  		$return[$k]['p_m_times']=0;
		  	}
		}                   
		return $return;
	}
	
	

	function sure_teacher_comment_opreate($id){        //只有管理员和 当前评论的主人 才可以删除该条评论
	            $user_op=A('Trade')->getlogined_id();		   
	            $is_admin=M('user')->where('user_id='.$user_op)->field('isAdmin')->find();
		      if (($user_op==$id)||($is_admin['isAdmin']==1)){
		      	  return "3";
		      }
		      else {
		      	return "";
		      }
	}
	
	
	
	
	
	
	
	
	function getweitie_comment_List($id,$since,$row){
		$return=D()->query("SELECT * FROM wo_weitie_comment WHERE weitie_id = $id ORDER BY comment_id DESC LIMIT $since,$row");    

		
		foreach ($return as $k =>$value){
		        if ($return[$k]['recomment_id']!=0){ 
		        	$key=$return[$k]['recomment_id'];
		     	    $recomment=D()->query("SELECT * FROM wo_weitie_comment WHERE comment_id = $key");
		     	    if(!!$recomment){
		   	        $return[$k]['recomment']['comment_id']=$recomment[0]['comment_id'];
		   	        $return[$k]['recomment']['user_id']=$recomment[0]['user_id'];
		   	        $return[$k]['recomment']['content']=$recomment[0]['content'];
		   	        $return[$k]['recomment']['ctime']=$recomment[0]['ctime'];
		     	    }else {
		     	    	$return[$k]['recomment']['recomment_deleted']=3;//告诉前台，此评论已被原主人删除
		     	    }		   	       
		         }   
		         $return[$k]['opreate']=$this->sure_comment_opreate($return[$k]['user_id'],$return[$k]['weitie_id']);                      
              }                   
		return $return;
	}
	
	
	
	function get_wt_comment_Number($wt_id){   //获得每一条微贴的评论总数
		$number = D()->query("SELECT count(*) FROM wo_weitie_comment WHERE weitie_id = $wt_id");
		   return $number[0]['count(*)'];				  		   
	}
	
	
	function get_wt_Number($t){   //获得微贴的总数
		
		if ($t==""){  //就是获得全部微贴
		
		$number = D()->query("SELECT count(*) FROM wo_weitie");
		   return $number[0]['count(*)'];	
		}else {			//这是获得我关注的人的所有微贴总数
			$user_op=A('Trade')->getlogined_id();
			$return=D()->query("select * from wo_weitie  left join(wo_user_follow)on (wo_weitie.user_id=wo_user_follow.fid)   WHERE wo_user_follow.uid=$user_op");   	     	     		      
		  //   dump(D());
			return count($return);								
		}			  		   
	}
	
	function get_wt_class_Number($_first,$_se){   //获得分类微贴的总数
		$number = D()->query("SELECT count(*) FROM wo_weitie WHERE forum_class_first=$_first AND forum_class_second=$_se");
		   return $number[0]['count(*)'];				  		   
	}
	

		function get_i_join_Number(){   //获得我参与评论的微贴的总数
			 $user_op=A('Trade')->getlogined_id();
			$return=D()->query("select * from wo_weitie_comment   left join(wo_weitie) on (wo_weitie_comment.weitie_id= wo_weitie.weitie_id)   WHERE wo_weitie_comment.user_id=$user_op AND wo_weitie.user_id!=$user_op GROUP BY wo_weitie_comment.weitie_id");   	     	     		      

		     return count($return);				  		   
	}
		
	function get_comment_me_Number(){   //获得我收到评论的微贴的总数
			 $user_op=A('Trade')->getlogined_id();
			$return=D()->query("select * from wo_weitie_comment   left join(wo_weitie) on (wo_weitie_comment.weitie_id= wo_weitie.weitie_id)   WHERE wo_weitie.user_id=$user_op AND wo_weitie_comment.user_id!=$user_op GROUP BY wo_weitie_comment.weitie_id");   	     	     		      

		     return count($return);				  		   
	}
	
	
	
	
	
	
	
      function get_wt_me_Number($id){   //获得我的微贴的总数
		$number = D()->query("SELECT count(*) FROM wo_weitie WHERE user_id=$id");
		   return $number[0]['count(*)'];				  		   
	}
	
	
	// 删除每一条评论
	
	function deletedcomment($comment_id,$weitie_id){
		
		 $t=  D()->execute('UPDATE wo_weitie SET count_comment = count_comment -1 WHERE weitie_id = '.$weitie_id);
	      $y= M('weitie_comment')->where('comment_id='.$comment_id)->delete();      
	    if ($t&&$y) {
	 	 	return true;
	 	 }else {
	 	 	return false;
	 	 }    
	      ///   测试修改 
	    }
	
	
	
	//删除微贴
	 function deletedweitie($id){
	 	$t= M('weitie')->where('weitie_id='.$id)->delete();
	 	 $y=M('weitie_comment')->where('weitie_id='.$id)->delete();
	 	 if ($t&&$y) {
	 	 	return true;
	 	 }else {
	 	 	return false;
	 	 }
	 }
	
	
	
	function dele_teacher($teacher_id){    //删除教师席位
	     $t= M('teacher')->where('teacher_id='.$teacher_id)->delete();
	 	 $y=M('teacher_comment')->where('teacher_id='.$teacher_id)->delete();
	 	 if ($t||($t&&$y)) {
	 	 	echo  1;
	 	 }else {
	 	 	echo  0;
	 	 }
		
	}
	
	
	
	// 删除老师的一条评论
	
	function deleted_teacher_comment($comment_id){
	      return M('teacher_comment')->where('comment_id='.$comment_id)->delete();	     	      
	}
	
	
	
	function sure_comment_opreate($comment_user_id,$weitie_id){   //确定谁有权限删除该条评论
		
		    $user_op=A('Trade')->getlogined_id();
		    $weitie_user_id=M('weitie')->where('weitie_id='.$weitie_id)->field('user_id')->find();
	        $is_admin=M('user')->where('user_id='.$user_op)->field('isAdmin')->find();
		      if ($user_op==$comment_user_id){
		      	  return 3;
		      }
	         if ($is_admin['isAdmin']==1){
		      	  return 3;
		      }
	         if ($user_op==$weitie_user_id['user_id']){
		      	  return 3;
		      }
		      else {
		      	return "";
		      }
		
		
	}
	
	
	function sure_weitie_opreate($weitie_user_id,$weitie_id){       //确定当前登录用户对该篇微贴的操作
		    $user_op=A('Trade')->getlogined_id();
		    $is_admin=M('user')->where('user_id='.$user_op)->field('isAdmin')->find();
		    
	       if ($user_op==$weitie_user_id){
		      	  return "<a href=\"javascript:void(0)\" onclick=\"deletedweitie(".$weitie_id.")\">删除</a> <a href=\"javascript:void(0)\" onclick=\"re_xiugai(".$weitie_id.")\">修改</a>";
		      }
	         if ($is_admin['isAdmin']==1&&$user_op!=$weitie_user_id){
		      	  return "<a href=\"javascript:void(0)\" onclick=\"deletedweitie(".$weitie_id.")\">删除</a>";
		      }
		      else {
		      	return "&nbsp;&nbsp;&nbsp;";
		      }
		    
		    
	}
	
	
	
	function put($id){    //推荐为精华
	  return	$data = D()->execute('UPDATE wo_weitie SET put = put +1 WHERE weitie_id = '.$id); 
		
	}
	
	
	
	function sure_weitie_class($first,$second){   //确定每一条微贴的分类
		
		if (empty($first)&&empty($second)){
			return '未归类';
		}else{
			$first_class=M('forum_class_first')->where("forum_class_first_id	= $first")->field('forum_class_first_name')->find();
			$second_class=M('forum_class_second')->where("forum_class_first_id= $first AND first_second_id= $second")->field('forum_class_second_name')->find();
		    if ($first_class){
		    	$t=$first_class['forum_class_first_name'];
		    }else {
		    	$t=1;
		    }
		   if ($second_class){
		    	$y=$second_class['forum_class_second_name'];
		    }else {
		    	$y=1;
		    }
			if($t==1&&$y==1){
				return '&nbsp;&nbsp;&nbsp;未归类';		    	
		    }
		    if($t==1&&$y!=1){
				return '&nbsp;&nbsp;&nbsp;'.$y;		    	
		    }if($t!=1&&$y==1){
				return '&nbsp;&nbsp;&nbsp;'.$t;		    	
		    }
		    else {
		     	return  '&nbsp;'.$t.'&nbsp;&#8226;&nbsp;'.$y;
		    }	
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}







?>