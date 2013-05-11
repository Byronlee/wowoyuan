<?php
class ShanCunAction extends CommonAction{
     
	public function index(){
				
		$this->assign("uvatar",uvatar);
		$this->assign("uname",uname);
		import("ORG.Util.Page");
		$type = ($_GET['t_']=='friend_flash')?'friend_flash':'all_flash';  
		$this->assign('type',$type);		
		if($type=='all_flash'){
			$number = D()->query("SELECT count(*) FROM wo_flash");			
			$page = new Page($number[0]["count(*)"],50);	
		    $data = D ( 'Flash')->getHomeList($page->firstRow, $page->listRows);  
		     $show  = $page->show();
			$this->assign ("data",$data );
			$this->assign ('page',$show);		
			$this->setTitle ( '窝窝园-闪存' );
			$this->display ();  	       	       	
		}else if($type=='friend_flash'){			
			$number = D('Flash')->count_friend_flash($this->uid);			
			$page = new Page($number,50);	
		    $data = D ( 'Flash')->getHomeList($page->firstRow, $page->listRows,111);   
		    $show  = $page->show();
			$this->assign ("data",$data );
			$this->assign ('page',$show);		
			$this->setTitle ( '窝窝园-闪存' );
			$this->display ();	       		
		}else{
			 $this->assign('waitSecond',3);
    		 $this->error('你访问的页面不存在或者已被删除！');	
		}
		  
}



   //发布
    function publish(){   		
    	$pflash = D('Flash');
        $content = h(trim($_POST['content'])); 
     if(mb_strlen($content,'utf8')>140){  //限制发表内容多长度，默认为140
		 	               $this->assign('waitSecond',3);
    		               $this->error('发这么多内容干啥^_^，不能超过140字。');

	} else {			 	
                      
                      if($_SESSION['flash_body']!=$content){

         	                Session::set('flash_body',$content);
                      
		
					       $id = $pflash ->publish( $this->uid , $content);
					       if( $id ){
					        	 $data = M('flash')->where("user_id=$this->uid")->order('flash_id DESC')->limit("1")->findAll();
    	                         $this->assign('data',$data);
					        	$this->display();					
					       }
                      }else{
                      	   $this->assign('waitSecond',3);
    		               $this->error('亲，不能发布重复内容哦！');
                      }
   			 }
    
    }
    
    
    
    //发布前检验，是否重复发布
    function republic(){
    	 $content = h(trim($_POST['content'])); 
         if($_SESSION['flash_body']!=$content){
         	echo 4;
         }else{
         	echo 5;
         }
    }
    
    
    
    
    
	function deleted(){
		$t=intval($_POST['flash_id']);
          if($t){
          	$delete=D('Flash')->flash($t); 
          	echo $delete;         	
          }else{
             echo 2;
          }
}
	
   function deletedcomment(){
   	$t=intval($_POST['comment_id']);
   	$y=intval($_POST['flash_id']);
      if($t&&$y){
           $delete=D('Flash')->flash_comment($t,$y);
           if($delete){
             	$count=M('flash')->where('flash_id='.$y)->field('flash_comment_time')->find();
    		    $r  = intval( $count['flash_comment_time']);
    		    echo '[{"status":"ok","count":"'.$r.'"}]';;
            }else{           	        	
    		    echo  '[{"status":"on"}]';
            }          		
          }else{
             echo  '[{"status":"on"}]';
          }         
   }
   
 
	
	
	// 点击表情按钮加载表情
  function loadExpression(){
  	 $flag = $_POST['flag'];
				 
				  	 // $flag =1 ;
				  	  if (!empty($flag)) {
				  	  	// 输出表情列表
				  	  	$return = "<div id='face_list' style='disply:block'>
				      
				                   <table width='100%' border='0' cellpadding='0' cellspacing='0'>
				  <tr>
				<td width='438' height='27' style='font-size:13px;'>&nbsp;点击插入表情</td>
				<td width='32' align='center' background='img/vote_r2.gif'><a href='javascript:void(0);' onclick='close_div(\"".$flag."\")' title='关闭'><img src='/Public/images/button/closeBtn.jpg' width='15' height='15' border='0' /></a></td>
				  </tr>
				  <tr>
				  <td height='100' colspan='2' valign='top' class='top_line_1'>";
				  	  $data  = D()->query("SELECT * FROM wo_expression ");
				  	  foreach($data as $key=>$value){
				  	  	$return.="<a href='javascript:void(0);' title=".$value['title']." class='face_a' onclick=face_insert('".$value['title']."','".$flag."'); return false;' ><img src='/Public/images/expression/".$value['filename']."' /></a>";
				  	  }
				  	  $return.="</td>
				  </tr>
				</table>                 
				 </div>";
				  	  echo $return;	
				  	  }
				  	  else echo '表情加载失败!';
  }	
	



 
  // 加载评论
    function loadcomment(){
    	$flash_id  = intval($_POST['id']);
    	//echo $flash_id;
	   	if (!empty($flash_id)) {                              //Session::set('flash_id',$flash_id);
	    	$data = D('Flash')->getComment($flash_id,20);
	    	$this->assign('flash_id',$flash_id);
	    	$this->assign('data',$data);
	    	$this->display();
	    }else {
	    	 $this->assign('waitSecond',3);
    		 $this->error('加载评论失败，稍后再试！');
	    }
    }
    //  index  页面添加评论
    function addComment(){         // 要限制评论的长读
 
     $comment_content = h(trim($_POST['comment_content'])); 
     if(mb_strlen($comment_content,'utf8')>140){  //限制发表内容多长度，默认为140
		 	               $this->assign('waitSecond',3);
    		               $this->error('发这么多内容干啥^_^，不能超过140字。');

	 } else {
	 	
		         $reply_comment_id=$_POST['reply_comment_id'];
		         $flash_id=$_POST['flash_id'];
		         $this->assign('flash_id',$flash_id);
		         $host_id=$_POST['host_id']; 	   //被评论的闪存的人的id;
		         if(!!intval($reply_comment_id)){    //这是回复已有的评论，这只是通知改评论的主人，而不用在去通知改改评论所属闪存的主人
					         	
		         	$reply_comment_user=M('flash_comment')->where("comment_id= $reply_comment_id")->field('user_id')->find();
                    $us=$reply_comment_user['user_id'];
		         			$data=array(
					    	       'user_id'=>$this->uid,
					    	       'flash_id'=>$flash_id,
					    	       'comment_body'=>$comment_content,
					    	       'receive_user_id'=>$host_id,
					               'recomment_id'=>$reply_comment_id, 
		         			       'recomment_user_id'  => $us,
					               'ctime'=>time()
					    	 );			    	 
							  $data =   M('flash_comment')->add($data);
							   if($data){
							   
							     $updata = D()->execute('UPDATE wo_flash SET flash_comment_time = flash_comment_time +1 WHERE flash_id = '.$flash_id); 												     
					        	 	// 通知和动态       
					        	 	//这只是通知改评论的主人，而不用在去通知改改评论所属闪存的主人
					   	            $form=$this->uid;
						            $comment_user_id=M('flash_comment')->where("comment_id=$reply_comment_id")->field('user_id')->find();
							        if ($form!=$comment_user_id['user_id']){
							      	   A('Notify')->send( $form, $comment_user_id['user_id'],1 ); //规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；
							        }               
					           	    $data = D('Flash')->getComment($flash_id);
					    	        $this->assign('data',$data[0]);
					                $this->display();
							   }else {
									   $this->assign('waitSecond',3);
			    		               $this->error('评论失败，稍后再试!');
							   }	 		    	 
				   }else{				   	//这是直接评论闪存的情况   就直接通知闪存的主人
							   $data=array(
					    	       'user_id'=>$this->uid,
					    	       'flash_id'=>$flash_id,
					    	       'comment_body'=>$comment_content,
					    	       'receive_user_id'=>$host_id,   	   //被评论的闪存的人的id;
					               'ctime'=>time()
					    	 );			    	 
							  $data =   M('flash_comment')->add($data);
							   if($data){							   
							     $updata = D()->execute('UPDATE wo_flash SET flash_comment_time = flash_comment_time +1 WHERE flash_id = '.$flash_id); 												     
					        	 	// 通知和动态       
					        	 	//这是直接评论闪存的情况   就直接通知闪存的主人
					   	            $form=$this->uid;						          
							        if ($form!=$host_id){
							      	   A('Notify')->send( $form,$host_id,1 ); //规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；
							        }               
					           	    $data = D('Flash')->getComment($flash_id);
					    	        $this->assign('data',$data[0]);
					                $this->display();
							   }else {
									   $this->assign('waitSecond',3);
			    		               $this->error('评论失败，稍后再试!');
							   }	 					   					   	
				   } 
	}
        
        
  }
  
  
  //comment  页面添加评论    
  //发布微贴的评论
	function comment_publish(){

	$comment_content = h(trim($_POST['comment_content'])); 
     if(mb_strlen($comment_content,'utf8')>140){  //限制发表内容多长度，默认为140
		 	              echo 3;

	 } else {
	 	
		         $reply_comment_id=intval($_POST['comment_id']);
		         $flash_id=intval($_POST['flash_id']);
		         $this->assign('flash_id',$flash_id);
		        $recomment_user_id=intval($_POST['comment_user_id']);
		       // dump($recomment_user_id);
		         if(!!intval($reply_comment_id)){    //这是回复已有的评论，这只是通知改评论的主人，而不用在去通知改改评论所属闪存的主人

		         	$receive_user_id=M('flash')->where("flash_id=$flash_id")->field('user_id')->find();
                      $us=$receive_user_id['user_id'];
		         	$data	= array(
						'flash_id'		=>$flash_id,
						'user_id'		=> $this->uid,
		         		'receive_user_id'=> $us,
						'comment_body'	=> $comment_content,
				        'recomment_id'=>$reply_comment_id,
		         	    'recomment_user_id'=>$recomment_user_id,
						'ctime'		=> time(),
						);
		         			         		    	 
							  $data =   M('flash_comment')->add($data);
							   if($data){
							   
							     $updata = D()->execute('UPDATE wo_flash SET flash_comment_time = flash_comment_time +1 WHERE flash_id = '.$flash_id); 												     
					        	 	// 通知和动态       
					        	 	//这只是通知改评论的主人，而不用在去通知改改评论所属闪存的主人
					   	            $form=$this->uid;						            
							        if ($form!=$recomment_user_id){
							      	   A('Notify')->send( $form, $recomment_user_id,1 ); //规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；
							        }               
			           	            echo 1;
							   }else {
									   echo 2;
							   }	 		    	 
				   }else{				   
							
									  echo 2;				   					   	
				   } 
	}
        

}
  
  
  
   
    function comment_count(){     //返回 改闪存 现在的评论总数
    	 $flash_id=$_POST['flash_id'];
    	 $count=M('flash')->where("flash_id=$flash_id")->field('flash_comment_time')->find();
    	 echo $count['flash_comment_time'];
    }
    
    
    
    
    function comment(){
    	//1.收到的评论2.发出的评论  
    	$type = $_GET['type'];
    	import("ORG.Util.Page");
    	$user_op=$this->uid;
    	$this->assign("type",$type);
    	if ($type==1){
    		//收到的评论 	
    		$number =D()->query("select * from wo_flash left join(wo_flash_comment) on (wo_flash.flash_id= wo_flash_comment.flash_id) WHERE  (wo_flash_comment.recomment_user_id=$user_op) OR (wo_flash_comment.receive_user_id=$user_op AND wo_flash_comment.recomment_user_id=0)");
    		$page = new Page(count($number), 50);
    		$data = $this->getComment($page->firstRow,$page->listRows);	
    		//消除通知		
    		$t=$this->uid;   		   		
    					//	规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；5为 @    				 	
							 if( 0!=M('notify')->where("receive= $t AND is_read=0 AND type= 1")->count()){
							     //清除通知
	    					    M('notify')->data(array('is_read'=>1))->where("receive= $t AND is_read=0 AND type= 1")->save();    	
							 }	
    		$show = $page->show();	
	    	$this->assign('data',$data);
	    	$this->assign('page',$show);
	    	$this->assign('title','我收到的评论');
	    	$this->display();   		
    	}else if($type==2){
    		//发出的评论 
    		$number =D()->query("select * from wo_flash_comment  WHERE user_id=$user_op");
    		$page = new Page(count($number), 50);
    		$data = $this->getComment($page->firstRow,$page->listRows,$this->uid);
    		$show = $page->show();
	    	$this->assign('data',$data);
	    	$this->assign('page',$show);
	    	$this->assign('title','我发出的评论');
	    	$this->display();
    	} 
    	else {
    		 $this->assign('waitSecond',3);
    		 $this->error('你请求的页面不存在，稍后再试！');
    	}      	
    	   	
    }
    
    
  function getComment($since,$row,$du){     
    	if(!!empty($du)){      //获取我收到的评论的列表
			    	$user_op=$this->uid;	
			        $data=D()->query("select * from wo_flash left join(wo_flash_comment) on (wo_flash.flash_id= wo_flash_comment.flash_id) WHERE  (wo_flash_comment.recomment_user_id=$user_op) OR (wo_flash_comment.receive_user_id=$user_op AND wo_flash_comment.recomment_user_id=0) ORDER BY comment_id DESC LIMIT $since,$row");
			        foreach ($data as $key=>$value){
			        	
			        	  $f_u=$data[$key]['flash_id']+$data[$key]['receive_user_id'];
			        	 $url = U ( 'Shancun/detail', array ('f_'=>$data[$key]['flash_id'],'u_'=>$data[$key]['receive_user_id'],'f_u'=>md($f_u)));
			        	
			        	if(!!empty($data[$key]['recomment_id'])){			        		        					        	
			        	 $con=$data[$key]['flash_body'];
			        		if(!empty($con)){
			  		   		$data[$key]['flash_body']= "<a href='{$url}' target=\"_blank\" title=\"查看原闪存\">".format($con)."</a>";
			  		   	}else {
			  		   		$data[$key]['flash_body']=	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;此闪存已被原主人删除！&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			  		   	}
			  		   }if (!empty($data[$key]['recomment_id'])){ 			  		   	 		   			  		   
			  		   	$r=$data[$key]['recomment_id'];
			  		   	$comment_content=M('flash_comment')->where('comment_id='.$r)->field('comment_body')->find();
			  		   	$con=$comment_content['comment_body'];
			  		   	if(!empty($con)){
			  		   		$data[$key]['recomment_body']=	"<a href='{$url}' target=\"_blank\" title=\"查看该评论的闪存\">".format($con)."</a>";
			  		   	}else {
			  		   		$data[$key]['recomment_body']=	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;此评论已被原主人删除！&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			  		   	}
			  		   	
			  		   }  		  		   
			    	$data[$key]['opreate']=	D('Flash')->operate_flash_comment($data[$key]['user_id'],$data[$key]['comment_id'],$this->uid,$data[$key]['flash_id']);
			    }
   }else{       //这是我发出的评论
   					$data=D()->query("select * from wo_flash_comment  WHERE user_id=$du ORDER BY comment_id DESC LIMIT $since,$row"); 					
   					foreach ($data as $key=>$value){
   						 $f_u=$data[$key]['flash_id']+$data[$key]['receive_user_id'];
   						 $url = U ( 'Shancun/detail', array ('f_'=>$data[$key]['flash_id'],'u_'=>$data[$key]['receive_user_id'],'f_u'=>md($f_u)));
			        	if(!!empty($data[$key]['recomment_id'])){
					        	 $r=$data[$key]['flash_id'];
			  		         	  $flash_body=M('flash')->where('flash_id='.$r)->field('flash_body')->find();
			  		   	          $con=$flash_body['flash_body'];
					        		if(!empty($con)){
					  		   		$data[$key]['flash_body']= "<a href='{$url}' target=\"_blank\" title=\"查看原闪存\">".format($con)."</a>";
					  		   	}else {
					  		   		$data[$key]['flash_body']=	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;此闪存已被原主人删除！&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					  		   	}
			  		   }if (!empty($data[$key]['recomment_id'])){ 			  		   	 		   			  			  		  
			  		     	$r=$data[$key]['recomment_id'];
			  		       $comment_content=M('flash_comment')->where('comment_id='.$r)->field('comment_body')->find();
			  		   	   $con=$comment_content['comment_body'];
			  		   	if(!empty($con)){
			  		   		$data[$key]['recomment_body']=	"<a href='{$url}' target=\"_blank\"  title=\"查看该评论的闪存\">".format($con)."</a>";
			  		   	}else {
			  		   		$data[$key]['recomment_body']=	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;此评论已被原主人删除！&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			  		   	}
			  		   	
			  		   }  		  		   
			    	$data[$key]['opreate']=	D('Flash')->operate_flash_comment($data[$key]['user_id'],$data[$key]['comment_id'],$this->uid,$data[$key]['flash_id']);
			    }
   }
    return $data;
  }   
    
  
  
  
  function at_me(){
  	
  	    $this->assign("uvatar",uvatar);
		$this->assign("uname",uname);
		import("ORG.Util.Page");		
             $uid=$this->uid;
			$number =D('flash')->get_atmeListcount($page->firstRow, $page->listRows,$uid);
			$page = new Page($number,50);	
		    $data = D('flash')->get_atmeList($page->firstRow, $page->listRows,$uid);           			
		    $show  = $page->show();
			$this->assign ("data",$data );
			$this->assign ('page',$show);				
               $t=$this->uid;
    		
    		//	规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；5为 @    				 	
			if( 0!=M('notify')->where("receive= $t AND is_read=0 AND type= 5")->count()){
				 //清除通知
	    		   M('notify')->data(array('is_read'=>1))->where("receive= $t AND is_read=0 AND type= 5")->save();    	
			 }			
		$this->setTitle ( 'at提到我的闪存' );
		$this->display ();
  }
  

    
    function alluser(){    //通知所需要的全部用户信息
    	$user_list=M('user')->field('username')->order('user_id DESC')->findAll(); 	
    	  echo json_encode($user_list);
    }
    
    
    
    function detail(){
    	$flash_id=intval($_GET['f_']);
    	$user_id=intval($_GET['u_']);
    	$f_u=$_GET['f_u'];
    	$f_u_=md($flash_id+$user_id);
    	if($f_u==$f_u_){
			    	$m_user_id=M('flash')->where('flash_id='.$flash_id)->field('user_id')->find();
			    	if($user_id==$m_user_id['user_id']){
			    		
			    		$data_flash=M('flash')->where('flash_id='.$flash_id)->find();   		           
			            $data_flash['operate']=D('Flash')->operate_flash($data_flash['user_id'],$data_flash['flash_id'],$this->uid);     	
			 
			    		$data_c=D('Flash')->getComment($flash_id);
			    		if($data_flash&&$data_c){
			    			$this->assign('data_flash',$data_flash);
			    			$this->assign('data_c',$data_c);
			    			$this->display();
			    		}else {
			    			$this->assign('waitSecond',3);
			    		    $this->error('数据加载失败！，稍后再试！');
			    		}
			    	}else {
			    		 $this->assign('waitSecond',3);
			    		 $this->error('哦，亲，你的请求不存在哦，稍后再试！');
			    	}
    	}else{
    		$this->assign('waitSecond',3);
			$this->error('哦，亲，你的请求不存在哦，稍后再试！');
    	}
    }
    
    
    
    
    
    

}
?>