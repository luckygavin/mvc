<?php 	
/**
 * 路由作用
 */
class Urls{
	private $url;
	private $action;
	private $values=array();

	public function __construct(){
		$this->url = $_SERVER['PHP_SELF'];
		$this->__route();
	}

	/* 路由功能:获取对应目标函数及参数 */
	private function __route(){
		$action=preg_replace('/.*?index.php\/?/', '', $this->url);
		if($action!=''){
			$tmp = explode('/', $action);
			$this->action = $tmp[0];
			//其余的量都是参数
			unset($tmp[0]);
			if($tmp){
				foreach ($tmp as $value) {
					array_push($this->values , $value);
				}
			}
		}else{
			$this->action='index';
		}
		$this->action = 'action'.ucfirst($this->action); 	//更换为actionIndex形式
									//防止开发者自定义的函数不小心声明为public而被用户直接访问到
	}

	/* 执行相应的controller */
	public function run(){
		try{
			session_start();
			$controller = new Controller($this->action,$this->values);
			$controller->run();
		}catch(Exception $e){
			new Error($e);
		}
	}
}
?>