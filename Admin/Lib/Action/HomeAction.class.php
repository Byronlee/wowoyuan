<?php
class HomeAction extends AdministratorAction
{
	// 统计信息
	public function statistics()
	{
		$statistics = array();
		
		/*
		 * 重要: 为了防止与应用别名重名，“服务器信息”、“用户信息”、“开发团队”作为key前面有空格
		 */
		
		// 服务器信息	
        $serverInfo['服务器系统及PHP版本']	= PHP_OS.' / PHP v'.PHP_VERSION;
        $serverInfo['服务器软件'] 			= $_SERVER['SERVER_SOFTWARE'];
        
        $mysqlinfo = M('')->query("SELECT VERSION() as version");
        $serverInfo['MySQL版本']			= $mysqlinfo[0]['version'] ;
        
        $t = M('')->query("SHOW TABLE STATUS LIKE '".C('DB_PREFIX')."%'");
        foreach ($t as $k){
            $dbsize += $k['Data_length'] + $k['Index_length'];
        }
        $serverInfo['数据库大小']			= byte_format( $dbsize );
        $statistics[' 服务器信息']          = $serverInfo;
        unset($serverInfo);
        
        // 用户信息
        $user['当前在线'] = getOnlineUserCount();
        $user['全部用户'] = M('user')->count();
        $user['有效用户'] = M('user')->where('`userlock` = 0')->count();
        $statistics[' 用户信息'] = $user;
        unset($user);

        
        // 开发团队
        $statistics[' 开发团队'] = array(
        	'版权所有'	=> 'NOON工作室',
        	'开发团队'	=> 'NOON工作室',
        );
        
        $this->assign('statistics', $statistics);
        $this->display();
	}
	
}