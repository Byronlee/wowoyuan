<?php 
class IndexAction extends AdministratorAction {
    //后台框架页
    public function index() {
    	$this->assign('channel', $this->_getChannel());
    	$this->assign('menu',    $this->_getMenu());
        $this->display();
    }
    
    //后台首页
    public function main() {
    	echo '<h2>这里是后台首页</h2>';
    	$this->display();
    }
    
    protected function _getChannel() {
    	return array(
    		'index'			=>	'首页',
    		'global'		=>	'全局',
    		'flash'		    =>	'闪存',
    	    'forum'		    =>	'微社',
    	    'shop'          =>  '商城',
    		'user'			=>	'用户',
    		'extension'		=>	'扩展',
    	);
    }
    
    
    //   将menu数组返回
    protected function _getMenu() {
    	$menu = array();
    	// 后台管理首页
    	$menu['index'] 		=   array(
    		    '首页'			=>	array(
    			'首页'		=>	U('Home/statistics'),
    			
    		),
    	);
    	
    	//全局
    	$menu['global'] 	=   array(
    		'全局配置'		=>  array(
    			'站点配置'	=>	U('Global/siteopt'),
    			'注册配置'	=>	U('Global/register'),
    			'表情管理'	=>	U('Global/expression'),	
    	        '建议管理'	=>  U('Global/advise'),	
    			
    		),
    	);
    	
    	//闪存
    	$menu['flash'] 	=   array(
    		'闪存管理'		=>  array(
    			'闪存列表'	=>	U('Flash/index'),  			
    			'搜索闪存'	=>	U('Flash/searchFlash'),
    	        '闪存统计'   => U('Flash/statistics')
    			
     		
    		),
    	);
    	
    	//论坛
    	$menu['forum'] 	=   array(
    		'微社管理'		=>  array(
    			'微帖列表'	=>	U('Forum/forum'),
    			'搜索微贴'	=>	U('Forum/searchForum'),  			
    		
    	        '微贴统计'  =>  U('Forum/statistics'),
    			
    		),
    	);
    	
    	//商城
    	$menu['shop'] 	=   array(
    		'商城管理'		=>  array(
    			'宝贝列表'	=>	U('Shop/shop'),
    			'搜索宝贝'	=>	U('Shop/searchGoods'),  
    	        '商城统计'	=>  U('shop/statistics'),		
    			
    		),
    	);
    	
    	//用户
    	$menu['user']		=	array(
    		'用户'			=>	array(
    			'用户管理'	=>	U('User/user'),
    	        '用户搜索' =>  U('User/searchUser'),
    			
    			
    			
    		),
    		
    	);
	
    	//  扩展
    	$menu['extension']	=	array(
    		'工具'			=>	array(
    			
    			'缓存更新'	=>	U('Tool/cleanCache'),   			
    			
    			
    		),
    	
    	);
    	
    	return $menu;
    }
}