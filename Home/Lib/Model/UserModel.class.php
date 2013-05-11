<?php
class UserModel extends Model{
	protected	$tableName	=	'user';
    var $uid;
    
    
    
    public  function deleteUser($uids) {
    	
    	if ( empty($uids) ) return false;

    	$map['uid'] = array('in', $uids);
    	$map['isAdmin'] = 0;
    	//user
    	$res = M('user')->where($map)->delete();
    	//user_group_link
    	//user_group_popedom
    	//user_popedom
    	unset($map['isAdmin']);
		
    	return $res;
    }
    
    
/**
	 * 根据标示符(uid或uname或email或domain)获取用户信息
	 * 
	 * 首先检查缓存(缓存ID: user_用户uid / user_用户uname), 然后查询数据库(并设置缓存).
	 * 
	 * @param string|int $identifier      标示符内容
	 * @param string     $identifier_type 标示符类型. (uid, uname, email, domain之一)
	 */
	public function getUserByIdentifier($identifier, $identifier_type = 'uid')
	{
	
		$map = array();
		if ($identifier_type == 'uid')
			$map['user_id'] = intval($identifier);
		else
			$map['username'] = t($identifier);
		$user = $this->where($map)->find();
		return $user;
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		public function gettop5(){
			
		$data=$this->limit('5')->order('user_id desc')->where("is_set_avatar=1")->findAll();
		
		
		
		return $data;
	}
	
	
	
	
	public function getAll_user_detail($p,$since,$row){
		
		$user_op=A('Trade')->getlogined_id();
		
		$data=D()->query("SELECT * FROM wo_user WHERE is_set_avatar=1 ORDER BY follower DESC LIMIT $since,$row");
		 foreach ($data as $k =>$value){   
		 $data[$k]['followState']  = D('Follow')->getState($user_op,$data[$k]['user_id']);		
		 	if($p>=2){
		  		 $data[$k]['p_m_times']=($p-1)*33;
		  	}else {
		  		 $data[$k]['p_m_times']=0;
		  	}
		  	
		}
		return $data;		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
    ?>
