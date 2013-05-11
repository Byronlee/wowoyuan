<?php
class ForumAction extends AdministratorAction{
	
	
	//  微贴主页
	public function forum(){
	    $data = $this->allModel->query("SELECT * FROM wo_weitie");
	    $this->assign('data',$data);
		$this->display();
		
	}
	
	//  搜索微贴
    public function doSearchForum(){
    	$querys = "SELECT * FROM wo_weitie WHERE (1=1)";
    	if($_POST['content']){
    		$querys.="AND title LIKE '%". $_POST['content']."%'";
    	}
    	if ($_POST['stime']){
    		$querys.="AND ctime >= '".strtotime($_POST['stime'])."'";
    	}
    	if ($_POST['etime']){
    		$querys.="AND ctime <='".strtotime($_POST['etime'])."'";
    	}
        if ($_POST['name']){
             //  IN子句 	
    		$querys.="AND user_id IN (SELECT user_id FROM wo_user WHERE username LIKE '%".$_POST['name']."%')";
    	}
    	$data = $this->allModel->query($querys);
    	
    	$this->assign('data',$data);
    	$this->display('forum');
    }
    // 删除微贴
    public function doDeleteWeitie(){
    	if (empty($_POST['checkbox'])&&empty($_GET['id'])) $this->error('没有选中任何选项!');
    	$boxs =array();
		//  从表单传过来的要删除id数组
		$boxs = $_POST['checkbox']?$_POST['checkbox']:$boxs =array(0=>$_GET['id']);
		$flag = 1;
		for($i=0;$i<count($boxs);$i++){
			// delete子句不可以定义别名
		    $flag =  $this->allModel->execute("DELETE FROM wo_weitie  WHERE weitie_id = $boxs[$i]");
		    if($flag==0)break;
		}
		if($flag==1) $this->success('删除成功!');
		else $this->error('删除失败!');
    	
    }
    
 


     public function statistics(){
     	 $data = $this->allModel->query("SELECT count(*) FROM wo_weitie");
     	 //dump($data);
     	 $this->assign('data',$data[0]['count(*)']);
     	 $this->display();
     }
}
?>