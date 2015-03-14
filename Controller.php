<?php 
/* Content All controller functions */
require(dirname(__FILE__).'/framework/CController.php');
class Controller extends CController
{
	public $layout = 'main';
	/* 默认的函数:action为空时默认为执行此函数 */	
	public function index(){
		$this->layout = 'leftSide';
		$this->render('index',array('i'=>1));
	}
	

	/********************************************************** 功能性函数(私有函数，仅供成员函数调用) ***********************************************************/


}
?>