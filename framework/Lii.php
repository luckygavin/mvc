<?php 
/**
 * 一些常用的方法或变量
 */
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
				return $this->__getBaseUrl();
				break;
			case 'basePath':
				return ROOT_PATH;  //在index.php中定义
				break;
			case 'homeUrl':
				return $this->__getBaseUrl().'/index.php';  //home page
				break;
			default: break;
		}
	}

	/********************************************************** 功能性函数(私有函数，仅供成员函数调用) ***********************************************************/
	private function __getBaseUrl(){
		$path = $_SERVER['PHP_SELF'];
		if(stripos($_SERVER['PHP_SELF'],'index.php'))
			$path = substr($path, 0, stripos($_SERVER['PHP_SELF'],'/index.php'));
		rtrim($path,'/');
		return $path;
	}
}
?>