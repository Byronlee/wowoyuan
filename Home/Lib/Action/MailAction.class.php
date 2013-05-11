<?php
class MailAction extends Action{
private $option = array();
	
	
	public function __construct() {
		$this->init();
	}
	
	/**
	 * 加载phpmailer, 初始化默认参数
	 */
	public function init() {
		include_once(THINK_PATH.'/lib/phpmailer/class.phpmailer.php');
		include_once(THINK_PATH.'/lib/phpmailer/class.pop3.php');
		include_once(THINK_PATH.'/lib/phpmailer/class.smtp.php');
		//$emailset = X('Xdata')->lget('email');
		$this->option = array(
			'email_sendtype'		=> 'smtp',
			'email_host'			=> 'smtp.sina.cn',
			'email_port'			=> 25,
			//'email_ssl'				=> $emailset['email_ssl'],
			'email_account'			=> 'wowoyuan@sina.cn',
			'email_password'		=> 'zq8967170',
			'email_sender_name'		=> '窝窝园',
			'email_sender_email'	=> 'wowoyuan@sina.cn',
			'email_reply_account'	=> 'wowoyuan@sina.cn'
		);
	}

	/**
	 * 发送邮件
	 * 
	 * @param string $sendto_email 收信人的Email
	 * @param string $subject      主题
	 * @param string $body         正文
	 * @param array  $senderInfo   发件人信息 array('email_sender_name'=>'发件人姓名', 'email_account'=>'发件人Email地址')
	 * @return boolean
	 */
	public function send_email( $sendto_email, $subject, $body, $senderInfo = '' ) {
        $mail = new PHPMailer();
		if(empty($senderInfo)) {
			$sender_name  = $this->option['email_sender_name'];
			$sender_email = $this->option['email_account'];
		}else {
			$sender_name = $senderInfo['email_sender_name'];
			$sender_email = $senderInfo['email_account'];
		}

		if($this->option['email_sendtype'] =='smtp'){
			$mail->Mailer = "smtp";
			$mail->Host	= $this->option['email_host'];	// sets GMAIL as the SMTP server
			$mail->Port	= $this->option['email_port'];	// set the SMTP port

			if($this->option['email_ssl']){
				$mail->SMTPSecure	=	"ssl";	// sets the prefix to the servier  tls,ssl
			}

			$mail->SMTPAuth = true;						 // turn on SMTP authentication
			$mail->Username = $this->option['email_account'];	 // SMTP username
			$mail->Password = $this->option['email_password']; // SMTP password

		}

		$mail->FromName	= $sender_name;  // 发件人姓名
		$mail->From		= $sender_email; // 发件人邮箱


		$mail->CharSet	= "UTF-8"; // 这里指定字符集！
		$mail->Encoding	= "base64";

		if(is_array($sendto_email)){
			foreach($sendto_email as $v){
				$mail->AddAddress($v);
			}
		}else{
			$mail->AddAddress($sendto_email);
		}

		//以HTML方式发送
		$mail->IsHTML(true); // send as HTML
		// 邮件主题
		$mail->Subject	 = $subject;
		// 邮件内容
		$mail->Body		 =	$body;
		$mail->AltBody	 =	"text/html";
		$mail->SMTPDebug =	false;
		return $mail->Send();
	}
}