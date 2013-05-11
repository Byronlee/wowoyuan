
<?php

class IndexAction extends CommonAction
{
    
     public function index(){
     // echo '<script type="text/javascript">window.location.href="'.SITE_URL.'/'.$my['username'].'"</script>';
       header('location:'.SITE_URL.'url=home');
    }
    

    public function home(){	   	   	
    	
    	$data_all = D ( 'Flash')->get_allHomeList();     //  echo 'data变量:';dump($data);
		$this->assign ("data_all",$data_all );
		$data_friend = D ( 'Flash')->get_friendHomeList();     //  echo 'data变量:';dump($data);
		$this->assign ("data_friend",$data_friend );
		$data_me = D ( 'Flash')->get_meHomeList();     //  echo 'data变量:';dump($data);
		$this->assign ("data_me",$data_me );
		
		$data_user= M('user')->limit('7')->order('user_id desc')->where("is_set_avatar=1")->findAll();
		$this->assign("data_user",$data_user);
		
		$all_wt= M('weitie')->limit('18')->order('weitie_id desc')->findAll();
		$this->assign("all_wt",$all_wt);
		
	    $all_comment=D('Forum')->home_new_comment();
		$this->assign("all_comment",$all_comment);
		
		$spacial_wt=M('weitie')->limit('18')->order('put desc')->findAll();
		$this->assign("spacial_wt",$spacial_wt);
		
		$hot_activit=M('weitie')->limit('18')->where("forum_class_first=3 or (forum_class_first=2 AND forum_class_second=3)")->order('weitie_id desc')->findAll();
		$this->assign("hot_activit",$hot_activit);
		
		$new_goods=M('shelve')->limit('20')->where("is_Sale=2")->order('goods_id desc')->findAll();
		$this->assign("new_goods",$new_goods);
		
		$this->setTitle("窝窝园");
		$this->display ();
    }

    
    
    function s_result(){      //分类搜素结果

		import("ORG.Util.Page");	
		$tag=$_POST['tag']; 
		if(!!empty($tag)){
			$tag=1;
		}
		$keywords =strip_tags(h(t(trim($_POST['key']))));		
		if($tag==1){
		           if($keywords==""){
				        $this->assign('k',$keywords);
				        $this->display('search');
				        	
				  }else if(mb_strlen($keywords,'utf8')>20){
		        	$this->assign('waitSecond',3);
		    		$this->error('请缩短关键字的长度，尽量用常用字，简洁。可用空格将多个关键字分开！');
		        }else{	 
				        $n_flash = $this->computer('wo_flash','flash_body',$keywords);
				       	$this->assign('n_flash',$n_flash);
				       	$this->assign('tag_flash',2);
				       	
				      	$n_user = $this->computer('wo_user','username',$keywords);
				      	$this->assign('n_user',$n_user);
				      	$this->assign('tag_user',3);
				      	
				      	$n_shelve = $this->computer('wo_shelve','goods_name',$keywords);
				      	$this->assign('n_shelve',$n_shelve); 
				      	$this->assign('tag_shelve',4);
				      	
				      	$n_weitie = $this->computer('wo_weitie','title',$keywords); 
				      	$this->assign('n_weitie',$n_weitie);	
				      	$this->assign('tag_weitie',5);	
				      						        	   
				        $this->assign('k',$keywords);

				        $this->display('search');
		    }
			
			
		}else {
				        if($keywords==""){
				        	$this->assign('k',$keywords);
				            $this->display('search');
				        } else if(mb_strlen($keywords,'utf8')>20){
				        	$this->assign('waitSecond',3);
				    		$this->error('请缩短关键字的长度，尽量用常用字，简洁。可用空格将多个关键字分开！');
				        }else{	
				        	// tag的值  2 闪存 3用户 4 商场 5微贴
				
						        if($tag!=2&&$tag!=3&&$tag!=4&&$tag!=5){
										      	  $this->assign('waitSecond',3);
						    		              $this->error('网络繁忙，请稍后再试！');
									}else{
										    if ($tag==2){
										         $number = $this->computer('wo_flash','flash_body',$keywords);
										    	 $page = new Page($number, 40);
										       	 $result =  $result['flash'] = $this->search_flash($keywords,$page->firstRow,$page->listRows);
										       	 $this->assign('n_flash',$number);
											     $this->assign('kind_tag',$tag);
										       	 
										       }
										       if ($tag==3){
										      	$number = $this->computer('wo_user','username',$keywords);
										    	$page = new Page($number, 30);
										      	$result = $result['user'] = $this->search_user($keywords,$page->firstRow,$page->listRows);
										    	$this->assign('n_user',$number);
										      	$this->assign('kind_tag',$tag);
										       }
										      if($tag==4){
										      	$number = $this->computer('wo_shelve','goods_name',$keywords);
										    	$page = new Page($number, 40);
										        $result = $result['trade'] = $this->search_trade($keywords,$page->firstRow,$page->listRows);
										      	$this->assign('n_shelve',$number);
										      	$this->assign('kind_tag',$tag);						      	
										      }
										      if($tag==5){
										      	$number = $this->computer('wo_weitie','title',$keywords);
										    	$page = new Page($number, 50);
										      	$result = $result['weitie'] = $this->search_weitie($keywords,$page->firstRow,$page->listRows);
										      	$this->assign('n_weitie',$number);
										      	$this->assign('kind_tag',$tag);
										      }
										      
										      $this->assign('data',$result);
										       $show = $page->show();
										        $this->assign('page',$show);
										        $this->assign('tag',$tag);
										        $this->assign('k',$keywords);		      
									}
				        }				      
						 $this->display();
		}
    }
    
    
    
    
    // 搜索闪存
    public function search_flash($keywords,$firstRow,$listRows){
    	 
    	 $flash = D()->query('SELECT * FROM wo_flash WHERE flash_body LIKE \'%'.$keywords.'%\' LIMIT '.$firstRow.','.$listRows);
    	   foreach ($flash as $k =>$value){            
                  $flash[$k]['operate']=D('Flash')->operate_flash($flash[$k]['user_id'],$flash[$k]['flash_id'],$this->uid);     	
              }  
    	 
    	 return $flash;
    }
    // 搜索用户
    public function search_user($keywords,$firstRow,$listRows){
    	$user = D()->query('SELECT * FROM wo_user WHERE username LIKE \'%'.$keywords.'%\' LIMIT '.$firstRow.','.$listRows);   	

    	foreach ($user  as $k=>$v){				
    		$user_id=$user[$k]['user_id'];
			$user[$k]['following'] = M('user_follow')->where('uid='.$user_id)->count();		
			$user[$k]['follower']  = M('user_follow')->where('fid='.$user_id)->count();
			$user[$k]['flashs']=M('flash')->where('user_id='.$user_id)->count();
			$user[$k]['weities']=M('weitie')->where('user_id='.$user_id)->count();
			$user[$k]['followState']  = D('Follow')->getState($this->uid,$user_id);				
		}  	
    	return $user;
    }
    // 搜索商城
    public function search_trade($keywords,$firstRow,$listRows){
    	$trade = D()->query('SELECT * FROM wo_shelve WHERE goods_name LIKE \'%'.$keywords.'%\' LIMIT '.$firstRow.','.$listRows);
    	return $trade;
    }
    // 搜索微贴
    public function search_weitie($keywords,$firstRow,$listRows){
    	$weitie = D()->query('SELECT * FROM wo_weitie WHERE title LIKE \'%'.$keywords.'%\' LIMIT '.$firstRow.','.$listRows);
    	return $weitie;
    }
   
    /**
     * 计算满足条件的搜索结果总数
     * @param $table 数据库表
     * @param $field 数据库字段
     * @param $keywords 查询关键字
     * @return int
     * 
     */
    public function computer($table,$field,$keywords){
    	$number = D()->query('SELECT * FROM '.$table.' WHERE '.$field.' LIKE \'%'.$keywords.'%\'');
    	return count($number);
    	
    }
    
    public function avatar(){
    	$iModel = D('Index');
    	$iModel->uid = $this->uid;
    	// 注意是GET
    	$type =  $_GET['type'];
    	if($type=='upload'){
    		echo $iModel->upload();
    		
    	 }
    	 else if($type=='save'){
    	 	// echo $type;
    	 	 echo $iModel->doSave();
    	 }
    	
    	else {
    		
    		$this->display();
    	}
    	
    }
    
    public function setAvatar(){
    	$this->setTitle('修改头像');
    	$this->display();
    }
    public function setAccount(){
    	$email = D()->query("SELECT mailadres FROM wo_user WHERE user_id = ".$this->uid);
    	$this->assign('email',$email[0]['mailadres']);
    	$this->setTitle('账号设置');
    	$this->display();
    }
    
    public function doSetAccount(){
    	
     	$pas   = md5(md5($_POST["pas"])+md5($this->user[0]['mailadres']));
     	$mopas = md5(md5($_POST["mopas"])+md5($this->user[0]['mailadres']));
     	// 验证初始密码是否正确
        if (!empty($_POST["pas"])){
        	$flag = D()->query("SELECT user_id FROM wo_user WHERE user_id = ".$this->uid." AND password = '".$pas."'");
        }
         // 修改密码
        else if(!empty($_POST["mopas"])){
        	$flag = D()->execute("UPDATE wo_user SET password = '".$mopas."' WHERE user_id = ".$this->uid);
        	
        }
        //dump(D());
        if (!empty($flag)) {
        	echo 1;
        }
        else echo 0;
    }
    
    
    public function information(){
    	$this->setTitle('基本信息');
    	$this->display();
    }
    public function doSaveInformation(){
    	$nickName     = $_POST['nickName'];
    	$qq           = $_POST['qq'];
    	$sex          = $_POST['sex'];
    	$description  = $_POST['description'];
    	$year         = $_POST['year'];
    	$month        = $_POST['month'];
    	$day          = $_POST['day'];
    	$class        = $_POST['class'];
    	$grade        = $_POST['grade'];
    	$profession   = $_POST['profession'];
    	$academy      = $_POST['academy'];
    	$data1 = D()->execute("UPDATE wo_user SET username = '".$nickName."',user_qq = '".$qq."',
    	user_gender = '".$sex."',description = '".$description."',class='".$class."',grade ='".$grade."',
    	profession = '".$profession."',academy = '".$academy."',year = '".$year."',month = '".$month."' ,day = '".$day."' WHERE user_id = ".$this->uid);
    	//$data2 = D()->execute("UPDATE wo_user_statistics SET year = '".$year."',month = '".$month."' ,day = '".$day."' WHERE user_id = ".$this->uid);
    
    	if (isset($data1)||isset($data2)){
    		echo 1;
    	}
    	else echo 0;
    }
    
    // about
    public function about(){
    	$id = $_GET['type'];
    	
    	           $wo['about_wowoyuan']="

                                	窝窝园
									起于2011年6月份，是NOON团队之处女座，因无任何经验与背景，自习而成，虽开发人员激情四射，窸窣而成，但其中定会存在诸多问题，源于时间和人力有限，错误或不妥之处不能完全避之，诚借借大家之力，如有发现，勿扶而笑之，还愿联系我们，我们以便加以改进。使处于雏鸟阶段的窝窝园更加完善。
									在此窝窝园全体开发人员先谢谢你的谅解。我们会在你们的建议更加的努力。你们的支持就是我们不懈努力的动力。再谢。<br />
									窝窝园设计之初，起于学校一年一度的淘宝集会，届时因有大量的可重复利用资源，由学校学生会之前统一收集起来在此活动中大量展出，同学们可以再次购买，然后以便实现资源的可重复利用

									。但如果全靠这几天活动来良好的循环这种可重复利用的状态，效果可能显微。估诞生此想法。把这些东西放在网上。随时随地的都来持续这种良好的可重复利用状态。
									之后在一段实地考察阶段之间发现，
									就目前大三大四的同学来说，他们即将毕业离校，有很多东西，比如学习笔记，电脑，自行车等物品由于多种原因而没有使用，但弃之可惜，因此，他们就可以将之放在这样的

									一个平台上，卖给需要的学弟学妹们，让那些有价值的好宝贝继续造福学弟学妹们。就大一大二的同学的们来说，有一些东西是需要而没有的，有一些物品是我们现在不需要到的，那么

									他（她）也可以放在这样一个平台上，而去寻找自己需要的，卖掉或者换掉自己所不需要的。从而通过这样一个平台，方便同学们寻找自己所需的物品，方便同学们的日常生活。而且，全为本校学生，加强了

									沟通交流。在这里变废为宝。所以有很大的可行性。从而搭建这么一个平台的理念都诞生了，。真正做到低碳生活从身边做起，从一件一件小物品做起。<br />

									在开发的过程中，队友多此策商，为了更进一步的扩大这种效果，加强大学校园内，同学们之间的交流，又扩招了 微社和闪存两个版本。

									关于微社，设计之初，观察到，


									大学是一个小社会，大家庭，所以在每天学校生活中都会产生很多新鲜事，有全校六十多个协会的活动，有各个学院的最新竞赛，有突然找到那学课的详细答案想给同学们分享，

									以及发生在我们身边的那些小小的趣事等等，全校同学之间如果有属于量身为我们打造的交流平台，让全校同学能够有途径去了解身边同学的所思所想所感。真的做到把学校变成

									一个自己了解的家。在这个平台上减少了同学们之间的距离，加强了交流，那么就为自己的大学生活又填了一份精彩的回忆。所以，开发了微社版块，加强了校园文化的继承和传

										播。
									再后来，受新浪微博的强烈影响，它的新闻动态及时，简介，随心所欲。进一步加快了大家了交流，他不同于我们平时所浏览的论坛，没有长篇大论，言简意赅。正是这些不管是微社还是论坛都无法取代的优点，使得微博现在深深的走进人们的生活。但介于微博范围太广，如果有只属于我们大学校园内有的这么一个交流平台，缩小范围，加大交流次数。跟能使我们大学像是一个温馨的大家庭。于是，窝窝园闪存的设计就由此诞生。<br />

									由此窝窝园在不断的考察和策商中孕育而出。<br />
									
									但是现实是残酷的，空有想法和热血没有技术，一切都是空谈，在开发的过程中，有于队员的不固定，没有指导老师给予指导。加之我们每一个人都是零基础，导致开发时间过长，因此设计中定会出现不同的错误，我们一直在努力优化，由于任务繁重，时间紧迫，仓促上线。若发现不妥之处，敬请谅解。愿联系我们，以便我们好我们加以改进 。谢谢！

    	         			        
									
									";
    	           $wo['join_us']="
    	             在开发过程中，感慨颇多，要诞生一个优秀的产品，肯定会有一个很强大和谐的团队。在以后的路上团队就是我们构建高楼的一专
    	             一瓦。都希望在一个好的团队氛围中去营造一个个奇迹。  <br />在这里，虽没有武林高手但都有一番热血，一颗执着的心，
    	             并坚持不懈的走下去。在这过程愿结识更多的志同道合之士并肩而战。壮大力量。由于现在人员力量单薄，所以在开
    	             发的过程中我们也一直在努力的寻找这份志同道合的缘分，  <br />今天，我们照样以赤子之心来邀请各位有志之士，一起来书写未来。
    	           
    	          <br />     如果你是高手，那就不用说了，如果你已经会部分技术当然更好，但如果你不会任何技术，也不要太在意，因为做任何事学习最重要，能力也就无所畏惧了，在斩风破浪时，只要你有一个良好的心态，持之以恒的决心。能力次之。所以我们都可以在一起。
    	             <br />最后NOON 诚愿本校有意向这这请与我们联系。      NOON在这里等着大家。<br />
    	           
    	          相信自己，勇于的迈出第一步。期待我们一起并肩作战。书写成大和自己未来的奇迹。 
    	           ";
    	           $wo['ad']="
    	           
    	             在这里，大家的支持是才是我们走下去的力量。如果你发现什么不妥之处或者有什么好的建议
    	             或者意见，就请大家发建议给我们吧。谢谢你的谅解与合作。
    	           
    	           ";
    	           $this->assign('wo',$wo);
    	$this->display();
    }
    public function upAdvice(){
    	$text = $_POST['text'];
   
    	if(!empty($text)){
    		$data = D('Index')->upAdvise($text,$this->uid);
    	
    		if($data==1){
    			echo 1;
    		}
    		else echo 0;
    	}
    	else echo 0;
    }
    

}


?>