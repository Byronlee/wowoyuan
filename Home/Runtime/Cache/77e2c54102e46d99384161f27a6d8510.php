<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>注册</title>
   <script>
	var _PUBLIC_  = '__PUBLIC__';
	var SITE_URL  = '<?php echo SITE_URL;?>'; 
</script>
 <script type="text/javascript" src="__PUBLIC__/javascript/jquery-1.4.2.min.js"> </script>
 <script type="text/javascript" src="__PUBLIC__/javascript/jquery.form.js"></script>
 <script type="text/javascript" src="__PUBLIC__/javascript/js.js"></script>
 <link rel="stylesheet" type="text/css" href="__PUBLIC__/style/register.css" />
 <link rel="shortcut icon" href="__PUBLIC__/images/wo.png" type="image/x-icon" />
 <link rel="stylesheet" type="text/css" href="__PUBLIC__/style/shancun_public.css"/>
 </head>
 <body>
 <div class="content_all">
             <div class="reg_head">
                     <div class="logo"></div>
            </div>
            <div class="reg_right"> 
         
               <div class="btn_login">已有帐号，直接登录<br /><a href="<?php echo SITE_URL;?>url=login">登录</a></div>
              
                <div class="scoll">
                 <strong>他们在这里</strong><br />
                   <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><div class="Euser"><img src="<?php echo (getUserFace($vo["user_id"])); ?>"/>
                                     
                                   <div class="user_in">
                                    <span class=username><?php echo ($vo["username"]); ?></span><br />
                                    <span class=us><?php echo ($vo["profession"]); ?></span><br /> 
                                    <span class=us><?php echo ($vo["academy"]); ?></span>
                                    </div>
                      </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                      
            </div>
            <div  class="reg_left">                        
             <p>欢迎您加入<span>窝窝园</span>，请完成所有信息进行注册——<strong>我没有在窝窝园,就在窝窝圆的路上...</strong></p>            
                <form name="form" id="form" method="post" action="__URL__/doRegister">
                       <div id="email"><label>我的邮箱:</label><input type="text" name="email"  id="email"  /></div>
                       <div id="email"> <label>创建密码:</label><input type="password"" name="password"  id="password"  /></div>
                       <div id="email"><label>确认密码:</label><input type="password" name="repassword"  id="repassword"/></div>
                       <div id="email"><label>真实姓名:</label><input type="text" name="nickname"  id="nickname" /></div>   
                       
                                                             
   <label>所在学院:</label><select name="academy" id="academy" onChange="getProfession(this.options[this.selectedIndex].value)">
    <option value="信息科学与技术学院">信息科学与技术学院</option>
	<option value="美术学院">美术学院</option>
	<option value="文学与新闻传播学院">文学与新闻传播学院</option>
	<option value="外国语学院">外国语学院</option>
	<option value="经济政法学院">经济政法学院</option>
	<option value="电子信息工程学院">电子信息工程学院</option>
	<option value="信息科学与技术学院">信息科学与技术学院</option>

	<option value="生物产业学院">生物产业学院</option>
	<option value="管理学院">管理学院</option>
	<option value="工业制造学院">工业制造学院</option>
	<option value="城乡建设学院">城乡建设学院</option>
	<option value="旅游文化产业学院">旅游文化产业学院</option>
	<option value="体育学院">体育学院</option>
	<option value="国际教育学院">国际教育学院</option>

	<option value="师范学院">师范学院</option>
	<option value="艺术学院">艺术学院</option>
	<option value="医护学院">医护学院</option>
	<option value="学前教育学院">学前教育学院</option>
</select> <select name="profession" id="profession">

           <option value="计算机科学与技术">计算机科学与技术</option>
			<option value="软件工程">软件工程</option>
			<option value="网络工程">网络工程</option>
			<option value="数字媒体技术">数字媒体技术</option>
</select> 
    <select name="grade">
    <option value="2012">2012级</option>
	<option value="2011">2011级</option>
	<option value="2010">2010级</option>
	<option value="2009">2009级</option>
	<option value="2008">2008级</option>
	<option value="1">2008级以前</option>
</select><br />
                                                      <div id="sexall">性别:
	                                                      <label for="mal" >男 </label>  
	                                                      <input  type="radio" name="sex" value="male" id="mal" checked/>
	                                                      <label for="femal">女</label>
	                                                      <input  type="radio" name="sex" value="female" id="femal"/>
                                                      </div>  
                                                                                               
                                                    <div id="verify"><label>验证码:</label><input type="text" name="verify"  id="validateVerify" />&nbsp;&nbsp;&nbsp;
                                                                 <img id="verifyImg" style="margin-top:9px;" src="__URL__/verify" onClick="changeVerify()" title="点击刷新验证码" /><a href="javascript:void(0)" id="change">换一换</a></div>                                                                                                                                                                   
                                                                    <div id="submit"><input type="submit" name="submit" id="send" value="立即注册"/></div>                                                             
               </form>        
            </div>
           
 </div>
             
                   
            
 </body>
</html>