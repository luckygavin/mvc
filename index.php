<?php 
/* This is the entry of this website*/
defined('ROOT_PATH') or define('ROOT_PATH',dirname(__FILE__));

include(dirname(__FILE__).'/AppConfig.php'); 
//自动导入要用到的类文件
include(dirname(__FILE__).'/mvc/autoload.php'); 

$action = new Urls();
$action->run();
