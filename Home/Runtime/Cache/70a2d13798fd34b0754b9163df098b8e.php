<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>上传头像</title>
   <script>
	var _PUBLIC_  = '__PUBLIC__';
	var SITE_URL  = '<?php echo SITE_URL;?>'; 
</script>
  <link rel="stylesheet" type="text/css" href="__PUBLIC__/style/register.css" />
   <link rel="stylesheet" type="text/css" href="__PUBLIC__/style/shancun_public.css"/>
<script type="text/javascript" src="__PUBLIC__/javascript/jquery-1.4.2.min.js"></script> 
   <script type="text/javascript" src="__PUBLIC__/javascript/jquery.form.js"></script>
   <script type="text/javascript" src="__PUBLIC__/javascript/jquery.Jcrop.js"></script>
   <link rel="stylesheet" href="__PUBLIC__/style/jquery.Jcrop.css" type="text/css" />
 </head>
 <script type="text/javascript" language="JavaScript">

</script>
 <body>
 <div class="content_all">
             <div class="reg_head">
                     <div class="logo"></div>
            </div>
            <div class="reg_right"> 
              <div class="btn_login">已有帐号，直接登录<br /><a href="<?php echo SITE_URL;?>url=login">登录</a></div>
                <div class="scoll">
                 <strong>他们在这里</strong><br />
                   <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><div class="Euser"><img src="<?php echo (getUserFace($vo["user_id"],'m')); ?>"/>
                                   <div class="user_in">
                                    <span class=username><?php echo ($vo["username"]); ?></span><br />
                                    <span class=us><?php echo ($vo["profession"]); ?></span><br /> 
                              <span class=us><?php echo ($vo["academy"]); ?></span>
                                </div>
                      </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>

            </div>
     <div  class="reg_pic_left">                        
           <p style="margin-top:127px">欢迎您加入<span>窝窝园</span>，———<strong>上传头像，注意头像是否清晰</strong></p>       
           <form class="selectpic" action="<?php echo U('Index/avatar',array('type'=>'upload'));?>" method="post" enctype="multipart/form-data" id="form1">
            <span>修改头像</span>
            <input  type="file" class="upload" name="uping" onchange="up()" id="uping" /><br />
            <p>仅支持JPG、GIF、PNG图片文件，且小于5M</p>
            </form>
                       <div class="upload_img" >
                       <div id="yulan"><span>预览</span></div>
                          <table  id="photo" class="same">
                          <tr>
                          <td align="center" id="photo_1">
                          <img id="crop_preview1" src="/Public/images/uploads/avatar/default/default.png" />
                          </td>                       
                          </tr></table>
                         <div id="pre">
                         <span id="previewImg1" class="same"><img id="crop_preview1" src="__PUBLIC__/images/uploads/avatar/default/default_big.gif" /></span><br />
                         <span id="previewImg2" class="same"><img id="crop_preview2" src="__PUBLIC__/images/uploads/avatar/default/default_middle.gif" /></span><br />
                        <span id="previewImg3" class="same"><img id="crop_preview3" src="__PUBLIC__/images/uploads/avatar/default/default_small.gif" /></span><br />
                       </div>
                     </div>
                <form action="<?php echo U('Index/avatar',array('type'=>'save'));?>" method="post" id="form2" >
                       <input type="hidden" name="pic_url" />
                       <input type="hidden" name="x1" />
                       <input type="hidden" name="y1" />
                       <input type="hidden" name="x2" />
                       <input type="hidden" name="y2" />
                       <input type="hidden" name="w" />
                       <input type="hidden" name="h" />
                       <input type="submit" value="保存" />

              </form>
            </div>
 </div>          
 </body>
</html>