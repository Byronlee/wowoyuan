<?php
if (isset($_SERVER['HTTP_X_REWRITE_URL'])){
  $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
}
define("APP_NAME","Home");
define("APP_PATH","Home");
require ('./ThinkPHP/ThinkPHP.php');
require('./define.inc.php');
app::run();
?>