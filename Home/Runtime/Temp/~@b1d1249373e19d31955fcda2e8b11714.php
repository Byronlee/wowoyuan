<?php
//000000000060s:4802:"
 <script>
	var _PUBLIC_  = '/Public';
	var SITE_URL  = 'http://localhost/index.php/'; 
</script>
     <script type="text/javascript" src="/Public/javascript/jquery-1.4.2.min.js"></script> 
     <script type="text/javascript" src="/Public/javascript/jq.js"></script> 
     <script type="text/javascript" src="/Public/javascript/apprise-1.5.full.js"></script>
     <link rel="stylesheet" type="text/css" href="/Public/style/apprise.css" />
     <link rel="shortcut icon" href="/Public/images/wo.png" type="image/x-icon" />
	 <link rel="stylesheet" type="text/css" href="/Public/style/shancun_layout.css"/> 
	 <link rel="stylesheet" type="text/css" href="/Public/style/shancun_public.css"/>       
	 <script type="text/javascript" src="/Public/javascript/flash.js"></script>       
	 <script type="text/javascript" src="/Public/javascript/notice.js"></script> 
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
                                     
                                  
                <div class="logo"><a href="http://localhost/index.php/url=home" >Wowoyuan</a></div>               
                <div class="nav">
                    <ul>
                        <li>
                            <a href="http://localhost/index.php/url=flash" class="fb14">闪存</a>
                        </li>
                        <li class="set">
                            <a href="http://localhost/index.php/url=forum" class="fb14">微社</a>
                             <div class="set_con">
                               <span><a href="/index.php/Forum/wt_me/t_y_p/my">我的微贴</a></span><br />
                                <span><a href="/index.php/Forum/wt_me/t_y_p/comment_me">最新评论</a></span><br />                                      
                                </div>
                         
                        </li>
                        <li class="set">
                            <a href="http://localhost/index.php/url=trade" class="fb14">商场</a>
                            <div class="set_con">
                               <span><a href="/index.php/Trade/manage/type/shelve">最新上架</a></span><br />
                                <span><a href="/index.php/Trade/manage/type/I_shelve">我的交易</a></span><br />
                               <span><a href="/index.php/Trade/shelve">上架宝贝</a></span><br />            
                                </div>
                        </li>
                        <li class="set">
                            <a href="#" class="fb14">设置</a> 
                              <div class="set_con">
                               <span><a href="/index.php/Index/information">基本信息</a></span><br />
                                <span><a href="/index.php/Index/setAccount">帐号设置</a></span><br />
                               <span><a href="/index.php/Index/setAvatar">修改头像</a></span><br />
                               <span><a href="http://localhost/index.php/out">退出</a></span> <br />              
                                </div>                  
                        </li>                     
                    </ul>
                   
                   
                    <form action="/index.php/Index/s_result" id="quick_search_form" method="post">
                     <input type="hidden" id="hidden_input" name="tag" value=1/>
                        <div class="soso"><label id="_header_search_label" style="display: block;" onclick="$(this).hide();$('#_header_search_text').focus();">闪存/名字/宝贝/关键字</label><input type="text" class="so_text" value="" name="key" id="_header_search_text" onblur="if($(this).val()=='') $('#_header_search_label').show();"/><input name="" type="button" onclick="$('#quick_search_form').submit()" class="so_btn hand br3"/></div>
                        <script>
                            if($('#_header_search_text').val()=='')
                                $('#_header_search_label').show();
                            else
                                $('#_header_search_label').hide();
                        </script>
                    <input type="hidden" name="__hash__" value="6d9347eb306fc189371248df580c3834" /></form>
                </div>                                      
            </div>                                     
            </div>";
?>