<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

/**
 +------------------------------------------------------------------------------
 * ThinkPHP Action鎺у埗鍣ㄥ熀绫�鎶借薄绫�
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id$
 +------------------------------------------------------------------------------
 */
abstract class Action extends Think
{//绫诲畾涔夊紑濮�

    // 瑙嗗浘瀹炰緥瀵硅薄
    protected $view   =  null;
    // 褰撳墠Action鍚嶇О
    private $name =  '';

   /**
     +----------------------------------------------------------
     * 鏋舵瀯鍑芥暟 鍙栧緱妯℃澘瀵硅薄瀹炰緥
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function __construct()
    {
        //瀹炰緥鍖栬鍥剧被
        $this->view       = Think::instance('View');
        //鎺у埗鍣ㄥ垵濮嬪寲
        if(method_exists($this,'_initialize'))
            $this->_initialize();
    }

   /**
     +----------------------------------------------------------
     * 鑾峰彇褰撳墠Action鍚嶇О
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     */
    protected function getActionName() {
        if(empty($this->name)) {
            // 鑾峰彇Action鍚嶇О
            $this->name     =   substr(get_class($this),0,-6);
        }
        return $this->name;
    }

    /**
     +----------------------------------------------------------
     * 鏄惁AJAX璇锋眰
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @return bool
     +----------------------------------------------------------
     */
    protected function isAjax() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
            if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
                return true;
        }
        if(!empty($_POST[C('VAR_AJAX_SUBMIT')]) || !empty($_GET[C('VAR_AJAX_SUBMIT')]))
            // 鍒ゆ柇Ajax鏂瑰紡鎻愪氦
            return true;
        return false;
    }

    /**
     +----------------------------------------------------------
     * 妯℃澘鏄剧ず
     * 璋冪敤鍐呯疆鐨勬ā鏉垮紩鎿庢樉绀烘柟娉曪紝
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $templateFile 鎸囧畾瑕佽皟鐢ㄧ殑妯℃澘鏂囦欢
     * 榛樿涓虹┖ 鐢辩郴缁熻嚜鍔ㄥ畾浣嶆ā鏉挎枃浠�
     * @param string $charset 杈撳嚭缂栫爜
     * @param string $contentType 杈撳嚭绫诲瀷
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
  protected function display($templateFile='',$charset='',$contentType='text/html')
    {
        if(false === $templateFile) {
            $this->showTrace();
        }else{
            $this->view->display($templateFile,$charset,$contentType);
        }
    }

    /**
     +----------------------------------------------------------
     *  鑾峰彇杈撳嚭椤甸潰鍐呭
     * 璋冪敤鍐呯疆鐨勬ā鏉垮紩鎿巉etch鏂规硶锛�
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $templateFile 鎸囧畾瑕佽皟鐢ㄧ殑妯℃澘鏂囦欢
     * 榛樿涓虹┖ 鐢辩郴缁熻嚜鍔ㄥ畾浣嶆ā鏉挎枃浠�
     * @param string $charset 杈撳嚭缂栫爜
     * @param string $contentType 杈撳嚭绫诲瀷
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    protected function fetch($templateFile='',$charset='',$contentType='text/html')
    {
        return $this->view->fetch($templateFile,$charset,$contentType);
    }

    /**
     +----------------------------------------------------------
     *  鍒涘缓闈欐�椤甸潰
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @htmlfile 鐢熸垚鐨勯潤鎬佹枃浠跺悕绉�
     * @htmlpath 鐢熸垚鐨勯潤鎬佹枃浠惰矾寰�
     * @param string $templateFile 鎸囧畾瑕佽皟鐢ㄧ殑妯℃澘鏂囦欢
     * 榛樿涓虹┖ 鐢辩郴缁熻嚜鍔ㄥ畾浣嶆ā鏉挎枃浠�
     * @param string $charset 杈撳嚭缂栫爜
     * @param string $contentType 杈撳嚭绫诲瀷
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    protected function buildHtml($htmlfile='',$htmlpath='',$templateFile='',$charset='',$contentType='text/html') {
        return $this->view->buildHtml($htmlfile,$htmlpath,$templateFile,$charset,$contentType);
    }

    /**
     +----------------------------------------------------------
     * 妯℃澘鍙橀噺璧嬪�
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param mixed $name 瑕佹樉绀虹殑妯℃澘鍙橀噺
     * @param mixed $value 鍙橀噺鐨勫�
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    protected function assign($name,$value='')
    {
        $this->view->assign($name,$value);
    }

    public function __set($name,$value) {
        $this->view->assign($name,$value);
    }

    /**
     +----------------------------------------------------------
     * 鍙栧緱妯℃澘鏄剧ず鍙橀噺鐨勫�
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $name 妯℃澘鏄剧ず鍙橀噺
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    protected function get($name)
    {
        return $this->view->get($name);
    }

    public function __get($name) {
        return $this->view->get($name);
    }

    /**
     +----------------------------------------------------------
     * Trace鍙橀噺璧嬪�
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param mixed $name 瑕佹樉绀虹殑妯℃澘鍙橀噺
     * @param mixed $value 鍙橀噺鐨勫�
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    protected function trace($name,$value='')
    {
        $this->view->trace($name,$value);
    }

    /**
     +----------------------------------------------------------
     * 榄旀湳鏂规硶 鏈変笉瀛樺湪鐨勬搷浣滅殑鏃跺�鎵ц
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $method 鏂规硶鍚�
     * @param array $parms 鍙傛暟
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    public function __call($method,$parms) {
        if( 0 === strcasecmp($method,ACTION_NAME)) {
            // 妫�煡鎵╁睍鎿嶄綔鏂规硶
            $_action = C('_actions_');
            if($_action) {
                // 'module:action'=>'callback'
                if(isset($_action[MODULE_NAME.':'.ACTION_NAME])) {
                    $action  =  $_action[MODULE_NAME.':'.ACTION_NAME];
                }elseif(isset($_action[ACTION_NAME])){
                    // 'action'=>'callback'
                    $action  =  $_action[ACTION_NAME];
                }
                if(!empty($action)) {
                    call_user_func($action);
                    return ;
                }
            }
            // 濡傛灉瀹氫箟浜哶empty鎿嶄綔 鍒欒皟鐢�
            if(method_exists($this,'_empty')) {
                $this->_empty($method,$parms);
            }else {
                // 妫�煡鏄惁瀛樺湪榛樿妯＄増 濡傛灉鏈夌洿鎺ヨ緭鍑烘ā鐗�
                if(file_exists_case(C('TMPL_FILE_NAME')))
                    $this->display();
                else
                    // 鎶涘嚭寮傚父
                    throw_exception(L('_ERROR_ACTION_').ACTION_NAME);
            }
        }elseif(in_array(strtolower($method),array('ispost','isget','ishead','isdelete','isput'))){
            return strtolower($_SERVER['REQUEST_METHOD']) == strtolower(substr($method,2));
        }else{
            throw_exception(__CLASS__.':'.$method.L('_METHOD_NOT_EXIST_'));
        }
    }

    /**
     +----------------------------------------------------------
     * 鎿嶄綔閿欒璺宠浆鐨勫揩鎹锋柟娉�
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $message 閿欒淇℃伅
     * @param Boolean $ajax 鏄惁涓篈jax鏂瑰紡
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    protected function error($message,$ajax=false)
    {
        $this->_dispatch_jump($message,0,$ajax);
    }

    /**
     +----------------------------------------------------------
     * 鎿嶄綔鎴愬姛璺宠浆鐨勫揩鎹锋柟娉�
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $message 鎻愮ず淇℃伅
     * @param Boolean $ajax 鏄惁涓篈jax鏂瑰紡
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    protected function success($message,$ajax=false)
    {
        $this->_dispatch_jump($message,1,$ajax);
    }

    /**
     +----------------------------------------------------------
     * Ajax鏂瑰紡杩斿洖鏁版嵁鍒板鎴风
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param mixed $data 瑕佽繑鍥炵殑鏁版嵁
     * @param String $info 鎻愮ず淇℃伅
     * @param boolean $status 杩斿洖鐘舵�
     * @param String $status ajax杩斿洖绫诲瀷 JSON XML
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    protected function ajaxReturn($data,$info='',$status=1,$type='')
    {
        // 淇濊瘉AJAX杩斿洖鍚庝篃鑳戒繚瀛樻棩蹇�
        if(C('LOG_RECORD')) Log::save();
        $result  =  array();
        $result['status']  =  $status;
        $result['info'] =  $info;
        $result['data'] = $data;
        if(empty($type)) $type  =   C('DEFAULT_AJAX_RETURN');
        if(strtoupper($type)=='JSON') {
            // 杩斿洖JSON鏁版嵁鏍煎紡鍒板鎴风 鍖呭惈鐘舵�淇℃伅
            header("Content-Type:text/html; charset=utf-8");
            exit(json_encode($result));
        }elseif(strtoupper($type)=='XML'){
            // 杩斿洖xml鏍煎紡鏁版嵁
            header("Content-Type:text/xml; charset=utf-8");
            exit(xml_encode($result));
        }elseif(strtoupper($type)=='EVAL'){
            // 杩斿洖鍙墽琛岀殑js鑴氭湰
            header("Content-Type:text/html; charset=utf-8");
            exit($data);
        }else{
            // TODO 澧炲姞鍏跺畠鏍煎紡
        }
    }

    /**
     +----------------------------------------------------------
     * Action璺宠浆(URL閲嶅畾鍚戯級 鏀寔鎸囧畾妯″潡鍜屽欢鏃惰烦杞�
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $url 璺宠浆鐨刄RL琛ㄨ揪寮�
     * @param array $params 鍏跺畠URL鍙傛暟
     * @param integer $delay 寤舵椂璺宠浆鐨勬椂闂�鍗曚綅涓虹
     * @param string $msg 璺宠浆鎻愮ず淇℃伅
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    protected function redirect($url,$params=array(),$delay=0,$msg='') {
        if(C('LOG_RECORD')) Log::save();
        $url    =   U($url,$params);
        redirect($url,$delay,$msg);
    }

    /**
     +----------------------------------------------------------
     * 榛樿璺宠浆鎿嶄綔 鏀寔閿欒瀵煎悜鍜屾纭烦杞�
     * 璋冪敤妯℃澘鏄剧ず 榛樿涓簆ublic鐩綍涓嬮潰鐨剆uccess椤甸潰
     * 鎻愮ず椤甸潰涓哄彲閰嶇疆 鏀寔妯℃澘鏍囩
     +----------------------------------------------------------
     * @param string $message 鎻愮ず淇℃伅
     * @param Boolean $status 鐘舵�
     * @param Boolean $ajax 鏄惁涓篈jax鏂瑰紡
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    private function _dispatch_jump($message,$status=1,$ajax=false)
    {
        // 鍒ゆ柇鏄惁涓篈JAX杩斿洖
        if($ajax || $this->isAjax()) $this->ajaxReturn($ajax,$message,$status);
        // 鎻愮ず鏍囬
        $this->assign('msgTitle',$status? L('_OPERATION_SUCCESS_') : L('_OPERATION_FAIL_'));
        //濡傛灉璁剧疆浜嗗叧闂獥鍙ｏ紝鍒欐彁绀哄畬姣曞悗鑷姩鍏抽棴绐楀彛
        if($this->get('closeWin'))    $this->assign('jumpUrl','javascript:window.close();');
        $this->assign('status',$status);   // 鐘舵�
        $this->assign('message',$message);// 鎻愮ず淇℃伅
        //淇濊瘉杈撳嚭涓嶅彈闈欐�缂撳瓨褰卞搷
        C('HTML_CACHE_ON',false);
        if($status) { //鍙戦�鎴愬姛淇℃伅
            // 鎴愬姛鎿嶄綔鍚庨粯璁ゅ仠鐣�绉�
            if(!$this->get('waitSecond'))    $this->assign('waitSecond',"1");
            // 榛樿鎿嶄綔鎴愬姛鑷姩杩斿洖鎿嶄綔鍓嶉〉闈�
            if(!$this->get('jumpUrl')) $this->assign("jumpUrl",$_SERVER["HTTP_REFERER"]);
            $this->display(C('TMPL_ACTION_SUCCESS'));
        }else{
            //鍙戠敓閿欒鏃跺�榛樿鍋滅暀3绉�
            if(!$this->get('waitSecond'))    $this->assign('waitSecond',"3");
            // 榛樿鍙戠敓閿欒鐨勮瘽鑷姩杩斿洖涓婇〉
            if(!$this->get('jumpUrl')) $this->assign('jumpUrl',"javascript:history.back(-1);");
            $this->display(C('TMPL_ACTION_ERROR'));
        }
        if(C('LOG_RECORD')) Log::save();
        // 涓鎵ц  閬垮厤鍑洪敊鍚庣户缁墽琛�
        exit ;
    }

    protected function showTrace(){
        $this->view->traceVar();
    }

}//绫诲畾涔夌粨鏉�
?>