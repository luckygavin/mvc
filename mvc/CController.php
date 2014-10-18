<?php 	
class CController{
	public $action;
	public $values;

	public function __construct($action,$values){
		$this->action = $action;
		$this->values = $values;
		//echo '<br>in CController';
	}

	/* 执行相应的action */
	public function run(){
		//echo  '<br>in CController run';var_dump($this->action);
		call_user_func_array(array($this,$this->action), $this->values);	
	}

	/* 渲染页面 */
	public function render($file,$values=array()){
		//把数组变成变量
		extract($values);
		include('views/'.$file);
	}
}
?>