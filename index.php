<?php /* This is the entry of this website*/
	// change the following paths if necessary
	include(dirname(__FILE__).'/AppConfig.php'); 
	//自动导入要用到的类文件
	include(dirname(__FILE__).'/mvc/Autoload.php'); 
	
	$action = new Urls();
	$action->run();
?>