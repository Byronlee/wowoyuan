<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/style/public.css" /> 
<script type="text/javascript" src="__PUBLIC__/javascript/jquery-1.4.2.min.js"> </script>
<meta http-equiv="Refresh" content="<?php echo ($waitSecond); ?>,<?php echo ($jumpUrl); ?>">
<title>error</title>
<script type="text/javascript">
function init(){
$(".setAva-center").css("margin-top",($(window).height())/5+"px");
}
</script>
</head>

<body>

<body id="success-error">


<div class="setAva-center">
<div class="user">To:尊敬的用户</div>
 <div class="message-error"><?php if(($message)  ==  ""): ?>您访问的页面不存在或已被删除<?php else: ?><?php echo ($message); ?>,3秒后将自动跳转,如果不想等待请<a style="text-decoration:none" href="<?php echo ($jumpUrl); ?>">点击这里</a><?php endif; ?></div>
 <div class="from">From:窝窝园</div>
</div>
</body>
</html>