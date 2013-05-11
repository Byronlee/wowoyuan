<?php
class FlashAction extends AdministratorAction{
	
	//  闪存首页 
	public function index(){
		$data = D('FlashView')->select();
		//dump(M('Flash'));
		$this->assign('list',$data);
		$this->display();
	}
	
	
	//  连接到搜索页面
	public function searchFlash(){
		$this->display();
	}
	
	// 进行多条件搜索操作
	public function doSearchFlash(){
		// 采用原生态SQL语句
		// 存放SQL语句
		// (1=1) 辅助条件
		$querys='select* from wo_flash where (1=1)';
		// 实例化一个model对象 没有对应任何数据表
		$fModel = new Model();
		//  闪存id
		$fid  = $_POST['fid'];
		// 用户id
		$uid  = $_POST['uid'];
		//  闪存内容
		$content = $_POST['content'];
		if($fid){
			$querys.= 'AND(flash_id ='. $fid.')';
		}
		if ($uid&&$fid==''){
			$querys.='AND(user_id ='.$uid.') ';
		}
		if($content){
			$querys.='AND(flash_body LIKE \'%'.$content.'%\')';
		}
		$data = $fModel->query($querys);
		//dump($data);
		$this->assign('list',$data);
		$this->display('index');
		
		
	}
	//   使用按钮 删除数组
	public function deleteFlash(){
		//  一定要定义为数组
		$flashs = array();
		// checkbox为表单中复选框的数组
		$flashs = $_POST['checkbox'];
		if ($flashs){
	for($i=0;$i<count($flashs);$i++){
    	   $temp = M('Flash')->where("flash_id = $flashs[$i]")->delete();
    	   if($temp){
    	   	// flag用来判断是否全部删除成功
    	     $flag = true;
    	    }
    	    else $flag =false;
    	}
    	if($flag){
      $this->success('删除成功');
      $this->assign('jumpUrl', U('Flash/index'));
      $this->assign('waitSecond',5);
    	}
    	else $this->error('删除失败!');
    }
    else $this->error('参数错误!');
    }

	//  使用连接删除闪存
	public function doDeleteFlash(){
		$flash = $_GET['id'];
		if ($flash){
			$temp = M('Flash')->where("flash_id = $flash") ->delete();
			if($temp){
				$this->success('删除成功');
				$this->assign(jumpUrl,'Flash/index');
				//$this->assign(waitSecond,'80');
			}
			else{
				$this->error('删除失败');
			}
		}
		else {
		$this->error('参数错误!');
		}
		
	}
	// 闪存统计
	public function statistics(){
		$number = D('Flash')->queryNumber(1);
		$this->assign('data',$number);
		$this->display();
		
	}

}
?>
