<?php
/**
 * 根据数据库自己检测/产生表名和字段名
 */
class Model{
	private $con;		//数据库连接的句柄
	private $table;	//当前数据库表的名称，初始化时指定
	//private $_newColumn=true;  //是否是新一行
	private $_attributes=array();	 //一次性给多个属性赋值时用到
	public $columns=array(); //数据库中所有列对应的成员变量名

	/**
	 * 通过静态函数构造一个对象
	 * 参数 : 表名
	 * 以此可以用 Model::get('tab')->findAll();
	 */
	public static function get($tab=''){
		return new Model($tab);
	}

	/**
	 * 构造函数
	 * 初始化数据库和成员变量-对应数据库中的列
	 * 初始化时传入要使用的表 $table
	 */
	public function __construct($table=''){
		$mysql = AppConfig::$db;
		$con = mysql_connect($mysql['host'],$mysql['username'],$mysql['password']);
		if(!$con){
			throw new Exception('Could not connect: '.mysql_error(), 500);
		}
		mysql_select_db($mysql['dbname'],$con);
		$this->con = $con;
		//表名可以构造的时候设置，也可以以后再设置 setTable
		if($table != ''){	
			$this->setTable($table);			
		}
	}

	/**
	 * 设置要查询的表名
	 */
	public function setTable($table){
		$this->table=$table;
		$mysql = AppConfig::$db;
		/* 获取表名的列表 */
		$tables = $this->getTableList($mysql['dbname']);
		if(in_array($table, $tables)){
			/* 获取表里的字段名并存到全局变量里 */
			$result = $this->getColumnList($table);
			foreach ($result as $key => $value) { 	
				$this->_attributes["$value"] = NULL;		
				array_push($this->columns, $value);
			}
		}else{
			throw new Exception("Error : There is not exist a table named ".$table, 500);
		}
	}

	/**
	 * 赋值 -- 魔术方法
	 * 当给成员变量赋值时掉用此方法
	 * 如果传入的value是数组,说明一次性给多个属性赋值,其键对应类成员变量名的值会赋值给成员变量
	 * 否则是给单个成员变量赋值,直接赋值
	 * 若属性不存在，则新建属性并赋值
	 */
	public function __set($attribute,$value){
		if($attribute == 'attributes'){
			if(is_array($value)){
				foreach ($value as $key => $val) {
					if(in_array($key, $this->columns)){
						$this->_attributes["$key"] = $val;
					}
				}
			}
		}else{
			$this->_attributes["$attribute"] = $value;
		}
	}

	/**
	 * 取值 -- 魔术方法
	 * 获取成员变量
	 */
	public function __get($attribute){
		if(array_key_exists($attribute, $this->_attributes))
			return $this->_attributes["$attribute"];
		else
			throw new Exception("Error : There is not exist a column named ".$attribute, 500);
	}

	/**
	 * 只取一条数据，
	 * 若查询出多条数据，则返回第一条
	 * 若没有数据则返回 NULL
	 */
	public function find($condition=''){
		$result = $this->select($condition." limit 1");
		if(!$result)
			$result[0] = NULL;
		return $result[0];
	}

	/**
	 * 返回所有数据
	 * 若没有数据则返回空数组
	 */
	public function findAll($condition=''){
		$result = $this->select($condition);
		return $result;
	}

	/**
	 * 根据主键查找
	 */
	public function findByPk($id){
		$condition = $this->columns[0].'='.$id;
		return $this->find($condition);
	}

	/** 
	 * 通过自定义的sql语句执行查询
	 * ************** 当前函数比较特殊，不依赖于初始化的成员变量 **********************
	 * ************ 此对象不是model对象,仅仅是一个sql产生的用对象存储的数据 ***********
	 * return array() 对象数组() 
	 */
	public function findAllBySql($sql){
		$result = $this->applyQuery($sql, $this->con);
		$result_array = array();
		while($row = mysql_fetch_object($result)){
			$this_model = clone $row;
			$result_array[] = $this_model;
		}
		return $result_array;
	}
	/**
	 * 通过自定义的sql语句执行查询
	 * return object
	 */
	public function findBySql($sql){
		$sql .= ' limit 1';
		$result = $this->applyQuery($sql, $this->con);
		$row = mysql_fetch_object($result);
		return $row;
	}

	/**
	 * 获取数据总条数
	 */
	public function countAll($condition=''){
		$py_key = $this->columns[0];
		$sql = "select $py_key from $this->table ";
		$sql = $this->joinSql($sql,$condition);

		$result = $this->applyQuery($sql, $this->con);

		return mysql_num_rows($result);
	}

	/**
	 * 把Model中的数据同步到数据库中
	 */
	public function save(){
		$py_key = $this->columns[0];
		if($this->_attributes["$py_key"]!=NULL)
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
		return $this->applyQuery($sql,$this->con);
	}




	/********************************************************** 功能性函数(私有函数，仅供成员函数调用) ***********************************************************/
	/********************************************************** 功能性函数(私有函数，仅供成员函数调用) ***********************************************************/
	/********************************************************** 功能性函数(私有函数，仅供成员函数调用) ***********************************************************/
	/********************************************************** 功能性函数(私有函数，仅供成员函数调用) ***********************************************************/
	/********************************************************** 功能性函数(私有函数，仅供成员函数调用) ***********************************************************/
	/**
	 * 过滤各字段的值，防止注入
	 */
	private function filter(){
		foreach ($this->columns as $value) {
			$tmp = $this->$value;
			$tmp = strip_tags($tmp);
			$tmp = mysql_real_escape_string($tmp);
			$tmp = trim($tmp);
			$this->$value = $tmp;
		}
	}

	/**
	 * 更新数据库中的数据
	 */
	private function update(){
		$this->filter();
		$sql_value = '';
		foreach ($this->columns as $key => $value) {
			if($key == 0) 	//跳过主键.自增
				continue;
			$sql .= $value."='".$this->_attributes["$value"]."',";
		}
		rtrim($sql_value,',');
		$py_key = $this->columns[0];
		$sql = "update $this->table set $sql_value where $py_key=$this->$py_key";
		return $this->applyQuery($sql,$this->con);
	}

	/**
	 * 向数据库中插入数据
	 */
	private function insert(){
		$this->filter();
		$sql_column = '';
		$sql_value = '';
		foreach ($this->columns as $key => $value) {
			if($key == 0) 	//跳过主键.自增
				continue;
			$sql_column .= $value.',';
			$sql_value .= "'".$this->_attributes["$value"]."',";
		}
		$sql_column = rtrim($sql_column,",");
		$sql_value = rtrim($sql_value,",");
		$sql = "insert into $this->table ($sql_column) values($sql_value)";
		$result = $this->applyQuery($sql,$this->con);
		if($result)
			$this->columns[0] = mysql_insert_id();
		return $result;
	}

	/**
	 * 从数据库里取数据
	 * return 一个对象数组
	 */
	private function select($condition){
		$sql = "select * from $this->table ";
		$sql = $this->joinSql($sql,$condition);
		$result = $this->applyQuery($sql, $this->con);

		$result_array = array();
		while($row = mysql_fetch_assoc($result)){
			$this->_attributes = $row;
			$this_model = clone $this;
			$result_array[] = $this_model;
		}
		return $result_array;
	}

	/**
	 * 获取表名的列表
	 * return array()
	 */
	private function getTableList($database){
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
	private function getColumnList($table){
		$rs = mysql_query("DESC $table",$this->con);
		$columns = array();
	    	while ($row = mysql_fetch_row($rs)) {
	        		$columns[] = $row[0];
	    	}
	    	//var_dump($columns);die;
	    	mysql_free_result($rs);
	    	return $columns;
	}	

	/**
	 * 执行sql语句，如果有错误 抛出异常
	 */
	private function applyQuery($sql){
		$result = mysql_query($sql,$this->con);
		if( !mysql_errno())  //mysql_errno() 返回一个错误码，若没有错误则返回0
			return $result;
		else
			throw new Exception('DB Error:'.mysql_errno().' '.mysql_error(), 500);
	}

	/**
	 * 处理condition 并构造sql语句
	 * 连接初始的sql和condition为一条sql语句
	 */
	private function joinSql($sql, $condition){
		if($condition){
			//补充缺省的where,如果需要的话
			$first_word = $sub=strpos($condition, ' ')===false ? $condition : $sub;
			if(strpos($first_word, '=') || strpos($first_word, '>') || strpos($first_word, '<'))
				$condition = 'where '.$condition;
			$sql .= $condition;
		}
		return $sql;
	}

}
?>