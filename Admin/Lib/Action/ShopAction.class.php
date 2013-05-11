<?php
class ShopAction extends AdministratorAction{

	
	public function shop(){
		$sModel = new Model();
		$data = $this->allModel->query("SELECT * FROM wo_shelve");
		$this->assign('res',$data);
		$this->display();
	}
	
	//  编辑上架的物品
	public function editShelve(){
		$id     = intval($_GET['uid']);
		if (empty($id)) $this->error('参数错误!');
		$flag = $this->allModel->query("SELECT * FROM wo_shelve WHERE goods_id = $id ");
		if($flag){
			$this->assign('g',$flag);
		}
		else $this->error('没有找到相应的数据!');
		$this->display();
	}
	
	//  编辑提交
	public function doEditShelve(){
		$id     = intval($_POST['uid']);
		if (empty($id)) $this->error('参数错误!');
		$name   = $_POST['name'];	
		$detail = $_POST['detail'];
		$isSale = $_POST['isSale'];
		$required_field = array(
		         name     => '商品名称',
		         detail   =>'商品信息',
		         isSale   =>'状态',
		);
		foreach ($required_field as $key=>$value){
			if (empty($_POST[$key])) $this->error($value.'不能为空!');
		}
		$flag = $this->allModel->execute("UPDATE wo_shelve SET goods_name = '$name',goods_detail = '$detail',is_Sale = $isSale WHERE goods_id = $id");
		if($flag==1){
			$this->success('修改成功!');
		}
		else $this->error('修改失败!');
		
	}
	
	// 删除上架的宝贝
	public function doDeleteShelve(){
		$boxs =array();
		//  从表单传过来的要删除id数组
		$boxs = $_POST['checkbox']?$_POST['checkbox']:$boxs =array(0=>$_GET['id']);
		if (empty($boxs)) $this->error('没有任何参数!');
		$flag = 1;
		for($i=0;$i<count($boxs);$i++){
			// delete子句不可以定义别名
		    $flag =  $this->allModel->execute("DELETE FROM wo_shelve  WHERE goods_id = $boxs[$i]");
		    if($flag==0)break;
		}
		if($flag==1) $this->success('删除成功!');
		else $this->error('删除失败!');
		
	}
	// 搜索宝贝界面
	public function searchGoods(){
		$this->display();
	}
	
	//  搜索宝贝
	public function doSearchGoods(){
		// 定义查询语句字符串
		$querys ="SELECT * FROM wo_shelve WHERE (1=1)";
		// 卖家
		if ($_POST['uname']){
			$querys.="AND user_id IN(SELECT user_id FROM wo_user WHERE username LIKE '%".$_POST['uname']."%')";
		}
		// 卖家
		if ($_POST['bname']){
			$querys.="AND buy_id IN(SELECT user_id FROM wo_user WHERE username LIKE '%".$_POST['bname']."%')";
		}
		if($_POST['name']){
			$querys.="AND goods_name  LIKE \"%". $_POST['name']."%\"";
		}
		if ($_POST['detail']){
			$querys.="AND goods_detail LIKE \"%". $_POST['detail']."%\"";
		}
		if ($_POST['time']) {
			
			$querys.='AND shelve_time ='.$_POST['time'];
		}
		if($_POST['isSale']){
			$querys.='AND is_Sale = '.$_POST['isSale'];
		}
		$data = $this->allModel->query($querys);
		$this->assign('res',$data);
		$this->display('shop');
	}

// 商城统计
Public function statistics(){
	//1交易成功2待售3谈判中
	 $data = array();
	//1
	 $data['success'] = D('Shelve')->queryNumber(1);
	 //2
	 $data['onSale']  = D('Shelve')->queryNumber(2);
	 //3
	 $data['consult'] = D('Shelve')->queryNumber(3);
	 //商品总数
	 $data['all']     = D('Shelve')->queryNumber(4);
	 //dump($data);
	 $this->assign('data',$data);
	 
	
	  $this->display();
	
	
}
}
?>
