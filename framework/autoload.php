<?php
/**
 * __autoload
 * 自动导入要用到的类文件
 * 导入的路径在AppConfig中设置
 */
function __autoload($classname){
	foreach (AppConfig::$includePath as $path) {
		//先转换成'/'形式的路径
		$path = str_replace(array('application','.'), '/', $path);
		$path = ROOT_PATH .$path;
		$path = realpath($path).'/';
		$path .= $classname.'.php';
		if(file_exists($path)){
			include($path);
			$ok = true;
			break;
		}
	}
	if(!isset($ok))
		throw new Exception("<b>Fatal error:</b> Class $classname not found.There not found a file named $classname.php", 1);
}
?>