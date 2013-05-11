<?php
//  视图模式在定义的时候切记类名应该是****ViewModel
class FlashViewModel extends ViewModel{
	public $viewFields = array(
	         'Flash'   => array('flash_id','user_id','flash_body','flash_comment_time','posttime','_type'=>'LEFT'),
	         'User'    => array('user_id','username','_on'=>'Flash.user_id = User.user_id'),
	
	);
	
	
}
