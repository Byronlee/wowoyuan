<?php
class SpaceAction extends CommonAction{

		
	function index(){
		 $uid = intval($_GET['uid']);
		 $uid_ = $_GET['ui_'];
		$type = ($_GET['type']=='weitie')?'weitie':'flash';  
		 $mid=$this->uid;	 
		 $ui=$uid*3762-37;
	      $ui_=md5($ui);
		 if($ui_==$uid_){
				 	 import("ORG.Util.Page");
						 if (($mid!=$uid)&&($_COOKIE['visited_id']!=$uid)){						 	
						 	cookie("visited_id",$uid);//::set('visited_id',$uid);							 						 		 	
						 	$data = array(
										'user_id'=>$this->uid,
										'visited_id'=>$uid,			
							 		    'ctime' => time()
										);											
						     M('space_visit')->add($data);
						 }						 
						 if($mid==$uid){				 	
						 	 $guest=M('space_visit')->where("visited_id=$mid")->order('ctime DESC')->group("user_id")->limit('15')->findAll();
						     $this->assign('guest',$guest);						 	
						 }
					    
					    $user_detail_info = D('Public')->getUserInfo($uid,$this->uid);
					    $this->assign('user_detail_info',$user_detail_info[0]);	
						$this->assign('type',$type);
						
						$this->assign("user_id",$uid);  //前台判断当前浏览的页面 的用户是不是登录用户
						$this->assign("m_id",$mid);
						$this->assign("uvatar",uvatar);
						$this->assign("uname",uname);
						
						if($type=="flash"){
						$number = D()->query("SELECT count(*) FROM wo_flash WHERE user_id=$uid");			
			            $page = new Page($number[0]["count(*)"],40);				
						$data  = D('flash')->getspace_indexList($uid,$type,$page->firstRow, $page->listRows);
						$this->setTitle ( getUserName($uid)."--空间" );
						
						}else{
							$number = D()->query("SELECT count(*) FROM wo_weitie WHERE user_id=$uid");			
				            $page = new Page($number[0]["count(*)"],50);					
							$data  = D('flash')->getspace_indexList($uid,$type,$page->firstRow, $page->listRows);
						
						$this->setTitle (getUserName($uid)."--微贴" );
						}
						 $show  = $page->show();
						$this->assign ('page',$show);
						$this->assign('data',$data);
						$this->display();
	}else{
		 $this->assign('waitSecond',3);
         $this->error('亲，你请求的页面不存在!'); 
	}
	
}


	function follow(){
	 $uid = intval($_GET['uid']);
		 $uid_ = $_GET['ui_'];
		$type = ($_GET['type']=='following')?'following':'follower';  
		 $mid=$this->uid;	 
		 $ui=$uid*3762-37;
	      $ui_=md5($ui);
		 if($ui_==$uid_){
				 	 import("ORG.Util.Page");
						 if (($mid!=$uid)&&($_COOKIE['visited_id']!=$uid)){						 	
						 	cookie("visited_id",$uid);//::set('visited_id',$uid);							 						 		 	
						 	$data = array(
										'user_id'=>$this->uid,
										'visited_id'=>$uid,			
							 		    'ctime' => time()
										);											
						     M('space_visit')->add($data);
						 }						 
						 if($mid==$uid){				 	
						 	 $guest=M('space_visit')->where("visited_id=$mid")->order('ctime DESC')->group("user_id")->limit('15')->findAll();
						     $this->assign('guest',$guest);						 	
							 if( 0!=M('notify')->where("receive= $mid AND is_read=0 AND type= 4")->count()){
							     //清除通知							
	    		
	    					   //	规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；5为 @
	    					    M('notify')->data(array('is_read'=>1))->where("receive= $mid AND is_read=0 AND type= 4")->save();    	
							 }
						 
						 }
					    
					    $user_detail_info = D('Public')->getUserInfo($uid,$this->uid);
					    $this->assign('user_detail_info',$user_detail_info[0]);	
						$this->assign('type',$type);
						
						$this->assign("user_id",$uid);  //前台判断当前浏览的页面 的用户是不是登录用户
						$this->assign("m_id",$mid);
						$this->assign("uvatar",uvatar);
						$this->assign("uname",uname);
						
						if($type=="follower"){
						$number = D()->query("SELECT count(*) FROM wo_user_follow WHERE fid=$uid");			
			            $page = new Page($number[0]["count(*)"],40);				
						 $list = D('Follow')->getList($uid,$type,$page->firstRow, $page->listRows);
						$this->setTitle ( getUserName($uid)."--粉丝" );
						
						}else{
							$number = D()->query("SELECT count(*) FROM wo_user_follow WHERE uid=$uid");			
				            $page = new Page($number[0]["count(*)"],50);					
							$list = D('Follow')->getList($uid,$type,$page->firstRow, $page->listRows);
						
						$this->setTitle (getUserName($uid)."--关注" );
						}
						 $show  = $page->show();
						$this->assign ('page',$show);
						$this->assign('list',$list);
						$this->display();
	}else{
		 $this->assign('waitSecond',3);
         $this->error('亲，你请求的页面不存在!'); 
	}
}
	
	

	
	
	
	
	
	
}



?>