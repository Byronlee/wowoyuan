/**
 * @brief after reference jquery.js
 */
(function(){
	var Notice = new Object() || {};
	Notice.init=function(){
		var t = setInterval(function(){
			Notice.get();
	},4000);
	};
	Notice.get=function(){
		$.post(SITE_URL+"Common/notice",function(txt){
		   txt = eval(txt);
		   if(!!txt){
				Notice.show(txt);
		   }
 	   });
	};
	Notice.show=function(j){
		var str = "<div class='notice'><ul>{count}</ul></div>";
		var p = "";
		if(j[0].status=='ok'){			
		$.each(j,function(i,o){		   
			   if(o.fans!=0){
				   p += "<li><strong>"+o.fans+"</strong>&nbsp;位新粉丝，<a href=\""+SITE_URL+"Space/follow/uid/"+o.user_id+"/type/follower/ui_/"+o.ui_+ "\">点击查看</a></li>";
			   }			   
			   if(o.new_trade!=0){
				   p += "<li><strong>"+o.new_trade+"</strong>&nbsp;条新交易，<a href=\""+SITE_URL+"Trade/manage/type/I_shelve\">点击查看</a></li>";
			   }
			   if(o.at_me!=0){
				   p += "<li><strong>"+o.at_me+"</strong>&nbsp;条@提到我的，<a href=\""+SITE_URL+"Shancun/at_me\">点击查看</a></li>";
			   }
			   if(o.wt_com!=0){
				   p += "<li><strong>"+o.wt_com+"</strong>&nbsp;条新微贴回复，<a href=\""+SITE_URL+"Forum/wt_me/t_y_p/comment_me\">点击查看</a></li>";
			   }
			   if(o.flash_com!=0){
				   p += "<li><strong>"+o.flash_com+"</strong>&nbsp;条新闪存评论，<a href=\""+SITE_URL+"Shancun/comment/type/1\">点击查看</a></li>";
			   }		   
		});
		//colse fn		
		str = str.replace(/\{count\}/ig,p);
		$(".notice").remove();
		$(".header").prepend(str);
		}if(j[0].status=='no'){
			$(".notice").remove();
		}
	};
	//init
	Notice.init();
})();


 



