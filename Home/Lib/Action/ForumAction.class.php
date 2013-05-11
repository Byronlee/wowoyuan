

<?php
class ForumAction extends CommonAction{

	public function index(){	
		
		$z_ = ($_GET['z_']=='fans_all')?'fans_all':'in_all';  	
		$this->assign('z_',$z_);
		
		if($z_=='fans_all'){
		    $menut=$this->getAllweishe_classlist();
	        $this->assign('menut',$menut);

	         import("ORG.Util.Page");               //这是对微贴分页
             $number = D('Forum')->get_wt_Number(2);
             $page = new Page($number,35);
             $content=D('Forum')->getwt_list('fans_all',$page->firstRow,$page->listRows);       
    	     $show = $page->show();
    	     $this->assign('page',$show);
	         $this->assign('content',$content);
	         $this->display();
		}
		else {
		   $menut=$this->getAllweishe_classlist();
	       $this->assign('menut',$menut);

	      import("ORG.Util.Page");               //这是对微贴分页
          $number = D('Forum')->get_wt_Number();
          $page = new Page($number,35);
          $content=D('Forum')->getwt_list('in_all',$page->firstRow,$page->listRows);       
    	  $show = $page->show();
    	  $this->assign('page',$show);
	      $this->assign('content',$content);
	      $this->display();
		}
		
	     
 }
  
        
	public function forum_class(){	
		
		$_first=intval( $_GET['_first']);
		$_se = intval($_GET['_se']);
		
		$class_fs=$_GET['class_fs'];
        $class_fs_=md($_first+$_se);
		if($class_fs_==$class_fs){
						$es=M('forum_class_second')->where("forum_class_first_id=$_first AND first_second_id=$_se")->field('forum_class_second_name ')->find();
						if (!!$es){
							$this->assign('_first',$_first);	
						    $this->assign('_se',$_se);		    
						    $class=D('Forum')->sure_weitie_class($_first,$_se);
						    $this->assign('class',$class);
						     $menut=$this->getAllweishe_classlist();
					        $this->assign('menut',$menut);
						    
						    
							import("ORG.Util.Page");               //这是对微贴分页
				       		 $number = D('Forum')->get_wt_class_Number($_first,$_se);
				        		$page = new Page($number,35);
				       		    $content=D('Forum')->get_wt_class_list($_first,$_se,$page->firstRow,$page->listRows);       
				    			$show = $page->show();
				    			$this->assign('page',$show);
					  		  $this->assign('content',$content);	       
					          $this->display();
						
						}else{
							$this->assign('waitSecond',3);
	    					$this->error('哦，亲目前窝窝园还没有开放此模块呢！！我们会尽快努力的');		
						}
		}else{	
			$this->assign('waitSecond',3);
    		$this->error('哦，亲,你所请求的页面不存在或者已被删除!');		
		}
		
 }
        
        

	public function wt_me(){	
		
		$t_y_p=$_GET['t_y_p'];
	   			 if($t_y_p=='pt_me'){			
		    			$this->assign('t_y_p',$t_y_p);	 
		          		 $menut=$this->getAllweishe_classlist();
	             		 $this->assign('menut',$menut);
	              		 import("ORG.Util.Page"); 
		           
       				     $number = D('Forum')->get_i_join_Number();
        			     $page = new Page($number,35);
       			     	$content=D('Forum')->get_pt_me_list($page->firstRow,$page->listRows);    
  
    		        	$show = $page->show();
    		        	$this->assign('page',$show);      
	  	
	  				    $this->assign('content',$content);	      
	      		        $this->display();
		
			      }  else if($t_y_p=='comment_me'){
					
					$this->assign('t_y_p',$t_y_p);	 
		            $menut=$this->getAllweishe_classlist();
	                $this->assign('menut',$menut);
	                import("ORG.Util.Page"); 
              
       		        $number = D('Forum')->get_comment_me_Number();
        	        $page = new Page($number,35);
        	
        	
       		        $content=D('Forum')->get_comment_me_list($page->firstRow,$page->listRows);  
       		        /*
						 -----------------这儿还应该有清除notifly 表中的 通知信息--------------
						 */
						 $t=$this->uid;    		
    					//	规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；5为 @    				 	
							 if( 0!=M('notify')->where("receive= $t AND is_read=0 AND type= 2")->count()){
							     //清除通知
	    					    M('notify')->data(array('is_read'=>1))->where("receive= $t AND is_read=0 AND type= 2")->save();    	
							 }					   					
    			    $show = $page->show();
    			    $this->assign('page',$show);      
	  		       $this->assign('content',$content);	      
	               $this->display();
		
		         }else if($t_y_p=='my') {				
					$this->assign('t_y_p',$t_y_p);	 
		            $menut=$this->getAllweishe_classlist();
	                $this->assign('menut',$menut);
	                import("ORG.Util.Page"); 
		   
       		        $number = D('Forum')->get_wt_me_Number($this->uid);
        	        $page = new Page($number,35);
       	         	$content=D('Forum')->get_wt_me_list($this->uid,$page->firstRow,$page->listRows);       
    		     	$show = $page->show();
    		    	$this->assign('page',$show);
       
	  		        // dump($content);
	  		        $this->assign('content',$content);	      
	                $this->display();
		      }else{
		          $this->assign('waitSecond',3);
    		      $this->error('你请求的页面不存在或者已被删除!');		      
		      }		
 }
	
	
	

        
	function getAllweishe_classlist(){   //获得微社所有微区的列表
   				$i = 0;
   				$menu = array();
   	
   
   				$first   = D()->query('SELECT forum_class_first_name,forum_class_first_id FROM wo_forum_class_first');
   				$second  = D()->query('SELECT forum_class_second_name,forum_class_first_id FROM  wo_forum_class_second'); 
  				foreach ($first as $key =>$value ){
 				foreach ($second as $keys => $values){
 						if($value['forum_class_first_id'] ==$values['forum_class_first_id']){
 						$menu[$value['forum_class_first_name']][$i++] = $values['forum_class_second_name'];
 						}
 				else $i=0;
 					}
 	
 				}
		   return $menu;
}




	public function rank_teacher(){	
	 $_first=intval( $_GET['_first']);
		$_se = intval($_GET['_se']);
		$p = intval($_GET['p']);

		$class_fs=$_GET['class_fs'];
        $class_fs_=md($_first+$_se);
		
        if($class_fs_==$class_fs){
							$this->assign('_first',$_first);	
						    $this->assign('_se',$_se);
						    
						    $class=D('Forum')->sure_weitie_class($_first,$_se);
						    $this->assign('class',$class);		
						     $menut=$this->getAllweishe_classlist();
					        $this->assign('menut',$menut);
				
					        import("ORG.Util.Page"); 
					        $number = M('teacher')->count();     
					        $page = new Page($number,33);	        	        
					        $data=D('Forum')->getAll_teacher($p,$page->firstRow,$page->listRows);
				
					        $show = $page->show();
				    	    $this->assign('page',$show);
					        $this->assign('data',$data);
				        	$this->display();
		}
		else{	
						    $this->assign('waitSecond',3);
				    		$this->error('哦，亲你所请求的页面不存在，或者已被删除!');		
		}

}
		



   function put_teacher(){     // 这是为老师创建席位
      $name=  strip_tags(h(t(trim($_POST['teacher_name']))));
      $xuyuan= strip_tags(h(t(trim($_POST['teacher_xueyuan']))));       
        if(mb_strlen($name,'utf8')>10||mb_strlen($xuyuan,'utf8')>15){  //限制发表内容多长度，默认1000千字
		 	 echo 3;
		 }else {  
          return $this->do_put_teacher($name,$xuyuan);  
		 }    
   }



   
   	
		
	
	function do_put_teacher($name,$xuyuan){     //为老师创建席位
			
		$map['teacher_name']  = $name;
		$mapt['teacher_name']  = $name."老师";
		$mapj['teacher_name']  = $name."教授";
		if ((0 == M('teacher')->where($map)->count())&&(0 == M('teacher')->where($mapt)->count())&&(0 == M('teacher')->where($mapj)->count())){
			$data=array(
			'teacher_name'=>$name,
			'xueyuan'=>$xuyuan
			);
			$return=M('teacher')->data($data)->add();
			if($return){
			 $id = M('teacher')->query("SELECT LAST_INSERT_ID()");
			    $t=$id[0]['LAST_INSERT_ID()'];
			    echo $t;  
			}else{
				echo "1";
			}
		}else {
			echo "2";
		}
	}
	
   function vote_teacher(){
   
        $_first=intval( $_GET['_first']);
		$_se = intval($_GET['_se']);
		$_teacher = intval($_GET['_teacher']);
		$p = intval($_GET['p']);
		if($_first==4&&$_se==1&& is_numeric($_teacher)){
    
		    $class=D('Forum')->sure_weitie_class($_first,$_se);
		    $this->assign('class',$class);		
		     $menut=$this->getAllweishe_classlist();
	        $this->assign('menut',$menut);

	        import("ORG.Util.Page"); 
	        	        	   	        
	        $teacher_Info = D('Forum')->teacher_Info($_teacher);
    	if($teacher_Info){

    	       $this->assign('teacher_Info',$teacher_Info);  //这是每一位老师的信息

    	       import("ORG.Util.Page");               //这是对评论分页
               $number = M('teacher_comment')->where("teacher_id=$_teacher")->count();
               $page = new Page($number,12);
               $data = D ('Forum')->get_teacher_comment_List($p,$_teacher,$page->firstRow,$page->listRows);	       	  
	        $show = $page->show();
    	    $this->assign('page',$show);
	        $this->assign('data',$data);
        	$this->display();
		}
		else{	
		    $this->assign('waitSecond',3);
    		$this->error('你请求的页面不存在或者已被删除!');		
		}
    }else{	
		    $this->assign('waitSecond',3);
    		$this->error('你请求的页面不存在或者已被删除!');		
    }
}
   
   
   
   
   
   
   
   function do_vote_teacher(){           // 为老师投每一票
    $id=intval($_POST['id']);
    $content=h(trim($_POST['content']));   
      if(mb_strlen($content,'utf8')>1000){  //限制发表内容多长度，默认1000千字
		 	             echo 1;
		 }
		 else{
	              $flag =  D('Forum')->do_vote_teacher($id,$content);	
							       if (!!$flag){
							       	// 成功	 
										       	echo 2;
					                  }else {	
					                  	// 失败				                  	
					                  	echo 3;					    		      
					              }
		 }
      
}
   
   
   
   
   
   function dele_teacher(){
         $teacher_id= intval($_POST['teacher_id']);
		 $for_d=D('Forum')->dele_teacher($teacher_id);
	    return $for_d;
   }
   
  
   function deleted_teacher_comment(){     //删除评论
		$comment_id= intval($_POST['comment_id']);
		 $for_d=D('Forum')->deleted_teacher_comment($comment_id);
	    return $for_d;
	}

   


	public function rank_fans(){
		
        $_first=intval( $_GET['_first']);
		$_se = intval($_GET['_se']);
		$p = intval($_GET['p']);

		$class_fs=$_GET['class_fs'];
        $class_fs_=md($_first+$_se);
		
        if($class_fs_==$class_fs){
			    
					    $class=D('Forum')->sure_weitie_class($_first,$_se);
					    $this->assign('class',$class);		
					     $menut=$this->getAllweishe_classlist();
				        $this->assign('menut',$menut);
			
				        import("ORG.Util.Page"); 
			             $user_op=$this->uid;
			             $this->assign('uid',$this->uid);
			       	     $number = M('user')->where("is_set_avatar=1")->count();       	     
			       	     $is_admin=M('user')->where('user_id='.$user_op)->field('isAdmin')->find();   
			       	         	          	     
			       	     if($is_admin['isAdmin']==1){
			       	         $page = new Page($number,33);
			       	     }
			     	     else {
			       	     		if ($number>100){       //只对一般用户显示一百条信息
			       	    	           $page = new Page(100,33);
			       	   		    }else {
			       	                  $page = new Page($number,33);
			       	            }  
			    	     }       	          	     
				        $data=D('user')->getAll_user_detail($p,$page->firstRow,$page->listRows);
				        $show = $page->show();
			    	    $this->assign('page',$show);
				        $this->assign('data',$data);
				          
				        $my_follower =M('user')->where('user_id='.$user_op)->field('follower')->find(); 
			            $this->assign('my_follower',$my_follower['follower']);
				        
			        	$this->display();
		}
		else{	
		    $this->assign('waitSecond',3);
    		$this->error('哦，亲你所请求的页面不存在，或者已被删除!');		
		}
		
		
	}


	
	
    public function wt_publish(){

    	$wt_id = intval($_GET['_t_y']);   	    	
    	$_first=intval( $_GET['_first']);
		$_se = intval($_GET['_se']);
        if(!!$wt_id){
              $x_id =$_GET['x_id'];
        	  $x_id_=md($wt_id);
        	  if($x_id==$x_id_){			        	
				    		 $_first=M('weitie')->where('weitie_id='.$wt_id)->field('forum_class_first')->find();  			   	
				    		 $_se=M('weitie')->where('weitie_id='.$wt_id)->field('forum_class_second')->find();
				    			   	
				    		$wt_Info = D('Forum')->getEvery_wt($wt_id);
				    		
				    		if($wt_Info){
				    			   if($wt_Info[0]['user_id']==$this->uid){     //如果宝贝主人不是当前登录用户，则没有权限修改该宝贝的信息
				    			     $this->assign('every',$wt_Info);          //这是强大的防盗啊。哈哈哈
				    		         
				    			     $this->assign('_first',$_first['forum_class_first']);	
						             $this->assign('_se',$_se['forum_class_second']);
				    			     $this->display();
				    			   }
				    			   else{
											$this->assign('waitSecond',3);
											$this->error('哦，亲你无权更改此篇微贴，如果你对此微贴的内容有质疑，请联系微贴主人');		
									}
				    		
				    		}else {

									$this->assign('waitSecond',3);
									$this->error('哦，亲目前窝窝园还没有开放此模块呢！！我们会尽快努力的');		
						    }
				    		
        	   }else{        	   
        	        $this->assign('waitSecond',3);
					$this->error('哦，亲,你请求的页面不存在或者已被删除！');	     	   
        	   }
    	}else {
    		
    		   $f_s =$_GET['f_s'];
        	   $f_s_=md($_first+$_se);
        	  if($f_s==$f_s_){
    	                $this->assign('_first',$_first);	
		                $this->assign('_se',$_se);
				    
				        $es=M('forum_class_second')->where("forum_class_first_id=$_first AND first_second_id=$_se")->field('forum_class_second_name ')->find();
						if (!!$es){  
				                $class=D('Forum')->sure_weitie_class($_first,$_se);
				                $this->assign('class',$class);
		    	                $this->display();
						}else{
							$this->assign('waitSecond',3);
							$this->error('哦，亲目前窝窝园还没有开放此模块呢！！我们会尽快努力的');		
						}
        	  }else{
        	  
        	       $this->assign('waitSecond',3);
					$this->error('哦，亲,你请求的页面不存在或者已被删除！');	
        	  
        	  
        	  }
    	}

	}




    function ewt_display(){

        $wt_id = intval($_GET['s_t_y']);
         $w_t = $_GET['w_t']; 
		 $w_=md($wt_id);
		 if($w_t==$w_){    
				    	if(empty($wt_id))
				    	{
				    		$this->assign('waitSecond',3);
				    		$this->error('参数错误!');
				    	}else{
						    	// 从数据库中查出该id的数据信息
						    	$wt_Info = D('Forum')->getEvery_wt($wt_id);
						    	if($wt_Info){
								    	$this->assign('every',$wt_Info);  //这是每一天微贴的信息
								
								    	   import("ORG.Util.Page");               //这是对评论分页
								        $number = D('Forum')->get_wt_comment_Number($wt_id);
								        $page = new Page($number,10);
								        $data = D ( 'Forum')->getweitie_comment_List($wt_id,$page->firstRow,$page->listRows);
								    	$show = $page->show();
								    	$this->assign('page',$show);
								         //	dump($data);
									   $this->assign ("data",$data );   //这是该条微贴的评论信息
								    	 $mid=$this->uid;
										$this->assign("mid",$mid);
										//统计阅读次数
										D()->execute('UPDATE wo_weitie SET read_times = read_times +1 WHERE weitie_id = '.$wt_id);
										
								        //   如果是这么帖子的主人浏览该贴，清除，WO_weitie表中的  last_comment_is_read ,表示已读
								        
										 $weitie_user_id=M('weitie')->where('weitie_id='.$wt_id)->field('user_id')->find();
										 if( $this->uid==$weitie_user_id['user_id']){
										     M('weitie')->data(array('last_comment_is_read'=>0))->where('weitie_id='.$wt_id)->save();
										 }   

										 
						    	$this->display();
						    	}else {
						    		$this->assign('waitSecond',3);
						    		$this->error('参数错误!');
						
						    	}
				    }
				}else{
							$this->assign('waitSecond',3);
				    		$this->error('你请求的页面不存在!');
				
				}
    }



     function do_wt_publish(){

     	$p_weitie_id= $_POST['p_weitie_id'];

     	if ($p_weitie_id){   //修改微贴信息
     		      $title	= trim($_POST['title']);
     		      $content= trim($_POST['content']);

                  if(mb_strlen($title,'utf8')>64){    //限制发表内容多长度，默认为30
		 	             $this->assign('waitSecond',3);
    		             $this->error('标题很长很长很长很长...^_^，简短些吧！');
		            }
                 else  if(mb_strlen($content,'utf8')>10000){  //限制发表内容多长度，默认10000千字
		 	             $this->assign('waitSecond',3);
    		             $this->error('发这么多内容干啥^_^，不能超过10000千字。');

		           }
		           
     	   			 else 		{

				     			   $data = array(
								   'title'=>$title,
								   'content'=>$content,
							       'iscomment'=>$_POST['iscomment']  			   
							       //  'is_photo'=>1,
							        );
							        
							        	       //判断是否有图片和附件
							   
							    if(preg_match('/<img(.[^<]*)src=\"?(.[^<\"]*)\"?(.[^<]*)\/?>/is', $content)){
							     	$data['is_photo'] = 1;
							      }
							      else $data['is_photo'] = 0;
							        
				
						  	        $flag=M('weitie')->data($data)->where("weitie_id= $p_weitie_id")->save();
						            if ($flag){
						       	        $this->redirect("Forum/ewt_display/s_t_y/".$p_weitie_id."/w_t/".md($p_weitie_id));
				                        }else {
				    		                 $this->assign('waitSecond',3);
				    		                 $this->error('参数错误!,发布失败！请检测信息是否填写完整。');
				                        }
     	    		}

		  	}else{

		  	        $title	= trim($_POST['title']);
     		        $content= trim($_POST['content']);

                    if(mb_strlen($title,'utf8')>64){    //限制发表内容多长度，默认为30
		        	       $this->assign('waitSecond',3);
    	        	       $this->error('标题很长很长很长很长...^_^，简短些吧！');
		            }
                   else if(mb_strlen($content,'utf8')>10000){  //限制发表内容多长度，默认为10000千字
		 	               $this->assign('waitSecond',3);
    		               $this->error('发这么多内容干啥^_^，不能超过10000千字。');

		 			 }
		 			else { 
					 			 $data = array(
									'user_id'=>$this->uid,
									'title'=>$title,
									'content'=>$content,
						   			 'forum_class_first'=>$_POST['w_class_first'],
									'forum_class_second'=>$_POST['w_class_second'],
						  			  'iscomment'=>$_POST['iscomment'],
						 		  //  'is_photo'=>1,
						 		    'ctime'=> time()
									);
									
									
					  	    	       //判断是否有图片和附件
					  	    	       
						   //dump($content);
						    if(preg_match('/<img(.[^<]*)src=\"?(.[^<\"]*)\"?(.[^<]*)\/?>/is', $content)){
						     	$data['is_photo'] = 1;
						      }
						      else $data['is_photo'] = 0;
									
					  			   $flag=M('weitie')->add($data);//发表新微贴
					      		 if ($flag){
					       				   $id = $this->allModel->query("SELECT LAST_INSERT_ID()");
					       				   $p_id = $id[0]['LAST_INSERT_ID()'];
			                			   $this->redirect("Forum/ewt_display/s_t_y/".$p_id."/w_t/".md($p_id));
			                         }else {
			    		                 $this->assign('waitSecond',3);
			    		              $this->error('参数错误!,发布失败！请检测信息是否填写完整。');
			                     }
		  	}
		  	}
}




	//发布微贴的评论
	function do_wt_comment_publish(){

		$weitie_id=intval($_POST['weitie_id']);		
		$weitie_user_id=M('weitie')->where("weitie_id = $weitie_id")->field('user_id')->find();
        $weitie_user_id=$weitie_user_id['user_id'];
		$content= trim($_POST['content']);
	    $recomment_id=intval($_POST['comment_id']);
	    $mid=$this->uid;
	    $us;    //定义一个全局变量  被评论的评论的user_id
	    if(mb_strlen($content,'utf8')>1000){  //限制发表内容多长度，默认1000千字
		 	             echo 1;
		 }
		 else{
              if(!!intval($recomment_id)){    //这是回复已有的评论，这只是通知改评论的主人，而不用在去通知改改评论所属weitie的主人					         	
		         	$recomment_id_user_id=M('weitie_comment')->where("comment_id = $recomment_id")->field('user_id')->find();
                    $us=$recomment_id_user_id['user_id'];
							$data	= array(
									'weitie_id'		=>$weitie_id,
									'user_id'		=>$this->uid,
				                    'weitie_user_id'	=>$weitie_user_id,								
									'content'	    => $content,
							        'recomment_id'  =>$recomment_id,
                                    'recomment_id_user_id'=>$us,
									'ctime'		=> time(),
								);
								
              $flag=M('weitie_comment')->add($data);//发表新评论
				 if ($flag){	
				 	//更新评论次数：+1	
				 	   D()->execute('UPDATE wo_weitie SET count_comment = count_comment +1 WHERE weitie_id = '.$weitie_id);
				 	 //
				 	 if($weitie_user_id==$mid){
				 	    M('weitie')->data(array('last_comment_user_id'=>$mid))->where("weitie_id=$weitie_id")->save();	 
				 	 }else{			
					   M('weitie')->data(array('last_comment_user_id'=>$mid,'last_comment_is_read'=>1))->where("weitie_id=$weitie_id")->save();
				 	 }
				 	 //  dump(M('weitie'));
					
										       
					// 在微社版块  通知帖子 主人  有新信息   如果是 帖子的主人自己评论自己的 就不通知	       	 
						 if( ($this->uid!=$weitie_user_id)&&!!empty($recomment_id)){		      	   
							 // 通知贴子的主人  有新回复													     
							 A('Notify')->send( $u, $weitie_user_id,2 ); //规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；
								}										        										        					
								 //如果是评论已有的评论，就通知这条评论的主人
									 if (!empty($recomment_id)){
										if( $u!=$us){		      	   
											    // 通知这条评论的主人  有新回复
											   A('Notify')->send( $u, $us,2 ); //规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；
									     } 		       	        
									 }										        										      
									echo 2;
					         }else {					                  	
					     	echo 3;					    		      
					              }			
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
			   }else{
						     $data	= array(
									'weitie_id'		=>$weitie_id,
						            'weitie_user_id'	=>$weitie_user_id,	
									'user_id'		=> $this->uid,
									'content'	=> $content,
									'ctime'		=> time()
								);			  			  
			      }
					
				$flag=M('weitie_comment')->add($data);//发表新评论
				  if ($flag){
					  $u=$this->uid;							
					   M('weitie')->data(array('last_comment_user_id'=>$u,'last_comment_is_read'=>1))->where("weitie_id=$weitie_id")->save();
                        //  dump(M('weitie'));
					D()->execute('UPDATE wo_weitie SET count_comment = count_comment +1 WHERE weitie_id = '.$weitie_id);
										       
					// 在微社版块  通知帖子 主人  有新信息   如果是 帖子的主人自己评论自己的 就不通知	       	 
						 if( ($this->uid!=$weitie_user_id)&&!!empty($recomment_id)){		      	   
							 // 通知贴子的主人  有新回复													     
							 A('Notify')->send( $u, $weitie_user_id,2 ); //规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；
								}										        										        					
								 //如果是评论已有的评论，就通知这条评论的主人
									 if (!empty($recomment_id)){
										if( $u!=$us){		      	   
											    // 通知这条评论的主人  有新回复
											   A('Notify')->send( $u, $us,2 ); //规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；
									     } 		       	        
									 }										        										      
									echo 2;
					         }else {					                  	
					     	echo 3;					    		      
					              }

		 }

	}


	function deletedcomment(){     //删除评论
		$comment_id= intval($_POST['comment_id']);
		$weitie_id= intval($_POST['weitie_id']);
		 $for_d=D('Forum')->deletedcomment($comment_id,$weitie_id);
	    return $for_d;
	}


	function deletedweitie(){
	    $weitie_id= intval($_POST['weitie_id']);     //删除微贴
		 $for_d=D('Forum')->deletedweitie($weitie_id);
	     return $for_d;
	}


	function put(){             //推荐为精华

		//$weiite_id          = $_SESSION['put_weitie_id'];
	    //$user_id          = $_SESSION['put_user_id'];
	    $weitie_id= intval($_POST['weitie_id']);

      if ($_SESSION['put_weitie_id']!=$weitie_id){

         	Session::set('put_weitie_id',$weitie_id);
         	$for_d=D('Forum')->put($weitie_id);
         	if($for_d){
         	  echo '2';            //成功
         	}else {
         	   echo '3';   //失败 稍后再试
         	}
         }

	    else {
	         echo '1';   //不能重复推荐
	    }


	}

   public function preg(){
   	      $preg = "<img src='' >";
   	      $id = preg_match("/<img(.[^<]*)src=\"?(.[^<\"]*)\"?(.[^<]*)\/?>/is", $preg);
   	      echo $id;
   	 
   	
   	
   }














}