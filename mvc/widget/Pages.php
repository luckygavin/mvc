<?php
/* 分页的类 */
class Pages{

	private $dataCount;  	// 所有数据总行数
	private $offset = 0;		// 偏移量
	public $currentPage = 1;	// 当前页
	public $pageCount;		// 页数

	public $pageSize = 10; 	// 默认每页10行

	/**
	 * 构造函数
	 * $dataCount 所有数据总行数
	 */
	public function __construct($dataCount){
		$this->dataCount = $dataCount;
		$this->pageCount = ceil($dataCount/$this->pageSize);
	}

	/**
	 * 给原条件上添加limit限制
	 */
	public function applyLimit(&$condition){
		$this->pageCount = ceil($this->dataCount/$this->pageSize);
		if(isset($_GET['page'])){
			if($_GET['page']<1)
				$_GET['page'] = 1;
			if($_GET['page']>$this->pageCount)
				$_GET['page']=$this->pageCount;
			$this->offset = $this->pageSize*($_GET['page']-1);
			$this->currentPage = $_GET['page'];
		}
		$condition .= " limit $this->offset,$this->pageSize";
	}

	/**
	 * 产生分页代码
	 */
	public function displayCode(){
		$start = 1;
		$end = $this->pageCount;
		if($this->currentPage<=5){
			if($end>9){
				$end = 9;
				$not_end = '<li style="background-color:#F6F6F3;line-height: 34px;">&nbsp...&nbsp</li>'; 
			}
		}else{
			$not_start = '<li style="background-color:#F6F6F3;line-height: 34px;">&nbsp...&nbsp</li>';
			$start = $this->currentPage-4;
			if($this->currentPage+4<$this->pageCount){
				$not_end = '<li style="background-color:#F6F6F3;line-height: 34px;">&nbsp...&nbsp</li>';
				$end = $this->currentPage+4;
			}else{
				$start = $this->pageCount-8;
			}   
		}
		//构成页面代码
		$html = "<div class='app_pages'>";
		$html .=	"<ul class='app_pages_ul'>";
		$html .=		"<li class='app_pages_li'><a href='?page=1' title='跳到第一页'><<</a></li>";
		$html .=		"<li class='app_pages_li'><a href='?page=".($this->currentPage-1)."' title='上一页'><</a></li>";
		if(isset($not_start)){
			$html .= $not_start;
		}
		for ($i=$start; $i<=$end; $i++){ 
			$ch = '';
			if($i==$this->currentPage) 
				$ch = 'class="change_select"';
			$html .= "<li class='app_pages_li'><a $ch href='?page=$i'>$i</a></li>";
		}
		if(isset($not_end)){
			$hmtl .= $not_end;
		}
		$html .=		"<li class='app_pages_li'><a href='?page=".($this->currentPage+1)."' title='下一页'>></a></li>";
		$html .=		"<li class='app_pages_li'><a href='?page=".$this->pageCount."' title='最后一页'>>></a></li>";
		$html .=	"</ul>";
		$html .= "</div>";
		echo $html;
	}

}
?>