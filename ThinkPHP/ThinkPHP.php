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
// $Id: ThinkPHP.php 1829 2010-10-18 08:15:58Z liu21st $

/**
 +------------------------------------------------------------------------------
 * ThinkPHP????
 +------------------------------------------------------------------------------
 */
// ???????????
function G($start,$end='',$dec=3) {
    static $_info = array();
    if(!empty($end)) { // ????
        if(!isset($_info[$end])) {
            $_info[$end]   =  microtime(TRUE);
        }
        return number_format(($_info[$end]-$_info[$start]),$dec);
    }else{ // ????
        $_info[$start]  =  microtime(TRUE);
    }
}

//????????
G('beginTime');
if(!defined('APP_PATH')) define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
if(!defined('RUNTIME_PATH')) define('RUNTIME_PATH',APP_PATH.'/Runtime/');
if(!defined('APP_CACHE_NAME')) define('APP_CACHE_NAME','app');// ??????
if(defined('RUNTIME_ALLINONE') && is_file(RUNTIME_PATH.'~allinone.php')) {
    // ALLINONE ??????allinone??
    $result   =  require RUNTIME_PATH.'~allinone.php';
    C($result);
    // ?????????
    define('RUNTIME_MODEL',true);
}else{
    if(version_compare(PHP_VERSION,'5.0.0','<'))  die('require PHP > 5.0 !');
    // ThinkPHP??????
    if(!defined('THINK_PATH')) define('THINK_PATH', dirname(__FILE__));
    if(!defined('APP_NAME')) define('APP_NAME', basename(dirname($_SERVER['SCRIPT_FILENAME'])));
    $runtime = defined('THINK_MODE')?'~'.strtolower(THINK_MODE).'_runtime.php':'~runtime.php';
    if(is_file(RUNTIME_PATH.$runtime)) {
        // ??????????
        require RUNTIME_PATH.$runtime;
    }else{
        // ????????
        require THINK_PATH."/Common/runtime.php";
        // ??????~runtime??
        build_runtime();
    }
}
// ????????
G('loadTime');
?>