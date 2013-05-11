<?php
function formatsize($fileSize) {
	$size = sprintf("%u", $fileSize);
	if($size == 0) {
		return("0 Bytes");
	}
	$sizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
	return round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizename[$i];
}

//斯蒂芬嘎的


/**
 +----------------------------------------------------------
 * 字节格式化 把字节数格式为 B K M G T 描述的大小
 +----------------------------------------------------------
 * @return string
 +----------------------------------------------------------
 */
function byte_format($size, $dec=2) {
	$a = array("B", "KB", "MB", "GB", "TB", "PB");
	$pos = 0;
	while ($size >= 1024) {
		 $size /= 1024;
		   $pos++;
	}
	return round($size,$dec)." ".$a[$pos];
}



/**
 * 获取当前在线用户数(有效期15分钟)
 * 
 * @return int
 */
function getOnlineUserCount() {
	//15分钟前
	$time = time() - 15 * 60;
    $sql = "SELECT COUNT(*) AS count FROM " . C('DB_PREFIX') . "user_online WHERE record_time > '$time'";
    $res = M('')->query($sql);
    return $res[0]['count'];
}
    

/**
	 * 验证用户是否已登录
	 * 
	 * 按照session -> cookie的顺序检查是否登陆
	 * 
	 * @return boolean 登陆成功是返回true, 否则返回false
	 */
 function isLogged()
	{
		// 验证本地系统登录
		if (intval($_SESSION['mid']) > 0)
			return true;
		else if ($uid = $this->getCookieUid())
			return $this->loginLocal($uid);
		else
			return false;
	}

	/**
	 * 根据标示符(email或uid)和未加密的密码获取本地用户 (密码为null时不参与验证)
	 * 
	 * @param string         $identifier 标示符内容 (为数字时:标示符类型为uid, 其他:标示符类型为email)
	 * @param string|boolean $password   未加密的密码
	 * @return array|boolean 成功获取用户数据时返回用户信息数组, 否则返回false
	 */
 function getLocalUser($identifier, $password = null)
	{
		if (empty($identifier))
			return false;
		
		$identifier_type = is_numeric($identifier) ? 'uid' : 'email';
		$user = D('User', 'home')->getUserByIdentifier($identifier, $identifier_type);
		if (!$user)
			return false;
		else if ($password && md5($password) != $user['password'])
			return false;
		else
			return $user;
	}

	/**
	 * 使用本地账号登陆 (密码为null时不参与验证)
	 * 
	 * @param string         $email
	 * @param string|boolean $password
	 * @return boolean
	 */
 function loginLocal($identifier, $password = null, $is_remember_me = false)
	{
		$user = $this->getLocalUser($identifier, $password);
		
		return $user ? $this->registerLogin($user, $is_remember_me) : false;
	}
	
	/**
	 * 注册用户的登陆状态 (即: 注册cookie + 注册session + 记录登陆信息)
	 * 
	 * @param array   $user          
	 * @param boolean $is_remeber_me 
	 */
 function registerLogin(array $user, $is_remeber_me = false)
	{
		if (empty($user))
			return false;
		
		$_SESSION['mid']	= $user['uid'];
		$_SESSION['uname']	= $user['uname'];
		
		if (!$this->getCookieUid()) {
			$expire = $is_remeber_me ? (3600*24*365) : (3600*1);
			cookie('LOGGED_USER', base64_encode("thinksns.{$user['uid']}"), $expire);
			
			// 登陆积分
			X('Credit')->setUserCredit($uid, 'user_login');
		}
		
		$this->recordLogin($user['uid']);
		
		return true;
	}
	
	/**
	 * 注销本地登录
	 */
 function logoutLocal()
	{
		// 注销session
		unset($_SESSION['mid']);
		unset($_SESSION['uname']);
		unset($_SESSION['userInfo']);

		// 注销cookie
		cookie('LOGGED_USER', NULL);

		// 注销管理员
		unset($_SESSION['ThinkSNSAdmin']);
	}
	
	/**
	 * 获取cookie中记录的用户ID
	 */
 function getCookieUid()
	{
		static $cookie_uid = null;
		if (isset($cookie_uid))
			return $cookie_uid;
			
		$cookie = t(cookie('LOGGED_USER'));
		$cookie = explode('.', base64_decode($cookie));
		$cookie_uid = ($cookie[0] !== 'thinksns') ? false : $cookie[1];
		return $cookie_uid;
	}
	
	/**
	 * 检查是否登陆后台
	 */
 function isLoggedAdmin()
	{
		return $_SESSION['isAdmin'] == '1';
	}
	
	/**
	 * 登陆后台
	 * 
	 * @param int    $uid      用户ID,不能和email同时为空
	 * @param string $email    用户Email,不能和用户ID同时为空
	 * @param string $password 未加密的密码,不能为空
	 * @return boolean
	 */
 function loginAdmin($identifier, $password)
	{
		if (empty($identifier) || empty($password))
			return false;
		
		if (!($user = $this->getLocalUser($identifier, $password))) {
			unset($_SESSION['ThinkSNSAdmin']);
			return false;
		}
		
		// 检查是否拥有admin/Index/index权限
		if ( service('SystemPopedom')->hasPopedom($user['uid'], 'admin/Index/index', false) ) {
			$_SESSION['ThinkSNSAdmin']	= 1;
			$_SESSION['mid']			= $user['uid'];
			$_SESSION['uname']			= $user['uname'];

			//登录记录
			$this->recordLogin($user['uid']);
			return true;
		} else {
			unset($_SESSION['ThinkSNSAdmin']);
			return false;
		}
	}
	
	/**
	 * 记录登录信息
	 * 
	 * @param int $uid 用户ID
	 */
 function recordLogin($uid)
	{
		$data['uid']	= $uid;
		$data['ip']		= get_client_ip();
		$data['place']	= convert_ip($data['ip']);
		$data['ctime']	= time();
		M('login_record')->add($data);
	}

	/* 后台管理相关方法 */
	
	// 运行服务，系统服务自动运行
  function run(){
		return;
	}
	
	//获取用户姓名
function getUserName($uid,$lang='zh') {
	if ($uid){
		$uModel = new Model();
		$uname = $uModel->query("SELECT username FROM wo_user WHERE user_id = $uid");
		return $uname[0]['username'];
	}
	else return '用户不存在!';
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
function md($id){
	 $ui=$id*3762-37;
	 $ui_=md5($ui);
	 return $ui_;
}


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
	$faceurl = __ROOT__.'/Public/images/uploads/avatar/'.$uid.'/'.$type.'.jpg';
	//return $faceurl;
	if (is_file($faceurl)) {
		return $faceurl;
	} else {
		return __ROOT__."/Public/images/uploads/avatar/default/default_".$type.".gif";    //默认的 公共头像；
	}
}

?>