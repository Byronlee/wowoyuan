<?php
	//获取用户姓名

 function getUserName($uid,$lang='zh') {
	if ($uid){
		$uModel = new Model();
		$uname = $uModel->query("SELECT username FROM wo_user WHERE user_id = $uid");
		return $uname[0]['username'];
	}
	else return '用户不存在!';
}



// 搜索结果中关键字显示红色
     function showRed($string,$keyword){
     	//dump($string);
     	$replace = "<font color='red'>$keyword</font>";
     	return preg_replace("/$keyword/",$replace,$string);
     	
     } 



function getShort($str, $length = 40, $ext = '') {
	$str	=	htmlspecialchars($str);
	$str	=	strip_tags($str);
	$str	=	htmlspecialchars_decode($str);
	$strlenth	=	0;
	$out		=	'';
	preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/", $str, $match);
	foreach($match[0] as $v){
		preg_match("/[\xe0-\xef][\x80-\xbf]{2}/",$v, $matchs);
		if(!empty($matchs[0])){
			$strlenth	+=	1;
		}elseif(is_numeric($v)){
			$strlenth	+=	0.545;
		}else{
			$strlenth	+=	0.475;
		}

		if ($strlenth > $length) {
			$output .= $ext;
			break;
		}

		$output	.=	$v;
	}
	return $output;
}

// 通过图片的id获得图片的名字
function getImageById($id){
	if (!isset($id)) return 0;
	$imgName = D()->query('SELECT img_name From wo_goods_img WHERE img_id = '.$id);
	if ($imgName) return $imgName[0]['img_name'];
}




//  通过二级分类的名字或的相关信息
    function getList($first,$second){

    	$info=M('shelve')->where("class_first=$first AND class_second=$second AND is_Sale=2")->order('goods_id DESC')->limit('5')->findAll();
    	if (!empty($info)) return $info;  	  	
}
	







// 获得IP
    function real_ip(){
    static $realip = NULL;
    if ($realip !== NULL){
        return $realip;
    }
    if (isset($_SERVER)){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr as $ip){
                $ip = trim($ip);
                if ($ip != 'unknown'){
                    $realip = $ip;
                    break;
                }
            }
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])){
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])){
                $realip = $_SERVER['REMOTE_ADDR'];
            }else {
                $realip = '0.0.0.0';
            }
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR')){
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }  elseif (getenv('HTTP_CLIENT_IP')){
            $realip = getenv('HTTP_CLIENT_IP');
        } else  {
            $realip = getenv('REMOTE_ADDR');
        }
    }
    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
    return $realip;
}

//  获得商品分类或者微社分类的列表  
    function getMenu($type){
   	$i = 0;
   	$menu = array();
   	if ($type=='trade'){
   	//$data = D()->query('SELECT class_first_name,class_second_name,s.class_first_id  FROM wo_goods_class_first as f , wo_goods_class_second  as s WHERE f.class_first_id = s.class_first_id');
   	$first   = D()->query('SELECT class_first_name,class_first_id FROM wo_goods_class_first');
   	$second  = D()->query('SELECT class_second_name,class_first_id FROM wo_goods_class_second'); 
   	}
   	else {
   		$first = D()->query('SELECT forum_class_first_name,forum_class_first_id FROM wo_forum_class_first');
   		$second = D()->query('SELECT forum_class_second_name,forum_class_second_id FROM wo_forum_class_second');
   	}
   	dump($first);
   		dump($second);
  foreach ($first as $key =>$value ){
 	foreach ($second as $keys => $values){
 		if($value['forum_class_first_id'] ==$values['forum_class_first_id']){
 		$menu[$value['forum_class_first_name']][$i++] = $values['forum_class_second_name'];
 		}
 		else $i=0;
 	}
 	
 }
return $menu;
 }

/*                                 闪存中的Common                 */


function getUserFace($uid,$size){

	$size = ($size) ? $size : 'm';
	if ($size == 'm') {
		$type = 'middle';
	} elseif ($size == 's') {
		$type = 'small';
	} else {
		$type = 'big';
	}
	//return $uid;
	// 注意使用is_file和file_exists注意路径的写法
	$faceurl ='Public/images/uploads/avatar/'.$uid.'/'.$type.'.jpg';
	//return $faceurl;
	if (is_file($faceurl)) {
		return "/".$faceurl;
	} else {
		return "/Public/images/uploads/avatar/default/default_".$type.".gif";    //默认的 公共头像；
	}
}



function getUserSpace($uid, $text,$at=FALSE) {
	static $_userinfo = array ();
	$ui=$uid*3762-37;
	$ui_=md5($ui);
	if (! isset ( $_userinfo [$uid] )) {
		$_userinfo [$uid] = D ( 'User', 'home' )->getUserByIdentifier ( $uid, 'uid' );
	}
	$title=getUserName($uid);
	$target = '_blank';
	if ($text=='uname') {
		  if ($at){
		  	$text = getUserName($uid);
		  	$text='@'.$text;
		    $class = 'username';		  	
		  }else{
		  	$text = getUserName($uid);
		    $class = 'username';
		  }
		}
		if($text=='uvatar') {
		 
			$face = getUserFace($uid,$text);
			$text = "<img src=\"$face\"/>";
			$class = 'avatar';
		}
	
	if ($_userinfo [$uid] ['domain'])
		$url = U ( 'Space/index', array ('uid' => $_userinfo [$uid] ['domain'], 'ui_'=>$ui_) );
	else
		$url = U ( 'Space/index', array ('uid' => $uid, 'ui_'=>$ui_ ) );
	return "<a href='{$url}' class='{$class}' title='{$title}' target='{$target}'>$text</a>";

      
}


/**
 * 将给定用户设为在线
 * 
 * @param int $uid
 */
function setOnline($uid) {
	$cookie_name = 'login_time_' . $uid;
	$cookie_time = intval(cookie($cookie_name));
	$now         = time();
	$expire      = 5 * 60; // 有效期: 5min
	// $now -$expire = 5分钟前
	// 每5分钟更新一次
	if ($cookie_time < ($now - $expire)) {
		cookie($cookie_name, $now, $expire);
	
		$sql = 'REPLACE INTO ' . C('DB_PREFIX') . 'user_online (user_id,record_time) VALUES ("' . $uid . '", "' . $now . '")';
	    return M('')->query($sql);
	} else {
		return null;
	}
}



function format($content) {
	
	$content = preg_replace_callback ( "/(?:#[^#]*[^#^\s][^#]*#|(\[.+?\]))/is", replaceEmot, $content );		
	$content = preg_replace_callback("/@([\w\x{4e00}-\x{9fa5}\-]+)/u",getUserId,$content);
	$content = preg_replace('/((?:https?|mailto):\/\/(?:www\.)?(?:[a-zA-Z0-9][a-zA-Z0-9\-]*\.)?[a-zA-Z0-9][a-zA-Z0-9\-]*(?:\.[a-zA-Z0-9]+)+(?:\:[0-9]*)?(?:\/[^\x{4e00}-\x{9fa5}\s<\'\"“”‘’]*)?)/u', '<a href="\1" target="_blank">http://wowoyuan.com/3qAQ4&nbsp;</a>', $content);		
	return $content;
}

/**
 * 根据用户昵称获取用户ID [格式化微博与格式化评论专用]
 * 
 * @param array $name
 * @see format()
 * @see formatComment()
 */
function getUserId($name) {
	$info = D('User', 'home')->getUserByIdentifier($name[1], 'uname');
	
	if ($info) {
		return getUserSpace($info['user_id'],'uname',true);
	}else {          //等张强做好了搜搜就可以了
		return "<a href=".U('Index/s_result').">".$name[0]."</a>";
	}
}

			


/* 表情替换 [格式化微博与格式化评论专用]
 * 
 * @param array $data
 * @see format()
 * @see formatComment()
 */
function replaceEmot($data) {
    if(preg_match("/#.+#/i",$data[0])) {
    	return $data[0];
    }
    
	$info = getExpressionDetailByEmotion($data[1]);
	if($info) {
		return preg_replace("/\[.+?\]/i","<img src='".__PUBLIC__."/images/expression/".$info['filename']."' />",$data[0]);
	}else {
		return $data[0];
	}
}

function getExpressionDetailByEmotion($emotion){
	        $list = array();
            $res = D('Expression')->field('title,emotion,filename,type')->findAll();
			foreach ($res as $v) {
				$list[$v['emotion']] = $v;
			}
			return $list[$emotion];
}



function friendlyDate($sTime, $type = 'normal', $alt = 'false') {
	$cTime = time ();
	$dTime = $cTime - $sTime;
	$dDay = $dTime / 3600 / 24;
	$dYear = intval ( date ( "Y", $cTime ) ) - intval ( date ( "Y", $sTime ) );
	if ($type == 'normal') {
		if ($dTime < 60) {
			return $dTime . "秒前";
		} elseif ($dTime < 3600) {
			return intval ( $dTime / 60 ) . "分钟前";
		} elseif ($dTime >= 3600 && $dDay == 0) {
			return '今天' . date ( 'H:i', $sTime );
		} elseif ($dYear == 0) {
			return date ( "m月d日 H:i", $sTime );
		} else {
			return date ( "Y-m-d H:i", $sTime );
		}
	} elseif ($type == 'mohu') {
		if ($dTime < 60) {
			return $dTime . "秒前";
		} elseif ($dTime < 3600) {
			return intval ( $dTime / 60 ) . "分钟前";
		} elseif ($dTime >= 3600 && $dDay == 0) {
			return intval ( $dTime / 3600 ) . "小时前";
		} elseif ($dDay > 0 && $dDay <= 7) {
			return intval ( $dDay ) . "天前";
		} elseif ($dDay > 7 && $dDay <= 30) {
			return ceil ( $dDay / 7 ) . '周前';
		} elseif ($dDay > 30) {
			return ceil ( $dDay / 30 ) . '个月前';
		}
	} elseif ($type == 'full') {
		return date ( "Y-m-d , H:i:s", $sTime );
	} elseif ($type == 'ymd') {
		return date ( "Y-m-d", $sTime );
	} else {
		if ($dTime < 60) {
			return $dTime . "秒前";
		} elseif ($dTime < 3600) {
			return intval ( $dTime / 60 ) . "分钟前";
		} elseif ($dTime >= 3600 && $dDay == 0) {
			return intval ( $dTime / 3600 ) . "小时前";
		} elseif ($dYear == 0) {
			return date ( "Y-m-d H:i:s", $sTime );
		} else {
			return date ( "Y-m-d H:i:s", $sTime );
		}
	}
}

function getfollower_num($uid){
	$count ['follower'] = M ( 'Flash' )->where ( "fid=$uid AND type=0" )->count ();
	return "1200";
}
function getfollowering_num($uid){
	$count ['following'] = M ( 'Flash' )->where ( "uid=$uid AND type=0" )->count ();
	return "120";
}
function getflash_num($uid){
	M ( 'Flash' )->where ( 'user_id=' . $uid )->count ();
	return "67";
}
function getMini_num($uid){
	M ( 'Flash' )->where ( 'user_id=' . $uid )->count ();
	return "467";
}

/*                     结束                                         */




/**
 * 获取关注状态
 * 
 * @param int $uid 用户ID
 * @param int $fid 好友ID
 * @param int $type 0:关注好友 1:关注话题
 * @return string eachfollow:相互关注 | havefollow:已关注 | unfollow:未关注 | 空:同一个用户
 * 
 * TODO: 使用缓存
 */
function getFollowState($uid,$fid) {

	
		if (M('user_follow')->where("(uid=$uid AND fid=$fid) OR (uid=$fid AND fid=$uid)")->count() == 2) {
			return 'eachfollow';
		}else if(M('user_follow')->where("uid=$uid AND fid=$fid ")->count()) {
			return 'havefollow';
		}else {
			return 'unfollow';
		}	
}

// 验证邮箱是否合法
	 function isValidEmail($email){
	 	return preg_match("/[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/i", $email) !== 0;
	 }


	 
	 
//输出安全的html
function h($text, $tags ='1'){
	
	$text	=	preg_replace('/<!--?.*-->/','',$text);
	//完全过滤注释
	$text	=	preg_replace('/<!--?.*-->/','',$text);
	//完全过滤动态代码
	$text	=	preg_replace('/<\?|\?'.'>/','',$text);
	//完全过滤js
	$text	=	preg_replace('/<script?.*\/script>/','',$text);

	//过滤危险的属性，如：过滤on事件lang js
	while(preg_match('/(<[^><]+) (lang|on|action|background|codebase|dynsrc|lowsrc)[^><]+/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1],$text);
	}
	while(preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1].$mat[3],$text);
	}	
	$text	=	str_replace('  ',' ',$text);
	return $text;
}

/**
 * 转换为安全的纯文本
 * 
 * @param string  $text
 * @param boolean $parse_br    是否转换换行符
 * @param int     $quote_style ENT_NOQUOTES:(默认)不过滤单引号和双引号 ENT_QUOTES:过滤单引号和双引号 ENT_COMPAT:过滤双引号,而不过滤单引号
 * @return string|null string:被转换的字符串 null:参数错误
 */
function t($text, $parse_br = false, $quote_style = ENT_NOQUOTES)
{
	if (is_numeric($text))
		$text = (string)$text;
	
	if (!is_string($text))
		return null;
	
	if (!$parse_br) {
		$text = str_replace(array("\r","\n","\t"), ' ', $text);
	} else {
		$text = nl2br($text);
	}
	
	$text = stripslashes($text);
	$text = htmlspecialchars($text, $quote_style, 'UTF-8');
	
	return $text;
}
	 


function md($id){
	 $ui=$id*3762-37;
	 $ui_=md5($ui);
	 return $ui_;
}













?>


