<?php
class ToolAction extends AdministratorAction {
	
	public function index() {
		echo '<h3>正在开发中...</h3>';
		$this->assign('name',$name);
	}
	

	
	
	// 清除缓存
	public function cleanCache(){
	$dirname = 'Admin/Runtime';
	$homeDirname ='Home/Runtime';
	
	$this->rmdirr($dirname);
	$this->rmdirr($homeDirname);
    
	echo "<div style='border:2px solid green; background:#f1f1f1; padding:20px;margin:20px;width:800px;font-weight:bold;color:green;text-align:center;'>\"".$value."\" have been cleaned clear! </div> <br /><br />";
    //  创建Runtime目录  @隐藏错误信息  0777最大可能的访问权限
	@mkdir($dirname,0777,true);
	@mkdir($homeDirname,0777,TRUE);

	}
	
	
	// 删除目录中的文件
	
function rmdirr($dirname) {
	

      //  判断文件是否存在
	if (!file_exists($dirname)) {
		return false;
	}

	if (is_file($dirname) || is_link($dirname)) {
		//  删除文件
		return unlink($dirname);
	}
    // 打开目录
	$dir = dir($dirname);
    // 读取目录中的文件
	while (false !== $entry = $dir->read()) {
     //  '.' 和 '..' 两个特殊的目录,表示当前目录和父目录
		if ($entry == '.' || $entry == '..') {
			continue;
		}
       //  例如:  Admin/Runtime/cache
		$this->rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
	}

	$dir->close();
     //  删除
	return rmdir($dirname);
}
	
	
}