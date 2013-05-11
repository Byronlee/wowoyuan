<?php
class PublicAction extends Action{
	public function index(){
		$this->display('login');
	}
	
	// 检查登录
	public function doAdminLogin(){
	    $uModel = new Model();
		// 数据检查
		if ( empty($_POST['password']) ) {
			$this->error('密码不能为空');
		}
		
		// && ! isValidEmail($_POST['email'])
		if (! isset($_POST['email'])  ) {
			$this->error('email格式错误');
		}

		// 检查帐号/密码
		
		if (isset($_POST['email'])) {
			$flag = $uModel ->query("SELECT user_id,username,password,isAdmin,userlock FROM wo_user WHERE mailadres =\"". $_POST['email']."\"");
			if (empty($flag)){
				$this->error('用户不存在!');
			}
			if ($flag[0]['password']!=md5(md5($_POST['password'])+md5($_POST['email']))){
				$this->error('密码错误!');
			}
			else if($flag[0]['isAdmin']!=1){
				
				$this->assign('jumpUrl',U('Public/index'));
				$this->assign('waitSecond',3);
				$this->error('尊敬的'.$flag[0]['username'].'用户,你没有权限登录后台!');
			}
		         else if ($flag[0]['userlock']==1){
		         	$this->assign('jumpUrl',U('Public/index'));
				    $this->assign('waitSecond',3);
		         	$this->error('尊敬的'.$flag[0]['username'].'用户,你已经被锁定,请联系管理员!');
		         }
				else{
				$_SESSION['isAdmin'] = 1;
				$_SESSION['uname']   =$flag[0]['username'];
				$_SESSION['mid']     =$flag[0]['user_id'];
				// 记录后台管理员的登录信息,暂时空置   
				//$this->recordLogin($flag[0]['user_id']);
				$this->assign('jumpUrl', U('Index/index'));
				$this->assign('waitSecond',1);
			    $this->success('尊敬的'.$flag[0]['username'].'管理员,欢迎进入后台管理!');
				
			}		
	
		}else {
			$this->error('参数错误');
		}

	}
	
	

	// 退出
	public function logoutAdmin(){
		unset($_SESSION['mid']);
		unset($_SESSION['uname']);
		unset($_SESSION['isAdmin']);
		$this->assign('jumpUrl',U('Public/index'));
		$this->success('成功退出!');
	}
	
	/**
	 * 记录登录信息
	 * 写入公共函数
	 * @param int $uid 用户ID
	 */
 function recordLogin($uid)
	{
		$data['uid']	= $uid;
		$data['ip']		= get_client_ip();
		$data['place']	= convert_ip($data['ip']);
		$data['ctime']	= time();
		M('logindt')->add($data);
	}
}
?>