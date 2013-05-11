/**
 * 
 */

//空间关注操作
function dofollow(type,target,uid){    //这里的  uid  表示当前登录用户要去关注的对象的人的ID；
	var html = '';
	$('#follow_state').html( '<img src="'+ _THEME_+'/images/icon_waiting.gif" width="15">' );
	$.post(SITE_URL+"Space/follow" ,{uid:uid,type:type},function(txt){
		if(txt=='12'){
			html = followState('havefollow');
		}else if(txt=='13'){
			html = followState('eachfollow');
		}else if(txt=='00'){
			alert('对方不允许你关住')
		}else{
			html = followState();
		}
		$('#follow_state').html( html );
	});
}

//列表关注操作
function dolistfollow(type,target,uid){   //这里的  uid  表示当前登录用户要去关注的对象的人的ID；
	var html = '';
	var target=target;
	var uid=uid;
	$("#follow_list_"+uid).html( '<img src="/Public/images/button/icon_waiting.gif" width="15">' );
	$.post(SITE_URL+"Follow/follow" ,{uid:uid,type:type},function(txt){
	//	alert(txt);
		if(txt=='12'){
			html = followState('havefollow',target,uid);			
		}else if(txt=='13'){
			html = followState('eachfollow',target,uid);
		}else if(txt=='00'){
			ui.error('取消失败');
			html = followState('unfollow',target,uid);
		}else{
			html = followState('',target,uid);
		}
		$("#follow_list_"+uid).html( html );
	//	window.location.reload();
	});
}

//关注状态
function followState(type,target,uid){    //这里的  uid  表示当前登录用户要去关注的对象的人的ID；
	target = target || 'dofollow';

	if(type=='havefollow'){
		html = '<div class="btn_relation btn_relation1"><span>已关注|</span><a href="javascript:void(0);" onclick="'+target+'(\'unflollow\',\''+target+'\','+uid+')">取消</a></div>';
	}else if(type=='eachfollow'){
		html = '<div class="btn_relation btn_relation2"><span>互相关注|</span><a href="javascript:void(0);" onclick="'+target+'(\'unflollow\',\''+target+'\','+uid+')">取消</a></div>';
	}else{
		html = '<a class="add_atn" href="javascript:void(0);" onclick="'+target+'(\'dofollow\',\''+target+'\','+uid+')">加关注</a>';
	}
	return html;
}










