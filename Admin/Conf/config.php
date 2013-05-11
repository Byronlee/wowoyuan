<?php
$config = require 'config.inc.php';
$array  =  array(
	//'配置项'=>'配置值'
       
);
//合并输出配置
return array_merge($config,$array);
?>