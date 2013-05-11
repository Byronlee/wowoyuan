<?php
class GlobalAction extends AdministratorAction {
	
	private $site;
	
	// 判断传过来数组是否全部为空!
	private function __isValidRequest($field, $array = 'post') {
		$field = is_array($field) ? $field : explode(',', $field);
		$array = $array == 'post' ? $_POST : $_GET;
		foreach ($field as $v){
			$v = trim($v);
			if ( !isset($array[$v]) || $array[$v] == '' ) return false;
		}
		return true;
	}
	
	/** 系统配置 - 站点配置 **/
	
	
	//  获得System表中的数据信息 
  public function getData(){
    $site_opt = M('System')->select();
	   foreach ( $site_opt as $key => $val ) {
				$this->site [$val ['name']] = $val ['contents'];
			}
  	$this->assign('site',$this->site);
  }
	//站点设置
	public function siteopt() {
		$this->getData();	
        $this->display();
	}
	
	//设置站点
	public function doSetSiteOpt() {
		if (empty($_POST)) {
			$this->error('参数错误');
		}
		
		$_POST['site_name']           		= $_POST['site_name'];
		$_POST['site_nameEN']		  		= $_POST['site_nameEN'];
//		$_POST['site_header_keywords']		= $_POST['site_header_keywords'];
//		$_POST['site_header_description']	= $_POST['site_header_description'];
//		
//		$_POST['site_closed_reason'] 		= $_POST['site_closed_reason'];
		$_POST['site_icp']  		 		= $_POST['site_icp'];
		$_POST['site_closed']		 		= intval($_POST['site_closed']);
	
		
	//	$res = D()->execute('UPDATE wo_system SET  contents = '.$_POST['site_closed'].' WHERE id = 4');
		$this->modifySite($_POST['site_closed'], 4);
		$this->modifySite($_POST['site_name'], 1);
		$this->modifySite($_POST['site_nameEN'], 7);
		$this->modifySite($_POST['site_icp'], 10);
        $this->assign('jumpUrl', U('Global/siteopt'));
	    $this->success('保存成功');
	}
	private function modifySite($content,$id){
		$res = D()->execute("UPDATE wo_system SET contents = '".$content."' WHERE id = ".$id);
		
		if($res==1||$res==0){
			//$this->assign('jumpUrl', U('Global/siteopt'));
			//$this->success('保存成功');
		}
		else{
			dump($res);
			$this->error('保存失败');
		}
	}
	
	/** 系统配置 - 注册配置 **/
	
	public function register() {
		$this->getData();
		//$data = $sModel->query("select contents from wo_system where name = \"register_type\"");
		$this->assign('temp',$data);
	    $this->display();
	}
	
	public function doSetRegisterOpt() {
	    //  注册方式  1关闭注册  2邀请注册 3 公开注册(默认)
		$register_type= $_POST['register_type'];
		
		//   邀请方式
		$invite_set = $_POST['invite_set'];
		$sModel = new Model();
		$querysql = "UPDATE wo_system SET contents = $register_type WHERE name = \"register_type\"";
		$data   = $sModel->execute($querysql);
		$querys = "UPDATE wo_system SET contents = $invite_set    WHERE name = \"invite_set\"";
		// 当模版中的值没有改变的时候,会返回值0
		$data   = $sModel->execute($querys);
        //dump($data);
		if($data==1||$data==0){
			
			$this->success('保存成功');
		}else {
			$this->error('保存失败');
		}
	}
	
	

	
	
		
	/** 内容管理 - 表情管理 **/
	
	public function expression() {
		$expression = $this->allModel->query('SELECT * FROM wo_expression');
		$this->assign('data', $expression);
		$this->display();
	}
	
	public function addExpression() {
		// 在模版中现在类型为增加表情
		$this->assign('type', 'add');
		$this->display('editExpression');
	}
	
	public function doAddExpression() {
		if (!$this->__isValidRequest('title,type,emotion,filename')) {
			$this->error('数据不完整');
		}
         // 插入数据 
		$res = $this->allModel->execute('INSERT INTO wo_expression(title,type,emotion,filename) VALUES(\''.$_POST['title'].'\',\''.$_POST['type'].'\',\''.$_POST['emotion'].'\',\''.$_POST['filename'].'\')');
		if ($res) $this->success('保存成功');
		 else	  $this->error('保存失败');
	}

	public function editExpression() {
		// GET传值id
		$id      = intval($_GET['id']);
		$querys  = $this->allModel->query("SELECT * FROM wo_expression WHERE expression_id = $id"); 
	    // 返回的是二维数组 
		$this->assign('expression', $querys[0]);
		// 页面为编辑类型
		$this->assign('type', 'edit');
		$this->display();
	}

	public function doEditExpression() {
		if (!$this->__isValidRequest('expression_id,title,type,emotion,filename')) {
			$this->error('数据不完整');
		}
	    $res = $this->allModel->execute("UPDATE wo_expression SET title ='". $_POST['title']."',type ='". $_POST['type']."',emotion ='". $_POST['emotion']."',filename = '".$_POST['filename']."'WHERE expression_id = '".$_POST['expression_id']."'");
	  
		if ($res) {
			$this->assign('jumpUrl', U('Global/expression'));
			$this->success('保存成功');
		}else{
			$this->error('保存失败');
		}
	}
	
	public function doDeleteExpression() {
		$arrays =array();
		$arrays = $_POST['checkbox']?$_POST['checkbox']:$arrays = array(0=>$_GET['id']);
		// arrays为空
		if (empty($arrays)) $this->error('参数错误!');
		$flag = 1;
		foreach ($arrays as $value){
			$flag = $this->allModel->execute("DELETE FROM wo_expression WHERE expression_id = $value");
			if ($flag==0)break;
		}
		if ($flag==1)$this->success('删除成功!');
		else $this->error('删除失败!');
		
	}
	/**
	 * 
	 * 用户意见管理
	 * 
	 */
	public function advise(){
		$data = D('Database')->getAdvise();
		if(!empty($data)){
			$this->assign('data',$data);
		}
		else {
			$this->error("参数错误!");
		}
		$this->display();
	}
	
}