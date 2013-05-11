<?php
class CommonAction extends Action {

    // 锟斤拷前Action锟斤拷锟�
    private		$name =  '';
	protected	$site;
	protected	$user;
	protected	$mid;
	protected	$uid;
	public      $allModel;
	protected	$userCount;
	// 页面标题
	protected   $page_title;
	
	

   /**
     +----------------------------------------------------------
     * 锟杰癸拷锟斤拷锟斤拷 取锟斤拷模锟斤拷锟斤拷锟绞碉拷锟�
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function _initialize()
    {
        $this->allModel = new Model();
        
		$this->initSite();
		$this->initUser();
		$this->getNotice();
		if(Cookie::get('isLogged')!=1) redirect( SITE_URL.'url=login');
		header('Content-type:text/html;charset=utf-8');    
		
    }

   /**
     +----------------------------------------------------------
     * 锟斤拷始锟斤拷站锟斤拷锟斤拷锟斤拷锟斤拷息
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     */
	protected function initSite() {
		
	    $site = array ();
			$sdata = M ( 'system' )->select ();
			foreach ( $sdata as $key => $val ) {
				$site [$val ['name']] = $val ['contents'];
			}
	$this->site = $site;
	    if($this->site['site_closed']==1) {
	        $this->assign('close',1);
	        $this->assign('waitSecond',3);
	    	$this->error('对不起,网站已关闭,请稍后再试!');
	    }
	
   else $this->assign('site',$this->site);
	}
   /**
     +----------------------------------------------------------
     * 锟斤拷始锟斤拷锟斤拷前锟斤拷录锟矫伙拷锟斤拷息
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     */
	public function initUser()
	{
		
		$this->uid = intval(Cookie::get('uid'));
		setOnline($this->uid);
		if ($this->uid == 0)
			$this->uid = $this->mid;   
		// 锟斤拷值锟斤拷前锟矫伙拷
		$this->user	= $this->returnUserInfo($this->uid);		
		$this->assign('mid',$this->mid);
		$this->assign('uid',$this->uid);
		$this->assign('user',$this->user);				
	}
	
  // 返回个人信息
    function returnUserInfo($id){    
   	$userInfo = D('Public')->getUserInfo($id);  
   	if ($userInfo!=0){
   		 return $userInfo;  	   		
   	}
   	//$this->display();
   }
	
	

   
   
   /*BYronlee  新加的内容*/
   
    /**
     +----------------------------------------------------------
     * 模板Title，keywords等赋值
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $input 要赋值的变量
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */

   
   

   
	public function getNotice(){
	
		$this->assign('notice',$string);
	}
  
   
   


//设置标题函数

 function setTitle($input) {
    	$this->page_title = $input;
    	$this->assign('page_title',$this->page_title);
	}
   

	function notice(){
				
			$userCount= D('Notify')->getCount($this->uid);
			//dump($userCount);
			if ($userCount!=0){
				$ui_=md($this->uid);
			echo '[{"status":"ok","fans":"'.$userCount['new_fid'].'","flash_com":"'.$userCount['flash_comment'].'","ui_":"'.$ui_.'","new_trade":"'.'","user_id":"'.$this->uid.'","new_trade":"'.$userCount['new_trade'].'","wt_com":"'.$userCount['wt_comment'].'","at_me":"'.$userCount['at_me'].'"}]';
			}else{
				echo '[{"status":"no"}]';
			}
	}
	
}
?>