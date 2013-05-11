<?php
//  路由定义文件  ,查看官方手册URL路由
/***********************************************************
 * 2.0版不支持URL_ROUTE_RULES配置，必须建立routes.php文件
 Return Array(       
                    第一种方式 常规路由       
 'RouteName'=>array('路由定义','[分组/]模块/操作名', '路由对应发量','额外参数'),       
                     第二种方式 泛路由       2.1版本开始取消泛路由定义,改成了正则路由定义方式
 ‘RouteName@’=>array(       
        array('路由定义','[分组/]模块/操作名', '路由对应变量','额外参数'),       
),       
…更多的路由名称定义       
)     
*************************************************************/
return array(
   //注册
   array('Reg','Public/register','',''),
   //登录,这个有好处
   array('login','Public/index','',''),
   array('url=login','/Public/index','',''),
   array('','/Public/index','',''),
   
   //注册后上传头像
   array('uphead','Public/upload_head','',''),
    
   //闪存
   array('url=flash','ShanCun/index','',''),
   //微社
   array('url=forum','Forum/index','',''),
   //商场
   array('url=trade','Trade/index','',''),
   //屏蔽其他浏览器
   array('sorry','Public/checkout','',''),
   array('forgetpw','Public/forgetpw','',''),
   
   array('experience','Public/new_user','',''),
   
   
      
    array('out','Public/loginout','',''),
    array('error','Public/error','',''),   
     //主页
   array('url=home','Index/home','',''),
)
?>