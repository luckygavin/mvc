<?php 
class Controller extends CController{
/* Content All controller functions */

	/* 默认的函数:action为空时默认为执行此函数 */	
	public function index(){
		$this->render('index.php',array('i'=>1));
	}

}
?>