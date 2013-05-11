<?php
class AdministratorAction extends Action {
	private $mid;
	private $uid;
	private $user;
	public  $allModel;
	
	public function _initialize()
	{
		
		$this->initUser();
		// 实例化模型,连接数据库
		$this->allModel = new Model();
		
		// 检查用户是否登陆管理后台, 有效期为$_SESSION的有效期
		if (!isLoggedAdmin())
			redirect( U('Public/index') );

	}
	
	//  测试使用
//	function __construct(){
//		echo '2';
//	}
	
/**
     +----------------------------------------------------------
     * 初始化当前登录用户信息
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     */
	protected function initUser()
	{
		//  $_REQUEST可以获取包含$_GET $_COOKIE $_POST在内的所有值。
		$this->mid = intval($_SESSION['mid']);
	

		if ($this->uid == 0)
			$this->uid = $this->mid;
		
		// 赋值当前用户
		$this->user	= $_SESSION['uname'];
	
		
		$this->assign('mid',$this->mid);
		$this->assign('uid',$this->uid);
		$this->assign('user',$this->user);
		
	
	}
	
}
?>