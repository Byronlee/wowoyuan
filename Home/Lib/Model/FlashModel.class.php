
<?php
	class FlashModel extends Model{

 var $tableName = 'Flash';

	/**
	 * 
	 +----------------------------------------------------------
	 * Description 微博发布
	 +----------------------------------------------------------
	 * @author NOON@wowoyuan.com
	 +----------------------------------------------------------
	 * @param $uid 发布者用户ID
	 * @param $data 微博主要数据
	 +----------------------------------------------------------
	 * @return $id
	 +----------------------------------------------------------
	 * Create at  2011-11-7 下午05:02:06
	 +----------------------------------------------------------
	 */
//发布微博
     function publish($uid,$data){
     	$con=t($data);
     	$save['user_id']	= $uid;        
        $save['posttime']      = time();     	
     	$save['flash_body'] =$con;
     	$id = $this->add($save);
     	//dump($id);
     	//$f_id = $this->allModel->query("SELECT LAST_INSERT_ID()");
     	// $flash_id = $f_id[0]['LAST_INSERT_ID()'];
     	if( $id){
     	     $this->notifyToAtme($uid, $con,$id);
     		return $id;
     	}else{
     		return false;
     	}
    }
    
   

     // 给提到我的发通知 @Byronlee 
    function notifyToAtme($uid,$content,$flash_id){
    	
        $arrUids= array();
    	$arrUids =$this->getUids($content);  //把几个数组合并成一个数组
   // 	dump($arrUids);
    	if( $arrUids ){
    		$arrUids = array_unique( $arrUids ); //去重
    		$form=$uid;   //为当前登录用户
    	foreach ($arrUids as $k =>$v){	
    	//		    	     dump($v);
			  if ($form!=$v&&(!empty($v))){			  
				 A('Notify')->send( $form,$v,5); //规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；5为@到的新用户
			   }
                if((!empty($v))){
               	   	$data	= array(
						'flash_id'=>$flash_id,
                        'uid'=>$v
						);		         			         		    	 
				   M('flash_atme')->add($data);
               }	
		}
    	}
 } 
 
    
    
function getUids($content) {	
    preg_match_all("/@([\w\x{4e00}-\x{9fa5}\-]+)/u", $content, $matches);
    $unames = $matches[1];
    $ulist=array();
    if(!empty($unames)){
    foreach ($unames as $k=>$value){
    	$map['username']=$value;
    	$u= M('user')->where($map)->field('user_id')->findall();
    	if(intval($u[0]['user_id'])){
    		$ulist[]=$u[0]['user_id'];
    	}        
    }
     return $ulist;
    }
}
 
  



//获取项目首页微博列表
function get_allHomeList($row=5){
	$list = $this->order('flash_id DESC')->limit($row)->findAll();
	   return $list;
	
}
	function get_friendHomeList($row=5){
		$user_op=A('Trade')->getlogined_id();
	      $return=D()->query("select * from wo_flash left join(wo_user_follow) on (wo_user_follow.fid= wo_flash.user_id)   WHERE wo_user_follow.uid=$user_op ORDER BY wo_flash.flash_id DESC LIMIT 5");   	     	     		      
			return $return;
}
function get_meHomeList($row=5){
		$user_op=A('Trade')->getlogined_id();
	$return=D()->query("select * from wo_flash WHERE user_id=$user_op ORDER BY flash_id DESC LIMIT 5");   	     	     		      
	   return $return;
	
}





 
 /**
 *   获取空间闪存列表
 * 
 * @param  int $id  数据库查询条件
 * @param  int $since 数据库查询的起始记录
 * @param  int $row   查询的总数
 * @return int 满足条件的个数
 *
 */



function getspace_indexList($uid,$type,$since,$row){
	$row = $row?$row:20;
	$login_id=A(Trade)->getlogined_id();
	if($type=='flash'){	
	$list = $this->where("user_id=$uid")->order('flash_id DESC')->limit("$since,$row")->findAll();
	foreach ($list as $k =>$value){            
                  $list[$k]['operate']=$this->operate_flash($list[$k]['user_id'],$list[$k]['flash_id'],$login_id);     	
              }		
	}
	if($type=='weitie'){
		$list = M('weitie')->where("user_id=$uid")->order('weitie_id DESC')->limit("$since,$row")->findAll();
	}
  return $list;
}
/**
 *   获得满足条件的闪存总数,用于分页类
 * 
 * @param  int $id  数据库查询条件
 * @return int 满足条件的个数
 *
 */
function getSpaceNumber($id){
	
	$number = D()->query("SELECT count(*) FROM wo_flash WHERE user_id = $id");
	return $number[0]['count(*)'];
}




/**
 * 将给定用户设为在线
 * 
 * @param int $since  每页起始记录
 * @param int $row    每页显示个数
 */

    //获取闪存首页列表
    function getHomeList($since, $row,$data) {
    	$uid=A(Trade)->getlogined_id();
    	if(empty($data)){
    		$list = $this->order('flash_id DESC')->limit("$since,$row")->findAll();
    	}else {
    		$list = D()->query("select * from wo_flash left join(wo_user_follow) on (wo_user_follow.fid= wo_flash.user_id)   WHERE wo_user_follow.uid=$uid ORDER BY wo_flash.flash_id DESC LIMIT $since,$row");  
    	}
    	  foreach ($list as $k =>$value){            
                  $list[$k]['operate']=$this->operate_flash($list[$k]['user_id'],$list[$k]['flash_id'],$uid);     	
              }      	
        return $list;
    }
    

    
    function operate_flash($f_user,$f_id,$mid){         //判断 对每一条闪存的 操作权限
    	$is_admin=M('user')->where('user_id='.$mid)->field('isAdmin')->find();
    	if ($f_user==$mid){
    		return  "<a href=\"javascript:void(0)\" onclick=\"deleted(".$f_id.")\" >删除</a>&nbsp;| ";
    	}else if ($is_admin['isAdmin']==1){
	          return  "<a href=\"javascript:void(0)\" onclick=\"deleted(".$f_id.")\" >删除</a>&nbsp;| ";
	        }else {
	        	return "";
	        }  	
    }
    
    
    function count_friend_flash($uid){   //统计我关注的所有人的发微贴总数
    	$list = D()->query("select * from wo_flash left join(wo_user_follow) on (wo_user_follow.fid= wo_flash.user_id)   WHERE wo_user_follow.uid=$uid");  
    	return count($list);
    }
    
    
    
    
    
    //删除一条删除闪存评论
    function flash_comment($comment_id,$flash_id){   	
       
        
      $updata = D()->execute('UPDATE wo_flash SET flash_comment_time = flash_comment_time -1 WHERE flash_id = '.$flash_id);  
      return $deletedflash_comment = M('flash_comment')->where( "comment_id=$comment_id")->delete(); 
    }
    	
    	
     //删除一条闪存
    function flash($flash_id){

       $deletedflash = $this->where( "flash_id=$flash_id")->delete();
       if($deletedflash){
       	//同时删除评论
       $uid=A(Trade)->getlogined_id();
        M('flash_comment')->where("flash_id=$flash_id AND user_id= $uid")->delete();  
        M('flash_atme') ->where("flash_id=$flash_id")->delete();
       	return 1;
       }else{
       	return 2;
       }
                           
    }
    
    
    
    
	 //返回一个站内使用的解析微博
    public function getOneLocation($id)
    {
    	$value = $this->where('flash_id='.$id)->find(); 
        return $value;
       
    }
    
    
    
    
    	public function getComment($id,$num){     //给定一条闪存的id 获得这条闪存的相关评论
    		$uid=A(Trade)->getlogined_id();
    		if(empty($num)){
				$data =  D()->query('SELECT * FROM wo_flash_comment WHERE flash_id  =  '.$id.' ORDER BY ctime DESC');				
				foreach ($data as $k =>$value){            
                  $data[$k]['operate']=$this->operate_flash_comment($data[$k]['user_id'],$data[$k]['comment_id'],$uid,$id);     	
              } 				
				return $data;
			}else{
				$data =  D()->query('SELECT * FROM wo_flash_comment WHERE flash_id  =  '.$id.' ORDER BY ctime DESC LIMIT '.$num);
				
				foreach ($data as $k =>$value){            
                  $data[$k]['operate']=$this->operate_flash_comment($data[$k]['user_id'],$data[$k]['comment_id'],$uid,$id);     	
              	}							
				return $data;
			}
    }
    

    
    function operate_flash_comment($comment_user,$comment_id,$mid,$id){     //对每一条评论的操作权限进行判断   $comment_user表示 该条评论的主人
    	$is_admin=M('user')->where('user_id='.$mid)->field('isAdmin')->find();
    	if ($comment_user==$mid){
    		return  "<a href=\"javascript:void(0)\" onclick=\"deletedcomment(".$comment_id.",".$id.")\" >删除</a>&nbsp; ";
    	}else if ($is_admin['isAdmin']==1){
	          return  "<a href=\"javascript:void(0)\" onclick=\"deletedcomment(".$comment_id.",".$id.")\" >删除</a>&nbsp; ";
	        }else {
	        	return "";
	        }  	
    }
    
    	
    	
    	
    	
    function get_atmeList($since,$row,$uid){ 	
  	    $data =  D()->query("select * from wo_flash_atme left join(wo_flash) on (wo_flash_atme.flash_id= wo_flash.flash_id) WHERE  wo_flash_atme.uid=$uid ORDER BY wo_flash_atme.at_id DESC LIMIT $since,$row");	
      
  	     foreach ($data as $k =>$value){            
                  $data[$k]['operate']=$this->operate_flash($data[$k]['user_id'],$data[$k]['flash_id'],$uid);     	
              }  	    
  	    return $data;
  }
  
  function get_atmeListcount($since,$row,$uid){
  	
  	    $data =  D()->query("select * from wo_flash_atme left join(wo_flash) on (wo_flash_atme.flash_id= wo_flash.flash_id) WHERE  wo_flash_atme.uid=$uid");	
  	    return count($data);
  }
  
  
    	
    	
    	
    	
    	
    	
    	
    	
    	
    	
    	
    	
    
	}
    
 	?>