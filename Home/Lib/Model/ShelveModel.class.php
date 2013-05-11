<?php
class ShelveModel extends Model{
	// 获得最近上架的物品
	function getNewList($type,$number){
	       if ($type=='on'){
		
    	$data=M('shelve')->where("is_Sale=2")->order('goods_id DESC')->limit("$number")->findAll();

		  return  $data;
	       }
	      else return $this->where("is_Sale=1")->order('goods_id DESC')->limit("$number")->findAll();
	}
	
	

	
	// 我的商品信息
	function getMy($type,$since,$row){
		
			// 参数$type为user,buy  			       
			   $uid=A(Trade)->getlogined_id();
			   if($type=="buy"){
			   $return=D()->query("SELECT goods_id,img_id,goods_name,a_price,user_id,buy_id,trade_way,is_sale,shelve_time,buy_time FROM wo_shelve WHERE buy_id =$uid ORDER BY buy_time DESC LIMIT $since,$row");             
			   }else {
			    $return=D()->query("SELECT goods_id,img_id,goods_name,a_price,user_id,buy_id,trade_way,is_sale,shelve_time,buy_time FROM wo_shelve WHERE user_id =$uid ORDER BY goods_id DESC LIMIT $since,$row");             
			   }
			 // $return=M('shelve')->where("$type.'_id ='.$uid")->order('goods_id DESC')->findAll();		 
			 foreach ($return as $k =>$value){            
              $return[$k]['trade_way']=$this->trade_way($return[$k]['trade_way']); 
              if($type=="buy"){
              $return[$k]['operate']=$this->operate($return[$k]['is_sale'],111); 
              }else{
              $return[$k]['operate']=$this->operate($return[$k]['is_sale']); 
              }   
              $return[$k]['host_id']=$return[$k]['user_id'];          
              $return[$k]['user_id']=$this->sure_master($return[$k]['user_id'],$return[$k]['buy_id'],$return[$k]['is_sale']);   
              $return[$k]['is_sale']=$this->is_sale($return[$k]['is_sale'],$return[$k]['buy_time'],$return[$k]['goods_id']);       	
              }          
              return $return;
		
	}
	
	
	
	//对每一件宝贝的新主人  的智能判断    交易成功为 （新）主人，未交易，则为原本所有者，谈判中  则为（预）主人
	
	function sure_master($uid,$bid,$issale){	
		if ($bid!=0&&$issale==1){
		     $master = M('user')->query('SELECT username FROM wo_user WHERE user_id ='. $bid);
		     $url = U ( 'Space/index', array ('uid' => $bid,'ui_'=>md($bid) ) );
		     $target = '_blankf';
	         return "<span class=\"mt\">（新）主人</span><br /><a href='{$url}' target='{$target}'>{$master[0]['username']}</a>";
		}
	    if ($bid!=0&&$issale==3){
		    $master = M('user')->query('SELECT username FROM wo_user WHERE user_id ='. $bid);
		     $url = U ( 'Space/index', array ('uid' => $bid,'ui_'=>md($bid) ) );
		     $target = '_blank';
	         return "<span class=\"mt\">（预）主人</span><br /><a href='{$url}' target='{$target}'>{$master[0]['username']}</a>";
		}else{
		    $master = M('user')->query('SELECT username FROM wo_user WHERE user_id ='. $uid);
		     $url = U ( 'Space/index', array ('uid' => $uid ,'ui_'=>md($uid)) );
		     $target = '_blank';
	         return "<a href='{$url}' target='{$target}'>{$master[0]['username']}</a>";
		}
	  
	}
	

	
	
	// 判断交易方式
	function trade_way($value){
	      if ($value==1) {
	      	return "现金";
	      }
	      if ($value==2) {
	      	return "以物易物";
	      }else{
	        return "现金或易物";
	      }
	}
	
	
function sure_class($first,$second){   // 判断一件宝贝的类别
		
		if (empty($first)&&empty($second)){
			return '未分类';
		}else{
			$first_class=M('goods_class_first')->where("class_first_id	= $first")->field('class_first_name')->find();
			$second_class=M('goods_class_second')->where("class_first_id= $first AND class_second_id= $second")->field('class_second_name')->find();
		    if ($first_class){
		    	$t=$first_class['class_first_name'];
		    }else {
		    	$t=1;
		    }
		   if ($second_class){
		    	$y=$second_class['class_second_name'];
		    }else {
		    	$y=1;
		    }
			if($t==1&&$y==1){
				return '未分类';		    	
		    }
		    if($t==1&&$y!=1){
				return $y;		    	
		    }if($t!=1&&$y==1){
				return $t;		    	
		    }
		    else {
		     	return  $t.'&nbsp;&#8226;&nbsp;'.$y;
		    }	
		}
	}
	
	
	

	
	
	
	
	
	
	
	//判断目前该物品的交易状态
	
	function is_sale($value,$buy_time,$id){
		
		  //清理处于7天后的且处于谈判 状态下的交易，取消该项交易
		if($buy_time!=0){
	
	 	$cTime = time ();
	    $dTime = $cTime - $buy_time;
	    $dDay =$dTime / 3600 / 24;
	 //   dump($cTime);
      //  dump($dDay);
		if ($dDay < 7) {
	           if ($value==1) {
	      	      return "<div class=\"sure_trade_su\"><input type=\"button\" value=\"交易成功!\"  class=\"succ issa\" /></div>";
	            }
	            if ($value==3) {
	           	return "<div class=\"sure_trade_su\"><input type=\"button\" value=\"谈判中...\"  class=\"statu issa\" /></div>";
	           }else{
	          // 	dump($value);
	            return "<div class=\"sure_trade_su\"><input type=\"button\" value=\"未交易\"  class=\"statu issa\" /></div>";
	         }
	       }else {
	       
	                 $return=$this->data(array('is_Sale'=>2,'buy_id'=>0,buy_time=>0))->where('goods_id='.$id)->save();
                     if ($value==1) {
	      	          return "<div class=\"sure_trade_su\"><input type=\"button\" value=\"交易成功!\"  class=\"succ issa\" /></div>";
	                   }
	                   if ($value==3) {
	                	return "<div class=\"sure_trade_su\"><input type=\"button\" value=\"谈判中...\"  class=\"statu issa\" /></div>";
	                  }else{	         
	                     return "<div class=\"sure_trade_su\"><input type=\"button\" value=\"未交易\"  class=\"statu issa\" /></div>";
	                  }
               
	       
	       }
		}
		else {
		      if ($value==1) {
	      	      return "<div class=\"sure_trade_su\"><input type=\"button\" value=\"交易成功!\"  class=\"succ issa\" /></div>";
	            }
	            if ($value==3) {
	           	return "<div class=\"sure_trade_su\"><input type=\"button\" value=\"谈判中...\"  class=\"statu issa\" /></div>";
	           }else{
	          // 	dump($value);
	            return "<div class=\"sure_trade_su\"><input type=\"button\" value=\"未交易\"  class=\"statu issa\" /></div>";
	           }
		
		
		}
	      
	      
	      
	      
	}
	
	
	//根据不同的身份 给出不同的用户权限操作
	function operate($data,$d_buy){
		if($d_buy==""){
		    if($data==""){
	        $user_op=A('Trade')->getlogined_id();
	        $is_admin=M('user')->where('user_id='.$user_op)->field('isAdmin')->find();
	        if ($is_admin['isAdmin']==1){
	          return "管理员<br /><input type=\"button\" value=\"强制下架\"  class=\"down\" />";
	        }else {
	        return "";
	        }
		    }
		    if ($data==1){
		        return "";
		    }
		    
	       if ($data==2){
		         return "<div><input type=\"button\" value=\"下架宝贝\"  class=\"I_down\" /></div><div><input type=\"button\" value=\"修改详情\"  class=\"change_info\"/></div>";
		    }		    
		    else {
		    return "<div><input type=\"button\" value=\"确定交易\"  class=\"sure_trade  spedd\"/></div>";
		
		    }
		}
		else {
		
		 if ($data==1){
		        return "";
		    }
		 else {
		    return "<div><input type=\"button\" value=\"取消交易\"  class=\"cancel_trade\" /></div>";
		
		    }
			
		}  
		    
		    
		    
	}
	// 管理员强行下架货物
	
	function force_down($id){
	      return $this->where('goods_id='.$id)->delete();	     
	      
	}
	
	//确定交易
	
	function  sure_trade($id){
	     if($id!=""){
	     $ctime = time();   
     	    $return=$this->data(array('buy_time'=>$ctime,'is_Sale'=>1))->where('goods_id='.$id)->save();
     	 //dump($id);
     	if($return){	
     	     return true;
     		}else{
     		return false;
    		}
     	}else {
    		return false;
     	}
	
	}
	
	//取消交易
	 function cancel_trade($id){
	   if($id!=""){
     	    $return=$this->data(array('is_Sale'=>2,'buy_id'=>0,'buy_time'=>0))->where('goods_id='.$id)->save();
     	 //dump($id);
     	if($return){	
     	     return true;
     		}else{
     		return false;
    		}
     	}else {
    		return false;
     	}
	 }
	
	
	
	
	
	// 全部商品
	function getAll($type,$since,$row){
              // 参数$type为1卖出的宝贝    2上架的宝贝   3的时候表示当前登录用户不是管理员  所以在最新卖出的物品 选项中 只展示 最新18条记录
              
		    if($type==3){
		          $return=D()->query("SELECT goods_id,img_id,goods_name,a_price,user_id,buy_id,trade_way,is_sale,shelve_time,buy_time FROM wo_shelve WHERE is_Sale =1 ORDER BY buy_time DESC LIMIT 18");             	          
		      foreach ($return as $k =>$value){            
              $return[$k]['trade_way']=$this->trade_way($return[$k]['trade_way']); 
              $return[$k]['host_id']=$return[$k]['user_id']; 
              $return[$k]['user_id']=$this->sure_master($return[$k]['user_id'],$return[$k]['buy_id'],$return[$k]['is_sale']);  
              $return[$k]['is_sale']=$this->is_sale($return[$k]['is_sale'],$return[$k]['buy_time'],$return[$k]['goods_id']); 
              $return[$k]['operate']=$this->operate();     	
              }          
              return $return;
           
		      }
		      if($type==1){
              $return=D()->query("SELECT goods_id,img_id,goods_name,a_price,user_id,buy_id,trade_way,is_sale,shelve_time,buy_time FROM wo_shelve WHERE is_Sale =1 ORDER BY buy_time DESC LIMIT $since,$row");             
              foreach ($return as $k =>$value){            
              $return[$k]['trade_way']=$this->trade_way($return[$k]['trade_way']); 
               $return[$k]['host_id']=$return[$k]['user_id']; 
              $return[$k]['user_id']=$this->sure_master($return[$k]['user_id'],$return[$k]['buy_id'],$return[$k]['is_sale']);  
              $return[$k]['is_sale']=$this->is_sale($return[$k]['is_sale'],$return[$k]['buy_time'],$return[$k]['goods_id']); 
               $return[$k]['operate']=$this->operate();           	
              }          
              return $return;
              }
              else{
              $return=D()->query("SELECT goods_id,img_id,goods_name,a_price,user_id,buy_id,trade_way,is_sale,shelve_time,buy_time FROM wo_shelve WHERE is_Sale =2 OR is_sale=3 ORDER BY goods_id DESC LIMIT $since,$row");
              foreach ($return as $k =>$value){            
              $return[$k]['trade_way']=$this->trade_way($return[$k]['trade_way']);  
               $return[$k]['host_id']=$return[$k]['user_id']; 
              $return[$k]['user_id']=$this->sure_master($return[$k]['user_id'],$return[$k]['buy_id'],$return[$k]['is_sale']);   
              $return[$k]['is_sale']=$this->is_sale($return[$k]['is_sale'],$return[$k]['buy_time'],$return[$k]['goods_id']); 
             $return[$k]['operate']=$this->operate();      
              }           
              return $return;
              }
	}
	
	// 分类获得商品
	function getClass($first,$second,$since,$row){
			
			if(empty($second)){			
              $return=D()->query("SELECT img_id,user_id,goods_name,goods_id,a_price FROM wo_shelve WHERE class_first = $first AND is_Sale = 2 ORDER BY goods_id DESC LIMIT $since,$row ");
		       return $return;
		  }else {		
	             // $return=M('shelve')->where("is_Sale=2 AND class_first = $first AND class_second = $second")->order('goods_id DESC')->findAll();
		      $return=D()->query("SELECT img_id,user_id,goods_name,goods_id,a_price FROM wo_shelve WHERE class_first = $first AND class_second = $second  AND is_Sale = 2 ORDER BY goods_id DESC LIMIT $since,$row ");
 
			 return $return;		
		}
}
	
	// 获得每件商品信息  
	function  getEvery($id,$data){
		if(empty($data)) {
		$return =D()->query("SELECT * FROM wo_shelve WHERE goods_id = $id");
		 foreach ($return as $k =>$value){ 
		  $return[$k]['class']=$this->sure_class($return[$k]['class_first'],$return[$k]['class_second']);		 
		 }	
		return $return;
		}else {		
		$return=D()->query("SELECT * FROM wo_shelve WHERE goods_id = $id");
		 foreach ($return as $k =>$value){            
              $return[$k]['trade_way']=$this->trade_way($return[$k]['trade_way']); 
              $return[$k]['class']=$this->sure_class($return[$k]['class_first'],$return[$k]['class_second']);
              $goods_user_id=$return[$k]['user_id']; 
              $return[$k]['is_sale_t']=$return[$k]['is_Sale'];
               $return[$k]['is_sale']=$this->is_sale($return[$k]['is_Sale'],$return[$k]['buy_time'],$return[$k]['goods_id']);           	             
             //把原始主人的信息整合在一个数组里面
             
              $host=D('Public')->getUserInfo($goods_user_id);  
              
             foreach ($host as $key =>$da){
             $return[$k]['host_id']=$host[$key]['user_id'];
             $return[$k]['host_academy']=$host[$key]['academy'];
             $return[$k]['host_profession']=$host[$key]['profession'];
             $return[$k]['host_grade']=$this->sure_grade($host[$key]['grade'],$host[$key]['class']);
             $return[$k]['host_mailadres']=$host[$key]['mailadres'];
             $return[$k]['looking']="
                   &nbsp; 亲，您好，<span>欢迎</span>来到窝窝园交易平台，在这里我们对窝窝园的<span>特色交易方案</span>给你做一些说明，窝窝园的交易特色就是，在这里，<span>我们不提供具体的
                                                 交易方式，如果你喜欢或是感兴趣这件物品，就根据卖
                                               家留下的联系方式，去主动联系卖家，然后你们再商议
                                                 具体的交易时间，地点，和交易方式</span>，这样的话你们的交易可以是现金，也可以是<span>以物易物</span>哦，这样一来，在主动联系他或她的同时，不仅<span>得到</span>自己<span>心仪的宝贝</span>，也同时多<span>认识
                                               了一位校友</span>哦。亲，行动吧，<strong>缘分就在里面</strong>哦！。";
             }
  
		 }     
		      return $return;
		}
	}

	
	//组合班级和年级
	 function sure_grade($t,$y){
	     if(!empty($t)&&!empty($y)){
	         return $t."级&nbsp;".$y."班";
	     }
	     if(!empty($t)&&empty($y)){
	         return $t."级";
	     }
	     if(empty($t)&&!empty($y)){
	         return $y."班";
	     }
	     
	     else {
	       return "未填写";
	     }
	 }
	
	
	
	//发起一项交易
	function make_trade($id,$uid,$host_id){
	 if($id!=""&&$uid!=""){
	 	  	$ctime = time();	 	   	 		 	   	
     	    $return=$this->data(array('is_Sale'=>3,'buy_time'=>$ctime,'buy_id'=>$uid))->where('goods_id='.$id)->save();
     	 //dump($id);
     	if($return){
     		  A('Notify')->send( $uid,$host_id,3 ); //规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；
     	     return true;
     		}else{
     		return false;
    		}
     	}else {
    		return false;
     	}
	
	}
	
	
	
	
	
	
	
	
	
/**
 * 根据条件获得相应分类的总数
 * @param int $first  一类分类
 * @param int $second 二级分类
 * @return int 
 */
	function getClassNumber($first,$second){
		
		if(empty($second)){
		   $number = $this->query("SELECT count(*) FROM wo_shelve WHERE class_first = $first AND is_Sale=2");
		   return $number[0]['count(*)'];
		  }else {		
			$number = $this->query("SELECT count(*) FROM wo_shelve WHERE class_first = $first AND class_second = $second AND is_Sale=2");
		    return $number[0]['count(*)'];
		
		}		
		
	}
	
	//根据不同的特点获取manage页面的四个分类的总数
	
	
	function  getmanageNumber($type){
	    $uid=A(Trade)->getlogined_id();
	    if($type=="marketed"){
    	   $number = $this->query("SELECT count(*) FROM wo_shelve WHERE is_Sale =1");
		   return$number[0]['count(*)'];
    	}
    	if($type=="shelve"){
            $number = $this->query("SELECT count(*) FROM wo_shelve WHERE  is_Sale =2 OR is_Sale =3");
		    return $number[0]['count(*)'];
    	}
    	if($type=="I_shelve"){
                $number = $this->query("SELECT count(*) FROM wo_shelve WHERE  user_id =$uid");
		        return $number[0]['count(*)'];
    	}
    	if($type=="I_mak"){
    		$number = $this->query("SELECT count(*) FROM wo_shelve WHERE buy_id=$uid");
		    return $number[0]['count(*)'];
    	
    	}	
	}
	
	
	
	
	
	
	
	
	
}