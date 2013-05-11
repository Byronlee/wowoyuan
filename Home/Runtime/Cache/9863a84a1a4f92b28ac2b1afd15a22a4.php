<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>        
           <title><?php echo ($page_title); ?></title>    
            <script>
	var _PUBLIC_  = '__PUBLIC__';
	var SITE_URL  = '<?php echo SITE_URL;?>'; 
</script>             
          <link href="__PUBLIC__/style/stylesheep.css" rel="stylesheet" type="text/css" />
          <link href="__PUBLIC__/style/css.css" rel="stylesheet" type="text/css" />
          <link href="__PUBLIC__/style/home.css" rel="stylesheet" type="text/css" />      
          <script type="text/javascript" src="__PUBLIC__/javascript/js.js"></script>        
    </head>
    <body onload="bodyload()">
   

 <script>
	var _PUBLIC_  = '__PUBLIC__';
	var SITE_URL  = '<?php echo SITE_URL;?>'; 
</script>
     <script type="text/javascript" src="__PUBLIC__/javascript/jquery-1.4.2.min.js"></script> 
     <script type="text/javascript" src="__PUBLIC__/javascript/jq.js"></script> 
     <script type="text/javascript" src="__PUBLIC__/javascript/apprise-1.5.full.js"></script>
     <link rel="stylesheet" type="text/css" href="__PUBLIC__/style/apprise.css" />
     <link rel="shortcut icon" href="__PUBLIC__/images/wo.png" type="image/x-icon" />
	 <link rel="stylesheet" type="text/css" href="__PUBLIC__/style/shancun_layout.css"/> 
	 <link rel="stylesheet" type="text/css" href="__PUBLIC__/style/shancun_public.css"/>       
	 <script type="text/javascript" src="__PUBLIC__/javascript/flash.js"></script>       
	 <script type="text/javascript" src="__PUBLIC__/javascript/notice.js"></script> 
     <script type="text/javascript">
<!--
$(document).ready(function(){	   
    $('.set').live('mouseover',function(){
  	$(this).find('.set_con').show();
    });
    $('.set').live('mouseout',function(){
    	$(this).find('.set_con').hide();	
     });
});
-->
</script>        
        <div class="shancun_all_head">
            <div class="header"><!-- 头部 begin -->
                                     
                                  
                <div class="logo"><a href="<?php echo SITE_URL;?>url=home" >Wowoyuan</a></div>               
                <div class="nav">
                    <ul>
                        <li>
                            <a href="<?php echo SITE_URL;?>url=flash" class="fb14">闪存</a>
                        </li>
                        <li class="set">
                            <a href="<?php echo SITE_URL;?>url=forum" class="fb14">微社</a>
                             <div class="set_con">
                               <span><a href="<?php echo U('Forum/wt_me/t_y_p/my');?>">我的微贴</a></span><br />
                                <span><a href="<?php echo U('Forum/wt_me/t_y_p/comment_me');?>">最新评论</a></span><br />                                      
                                </div>
                         
                        </li>
                        <li class="set">
                            <a href="<?php echo SITE_URL;?>url=trade" class="fb14">商场</a>
                            <div class="set_con">
                               <span><a href="<?php echo U('Trade/manage/type/shelve');?>">最新上架</a></span><br />
                                <span><a href="<?php echo U('Trade/manage/type/I_shelve');?>">我的交易</a></span><br />
                               <span><a href="<?php echo U('Trade/shelve');?>">上架宝贝</a></span><br />            
                                </div>
                        </li>
                        <li class="set">
                            <a href="#" class="fb14">设置</a> 
                              <div class="set_con">
                               <span><a href="<?php echo U('Index/information');?>">基本信息</a></span><br />
                                <span><a href="<?php echo U('Index/setAccount');?>">帐号设置</a></span><br />
                               <span><a href="<?php echo U('Index/setAvatar');?>">修改头像</a></span><br />
                               <span><a href="<?php echo SITE_URL;?>out">退出</a></span> <br />              
                                </div>                  
                        </li>                     
                    </ul>
                   
                   
                    <form action="<?php echo U('Index/s_result');?>" id="quick_search_form" method="post">
                     <input type="hidden" id="hidden_input" name="tag" value=1/>
                        <div class="soso"><label id="_header_search_label" style="display: block;" onclick="$(this).hide();$('#_header_search_text').focus();">闪存/名字/宝贝/关键字</label><input type="text" class="so_text" value="" name="key" id="_header_search_text" onblur="if($(this).val()=='') $('#_header_search_label').show();"/><input name="" type="button" onclick="$('#quick_search_form').submit()" class="so_btn hand br3"/></div>
                        <script>
                            if($('#_header_search_text').val()=='')
                                $('#_header_search_label').show();
                            else
                                $('#_header_search_label').hide();
                        </script>
                    </form>
                </div>                                      
            </div>                                     
            </div>
        <div  id="home_center">                                           
                        <div class="home_left">
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <div class="content_right"> 
       <div class="user_head"><?php echo (getUserSpace($user[0]['user_id'],uvatar)); ?></div>
       <div class="user_info">
                                    <div class="username" style="margin-bottom:10px;width: 200px;text-align: left;">
                                     <?php if(isset($user["0"]["username"])): ?><?php echo ($user[0]['username']); ?><?php else: ?>未填写<?php endif; ?>
                                    
                                    </div><br/>
                                    <div class="us">
                                     <?php if(isset($user["0"]["profession"])): ?><?php echo ($user[0]['profession']); ?><?php else: ?>未填写<?php endif; ?>
                                    
                                    </div>
                                    <div class="us">
                                     <?php if(isset($user["0"]["grade_class"])): ?><?php echo ($user[0]['grade_class']); ?><?php else: ?>未填写<?php endif; ?>
                      
                                    </div>   
                                    <div class="us">
                                     <?php if(isset($user["0"]["academy"])): ?><?php echo ($user[0]['academy']); ?><?php else: ?>未填写<?php endif; ?>                                  
                                    </div>
                                    <div class="LR">
                                     <span class="lineR"><a href="<?php echo U('Space/follow',array('type'=>'following', 'uid'=>$uid,'ui_'=>md($uid)));?>"><strong><?php echo ($user[0]['following']); ?></strong><br />关注</a></span>
                                     <span class="lineR"><a href="<?php echo U('Space/follow',array('type'=>'follower', 'uid'=>$uid,'ui_'=>md($uid)));?>"><strong><?php echo ($user[0]['follower']); ?></strong><br />粉丝</a></span>
                                     <span class="lineR"><a href="<?php echo U('space/index',array('uid'=>$uid,'type'=>'flash','ui_'=>md($uid)));?>"><strong id="miniblog_count"><?php echo ($user[0]['flashs']); ?></strong><br />闪存</a></span>
                                     <span class="lineR ov"><a href="<?php echo U('space/index',array('uid'=>$uid,'type'=>'weitie','ui_'=>md($uid)));?>"><strong id="miniblog_count"><?php echo ($user[0]['weities']); ?></strong><br />微贴</a></span>                         
                                     </div>
       </div>
   </div>

                              <div class="scoll">
                              <strong>欢迎新同学</strong><br />
                              <?php if(is_array($data_user)): $i = 0; $__LIST__ = $data_user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><div class="Euser"><?php echo (getUserSpace($vo["user_id"],uvatar)); ?>                                   
                                   <div class="user_in">
                                    <span class=username><?php echo (getUserSpace($vo["user_id"],uname)); ?></span><br />
                                    <span class=us><?php echo ($vo["profession"]); ?></span><br /> 
                                    <span class=us><?php echo ($vo["academy"]); ?></span>
                                    </div>
                              </div><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>  
                              <div class="shixing">      
                                 <img src="__PUBLIC__/images/bottom/shuxing.png"/> &nbsp;WOWOYUAN
                              </div>
                        </div>
            <div id="home_zhongjian">
                  <div id="home_zhongjian_top">                 
                    <div id="sc1" class="tttt">                   
                        <A id="first" onMouseOver="showdetaildiv('at1','sc1',this)"   href="#">最新微贴</A>
                        <A onMouseOver="showdetaildiv('at2','sc1',this)"   href="#">最新回复</A>
                        <A onMouseOver="showdetaildiv('at3','sc1',this)"  href="#">金典微贴</A>
                        <A onMouseOver="showdetaildiv('at4','sc1',this)"  href="#">热门活动</A>
                    </div>                    
                     <div  id="at1" class="top_content" >
                        <div class="lines"></div>
                        <table  >
                        
                          <?php if(is_array($all_wt)): $i = 0; $__LIST__ = $all_wt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
                                        <td class="td_t">
                                               <div class="title"><img src="__PUBLIC__/images/button/topic_new.gif" />&nbsp;<a target="_blank" href="<?php echo SITE_URL;?>Forum/ewt_display/s_t_y/<?php echo ($vo["weitie_id"]); ?>/w_t/<?php echo (md($vo["weitie_id"])); ?>" title="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></a><?php if(($vo['is_photo'])  ==  "1"): ?>&nbsp;<img src="__PUBLIC__/images/button/image_s.gif" title="附有图片" style="margin-left:7px;"/><?php endif; ?></div>                    
                                       </td>
                                       <td>
                                                 <div class="author"><?php echo (getUserSpace($vo["user_id"],uname)); ?></div>                                      
                                       </td>
                                     </tr><?php endforeach; endif; else: echo "" ;endif; ?>    
                    
                        </table>
                    </div>
                    <div  id="at2" class="top_content" >
                        <div class="lines"></div>
                        <table  >                       
                         <?php if(is_array($all_comment)): $i = 0; $__LIST__ = $all_comment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
                                        <td class="td_t">
                                               <div class="title"><img src="__PUBLIC__/images/button/topic.gif" /><a target="_blank" href="<?php echo SITE_URL;?>Forum/ewt_display/s_t_y/<?php echo ($vo["weitie_id"]); ?>/w_t/<?php echo (md($vo["weitie_id"])); ?>" title="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></a><?php if(($vo['is_photo'])  ==  "1"): ?>&nbsp;<img src="__PUBLIC__/images/button/image_s.gif" title="附有图片" style="margin-left:7px;"/><?php endif; ?></div>                    
                                       </td>
                                       <td>
                                                 <div class="author">
                                                 <?php if(($vo['last_comment_user_id'])  ==  "0"): ?><?php echo (getUserSpace($vo["user_id"],uname)); ?>
                                                 <?php else: ?>
                                                 <?php echo (getUserSpace($vo["last_comment_user_id"],uname)); ?><?php endif; ?>                                                 
                                                 </div>                                      
                                       </td>
                                     </tr><?php endforeach; endif; else: echo "" ;endif; ?>                        
                        </table>
                    </div>
                    <div  id="at3" class="top_content" >
                        <div class="lines"></div>
                        <table  >                       
                         <?php if(is_array($spacial_wt)): $i = 0; $__LIST__ = $spacial_wt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
                                        <td class="td_t">
                                               <div class="title"><img src="__PUBLIC__/images/button/topic.gif" /><a target="_blank" href="<?php echo SITE_URL;?>Forum/ewt_display/s_t_y/<?php echo ($vo["weitie_id"]); ?>/w_t/<?php echo (md($vo["weitie_id"])); ?>" title="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></a><?php if(($vo['is_photo'])  ==  "1"): ?>&nbsp;<img src="__PUBLIC__/images/button/image_s.gif" title="附有图片" style="margin-left:7px;"/><?php endif; ?></div>                    
                                       </td>
                                       <td>
                                                 <div class="author"><?php echo (getUserSpace($vo["user_id"],uname)); ?></div>                                      
                                       </td>
                                     </tr><?php endforeach; endif; else: echo "" ;endif; ?>                        
                        </table>
                    </div>

                    <div  id="at4" class="top_content" >
                        <div class="lines"></div>
                        <table  >                       
                         <?php if(is_array($hot_activit)): $i = 0; $__LIST__ = $hot_activit;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
                                        <td class="td_t">
                                               <div class="title"><img src="__PUBLIC__/images/button/topic.gif" /><a target="_blank" href="<?php echo SITE_URL;?>Forum/ewt_display/s_t_y/<?php echo ($vo["weitie_id"]); ?>/w_t/<?php echo (md($vo["weitie_id"])); ?>" title="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></a><?php if(($vo['is_photo'])  ==  "1"): ?>&nbsp;<img src="__PUBLIC__/images/button/image_s.gif" title="附有图片" style="margin-left:7px;"/><?php endif; ?></div>                    
                                       </td>
                                       <td>
                                                 <div class="author"><?php echo (getUserSpace($vo["user_id"],uname)); ?></div>                                      
                                       </td>
                                     </tr><?php endforeach; endif; else: echo "" ;endif; ?>                        
                        </table>
                    </div>
                  </div>
            
                 <div id="home_zhongjian_center">
                
                    <div id="sc2" class="tttt">
                        <A id="first_shancun" onMouseOver="showdetaildiv('at5','sc2',this)"   href="#">全园闪存</A>
                        <A onMouseOver="showdetaildiv('at6','sc2',this)"   href="#">好友闪存</A>
                        <A onMouseOver="showdetaildiv('at7','sc2',this)"  href="#">我的闪存</A>
                    </div>
                    <div id="at5" class="center_content" >
                    <div class="lines"></div>
                       <ul class="feed_list"> 
                          <?php if(is_array($data_all)): $i = 0; $__LIST__ = $data_all;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><li class="IndexEline" id="list_<?php echo ($vo["flash_id"]); ?>">
                                   <div class="headpic_s"><?php echo (getUserSpace($vo["user_id"],uvatar)); ?></div>
                                   <div class="shancon"><span><?php echo (getUserSpace($vo["user_id"],uname)); ?></span>：<?php echo (format($vo["flash_body"])); ?>
                                      <div class="dosth">	                                    	                                         	                                    
                                          <?php echo (friendlyDate($vo["posttime"])); ?>                                           
					                     </div>	
                                   </div>                                                                     	                                                                       	                                   	                                     
					                     <div class="clear"></div>				             					                    				           					          					              					             
                                  </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                  </div>                                                       
                    <div id="at6" class="center_content" >
                      <div class="lines"></div>
                       <ul class="feed_list"> 
                          <?php if(is_array($data_friend)): $i = 0; $__LIST__ = $data_friend;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><li class="IndexEline" id="list_<?php echo ($vo["flash_id"]); ?>">
                                   <div class="headpic_s"><?php echo (getUserSpace($vo["user_id"],uvatar)); ?></div>
                                   <div class="shancon"><span><?php echo (getUserSpace($vo["user_id"],uname)); ?></span>：<?php echo (format($vo["flash_body"])); ?>
                                      <div class="dosth">	                                    	                                         	                                    
                                          <?php echo (friendlyDate($vo["posttime"])); ?>                                           
					                     </div>	
                                   </div>                                                                     	                                                                       	                                   	                                     
					                     <div class="clear"></div>				             					                    				           					          					              					             
                                  </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                  </div>
                    
                    <div id="at7" class="center_content" >
                       <div class="lines"></div>
                    <ul class="feed_list"> 
                          <?php if(is_array($data_me)): $i = 0; $__LIST__ = $data_me;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><li class="IndexEline" id="list_<?php echo ($vo["flash_id"]); ?>">
                                   <div class="headpic_s"><?php echo (getUserSpace($vo["user_id"],uvatar)); ?></div>
                                   <div class="shancon"><span><?php echo (getUserSpace($vo["user_id"],uname)); ?></span>：<?php echo (format($vo["flash_body"])); ?>
                                    <div class="dosth">	                                    	                                         	                                    
                                          <?php echo (friendlyDate($vo["posttime"])); ?>                                           
					                     </div>	
                                   </div>                                                                     	                                                                       
	                                    	  <div class="clear"></div>			             					                    				           					          					              					             
                                  </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                  </div>
            
            </div>
             <div id="home_zhongjian_bottom">
                    <div id="bottom_title"><a href="javascript:void(0);">园内最新上架宝贝</a></div>
                  
                   <div id="scrollbody1">
                        <table>
                            <tr>
                             <?php if(is_array($new_goods)): $i = 0; $__LIST__ = $new_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><td id="scroll3">
                                    <table>
                                        <tr>                                                                                                        
                                             <td><div class="Pic1"><a href="<?php echo SITE_URL;?>Trade/detail/id/<?php echo ($vo["goods_id"]); ?>/i_/<?php echo (md($vo["goods_id"])); ?>" target="_blank" title=<?php echo ($vo["goods_name"]); ?>><img src="__PUBLIC__/images/temp/<?php echo ($vo["user_id"]); ?>/thumb_<?php echo (getImageById($vo["img_id"])); ?>" alt="<?php echo ($vo["goods_name"]); ?>"/></a></div></td>                                                  
                                          </tr>
                                    </table>
                                </td><?php endforeach; endif; else: echo "" ;endif; ?>  
                                <td id="scroll4">
                                </td>
                            </tr>
                        </table>
                    </div>                                   
                </div>    
            </div> 
            <div class="clear"></div>                         
        </div>
              
         <div  style=" width:100%; margin-top:15px;margin-bottom:10px;font-family: 黑体;font-size:13px;color:#2DABA6; text-align:center; float:left;">    
<p><?php echo ($site['sitename_EN']); ?> &copy; <?php echo ($site['regi_year']); ?> <?php echo ($site['siteowner']); ?> &nbsp;<a style="color:#2DABA6;" href="<?php echo U('Index/about');?>">关于窝窝园</a><?php echo ($site['site_icp']); ?>&nbsp;<img src="http://img.tongji.linezing.com/2788666/tongji.gif"></p>
</div>
           
    </body>
</html>