<?php 
class UserAction extends AdministratorAction {
    
    /** 用户 **/
    
    //用户管理
    public function user() {
   	    $dao = D('User', 'home');
   	    $res = $dao->order('user_id DESC')->select();
    	$this->assign('res',$res);
        $this->display();
    }
    
   
    //编辑用户
    public function editUser() {
    	$_GET['uid']  = intval($_GET['uid']);
    	if ($_GET['uid'] <= 0) $this->error('参数错误');
    	// $map
    	$map['user_id']	= $_GET['uid'];
    	$user = M('user')->where($map)->find();
    	if(!$user) $this->error('无此用户');
    	$this->assign('u',$user);
    	$this->display();
    }
    
    public function doEditUser() {
    	//参数合法性检查
    	$_POST['uid']	= intval($_POST['uid']);
    	
			$required_field = array(
				'uid'		=> '指定用户',
				'username'		=> '姓名',);
			//  检查是够为空
			foreach ($required_field as $k => $v) {
				if ( empty($_POST[$k]) ) $this->error($v . '不可为空');
			}
			//  检查密码
			if ( !empty($_POST['password']) && strlen($_POST['password']) < 6 || strlen($_POST['password']) > 16 ) {
				$this->error('密码必须为6-16位');
			}
    	//  mb_strlen和strlen计算长度不同 
    	if( mb_strlen($_POST['username'],'UTF8') > 10 ) {
			$this->error('昵称不能超过10个字符');
		}
		//保存修改
		$key   			 = array('username','user_gender','userlock','isAdmin');
		$value 			 = array( $_POST['username'], $_POST['user_gender'], $_POST['userlock'],$_POST['userGroup']);
		//  自动加载在数组最后
		if ( !empty($_POST['password']) ) {
			$key[]   	 = 'password';
			$value[] 	 = md5($_POST['password']);
		}
		$map['user_id']	= $_POST['uid'];
		// 通过用户id获得修改的字段
		$data[] = M('User')->where($map)->field('user_id,mailadres,password,username,isAdmin,user_gender,userlock')->find();
		//  setField(field,value,condition='') 设置记录的某个字段值
		$res = M('user')->where($map)->setField($key, $value);
		$this->assign('jumpUrl', U('User/user'));
		 $this->assign('waitSecond',5);
		$this->success('保存成功');
    }
    
    // 点击按钮删除用户
    public function doDeleteUser() {
    	$ids = array();
    	$ids = $_POST['checkbox'];
    	if($ids){
    //  注意:PHP中计算数组长度不是length而是count或者sizeof
    //  "user_id = $ids[$i]"双引号!
    	for($i=0;$i<count($ids);$i++){
    	   $temp = M('User')->where("user_id = $ids[$i]")->delete();
    	   if($temp){
    	   	// flag用来判断是否全部删除成功
    	     $flag = true;
    	    }
    	    else $flag =false;
    	}
    	if($flag){
      
      $this->assign('jumpUrl', U('User/user'));
      $this->assign('waitSecond',2);
      $this->success('删除成功');
      
    	}
    	else $this->error('删除失败!');
    }
    else $this->error('参数错误!');
    }
    
    //  点击连接删除用户
    public function deleteUser(){
    	$id = $_GET['id'];
    	if(!empty($id)){
    		$temp = M('User')->where("user_id = $id")->delete();
    		if ($temp){
    			
    			$this->assign('jumpUrl', U('User/user'));
    			$this->assign('waitSecond',2);
    			$this->success('删除成功');
    		}
    		else $this->error('删除失败!');
    	}
    	else $this->error('参数错误!');
    }
    
    
    //
    public function searchUser(){
    	$this->display();
    }
    
    //搜索用户
    public function doSearchUser() {
    	$keywords = $_POST['keywords'];
    	$type     = $_POST['select'];
    	$data     = '';
    	if(!empty($keywords)&&!empty($type)){
    	
    		// type等于用户名
    		if($type==1){
    			$condition['username'] = array('like',"%$keywords%");
    			$data = M('User')->where($condition)->select(); 
    			//dump(M('User'));	   			
    		}
    		//  用户等于ID,只能用相等查询
    		if($type == 2){
    			$data = M('User')->where("user_id =$keywords")->select();
    		}
    		//  用户昵称搜索
    		if ($type ==3) {
    			$cond['mailadres'] = array('like',"%$keywords%");
    			$data = M('User')->where($cond)->select(); 
    		}
    		
    		$this->assign('res',$data);
    		$this->display('user');
    	}
    	else{ 
         echo '参数错误!';
    	 $this->error();
    	}
    }
    
   
    
    //用户等级
    public function level() {
    	echo '<h2>这里是用户等级</h2>';
        //$this->display();
    }
  
	
	private function __isValidRequest($field, $array = 'post') {
		$field = is_array($field) ? $field : explode(',', $field);
		$array = $array == 'post' ? $_POST : $_GET;
		foreach ($field as $v){
			$v = trim($v);
			if ( !isset($array[$v]) || $array[$v] == '' ) return false;
		}
		return true;
	}
}
?>