<?php require_once(dirname(__FILE__).'/Base.php');
/**
 * 错误处理类
 */
class Error extends Base
{
	public $viewPath = 'application.views.error';

	/**
	 * 构造函数
	 * $e 为一个Exception对象
	 */
	public function __construct($e){
		if(AppConfig::$debug){
			$this->debugError($e);
		}else{
			$this->viewError($e);
		}
	}

	/**
	 * 没有开debug模式的错误处理页面
	 */
	public function viewError($e){
		//可以自定义404和500等页面
		$errorFile = 'error'.$e->getCode();
		$filePath = $this->switchPath($this->viewPath).$errorFile.'.php';
		if(!file_exists($filePath))
			$errorFile = 'error';
		$this->renderPartial($errorFile,array(
				'errorCode'=>$e->getCode(),
				'message'=>$e->getCode()===404 ? $e->getMessage() : 'Internal Server Error.',
			));
	}

	/**
	 * 开启debug模式的错误处理
	 */
	public function debugError($e){
		$this->viewPath = AppConfig::$includePath["framework"].'.views';
		$trace = $e->getTrace();
		foreach($trace as $i=>$t){
			if(!isset($t['file']))
				$trace[$i]['file']='unknown';
			if(!isset($t['line']))
				$trace[$i]['line']=0;
			if(!isset($t['function']))
				$trace[$i]['function']='unknown';
			unset($trace[$i]['object']);
		}
		$this->renderPartial('error',array(
				'errorCode'=>$e->getCode(),
				'message'=>$e->getMessage(),
				'errorFile'=>$e->getFile(),
				'errorLine'=>$e->getLine(),
				'trace'=>$e->getTraceAsString(),
				'traces'=>$trace,
			));
	}

	/**
	 * 获得错误位置的代码
	 */
	public function renderSourceCode($file,$errorLine,$maxLines=25){
		$errorLine--;	// adjust line number to 0-based from 1-based
		if($errorLine<0 || ($lines=@file($file))==false || ($lineCount=count($lines))<=$errorLine)
			return '';

		$halfLines = (int)($maxLines/2);
		$beginLine = $errorLine-$halfLines>0 ? $errorLine-$halfLines : 0;
		$endLine = $errorLine+$halfLines<$lineCount ? $errorLine+$halfLines : $lineCount-1;
		$lineNumberWidth=strlen($endLine+1);

		$output='';
		for($i=$beginLine;$i<=$endLine;++$i){
			$isErrorLine = $i===$errorLine;
			$code=sprintf("<span class=\"ln".($isErrorLine ? ' error-ln':'')."\">%0{$lineNumberWidth}d</span> %s",$i+1,htmlspecialchars(str_replace("\t",'    ',$lines[$i])),ENT_QUOTES);
			if(!$isErrorLine)
				$output.=$code;
			else
				$output.='<span class="error">'.$code.'</span>';
		}
		return '<div class="code"><pre>'.$output.'</pre></div>';
	}

	/**
	 * 过滤掉mvc文件夹下的代码显示
	 * 也就是说只把mvc以外的文件的代码直接显示在debug页面，而mvc里面的是隐藏的
	 */
	public function isCoreCode($trace){
		if(isset($trace['file'])){
			$systemPath=realpath(dirname(__FILE__));
			//strpos 那一块的作用是：在mvc目录下的文件匹配mvc目录会从一开始匹配到，返回0.而mvc外的目录匹配mvc目录匹配不到，返回false
			return $trace['file']==='unknown' || strpos(realpath($trace['file']),$systemPath.DIRECTORY_SEPARATOR)===0;
		}
		return false;
	}
}
?>