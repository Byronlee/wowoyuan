<?php
class NotifyAction extends   CommonAction{
	
	
	/**
	 * 用户对用户发送通知
	 * @param string|int|array $receive 接收人ID 多个时以英文的","分割或传入数组
	 * @param string           $type    通知类型, 必须与模版的类型相同, 使用下划线分割应用. 
	 * 					   				如$type = 0 表示系统通知，  1表示粉丝通知
	 * @param array            $data
	 * @param int              $from    发送人ID
	 * * @param $mid     是当前登录用户
	 * @return void
	 */
	public function send($form, $receive_id,$type) {
		D('Notify')->__put($form, $receive_id,$type);
	}
	
	
	
	
	/**
	 * 系统对用户发送通知
	 * @param string|int|array $receive 接收人ID 多个时以英文的","分割或传入数组
	 * @param string           $type    通知类型, 必须与模版的类型相同, 使用下划线分割应用. 
	 * 					   				如$type = "weibo_follow"定位至/apps/weibo/Language/cn/notify.php的"weibo_follow"
	 * @param array            $data
	 * @return void
	 * * @param $mid     是当前登录用户
	 */
	public function sendIn( $receive , $type , $data ,$mid  ) {
		$this->__put( $receive , $type , $data  , 0 , true, $mid );
	}
	
	
	
	
	
	
	
	
	
}
?>