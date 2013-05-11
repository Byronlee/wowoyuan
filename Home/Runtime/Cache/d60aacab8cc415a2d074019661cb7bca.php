<?php if (!defined('THINK_PATH')) exit();?><!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>微贴-与我相关</title>
     <script>
	var _PUBLIC_  = '__PUBLIC__';
	var SITE_URL  = '<?php echo SITE_URL;?>'; 
   </script>
       <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/style/css_3.css">    
        
         <script language=JavaScript>        
          function deletedweitie(id){
    	   apprise('确定删除这一篇微贴？', {'confirm':true},function(r){		
				if(r){		
					$.post(SITE_URL+"Forum/deletedweitie",{weitie_id:id},function(txt){		
						   window.location.reload();
						});
				}	
			})
       }
       function re_xiugai(id,md){
    	    apprise('确定要修改此篇微贴？', {'confirm':true},function(r){		
				if(r){		
				window.location.href=SITE_URL+"Forum/wt_publish/_t_y/"+id+"/x_id/"+md;
				}	
			})
       }             
       </script>
  </head>
  <body>
        <!-- layout::public:header::60 -->
      <div class="forum_in_center">
    <div class="in_left_all">
        <div class="hh"></div>
        <div class="in_left">
              <div class="menu"> <a href="__URL__/wt_me/t_y_p/my" class="<?php if(($t_y_p)  ==  "my"): ?>menu_on<?php endif; ?>">我的微贴</a><a href="__URL__/wt_me/t_y_p/comment_me" class="<?php if(($t_y_p)  ==  "comment_me"): ?>menu_on<?php endif; ?>">最新评论</a><a href="__URL__/wt_me/t_y_p/pt_me" class="<?php if(($t_y_p)  ==  "pt_me"): ?>menu_on<?php endif; ?>">我的参与</a></div>
              <div class="in_left_content" style="margin-top:12px;">             
              <?php if(is_array($content)): $i = 0; $__LIST__ = $content;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><?php if(($t_y_p)  ==  "comment_me"): ?><div class="every1">
             <span> <?php if(empty($vo['last_comment_user_id'])): ?><span class="no_comment_user">没找到该用户</span><?php else: ?><?php echo (getUserSpace($vo["last_comment_user_id"],uname)); ?><?php endif; ?>
            对帖子：
           </span>                   
                              
              <div class="title"><a target="_blank"  href="<?php echo U('Forum/ewt_display',array('s_t_y'=>$vo['weitie_id'],'w_t'=>md($vo['weitie_id'])));?>"  title="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></a></div>                     
                                   给了新回复：     

   
              </div>
              
              
              
              <?php else: ?>
              
              
              <div class="every1">
                        <div class="title"><img src="__PUBLIC__/images/button/topic.gif" /><a target="_blank" class='<?php if(($t_y_p)  ==  "comment_me"): ?><?php if(($vo['last_comment_is_read'])  ==  "1"): ?>no_read<?php endif; ?><?php endif; ?>' href="<?php echo U('Forum/ewt_display',array('s_t_y'=>$vo['weitie_id'],'w_t'=>md($vo['weitie_id'])));?>"  title="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></a><?php if(($vo['is_photo'])  ==  "1"): ?>&nbsp;<img src="__PUBLIC__/images/button/image_s.gif" title="附有图片" style="margin-left:7px;"/><?php endif; ?></div>                     
                        <table class="show1">
                            <tr>                                
                                <td >
                                
                                <div class="wt_uname">
                                <?php if(($t_y_p)  ==  "my"): ?>&nbsp;&nbsp;
                                <input type="hidden" value="<?php echo (md($vo["weitie_id"])); ?>" id="x_id">
                                  <a href="javascript:void(0)" onclick="deletedweitie(<?php echo ($vo["weitie_id"]); ?>,this)">删除</a>&nbsp;<a href="javascript:void(0)" onclick="re_xiugai(<?php echo ($vo["weitie_id"]); ?>,'<?php echo (md($vo["weitie_id"])); ?>')">修改</a>
                                <?php else: ?>                           
                                <?php if(empty($vo['last_comment_user_id'])): ?><span class="no_comment_user">没找到该用户</span><?php else: ?><?php echo (getUserSpace($vo["last_comment_user_id"],uname)); ?><?php endif; ?><?php endif; ?>                     
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><span><?php echo (friendlyDate($vo["ctime"])); ?></span></td>
                            </tr>
                        </table>
                               <!--   查看回复       -->
                        <div class="answ">                                  
                               <?php if(($t_y_p)  ==  "my"): ?>评论/阅读<br />(<?php echo ($vo["count_comment"]); ?>)/(<?php echo ($vo["read_times"]); ?>)
                                <?php else: ?>
                                                                                              最后回复:<br />(<?php echo ($vo["count_comment"]); ?>)/(<?php echo ($vo["read_times"]); ?>)<?php endif; ?>                       
                       </div>                                           
                   </div><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>                          
              </div>
        <div class="page_wowo" style="width:768px;text-align:center;height:40px;margin-top:35px;background-color:#fff;float:right;"><?php echo ($page); ?></div> 
        </div>
    </div>
    <div>
    <!-- layout::public:forum_right::60 -->
    </div>
      </div>
       <div  style=" width:100%; margin-top:15px;margin-bottom:10px;font-family: 黑体;font-size:13px;color:#2DABA6; text-align:center; float:left;">    
<p><?php echo ($site['sitename_EN']); ?> &copy; <?php echo ($site['regi_year']); ?> <?php echo ($site['siteowner']); ?> &nbsp;<a style="color:#2DABA6;" href="<?php echo U('Index/about');?>">关于窝窝园</a><?php echo ($site['site_icp']); ?>&nbsp;<img src="http://img.tongji.linezing.com/2788666/tongji.gif"></p>
</div>
  </body>
</html>