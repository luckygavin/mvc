<?php
/* 根据数据库自己检测/产生表名和字段名 */
class Model{
	private $con;
	private $table;
	private $columns=array();

	/**
	 * 构造函数
	 * 初始化数据库和成员变量-对应数据库中的列
	 * 初始化时传入要使用的表 $table
	 */
	public function __construct($table){
		$this->table=$table;

		$config = get_config();
		$mysql = $config['db'];
		$con = mysql_connect($mysql['host'],$mysql['username'],$mysql['password']);
		if(!$con){
	  		die('Could not connect: ' . mysql_error());
		}
		mysql_select_db($mysql['dbname'],$con);
		$this->con = $con;

		/* 获取表名的列表 */
		$tables = $this->get_table_list($mysql['dbname']);
		//var_dump($tables);die;
		if(in_array($table, $tables)){
			/* 获取表里的字段名并存到全局变量里 */
			$result = $this->get_column_list($table);
			foreach ($result as $key => $value) { 	
				$this->$value = '';		//产生成员变量
				$this->columns[] = $value;
			}
		}else{
			throw new Exception("Error : There is not exist a table named ".$table, 1);
		}
	}

	/**
	 * 只取一条数据，
	 * 若查询出多条数据，则返回第一条
	 * 若没有数据则返回 NULL
	 */
	public function find($where='',$other=''){
		$result = $this->select($where,$other);
		if(!$result)
			$result[0] = NULL;
		return $result[0];
	}

	/**
	 * 返回所有数据
	 * 若没有数据则返回空数组
	 */
	public function findAll($where='',$other=''){
		$result = $this->select($where,$other);
		return $result;
	}

	/**
	 * 把Model中的数据同步到数据库中
	 */
	public function save(){
		$py_key = $this->columns[0];
		if($this->$py_key!='')
			return $this->update();
		else
			return $this->insert();
	}

	/**
	 * 删除数据库中的数据
	 */
	public function delete(){
		$py_key = $this->columns[0];
		$sql  = "delete from $this->table where $py_key=".$this->$py_key;
		return mysql_query($sql,$this->con);
	}


	/********************************************************** 功能性函数(私有函数，仅供成员函数调用) ***********************************************************/
	/**
	 * 更新数据库中的数据
	 */
	private function update(){
		$sql_value = '';
		foreach ($this->columns as $key => $value) {
			if($key == 0) 	//跳过主键.自增
				continue;
			$sql .= $value."='$this->$value',";
		}
		rtrim($sql_value,',');
		$py_key = $this->columns[0];
		$sql = "update $this->table set $sql_value where $py_key=$this->$py_key";
		var_dump($sql);die;
		return mysql_query($sql,$this->con);
	}

	/**
	 * 向数据库中插入数据
	 */
	private function insert(){
		$sql_column = '';
		$sql_value = '';
		foreach ($this->columns as $key => $value) {
			if($key == 0) 	//跳过主键.自增
				continue;
			$sql_column .= $value.',';
			$sql_value .= "'".$this->$value."',";
		}
		$sql_column = rtrim($sql_column,",");
		$sql_value = rtrim($sql_value,",");
		$sql = "insert into $this->table ($sql_column) values($sql_value)";
		return mysql_query($sql,$this->con);
	}

	/**
	 * 从数据库里取数据
	 * return 一个对象数组
	 */
	private function select($where,$other){
		$sql = "select * from $this->table ";
		if($where)
			$sql .= "where $where ";
		if($other)
			$sql .= $other;
		$result = mysql_query($sql, $this->con);
		$result_array = array();
		while($row = mysql_fetch_assoc($result)){
			foreach ($row as $key => $value) {
					//$columns = $this->columns;
					$this->$key = $value;
			}
			$this_model = clone $this;
			$result_array[] = $this_model;
		}
		return $result_array;
	}

	/**
	 * 获取表名的列表
	 * return array()
	 */
	private function get_table_list($database){
		$rs = mysql_query("SHOW TABLES",$this->con);
	    	$tables = array();
	    	while ($row = mysql_fetch_row($rs)) {
	        		$tables[] = $row[0];
	    	}
	    	mysql_free_result($rs);
	    	return $tables;
	}

	/**
	 * 获取表里的字段名
	 * return array()
	 */
	private function get_column_list($table){
		$rs = mysql_query("DESC $table",$this->con);
	    	$columns = array();
	    	while ($row = mysql_fetch_row($rs)) {
	        		$columns[] = $row[0];
	    	}
	    	//var_dump($columns);die;
	    	mysql_free_result($rs);
	    	return $columns;
	}	

}
?>