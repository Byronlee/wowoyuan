<?php



/**
 * 动态服务
 */
class NotifyModel extends Model{


	
	
/**
	 * 删除通知
	 * @param string|array $ids 通知ID 多个时以英文的","分割
	 * @return boolean
	 */
	public function deleteNotify($ids) {
		$ids = is_array($ids) ? $ids : explode(',', $ids);
		if ( empty($ids) )
			return false;
		$map['notify_id'] = array('in', $ids);
		return M('notify')->where($map)->delete();
	}
	
	
/**
	 +----------------------------------------------------------
	 * Description 通知发送处理
	 +----------------------------------------------------------
	 +----------------------------------------------------------
	 * @param $type    通知类型
	 * @param $receive 通知接收者的用户ID,类型可为 数字、字符串、数组
	 * @param $title   通知标题
	 * @param $body    通知内容
	 * @param $from    通知发送者UID
	 * @param $system  是否为系统通知
	 * @param $mid     是当前登录用户
	 +----------------------------------------------------------
	 * @return Boolen
	 +----------------------------------------------------------
	 * Create at  2011-12-3 下午04:24:53
	 +----------------------------------------------------------
	 */
	public  function __put($form, $receive_id,$type) {
		
		 $data= array(
		 'from'=>$form,
		 'receive'=>$receive_id,
		 'type'=>$type,
		 'ctime'=>time()
		 );
		 //规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；5为@到的用户
		$result =M('notify')->data($data)->add();		
		return $result;
	}

	
	
	
	
	//解析传入的用户ID
	public function _parseUser($touid){
		if( is_numeric($touid) ){
			$sendto[] = $touid;
		}elseif ( is_array($touid) ){
			$sendto = $touid;
		}elseif (strpos($touid,',') !== false){          //strpos — 查找字符串首次出现的位置
			$touid = array_unique(explode(',',$touid));   //array_unique() 函数移除数组中的重复的值，并返回结果数组。
			foreach ($touid as $key=>$value){
				$sendto[] = $value;
			}
		}else{
			$sendto = false;
		}
		return $sendto;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 /**
     * 获取给定用户的通知统计
     * @param int $mid
     * @return array 格式为:
     *               <code>
     *               array(
     *               	'message'		=> '0', // 未读微信息数
     *               	'notify'		=> '0', // 未读系统通知数
     *               	'comment'		=> '0', // 未读评论总数
     *               	'total'			=> '0', // 以上未读的总数
     *               	'new_fid'        => '0', // 未读的新曾粉丝数
     *               )
     *               </code>                           //$type   0表示系统通知，1表示 新粉丝通知
     */
public function getCount($uid){        //规定 type 类型：1为flash_comment，2为wt_comment，3为new_trade，4为new_fid；5为@到我的
		$uid = intval($uid);
		if($uid){

		$return['flash_comment']	    = M('notify')->where("receive= $uid AND is_read=0 AND type= 1")->count();
		$return['wt_comment']    		=  M('notify')->where("receive= $uid AND is_read=0 AND type= 2")->count();
		$return['new_trade']     		=  M('notify')->where("receive= $uid AND is_read=0 AND type= 3")->count();
		$return['new_fid']              =  M('notify')->where("receive= $uid AND is_read=0 AND type= 4")->count();
	    $return['at_me']                =M('notify')->where("receive= $uid AND is_read=0 AND type= 5")->count();

	    $num   = array_sum($return);
		if (empty($num)){
			return 0;
		}else{
			return $return;
		}
	}else{
		return 0;
	}
}
	/**
	 * 获取通知列表
	 * 
	 * @param array|string $map          查询条件, 必须是ThinkPHP格式的map
	 * @param int          $limit        每页显示的数据条数
	 * @param boolean      $mark_is_read 是否标记为已读
	 * @return array
	 */
	public function get($map,$limit=20,$mark_is_read = true) {
		$notifyList = M('Notify')->where($map)->order('ctime DESC')->findpage($limit);

		foreach ($notifyList['data'] as $key=>$value){
			$parseData = $this->_parseTemplate($value);
			$notifyList['data'][$key]['title'] = $parseData['title'];
			$notifyList['data'][$key]['body']  = $parseData['body'];
			$notifyList['data'][$key]['other']  = $parseData['other'];
		}
		
		if ($mark_is_read)
			M('Notify')->data(array('is_read'=>1))->where($map)->save();
			
		return $notifyList;
	}
	
	
	
	/*清楚查看粉丝通知*/
	public function getviewfans($uid){
		M('Notify')->data(array('is_read'=>1))->where('receive='.$uid.' AND is_read=0 AND type=\'weibo_follow\'')->save();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
/**
	 * 用户未微信数
	 * 
	 * @param int $uid 用户ID
	 * @return array
	 */
	public function getUnreadMessageCount($uid) {
		$map['to_uid']		= $uid;
		$map['is_read']		= 0;
		$map['deleted_by']	= array('neq', $uid);  //表示癿查诟条件就是deleted_by != 100
		return M('message')->where($map)->count();
	}
	
	

}
?>