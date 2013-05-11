<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename Function.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/






function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : ET_URL);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

function StrLenW($str){
    return mb_strlen($str,'UTF8');
}

function StrLenW2($str){
    return (strlen($str)+mb_strlen($str,'UTF8'))/2;
}

function daddslashes($string) {
    $string=str_replace("'",'"',$string);
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
    if(!MAGIC_QUOTES_GPC) {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = daddslashes($val);
            }
        } else {
            $string = addslashes($string);
        }
    }
	return $string;
}

function sethead($head) {
    //ucenter头像
    if (ET_UC==TRUE) {
        return UC_API."/avatar.php?uid=".$head."&size=middle";
    }
    if (getsubstr($head,0,4,false)=='http') {
        return $head;
    } else if (getsubstr($head,-4,1,false)!='.') {
        return __PUBLIC__."/images/noavatar.jpg";
    } else {
        return $head?__PUBLIC__."/attachments/head/".$head:__PUBLIC__."/images/noavatar.jpg";
    }
}

function setvip($user_auth) {
    $vipgroup=@include(ET_ROOT.'/Home/Runtime/Data/vipgroup.php');
    if ($vipgroup) {
        foreach($vipgroup as $val){
            $vgroup[$val['id']]=$val;
        }
    }
    if ($vgroup[$user_auth]['name']) {
        return 'vip'.$user_auth;
    } else {
        return '';
    }
}

function viptitle($user_auth) {
    $vipgroup=@include(ET_ROOT.'/Home/Runtime/Data/vipgroup.php');
    if ($vipgroup) {
        foreach($vipgroup as $val){
            $vgroup[$val['id']]=$val;
        }
    }
    if ($vgroup[$user_auth]['name']) {
        return 'title="'.$vgroup[$user_auth]['name'].'"';
    } else {
        return '';
    }
}

function timeop($time,$type="talk") {
    $ntime=time()-$time;
    if ($ntime<60) {
        return(L('just'));
    } elseif ($ntime<3600) {
        return(intval($ntime/60).L('date_minutes'));
    } elseif ($ntime<3600*24) {
        return(intval($ntime/3600).L('date_houre'));
    } else {
        if ($type=="talk") {
            return(gmdate('m'.L('months').'d'.L('day').' H:i',$time+8*3600));
        } else {
            return(gmdate('Y-m-d H:i',$time+8*3600));
        }

    }
}

function randStr($len=6) {
    $chars='ABDEFGHJKLMNPQRSTVWXY123456789';
    mt_srand((double)microtime()*1000000*getmypid());
    $password='';
    while(strlen($password)<$len)
    $password.=substr($chars,(mt_rand()%strlen($chars)),1);
    return $password;
}

function getsubstr($string, $start = 0,$sublen,$append=true) {
    $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
    preg_match_all($pa, $string, $t_string);

    if(count($t_string[0]) - $start > $sublen && $append==true) {
        return join('', array_slice($t_string[0], $start, $sublen))."...";
    } else {
        return join('', array_slice($t_string[0], $start, $sublen));
    }
}

//过滤html
function clean_html($html) {
    $html = nl2br($html);
    $html = str_replace(array("<br />","<br/>","<br>","\r","\n","\r\n","#".L('input_topic_title')."#"), " ", $html);
    $html = eregi_replace('<("|\')?([^ "\']*)("|\')?.*>([^<]*)<([^<]*)>', '\4', $html);
    $html = preg_replace('#</?.*?\>(.*?)</?.*?\>#i','',$html);
    $html = preg_replace('#(.*?)\[(.*?)\](.*?)javascript(.*?);(.*?)\[/(.*?)\](.*?)#','', $html);
    $html = preg_replace('#javascript(.*?)\;#','', $html);
    $html = htmlspecialchars($html);
    return($html);
}


//share functions
function get_host($str){
	$list=array(
        "sina.com.cn",
        "youku.com",
        "tudou.com",
        "ku6.com",
        "sohu.com",
        "mofile.com",
        "youtube.com",
	);
	foreach($list as $v){
		if( strpos($str,$v)>0){
			$re= substr($str,strpos($str,$v),100);
			break;
		}
	}
	return $re;
}






function gotomail($mail) {
    $temp=explode('@',$mail);
    $t=strtolower($temp[1]);

    if ($t=='163.com') {
        return 'mail.163.com';
    } else if ($t=='vip.163.com') {
        return 'vip.163.com';
    } else if ($t=='126.com') {
        return 'mail.126.com';
    } else if ($t=='qq.com' || $t=='vip.qq.com' || $t=='foxmail.com') {
        return 'mail.qq.com';
    } else if ($t=='gmail.com') {
        return 'mail.google.com';
    } else if ($t=='sohu.com') {
        return 'mail.sohu.com';
    } else if ($t=='tom.com') {
        return 'mail.tom.com';
    } else if ($t=='vip.sina.com') {
        return 'vip.sina.com';
    } else if ($t=='sina.com.cn' || $t=='sina.com') {
        return 'mail.sina.com.cn';
    } else if ($t=='tom.com') {
        return 'mail.tom.com';
    } else if ($t=='yahoo.com.cn' || $t=='yahoo.cn') {
        return 'mail.cn.yahoo.com';
    } else if ($t=='tom.com') {
        return 'mail.tom.com';
    } else if ($t=='yeah.net') {
        return 'www.yeah.net';
    } else if ($t=='21cn.com') {
        return 'mail.21cn.com';
    } else if ($t=='hotmail.com') {
        return 'www.hotmail.com';
    } else if ($t=='sogou.com') {
        return 'mail.sogou.com';
    } else if ($t=='188.com') {
        return 'www.188.com';
    } else if ($t=='139.com') {
        return 'mail.10086.cn';
    } else if ($t=='189.cn') {
        return 'webmail15.189.cn/webmail';
    } else if ($t=='wo.com.cn') {
        return 'mail.wo.com.cn/smsmail';
    } else if ($t=='139.com') {
        return 'mail.10086.cn';
    } else {
        return '';
    }
}
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


   
   


?>