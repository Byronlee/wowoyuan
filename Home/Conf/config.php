<?php
$config = require 'config.inc.php';
$array =  array(
     'APP_DEBUG'             =>'',	// 是否开启调试模式
		/*配置系统权限 */
    'USER_AUTH_ON'          =>true,                    //是否开启RBAC
	'USER_AUTH_TYPE'	    =>2,		// 默认认证类型 1 登录认证 2 实时认证
	'USER_AUTH_KEY'			=>'id',	// 用户认证SESSION标记
    'ADMIN_AUTH_KEY'	    =>'administrator',
	'USER_AUTH_MODEL'		=>'user',	// 默认验证数据表模型
	'AUTH_PWD_ENCODER'		=>'md5',	// 用户认证密码加密方式
	'USER_AUTH_GATEWAY'	    =>'/Public/index',	// 默认认证网关
	'NOT_AUTH_MODULE'		=>'Public',		// 默认无需认证模块
	'REQUIRE_AUTH_MODULE'   =>'',		// 默认需要认证模块
	'NOT_AUTH_ACTION'		=>'index',		// 默认无需认证操作
	'REQUIRE_AUTH_ACTION'   =>'',		// 默认需要认证操作
    'GUEST_AUTH_ON'         => false,    // 是否开启游客授权访问
    'GUEST_AUTH_ID'         =>    0,     // 游客的用户ID
	'SHOW_RUN_TIME'         =>true,			// 运行时间显示
	'SHOW_ADV_TIME'         =>true,			// 显示详细的运行时间
	'SHOW_DB_TIMES'         =>true,			// 显示数据库查询和写入次数
	'SHOW_CACHE_TIMES'      =>true,		// 显示缓存操作次数
	'SHOW_USE_MEM'          =>true,			// 显示内存开销
    'DB_LIKE_FIELDS'        =>'title|remark',
    'RBAC_ROLE_TABLE'       =>'wowoyuan_role', //角色表
	'RBAC_USER_TABLE'	    =>'wowoyuan_role_user', //用户角色明细表
	'RBAC_ACCESS_TABLE'     =>'wowoyuan_access',  //权限表
	'RBAC_NODE_TABLE'	    =>'wowoyuan_node',   //节点表
	

	 /* URL设置 */
	'URL_ROUTER_ON'         =>true,        // 启用URL路由功能 
	//'URL_MODEL'             =>2,
	
    'TMPL_CACHE_TIME'		=>	-1, 




    /* 默认设定 */
    'DEFAULT_APP'           => '@',     // 默认项目名称，@表示当前项目
    'DEFAULT_GROUP'         => 'Home',  // 默认分组
    'DEFAULT_MODULE'        => 'public', // 默认模块名称
    'DEFAULT_ACTION'        => 'index', // 默认操作名称
    'DEFAULT_CHARSET'       => 'utf-8', // 默认输出编码
    'DEFAULT_TIMEZONE'      => 'PRC',	// 默认时区
    'DEFAULT_AJAX_RETURN'   => 'JSON',  // 默认AJAX 数据返回格式,可选JSON XML ...
    'DEFAULT_THEME'         => 'default',	// 默认模板主题名称
    'DEFAULT_LANG'          => 'zh-cn', // 默认语言

);
return array_merge($config,$array);
?>