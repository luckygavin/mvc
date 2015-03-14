<?php require_once(dirname(__FILE__).'/Base.php');
/**
 * Controller的父类
 */
class CController extends Base
{
	public $action;	
	public $values;
	public $layout;	//只要layout下的文件名,在views下的layout文件夹下对应的文件,不需要扩展名
	public $viewPath='application.views';	//views的路径

	/**
	 * 构造函数
	 */
	public function __construct($action,$values){
		$this->action = $action;
		$this->values = $values;
		$this->__validateAction();
	}

	/* 执行相应的action */
	public function run(){
		call_user_func_array(array($this,$this->action), $this->values);	
	}

	/**
	 * 验证是否请求有对应的成员方法
	 */
	public function __validateAction(){
		if(!method_exists($this,$this->action))
			throw new Exception("The system is unable to find the requested action \"$this->action\"", 404);	
	}
}
?>