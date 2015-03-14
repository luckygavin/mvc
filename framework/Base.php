<?php 
/**
 * 基础类，放一些系统常用方法
 */
class Base 
{
	public $viewPath;  //views的路径 子类中自行设定
	public $layout;  //子类中自行设定 在views下的layout文件夹下
	private $father_layout; //用于多层layout渲染

	/**
	 * 构造函数
	 */
	public function __construct(){
	}

	/**
	 * 把'.'形式的路径 转换成'/'形式的路径
	 */
	public function switchPath($path){
		$path = str_replace(array('application','.'), '/', $path);
		$path = ROOT_PATH .$path;
		$path = realpath($path).'/';
		return $path;
	}

	/**
	 * 渲染页面 -- 加载layout
	 */
	public function render($file,$values=array()){
		$layout = $this->switchPath($this->viewPath).'layout/'.$this->layout.'.php';
		if(!empty($this->layout) && file_exists($layout)){
			ob_end_clean();
			ob_start();
			$this->renderPartial($file,$values);
			$content = ob_get_contents();
			ob_end_clean();
			include($layout);
		}else{
			$this->renderPartial($file,$values);
		}
	}

	/**
	 * 渲染页面 -- 直接渲染不加载layout
	 */
	public function renderPartial($file,$values=array()){
		extract($values); 	//把数组变成变量
		$path = $this->switchPath( $this->viewPath );
		$path = $path.$file.'.php';
		if(file_exists($path))
			include($path);
		else
			throw new Exception("Fatal: File \"$file.php\" not found in path:$path", 404);
	}

	/**
	 * 开始加载父级layout
	 * 用于多重渲染
	 */
	public function startContent($layout){
		ob_start();
		$this->father_layout = $layout;
	}

	/**
	 * 结束加载
	 */
	public function endContent(){
		$content = ob_get_contents();
		ob_end_clean();
		$layout = $this->switchPath($this->viewPath).'/layout/'.$this->father_layout.'.php';
		if(!empty($this->layout) && file_exists($layout)){
			include($layout);
		}else{
			echo $content;
		}
	}
}
?>