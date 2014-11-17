<?php
/* 用于数据库链接等的配置 */
class Lii {
	/**
	 * 通过静态函数构造一个对象
	 */
	public static function app(){
		return new Lii();
	}

	private $baseUrl ; //应用根目录
	private $basePath ; //应用根目录路径

	/**
	 * 获取变量时赋值
	 */
	public function __get($name){
		switch ($name) {
			case 'baseUrl':
				$path = $_SERVER['PHP_SELF'];
				if(stripos($_SERVER['PHP_SELF'],'index.php'))
					$path = substr($path, 0, stripos($_SERVER['PHP_SELF'],'/index.php'));
				rtrim($path,'/');
				return $path;
				break;
			case 'basePath':
				return dirname(__FILE__);  //最后会别include到index.php中，所以对应的是index.php目录路径
				break;
			default: break;
		}
	}

}
?>