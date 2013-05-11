<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
 <script>
	var _PUBLIC_  = '__PUBLIC__';
	var SITE_URL  = '<?php echo SITE_URL;?>'; 
</script>
      <!-- layout::public:header::60 -->
        <script type="text/javascript" src="__PUBLIC__/xheditor/xheditor-1.1.12-zh-cn.min.js"></script>
        <script type="text/javascript" src="__PUBLIC__/javascript/wo_forum_ewt_display.js"></script>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <link rel="stylesheet" type="text/css" href="__PUBLIC__/style/css.css"> 
       <link rel="stylesheet" type="text/css" href="__PUBLIC__/style/editor.css"> 
      <title>微贴-<?php echo ($every[0]['title']); ?></title>
            <script language=JavaScript> 
           
       </script>
</head>
<body>


<div id="ewt_center">
        <div class="ewt_title"><?php echo ($every[0]['title']); ?> </div>
         <div class="ewt_user"><?php echo (getUserSpace($every[0]['user_id'],uvatar)); ?><div class="wt_inf">发表于：<?php echo (friendlyDate($every[0]['ctime'])); ?>&nbsp;&nbsp;&nbsp;来自：<?php echo (getUserSpace($every[0]['user_id'],uname)); ?></div>
          <div class="wt_class">来源：<span>&nbsp;<?php echo ($every[0]['class']); ?></span></div>
       </div>

       <div class="ewt_cont"><?php echo ($every[0]['content']); ?></div>
       <div class="ewt_opereat">
         <span class="com_num">阅读（<?php echo ($every[0]['read_times']); ?>）&nbsp;评论（<?php echo ($every[0]['count_comment']); ?>）</span>
         <span class="com_op">
         
          <input type="hidden" name="x_id" value="<?php echo (md($every[0]['weitie_id'])); ?>" id="x_id"/>
         <?php echo ($every[0]['opreate']); ?></span>
           <span><input type="button"" class="j_h" value="推荐为精华(<?php echo ($every[0]['put']); ?>)" title="推荐为精华，为更多人看到这篇微贴" onclick="put(<?php echo ($every[0]['weitie_id']); ?>)"/></span>
        </div>
        <div onselectstart = "return false"; onpaste="return false" oncopy="return false;" oncut="return false;">
     <ul class="comment_list">
          <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><li class="Ewt_line" id="list_<?php echo ($vo["comment_id"]); ?>">
                            <div class="headpic"><?php echo (getUserSpace($vo["user_id"],uvatar)); ?></div>
                            <div class="comment_time">&nbsp;<?php echo (friendlyDate($vo["ctime"])); ?>&nbsp;&nbsp;<?php echo (getUserSpace($vo["user_id"],uname)); ?></div>
                            
                            <?php if(isset($vo['recomment'])): ?><?php if(($vo['recomment']['recomment_deleted'])  ==  "3"): ?><p  style="float:left;margin:30px 20px;font-size:19px;color:#999;">“此评论已被原主人删除！”</p>
                            <?php else: ?>
                             <div class="recomment_content_t">
                                          <p class=bingen></p>
                                          <div class="re_inf">&nbsp;<?php echo (getUserSpace($vo["recomment"]["user_id"],uvatar)); ?>&nbsp;<?php echo (getUserSpace($vo["recomment"]["user_id"],uname)); ?>发表于：<?php echo (friendlyDate($vo["recomment"]["ctime"])); ?></div>
                                            <div class="re_con">&nbsp;&nbsp;&nbsp;<?php echo ($vo["recomment"]["content"]); ?><span class="end">&nbsp;&nbsp;</span> </div>  
                             </div><?php endif; ?><?php endif; ?>
                                                                                                            
                            <div class="comment_con"><?php echo ($vo["content"]); ?></div>                        
	                        <div class="recomment">      
	                              <!-- 如果是管理员或者这篇帖子的主人都有删除功能 -->
	                              
	                              <?php if(($vo['opreate'])  ==  "3"): ?><a href="javascript:void(0)" onclick="deletedcomment(<?php echo ($vo["comment_id"]); ?>)">删除</a><?php else: ?><a href="javascript:void(0)" class="no_dele" style="margin-right:78px;">&nbsp;</a><?php endif; ?>
	                                                                                  
                                  <a href="javascript:void(0)" onclick="commentOpen(<?php echo ($vo["comment_id"]); ?>)">回复</a>    
					       </div>
					        <div class="rcomment_t " onselectstart = "return false"; onpaste="return false" oncopy="return false;" oncut="return false;">   
                                      <div class="rcomment_<?php echo ($vo["comment_id"]); ?>" style="display:none">               
                                       <textarea style="width:500px;height:70px;font-size:18px; font-family:kaiti;" id="recom_<?php echo ($vo["comment_id"]); ?>"  class="xheditor {skin:'nostyle'}" {forcePtag:true} ></textarea>
                                       <p class="rr" ><a href="javascript:void(0);" style="align:center;" onclick="recomment(<?php echo ($vo["comment_id"]); ?>)" >回复^ _ ^</a></p>
                                    </div>

				           	</div> 

               </li><?php endforeach; endif; else: echo "" ;endif; ?>
         </ul>

         <div class="page_wowo" style="min-width:100px;text-align:center;height:30px;margin-right:165px;background-color:#fff;float:right;"><?php echo ($page); ?></div>
        <p style="padding-left:153px;float:left;width:300px; font-size:15px;margin-top:50px;">你的回应</p>

     <div style="padding-left:133px;margin:50px 20px;" >
      <form method="POST" id="wt_comment_publish" action="__URL__/do_wt_comment_publish">

        <input type="hidden" name="weitie_id" value="<?php echo ($every[0]['weitie_id']); ?>" id="ewt_weitie_id"   class="weitie_id"/>
        
        
        <?php if(($every["0"]["iscomment"])  ==  "1"): ?><textarea name="comment_content" id="comment_content"   style="width:685px;height:140px;float:left;"  class="xheditor {skin:'nostyle'}" {forcePtag:true} ></textarea>
        <div id="comment_submit"> <input  type="button" value="我来评论^ _ ^" style="margin:10px 0px" onclick="checkcomment()"></div>
       <?php else: ?>
            <input  type="button" class="comment_submit_no" value="嘿，这篇微贴的主人说了，这篇帖子暂时不要咱们评论!" ><?php endif; ?>
       </form>  
      </div></div>
</div>
<div  style=" width:100%; margin-top:15px;margin-bottom:10px;font-family: 黑体;font-size:13px;color:#2DABA6; text-align:center; float:left;">    
<p><?php echo ($site['sitename_EN']); ?> &copy; <?php echo ($site['regi_year']); ?> <?php echo ($site['siteowner']); ?> &nbsp;<a style="color:#2DABA6;" href="<?php echo U('Index/about');?>">关于窝窝园</a><?php echo ($site['site_icp']); ?>&nbsp;<img src="http://img.tongji.linezing.com/2788666/tongji.gif"></p>
</div>
</body>
</html>