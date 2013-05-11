<?php
class FollowModel extends Model {

var $tableName = 'user_follow';

/**
	 * 添加关注 (关注用户 / 关注话题)
	 * 
	 * @param int $mid  发起操作的用户ID
	 * @param int $fid  被关注的用户ID 或 被关注的话题ID
	 * @return null:参数错误 11:已关注 12:关注成功(且为单向关注) 13:关注成功(且为互粉)
	 */
	public function dofollow($mid, $fid)     
	{
		
		$map['uid']  = $mid;
		$map['fid']  = $fid;
		if (0 == $this->where($map)->count()) { // 未关注
			$this->add($map);
			unset($map);
			
			D()->execute('UPDATE wo_user SET follower = follower +1 WHERE user_id = '.$fid); 
	
				
				// 通知和动态          这块以后来完善
				 	// 通知和动态       
  
		      	   A('Notify')->send( $mid, $fid,4 ); //规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；
				
			if (0 == $this->where("uid=$fid AND fid=$mid")->count()) {
				return '12'; // 关注成功(单向关注)
			} else {
				return '13'; // 关注成功(互粉)
			}
		}
		 else {
			return 11; // 已关注过
		}
	}
	
	/**
	 * 取消关注 (关注用户 / 关注话题)
	 * 
	 * @param int $mid  发起操作的用户ID
	 * @param int $fid  被取消关注的用户ID 或 被取消关注的话题ID
	 * @param int $type 0:取消关注用户(默认) 1:取消关注话题
	 * @return 00:取消失败 01:取消成功
	 */
	public function unfollow($mid, $fid)
	{
		$map['uid']  = $mid;
		$map['fid']  = $fid;
		if ($this->where($map)->delete()) { // 取消成功	
			D()->execute('UPDATE wo_user SET follower = follower -1 WHERE user_id = '.$fid); 				
			return '01'; //取消成功
		} 
		else {
			return '00'; //取消失败
		}
	}
	//获取关注状态
	function getState( $uid , $fid){
		return getFollowState($uid,$fid);
	}

	//获取关注列表
	function getList( $uid,$type,$since,$row){      

		if( $type == 'following' ){ //关注	
				
				$list = $this->where("uid=$uid")->order('follow_id DESC')->limit("$since,$row")->findAll();		
		
	     $list = 	D()->query("select * from wo_user left join(wo_user_follow) on (wo_user.user_id= wo_user_follow.fid)   WHERE wo_user_follow.uid=$uid ORDER BY wo_user_follow.follow_id DESC LIMIT $since,$row"); 
		}else{ //粉丝
			 $list = 	D()->query("select * from wo_user left join(wo_user_follow) on (wo_user.user_id= wo_user_follow.uid)   WHERE wo_user_follow.fid=$uid ORDER BY wo_user_follow.follow_id DESC LIMIT $since,$row"); 
		}
	    foreach ($list as $key=>$value){				
				$list[$key]['grade_class']=D('Shelve')->sure_grade($list[$key]['grade'],$list[$key]['class']);
			}
		
		

		D('Notify')->getviewfans($uid);   //清除通知

		return $list;
	}
	
	/**
	 * 获取粉丝或者关注的用户总数
	 * 
	 * @param int $mid  发起操作的用户ID	
	 * @param int $type 0:粉丝1:关注
	 * @return int 
	 */
	function getListNumber($mid,$type){
		$querystr = 'SELECT count(*) FROM wo_user_follow WHERE';
		if($type==0){
			$number = $this->query($querystr.' fid= '.$mid);
		}
		else {
			$number = $this->query($querystr.' uid= '.$mid);
		}
		return $number[0]['count(*)'];
		
	}



}
?>