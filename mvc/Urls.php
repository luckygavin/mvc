<?php 	/* 路由作用 */
class Urls{
	private $url;
	private $action;
	private $values=array();

	public function __construct($url){
		$this->url=$url;
		$this->__route();
	}

	/* 路由功能:获取对应目标函数及参数 */
	private function __route(){
		$action=preg_replace('/.*?index.php\/?/', '', $this->url);
		if($action!=''){
			$tmp = explode('/', $action);
			$this->action = $tmp[0];
			unset($tmp[0]);
			if($tmp){
				foreach ($tmp as $value) {
					array_push($this->values , $value);
				}
			}
		}else{
			$this->action='index';
		}
	}

	/* 执行相应的controller */
	public function run(){
		//echo $this->action;
		$controller = new Controller($this->action,$this->values);
		$controller->run();
	}
}
?>