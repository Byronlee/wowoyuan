<?php

class TradeAction extends CommonAction {
	private $info;
    function index() {
    	//  最近上架的商品
    	$this->assign('on_list',D('Shelve')->getNewList('on',5));
    	//  最近卖出的物品
    	$this->assign('off_list',D('Shelve')->getNewList('off',6));	
    	$this->assign('menu',$this->_getMenu());
        $this->display();
    }
    function buy() {
        $data = M('goodsinfom');
        import("@.ORG.Page"); // 引用框架类
        $total = $data->count(); //计算数据库记录个数
        $p = new Page($total, 3);
        $page = $p->show();
        $this->assign("total", $total);
        $this->assign("page", $page); //将page对象分配给前台变量page
        $list = $data->limit($p->firstRow . ',' . $p->listRows)->select();
        $this->assign('list', $list);
        $this->display('buy');
    }
    
    // 展示全部的商品
    function showall(){
    	
    	$first    = intval($_GET['first']);
    	$second   = intval($_GET['second']);
    	$a_d=$_GET['a_d'];   	
    	$a_d_=md($first+$second);
    	if($a_d==$a_d_){
    		
			        if (empty($first)) {			        	
					        $this->assign('waitSecond',3);
					        $this->error('你访问的页面不存在!');   
			        }else{   				    
					        import("ORG.Util.Page");               
					        $number = D('shelve')->getClassNumber($first,$second);
					        $page = new Page($number,30);
					    	$allClass =  D('Shelve')->getClass($first,$second,$page->firstRow,$page->listRows); 	
					    	//  最近上架的商品
					    	$this->assign('on_list',D('Shelve')->getNewList('on',5));
					    	$show = $page->show();
					    	$this->assign('page',$show);
					    	//  最近卖出的物品
					    	$this->assign('off_list',D('Shelve')->getNewList('off',6));
					    	$this->assign('first',$first);
					    	$this->assign('second',$second);
					    	$this->assign('class',$allClass);
					    	$this->assign('menu',$this->_getMenu());
					    	$this->display();
			        }
					    		
    	}else{
    		
    		       $this->assign('waitSecond',3);
			        $this->error('你请求的页面不存在!'); 
    	}
    	
    }
    
    //  每件商品的详细信息
    function detail(){
    	// 商品ID
    	$id = intval($_GET['id']);
    	if(empty($id)) 
    	{
    		$this->assign('waitSecond',3);
			$this->error('此宝贝不存在或者已被删除！');
    	}else{
	    	  $i_=$_GET['i_'];
	    	  $i=md($id);
    	    if($i==$i_){
				    	// 从数据库中查出该id的数据信息
				    	$goodsInfo = D('Shelve')->getEvery($id,1112);
				    	if($goodsInfo){
				    	$this->assign('every',$goodsInfo);
				    	   	
				    	 $mid=$this->uid;
						$this->assign("mid",$mid);
					
				    	$this->display();
				    	}else {
				    		$this->assign('waitSecond',3);
				    		$this->error('此宝贝不存在或者已被删除！');
				    		
				    	}
    	    }else{
    	    	$this->assign('waitSecond',3);
				$this->error('此宝贝不存在或者已被删除！');
    	    }
    	}
		    	
    } 
    function make_trade(){
    	 $goods_id=$_POST['goods_id'];
    	 $host_id=$_POST['host_id'];
	  $make_trade=D('shelve')->make_trade($goods_id,$this->uid,$host_id);
	  return $make_trade;
    	
    }
    // 显示物品物品上架页面
    public function shelve(){
    	
    	$goods_id=$_GET['_t'];
			   	if($goods_id){			    		
				    $x_=$_GET['x_'];
    	            $x=md($goods_id);
    	            if($x==$x_){			    		
				    		$goodsInfo = D('Shelve')->getEvery($goods_id);
				    		if($goodsInfo){			
				    			   if($goodsInfo[0]['user_id']==$this->uid){     //如果宝贝主人不是当前登录用户，则没有权限修改该宝贝的信息   
				    			     $this->assign('every',$goodsInfo);          //这是强大的防盗啊。哈哈哈
				    	             $this->assign('data',D('Shelve')->getNewList('on',9));
				    	             $this->setTitle('修改详情');
				    		         $this->display();
				    			   }
				    			   else{
				    			   	    $this->assign('data',D('Shelve')->getNewList('on',9));
				    			   	    $this->setTitle('窝窝园--上架');
				    	                $this->display();
				    			   }
				    		}else {
				    			
				    			$this->assign('data',D('Shelve')->getNewList('on',9));
				    			$this->setTitle('窝窝园--上架');
				    	        $this->display();
				    		}	   		
				    	}else{
				    			$this->assign('data',D('Shelve')->getNewList('on',9));
				    			$this->setTitle('窝窝园--上架');
				    	        $this->display();
				    		
				    	}
			   	}else {				    	
				    	$this->assign('data',D('Shelve')->getNewList('on',9));
				    	$this->setTitle('窝窝园--上架');
				    	$this->display();
				    	}
				    	
    }
    function preview(){
      if (!empty($_FILES)){	
      	if ($this->upLoad()){
      		echo '<body><script type="text/javascript">{parent.preview("'.$this->info[0]["savename"].'")}</script></body>';
      		$flag =$this->allModel->execute('INSERT wo_goods_img(img_name,ctime) VALUES(\''.$this->info[0]["savename"].'\','.time().')');
      		if ($flag==1){
      			// 查询出图片的ID
      			$temp = $this->allModel->query('SELECT img_id FROM wo_goods_img WHERE img_name=\''.$this->info[0]["savename"].'\'');
      			// 保存到session中      			
      			if(!empty($temp)) Session::set('img_id',$temp[0]['img_id']);
      		}
      		else{
      		   echo '<body onload="error()"><script type="text/javascript">function error(){parent.error("数据插入数据库时出错!")}</script></body>';
      		}      		     		
      	}
      	// 上传失败,输出错误信息    	
      	//目前除了 视频格式的检测不出来，如果选择其他格式个文件，都会运行到此，都会提醒，图片格式错误！
      	else echo '<body onload="error()"><script type="text/javascript">function error(){parent.error("上传图片时失败！请检查图片格式或图片大小！")}</script></body>';
    	 
    	}  	
    }
    
    public function doShelve() {		
       $re_goods_id=$_POST['gs_id'];
  if(empty($re_goods_id)){    //判断是修改宝贝信息还是上架新的宝贝
    	$data=array(
    	  'user_id'=>$this->uid,
    	  'goods_name'=>$_POST['goods_name'],
    	  'goods_detail'=>$_POST['goods_detail'],
    	  'img_id'=>$_SESSION['img_id'],
    	  'a_price'=>$_POST['a_price'],
    	  'b_price'=>$_POST['b_price'],
    	  'seller_qq'=>$_POST['seller_qq'],
    	  'seller_tel'=>$_POST['tell'],
    	  'trade_way'=>$_POST['trade_way'],
    	  'class_first'=>$_POST['class_first'],
    	  'class_second'=>$_POST['class_second'],
    	  'shelve_time'=>time()
    	);
    	        $flag=M('shelve')->add($data);//上架新宝贝
                if ($flag){
     	             $id = $this->allModel->query("SELECT LAST_INSERT_ID()");
     	             $message['code']    = 1;
     	             $message['message'] ='成功上架该件宝贝!';
     	             $nm=$id[0]['LAST_INSERT_ID()'];
     	             $message['jumpUrl'] = U("Trade/detail/id/".$nm."/i_/".md($nm));
     	             $_SESSION['img_id'] ='';
     	             echo json_encode($message);
               }          
               else{
     	             $message['code']    = 0;
     	             $message['message'] = '网络错误,请稍后再试!';  
     	             echo json_encode($message);      
               }
    }else {
    	   	$data=array(
    	  'user_id'=>$this->uid,
    	  'goods_name'=>$_POST['goods_name'],
    	  'goods_detail'=>$_POST['goods_detail'],
    	  'a_price'=>$_POST['a_price'],
    	  'b_price'=>$_POST['b_price'],
    	  'seller_qq'=>$_POST['seller_qq'],
    	  'seller_tel'=>$_POST['tell'],
    	  'trade_way'=>$_POST['trade_way'],
    	  'shelve_time'=>time()
    	);
    	
    	    	//修改宝贝信息
     	      $flag=M('shelve')->data($data)->where('goods_id='.$re_goods_id)->save();
                     if ($flag){     	
     	                 $message['code']    = 1;
     	                 $message['message'] ='成功修改该件宝贝的详细信息!';
     	                 $message['jumpUrl'] = U("Trade/detail/id/".$re_goods_id."/i_/".md($re_goods_id));
     	                 echo json_encode($message);
                     }             
                   else{
     	               $message['code']    = 0;
     	               $message['message'] = '网络错误,请稍后再试!';  
                    	echo json_encode($message);      
                   }	
    }      
}

    //  上传图片
    public function upLoad(){
	    import ( "ORG.Net.UploadFile" );
	    // 实例化上传类
		$upload = new UploadFile (); 
		// 讴置附件上传大小
		$upload->maxSize = 3145728; 
		// 讴置附件上传类型
		$upload->allowExts = array('jpg', 'gif', 'png', 'jpeg'); 
		// 讴置附件上传目录
        $upload->savePath = './Public/images/temp/'.$this->uid.'/';
        
         //设置需要生成缩略图，仅对图像文件有效 
        $upload->thumb = true;
        //设置需要生成缩略图的文件后缀 
       //  $upload->thumbSuffix =  '_m';  
         //设置缩略图最大宽度 
         $upload->thumbMaxWidth =  '340';  
       //设置缩略图最大高度 
         $upload->thumbMaxHeight = '290'; 
         //  上传命名规则 
         $upload->saveRule  = 'uniqid';
         // 删除原图
         $upload->thumbRemoveOrigin = true;
         
        // 上传错诣 提示错诣信息
		if (! $upload->upload ()) { 
			$this->info  = $upload->getErrorMsg ();
			return false;
		} else { 
			// 上传成功 获叏上传文件信息
			$this->info = $upload->getUploadFileInfo ();
			return true;			
		}	
		//$this->success ( "数据保存成功！" );
}

      //返回当前登录用户的id
  public function getlogined_id(){
  	return $this->uid;
  }


public function force_down(){
	  $goods_id=$_POST['goods_id'];
	  $for_d=D('shelve')->force_down($goods_id);
	  return $for_d;
}

     //  管理物品
    public  function manage(){
    	               
    	// marketed最近卖出的宝贝shelve最近上架的宝贝I_shelve我上架的宝贝I_mak我买过的宝贝
    	//// 1最近卖出的宝贝2最近上架的宝贝3我上架的宝贝4我买过的宝贝
    	
    	$type  = $_GET['type'];
			    	import("ORG.Util.Page");
			    	$this->assign('type',$type);			    	
			    	if($type=="marketed"){
			    		$user_op=$this->getlogined_id();
				        $is_admin=M('user')->where('user_id='.$user_op)->field('isAdmin')->find();
				        if ($is_admin['isAdmin']==1){
				        	 $number = D('Shelve')->getmanageNumber($type);
			    		     $page = new Page($number,18);
			    		     $this->assign('backData', D('Shelve')->getAll(1,$page->firstRow,$page->listRows));
			    		     $show = $page->show();
			    	         $this->assign('page',$show);
			    	         $this->display();
				        }else{
				        	$this->assign('backData', D('Shelve')->getAll(3,$page->firstRow,$page->listRows));
				            $this->assign('miid',3);
				        	$this->display();
				        }		
			    	}
			    	else if($type=="shelve"){
			    		$number = D('Shelve')->getmanageNumber($type);
			    		 $page = new Page($number,18);
			    		$this->assign('backData',D('Shelve')->getAll(2,$page->firstRow,$page->listRows));
			    		 $show = $page->show();
			    	     $this->assign('page',$show);
			    	     $this->display();
			    	}
			    	else if($type=="I_shelve"){
			    		$number = D('Shelve')->getmanageNumber($type);
			    		 $page = new Page($number,18);
			    		$this->assign( 'backData',D('Shelve')->getMy('user',$page->firstRow,$page->listRows));			    					    		
			    		$t=$this->uid;   		   		
    					//	规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；5为 @    				 	
							 if( 0!=M('notify')->where("receive= $t AND is_read=0 AND type= 3")->count()){
							     //清除通知
	    					    M('notify')->data(array('is_read'=>1))->where("receive= $t AND is_read=0 AND type= 3")->save();    	
							 }				    		
			    		$show = $page->show();
			    	     $this->assign('page',$show);
			    	     $this->display();
			    	}
			    	else if($type=="I_mak"){
			    		$number = D('Shelve')->getmanageNumber($type);
			    		 $page = new Page($number,18);
			    		$this->assign( 'backData',D('Shelve')->getMy('buy',$page->firstRow,$page->listRows));
			    		 $show = $page->show();
			    	     $this->assign('page',$show);
			    	     $this->display();
			    	}else {
			    			$this->assign('waitSecond',3);
				    		$this->error('你请求的页面不存在或者已被删除！');
			    	}
			   	 	
			    	
    	
     }
     
     //确定交易
     public function sure_trade(){
     	$id=$_POST['goods_id'];
     	$suer_g=D('Shelve')->sure_trade($id);
	     return $suer_g;
     	
     }
     
     
     //取消交易
     public function cancel_trade(){
     	$id=$_POST['goods_id'];
     	$cancel_t=D('Shelve')->cancel_trade($id);
	     return $cancel_t;
     }

//  获得商品分类列表  
   private  function _getMenu(){
   	$i = 0;
   	$menu = array();
   	$first   = D()->query('SELECT class_first_name,class_first_id FROM wo_goods_class_first');
   	$second  = D()->query('SELECT class_second_name,class_first_id FROM wo_goods_class_second'); 
  foreach ($first as $key =>$value ){
 	foreach ($second as $keys => $values){
 		if($value['class_first_id'] ==$values['class_first_id']){
 		$menu[$value['class_first_name']][$i++] = $values['class_second_name'];
 		}
 		else $i=0;
 	}
 	
 }
 
return $menu;
 }
 
 // 通过AJAX获得商品分类
  function getClassByAjax(){
    $first =  $_GET['id']; 
 	if(empty($first)){
 		$this->assign('waitSecond',3);
 		$this->error('参数错误!');
 	}
 	$data = D()->query('SELECT class_second_name FROM wo_goods_class_second WHERE class_first_id = '.$first);
 	foreach($data as $value)
 	foreach ($value as $values)
 	{
 	$return.=$values.',';
 	}
 echo $return;
}




}

?>